{{-- resources/views/Teacher/enrollments/partials/students-table.blade.php --}}

@if($enrollments->count() > 0)
<div class="e-table-wrap">
    <table class="e-table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Reg Number</th>
                <th>Email</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Amount Paid</th>
                <th>Enrolled Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $enrollment)
                <tr>
                    <td data-label="Student">
                        {{ $enrollment->student->firstname ?? 'N/A' }} {{ $enrollment->student->lastname ?? '' }}
                    </td>
                    <td data-label="Reg Number">
                        {{ $enrollment->student->reg_number ?? 'N/A' }}
                    </td>
                    <td data-label="Email">
                        {{ $enrollment->student->email ?? 'N/A' }}
                    </td>
                    <td data-label="Status">
                        @php
                            $statusClass = match($enrollment->status) {
                                'active' => 'e-badge-active',
                                'completed' => 'e-badge-completed',
                                'suspended' => 'e-badge-suspended',
                                'expelled' => 'e-badge-expelled',
                                default => 'e-badge-active'
                            };
                        @endphp
                        <span class="e-badge {{ $statusClass }}">
                            <span class="dot"></span>{{ $enrollment->status }}
                        </span>
                    </td>
                    <td data-label="Payment">
                        @php
                            $paymentClass = match($enrollment->payment_status) {
                                'paid' => 'e-badge-paid',
                                'partial' => 'e-badge-partial',
                                'pending' => 'e-badge-pending',
                                default => 'e-badge-pending'
                            };
                        @endphp
                        <span class="e-badge {{ $paymentClass }}">
                            <span class="dot"></span>{{ $enrollment->payment_status }}
                        </span>
                    </td>
                    <td data-label="Amount Paid">
                        UGX {{ number_format($enrollment->amount_paid ?? 0) }}
                    </td>
                    <td data-label="Enrolled Date">
                        {{ \Carbon\Carbon::parse($enrollment->enrollment_date)->format('M d, Y') }}
                    </td>
                    <td data-label="Actions">
                        <div class="e-actions">
                            <button class="e-icon-btn" onclick="openEditEnrollModal({{ $enrollment->id }}, '{{ $enrollment->status }}', '{{ $enrollment->payment_status }}', {{ $enrollment->amount_paid ?? 0 }})" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="e-icon-btn del" onclick="removeEnrollment({{ $enrollment->id }})" title="Remove">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="e-empty">
    <div class="e-empty-ring"><i class="fas fa-users"></i></div>
    <p>No students enrolled in any class yet.</p>
    <button class="btn-primary" onclick="openEnrollModal()" style="margin-top: 16px;">
        <i class="fas fa-plus"></i> Enroll First Student
    </button>
</div>
@endif