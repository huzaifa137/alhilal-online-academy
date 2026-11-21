<?php

namespace App\Support;

use App\Models\Academic\Exam;
use Illuminate\Support\Facades\Session;

/**
 * Server-side stopwatch for timed quizzes.
 *
 * The countdown on the student's screen is driven by the number of seconds the
 * server says are left, so closing and re-opening the quiz (or refreshing the
 * page) can't restart the clock, and a submission that arrives long after the
 * deadline is refused. The clock starts when the student opens the quiz and
 * stops when they submit it.
 *
 * Quizzes without a duration have no clock at all.
 */
class QuizClock
{
    /** Seconds allowed past the deadline (network lag, auto-submit at 00:00). */
    public const GRACE_SECONDS = 60;

    /**
     * Start the clock for this attempt, or resume the one already running.
     *
     * @return array{remaining: ?int, fresh: bool}  remaining is null for untimed quizzes
     */
    public static function start(Exam $exam, $viewerId): array
    {
        if (!$exam->duration_minutes) {
            return ['remaining' => null, 'fresh' => false];
        }

        $key = self::key($exam, $viewerId);
        $startedAt = (int) Session::get($key, 0);
        $limit = $exam->duration_minutes * 60;

        // No clock yet, or the previous attempt ran out and was abandoned.
        if (!$startedAt || (time() - $startedAt) > $limit + self::GRACE_SECONDS) {
            $startedAt = time();
            Session::put($key, $startedAt);
            return ['remaining' => $limit, 'fresh' => true];
        }

        return ['remaining' => max(0, $limit - (time() - $startedAt)), 'fresh' => false];
    }

    /** True when the attempt was submitted too long after its deadline. */
    public static function isOverdue(Exam $exam, $viewerId): bool
    {
        if (!$exam->duration_minutes) {
            return false;
        }

        $startedAt = (int) Session::get(self::key($exam, $viewerId), 0);

        // Nothing recorded (e.g. session restarted): don't punish the student.
        if (!$startedAt) {
            return false;
        }

        return (time() - $startedAt) > ($exam->duration_minutes * 60 + self::GRACE_SECONDS);
    }

    public static function forget(Exam $exam, $viewerId): void
    {
        Session::forget(self::key($exam, $viewerId));
    }

    private static function key(Exam $exam, $viewerId): string
    {
        return "quiz_clock.{$exam->id}.{$viewerId}";
    }
}
