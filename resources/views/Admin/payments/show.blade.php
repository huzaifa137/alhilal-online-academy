@extends('Admin.layouts.admin-master')
@section('title', 'Payment Detail')
@section('page-title', 'Payment Detail')
@section('breadcrumb', 'Payments / Detail')

@section('content')
    <div style="max-width:720px;">
        <a href="{{ route('admin.payments') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:0.82rem;color:var(--purple);font-weight:600;text-decoration:none;margin-bottom:20px;">
            <i class="fas fa-arrow-left"></i> Back to Payments
        </a>

        <div class="card" style="padding:28px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
                <div>
                    <div style="font-size:1.2rem;font-weight:800;color:var(--ink);">Transaction Receipt</div>
                    <div style="font-size:0.78rem;font-family:'DM Mono',monospace;color:var(--purple);margin-top:4px;">{{ $payment->reference ?? 'N/A' }}</div>
                </div>
                @php
                    $statusColors = [
                        'completed'  => ['bg'=>'#d1fae5','color'=>'#065f46'],
                        'pending'    => ['bg'=>'#fef3c7','color'=>'#92400e'],
                        'processing' => ['bg'=>'#dbeafe','color'=>'#1e40af'],
                        'failed'     => ['bg'=>'#fee2e2','color'=>'#991b1b'],
                    ];
                    $sc = $statusColors[$payment->status] ?? ['bg'=>'var(--surface2)','color'=>'var(--muted)'];
                @endphp
                <span style="padding:6px 16px;border-radius:20px;font-size:0.8rem;font-weight:700;background:{{ $sc['bg'] }};color:{{ $sc['color'] }};">
                    {{ ucfirst($payment->status) }}
                </span>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                <div>
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:4px;">Student</div>
                    <div style="font-size:0.92rem;font-weight:700;color:var(--ink);">{{ $payment->student->firstname ?? '—' }} {{ $payment->student->lastname ?? '' }}</div>
                    <div style="font-size:0.78rem;color:var(--muted);">{{ $payment->student->email ?? '' }}</div>
                    <div style="font-size:0.78rem;color:var(--muted);">{{ $payment->student->phonenumber ?? '' }}</div>
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:4px;">Amount</div>
                    <div style="font-size:1.6rem;font-weight:800;color:var(--purple);">UGX {{ number_format($payment->amount) }}</div>
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:4px;">Payment Method</div>
                    <div style="font-size:0.88rem;color:var(--ink);">{{ ucfirst($payment->payment_method ?? 'Mobile Money') }}</div>
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:4px;">Date & Time</div>
                    <div style="font-size:0.88rem;color:var(--ink);">{{ $payment->created_at?->format('d M Y, H:i:s') }}</div>
                </div>
                @if($payment->payable_type)
                <div>
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:4px;">For</div>
                    <div style="font-size:0.88rem;color:var(--ink);">{{ class_basename($payment->payable_type) }} #{{ $payment->payable_id }}</div>
                </div>
                @endif
                @if($payment->phone_number)
                <div>
                    <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:4px;">Phone Number</div>
                    <div style="font-size:0.88rem;color:var(--ink);">{{ $payment->phone_number }}</div>
                </div>
                @endif
            </div>

            @if($payment->metadata)
            <div style="margin-top:20px;padding-top:20px;border-top:1px solid var(--border2);">
                <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:8px;">Metadata</div>
                <pre style="font-size:0.72rem;font-family:'DM Mono',monospace;color:var(--muted);background:var(--surface2);padding:12px;border-radius:var(--radius-md);overflow-x:auto;">{{ json_encode($payment->metadata, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif
        </div>
    </div>
@endsection
