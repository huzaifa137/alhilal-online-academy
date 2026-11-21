<?php

namespace App\Support;

use App\Models\Academic\Exam;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

/**
 * Hands each student their own random subset of a quiz's question pool.
 *
 * The drawn question ids are remembered server-side (in the session) from the
 * moment the student opens the quiz until they submit it. That gives us:
 *  - re-opening / refreshing the quiz returns the SAME questions, so a student
 *    cannot re-roll until they get an easier set;
 *  - on submit we know exactly which questions were issued, so a student cannot
 *    pick which questions get graded;
 *  - a new attempt (after submitting) gets a fresh random draw.
 *
 * When the exam has no "questions per student" limit this class is bypassed and
 * all questions are used.
 */
class QuizDraw
{
    /** Extra time allowed on top of the quiz duration before a draw expires. */
    private const GRACE_SECONDS = 300;

    /** Draw lifetime for quizzes that have no time limit. */
    private const UNTIMED_SECONDS = 7200;

    /**
     * The questions this student must answer for the current attempt.
     * Draws (and remembers) a new set when there is no valid one yet.
     */
    public static function questionsFor(Exam $exam, $viewerId): Collection
    {
        $pool = $exam->questions()->get()->keyBy('id');

        if (!$exam->usesRandomSubset($pool->count())) {
            return $pool->values();
        }

        $count = $exam->questionsPerAttempt($pool->count());
        $ids = self::rememberedIds($exam, $viewerId, $pool, $count);

        if ($ids === null) {
            $ids = $pool->keys()->shuffle()->take($count)->values()->all();
            Session::put(self::key($exam, $viewerId), [
                'ids' => $ids,
                'drawn_at' => time(),
            ]);
        }

        $drawn = collect($ids)->map(fn($id) => $pool[$id]);

        // Keep the teacher's order unless they asked for shuffling.
        return $exam->shuffle_questions
            ? $drawn->values()
            : $drawn->sortBy('sort_order')->values();
    }

    /**
     * The questions already issued to this student for the attempt in progress,
     * or null when nothing valid was issued (never opened, expired, or the
     * teacher edited the quiz in between).
     */
    public static function issuedFor(Exam $exam, $viewerId): ?Collection
    {
        $pool = $exam->questions()->get()->keyBy('id');
        $count = $exam->questionsPerAttempt($pool->count());
        $ids = self::rememberedIds($exam, $viewerId, $pool, $count);

        return $ids === null ? null : collect($ids)->map(fn($id) => $pool[$id])->values();
    }

    /** Forget the draw once the attempt is submitted so the next one is fresh. */
    public static function forget(Exam $exam, $viewerId): void
    {
        Session::forget(self::key($exam, $viewerId));
    }

    private static function rememberedIds(Exam $exam, $viewerId, Collection $pool, int $count): ?array
    {
        $saved = Session::get(self::key($exam, $viewerId));

        if (!is_array($saved) || empty($saved['ids'])) {
            return null;
        }

        $ttl = ($exam->duration_minutes ? $exam->duration_minutes * 60 : self::UNTIMED_SECONDS) + self::GRACE_SECONDS;

        $expired = (time() - (int) ($saved['drawn_at'] ?? 0)) > $ttl;
        $changed = count($saved['ids']) !== $count
            || collect($saved['ids'])->contains(fn($id) => !$pool->has($id));

        return ($expired || $changed) ? null : $saved['ids'];
    }

    private static function key(Exam $exam, $viewerId): string
    {
        return "quiz_draw.{$exam->id}.{$viewerId}";
    }
}
