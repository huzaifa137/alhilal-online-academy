@extends('Teacher.layouts.teacher-master')

@section('title', 'Add Questions - ' . $exam->title)
@section('page-title', 'Add Questions')
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

        .qz-questions-wrap {
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

        /* Info Card */
        .qz-info-card {
            background: var(--c-surface2);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-lg);
            padding: 20px 24px;
            margin-bottom: 28px;
            border-left: 4px solid var(--c-accent);
        }

        .qz-info-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--c-ink);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .qz-info-title i {
            color: var(--c-accent);
        }

        .qz-info-details {
            font-size: .82rem;
            color: var(--c-muted);
            line-height: 1.5;
        }

        .qz-info-details strong {
            color: var(--c-ink);
        }

        /* Question Card */
        .qz-question-card {
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-xl);
            margin-bottom: 24px;
            overflow: hidden;
            transition: all .2s ease;
            box-shadow: var(--shadow-sm);
        }

        .qz-question-card:hover {
            border-color: var(--c-accent);
            box-shadow: var(--shadow-md);
        }

        .qz-question-header {
            padding: 16px 24px;
            background: var(--c-surface2);
            border-bottom: 1.5px solid var(--c-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .qz-question-number {
            font-weight: 700;
            color: var(--c-accent);
            font-size: .85rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .qz-question-number i {
            font-size: .8rem;
        }

        .qz-question-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .qz-question-type-select {
            padding: 6px 12px;
            border-radius: var(--radius-pill);
            border: 1.5px solid var(--c-border);
            background: var(--c-surface);
            font-family: 'DM Sans', sans-serif;
            font-size: .75rem;
            font-weight: 500;
            color: var(--c-ink);
            cursor: pointer;
            transition: all .15s;
        }

        .qz-question-type-select:focus {
            outline: none;
            border-color: var(--c-accent);
        }

        .qz-question-body {
            padding: 24px;
        }

        /* Form Elements */
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
            min-height: 80px;
        }

        .fg-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        /* Options Container */
        .qz-options-container {
            background: var(--c-surface2);
            border-radius: var(--radius-lg);
            padding: 16px 20px;
            margin-top: 10px;
            border: 1px solid var(--c-border);
        }

        .qz-options-title {
            font-size: .75rem;
            font-weight: 700;
            color: var(--c-muted);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 12px;
        }

        .qz-option-row {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
        }

        .qz-option-row input {
            flex: 1;
        }

        .qz-option-label {
            width: 30px;
            font-weight: 600;
            color: var(--c-accent);
            font-size: .8rem;
        }

        .btn-remove-option {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1.5px solid var(--c-border);
            background: var(--c-surface);
            cursor: pointer;
            color: var(--c-red);
            transition: all .15s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-remove-option:hover {
            background: var(--c-red-lt);
            border-color: var(--c-red);
        }

        .btn-add-option {
            background: var(--c-accent-lt);
            border: none;
            padding: 6px 14px;
            border-radius: var(--radius-pill);
            cursor: pointer;
            color: var(--c-accent);
            font-size: .72rem;
            font-weight: 600;
            margin-top: 10px;
            transition: all .15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-add-option:hover {
            background: var(--c-accent);
            color: white;
        }

        .btn-remove-question {
            background: transparent;
            border: 1.5px solid var(--c-border);
            padding: 6px 12px;
            border-radius: var(--radius-pill);
            cursor: pointer;
            color: var(--c-red);
            font-size: .7rem;
            font-weight: 600;
            transition: all .15s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-remove-question:hover {
            background: var(--c-red-lt);
            border-color: var(--c-red);
        }

        .btn-add-question {
            background: var(--c-surface);
            border: 2px dashed var(--c-border);
            color: var(--c-accent);
            padding: 12px 24px;
            border-radius: var(--radius-pill);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            margin-top: 16px;
            transition: all .2s;
            width: auto;
        }

        .btn-add-question:hover {
            border-color: var(--c-accent);
            background: var(--c-accent-lt);
            transform: translateY(-1px);
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

        /* Empty State */
        .qz-empty-questions {
            text-align: center;
            padding: 60px 40px;
            background: var(--c-surface2);
            border-radius: var(--radius-xl);
            border: 2px dashed var(--c-border);
        }

        .qz-empty-questions i {
            font-size: 3rem;
            color: var(--c-muted);
            margin-bottom: 16px;
        }

        .qz-empty-questions p {
            color: var(--c-muted);
            font-size: .85rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .qz-page-title {
                font-size: 1.5rem;
            }

            .qz-question-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .qz-question-body {
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

    <div class="qz-questions-wrap">
        {{-- Page Header --}}
        <div class="qz-page-header">
            <div>
                <div class="qz-page-eyebrow"><i class="fas fa-question-circle"></i> Quiz Builder</div>
                <h1 class="qz-page-title">Add <em>Questions</em></h1>
                <div class="qz-page-subtitle">Create and manage questions for your quiz</div>
            </div>
        </div>

        {{-- Quiz Info Card --}}
        <div class="qz-info-card">
            <div class="qz-info-title">
                <i class="fas fa-info-circle"></i>
                {{ $exam->title }}
            </div>
            <div class="qz-info-details">
                <strong>📚 Class:</strong> {{ $exam->class->name ?? 'N/A' }} |
                <strong>📖 Subject:</strong> {{ $exam->subject->name ?? 'N/A' }} |
                <strong>⭐ Total Marks:</strong> {{ $exam->total_marks }} |
                <strong>✅ Pass Mark:</strong> {{ $exam->pass_mark }}%
                @if($exam->lesson)
                    <br><strong>📘 Lesson:</strong> {{ $exam->lesson->title }}
                @endif
            </div>
        </div>

        <form id="questionsForm">
            @csrf
            <div id="questionsList">
                @if($existingQuestions->count() > 0)
                    @foreach($existingQuestions as $index => $question)
                        <div class="qz-question-card" data-question-index="{{ $index }}">
                            <div class="qz-question-header">
                                <div class="qz-question-number">
                                    <i class="fas fa-question-circle"></i>
                                    Question #{{ $index + 1 }}
                                </div>
                                <div class="qz-question-actions">
                                    <select name="questions[{{ $index }}][type]" class="qz-question-type-select"
                                        onchange="updateQuestionType(this, {{ $index }})">
                                        <option value="mcq" {{ $question->type == 'mcq' ? 'selected' : '' }}>📝 Multiple Choice
                                        </option>
                                        <option value="true_false" {{ $question->type == 'true_false' ? 'selected' : '' }}>✓/✗
                                            True/False</option>
                                        <option value="short_answer" {{ $question->type == 'short_answer' ? 'selected' : '' }}>📋
                                            Short Answer</option>
                                        <option value="essay" {{ $question->type == 'essay' ? 'selected' : '' }}>📄 Essay</option>
                                    </select>
                                    <button type="button" class="btn-remove-question" onclick="removeQuestion(this)">
                                        <i class="fas fa-trash-alt"></i> Remove
                                    </button>
                                </div>
                            </div>
                            <div class="qz-question-body">
                                <div class="fg">
                                    <label>Question Text <span class="required">*</span></label>
                                    <textarea name="questions[{{ $index }}][question]" class="form-control" rows="2"
                                        required>{{ $question->question }}</textarea>
                                </div>

                                <div class="fg">
                                    <label>Question Text (Arabic)</label>
                                    <textarea name="questions[{{ $index }}][question_arabic]" class="form-control"
                                        rows="2">{{ $question->question_arabic }}</textarea>
                                </div>

                                <div class="fg-row">
                                    <div class="fg">
                                        <label>Marks <span class="required">*</span></label>
                                        <input type="number" name="questions[{{ $index }}][marks]" class="form-control"
                                            value="{{ $question->marks }}" min="1" required>
                                    </div>
                                    <div class="fg">
                                        <label>Correct Answer</label>
                                        <input type="text" name="questions[{{ $index }}][answer]" class="form-control"
                                            value="{{ $question->answer }}" placeholder="Correct answer">
                                    </div>
                                </div>

                                <div id="options-container-{{ $index }}"
                                    style="display: {{ in_array($question->type, ['mcq']) ? 'block' : 'none' }}">
                                    <div class="qz-options-container">
                                        <div class="qz-options-title">
                                            <i class="fas fa-list-ul"></i> Answer Options (MCQ)
                                        </div>
                                        <div id="options-list-{{ $index }}">
                                            @php
                                                $options = is_array($question->options) ? $question->options : [];
                                            @endphp
                                            @foreach($options as $optKey => $optValue)
                                                <div class="qz-option-row">
                                                    <div class="qz-option-label">{{ $optKey }}</div>
                                                    <input type="text" name="questions[{{ $index }}][options][{{ $optKey }}]"
                                                        class="form-control" placeholder="Option {{ $optKey }}" value="{{ $optValue }}">
                                                    <button type="button" class="btn-remove-option"
                                                        onclick="removeOption(this)">✕</button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn-add-option" onclick="addOption({{ $index }})">
                                            <i class="fas fa-plus"></i> Add Option
                                        </button>
                                    </div>
                                </div>

                                <div class="fg">
                                    <label>Explanation (Optional)</label>
                                    <textarea name="questions[{{ $index }}][explanation]" class="form-control" rows="2"
                                        placeholder="Explain why this answer is correct for students">{{ $question->explanation }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div id="noQuestionsMsg" class="qz-empty-questions">
                        <i class="fas fa-question-circle"></i>
                        <p>No questions added yet. Click "Add Question" to get started.</p>
                    </div>
                @endif
            </div>

            <button type="button" class="btn-add-question" onclick="addNewQuestion()">
                <i class="fas fa-plus-circle"></i> Add New Question
            </button>

            <div class="qz-form-actions">
                <a href="{{ route('teacher.quizzes.index') }}" class="btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i> Save Questions & Publish Quiz
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let questionCounter = {{ $existingQuestions->count() }};

        function addNewQuestion() {
            const container = document.getElementById('questionsList');
            const noQuestionsMsg = document.getElementById('noQuestionsMsg');
            if (noQuestionsMsg) noQuestionsMsg.remove();

            const index = questionCounter;
            const questionHtml = `
                <div class="qz-question-card" data-question-index="${index}">
                    <div class="qz-question-header">
                        <div class="qz-question-number">
                            <i class="fas fa-question-circle"></i>
                            Question #${index + 1}
                        </div>
                        <div class="qz-question-actions">
                            <select name="questions[${index}][type]" class="qz-question-type-select" onchange="updateQuestionType(this, ${index})">
                                <option value="mcq">📝 Multiple Choice</option>
                                <option value="true_false">✓/✗ True/False</option>
                                <option value="short_answer">📋 Short Answer</option>
                                <option value="essay">📄 Essay</option>
                            </select>
                            <button type="button" class="btn-remove-question" onclick="removeQuestion(this)">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        </div>
                    </div>
                    <div class="qz-question-body">
                        <div class="fg">
                            <label>Question Text <span class="required">*</span></label>
                            <textarea name="questions[${index}][question]" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="fg">
                            <label>Question Text (Arabic)</label>
                            <textarea name="questions[${index}][question_arabic]" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="fg-row">
                            <div class="fg">
                                <label>Marks <span class="required">*</span></label>
                                <input type="number" name="questions[${index}][marks]" class="form-control" value="1" min="1" required>
                            </div>
                            <div class="fg">
                                <label>Correct Answer</label>
                                <input type="text" name="questions[${index}][answer]" class="form-control" placeholder="Correct answer">
                            </div>
                        </div>

                        <div id="options-container-${index}" style="display: none;">
                            <div class="qz-options-container">
                                <div class="qz-options-title">
                                    <i class="fas fa-list-ul"></i> Answer Options (MCQ)
                                </div>
                                <div id="options-list-${index}"></div>
                                <button type="button" class="btn-add-option" onclick="addOption(${index})">
                                    <i class="fas fa-plus"></i> Add Option
                                </button>
                            </div>
                        </div>

                        <div class="fg">
                            <label>Explanation (Optional)</label>
                            <textarea name="questions[${index}][explanation]" class="form-control" rows="2" placeholder="Explain why this answer is correct for students"></textarea>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', questionHtml);
            questionCounter++;
            reindexQuestions();
        }

        function removeQuestion(btn) {
            const questionCard = btn.closest('.qz-question-card');
            questionCard.remove();
            reindexQuestions();

            if (document.querySelectorAll('.qz-question-card').length === 0) {
                const container = document.getElementById('questionsList');
                container.innerHTML = `
                    <div id="noQuestionsMsg" class="qz-empty-questions">
                        <i class="fas fa-question-circle"></i>
                        <p>No questions added yet. Click "Add Question" to get started.</p>
                    </div>
                `;
                questionCounter = 0;
            }
        }

        function updateQuestionType(select, index) {
            const type = select.value;
            const optionsContainer = document.getElementById(`options-container-${index}`);

            if (type === 'mcq') {
                optionsContainer.style.display = 'block';
                if (document.getElementById(`options-list-${index}`).children.length === 0) {
                    addOption(index);
                    addOption(index);
                }
            } else {
                optionsContainer.style.display = 'none';
            }
        }

        function addOption(index) {
            const optionsList = document.getElementById(`options-list-${index}`);
            const optionLetter = String.fromCharCode(65 + optionsList.children.length);

            const optionHtml = `
                <div class="qz-option-row">
                    <div class="qz-option-label">${optionLetter}</div>
                    <input type="text" name="questions[${index}][options][${optionLetter}]" class="form-control" placeholder="Option ${optionLetter}" value="">
                    <button type="button" class="btn-remove-option" onclick="removeOption(this)">✕</button>
                </div>
            `;

            optionsList.insertAdjacentHTML('beforeend', optionHtml);
        }

        function removeOption(btn) {
            btn.closest('.qz-option-row').remove();
        }

        function reindexQuestions() {
            const questions = document.querySelectorAll('.qz-question-card');
            questions.forEach((question, idx) => {
                const numberSpan = question.querySelector('.qz-question-number');
                numberSpan.innerHTML = `<i class="fas fa-question-circle"></i> Question #${idx + 1}`;

                // Update all input names
                const inputs = question.querySelectorAll('[name^="questions["]');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    const newName = name.replace(/questions\[\d+\]/, `questions[${idx}]`);
                    input.setAttribute('name', newName);
                });

                // Update options container id
                const optionsContainer = question.querySelector('[id^="options-container-"]');
                if (optionsContainer) {
                    const oldId = optionsContainer.id;
                    const newId = `options-container-${idx}`;
                    optionsContainer.id = newId;

                    // Update options list id
                    const optionsList = optionsContainer.querySelector('[id^="options-list-"]');
                    if (optionsList) {
                        optionsList.id = `options-list-${idx}`;
                    }

                    // Update add option button onclick
                    const addBtn = optionsContainer.querySelector('.btn-add-option');
                    if (addBtn) {
                        addBtn.setAttribute('onclick', `addOption(${idx})`);
                    }
                }
            });
            questionCounter = questions.length;
        }

        document.getElementById('questionsForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            // Validate at least one question
            const questions = document.querySelectorAll('.qz-question-card');
            if (questions.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'No Questions',
                    text: 'Please add at least one question to the quiz.',
                    confirmButtonColor: '#DC2626'
                });
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving Questions...';
            submitBtn.disabled = true;

            const formData = new FormData(this);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            try {
                const response = await fetch('{{ route("teacher.quizzes.save-questions", $exam->id) }}', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        confirmButtonColor: '#5B3FD9',
                        confirmButtonText: 'Great!'
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    let errorMsg = 'Failed to save questions.';
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