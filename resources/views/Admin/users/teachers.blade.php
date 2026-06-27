@extends('Admin.layouts.admin-master')
@section('title', 'Teachers Management')
@section('page-title', 'Teachers')
@section('breadcrumb', 'Teachers')

@section('content')
    <div class="card">
        <div class="card-head">
            <div class="card-head-left">
                <div class="card-head-title">All Teachers</div>
                <div class="card-head-sub">{{ $teachers->total() }} educators on the platform</div>
            </div>
            <div class="card-head-right">
                <form method="GET" style="display:flex;gap:8px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email…"
                        style="padding:8px 14px;border:1.5px solid var(--border2);border-radius:var(--radius-md);font-family:'DM Sans',sans-serif;font-size:0.82rem;outline:none;width:220px;">
                    <button type="submit"
                        style="padding:8px 16px;background:var(--gradient);color:white;border:none;border-radius:var(--radius-md);cursor:pointer;font-family:'DM Sans',sans-serif;font-size:0.82rem;font-weight:600;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body-0">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Teacher</th>
                        <th>Email</th>
                        <th class="text-center">Lessons</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $i => $teacher)
                        @php
                            $initials = strtoupper(substr($teacher->firstname ?? 'T', 0, 1) . substr($teacher->lastname ?? '', 0, 1));
                            $colors = ['ua-1', 'ua-2', 'ua-3', 'ua-4', 'ua-5', 'ua-6', 'ua-7', 'ua-8'];
                            $ava = $colors[$i % 8];
                            $active = $teacher->account_status == 10;
                        @endphp
                        <tr>
                            <td style="color:var(--muted2);font-size:0.75rem;">{{ $teachers->firstItem() + $i }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.78rem;flex-shrink:0;"
                                        class="{{ $ava }}">{{ $initials }}</div>
                                    <div>
                                        <div style="font-weight:600;font-size:0.84rem;color:var(--ink);">
                                            {{ $teacher->firstname }} {{ $teacher->lastname }}</div>
                                        <div style="font-size:0.7rem;color:var(--muted);">ID: {{ $teacher->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:0.82rem;color:var(--muted);">{{ $teacher->email }}</td>
                            <td class="text-center">
                                <span style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--purple);">{{ $teacher->lesson_count }}</span>
                            </td>
                            <td><span class="badge {{ $active ? 'badge-active' : 'badge-inactive' }}"><i
                                        class="fas fa-circle"></i> {{ $active ? 'Active' : 'Inactive' }}</span></td>
                            <td style="font-size:0.78rem;color:var(--muted);">{{ $teacher->created_at?->format('d M Y') }}</td>
                            <td class="text-right">
                                <div style="display:flex;gap:6px;justify-content:flex-end;">
                                    <a href="{{ route('admin.teachers.show', $teacher->id) }}"
                                        style="padding:5px 10px;border-radius:var(--radius-sm);background:var(--purple-light);color:var(--purple);font-size:0.72rem;font-weight:600;text-decoration:none;"><i
                                            class="fas fa-eye"></i></a>
                                    <form method="POST" action="{{ route('admin.teachers.toggle', $teacher->id) }}"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit"
                                            style="padding:5px 10px;border-radius:var(--radius-sm);background:{{ $active ? '#fee2e2' : '#d1fae5' }};color:{{ $active ? '#991b1b' : '#065f46' }};font-size:0.72rem;font-weight:600;border:none;cursor:pointer;">
                                            <i class="fas fa-{{ $active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:32px;color:var(--muted);">No teachers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($teachers->hasPages())
                <div style="padding:16px 24px;border-top:1px solid var(--border);">
                    {{ $teachers->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection