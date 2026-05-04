@extends('Teacher.layouts.teacher-master')

@section('title', 'Create New Quiz')
@section('page-title', 'Create New Quiz')
@section('breadcrumb', 'Quizzes')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
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
        --c-red: #DC2626;
        --c-red-lt: #FEE2E2;
        --c-green-lt: #D1FAE5;
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

    .qz-create-wrap {
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

    /* Info Note */
    .qz-info-note {
        background: var(--c-accent-lt);
        border-radius: var(--radius-lg);
        padding: 16px 20px;
        margin-bottom: 28px;
        border-left: 4px solid var(--c-accent);
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .qz-info-note i {
        color: var(--c-accent);
        font-size: 1rem;
        margin-top: 2px;
    }

    .qz-info-note p {
        margin: 0;
        font-size: .84rem;
        color: var(--c-ink);
        line-height: 1.4;
    }

    .qz-info-note strong {
        color: var(--c-accent);
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

        .qz-form-actions {
            flex-direction: column-reverse;
        }

        .qz-form-actions button,
        .qz-form-actions a {
            justify-content: center;
        }
    }
</style>

<div class="qz-create-wrap">
    {{-- Page Header --}}
    <div class="qz-page-header">
        <div>
            <div class="qz-page-eyebrow"><i class="fas fa-plus-circle"></i> Quiz Creation</div>
            <h1 class="qz-page-title">Create <em>New Quiz</em></h1>
            <div class="qz-page-subtitle">
                {{ $type === 'lesson' ? 'Create a quiz for a specific lesson' : 'Create a general quiz for an entire class' }}
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="qz-form-card">
        <div class="qz-card-head">
            <div class="qz-card-label">
                <div class="qz-card-icon"><i class="fas fa-plus-circle"></i></div>
                <div>
                    <div class="qz-card-title">{{ $type === 'lesson' ? 'Lesson Quiz' : 'Class Quiz' }}</div>
                    <div class="qz-card-sub">{{ $type === 'lesson' ? 'Quiz attached to a specific lesson' : 'General quiz for an entire class' }}</div>
                </div>
            </div>
        </div>

        <div class="qz-card-body">
            @if($type === 'lesson' && $lesson)
                <div class="qz-info-note">
                    <i class="fas fa-info-circle"></i>
                    <p>
                        <strong>Lesson:</strong> {{ $lesson->title }}<br>
                        <strong>Class:</strong> {{ $lesson->topic->class->name ?? 'N/A' }}<br>
                        <strong>Subject:</strong> {{ $lesson->topic->subject->name ?? 'N/A' }}
                    </p>
                </div>
            @endif

            <form id="quizForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="exam_type" value="quiz">
                <input type="hidden" name="lesson_id" value="{{ $lesson->id ?? '' }}">

                <div class="fg">
                    <label>Quiz Title <span class="required">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g., Chapter 1 Quiz" required>
                </div>

                <div class="fg-row">
                    <div class="fg">
                        <label>Class <span class="required">*</span></label>
                        <select id="classSelect" name="class_id" required>
                            <option value="">-- Select a class --</option>
                        </select>
                    </div>

                    <div class="fg">
                        <label>Subject <span class="required">*</span></label>
                        <select id="subjectSelect" name="subject_id" required disabled>
                            <option value="">-- First select a class --</option>
                        </select>
                    </div>
                </div>

                <div class="fg-row">
                    <div class="fg">
                        <label>Total Marks <span class="required">*</span></label>
                        <input type="number" name="total_marks" placeholder="100" min="1" value="100" required>
                    </div>

                    <div class="fg">
                        <label>Pass Mark (%) <span class="required">*</span></label>
                        <input type="number" name="pass_mark" placeholder="50" min="0" max="100" value="50" required>
                    </div>
                </div>

                <div class="fg-row">
                    <div class="fg">
                        <label>Duration (minutes)</label>
                        <input type="number" name="duration_minutes" placeholder="30" min="1">
                        <small>Leave empty for no time limit</small>
                    </div>

                    <div class="fg">
                        <label>Max Attempts</label>
                        <input type="number" name="max_attempts" placeholder="3" min="1" max="10" value="3">
                        <small>Number of times student can retake</small>
                    </div>
                </div>

                <div class="fg-row">
                    <div class="fg">
                        <label>Available From</label>
                        <input type="datetime-local" name="available_from">
                    </div>

                    <div class="fg">
                        <label>Available To</label>
                        <input type="datetime-local" name="available_to">
                    </div>
                </div>

                <div class="fg">
                    <label>Instructions</label>
                    <textarea name="instructions" placeholder="Provide instructions for students..."></textarea>
                </div>

                <div class="fg">
                    <label class="fg-checkbox">
                        <input type="checkbox" name="shuffle_questions" value="1">
                        <span>Shuffle Questions</span>
                    </label>
                    <small>Randomize question order for each student</small>
                </div>

                <div class="qz-form-actions">
                    <a href="{{ route('teacher.quizzes.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i> Create & Add Questions
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentClassId = null;
    let currentSubjectId = null;

    // Load classes on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadClasses();
        
        // If lesson is pre-selected, set the class and trigger change
        @if($type === 'lesson' && $lesson && $lesson->topic->class_id)
            setTimeout(function() {
                const classSelect = document.getElementById('classSelect');
                if (classSelect) {
                    classSelect.value = "{{ $lesson->topic->class_id }}";
                    classSelect.dispatchEvent(new Event('change'));
                }
            }, 500);
        @endif
    });

    // Load classes from database using the same endpoint as lessons
    async function loadClasses() {
        try {
            const response = await fetch('/teacher/lessons/classes/list');

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Classes loaded:', data);

            const classSelect = document.getElementById('classSelect');
            classSelect.innerHTML = '<option value="">-- Select a class --</option>';

            if (data.classes && data.classes.length > 0) {
                data.classes.forEach(cls => {
                    const option = document.createElement('option');
                    option.value = cls.id;
                    const levelName = cls.level?.name || 'N/A';
                    const sectionName = cls.level?.section?.name || '';
                    option.textContent = `${cls.name}${sectionName ? ` (${sectionName} - ${levelName})` : ` (${levelName})`}`;
                    classSelect.appendChild(option);
                });
                classSelect.disabled = false;
            } else {
                classSelect.innerHTML += '<option value="" disabled>No classes available</option>';
                classSelect.disabled = true;
            }
        } catch (error) {
            console.error('Error loading classes:', error);
            const classSelect = document.getElementById('classSelect');
            classSelect.innerHTML = '<option value="" disabled>Error loading classes. Please refresh.</option>';
            classSelect.disabled = true;
            Swal.fire('Error', 'Failed to load classes. Please refresh the page.', 'error');
        }
    }

    // Load subjects for selected class
    document.getElementById('classSelect').addEventListener('change', async function() {
        const classId = this.value;
        currentClassId = classId;
        const subjectSelect = document.getElementById('subjectSelect');

        subjectSelect.innerHTML = '<option value="">Loading subjects...</option>';
        subjectSelect.disabled = true;

        if (!classId) {
            subjectSelect.innerHTML = '<option value="">-- First select a class --</option>';
            return;
        }

        try {
            const response = await fetch(`/teacher/lessons/classes/${classId}/subjects`);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Subjects loaded:', data);

            subjectSelect.innerHTML = '<option value="">-- Select a subject --</option>';

            if (data.subjects && data.subjects.length > 0) {
                data.subjects.forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject.id;
                    option.textContent = `${subject.name} (${subject.code || ''})`;
                    subjectSelect.appendChild(option);
                });
                subjectSelect.disabled = false;
            } else {
                subjectSelect.innerHTML = '<option value="" disabled>-- No subjects assigned to this class --</option>';
                subjectSelect.disabled = true;
            }
        } catch (error) {
            console.error('Error loading subjects:', error);
            subjectSelect.innerHTML = '<option value="" disabled>Error loading subjects</option>';
            subjectSelect.disabled = true;
            Swal.fire('Error', 'Failed to load subjects for this class.', 'error');
        }
    });

    // Form submission
    document.getElementById('quizForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Validate subject is selected
        const subjectSelect = document.getElementById('subjectSelect');
        if (!subjectSelect.value) {
            Swal.fire('Error', 'Please select a subject.', 'error');
            return;
        }
        
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
        submitBtn.disabled = true;
        
        const formData = new FormData(this);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        
        try {
            const response = await fetch('{{ route("teacher.quizzes.store") }}', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Quiz Created!',
                    text: data.message,
                    confirmButtonColor: '#5B3FD9',
                    confirmButtonText: 'Continue to Add Questions'
                }).then(() => {
                    window.location.href = data.redirect;
                });
            } else {
                let errorMsg = 'Failed to create quiz.';
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