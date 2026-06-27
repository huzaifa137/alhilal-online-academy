@extends('Admin.layouts.admin-master')
@section('title', 'Enrollments')
@section('page-title', 'Enrollments')
@section('breadcrumb', 'Enrollments')

@section('content')
    {{-- Stats row --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:24px;">
        <div class="card" style="padding:20px;">
            <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:6px;">Total Enrollments</div>
            <div style="font-size:1.8rem;font-weight:800;color:var(--ink);">{{ $enrollments->total() }}</div>
        </div>
        <div class="card" style="padding:20px;">
            <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:6px;">Pending Approval</div>
            <div style="font-size:1.8rem;font-weight:800;color:#f59e0b;">{{ $pending }}</div>
        </div>
        <div class="card" style="padding:20px;">
            <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:6px;">Active Classes</div>
            <div style="font-size:1.8rem;font-weight:800;color:var(--purple);">{{ $classes->count() }}</div>
        </div>
    </div>

    {{-- Main table card --}}
    <div class="card">
        <div class="card-head">
            <div class="card-head-left">
                <div class="card-head-title">All Enrollments</div>
                <div class="card-head-sub">Manage student class enrollments</div>
            </div>
            <div class="card-head-right">
                <form method="GET" style="display:flex;gap:8px;align-items:center;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search student…"
                        style="padding:8px 14px;border:1.5px solid var(--border2);border-radius:var(--radius-md);font-family:'DM Sans',sans-serif;font-size:0.82rem;outline:none;width:200px;">
                    <select name="status"
                        style="padding:8px 12px;border:1.5px solid var(--border2);border-radius:var(--radius-md);font-family:'DM Sans',sans-serif;font-size:0.82rem;outline:none;">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <button type="submit"
                        style="padding:8px 16px;background:var(--gradient);color:white;border:none;border-radius:var(--radius-md);cursor:pointer;font-size:0.82rem;font-weight:600;">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Manual enroll form --}}
        <div style="padding:16px 20px;border-bottom:1px solid var(--border2);background:var(--surface2);">
            <form method="POST" action="{{ route('admin.enrollments.store') }}" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                @csrf
                <span style="font-size:0.78rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.05em;">Quick Enroll:</span>
                <select name="student_id" required
                    style="padding:7px 12px;border:1.5px solid var(--border2);border-radius:var(--radius-md);font-size:0.82rem;outline:none;min-width:200px;">
                    <option value="">Select Student…</option>
                    @foreach(\App\Models\User::where('user_role',1)->orderBy('firstname')->get() as $s)
                        <option value="{{ $s->id }}">{{ $s->firstname }} {{ $s->lastname }}</option>
                    @endforeach
                </select>
                <select name="class_id" required
                    style="padding:7px 12px;border:1.5px solid var(--border2);border-radius:var(--radius-md);font-size:0.82rem;outline:none;min-width:180px;">
                    <option value="">Select Class…</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}">{{ $c->class_name ?? $c->name }}</option>
                    @endforeach
                </select>
                <button type="submit"
                    style="padding:7px 18px;background:var(--gradient);color:white;border:none;border-radius:var(--radius-md);cursor:pointer;font-size:0.82rem;font-weight:600;">
                    <i class="fas fa-plus"></i> Enroll
                </button>
            </form>
        </div>

        @if(session('success'))
            <div style="margin:16px 20px;padding:10px 16px;background:#d1fae5;border-radius:var(--radius-md);color:#065f46;font-size:0.82rem;font-weight:600;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="margin:16px 20px;padding:10px 16px;background:#fee2e2;border-radius:var(--radius-md);color:#991b1b;font-size:0.82rem;font-weight:600;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="card-body-0">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Enrolled</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $i => $e)
                        @php
                            $colors = ['ua-1','ua-2','ua-3','ua-4','ua-5','ua-6','ua-7','ua-8'];
                            $initials = strtoupper(substr($e->student->firstname ?? 'S',0,1).substr($e->student->lastname ?? '',0,1));
                            $ava = $colors[$i % 8];
                            $statusMap = ['pending'=>'badge-warning','active'=>'badge-active','rejected'=>'badge-inactive'];
                            $sc = $statusMap[$e->status] ?? 'badge-inactive';
                        @endphp
                        <tr>
                            <td style="color:var(--muted2);font-size:0.75rem;">{{ $enrollments->firstItem() + $i }}</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div style="width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.76rem;flex-shrink:0;" class="{{ $ava }}">{{ $initials }}</div>
                                    <div>
                                        <div style="font-weight:600;font-size:0.84rem;color:var(--ink);">{{ $e->student->firstname ?? '—' }} {{ $e->student->lastname ?? '' }}</div>
                                        <div style="font-size:0.7rem;color:var(--muted);">{{ $e->student->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:0.82rem;color:var(--ink);font-weight:600;">{{ $e->class->class_name ?? $e->class->name ?? '—' }}</td>
                            <td style="font-size:0.78rem;color:var(--muted);">{{ $e->created_at?->format('d M Y') }}</td>
                            <td><span class="badge {{ $sc }}"><i class="fas fa-circle"></i> {{ ucfirst($e->status) }}</span></td>
                            <td>
                                <span class="badge {{ $e->payment_status == 'paid' ? 'badge-active' : 'badge-warning' }}">
                                    {{ ucfirst($e->payment_status ?? 'unpaid') }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div style="display:flex;gap:6px;justify-content:flex-end;">
                                    @if($e->status === 'pending')
                                        <form method="POST" action="{{ route('admin.enrollments.approve', $e->id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" title="Approve"
                                                style="padding:5px 10px;border-radius:var(--radius-sm);background:#d1fae5;color:#065f46;font-size:0.72rem;font-weight:600;border:none;cursor:pointer;">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.enrollments.reject', $e->id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" title="Reject"
                                                style="padding:5px 10px;border-radius:var(--radius-sm);background:#fee2e2;color:#991b1b;font-size:0.72rem;font-weight:600;border:none;cursor:pointer;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.enrollments.destroy', $e->id) }}" style="display:inline;"
                                        onsubmit="return confirm('Remove this enrollment?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Remove"
                                            style="padding:5px 10px;border-radius:var(--radius-sm);background:var(--surface2);color:var(--muted);font-size:0.72rem;border:none;cursor:pointer;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--muted);font-size:0.84rem;">No enrollments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;">{{ $enrollments->withQueryString()->links() }}</div>
    </div>
@endsection
