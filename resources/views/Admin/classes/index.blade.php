@extends('Admin.layouts.admin-master')
@section('title', 'Classes')
@section('page-title', 'Classes')
@section('breadcrumb', 'Classes')

@section('content')
    <div class="card">
        <div class="card-head">
            <div class="card-head-left">
                <div class="card-head-title">All Classes</div>
                <div class="card-head-sub">{{ $classes->total() }} classes on the platform</div>
            </div>
            <div class="card-head-right">
                <form method="GET" style="display:flex;gap:8px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search class or code…"
                        style="padding:8px 14px;border:1.5px solid var(--border2);border-radius:var(--radius-md);font-family:'DM Sans',sans-serif;font-size:0.82rem;outline:none;width:200px;">
                    <select name="status"
                        style="padding:8px 12px;border:1.5px solid var(--border2);border-radius:var(--radius-md);font-family:'DM Sans',sans-serif;font-size:0.82rem;outline:none;">
                        <option value="">All Status</option>
                        <option value="active"   {{ request('status')=='active'   ?'selected':'' }}>Active</option>
                        <option value="inactive" {{ request('status')=='inactive' ?'selected':'' }}>Inactive</option>
                        <option value="archived" {{ request('status')=='archived' ?'selected':'' }}>Archived</option>
                    </select>
                    <button type="submit"
                        style="padding:8px 16px;background:var(--gradient);color:white;border:none;border-radius:var(--radius-md);cursor:pointer;font-size:0.82rem;font-weight:600;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div style="margin:16px 20px;padding:10px 16px;background:#d1fae5;border-radius:var(--radius-md);color:#065f46;font-size:0.82rem;font-weight:600;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card-body-0">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Class</th>
                        <th>Level</th>
                        <th>Academic Year</th>
                        <th>Class Teacher</th>
                        <th class="text-center">Students</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $i => $class)
                        <tr>
                            <td style="color:var(--muted2);font-size:0.75rem;">{{ $classes->firstItem() + $i }}</td>
                            <td>
                                <div style="font-weight:700;font-size:0.86rem;color:var(--ink);">{{ $class->name }}</div>
                                @if($class->code)
                                    <div style="font-size:0.7rem;color:var(--purple);font-family:'DM Mono',monospace;">{{ $class->code }}</div>
                                @endif
                            </td>
                            <td style="font-size:0.82rem;color:var(--muted);">{{ $class->level->level_name ?? '—' }}</td>
                            <td style="font-size:0.82rem;color:var(--muted);">{{ $class->academicYear->year ?? '—' }}</td>
                            <td style="font-size:0.82rem;color:var(--ink);">
                                {{ $class->classTeacher->firstname ?? '—' }} {{ $class->classTeacher->lastname ?? '' }}
                            </td>
                            <td class="text-center">
                                <span style="font-weight:700;color:var(--purple);">{{ $class->student_count }}</span>
                                @if($class->capacity)
                                    <span style="color:var(--muted);font-size:0.72rem;">/{{ $class->capacity }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $class->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                    <i class="fas fa-circle"></i> {{ ucfirst($class->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--muted);font-size:0.84rem;">No classes found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;">{{ $classes->withQueryString()->links() }}</div>
    </div>
@endsection
