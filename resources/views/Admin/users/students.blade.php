@extends('Admin.layouts.admin-master')
@section('title', 'Students Management')
@section('page-title', 'Students')
@section('breadcrumb', 'Students')

@section('content')
    <div class="card" style="margin-bottom:20px;">
        <div class="card-head">
            <div class="card-head-left">
                <div class="card-head-title">All Students</div>
                <div class="card-head-sub">{{ $students->total() }} registered students on the platform</div>
            </div>
            <div class="card-head-right">
                <form method="GET" style="display:flex;gap:8px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email…"
                        style="padding:8px 14px;border:1.5px solid var(--border2);border-radius:var(--radius-md);font-family:'DM Sans',sans-serif;font-size:0.82rem;outline:none;width:220px;">
                    <select name="status"
                        style="padding:8px 12px;border:1.5px solid var(--border2);border-radius:var(--radius-md);font-family:'DM Sans',sans-serif;font-size:0.82rem;outline:none;">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
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
                        <th>Student</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $i => $student)
                        @php
                            $initials = strtoupper(substr($student->firstname ?? 'S', 0, 1) . substr($student->lastname ?? '', 0, 1));
                            $colors = ['ua-1', 'ua-2', 'ua-3', 'ua-4', 'ua-5', 'ua-6', 'ua-7', 'ua-8'];
                            $ava = $colors[$i % 8];
                            $active = $student->account_status == 10;
                        @endphp
                        <tr>
                            <td style="color:var(--muted2);font-size:0.75rem;">{{ $students->firstItem() + $i }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.78rem;flex-shrink:0;"
                                        class="{{ $ava }}">{{ $initials }}</div>
                                    <div>
                                        <div style="font-weight:600;font-size:0.84rem;color:var(--ink);">
                                            {{ $student->firstname }} {{ $student->lastname }}</div>
                                        <div style="font-size:0.7rem;color:var(--muted);">ID: {{ $student->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:0.82rem;color:var(--muted);">{{ $student->email }}</td>
                            <td style="font-size:0.82rem;color:var(--muted);">{{ $student->phonenumber ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $active ? 'badge-active' : 'badge-inactive' }}">
                                    <i class="fas fa-circle"></i> {{ $active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td style="font-size:0.78rem;color:var(--muted);">{{ $student->created_at?->format('d M Y') }}</td>
                            <td class="text-right">
                                <div style="display:flex;gap:6px;justify-content:flex-end;">
                                    <a href="{{ route('admin.students.show', $student->id) }}"
                                        style="padding:5px 10px;border-radius:var(--radius-sm);background:var(--purple-light);color:var(--purple);font-size:0.72rem;font-weight:600;text-decoration:none;"><i
                                            class="fas fa-eye"></i></a>
                                    <form method="POST" action="{{ route('admin.students.toggle', $student->id) }}"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit"
                                            style="padding:5px 10px;border-radius:var(--radius-sm);background:{{ $active ? 'var(--gold-light)' : 'var(--green-light)' }};color:{{ $active ? 'var(--gold)' : 'var(--green)' }};font-size:0.72rem;font-weight:600;border:none;cursor:pointer;">
                                            <i class="fas fa-{{ $active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:32px;color:var(--muted);">No students found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($students->hasPages())
                <div style="padding:16px 24px;border-top:1px solid var(--border);">
                    {{ $students->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection