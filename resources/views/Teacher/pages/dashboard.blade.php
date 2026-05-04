@extends('Teacher.layouts.teacher-master')

@section('title', 'Teacher Dashboard')
@section('page-title', 'My Teaching Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<style>
    :root {
        --gradient-start: #6B46C1;
        --gradient-end: #9F7AEA;
        --purple: #6B46C1;
        --purple-light: #9F7AEA;
        --ink: #1A202C;
        --ink-light: #4A5568;
        --muted: #718096;
        --cream: #F7FAFC;
        --cream2: #EDF2F7;
        --border: #E2E8F0;
        --red: #E53E3E;
        --green: #38A169;
        --yellow: #D69E2E;
        --blue: #3182CE;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: 1px solid var(--border);
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 70, 193, 0.15);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
    }
    
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 4px;
    }
    
    .stat-label {
        font-size: 14px;
        color: var(--muted);
    }
    
    .hierarchy-tree {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--border);
        overflow: hidden;
    }
    
    .section-item {
        border-bottom: 1px solid var(--border);
    }
    
    .section-header {
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        color: white;
        padding: 20px 24px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .section-header:hover {
        background: linear-gradient(135deg, var(--gradient-end), var(--gradient-start));
    }
    
    .level-item {
        background: var(--cream);
        border-bottom: 1px solid var(--border);
        padding: 16px 24px 16px 40px;
    }
    
    .level-header {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        font-weight: 600;
        color: var(--ink);
    }
    
    .class-item {
        background: white;
        border-bottom: 1px solid var(--border);
        padding: 12px 24px 12px 60px;
    }
    
    .class-header {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        font-weight: 500;
        color: var(--ink-light);
    }
    
    .subject-item {
        background: var(--cream2);
        border-bottom: 1px solid var(--border);
        padding: 12px 24px 12px 80px;
    }
    
    .subject-header {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        font-weight: 500;
    }
    
    .topic-item {
        background: white;
        border-bottom: 1px solid var(--border);
        padding: 12px 24px 12px 100px;
    }
    
    .lesson-item {
        background: var(--cream);
        margin-left: 120px;
        padding: 12px 20px;
        border-left: 3px solid var(--purple);
        margin-bottom: 8px;
        border-radius: 8px;
    }
    
    .resource-item {
        background: #F7FAFC;
        margin-left: 140px;
        padding: 8px 16px;
        border-left: 2px solid var(--blue);
        margin-top: 4px;
        margin-bottom: 4px;
        border-radius: 6px;
        font-size: 13px;
    }
    
    .toggle-icon {
        transition: transform 0.2s ease;
        width: 20px;
    }
    
    .toggle-icon.collapsed {
        transform: rotate(-90deg);
    }
    
    .content-wrapper {
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    
    .content-wrapper.collapsed {
        display: none;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 12px;
    }
    
    .badge-draft {
        background: #FEF5E7;
        color: var(--yellow);
    }
    
    .badge-published {
        background: #E6F7E6;
        color: var(--green);
    }
    
    .badge-video {
        background: #E3F2FD;
        color: var(--blue);
    }
    
    .badge-pdf {
        background: #FFE4E1;
        color: var(--red);
    }
    
    .btn-view {
        background: transparent;
        border: 1px solid var(--purple);
        color: var(--purple);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-view:hover {
        background: var(--purple);
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px;
        color: var(--muted);
    }
    
    .progress-bar {
        width: 100%;
        height: 4px;
        background: var(--border);
        border-radius: 2px;
        overflow: hidden;
        margin-top: 8px;
    }
    
    .progress-fill {
        height: 100%;
        background: var(--green);
        transition: width 0.3s ease;
    }
</style>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #E9D8FD; color: var(--purple);">
            <i class="fas fa-chalkboard"></i>
        </div>
        <div class="stat-value" id="totalClasses">0</div>
        <div class="stat-label">My Classes</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #FEEBC8; color: var(--yellow);">
            <i class="fas fa-book"></i>
        </div>
        <div class="stat-value" id="totalSubjects">0</div>
        <div class="stat-label">Subjects Teaching</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #C6F6D5; color: var(--green);">
            <i class="fas fa-layer-group"></i>
        </div>
        <div class="stat-value" id="totalTopics">0</div>
        <div class="stat-label">Topics Created</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #FEEBC8; color: var(--red);">
            <i class="fas fa-video"></i>
        </div>
        <div class="stat-value" id="totalLessons">0</div>
        <div class="stat-label">Lessons Created</div>
    </div>
</div>

<div class="hierarchy-tree">
    <div style="padding: 20px 24px; background: white; border-bottom: 1px solid var(--border);">
        <h3 style="font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 600; color: var(--ink); margin: 0;">
            <i class="fas fa-tree" style="color: var(--purple); margin-right: 8px;"></i>
            Curriculum Hierarchy
        </h3>
        <p style="color: var(--muted); font-size: 0.85rem; margin: 4px 0 0 0;">Sections → Levels → Classes → Subjects → Topics → Lessons → Resources</p>
    </div>
    
    <div id="hierarchyContent">
        <div class="empty-state">
            <i class="fas fa-spinner fa-spin fa-2x" style="color: var(--purple); margin-bottom: 16px;"></i>
            <p>Loading your teaching data...</p>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    let allData = null;
    
    document.addEventListener('DOMContentLoaded', function() {
        loadDashboardData();
    });
    
    async function loadDashboardData() {
        try {
            const response = await fetch('/teacher/dashboard-data', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (!response.ok) {
                throw new Error('Failed to load data');
            }
            
            const data = await response.json();
            allData = data;
            updateStats(data);
            renderHierarchy(data);
        } catch (error) {
            console.error('Error loading dashboard data:', error);
            document.getElementById('hierarchyContent').innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-exclamation-triangle fa-2x" style="color: var(--red); margin-bottom: 16px;"></i>
                    <p>Failed to load dashboard data. Please refresh the page.</p>
                </div>
            `;
        }
    }
    
    function updateStats(data) {
        document.getElementById('totalClasses').textContent = data.stats.total_classes || 0;
        document.getElementById('totalSubjects').textContent = data.stats.total_subjects || 0;
        document.getElementById('totalTopics').textContent = data.stats.total_topics || 0;
        document.getElementById('totalLessons').textContent = data.stats.total_lessons || 0;
    }
    
    function renderHierarchy(data) {
        const container = document.getElementById('hierarchyContent');
        
        if (!data.sections || data.sections.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-folder-open fa-2x" style="color: var(--muted); margin-bottom: 16px;"></i>
                    <p>No teaching data found. Start by creating lessons!</p>
                    <a href="{{ route('teacher.lessons.create') }}" class="btn-save" style="display: inline-block; margin-top: 16px; padding: 10px 24px;">
                        <i class="fas fa-plus"></i> Create First Lesson
                    </a>
                </div>
            `;
            return;
        }
        
        let html = '';
        
        data.sections.forEach(section => {
            html += `
                <div class="section-item">
                    <div class="section-header" onclick="toggleSection(${section.id})">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <i class="fas fa-chevron-down toggle-icon" id="section-icon-${section.id}"></i>
                                <i class="fas fa-building"></i>
                                <strong style="font-size: 1.1rem;">${escapeHtml(section.name)}</strong>
                                <span class="badge" style="background: rgba(255,255,255,0.2);">${section.code || ''}</span>
                            </div>
                            <div style="display: flex; gap: 8px;">
                                <span class="badge" style="background: rgba(255,255,255,0.2);">
                                    <i class="fas fa-layer-group"></i> ${section.levels_count || 0} Levels
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="content-wrapper" id="section-content-${section.id}">
                        ${renderLevels(section.levels)}
                    </div>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }
    
    function renderLevels(levels) {
        if (!levels || levels.length === 0) return '<div style="padding: 20px; text-align: center; color: var(--muted);">No levels found</div>';
        
        let html = '';
        levels.forEach(level => {
            html += `
                <div class="level-item">
                    <div class="level-header" onclick="toggleLevel(${level.id})">
                        <i class="fas fa-chevron-down toggle-icon" id="level-icon-${level.id}"></i>
                        <i class="fas fa-graduation-cap"></i>
                        <span>${escapeHtml(level.name)}</span>
                        <span class="badge" style="background: #E2E8F0; color: #4A5568;">${level.code || ''}</span>
                        <span class="badge" style="background: #C6F6D5; color: var(--green);">
                            <i class="fas fa-chalkboard"></i> ${level.classes_count || 0} Classes
                        </span>
                    </div>
                    <div class="content-wrapper" id="level-content-${level.id}">
                        ${renderClasses(level.classes)}
                    </div>
                </div>
            `;
        });
        return html;
    }
    
    function renderClasses(classes) {
        if (!classes || classes.length === 0) return '<div style="padding: 20px; text-align: center; color: var(--muted);">No classes found</div>';
        
        let html = '';
        classes.forEach(cls => {
            html += `
                <div class="class-item">
                    <div class="class-header" onclick="toggleClass(${cls.id})">
                        <i class="fas fa-chevron-down toggle-icon" id="class-icon-${cls.id}"></i>
                        <i class="fas fa-users"></i>
                        <span>${escapeHtml(cls.name)}</span>
                        <span class="badge" style="background: #FEEBC8; color: var(--yellow);">
                            <i class="fas fa-book"></i> ${cls.subjects_count || 0} Subjects
                        </span>
                    </div>
                    <div class="content-wrapper" id="class-content-${cls.id}">
                        ${renderSubjects(cls.subjects)}
                    </div>
                </div>
            `;
        });
        return html;
    }
    
    function renderSubjects(subjects) {
        if (!subjects || subjects.length === 0) return '<div style="padding: 20px; text-align: center; color: var(--muted);">No subjects assigned</div>';
        
        let html = '';
        subjects.forEach(subject => {
            html += `
                <div class="subject-item">
                    <div class="subject-header" onclick="toggleSubject(${subject.id})">
                        <i class="fas fa-chevron-down toggle-icon" id="subject-icon-${subject.id}"></i>
                        <i class="fas fa-book-open"></i>
                        <span>${escapeHtml(subject.name)}</span>
                        <span class="badge" style="background: #E3F2FD; color: var(--blue);">
                            <i class="fas fa-layer-group"></i> ${subject.topics_count || 0} Topics
                        </span>
                        <span class="badge" style="background: #E6F7E6; color: var(--green);">
                            <i class="fas fa-video"></i> ${subject.lessons_count || 0} Lessons
                        </span>
                    </div>
                    <div class="content-wrapper" id="subject-content-${subject.id}">
                        ${renderTopics(subject.topics)}
                    </div>
                </div>
            `;
        });
        return html;
    }
    
    function renderTopics(topics) {
        if (!topics || topics.length === 0) return '<div style="padding: 20px; text-align: center; color: var(--muted);">No topics created yet</div>';
        
        let html = '';
        topics.forEach(topic => {
            const progress = topic.progress || 0;
            html += `
                <div class="topic-item">
                    <div class="topic-header" onclick="toggleTopic(${topic.id})" style="display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="fas fa-chevron-down toggle-icon" id="topic-icon-${topic.id}"></i>
                            <i class="fas fa-folder"></i>
                            <div>
                                <div style="font-weight: 500;">${escapeHtml(topic.title)}</div>
                                ${topic.title_arabic ? `<div style="font-size: 12px; color: var(--muted);">${escapeHtml(topic.title_arabic)}</div>` : ''}
                            </div>
                            <span class="badge ${topic.status === 'published' ? 'badge-published' : 'badge-draft'}">
                                ${topic.status === 'published' ? '✓ Published' : '📝 Draft'}
                            </span>
                            <span class="badge" style="background: #E3F2FD; color: var(--blue);">
                                <i class="fas fa-video"></i> ${topic.lessons_count || 0} Lessons
                            </span>
                        </div>
                        <div style="width: 150px;">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${progress}%"></div>
                            </div>
                            <div style="font-size: 11px; text-align: center; margin-top: 4px;">${progress}% Complete</div>
                        </div>
                    </div>
                    <div class="content-wrapper" id="topic-content-${topic.id}">
                        ${renderLessons(topic.lessons)}
                    </div>
                </div>
            `;
        });
        return html;
    }
    
    function renderLessons(lessons) {
        if (!lessons || lessons.length === 0) return '<div style="padding: 20px; text-align: center; color: var(--muted);">No lessons created yet</div>';
        
        let html = '';
        lessons.forEach(lesson => {
            html += `
                <div class="lesson-item">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                            <i class="fas fa-${lesson.lesson_type === 'video' ? 'video' : lesson.lesson_type === 'audio' ? 'music' : lesson.lesson_type === 'pdf' ? 'file-pdf' : 'file-alt'}"></i>
                            <div>
                                <div style="font-weight: 500;">${escapeHtml(lesson.title)}</div>
                                <div style="font-size: 12px; color: var(--muted);">
                                    ${lesson.lesson_type} • ${lesson.duration || 'N/A'} min • Order: ${lesson.lesson_order || 0}
                                </div>
                            </div>
                            <span class="badge ${lesson.status === 'published' ? 'badge-published' : 'badge-draft'}">
                                ${lesson.status === 'published' ? 'Published' : 'Draft'}
                            </span>
                            <span class="badge badge-${lesson.lesson_type}">
                                ${lesson.lesson_type}
                            </span>
                        </div>
                        <div>
                            <button class="btn-view" onclick="viewLesson(${lesson.id})">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="btn-view" onclick="editLesson(${lesson.id})" style="background: var(--purple); color: white;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    ${lesson.resources && lesson.resources.length > 0 ? renderResources(lesson.resources) : ''}
                </div>
            `;
        });
        return html;
    }
    
    function renderResources(resources) {
        if (!resources || resources.length === 0) return '';
        
        let html = '';
        resources.forEach(resource => {
            html += `
                <div class="resource-item">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-paperclip"></i>
                        <span style="font-size: 13px;">${escapeHtml(resource.title)}</span>
                        <span class="badge" style="background: #E2E8F0; font-size: 10px;">${resource.type}</span>
                        ${resource.file_size ? `<span style="font-size: 11px; color: var(--muted);">${formatFileSize(resource.file_size)}</span>` : ''}
                        <a href="/storage/${resource.file_path}" target="_blank" class="btn-view" style="margin-left: auto; padding: 2px 8px;">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            `;
        });
        return html;
    }
    
    // Toggle functions
    function toggleSection(sectionId) {
        toggleContent('section', sectionId);
    }
    
    function toggleLevel(levelId) {
        toggleContent('level', levelId);
    }
    
    function toggleClass(classId) {
        toggleContent('class', classId);
    }
    
    function toggleSubject(subjectId) {
        toggleContent('subject', subjectId);
    }
    
    function toggleTopic(topicId) {
        toggleContent('topic', topicId);
    }
    
    function toggleContent(type, id) {
        const content = document.getElementById(`${type}-content-${id}`);
        const icon = document.getElementById(`${type}-icon-${id}`);
        
        if (content.classList.contains('collapsed')) {
            content.classList.remove('collapsed');
            icon.classList.remove('collapsed');
        } else {
            content.classList.add('collapsed');
            icon.classList.add('collapsed');
        }
    }
    
    function viewLesson(lessonId) {
        window.location.href = `/teacher/lessons/${lessonId}`;
    }
    
    function editLesson(lessonId) {
        window.location.href = `/teacher/lessons/${lessonId}/edit`;
    }
    
    function formatFileSize(bytes) {
        if (!bytes) return '';
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(1024));
        return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
@endsection