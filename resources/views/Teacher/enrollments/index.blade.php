@extends('Teacher.layouts.teacher-master')

@section('title', 'Student Enrollment')
@section('page-title', 'Student Enrollment')
@section('breadcrumb', 'Enrollment')

@section('content')

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --c-bg: #F0EEF8;
            --c-surface: #FFFFFF;
            --c-surface2: #F7F6FB;
            --c-border: #E3E0F0;
            --c-ink: #1A1628;
            --c-muted: #7C748E;
            --c-accent: #5B3FD9;
            --c-accent-lt: #EAE6FF;
            --c-indigo: #4F46E5;
            --c-pink: #D946A8;
            --c-emerald: #059669;
            --c-amber: #D97706;
            --c-red: #DC2626;
            --c-red-lt: #FEE2E2;
            --c-green-lt: #D1FAE5;
            --c-blue: #3B82F6;
            --c-blue-lt: #DBEAFE;
            --c-gold: #D97706;
            --c-gold-lt: #FEF3C7;
            --radius-lg: 18px;
            --radius-xl: 24px;
            --radius-pill: 999px;
            --shadow-sm: 0 1px 3px rgba(91, 63, 217, .07), 0 1px 2px rgba(0, 0, 0, .04);
            --shadow-md: 0 4px 16px rgba(91, 63, 217, .10), 0 2px 6px rgba(0, 0, 0, .05);
            --shadow-lg: 0 12px 40px rgba(91, 63, 217, .14), 0 4px 12px rgba(0, 0, 0, .06);
            --gradient: linear-gradient(135deg, #5B3FD9 0%, #8B5CF6 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--c-bg);
            font-family: 'DM Sans', sans-serif;
        }

        .e-wrap {
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            color: var(--c-ink);
        }

        /* Page Header */
        .e-page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .e-page-eyebrow {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--c-accent);
            margin-bottom: 6px;
        }

        .e-page-title {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--c-ink);
            line-height: 1.15;
            margin: 0;
        }

        .e-page-title em {
            font-style: italic;
            color: var(--c-accent);
        }

        .e-page-subtitle {
            margin-top: 6px;
            font-size: .83rem;
            color: var(--c-muted);
            font-weight: 400;
        }

        /* Stats Grid */
        .e-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .e-stat-card {
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-lg);
            padding: 20px;
            transition: all .22s ease;
            cursor: default;
        }

        .e-stat-card:hover {
            transform: translateY(-2px);
            border-color: var(--c-accent);
            box-shadow: var(--shadow-md);
        }

        .e-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 16px;
        }

        .e-stat-number {
            font-family: 'DM Serif Display', serif;
            font-size: 1.8rem;
            font-weight: 400;
            color: var(--c-ink);
            line-height: 1.1;
        }

        .e-stat-label {
            font-size: .73rem;
            font-weight: 600;
            color: var(--c-muted);
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        /* Main Card */
        .e-card {
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .e-card-head {
            padding: 22px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            border-bottom: 1.5px solid var(--c-border);
            background: var(--c-surface2);
        }

        .e-card-label {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .e-card-icon {
            width: 34px;
            height: 34px;
            background: var(--c-accent-lt);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--c-accent);
            font-size: .9rem;
            flex-shrink: 0;
        }

        .e-card-title {
            font-family: 'DM Serif Display', serif;
            font-size: 1.15rem;
            font-weight: 400;
            color: var(--c-ink);
            margin: 0;
        }

        .e-card-sub {
            font-size: .76rem;
            color: var(--c-muted);
            margin-top: 1px;
        }

        /* Buttons */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--c-accent);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem;
            font-weight: 600;
            padding: 9px 20px;
            border-radius: var(--radius-pill);
            border: none;
            cursor: pointer;
            transition: background .2s, box-shadow .2s, transform .15s;
            letter-spacing: .02em;
        }

        .btn-primary:hover {
            background: #4930C2;
            box-shadow: 0 6px 20px rgba(91, 63, 217, .32);
            transform: translateY(-1px);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: var(--radius-pill);
            border: 1.5px solid var(--c-border);
            background: var(--c-surface);
            color: var(--c-muted);
            font-family: 'DM Sans', sans-serif;
            font-size: .72rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, border-color .15s;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: var(--c-surface2);
            border-color: var(--c-muted);
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: var(--radius-pill);
            border: 1.5px solid var(--c-border);
            background: var(--c-surface);
            color: var(--c-red);
            font-family: 'DM Sans', sans-serif;
            font-size: .72rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-danger:hover {
            background: var(--c-red-lt);
            border-color: var(--c-red);
        }

        /* Class Selector */
        .e-class-selector {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .e-class-btn {
            padding: 8px 20px;
            border-radius: var(--radius-pill);
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            cursor: pointer;
            transition: all .2s ease;
            font-family: 'DM Sans', sans-serif;
            font-size: .8rem;
            font-weight: 500;
            color: var(--c-ink);
        }

        .e-class-btn.active {
            background: var(--c-accent);
            color: white;
            border-color: var(--c-accent);
        }

        .e-class-btn:hover:not(.active) {
            border-color: var(--c-accent);
            color: var(--c-accent);
        }

        /* Table */
        .e-table-wrap {
            overflow-x: auto;
        }

        .e-table {
            width: 100%;
            border-collapse: collapse;
        }

        .e-table thead th {
            text-align: left;
            padding: 13px 20px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: var(--c-muted);
            background: var(--c-surface2);
            border-bottom: 1.5px solid var(--c-border);
            white-space: nowrap;
        }

        .e-table tbody td {
            padding: 14px 20px;
            font-size: .84rem;
            color: var(--c-ink);
            border-bottom: 1px solid var(--c-border);
            vertical-align: middle;
        }

        .e-table tbody tr:last-child td {
            border-bottom: none;
        }

        .e-table tbody tr {
            transition: background .15s;
        }

        .e-table tbody tr:hover {
            background: var(--c-surface2);
        }

        /* Badges */
        .e-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 11px;
            border-radius: var(--radius-pill);
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .03em;
            text-transform: capitalize;
        }

        .e-badge .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .e-badge-active {
            background: var(--c-green-lt);
            color: var(--c-emerald);
        }

        .e-badge-active .dot {
            background: var(--c-emerald);
        }

        .e-badge-completed {
            background: var(--c-blue-lt);
            color: var(--c-blue);
        }

        .e-badge-completed .dot {
            background: var(--c-blue);
        }

        .e-badge-suspended {
            background: var(--c-gold-lt);
            color: var(--c-gold);
        }

        .e-badge-suspended .dot {
            background: var(--c-gold);
        }

        .e-badge-expelled {
            background: var(--c-red-lt);
            color: var(--c-red);
        }

        .e-badge-expelled .dot {
            background: var(--c-red);
        }

        .e-badge-paid {
            background: var(--c-green-lt);
            color: var(--c-emerald);
        }

        .e-badge-paid .dot {
            background: var(--c-emerald);
        }

        .e-badge-partial {
            background: var(--c-gold-lt);
            color: var(--c-gold);
        }

        .e-badge-partial .dot {
            background: var(--c-gold);
        }

        .e-badge-pending {
            background: var(--c-red-lt);
            color: var(--c-red);
        }

        .e-badge-pending .dot {
            background: var(--c-red);
        }

        /* Action Buttons */
        .e-actions {
            display: flex;
            gap: 6px;
        }

        .e-icon-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1.5px solid var(--c-border);
            background: var(--c-surface);
            color: var(--c-muted);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            transition: all .18s;
        }

        .e-icon-btn:hover {
            border-color: var(--c-accent);
            color: var(--c-accent);
            background: var(--c-accent-lt);
        }

        .e-icon-btn.del:hover {
            border-color: var(--c-red);
            color: var(--c-red);
            background: var(--c-red-lt);
        }

        /* Empty State */
        .e-empty {
            text-align: center;
            padding: 72px 40px;
        }

        .e-empty-ring {
            width: 72px;
            height: 72px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: var(--c-surface2);
            border: 2px dashed var(--c-border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: var(--c-muted);
        }

        /* Modal */
        .e-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(26, 22, 40, .48);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .e-modal-overlay.active {
            display: flex;
        }

        .e-modal {
            background: var(--c-surface);
            border-radius: var(--radius-xl);
            width: min(520px, 92vw);
            max-height: 88vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            animation: modalIn .26s cubic-bezier(.34, 1.56, .64, 1);
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(24px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .e-modal-head {
            padding: 22px 24px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1.5px solid var(--c-border);
        }

        .e-modal-head-title {
            font-family: 'DM Serif Display', serif;
            font-size: 1.1rem;
            font-weight: 400;
            color: var(--c-ink);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .e-modal-head-icon {
            width: 30px;
            height: 30px;
            background: var(--c-accent-lt);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--c-accent);
            font-size: .82rem;
        }

        .e-modal-close {
            width: 30px;
            height: 30px;
            border: none;
            background: var(--c-surface2);
            border-radius: 8px;
            cursor: pointer;
            color: var(--c-muted);
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s, color .15s;
        }

        .e-modal-close:hover {
            background: var(--c-red-lt);
            color: var(--c-red);
        }

        .e-modal-body {
            padding: 24px;
        }

        .e-modal-foot {
            padding: 16px 24px;
            border-top: 1.5px solid var(--c-border);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        /* Form Fields */
        .fg {
            margin-bottom: 20px;
        }

        .fg label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: var(--c-ink);
            margin-bottom: 7px;
            letter-spacing: .01em;
        }

        .fg label span {
            color: var(--c-accent);
        }

        .fg input,
        .fg select,
        .fg textarea {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid var(--c-border);
            border-radius: 11px;
            font-family: 'DM Sans', sans-serif;
            font-size: .84rem;
            color: var(--c-ink);
            background: var(--c-surface);
            transition: border-color .18s, box-shadow .18s;
            box-sizing: border-box;
        }

        .fg input:focus,
        .fg select:focus,
        .fg textarea:focus {
            outline: none;
            border-color: var(--c-accent);
            box-shadow: 0 0 0 3px rgba(91, 63, 217, .13);
        }

        .fg-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Button Cancel */
        .btn-cancel {
            display: inline-flex;
            align-items: center;
            padding: 9px 20px;
            border-radius: var(--radius-pill);
            border: 1.5px solid var(--c-border);
            background: #DC2626;
            color: #FFF;
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, border-color .15s;
        }

        .btn-cancel:hover {
            background: var(--c-surface2);
            border-color: var(--c-muted);
        }

        /* Card Body */
        .e-card-body {
            padding: 24px;
        }

        /* Responsive */
        @media (max-width: 1000px) {
            .e-stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
        }

        @media (max-width: 768px) {
            .e-stats-grid {
                grid-template-columns: 1fr;
            }

            .e-page-title {
                font-size: 1.5rem;
            }

            .e-card-head {
                padding: 16px 20px;
            }

            .e-card-body {
                padding: 16px;
            }

            .fg-row {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .e-table thead {
                display: none;
            }

            .e-table tbody tr {
                display: block;
                border: 1.5px solid var(--c-border);
                border-radius: var(--radius-lg);
                margin-bottom: 12px;
                padding: 8px 0;
            }

            .e-table tbody td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 10px 16px;
                border-bottom: 1px solid var(--c-border);
            }

            .e-table tbody td:last-child {
                border-bottom: none;
            }

            .e-table tbody td::before {
                content: attr(data-label);
                font-size: .7rem;
                font-weight: 700;
                color: var(--c-muted);
                min-width: 100px;
            }
        }
    </style>

    <div class="e-wrap">

        {{-- Page Header --}}
        <div class="e-page-header">
            <div>
                <div class="e-page-eyebrow"><i class="fas fa-users"></i> Class Management</div>
                <h1 class="e-page-title">Student <em>Enrollment</em></h1>
                <div class="e-page-subtitle">Manage student enrollments in your classes</div>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="e-stats-grid">
            <div class="e-stat-card">
                <div class="e-stat-icon" style="background: var(--c-accent-lt); color: var(--c-accent);">
                    <i class="fas fa-chalkboard"></i>
                </div>
                <div class="e-stat-number">{{ $classes->count() }}</div>
                <div class="e-stat-label">Your Classes</div>
            </div>
            <div class="e-stat-card">
                <div class="e-stat-icon" style="background: var(--c-green-lt); color: var(--c-emerald);">
                    <i class="fas fa-users"></i>
                </div>
                <div class="e-stat-number">{{ $enrollments->count() }}</div>
                <div class="e-stat-label">Total Enrollments</div>
            </div>
            <div class="e-stat-card">
                <div class="e-stat-icon" style="background: var(--c-gold-lt); color: var(--c-gold);">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="e-stat-number">{{ $students->count() }}</div>
                <div class="e-stat-label">Available Students</div>
            </div>
            <div class="e-stat-card">
                <div class="e-stat-icon" style="background: var(--c-blue-lt); color: var(--c-blue);">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="e-stat-number">{{ $enrollments->where('payment_status', 'paid')->count() }}</div>
                <div class="e-stat-label">Paid Enrollments</div>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="e-card">
            <div class="e-card-head">
                <div class="e-card-label">
                    <div class="e-card-icon"><i class="fas fa-user-plus"></i></div>
                    <div>
                        <div class="e-card-title">Student Enrollment</div>
                        <div class="e-card-sub">Manage student enrollments in your classes</div>
                    </div>
                </div>
                <button class="btn-primary" onclick="openEnrollModal()">
                    <i class="fas fa-plus-circle"></i> Enroll Student
                </button>
            </div>

            <div class="e-card-body">
                {{-- Class Selector --}}
                <div class="e-class-selector">
                    <button class="e-class-btn active" data-class="all" onclick="filterByClass('all')">All Classes</button>
                    @foreach($classes as $class)
                        <button class="e-class-btn" data-class="{{ $class->id }}" onclick="filterByClass({{ $class->id }})">
                            {{ $class->name }}
                        </button>
                    @endforeach
                </div>

                {{-- Students Table --}}
                <div class="e-table-wrap" id="studentsTableContainer">
                    @include('Teacher.enrollments.partials.students-table', ['enrollments' => $enrollments])
                </div>
            </div>
        </div>
    </div>

    {{-- Enroll Modal --}}
    <div id="enrollModal" class="e-modal-overlay">
        <div class="e-modal">
            <div class="e-modal-head">
                <div class="e-modal-head-title">
                    <div class="e-modal-head-icon"><i class="fas fa-user-plus"></i></div>
                    <span>Enroll New Student</span>
                </div>
                <button class="e-modal-close" onclick="closeEnrollModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="e-modal-body">
                <form id="enrollForm">
                    @csrf
                    <div class="fg">
                        <label>Select Class <span>*</span></label>
                        <select name="class_id" id="enroll_class_id" required>
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->level->name ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fg">
                        <label>Select Student <span>*</span></label>
                        <select name="student_id" id="enroll_student_id" required>
                            <option value="">-- Select Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->firstname }} {{ $student->lastname }}
                                    ({{ $student->reg_number }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fg">
                        <label>Payment Status <span>*</span></label>
                        <select name="payment_status" id="enroll_payment_status" required>
                            <option value="pending">Pending</option>
                            <option value="partial">Partial</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>

                    <div class="fg">
                        <label>Amount Paid (UGX)</label>
                        <input type="number" name="amount_paid" id="enroll_amount_paid" placeholder="0" min="0" step="1000">
                    </div>
                </form>
            </div>
            <div class="e-modal-foot">
                <button class="btn-cancel btn-danger" onclick="closeEnrollModal()">
                    <i class="fa fa-times"></i> &nbsp; Cancel
                </button>

                <button class="btn-primary" onclick="submitEnrollment()">
                    <i class="fa fa-plus"></i> Enroll Student
                </button>
            </div>
        </div>
    </div>

    {{-- Edit Enrollment Modal --}}
    <div id="editEnrollModal" class="e-modal-overlay">
        <div class="e-modal">
            <div class="e-modal-head">
                <div class="e-modal-head-title">
                    <div class="e-modal-head-icon"><i class="fas fa-edit"></i></div>
                    <span>Edit Enrollment</span>
                </div>
                <button class="e-modal-close" onclick="closeEditEnrollModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="e-modal-body">
                <form id="editEnrollForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_enrollment_id">

                    <div class="fg">
                        <label>Status <span>*</span></label>
                        <select name="status" id="edit_status" required>
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                            <option value="suspended">Suspended</option>
                            <option value="expelled">Expelled</option>
                        </select>
                    </div>

                    <div class="fg">
                        <label>Payment Status <span>*</span></label>
                        <select name="payment_status" id="edit_payment_status" required>
                            <option value="pending">Pending</option>
                            <option value="partial">Partial</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>

                    <div class="fg">
                        <label>Amount Paid (UGX)</label>
                        <input type="number" name="amount_paid" id="edit_amount_paid" placeholder="0" min="0" step="1000">
                    </div>
                </form>
            </div>
            <div class="e-modal-foot">
                <button class="btn-cancel" onclick="closeEditEnrollModal()">
                    <i class="fa fa-times"></i> &nbsp; Cancel
                </button>

                <button class="btn-primary" onclick="updateEnrollment()">
                    <i class="fa fa-pen"></i> Update
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentFilterClass = 'all';

        function filterByClass(classId) {
            currentFilterClass = classId;

            // Update active button state
            document.querySelectorAll('.e-class-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-class') == classId || (classId === 'all' && btn.getAttribute('data-class') === 'all')) {
                    btn.classList.add('active');
                }
            });

            // Fetch filtered data
            if (classId === 'all') {
                location.reload();
            } else {
                fetch(`/teacher/enrollments/class/${classId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateTable(data.students);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }

        function updateTable(enrollments) {
            const container = document.getElementById('studentsTableContainer');
            if (!container) return;

            if (enrollments.length === 0) {
                container.innerHTML = `
                        <div class="e-empty">
                            <div class="e-empty-ring"><i class="fas fa-users"></i></div>
                            <p>No students enrolled in this class yet.</p>
                            <button class="btn-primary" onclick="openEnrollModal()" style="margin-top: 16px;">
                                <i class="fas fa-plus"></i> Enroll First Student
                            </button>
                        </div>
                    `;
                return;
            }

            let html = `<div class="e-table-wrap"><table class="e-table"><thead><tr>`;
            html += `<th>Student</th><th>Reg Number</th><th>Email</th><th>Status</th><th>Payment</th><th>Amount Paid</th><th>Enrolled Date</th><th>Actions</th>`;
            html += `</tr></thead><tbody>`;

            enrollments.forEach(enrollment => {
                const statusClass = getStatusClass(enrollment.status);
                const paymentClass = getPaymentClass(enrollment.payment_status);

                html += `<tr>`;
                html += `<td data-label="Student">${enrollment.student?.firstname || 'N/A'} ${enrollment.student?.lastname || ''}</td>`;
                html += `<td data-label="Reg Number">${enrollment.student?.reg_number || 'N/A'}</td>`;
                html += `<td data-label="Email">${enrollment.student?.email || 'N/A'}</td>`;
                html += `<td data-label="Status"><span class="e-badge ${statusClass}"><span class="dot"></span>${enrollment.status}</span></td>`;
                html += `<td data-label="Payment"><span class="e-badge ${paymentClass}"><span class="dot"></span>${enrollment.payment_status}</span></td>`;
                html += `<td data-label="Amount Paid">UGX ${(enrollment.amount_paid || 0).toLocaleString()}</td>`;
                html += `<td data-label="Enrolled Date">${new Date(enrollment.enrollment_date).toLocaleDateString()}</td>`;
                html += `<td data-label="Actions"><div class="e-actions">`;
                html += `<button class="e-icon-btn" onclick="openEditEnrollModal(${enrollment.id}, '${enrollment.status}', '${enrollment.payment_status}', ${enrollment.amount_paid || 0})" title="Edit"><i class="fas fa-pencil-alt"></i></button>`;
                html += `<button class="e-icon-btn del" onclick="removeEnrollment(${enrollment.id})" title="Remove"><i class="fas fa-trash-alt"></i></button>`;
                html += `</div></td>`;
                html += `</tr>`;
            });

            html += `</tbody></table></div>`;
            container.innerHTML = html;
        }

        function getStatusClass(status) {
            const map = {
                'active': 'e-badge-active',
                'completed': 'e-badge-completed',
                'suspended': 'e-badge-suspended',
                'expelled': 'e-badge-expelled'
            };
            return map[status] || 'e-badge-active';
        }

        function getPaymentClass(paymentStatus) {
            const map = {
                'paid': 'e-badge-paid',
                'partial': 'e-badge-partial',
                'pending': 'e-badge-pending'
            };
            return map[paymentStatus] || 'e-badge-pending';
        }

        function openEnrollModal() {
            document.getElementById('enrollModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeEnrollModal() {
            document.getElementById('enrollModal').classList.remove('active');
            document.getElementById('enrollForm').reset();
            document.body.style.overflow = 'auto';
        }

        function submitEnrollment() {
            const formData = {
                class_id: document.getElementById('enroll_class_id').value,
                student_id: document.getElementById('enroll_student_id').value,
                payment_status: document.getElementById('enroll_payment_status').value,
                amount_paid: document.getElementById('enroll_amount_paid').value || 0,
                _token: document.querySelector('meta[name="csrf-token"]').content
            };

            if (!formData.class_id || !formData.student_id) {
                Swal.fire('Error', 'Please select both class and student', 'error');
                return;
            }

            Swal.fire({
                title: 'Enrolling Student...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch('{{ route("teacher.enrollments.enroll") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success!', data.message, 'success').then(() => {
                            location.reload();
                        });
                        closeEnrollModal();
                    } else {
                        Swal.fire('Error', data.message || 'Failed to enroll student', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Something went wrong', 'error');
                });
        }

        function openEditEnrollModal(id, status, paymentStatus, amountPaid) {
            document.getElementById('edit_enrollment_id').value = id;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_payment_status').value = paymentStatus;
            document.getElementById('edit_amount_paid').value = amountPaid;
            document.getElementById('editEnrollModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeEditEnrollModal() {
            document.getElementById('editEnrollModal').classList.remove('active');
            document.getElementById('editEnrollForm').reset();
            document.body.style.overflow = 'auto';
        }

        function updateEnrollment() {
            const id = document.getElementById('edit_enrollment_id').value;
            const formData = {
                status: document.getElementById('edit_status').value,
                payment_status: document.getElementById('edit_payment_status').value,
                amount_paid: document.getElementById('edit_amount_paid').value || 0,
                _token: document.querySelector('meta[name="csrf-token"]').content,
                _method: 'PUT'
            };

            Swal.fire({
                title: 'Updating...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch(`/teacher/enrollments/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-HTTP-Method-Override': 'PUT'
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success!', data.message, 'success').then(() => {
                            location.reload();
                        });
                        closeEditEnrollModal();
                    } else {
                        Swal.fire('Error', data.message || 'Failed to update enrollment', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Something went wrong', 'error');
                });
        }

        function removeEnrollment(id) {
            Swal.fire({
                title: 'Remove Student?',
                text: 'This will remove the student from the class. This action can be undone by re-enrolling.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, remove',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Removing...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    fetch(`/teacher/enrollments/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Removed!', data.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message || 'Failed to remove student', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error', 'Something went wrong', 'error');
                        });
                }
            });
        }

        // Close modals on outside click
        document.getElementById('enrollModal')?.addEventListener('click', function (e) {
            if (e.target === this) closeEnrollModal();
        });

        document.getElementById('editEnrollModal')?.addEventListener('click', function (e) {
            if (e.target === this) closeEditEnrollModal();
        });
    </script>

@endsection