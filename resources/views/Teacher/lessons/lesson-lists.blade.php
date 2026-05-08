@extends('Teacher.layouts.teacher-master')

@section('title', 'My Lessons')
@section('page-title', 'My Lessons')
@section('breadcrumb', 'Lessons')

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

    .ls-lessons-wrap {
        width: 100%;
        font-family: 'DM Sans', sans-serif;
        color: var(--c-ink);
    }

    /* Page Header */
    .ls-page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .ls-page-eyebrow {
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--c-accent);
        margin-bottom: 6px;
    }

    .ls-page-title {
        font-family: 'DM Serif Display', Georgia, serif;
        font-size: 2rem;
        font-weight: 400;
        color: var(--c-ink);
        line-height: 1.15;
        margin: 0;
    }

    .ls-page-title em {
        font-style: italic;
        color: var(--c-accent);
    }

    .ls-page-subtitle {
        margin-top: 6px;
        font-size: .83rem;
        color: var(--c-muted);
        font-weight: 400;
    }

    /* Stats Grid */
    .ls-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }

    .ls-stat-card {
        background: var(--c-surface);
        border: 1.5px solid var(--c-border);
        border-radius: var(--radius-lg);
        padding: 20px;
        transition: all .22s ease;
        cursor: default;
    }

    .ls-stat-card:hover {
        transform: translateY(-2px);
        border-color: var(--c-accent);
        box-shadow: var(--shadow-md);
    }

    .ls-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 16px;
    }

    .ls-stat-number {
        font-family: 'DM Serif Display', serif;
        font-size: 1.8rem;
        font-weight: 400;
        color: var(--c-ink);
        line-height: 1.1;
    }

    .ls-stat-label {
        font-size: .73rem;
        font-weight: 600;
        color: var(--c-muted);
        margin-top: 6px;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    /* Search Box */
    .ls-search-box {
        position: relative;
        margin-bottom: 32px;
        max-width: 500px;
    }

    .ls-search-box input {
        width: 100%;
        padding: 12px 20px 12px 48px;
        border: 1.5px solid var(--c-border);
        border-radius: var(--radius-pill);
        font-size: .84rem;
        font-family: 'DM Sans', sans-serif;
        background: var(--c-surface);
        transition: all .2s;
    }

    .ls-search-box input:focus {
        outline: none;
        border-color: var(--c-accent);
        box-shadow: 0 0 0 3px rgba(91, 63, 217, .13);
    }

    .ls-search-box i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--c-muted);
    }

    /* Class Grid - 3 Columns */
    .ls-class-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
        margin-top: 16px;
    }

    /* Class Card */
    .ls-class-card {
        background: var(--c-surface);
        border: 1.5px solid var(--c-border);
        border-radius: var(--radius-xl);
        overflow: hidden;
        transition: all .25s ease;
        height: fit-content;
        display: flex;
        flex-direction: column;
        box-shadow: var(--shadow-sm);
    }

    .ls-class-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-3px);
    }

    /* Class Header */
    .ls-class-header {
        background: var(--gradient);
        padding: 20px;
        cursor: pointer;
        transition: all .2s ease;
    }

    .ls-class-header:hover {
        background: linear-gradient(135deg, #4930C2 0%, #7C3AED 100%);
    }

    .ls-class-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .ls-class-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .ls-class-icon {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }

    .ls-class-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .ls-class-name {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        color: white;
    }

    .ls-class-level {
        font-size: .7rem;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 4px;
        color: white;
    }

    .ls-class-header-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .ls-subjects-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 4px 10px;
        border-radius: var(--radius-pill);
        font-size: .7rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        color: white;
    }

    .ls-chevron-icon {
        font-size: .85rem;
        transition: transform .25s ease;
        transform: rotate(-90deg);
        color: white;
    }

    /* Class Content */
    .ls-class-content {
        display: none;
        background: var(--c-surface2);
        padding: 8px 0 16px 0;
        max-height: 70vh;
        overflow-y: auto;
    }

    /* Custom scrollbar */
    .ls-class-content::-webkit-scrollbar {
        width: 5px;
    }

    .ls-class-content::-webkit-scrollbar-track {
        background: var(--c-border);
        border-radius: 10px;
    }

    .ls-class-content::-webkit-scrollbar-thumb {
        background: var(--c-accent);
        border-radius: 10px;
    }

    /* Subject Section */
    .ls-subject-section {
        border: 1px solid var(--c-border);
        background: var(--c-surface);
        margin: 8px 12px;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .ls-subject-header {
        padding: 12px 16px;
        background: var(--c-surface);
        cursor: pointer;
        transition: all .2s ease;
        border-left: 3px solid var(--c-accent);
    }

    .ls-subject-header:hover {
        background: var(--c-accent-lt);
    }

    .ls-subject-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .ls-subject-name {
        font-weight: 600;
        color: var(--c-ink);
        font-size: .85rem;
    }

    .ls-subject-code {
        font-size: .65rem;
        color: var(--c-muted);
    }

    .ls-subject-badge {
        background: var(--c-accent-lt);
        color: var(--c-accent);
        padding: 3px 10px;
        border-radius: var(--radius-pill);
        font-size: .65rem;
        font-weight: 600;
    }

    /* Subject Content */
    .ls-subject-content {
        display: none;
        background: var(--c-surface2);
        padding: 12px;
        border-top: 1px solid var(--c-border);
    }

    /* Topic Section */
    .ls-topic-section {
        padding: 12px;
        margin-bottom: 12px;
        background: var(--c-surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--c-border);
    }

    .ls-topic-title {
        font-weight: 700;
        color: var(--c-ink);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        font-size: .85rem;
        padding-left: 4px;
    }

    .ls-topic-badge {
        background: var(--c-surface2);
        color: var(--c-muted);
        padding: 2px 8px;
        border-radius: var(--radius-pill);
        font-size: .65rem;
    }

    .ls-topic-description {
        font-size: .7rem;
        color: var(--c-muted);
        margin-bottom: 12px;
        padding-left: 4px;
    }

    /* Lesson Item */
    .ls-lesson-item {
        padding: 12px;
        margin-bottom: 8px;
        background: var(--c-surface2);
        border-radius: var(--radius-lg);
        border: 1px solid var(--c-border);
        transition: all .2s ease;
        cursor: pointer;
    }

    .ls-lesson-item:hover {
        background: var(--c-surface);
        border-color: var(--c-accent);
        transform: translateX(4px);
        box-shadow: var(--shadow-sm);
    }

    .ls-lesson-main {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .ls-lesson-icon {
        width: 36px;
        height: 36px;
        background: var(--c-accent-lt);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--c-accent);
        font-size: .9rem;
        flex-shrink: 0;
    }

    .ls-lesson-details {
        flex: 1;
    }

    .ls-lesson-title {
        font-weight: 600;
        color: var(--c-ink);
        margin-bottom: 6px;
        font-size: .85rem;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .ls-lesson-lock {
        color: var(--c-red);
        font-size: .7rem;
    }

    .ls-lesson-meta {
        display: flex;
        gap: 12px;
        font-size: .65rem;
        color: var(--c-muted);
        flex-wrap: wrap;
    }

    .ls-lesson-meta-item {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .ls-lesson-footer {
        margin-top: 10px;
        padding-top: 8px;
        border-top: 1px dashed var(--c-border);
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }

    .ls-lesson-price {
        display: flex;
        align-items: center;
        gap: 6px;
        background: var(--c-accent-lt);
        padding: 4px 10px;
        border-radius: var(--radius-pill);
        font-size: .7rem;
        font-weight: 600;
        color: var(--c-accent);
    }

    .ls-lesson-payment-status {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: var(--radius-pill);
        font-size: .65rem;
        font-weight: 600;
    }

    .ls-lesson-payment-status.paid {
        background: var(--c-green-lt);
        color: var(--c-emerald);
    }

    .ls-lesson-payment-status.not-paid {
        background: var(--c-red-lt);
        color: var(--c-red);
    }

    /* Buttons */
    .btn-primary-custom {
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

    .btn-primary-custom:hover {
        background: #4930C2;
        box-shadow: 0 6px 20px rgba(91, 63, 217, .32);
        transform: translateY(-1px);
        color: white;
    }

    /* Empty State */
    .ls-empty-state {
        text-align: center;
        padding: 72px 40px;
        background: var(--c-surface);
        border-radius: var(--radius-xl);
        border: 1.5px solid var(--c-border);
    }

    .ls-empty-ring {
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

    /* Payment Modal */
    .ls-payment-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .ls-payment-modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(26, 22, 40, .6);
        backdrop-filter: blur(4px);
    }

    .ls-payment-modal-content {
        position: relative;
        background: var(--c-surface);
        border-radius: var(--radius-xl);
        width: 90%;
        max-width: 480px;
        box-shadow: var(--shadow-lg);
        animation: modalSlideIn .3s ease-out;
        overflow: hidden;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-30px) scale(.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .ls-payment-modal-header {
        background: var(--gradient);
        color: white;
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .ls-payment-modal-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .ls-close-modal {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .3s;
    }

    .ls-close-modal:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .ls-payment-modal-body {
        padding: 24px;
    }

    .ls-lesson-info-section {
        text-align: center;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--c-border);
    }

    .ls-amount-display {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--c-surface2);
        padding: 12px 20px;
        border-radius: var(--radius-lg);
        margin-top: 12px;
    }

    .ls-amount-label {
        color: var(--c-muted);
        font-size: .8rem;
    }

    .ls-amount-value {
        color: var(--c-accent);
        font-weight: 700;
        font-size: 1.2rem;
    }

    .ls-payment-methods-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }

    .ls-payment-method-card {
        background: var(--c-surface2);
        border: 2px solid var(--c-border);
        border-radius: var(--radius-lg);
        padding: 16px 12px;
        text-align: center;
        cursor: pointer;
        transition: all .3s;
        position: relative;
    }

    .ls-payment-method-card:hover {
        border-color: var(--c-accent);
        background: var(--c-accent-lt);
        transform: translateY(-2px);
    }

    .ls-payment-method-card.selected {
        border-color: var(--c-accent);
        background: var(--c-accent-lt);
    }

    .ls-method-icon {
        font-size: 1.3rem;
        color: var(--c-accent);
        margin-bottom: 8px;
    }

    .ls-selected-indicator {
        position: absolute;
        top: 8px;
        right: 8px;
        color: var(--c-accent);
        font-size: 1rem;
        display: none;
    }

    .ls-payment-method-card.selected .ls-selected-indicator {
        display: block;
    }

    .ls-payment-amount-input {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid var(--c-border);
        border-radius: var(--radius-lg);
        font-size: .9rem;
        font-family: 'DM Sans', sans-serif;
        transition: all .3s;
    }

    .ls-payment-amount-input:focus {
        outline: none;
        border-color: var(--c-accent);
        box-shadow: 0 0 0 3px rgba(91, 63, 217, .13);
    }

    .ls-payment-modal-footer {
        padding: 20px 24px;
        background: var(--c-surface2);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        border-top: 1px solid var(--c-border);
    }

    .btn-cancel-custom {
        padding: 8px 20px;
        border: 1.5px solid var(--c-border);
        background: var(--c-surface);
        color: var(--c-muted);
        border-radius: var(--radius-pill);
        cursor: pointer;
        font-weight: 600;
        font-size: .75rem;
        transition: all .3s;
    }

    .btn-cancel-custom:hover {
        background: var(--c-red-lt);
        border-color: var(--c-red);
        color: var(--c-red);
    }

    .btn-confirm-custom {
        padding: 8px 24px;
        background: var(--c-accent);
        border: none;
        color: white;
        border-radius: var(--radius-pill);
        cursor: pointer;
        font-weight: 600;
        font-size: .75rem;
        transition: all .3s;
    }

    .btn-confirm-custom:hover {
        background: #4930C2;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(91, 63, 217, .3);
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .ls-class-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
    }

    @media (max-width: 768px) {
        .ls-page-title {
            font-size: 1.5rem;
        }

        .ls-stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .ls-class-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .ls-payment-methods-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="ls-lessons-wrap">
    {{-- Page Header --}}
    <div class="ls-page-header">
        <div>
            <div class="ls-page-eyebrow"><i class="fas fa-book-open"></i> Content Management</div>
            <h1 class="ls-page-title">My <em>Lessons</em></h1>
            <div class="ls-page-subtitle">Manage and organize all your lesson content</div>
        </div>
        <a href="{{ route('teacher.lessons.create') }}" class="btn-primary-custom">
            <i class="fas fa-plus-circle"></i> Create New Lesson
        </a>
    </div>

    {{-- Search Box --}}
    <div class="ls-search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Search lessons by title, class, subject, or topic...">
    </div>

    {{-- Stats Grid --}}
    <div class="ls-stats-grid">
        <div class="ls-stat-card">
            <div class="ls-stat-icon" style="background: var(--c-accent-lt); color: var(--c-accent);">
                <i class="fas fa-book"></i>
            </div>
            <div class="ls-stat-number">{{ $totalLessons ?? 0 }}</div>
            <div class="ls-stat-label">Total Lessons</div>
        </div>
        <div class="ls-stat-card">
            <div class="ls-stat-icon" style="background: var(--c-green-lt); color: var(--c-emerald);">
                <i class="fas fa-globe"></i>
            </div>
            <div class="ls-stat-number">{{ $publishedLessons ?? 0 }}</div>
            <div class="ls-stat-label">Published</div>
        </div>
        <div class="ls-stat-card">
            <div class="ls-stat-icon" style="background: var(--c-gold-lt); color: var(--c-gold);">
                <i class="fas fa-pen-fancy"></i>
            </div>
            <div class="ls-stat-number">{{ $draftLessons ?? 0 }}</div>
            <div class="ls-stat-label">Drafts</div>
        </div>
        <div class="ls-stat-card">
            <div class="ls-stat-icon" style="background: var(--c-blue-lt); color: var(--c-blue);">
                <i class="fas fa-chalkboard"></i>
            </div>
            <div class="ls-stat-number">{{ count($groupedLessons ?? []) }}</div>
            <div class="ls-stat-label">Classes</div>
        </div>
    </div>

    {{-- Class Grid --}}
    @if (isset($groupedLessons) && count($groupedLessons) > 0)
        <div id="classGridContainer" class="ls-class-grid">
            @foreach ($groupedLessons as $className => $classData)
                <div class="ls-class-card" data-classname="{{ strtolower($className) }}">
                    <div class="ls-class-header" onclick="toggleClass(this)">
                        <div class="ls-class-header-content">
                            <div class="ls-class-header-left">
                                <div class="ls-class-icon">
                                    <i class="fas fa-chalkboard"></i>
                                </div>
                                <div class="ls-class-info">
                                    <h3 class="ls-class-name">{{ $className }}</h3>
                                    @if (isset($classData['level']) && $classData['level'])
                                        <span class="ls-class-level">
                                            <i class="fas fa-graduation-cap"></i>
                                            {{ $classData['level'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="ls-class-header-right">
                                <span class="ls-subjects-badge">
                                    <i class="fas fa-book"></i>
                                    {{ count($classData['subjects']) }} Subjects
                                </span>
                                <i class="fas fa-chevron-down ls-chevron-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="ls-class-content" style="display: none;">
                        @foreach ($classData['subjects'] as $subjectName => $subjectData)
                            <div class="ls-subject-section">
                                <div class="ls-subject-header" onclick="toggleSubject(this)">
                                    <div class="ls-subject-header-content">
                                        <div>
                                            <i class="fas fa-book-open" style="color: var(--c-accent); margin-right: 8px;"></i>
                                            <span class="ls-subject-name">{{ $subjectName }}</span>
                                            @if (isset($subjectData['subject_code']) && $subjectData['subject_code'])
                                                <span class="ls-subject-code">({{ $subjectData['subject_code'] }})</span>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="ls-subject-badge">
                                                <i class="fas fa-layer-group"></i> {{ count($subjectData['topics']) }} Topics
                                            </span>
                                            <i class="fas fa-chevron-down" style="margin-left: 8px; font-size: .7rem;"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="ls-subject-content" style="display: none;">
                                    @foreach ($subjectData['topics'] as $topicName => $topicData)
                                        <div class="ls-topic-section">
                                            <div class="ls-topic-title">
                                                <i class="fas fa-folder-open" style="color: var(--c-accent);"></i>
                                                <span>{{ $topicName }}</span>
                                                <span class="ls-topic-badge">
                                                    <i class="fas fa-video"></i> {{ count($topicData['lessons']) }} Lessons
                                                </span>
                                            </div>
                                            @if (isset($topicData['topic_description']) && $topicData['topic_description'])
                                                <p class="ls-topic-description">
                                                    {{ Str::limit($topicData['topic_description'], 120) }}
                                                </p>
                                            @endif

                                            <div>
                                                @foreach ($topicData['lessons'] as $lesson)
                                                    <div class="ls-lesson-item"
                                                        onclick="{{ strtolower($lesson->lesson_payment_status) === 'paid' ? "window.location.href='" . route('teacher.lessons.show', $lesson) . "'" : "showPaymentModal({$lesson->id}, '{$lesson->title}', '{$lesson->lesson_amount}')" }}">
                                                        <div class="ls-lesson-main">
                                                            <div class="ls-lesson-icon">
                                                                <i class="fas fa-play-circle"></i>
                                                            </div>
                                                            <div class="ls-lesson-details">
                                                                <div class="ls-lesson-title">
                                                                    {{ $lesson->title }}
                                                                    @if (strtolower($lesson->lesson_payment_status) !== 'paid')
                                                                        <span class="ls-lesson-lock">
                                                                            <i class="fas fa-lock"></i> Locked
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="ls-lesson-meta">
                                                                    <div class="ls-lesson-meta-item">
                                                                        <i class="fas fa-hourglass-half"></i>
                                                                        <span>{{ $lesson->duration ?? 'N/A' }} min</span>
                                                                    </div>
                                                                    <div class="ls-lesson-meta-item">
                                                                        <i class="fas fa-sort-numeric-down"></i>
                                                                        <span>Lesson {{ $lesson->lesson_order }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ls-lesson-footer">
                                                            <div class="ls-lesson-price">
                                                                <i class="fas fa-money-bill-wave"></i>
                                                                <span>{{ $lesson->lesson_amount ? 'UGX ' . number_format((int) str_replace(',', '', $lesson->lesson_amount)) : 'Free' }}</span>
                                                            </div>
                                                            <div class="ls-lesson-payment-status {{ strtolower($lesson->lesson_payment_status) === 'paid' ? 'paid' : 'not-paid' }}">
                                                                <i class="fas {{ strtolower($lesson->lesson_payment_status) === 'paid' ? 'fa-check-circle' : 'fa-exclamation-triangle' }}"></i>
                                                                <span>{{ ucfirst($lesson->lesson_payment_status ?? 'Not Paid') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="ls-empty-state">
            <div class="ls-empty-ring">
                <i class="fas fa-book-open"></i>
            </div>
            <h3 style="font-size: 1.1rem; color: var(--c-ink); margin-bottom: 8px;">No Lessons Yet</h3>
            <p style="color: var(--c-muted); margin-bottom: 24px;">You haven't created any lessons. Start creating your first lesson!</p>
            <a href="{{ route('teacher.lessons.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus-circle"></i> Create Your First Lesson
            </a>
        </div>
    @endif
</div>

{{-- Payment Modal --}}
<div id="paymentModal" class="ls-payment-modal">
    <div class="ls-payment-modal-overlay" onclick="closePaymentModal()"></div>
    <div class="ls-payment-modal-content">
        <div class="ls-payment-modal-header">
            <h3><i class="fas fa-credit-card"></i> Complete Payment</h3>
            <button class="ls-close-modal" onclick="closePaymentModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="ls-payment-modal-body">
            <div class="ls-lesson-info-section">
                <h4 id="modalLessonTitle" style="font-size: 1rem;"></h4>
                <div class="ls-amount-display">
                    <span class="ls-amount-label">Amount Required:</span>
                    <span class="ls-amount-value" id="modalLessonAmount"></span>
                </div>
            </div>

            <h5 style="font-size: .8rem; margin-bottom: 12px; color: var(--c-ink);">Select Payment Method</h5>
            <div class="ls-payment-methods-grid">
                <div class="ls-payment-method-card" onclick="selectPaymentMethod('mtn')" id="mtnCard">
                    <div class="ls-method-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <span style="font-size: .75rem;">MTN Mobile Money</span>
                    <div class="ls-selected-indicator">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="ls-payment-method-card" onclick="selectPaymentMethod('airtel')" id="airtelCard">
                    <div class="ls-method-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <span style="font-size: .75rem;">Airtel Money</span>
                    <div class="ls-selected-indicator">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <div class="ls-payment-method-card" onclick="selectPaymentMethod('card')" id="cardCard">
                    <div class="ls-method-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <span style="font-size: .75rem;">Bank Card</span>
                    <div class="ls-selected-indicator">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>

            <div>
                <label style="font-size: .75rem; font-weight: 600; margin-bottom: 6px; display: block;">Enter Amount (UGX)</label>
                <input type="number" id="paymentAmount" class="ls-payment-amount-input" placeholder="Enter amount" min="0" step="1000">
                <small id="amountHint" style="font-size: .65rem; color: var(--c-muted); margin-top: 6px; display: block;"></small>
            </div>
        </div>

        <div class="ls-payment-modal-footer">
            <button class="btn-cancel-custom" onclick="closePaymentModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
            <button class="btn-confirm-custom" onclick="confirmPayment()">
                <i class="fas fa-check"></i> Confirm Payment
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let selectedPaymentMethod = null;
    let currentLessonId = null;
    let requiredAmount = null;

    function showPaymentModal(lessonId, lessonTitle, amount) {
        currentLessonId = lessonId;
        requiredAmount = parseInt(amount.replace(/[^0-9]/g, ''));

        document.getElementById('modalLessonTitle').textContent = lessonTitle;
        document.getElementById('modalLessonAmount').textContent = 'UGX ' + requiredAmount.toLocaleString();
        document.getElementById('paymentAmount').value = requiredAmount;
        document.getElementById('amountHint').textContent = `Minimum amount: UGX ${requiredAmount.toLocaleString()}`;

        selectedPaymentMethod = null;
        document.querySelectorAll('.ls-payment-method-card').forEach(card => {
            card.classList.remove('selected');
        });

        document.getElementById('paymentModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function selectPaymentMethod(method) {
        selectedPaymentMethod = method;
        document.querySelectorAll('.ls-payment-method-card').forEach(card => {
            card.classList.remove('selected');
        });
        document.getElementById(method + 'Card').classList.add('selected');
    }

    async function confirmPayment() {
        if (!selectedPaymentMethod) {
            Swal.fire({
                icon: 'warning',
                title: 'Payment Method Required',
                text: 'Please select a payment method to continue.',
                confirmButtonColor: '#5B3FD9'
            });
            return;
        }

        const enteredAmount = parseInt(document.getElementById('paymentAmount').value);

        if (!enteredAmount || enteredAmount <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Amount',
                text: 'Please enter a valid amount.',
                confirmButtonColor: '#5B3FD9'
            });
            return;
        }

        if (enteredAmount < requiredAmount) {
            Swal.fire({
                icon: 'error',
                title: 'Insufficient Amount',
                text: `The amount entered (UGX ${enteredAmount.toLocaleString()}) is less than the required amount (UGX ${requiredAmount.toLocaleString()}).`,
                confirmButtonColor: '#DC2626'
            });
            return;
        }

        const result = await Swal.fire({
            title: 'Confirm Payment',
            html: `
                <div style="text-align: left;">
                    <p><strong>Lesson:</strong> ${document.getElementById('modalLessonTitle').textContent}</p>
                    <p><strong>Payment Method:</strong> ${getPaymentMethodName(selectedPaymentMethod)}</p>
                    <p><strong>Amount:</strong> UGX ${enteredAmount.toLocaleString()}</p>
                    ${enteredAmount > requiredAmount ? `<p style="color: #D97706;"><i class="fas fa-info-circle"></i> Change: UGX ${(enteredAmount - requiredAmount).toLocaleString()}</p>` : ''}
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#5B3FD9',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Yes, Pay Now',
            cancelButtonText: 'Cancel'
        });

        if (result.isConfirmed) {
            Swal.fire({
                title: 'Processing Payment...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            try {
                const response = await fetch('{{ route("teacher.lessons.process-payment") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        lesson_id: currentLessonId,
                        amount: enteredAmount,
                        payment_method: selectedPaymentMethod,
                        required_amount: requiredAmount
                    })
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Successful!',
                        text: data.message || 'Your payment has been processed successfully.',
                        confirmButtonColor: '#5B3FD9'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: data.message || 'Something went wrong. Please try again.',
                        confirmButtonColor: '#DC2626'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your payment.',
                    confirmButtonColor: '#DC2626'
                });
            }
        }
    }

    function getPaymentMethodName(method) {
        const methods = {
            'mtn': 'MTN Mobile Money',
            'airtel': 'Airtel Money',
            'card': 'Bank Card'
        };
        return methods[method] || method;
    }

    // Toggle functions
    function toggleClass(element) {
        const parentCard = element.closest('.ls-class-card');
        const content = parentCard.querySelector('.ls-class-content');
        const icon = element.querySelector('.ls-chevron-icon');

        if (content.style.display === 'none' || !content.style.display || getComputedStyle(content).display === 'none') {
            content.style.display = 'block';
            if (icon) icon.style.transform = 'rotate(0deg)';
        } else {
            content.style.display = 'none';
            if (icon) icon.style.transform = 'rotate(-90deg)';
        }
    }

    function toggleSubject(element) {
        const subjectDiv = element.closest('.ls-subject-section');
        const content = subjectDiv.querySelector('.ls-subject-content');
        const icon = element.querySelector('.fa-chevron-down:last-child');

        if (content.style.display === 'none' || !content.style.display || getComputedStyle(content).display === 'none') {
            content.style.display = 'block';
            if (icon) icon.style.transform = 'rotate(0deg)';
        } else {
            content.style.display = 'none';
            if (icon) icon.style.transform = 'rotate(-90deg)';
        }
    }

    // Search functionality
    function initSearch() {
        const searchInput = document.getElementById('searchInput');
        if (!searchInput) return;

        searchInput.addEventListener('keyup', function() {
            const term = this.value.toLowerCase();
            const cards = document.querySelectorAll('.ls-class-card');

            cards.forEach(card => {
                const classAttr = card.getAttribute('data-classname') || '';
                const lessonsInside = card.querySelectorAll('.ls-lesson-item');
                let anyMatch = false;

                lessonsInside.forEach(lesson => {
                    const text = lesson.innerText.toLowerCase();
                    if (term === '' || text.includes(term) || classAttr.includes(term)) {
                        lesson.style.display = '';
                        anyMatch = true;
                    } else {
                        lesson.style.display = 'none';
                    }
                });

                if (anyMatch || term === '') {
                    card.style.display = '';
                    if (term !== '') {
                        const contentDiv = card.querySelector('.ls-class-content');
                        if (contentDiv) contentDiv.style.display = 'block';
                        const allSubContents = card.querySelectorAll('.ls-subject-content');
                        allSubContents.forEach(sc => sc.style.display = 'block');
                        const icons = card.querySelectorAll('.ls-chevron-icon');
                        icons.forEach(ic => ic.style.transform = 'rotate(0deg)');
                    }
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initSearch();
    });
</script>
@endsection