<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Academic\ClassModel;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function __construct(protected CertificateService $service) {}

    /**
     * List all certificates with filters (status, search, class).
     */
    public function index(Request $request)
    {
        $query = Certificate::with(['student', 'class.level'])
            ->orderByDesc('issued_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('certificate_no', 'like', "%{$search}%")
                  ->orWhere('verification_code', 'like', "%{$search}%")
                  ->orWhereHas('student', fn($s) => $s->where('fullname', 'like', "%{$search}%")
                      ->orWhere('firstname', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $certificates = $query->paginate(20)->withQueryString();
        $classes      = ClassModel::orderBy('name')->get();
        $stats        = [
            'total'   => Certificate::count(),
            'issued'  => Certificate::where('status', 'issued')->count(),
            'revoked' => Certificate::where('status', 'revoked')->count(),
        ];

        return view('Admin.certificates.index', compact('certificates', 'classes', 'stats'));
    }

    /**
     * Revoke a certificate (admin action).
     */
    public function revoke(Request $request, Certificate $certificate)
    {
        $request->validate(['reason' => 'nullable|string|max:1000']);

        $certificate->update([
            'status'         => 'revoked',
            'revoked_reason' => $request->reason ?? 'Revoked by administrator.',
        ]);

        return back()->with('success', "Certificate {$certificate->certificate_no} has been revoked.");
    }

    /**
     * Re-issue a previously revoked certificate.
     */
    public function reissue(Certificate $certificate)
    {
        $certificate->update([
            'status'         => 'issued',
            'revoked_reason' => null,
            'issued_at'      => now(),
        ]);

        return back()->with('success', "Certificate {$certificate->certificate_no} has been re-issued.");
    }

    /**
     * Admin PDF download for any certificate.
     */
    public function download(Certificate $certificate)
    {
        $certificate->loadMissing(['student', 'class.level.section', 'class.academicYear']);

        $student     = $certificate->student;
        $studentName = $student->fullname
            ?? trim(($student->firstname ?? '') . ' ' . ($student->lastname ?? ''));

        $data = [
            'certificate'      => $certificate,
            'studentName'      => $studentName ?: 'Student',
            'className'        => $certificate->class->name ?? 'Class',
            'levelName'        => $certificate->class->level->name ?? null,
            'levelCode'        => $certificate->class->level->code ?? null,
            'sectionName'      => $certificate->class->level->section->name ?? null,
            'academicYearName' => $certificate->class->academicYear->name ?? null,
            'issuedDate'       => $certificate->issued_date,
            'certificateNo'    => $certificate->certificate_no,
            'verificationCode' => $certificate->verification_code,
            'grade'            => $certificate->grade,
            'percentage'       => $certificate->percentage,
            'verifyUrl'        => route('certificates.verify', ['code' => $certificate->verification_code]),
        ];

        $pdf      = Pdf::loadView('Student.certificates.template', $data)->setPaper('a4', 'landscape');
        $fileName = 'Certificate-' . str_replace(['/', '\\', ' '], '-', $certificate->certificate_no) . '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Show a single certificate detail (admin view).
     */
    public function show(Certificate $certificate)
    {
        $certificate->loadMissing(['student', 'class.level.section', 'class.academicYear']);
        return view('Admin.certificates.show', compact('certificate'));
    }
}