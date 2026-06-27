@extends('Admin.layouts.admin-master')
@section('title', 'Payments')
@section('page-title', 'Payments')
@section('breadcrumb', 'Payments')

@section('content')
    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:24px;">
        <div class="card" style="padding:20px;">
            <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:6px;">Total Revenue</div>
            <div style="font-size:1.8rem;font-weight:800;color:var(--purple);">UGX {{ number_format($totalRevenue) }}</div>
        </div>
        <div class="card" style="padding:20px;">
            <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:6px;">Pending Payments</div>
            <div style="font-size:1.8rem;font-weight:800;color:#f59e0b;">{{ $pendingPayments }}</div>
            <div style="font-size:0.72rem;color:var(--muted);">UGX {{ number_format($pendingAmount) }}</div>
        </div>
        <div class="card" style="padding:20px;">
            <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:6px;">Failed Amount</div>
            <div style="font-size:1.8rem;font-weight:800;color:#ef4444;">UGX {{ number_format($failedAmount) }}</div>
        </div>
        <div class="card" style="padding:20px;">
            <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:6px;">All Transactions</div>
            <div style="font-size:1.8rem;font-weight:800;color:var(--ink);">{{ $payments->total() }}</div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <div class="card-head-left">
                <div class="card-head-title">Payment Transactions</div>
                <div class="card-head-sub">All platform payment records</div>
            </div>
            <div class="card-head-right">
                <form method="GET" style="display:flex;gap:8px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Reference or student…"
                        style="padding:8px 14px;border:1.5px solid var(--border2);border-radius:var(--radius-md);font-family:'DM Sans',sans-serif;font-size:0.82rem;outline:none;width:210px;">
                    <select name="status"
                        style="padding:8px 12px;border:1.5px solid var(--border2);border-radius:var(--radius-md);font-family:'DM Sans',sans-serif;font-size:0.82rem;outline:none;">
                        <option value="">All Status</option>
                        <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                        <option value="pending"   {{ request('status')=='pending'  ?'selected':'' }}>Pending</option>
                        <option value="processing"{{ request('status')=='processing'?'selected':'' }}>Processing</option>
                        <option value="failed"    {{ request('status')=='failed'   ?'selected':'' }}>Failed</option>
                    </select>
                    <button type="submit"
                        style="padding:8px 16px;background:var(--gradient);color:white;border:none;border-radius:var(--radius-md);cursor:pointer;font-size:0.82rem;font-weight:600;">
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
                        <th>Reference</th>
                        <th>Student</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $i => $p)
                        @php
                            $statusColors = [
                                'completed'  => ['bg'=>'#d1fae5','color'=>'#065f46'],
                                'pending'    => ['bg'=>'#fef3c7','color'=>'#92400e'],
                                'processing' => ['bg'=>'#dbeafe','color'=>'#1e40af'],
                                'failed'     => ['bg'=>'#fee2e2','color'=>'#991b1b'],
                            ];
                            $sc = $statusColors[$p->status] ?? ['bg'=>'var(--surface2)','color'=>'var(--muted)'];
                        @endphp
                        <tr>
                            <td style="color:var(--muted2);font-size:0.75rem;">{{ $payments->firstItem() + $i }}</td>
                            <td style="font-size:0.78rem;font-family:'DM Mono',monospace;color:var(--purple);">{{ $p->reference ?? '—' }}</td>
                            <td>
                                <div style="font-weight:600;font-size:0.84rem;color:var(--ink);">{{ $p->student->firstname ?? '—' }} {{ $p->student->lastname ?? '' }}</div>
                                <div style="font-size:0.7rem;color:var(--muted);">{{ $p->student->email ?? '' }}</div>
                            </td>
                            <td style="font-weight:700;color:var(--ink);font-size:0.86rem;">UGX {{ number_format($p->amount) }}</td>
                            <td style="font-size:0.8rem;color:var(--muted);">{{ ucfirst($p->payment_method ?? 'mobile money') }}</td>
                            <td>
                                <span style="padding:3px 10px;border-radius:20px;font-size:0.72rem;font-weight:700;background:{{ $sc['bg'] }};color:{{ $sc['color'] }};">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td style="font-size:0.78rem;color:var(--muted);">{{ $p->created_at?->format('d M Y, H:i') }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.payments.show', $p->id) }}"
                                    style="padding:5px 10px;border-radius:var(--radius-sm);background:var(--purple-light);color:var(--purple);font-size:0.72rem;font-weight:600;text-decoration:none;">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" style="text-align:center;padding:40px;color:var(--muted);font-size:0.84rem;">No payments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;">{{ $payments->withQueryString()->links() }}</div>
    </div>
@endsection
