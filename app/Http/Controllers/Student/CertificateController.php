<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Academic\ClassModel;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    protected CertificateService $certificates;

    public function __construct(CertificateService $certificates)
    {
        $this->certificates = $certificates;
    }

    /**
     * List all certificates this student has earned (issued only).
     */
    public function index()
    {
        $studentId = session('LoggedStudent');

        $issuedCertificates = Certificate::with(['class.level'])
            ->where('student_id', $studentId)
            ->where('status', 'issued')
            ->orderByDesc('issued_at')
            ->get();

        return view('Student.certificates.index', compact('issuedCertificates'));
    }

    /**
     * JSON eligibility check for a class — used by the lesson list page
     * to decide whether the "Download Certificate" button is enabled.
     */
    public function checkEligibility(ClassModel $class)
    {
        $studentId = session('LoggedStudent');

        $eligibility = $this->certificates->evaluateClassEligibility($studentId, $class->id);

        return response()->json([
            'success'                    => true,
            'eligible'                   => $eligibility['eligible'],
            'reason'                     => $eligibility['reason'],
            'total_lessons'              => $eligibility['total_lessons'],
            'completed_lessons'          => $eligibility['completed_lessons'],
            'total_quizzes'              => $eligibility['total_quizzes'],
            'passed_quizzes'             => $eligibility['passed_quizzes'],
            'lesson_progress_percentage' => $eligibility['lesson_progress_percentage'],
        ]);
    }

    /**
     * Render an HTML preview of the certificate in-browser (no download).
     */
    public function preview(ClassModel $class)
    {
        $studentId = session('LoggedStudent');

        $certificate = $this->certificates->findOrIssue($studentId, $class->id);

        if (!$certificate) {
            return redirect()
                ->route('student.lessons.lists')
                ->with('fail', 'You have not yet completed all requirements for this class certificate.');
        }

        if ($certificate->isRevoked()) {
            abort(403, 'This certificate has been revoked.');
        }

        $data = $this->buildCertificateData($certificate);

        return view('Student.certificates.template', $data);
    }

    /**
     * Generate the certificate PDF on the fly and stream it for download.
     */
    public function download(ClassModel $class)
    {
        $studentId = session('LoggedStudent');

        $certificate = $this->certificates->findOrIssue($studentId, $class->id);

        if (!$certificate) {
            return redirect()
                ->route('student.lessons.lists')
                ->with('fail', 'You have not yet completed all requirements for this class certificate.');
        }

        if ($certificate->isRevoked()) {
            abort(403, 'This certificate has been revoked.');
        }

        $data = $this->buildCertificateData($certificate);

        $pdf = Pdf::loadView('Student.certificates.template', $data)
            ->setPaper('a4', 'landscape');

        $fileName = 'Certificate-' . str_replace(['/', '\\', ' '], '-', $certificate->certificate_no) . '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Public verification page — anyone with the verification code (no
     * login required) can confirm a certificate is genuine.
     */
    public function verify(Request $request)
    {
        $code        = $request->query('code');
        $certificate = null;

        if ($code) {
            $certificate = Certificate::with(['student', 'class.level'])
                ->where('verification_code', $code)
                ->first();
        }

        return view('Student.certificates.verify', [
            'code'        => $code,
            'certificate' => $certificate,
        ]);
    }

    // ── Private helpers ────────────────────────────────────────────────────────

    private function buildCertificateData(Certificate $certificate): array
    {
        $certificate->loadMissing(['student', 'class.level.section', 'class.academicYear']);

        $student     = $certificate->student;
        $studentName = $student->fullname
            ?? trim(($student->firstname ?? '') . ' ' . ($student->lastname ?? ''));

        return [
            'certificate'      => $certificate,
            'studentName'      => $studentName ?: 'Student',
            'className'        => $certificate->class->name ?? 'Class',
            'levelName'        => $certificate->class->level->name ?? null,
            'sectionName'      => $certificate->class->level->section->name ?? null,
            'academicYearName' => $certificate->class->academicYear->name ?? null,
            'issuedDate'       => $certificate->issued_date,
            'certificateNo'    => $certificate->certificate_no,
            'verificationCode' => $certificate->verification_code,
            'grade'            => $certificate->grade,
            'percentage'       => $certificate->percentage,
            'verifyUrl'        => route('certificates.verify', ['code' => $certificate->verification_code]),
        ];
    }
}