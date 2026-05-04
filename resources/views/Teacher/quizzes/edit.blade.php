@extends('Teacher.layouts.teacher-master')

@section('title', 'Edit Quiz - ' . $exam->title)
@section('page-title', 'Edit Quiz')
@section('breadcrumb', 'Quizzes')

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
            --c-emerald: #059669;
            --c-green-lt: #D1FAE5;
            --c-red: #DC2626;
            --c-red-lt: #FEE2E2;
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

        .qz-edit-wrap {
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            color: var(--c-ink);
        }

        /* Page Header */
        .qz-page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .qz-page-eyebrow {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--c-accent);
            margin-bottom: 6px;
        }

        .qz-page-title {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--c-ink);
            line-height: 1.15;
            margin: 0;
        }

        .qz-page-title em {
            font-style: italic;
            color: var(--c-accent);
        }

        .qz-page-subtitle {
            margin-top: 6px;
            font-size: .83rem;
            color: var(--c-muted);
            font-weight: 400;
        }

        /* Form Card */
        .qz-form-card {
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .qz-card-head {
            padding: 22px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            border-bottom: 1.5px solid var(--c-border);
            background: var(--c-surface2);
        }

        .qz-card-label {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qz-card-icon {
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

        .qz-card-title {
            font-family: 'DM Serif Display', serif;
            font-size: 1.15rem;
            font-weight: 400;
            color: var(--c-ink);
            margin: 0;
        }

        .qz-card-sub {
            font-size: .76rem;
            color: var(--c-muted);
            margin-top: 1px;
        }

        .qz-card-body {
            padding: 32px;
        }

        /* Current Status Banner */
        .qz-status-banner {
            background: var(--c-surface2);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-lg);
            padding: 16px 20px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .qz-status-label {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .qz-status-text {
            font-size: .82rem;
            font-weight: 600;
            color: var(--c-ink);
        }

        .qz-badge {
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

        .qz-badge .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .qz-badge-draft {
            background: var(--c-gold-lt);
            color: var(--c-gold);
        }

        .qz-badge-draft .dot {
            background: var(--c-gold);
        }

        .qz-badge-published {
            background: var(--c-green-lt);
            color: var(--c-emerald);
        }

        .qz-badge-published .dot {
            background: var(--c-emerald);
        }

        .qz-badge-closed {
            background: var(--c-red-lt);
            color: var(--c-red);
        }

        .qz-badge-closed .dot {
            background: var(--c-red);
        }

        .qz-status-hint {
            font-size: .72rem;
            color: var(--c-muted);
        }

        /* Form Elements */
        .fg {
            margin-bottom: 24px;
        }

        .fg label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: var(--c-ink);
            margin-bottom: 7px;
            letter-spacing: .01em;
        }

        .fg label .required {
            color: var(--c-accent);
            margin-left: 2px;
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

        .fg textarea {
            resize: vertical;
            min-height: 100px;
        }

        .fg small {
            display: block;
            font-size: .7rem;
            color: var(--c-muted);
            margin-top: 5px;
        }

        .fg-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        /* Checkbox Styling */
        .fg-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .fg-checkbox input {
            width: auto;
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--c-accent);
        }

        .fg-checkbox span {
            font-size: .78rem;
            font-weight: 600;
            color: var(--c-ink);
        }

        /* Form Actions */
        .qz-form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1.5px solid var(--c-border);
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
            text-decoration: none;
        }

        .btn-primary:hover:not(:disabled) {
            background: #4930C2;
            box-shadow: 0 6px 20px rgba(91, 63, 217, .32);
            transform: translateY(-1px);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
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

        /* Responsive */
        @media (max-width: 768px) {
            .qz-page-title {
                font-size: 1.5rem;
            }

            .qz-card-head {
                padding: 16px 20px;
            }

            .qz-card-body {
                padding: 20px;
            }

            .fg-row {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .qz-status-banner {
                flex-direction: column;
                align-items: flex-start;
            }

            .qz-form-actions {
                flex-direction: column-reverse;
            }

            .qz-form-actions button,
            .qz-form-actions a {
                justify-content: center;
            }
        }
    </style>

    <div class="qz-edit-wrap">
        {{-- Page Header --}}
        <div class="qz-page-header">
            <div>
                <div class="qz-page-eyebrow"><i class="fas fa-edit"></i> Quiz Management</div>
                <h1 class="qz-page-title">Edit <em>Quiz</em></h1>
                <div class="qz-page-subtitle">Update quiz settings and configuration</div>
            </div>
        </div>

        {{-- Edit Form Card --}}
        <div class="qz-form-card">
            <div class="qz-card-head">
                <div class="qz-card-label">
                    <div class="qz-card-icon"><i class="fas fa-edit"></i></div>
                    <div>
                        <div class="qz-card-title">{{ $exam->title }}</div>
                        <div class="qz-card-sub">Update quiz details and settings</div>
                    </div>
                </div>
            </div>

            <div class="qz-card-body">
                {{-- Current Status Banner --}}
                <div class="qz-status-banner">
                    <div class="qz-status-label">
                        <span class="qz-status-text">Current Status:</span>
                        <span class="qz-badge qz-badge-{{ $exam->status }}">
                            <span class="dot"></span>{{ ucfirst($exam->status) }}
                        </span>
                    </div>
                    <div class="qz-status-hint">
                        @if($exam->status == 'published')
                            <i class="fas fa-eye"></i> Quiz is visible to students
                        @elseif($exam->status == 'draft')
                            <i class="fas fa-eye-slash"></i> Quiz is not visible to students
                        @else
                            <i class="fas fa-lock"></i> Quiz is closed for submissions
                        @endif
                    </div>
                </div>

                <form id="editQuizForm">
                    @csrf
                    @method('PUT')

                    <div class="fg">
                        <label>Quiz Title <span class="required">*</span></label>
                        <input type="text" name="title" value="{{ $exam->title }}" required>
                    </div>

                    <div class="fg-row">
                        <div class="fg">
                            <label>Total Marks <span class="required">*</span></label>
                            <input type="number" name="total_marks" value="{{ $exam->total_marks }}" min="1" required>
                        </div>

                        <div class="fg">
                            <label>Pass Mark (%) <span class="required">*</span></label>
                            <input type="number" name="pass_mark" value="{{ $exam->pass_mark }}" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="fg-row">
                        <div class="fg">
                            <label>Duration (minutes)</label>
                            <input type="number" name="duration_minutes" value="{{ $exam->duration_minutes }}" min="1">
                            <small>Leave empty for no time limit</small>
                        </div>

                        <div class="fg">
                            <label>Max Attempts</label>
                            <input type="number" name="max_attempts" value="{{ $exam->max_attempts ?? 3 }}" min="1"
                                max="10">
                            <small>Number of times student can retake</small>
                        </div>
                    </div>

                    <div class="fg-row">
                        <div class="fg">
                            <label>Available From</label>
                            <input type="datetime-local" name="available_from"
                                value="{{ $exam->available_from ? date('Y-m-d\TH:i', strtotime($exam->available_from)) : '' }}">
                            <small>Leave empty for immediate availability</small>
                        </div>

                        <div class="fg">
                            <label>Available To</label>
                            <input type="datetime-local" name="available_to"
                                value="{{ $exam->available_to ? date('Y-m-d\TH:i', strtotime($exam->available_to)) : '' }}">
                            <small>Leave empty for no expiry</small>
                        </div>
                    </div>

                    <div class="fg">
                        <label>Instructions</label>
                        <textarea name="instructions" rows="3">{{ $exam->instructions }}</textarea>
                        <small>Provide instructions that students will see before starting the quiz</small>
                    </div>

                    <div class="fg-row">
                        <div class="fg">
                            <label>Status <span class="required">*</span></label>
                            <select name="status" required>
                                <option value="draft" {{ $exam->status == 'draft' ? 'selected' : '' }}>
                                    📝 Draft - Not visible to students
                                </option>
                                <option value="published" {{ $exam->status == 'published' ? 'selected' : '' }}>
                                    🚀 Published - Visible to students
                                </option>
                                <option value="closed" {{ $exam->status == 'closed' ? 'selected' : '' }}>
                                    🔒 Closed - No longer accepting submissions
                                </option>
                            </select>
                        </div>

                        <div class="fg">
                            <label class="fg-checkbox">
                                <input type="checkbox" name="shuffle_questions" value="1" {{ $exam->shuffle_questions ? 'checked' : '' }}>
                                <span>Shuffle Questions</span>
                            </label>
                            <small>Randomize question order for each student</small>
                        </div>
                    </div>

                    <div class="qz-form-actions">
                        <a href="{{ route('teacher.quizzes.index') }}" class="btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i> Update Quiz
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('editQuizForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            submitBtn.disabled = true;

            const formData = new FormData(this);

            try {
                const response = await fetch('{{ route("teacher.quizzes.update", $exam->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: data.message,
                        confirmButtonColor: '#5B3FD9',
                        confirmButtonText: 'Great!'
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    let errorMsg = 'Failed to update quiz.';
                    if (data.errors) {
                        errorMsg = Object.values(data.errors).flat().join('\n');
                    } else if (data.message) {
                        errorMsg = data.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg,
                        confirmButtonColor: '#DC2626'
                    });
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonColor: '#DC2626'
                });
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    </script>
@endsection