<?php

namespace App\Console\Commands;

use App\Models\Academic\Exam;
use App\Models\Academic\Lesson;
use App\Models\Academic\StudentProgress;
use App\Models\Academic\SubjectMaterial;
use App\Support\ContentLanguage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Admin escape hatch for labelling content with its teaching language.
 *
 * The teacher UI refuses to change the language of a lesson that students
 * have already started (it would move their progress to another language
 * track). Use this command when content that existed before the language
 * feature was really taught in a different language, e.g.
 *
 *   php artisan content:set-language sw --class=3 --subject=7 --dry-run
 *   php artisan content:set-language ar --lessons=12,13,14
 *   php artisan content:set-language lg --materials=5 --exams=9
 *   php artisan content:set-language en --all
 *
 * Quizzes attached to a lesson always follow their lesson automatically.
 */
class SetContentLanguage extends Command
{
    protected $signature = 'content:set-language
                            {language : Language code (en, ar, sw, lg ...)}
                            {--class= : Every lesson / PDF / class quiz of this class id}
                            {--subject= : ...limited to this subject id (can be combined with --class)}
                            {--lessons= : Comma separated lesson ids}
                            {--materials= : Comma separated study-material ids}
                            {--exams= : Comma separated class-quiz ids (quizzes attached to a lesson follow the lesson)}
                            {--all : Everything (lessons, PDFs and class quizzes)}
                            {--dry-run : Show what would change without saving}';

    protected $description = 'Set the teaching language of existing lessons, study materials and quizzes';

    public function handle(): int
    {
        $language = (string) $this->argument('language');

        if (!ContentLanguage::isValid($language)) {
            $this->error("Unknown language \"{$language}\". Use one of: " . implode(', ', ContentLanguage::codes()));

            return self::FAILURE;
        }

        $all         = (bool) $this->option('all');
        $classId     = $this->option('class') ? (int) $this->option('class') : null;
        $subjectId   = $this->option('subject') ? (int) $this->option('subject') : null;
        $lessonIds   = $this->ids('lessons');
        $materialIds = $this->ids('materials');
        $examIds     = $this->ids('exams');
        $scoped      = $classId || $subjectId;

        if (!$all && !$scoped && !$lessonIds && !$materialIds && !$examIds) {
            $this->error('Nothing selected. Pass --class, --subject, --lessons, --materials, --exams or --all.');

            return self::FAILURE;
        }

        // ── Lessons ────────────────────────────────────────────────────
        $lessonQuery = Lesson::query();
        $touchLessons = $all || $scoped || $lessonIds;

        if ($touchLessons && !$all) {
            $lessonQuery->where(function ($q) use ($classId, $subjectId, $lessonIds, $scoped) {
                if ($scoped) {
                    $q->orWhereHas('topic', function ($t) use ($classId, $subjectId) {
                        $classId && $t->where('class_id', $classId);
                        $subjectId && $t->where('subject_id', $subjectId);
                    });
                }
                if ($lessonIds) {
                    $q->orWhereIn('id', $lessonIds);
                }
            });
        }

        $lessonTargetIds = $touchLessons ? $lessonQuery->pluck('id')->all() : [];

        // ── Study materials ────────────────────────────────────────────
        $materialQuery = SubjectMaterial::query();
        $touchMaterials = $all || $scoped || $materialIds;

        if ($touchMaterials && !$all) {
            $materialQuery->where(function ($q) use ($classId, $subjectId, $materialIds, $scoped) {
                if ($scoped) {
                    $q->orWhere(function ($m) use ($classId, $subjectId) {
                        $classId && $m->where('class_id', $classId);
                        $subjectId && $m->where('subject_id', $subjectId);
                    });
                }
                if ($materialIds) {
                    $q->orWhereIn('id', $materialIds);
                }
            });
        }

        $materialTargetIds = $touchMaterials ? $materialQuery->pluck('id')->all() : [];

        // ── Standalone (class) quizzes ─────────────────────────────────
        $examQuery = Exam::query()->whereNull('lesson_id');
        $touchExams = $all || $scoped || $examIds;

        if ($touchExams && !$all) {
            $examQuery->where(function ($q) use ($classId, $subjectId, $examIds, $scoped) {
                if ($scoped) {
                    $q->orWhere(function ($e) use ($classId, $subjectId) {
                        $classId && $e->where('class_id', $classId);
                        $subjectId && $e->where('subject_id', $subjectId);
                    });
                }
                if ($examIds) {
                    $q->orWhereIn('id', $examIds);
                }
            });
        }

        $examTargetIds = $touchExams ? $examQuery->pluck('id')->all() : [];

        $lessonQuizCount = $lessonTargetIds
            ? Exam::whereIn('lesson_id', $lessonTargetIds)->count()
            : 0;

        $withProgress = $lessonTargetIds
            ? StudentProgress::whereIn('lesson_id', $lessonTargetIds)->distinct()->count('lesson_id')
            : 0;

        $label = ContentLanguage::name($language) . " ({$language})";
        $this->info("Setting teaching language to {$label}");
        $this->table(['What', 'Count'], [
            ['Lessons', count($lessonTargetIds)],
            ['  …of which already started by students', $withProgress],
            ['Quizzes attached to those lessons', $lessonQuizCount],
            ['Study materials (PDF)', count($materialTargetIds)],
            ['Class quizzes', count($examTargetIds)],
        ]);

        if ($withProgress > 0) {
            $this->warn("{$withProgress} lesson(s) already have student progress. That progress moves to the {$label} track with the lesson.");
        }

        if ($this->option('dry-run')) {
            $this->comment('Dry run – nothing was saved.');

            return self::SUCCESS;
        }

        if (!$lessonTargetIds && !$materialTargetIds && !$examTargetIds) {
            $this->comment('Nothing matched.');

            return self::SUCCESS;
        }

        DB::transaction(function () use ($language, $lessonTargetIds, $materialTargetIds, $examTargetIds) {
            if ($lessonTargetIds) {
                Lesson::whereIn('id', $lessonTargetIds)->update(['language' => $language]);
                Exam::whereIn('lesson_id', $lessonTargetIds)->update(['language' => $language]);
            }
            if ($materialTargetIds) {
                SubjectMaterial::whereIn('id', $materialTargetIds)->update(['language' => $language]);
            }
            if ($examTargetIds) {
                Exam::whereIn('id', $examTargetIds)->update(['language' => $language]);
            }
        });

        $this->info('Done.');

        return self::SUCCESS;
    }

    /** "1, 2,3" => [1, 2, 3] */
    private function ids(string $option): array
    {
        $raw = (string) $this->option($option);

        return array_values(array_filter(array_map('intval', preg_split('/\s*,\s*/', trim($raw), -1, PREG_SPLIT_NO_EMPTY) ?: [])));
    }
}
