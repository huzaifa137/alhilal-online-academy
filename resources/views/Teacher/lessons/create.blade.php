@extends('Teacher.layouts.teacher-master')

@section('title', 'Add New Lesson')
@section('page-title', 'Add New Lesson')
@section('breadcrumb', 'Lessons')

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
            --radius-lg: 18px;
            --radius-xl: 24px;
            --radius-pill: 999px;
            --shadow-sm: 0 1px 3px rgba(91, 63, 217, .07), 0 1px 2px rgba(0, 0, 0, .04);
            --shadow-md: 0 4px 16px rgba(91, 63, 217, .10), 0 2px 6px rgba(0, 0, 0, .05);
            --shadow-lg: 0 12px 40px rgba(91, 63, 217, .14), 0 4px 12px rgba(0, 0, 0, .06);
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

        .l-wrap {
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            color: var(--c-ink);
        }

        /* Page Header */
        .l-page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .l-page-eyebrow {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--c-accent);
            margin-bottom: 6px;
        }

        .l-page-title {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--c-ink);
            line-height: 1.15;
            margin: 0;
        }

        .l-page-title em {
            font-style: italic;
            color: var(--c-accent);
        }

        .l-page-subtitle {
            margin-top: 6px;
            font-size: .83rem;
            color: var(--c-muted);
            font-weight: 400;
        }

        /* Card */
        .l-card {
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
        }

        .l-card-head {
            padding: 22px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            border-bottom: 1.5px solid var(--c-border);
            background: var(--c-surface2);
        }

        .l-card-label {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .l-card-icon {
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

        .l-card-title {
            font-family: 'DM Serif Display', serif;
            font-size: 1.15rem;
            font-weight: 400;
            color: var(--c-ink);
            margin: 0;
        }

        .l-card-sub {
            font-size: .76rem;
            color: var(--c-muted);
            margin-top: 1px;
        }

        .l-card-body {
            padding: 28px;
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

        .fg input::placeholder,
        .fg textarea::placeholder {
            color: #C4BDD6;
        }

        .fg textarea {
            resize: vertical;
        }

        .fg-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .fg-row-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        /* Upload Area */
        .upload-area {
            background: var(--c-surface2);
            border: 2px dashed var(--c-border);
            border-radius: var(--radius-lg);
            padding: 40px 24px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
        }

        .upload-area:hover {
            border-color: var(--c-accent);
            background: var(--c-accent-lt);
        }

        .file-alert {
            background: var(--c-accent-lt);
            border-radius: 12px;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: .84rem;
            color: var(--c-accent);
        }

        .file-alert-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: var(--c-accent);
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
            padding: 12px 28px;
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
            gap: 8px;
            padding: 12px 24px;
            border-radius: var(--radius-pill);
            border: 1.5px solid var(--c-border);
            background: var(--c-surface);
            color: var(--c-muted);
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, border-color .15s;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: var(--c-surface2);
            border-color: var(--c-muted);
        }

        .link-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--c-accent);
            font-size: .85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .link-primary:hover {
            text-decoration: underline;
        }

        .new-topic-box {
            margin-top: 20px;
            padding: 20px;
            background: var(--c-surface2);
            border-radius: var(--radius-lg);
            border: 1px solid var(--c-border);
        }

        .form-actions {
            display: flex;
            gap: 16px;
            justify-content: flex-end;
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1.5px solid var(--c-border);
        }

        /* Loading Spinner */
        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 768px) {

            .fg-row,
            .fg-row-3 {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .l-card-head {
                padding: 16px 20px;
            }

            .l-card-body {
                padding: 20px;
            }

            .l-page-title {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="l-wrap">

        {{-- Page Header --}}
        <div class="l-page-header">
            <div>
                <div class="l-page-eyebrow"><i class="fas fa-plus-circle"></i> Lesson Creation</div>
                <h1 class="l-page-title">Create <em>New Lesson</em></h1>
                <div class="l-page-subtitle">Add engaging content for your students</div>
            </div>
        </div>

        <form id="addLessonForm" enctype="multipart/form-data">
            @csrf

            {{-- SECTION 1: Class & Subject Selection --}}
            <div class="l-card">
                <div class="l-card-head">
                    <div class="l-card-label">
                        <div class="l-card-icon"><i class="fas fa-chalkboard"></i></div>
                        <div>
                            <div class="l-card-title">Class & Subject</div>
                            <div class="l-card-sub">Choose where this lesson belongs</div>
                        </div>
                    </div>
                </div>
                <div class="l-card-body">
                    <div class="fg-row">
                        <div class="fg">
                            <label><i class="fas fa-users" style="margin-right: 6px;"></i> Select Class
                                <span>*</span></label>
                            <select id="classSelect" required>
                                <option value="">-- Select a class --</option>
                            </select>
                        </div>

                        <div class="fg">
                            <label><i class="fas fa-book" style="margin-right: 6px;"></i> Select Subject
                                <span>*</span></label>
                            <select id="subjectSelect" required disabled>
                                <option value="">-- First select a class --</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: Topic Selection --}}
            <div class="l-card">
                <div class="l-card-head">
                    <div class="l-card-label">
                        <div class="l-card-icon"><i class="fas fa-layer-group"></i></div>
                        <div>
                            <div class="l-card-title">Topic</div>
                            <div class="l-card-sub">Organize your lesson within a topic</div>
                        </div>
                    </div>
                </div>
                <div class="l-card-body">
                    <div class="fg">
                        <label><i class="fas fa-folder" style="margin-right: 6px;"></i> Select Topic <span>*</span></label>
                        <select id="topicSelect" name="topic_id" required disabled>
                            <option value="">-- First select a class and subject --</option>
                        </select>
                    </div>

                    <a href="#" id="showNewTopicBtn" class="link-primary" style="display: none;">
                        <i class="fas fa-plus-circle"></i> Or create a new topic
                    </a>

                    <div id="newTopicSection" style="display: none;">
                        <div class="new-topic-box">
                            <div
                                style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                                <h4
                                    style="font-family: 'DM Serif Display', serif; font-size: 1rem; font-weight: 400; color: var(--c-ink);">
                                    <i class="fas fa-plus" style="color: var(--c-accent); margin-right: 6px;"></i>
                                    Create New Topic
                                </h4>
                                <button type="button" id="hideNewTopicBtn"
                                    style="background: none; border: none; color: var(--c-muted); cursor: pointer; font-size: 1.1rem;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <div class="fg-row">
                                <div class="fg">
                                    <label>Topic Title <span>*</span></label>
                                    <input type="text" id="newTopicTitle" placeholder="e.g., Taharah, Salah, Zakah">
                                </div>

                                <div class="fg">
                                    <label>Topic Title (Arabic)</label>
                                    <input type="text" id="newTopicTitleArabic" placeholder="عنوان الموضوع بالعربية">
                                </div>
                            </div>

                            <div class="fg">
                                <label>Learning Objectives</label>
                                <textarea id="newTopicObjectives" rows="2"
                                    placeholder="What students will learn from this topic..."></textarea>
                            </div>

                            <div class="fg">
                                <label>Description</label>
                                <textarea id="newTopicDesc" rows="2"
                                    placeholder="Brief description of what this topic covers..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: Lesson Details --}}
            <div class="l-card">
                <div class="l-card-head">
                    <div class="l-card-label">
                        <div class="l-card-icon"><i class="fas fa-pencil-alt"></i></div>
                        <div>
                            <div class="l-card-title">Lesson Details</div>
                            <div class="l-card-sub">Core information about your lesson</div>
                        </div>
                    </div>
                </div>
                <div class="l-card-body">
                    <div class="fg-row">
                        <div class="fg">
                            <label>Lesson Title <span>*</span></label>
                            <input type="text" id="lessonTitle" name="title" placeholder="e.g., Wudhu - Step by Step Guide"
                                required>
                        </div>

                        <div class="fg">
                            <label>Lesson Title (Arabic)</label>
                            <input type="text" id="lessonTitleArabic" name="title_arabic"
                                placeholder="عنوان الدرس بالعربية">
                        </div>
                    </div>

                    <div class="fg-row">
                        <div class="fg">
                            <label>Lesson Type <span>*</span></label>
                            <select id="lessonType" name="lesson_type" required>
                                <option value="">-- Select --</option>
                                <option value="video">Video Lesson</option>
                                <option value="audio">Audio Lesson</option>
                                <option value="pdf">PDF Notes</option>
                                <option value="text">Text Lesson</option>
                                <option value="mixed">Mixed Content</option>
                            </select>
                        </div>

                        <div class="fg">
                            <label>Duration (minutes)</label>
                            <input type="number" id="lessonDuration" name="duration" placeholder="45" min="1" max="180" required>
                        </div>
                    </div>

                    <div class="fg">
                        <label>Lesson Description</label>
                        <textarea id="lessonDesc" name="description" rows="3"
                            placeholder="Describe what students will learn in this lesson..."></textarea>
                    </div>
                </div>
            </div>

            {{-- SECTION 4: Upload Lesson Material --}}
            <div class="l-card">
                <div class="l-card-head">
                    <div class="l-card-label">
                        <div class="l-card-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div>
                            <div class="l-card-title">Lesson Material</div>
                            <div class="l-card-sub">Upload your lesson content (required)</div>
                        </div>
                    </div>
                </div>
                <div class="l-card-body">
                    <div class="upload-area" id="uploadArea" onclick="document.getElementById('lessonFile').click()">
                        <i class="fas fa-cloud-upload-alt fa-3x" style="color: var(--c-accent); margin-bottom: 12px;"></i>
                        <p style="color: var(--c-ink); font-weight: 500; margin-bottom: 4px;">Click to browse or drag & drop
                            your file</p>
                        <span style="font-size: 0.72rem; color: var(--c-muted);">Supported: MP4, MP3, PDF (Max 50MB)</span>
                        <input type="file" id="lessonFile" name="lesson_file" style="display: none;" accept=".mp4,.mp3,.pdf"
                            required>
                    </div>

                    <div id="fileInfo" style="display: none; margin-top: 12px;">
                        <div class="file-alert">
                            <span><i class="fas fa-file"></i> <span id="fileName"></span></span>
                            <button type="button" class="file-alert-close" onclick="clearFile()">&times;</button>
                        </div>
                    </div>
                    <div id="fileError" style="display: none; color: var(--c-red); font-size: 0.8rem; margin-top: 8px;">
                        <i class="fas fa-exclamation-circle"></i> Please upload a lesson file
                    </div>
                </div>
            </div>

            {{-- SECTION 5: Additional Settings --}}
            <div class="l-card">
                <div class="l-card-head">
                    <div class="l-card-label">
                        <div class="l-card-icon"><i class="fas fa-cog"></i></div>
                        <div>
                            <div class="l-card-title">Additional Settings</div>
                            <div class="l-card-sub">Configure lesson order, pricing, and visibility</div>
                        </div>
                    </div>
                </div>
                <div class="l-card-body">
                    <div class="fg-row-3">
                        <div class="fg">
                            <label>Lesson Order</label>
                            <input type="number" id="lessonOrder" name="lesson_order" placeholder="Auto" min="1" readonly
                                style="background-color:#e9ecef; color:#6c757d; border:1px solid #ced4da; cursor:not-allowed;">
                            <span style="font-size: 0.7rem; color: var(--c-muted);">Leave empty for auto order</span>
                        </div>

                        <div class="fg">
                            <label>Amount (UGX)</label>
                            <input type="text" id="lessonAmount" name="amount" placeholder="e.g., 15,000" required>
                        </div>

                        <div class="fg">
                            <label>Status <span>*</span></label>
                            <select id="lessonStatus" name="status" required>
                                <option value="">-- Select --</option>
                                <option value="published">✅ Published - Visible to students</option>
                                <option value="draft">📝 Draft - Save for later</option>
                            </select>
                        </div>
                    </div>

                    <div class="fg">
                        <label>Teacher Notes (Private)</label>
                        <textarea id="lessonNotes" name="notes" rows="2"
                            placeholder="Teaching notes, preparation tips, reminders..."></textarea>
                        <span style="font-size: 0.7rem; color: var(--c-muted);">Only visible to you and other
                            teachers</span>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="form-actions">
                <a href="{{ route('teacher.lessons.index') }}" class="btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i> Save Lesson
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let selectedFile = null;
        let currentClassId = null;
        let currentSubjectId = null;

        // Load classes on page load
        document.addEventListener('DOMContentLoaded', function () {
            loadClasses();

            document.getElementById('showNewTopicBtn').addEventListener('click', function (e) {
                e.preventDefault();
                if (!currentClassId || !currentSubjectId) {
                    Swal.fire('Error', 'Please select a class and subject first.', 'error');
                    return;
                }
                document.getElementById('newTopicSection').style.display = 'none';
                this.style.display = 'none';
            });

            document.getElementById('hideNewTopicBtn').addEventListener('click', function (e) {
                e.preventDefault();
                document.getElementById('newTopicSection').style.display = 'none';
                document.getElementById('showNewTopicBtn').style.display = 'none';
                // Clear new topic fields
                document.getElementById('newTopicTitle').value = '';
                document.getElementById('newTopicTitleArabic').value = '';
                document.getElementById('newTopicObjectives').value = '';
                document.getElementById('newTopicDesc').value = '';
            });
        });

        // Load classes from database
        async function loadClasses() {
            try {
                const response = await fetch('/teacher/lessons/classes/list');

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('Classes loaded:', data); // Debug log

                const classSelect = document.getElementById('classSelect');
                classSelect.innerHTML = '<option value="">-- Select a class --</option>';

                if (data.classes && data.classes.length > 0) {
                    data.classes.forEach(cls => {
                        const option = document.createElement('option');
                        option.value = cls.id;
                        // Display class name with level and section info
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
                Swal.fire('Error', 'Failed to load classes. Please refresh the page.\n\n' + error.message, 'error');

                // Show fallback message
                const classSelect = document.getElementById('classSelect');
                classSelect.innerHTML = '<option value="" disabled>Error loading classes. Please refresh.</option>';
                classSelect.disabled = true;
            }
        }

        // Load subjects for selected class
        document.getElementById('classSelect').addEventListener('change', async function () {
            const classId = this.value;
            currentClassId = classId;
            const subjectSelect = document.getElementById('subjectSelect');
            const topicSelect = document.getElementById('topicSelect');

            subjectSelect.innerHTML = '<option value="">Loading subjects...</option>';
            topicSelect.innerHTML = '<option value="">-- First select a class and subject --</option>';
            topicSelect.disabled = true;

            document.getElementById('newTopicSection').style.display = 'none';
            document.getElementById('showNewTopicBtn').style.display = 'none';

            if (!classId) {
                subjectSelect.innerHTML = '<option value="">-- First select a class --</option>';
                subjectSelect.disabled = true;
                return;
            }

            try {
                const response = await fetch(`/teacher/lessons/classes/${classId}/subjects`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('Subjects loaded:', data); // Debug log

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
                    subjectSelect.innerHTML = '<option value="" disabled>-- No subjects assigned to this section --</option>';
                    subjectSelect.disabled = true;
                }
            } catch (error) {
                console.error('Error loading subjects:', error);
                subjectSelect.innerHTML = '<option value="" disabled>Error loading subjects</option>';
                subjectSelect.disabled = true;
                Swal.fire('Error', 'Failed to load subjects for this class.', 'error');
            }
        });

        // Load topics for selected subject
        document.getElementById('subjectSelect').addEventListener('change', async function () {
            const subjectId = this.value;
            currentSubjectId = subjectId;
            const topicSelect = document.getElementById('topicSelect');

            topicSelect.innerHTML = '<option value="">Loading topics...</option>';
            topicSelect.disabled = true;

            document.getElementById('newTopicSection').style.display = 'none';
            document.getElementById('showNewTopicBtn').style.display = 'none';

            if (!subjectId || !currentClassId) {
                topicSelect.innerHTML = '<option value="">-- First select a class and subject --</option>';
                return;
            }

            try {
                const response = await fetch(`/teacher/lessons/classes/${currentClassId}/subjects/${subjectId}/topics`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('Topics loaded:', data); // Debug log

                topicSelect.innerHTML = '<option value="">-- Select a topic --</option>';

                if (data.topics && data.topics.length > 0) {
                    data.topics.forEach(topic => {
                        const option = document.createElement('option');
                        option.value = topic.id;
                        option.textContent = topic.title;
                        if (topic.title_arabic) {
                            option.textContent += ` (${topic.title_arabic})`;
                        }
                        topicSelect.appendChild(option);
                    });
                    document.getElementById('showNewTopicBtn').style.display = 'none';
                    topicSelect.disabled = false;
                } else {
                    topicSelect.innerHTML += '<option value="" disabled>-- No topics yet. Click Settings Module to add new topic --</option>';
                    document.getElementById('newTopicSection').style.display = 'none';
                    document.getElementById('showNewTopicBtn').style.display = 'none';
                    topicSelect.disabled = false;
                }
            } catch (error) {
                console.error('Error loading topics:', error);
                topicSelect.innerHTML = '<option value="" disabled>Error loading topics</option>';
                Swal.fire('Error', 'Failed to load topics for this subject.', 'error');
            }
        });

        // File upload handling
        document.getElementById('lessonFile').addEventListener('change', function () {
            if (this.files && this.files[0]) {
                selectedFile = this.files[0];
                if (selectedFile.size > 50 * 1024 * 1024) {
                    Swal.fire('Error', 'File size exceeds 50MB limit', 'error');
                    this.value = '';
                    selectedFile = null;
                    document.getElementById('fileInfo').style.display = 'none';
                    return;
                }
                const fileSizeMB = (selectedFile.size / (1024 * 1024)).toFixed(2);
                document.getElementById('fileName').textContent = `${selectedFile.name} (${fileSizeMB} MB)`;
                document.getElementById('fileInfo').style.display = 'block';
                document.getElementById('fileError').style.display = 'none';
            }
        });

        function clearFile() {
            selectedFile = null;
            document.getElementById('lessonFile').value = '';
            document.getElementById('fileInfo').style.display = 'none';
        }

        // Form submission
        document.getElementById('addLessonForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            if (!selectedFile) {
                document.getElementById('fileError').style.display = 'block';
                Swal.fire('Error', 'Please upload a lesson file.', 'error');
                return;
            }

            const lessonTitle = document.getElementById('lessonTitle').value.trim();
            if (!lessonTitle) {
                Swal.fire('Error', 'Please enter a lesson title.', 'error');
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            submitBtn.disabled = true;

            const formData = new FormData();

            const newTopicTitle = document.getElementById('newTopicTitle').value.trim();
            const topicSelectValue = document.getElementById('topicSelect').value;

            // Handle topic selection or creation
            if (newTopicTitle && !topicSelectValue) {
                formData.append('create_new_topic', '1');
                formData.append('new_topic_title', newTopicTitle);
                formData.append('new_topic_title_arabic', document.getElementById('newTopicTitleArabic').value);
                formData.append('new_topic_learning_objectives', document.getElementById('newTopicObjectives').value);
                formData.append('new_topic_description', document.getElementById('newTopicDesc').value);
                formData.append('class_id', currentClassId);
                formData.append('subject_id', currentSubjectId);
            } else {
                if (!topicSelectValue) {
                    Swal.fire('Error', 'Please select a topic or create a new one.', 'error');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    return;
                }
                formData.append('topic_id', topicSelectValue);
            }

            // Lesson data
            formData.append('title', lessonTitle);
            formData.append('title_arabic', document.getElementById('lessonTitleArabic').value);
            formData.append('lesson_type', document.getElementById('lessonType').value);
            formData.append('description', document.getElementById('lessonDesc').value);
            formData.append('notes', document.getElementById('lessonNotes').value);
            formData.append('duration', document.getElementById('lessonDuration').value || '');
            formData.append('lesson_amount', document.getElementById('lessonAmount').value || '');
            formData.append('lesson_order', document.getElementById('lessonOrder').value || '');
            formData.append('status', document.getElementById('lessonStatus').value);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('lesson_file', selectedFile);

            try {
                const response = await fetch('/teacher/lessons/store', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Lesson created successfully!',
                        icon: 'success',
                        confirmButtonText: 'View Lesson'
                    }).then((result) => {
                        if (result.isConfirmed && data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.href = '/teacher/lessons';
                        }
                    });
                } else {
                    if (data.errors) {
                        const errorMessages = Object.values(data.errors).flat().join('\n');
                        Swal.fire('Validation Error', errorMessages, 'error');
                    } else {
                        Swal.fire('Error', data.message || 'Failed to create lesson.', 'error');
                    }
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }

            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to create lesson. Please check your connection.', 'error');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        window.clearFile = clearFile;
    </script>
@endsection