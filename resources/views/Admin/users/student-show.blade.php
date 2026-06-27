@extends('Admin.layouts.admin-master')
@section('title', 'Student Profile')
@section('page-title', 'Student Profile')
@section('breadcrumb', 'Students')

@section('content')
    <div style="display:grid;grid-template-columns:1fr 2fr;gap:20px;">
        {{-- Profile card --}}
        <div class="card" style="align-self:start;">
            <div
                style="background:var(--gradient-dark);padding:32px 24px;text-align:center;position:relative;overflow:hidden;">
                <div
                    style="width:72px;height:72px;border-radius:20px;background:var(--gradient);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:1.6rem;margin:0 auto 14px;border:3px solid rgba(255,255,255,0.2);box-shadow:0 8px 24px rgba(107,70,193,0.4);">
                    {{ strtoupper(substr($student->firstname ?? 'S', 0, 1) . substr($student->lastname ?? '', 0, 1)) }}
                </div>
                <div style="font-size:1.1rem;font-weight:700;color:white;">{{ $student->firstname }}
                    {{ $student->lastname }}</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.5);margin-top:4px;">Student · ID #{{ $student->id }}
                </div>
                <div style="margin-top:10px;">
                    <span class="badge {{ $student->account_status == 10 ? 'badge-active' : 'badge-inactive' }}">
                        {{ $student->account_status == 10 ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div
                        style="display:flex;justify-content:space-between;font-size:0.83rem;padding-bottom:10px;border-bottom:1px solid var(--border);">
                        <span style="color:var(--muted);">Email</span>
                        <span style="color:var(--ink);font-weight:500;">{{ $student->email }}</span>
                    </div>
                    <div
                        style="display:flex;justify-content:space-between;font-size:0.83rem;padding-bottom:10px;border-bottom:1px solid var(--border);">
                        <span style="color:var(--muted);">Phone</span>
                        <span style="color:var(--ink);font-weight:500;">{{ $student->phonenumber ?? '—' }}</span>
                    </div>
                    <div
                        style="display:flex;justify-content:space-between;font-size:0.83rem;padding-bottom:10px;border-bottom:1px solid var(--border);">
                        <span style="color:var(--muted);">Gender</span>
                        <span style="color:var(--ink);font-weight:500;">{{ ucfirst($student->gender ?? '—') }}</span>
                    </div>
                    <div
                        style="display:flex;justify-content:space-between;font-size:0.83rem;padding-bottom:10px;border-bottom:1px solid var(--border);">
                        <span style="color:var(--muted);">Joined</span>
                        <span style="color:var(--ink);font-weight:500;">{{ $student->created_at?->format('d M Y') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:0.83rem;">
                        <span style="color:var(--muted);">Avg Score</span>
                        <span
                            style="color:{{ $avgScore >= 80 ? 'var(--green)' : ($avgScore >= 60 ? 'var(--gold)' : 'var(--red)') }};font-weight:700;">{{ $avgScore ? number_format((float)$avgScore, 1) . '%' : '—' }}</span>
                    </div>
                </div>
                <div style="margin-top:16px;display:grid;grid-template-columns:1fr 1fr;gap:8px;text-align:center;">
                    <div
                        style="padding:12px;background:var(--cream);border-radius:var(--radius-sm);border:1px solid var(--border);">
                        <div
                            style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--purple);">
                            {{ $enrollments->count() }}</div>
                        <div style="font-size:0.68rem;color:var(--muted);">Classes</div>
                    </div>
                    <div
                        style="padding:12px;background:var(--cream);border-radius:var(--radius-sm);border:1px solid var(--border);">
                        <div
                            style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--green);">
                            {{ $certificates->count() }}</div>
                        <div style="font-size:0.68rem;color:var(--muted);">Certificates</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Details --}}
        <div style="display:flex;flex-direction:column;gap:20px;">
            {{-- Enrollments --}}
            <div class="card">
                <div class="card-head">
                    <div class="card-head-left">
                        <div class="card-head-title">Class Enrollments</div>
                        <div class="card-head-sub">{{ $enrollments->count() }} total</div>
                    </div>
                </div>
                <div class="card-body-0">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Enrolled</th>
                                <th>Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enrollments as $e)
                                <tr>
                                    <td style="font-weight:600;font-size:0.84rem;">{{ $e->class?->name ?? 'Unknown' }}</td>
                                    <td style="font-size:0.78rem;color:var(--muted);">
                                        {{ $e->enrollment_date?->format('d M Y') ?? $e->created_at?->format('d M Y') }}</td>
                                    <td><span
                                            class="badge badge-{{ $e->payment_status == 'paid' ? 'active' : 'pending' }}">{{ ucfirst($e->payment_status ?? 'unpaid') }}</span>
                                    </td>
                                    <td><span
                                            class="badge badge-{{ $e->status == 'active' ? 'active' : ($e->status == 'pending' ? 'pending' : 'inactive') }}">{{ ucfirst($e->status) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;padding:20px;color:var(--muted);">No enrollments
                                        yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Exam results --}}
            <div class="card">
                <div class="card-head">
                    <div class="card-head-left">
                        <div class="card-head-title">Exam Results</div>
                        <div class="card-head-sub">Last 10 attempts</div>
                    </div>
                </div>
                <div class="card-body-0">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Exam</th>
                                <th class="text-center">Score</th>
                                <th class="text-center">Percentage</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($examResults as $r)
                                <tr>
                                    <td style="font-size:0.83rem;">{{ $r->exam?->title ?? 'Exam #' . $r->exam_id }}</td>
                                    <td class="text-center" style="font-family:'DM Mono',monospace;font-size:0.82rem;">
                                        {{ $r->score }}/{{ $r->total_score }}</td>
                                    <td class="text-center">
                                        <span
                                            style="font-weight:700;color:{{ $r->percentage >= 80 ? 'var(--green)' : ($r->percentage >= 60 ? 'var(--gold)' : 'var(--red)') }};">{{ number_format($r->percentage, 1) }}%</span>
                                    </td>
                                    <td style="font-size:0.78rem;color:var(--muted);">{{ $r->created_at?->format('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center;padding:20px;color:var(--muted);">No exam results
                                        yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-top:16px;">
        <a href="{{ route('admin.students') }}"
            style="display:inline-flex;align-items:center;gap:6px;padding:10px 18px;border-radius:var(--radius-md);background:var(--cream);border:1.5px solid var(--border2);color:var(--ink);font-size:0.82rem;font-weight:600;text-decoration:none;">
            <i class="fas fa-arrow-left"></i> Back to Students
        </a>
    </div>
@endsection