@extends('Admin.layouts.admin-master')
@section('title', 'Reports')
@section('page-title', 'Reports')
@section('breadcrumb', 'Reports')

@section('content')
    {{-- Summary KPIs --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:16px;margin-bottom:24px;">
        <div class="card" style="padding:20px;">
            <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:6px;">Total Students</div>
            <div style="font-size:1.8rem;font-weight:800;color:var(--ink);">{{ $totalStudents }}</div>
        </div>
        <div class="card" style="padding:20px;">
            <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:6px;">Total Teachers</div>
            <div style="font-size:1.8rem;font-weight:800;color:var(--purple);">{{ $totalTeachers }}</div>
        </div>
        <div class="card" style="padding:20px;">
            <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:6px;">Active Enrollments</div>
            <div style="font-size:1.8rem;font-weight:800;color:#10b981;">{{ $activeEnrollments }}</div>
        </div>
        <div class="card" style="padding:20px;">
            <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:6px;">Total Revenue</div>
            <div style="font-size:1.5rem;font-weight:800;color:#f59e0b;">UGX {{ number_format($totalRevenue) }}</div>
        </div>
        <div class="card" style="padding:20px;">
            <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:6px;">Avg Exam Score</div>
            <div style="font-size:1.8rem;font-weight:800;color:var(--ink);">{{ $avgScore ? round($avgScore, 1) : '—' }}%</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;">
        {{-- Enrollment Chart --}}
        <div class="card" style="padding:24px;">
            <div style="font-size:0.9rem;font-weight:700;color:var(--ink);margin-bottom:16px;">Enrollments — Last 6 Months</div>
            @php $maxE = max(array_column($enrollmentChart, 'count') ?: [1]); @endphp
            <div style="display:flex;align-items:flex-end;gap:10px;height:140px;">
                @foreach($enrollmentChart as $row)
                    @php $h = $maxE > 0 ? round(($row['count']/$maxE)*120) : 0; @endphp
                    <div style="display:flex;flex-direction:column;align-items:center;flex:1;gap:4px;">
                        <div style="font-size:0.68rem;color:var(--muted);font-weight:600;">{{ $row['count'] }}</div>
                        <div style="width:100%;border-radius:6px 6px 0 0;background:var(--gradient);height:{{ max($h,4) }}px;"></div>
                        <div style="font-size:0.65rem;color:var(--muted);text-align:center;">{{ $row['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Revenue Chart --}}
        <div class="card" style="padding:24px;">
            <div style="font-size:0.9rem;font-weight:700;color:var(--ink);margin-bottom:16px;">Revenue — Last 6 Months (UGX)</div>
            @php $maxR = max(array_column($revenueByMonth, 'amount') ?: [1]); @endphp
            <div style="display:flex;align-items:flex-end;gap:10px;height:140px;">
                @foreach($revenueByMonth as $row)
                    @php $h = $maxR > 0 ? round(($row['amount']/$maxR)*120) : 0; @endphp
                    <div style="display:flex;flex-direction:column;align-items:center;flex:1;gap:4px;">
                        <div style="font-size:0.65rem;color:var(--muted);font-weight:600;">{{ $row['amount'] > 0 ? number_format($row['amount']/1000).'k' : '0' }}</div>
                        <div style="width:100%;border-radius:6px 6px 0 0;background:linear-gradient(180deg,#f59e0b,#d97706);height:{{ max($h,4) }}px;"></div>
                        <div style="font-size:0.65rem;color:var(--muted);text-align:center;">{{ $row['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Top Classes --}}
    <div class="card">
        <div class="card-head">
            <div class="card-head-left">
                <div class="card-head-title">Top Performing Classes</div>
                <div class="card-head-sub">By active enrollment count</div>
            </div>
        </div>
        <div class="card-body-0">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Class</th>
                        <th class="text-center">Students Enrolled</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topClasses as $i => $class)
                        <tr>
                            <td>
                                <span style="width:26px;height:26px;border-radius:8px;background:var(--gradient);color:white;font-size:0.76rem;font-weight:800;display:inline-flex;align-items:center;justify-content:center;">{{ $i+1 }}</span>
                            </td>
                            <td style="font-weight:600;color:var(--ink);">{{ $class->class_name ?? $class->name }}</td>
                            <td class="text-center">
                                <div style="display:flex;align-items:center;gap:10px;justify-content:center;">
                                    @php $pct = $topClasses->max('student_count') > 0 ? round(($class->student_count/$topClasses->max('student_count'))*100) : 0; @endphp
                                    <div style="width:100px;height:6px;background:var(--border2);border-radius:3px;overflow:hidden;">
                                        <div style="width:{{ $pct }}%;height:100%;background:var(--gradient);border-radius:3px;"></div>
                                    </div>
                                    <span style="font-weight:700;color:var(--purple);">{{ $class->student_count }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" style="text-align:center;padding:32px;color:var(--muted);">No class data available.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
