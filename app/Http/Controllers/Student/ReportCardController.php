<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Academic\ClassEnrollment;
use App\Models\Academic\ClassModel;
use App\Services\ReportCardService;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportCardController extends Controller
{
    protected ReportCardService $reportCards;

    public function __construct(ReportCardService $reportCards)
    {
        $this->reportCards = $reportCards;
    }

    /**
     * List every active class this student is enrolled in, each with a
     * quick live snapshot of their current standing, and a link to view
     * or download the full report card for that class.
     */
    public function index()
    {
        $studentId = session('LoggedStudent');

        $enrollments = ClassEnrollment::with(['class.level', 'class.academicYear'])
            ->where('student_id', $studentId)
            ->where('status', 'active')
            ->get();

        $snapshots = [];

        foreach ($enrollments as $enrollment) {
            if (!$enrollment->class) {
                continue;
            }

            $data = $this->reportCards->build($studentId, $enrollment->class_id);

            if ($data) {
                $snapshots[] = $data;
            }
        }

        return view('Student.report-card.index', compact('snapshots'));
    }

    /**
     * Live JSON snapshot for a single class — used by the lesson list page
     * to show a quick current-grade preview before the student opens the
     * full report card.
     */
    public function summary(ClassModel $class)
    {
        $studentId = session('LoggedStudent');

        $data = $this->reportCards->build($studentId, $class->id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'You are not enrolled in this class.',
            ], 404);
        }

        return response()->json([
            'success'                    => true,
            'overall_percentage'         => $data['overallPercentage'],
            'overall_grade'              => $data['overallGrade'],
            'total_marks_obtained'       => $data['totalMarksObtained'],
            'total_full_marks'           => $data['totalFullMarks'],
            'lesson_progress_percentage' => $data['lessonProgressPercentage'],
            'total_lessons'              => $data['totalLessons'],
            'total_lessons_completed'    => $data['totalLessonsCompleted'],
            'total_quizzes'              => $data['totalQuizzes'],
            'total_quizzes_taken'        => $data['totalQuizzesTaken'],
            'rank_position'              => $data['rankPosition'],
            'rank_out_of'                => $data['rankOutOf'],
        ]);
    }

    /**
     * Render an HTML preview of the report card in-browser (no download).
     */
    public function preview(ClassModel $class)
    {
        $studentId = session('LoggedStudent');

        $data = $this->reportCards->build($studentId, $class->id);

        if (!$data) {
            return redirect()
                ->route('student.lessons.lists')
                ->with('fail', 'Report card is not available for this class yet.');
        }

        return view('Student.report-card.template', $data);
    }

    /**
     * Generate the report card PDF on the fly and stream it for download.
     */
    public function download(ClassModel $class)
    {
        $studentId = session('LoggedStudent');

        $data = $this->reportCards->build($studentId, $class->id);

        if (!$data) {
            return redirect()
                ->route('student.lessons.lists')
                ->with('fail', 'Report card is not available for this class yet.');
        }

        $pdf = Pdf::loadView('Student.report-card.template', $data)
            ->setPaper('a4', 'portrait');

        $fileName = 'ReportCard-' . str_replace(['/', '\\', ' '], '-', $data['reportNo']) . '.pdf';

        return $pdf->download($fileName);
    }
}
