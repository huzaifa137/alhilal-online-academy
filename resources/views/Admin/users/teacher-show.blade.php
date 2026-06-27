@extends('Admin.layouts.admin-master')
@section('title', 'Teacher Profile')
@section('page-title', 'Teacher Profile')
@section('breadcrumb', 'Teachers / Profile')

@section('content')
    <a href="{{ route('admin.teachers') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:0.82rem;color:var(--purple);font-weight:600;text-decoration:none;margin-bottom:20px;">
        <i class="fas fa-arrow-left"></i> Back to Teachers
    </a>

    @php
        $initials = strtoupper(substr($teacher->firstname ?? 'T',0,1).substr($teacher->lastname ?? '',0,1));
        $active = $teacher->account_status == 10;
    @endphp

    <div style="display:grid;grid-template-columns:280px 1fr;gap:20px;align-items:start;">
        {{-- Profile card --}}
        <div class="card" style="padding:28px;text-align:center;">
            <div style="width:72px;height:72px;border-radius:18px;background:var(--gradient);color:white;font-size:1.4rem;font-weight:800;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">{{ $initials }}</div>
            <div style="font-size:1.1rem;font-weight:800;color:var(--ink);">{{ $teacher->firstname }} {{ $teacher->lastname }}</div>
            <div style="font-size:0.78rem;color:var(--muted);margin-top:2px;">{{ $teacher->email }}</div>
            @if($teacher->phonenumber)
                <div style="font-size:0.78rem;color:var(--muted);">{{ $teacher->phonenumber }}</div>
            @endif
            <div style="margin:14px 0;">
                <span class="badge {{ $active ? 'badge-active' : 'badge-inactive' }}"><i class="fas fa-circle"></i> {{ $active ? 'Active' : 'Inactive' }}</span>
            </div>
            <div style="font-size:0.72rem;color:var(--muted);">Joined {{ $teacher->created_at?->format('d M Y') }}</div>

            <div style="border-top:1px solid var(--border2);margin-top:20px;padding-top:16px;display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <div style="font-size:1.4rem;font-weight:800;color:var(--purple);">{{ $lessons->count() }}</div>
                    <div style="font-size:0.68rem;color:var(--muted);font-weight:600;text-transform:uppercase;">Lessons</div>
                </div>
                <div>
                    <div style="font-size:1.4rem;font-weight:800;color:var(--purple);">{{ $avgScore ? round($avgScore,1).'%' : '—' }}</div>
                    <div style="font-size:0.68rem;color:var(--muted);font-weight:600;text-transform:uppercase;">Avg Score</div>
                </div>
            </div>

            <div style="margin-top:16px;display:flex;flex-direction:column;gap:8px;">
                <form method="POST" action="{{ route('admin.teachers.toggle', $teacher->id) }}">
                    @csrf
                    <button type="submit"
                        style="width:100%;padding:9px;border-radius:var(--radius-md);background:{{ $active ? '#fee2e2' : '#d1fae5' }};color:{{ $active ? '#991b1b' : '#065f46' }};border:none;cursor:pointer;font-size:0.8rem;font-weight:700;">
                        <i class="fas {{ $active ? 'fa-user-times' : 'fa-user-check' }}"></i>
                        {{ $active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Lessons --}}
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Lessons Created</div>
                    <div class="card-head-sub">{{ $lessons->count() }} total lessons</div>
                </div>
            </div>
            <div class="card-body-0">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Lesson</th>
                            <th>Subject / Topic</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lessons as $i => $lesson)
                            <tr>
                                <td style="color:var(--muted2);font-size:0.75rem;">{{ $i + 1 }}</td>
                                <td style="font-weight:600;font-size:0.84rem;color:var(--ink);">{{ $lesson->title }}</td>
                                <td style="font-size:0.78rem;color:var(--muted);">
                                    {{ $lesson->topic->subject->subject_name ?? '—' }}
                                    @if($lesson->topic)
                                        <span style="color:var(--border2);">/</span> {{ $lesson->topic->topic_name }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $lesson->status === 'published' ? 'badge-active' : 'badge-inactive' }}">
                                        <i class="fas fa-circle"></i> {{ ucfirst($lesson->status) }}
                                    </span>
                                </td>
                                <td style="font-size:0.78rem;color:var(--muted);">{{ $lesson->created_at?->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--muted);">No lessons yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
