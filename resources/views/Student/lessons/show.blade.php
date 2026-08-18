@extends('Student.layouts.sidebar')

@section('main-content')
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@500;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    :root {
        --purple: #6B46C1;
        --purple-light: #EDE9FA;
        --red: #DC2626;
        --red-light: #FEE2E2;
        --gold: #D97706;
        --gold-light: #FEF3C7;
        --green: #16A34A;
        --green-light: #DCFCE7;
        --cream: #FDFBF7;
        --cream2: #F7F3EE;
        --ink: #1A0A2E;
        --muted: #6B6584;
        --border: rgba(107, 70, 193, 0.12);
        --gradient: linear-gradient(135deg, #6B46C1 0%, #8B5CF6 100%);
        --shadow-sm: 0 2px 12px rgba(107, 70, 193, 0.08);
        --shadow-md: 0 8px 32px rgba(107, 70, 193, 0.12);
        --radius: 20px
    }

    * {
        box-sizing: border-box
    }

    html, body {
        overflow-x: hidden;
        width: 100%;
        max-width: 100%;
    }

    /* MAIN WRAPPER — single source of truth for padding/margin */
    .ls-wrap {
        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        max-width: 1100px;
        width: 100%;
        margin: 0 auto;
        padding: 0 20px;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    .sd-content {
        padding: 28px;
        flex: 1;
        max-width: 100%;
        width: 100%;
        display: flex;
        justify-content: center;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    /* LESSON HEADER */
    .ls-hero {
        background: linear-gradient(135deg, #1A0A2E 0%, #2D0F5C 50%, #4A1A1A 100%);
        border-radius: 28px;
        padding: 32px 36px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        color: white;
        max-width: 100%;
        box-sizing: border-box;
    }

    .ls-hero::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(107, 70, 193, .3) 0%, transparent 70%);
        top: -150px;
        right: -80px;
        pointer-events: none
    }

    .ls-hero-top {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        flex-wrap: wrap
    }

    .ls-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .2);
        padding: 6px 14px;
        border-radius: 40px;
        font-size: .75rem;
        font-weight: 600;
        color: rgba(255, 255, 255, .85);
        text-decoration: none;
        transition: all .2s
    }

    .ls-back:hover {
        background: rgba(255, 255, 255, .2);
        color: white
    }

    .ls-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 40px;
        font-size: .7rem;
        font-weight: 600;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .15)
    }

    .ls-status-badge.completed {
        background: rgba(22, 163, 74, .2);
        border-color: rgba(22, 163, 74, .4);
        color: #4ade80
    }

    .ls-status-badge.in_progress {
        background: rgba(217, 119, 6, .2);
        border-color: rgba(217, 119, 6, .4);
        color: #fcd34d
    }

    .ls-status-badge.not_started {
        background: rgba(255, 255, 255, .08);
        color: rgba(255, 255, 255, .7)
    }

    .ls-hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 8px;
        word-break: break-word;
    }

    .ls-hero-meta {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
        font-size: .8rem;
        color: rgba(255, 255, 255, .6)
    }

    .ls-hero-meta span {
        display: flex;
        align-items: center;
        gap: 5px
    }

    .ls-progress-bar {
        height: 6px;
        background: rgba(255, 255, 255, .15);
        border-radius: 10px;
        margin-top: 16px;
        overflow: hidden
    }

    .ls-progress-fill {
        height: 100%;
        background: var(--gradient);
        border-radius: 10px;
        transition: width .6s ease
    }

    /* CONTENT GRID */
    .ls-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
        width: 100%;
        max-width: 100%;
    }

    @media(max-width:900px) {
        .ls-grid {
            grid-template-columns: 1fr
        }
    }

    /* RESOURCE VIEWER */
    .ls-resource-box {
        background: white;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        overflow: hidden;
        margin-bottom: 24px;
        max-width: 100%;
        width: 100%;
        box-sizing: border-box;
    }

    .ls-resource-tabs {
        display: flex;
        gap: 0;
        border-bottom: 1px solid var(--border);
        overflow-x: auto;
        max-width: 100%;
        -webkit-overflow-scrolling: touch;
    }

    .ls-rtab {
        padding: 12px 18px;
        font-size: .78rem;
        font-weight: 600;
        color: var(--muted);
        border: none;
        background: none;
        cursor: pointer;
        white-space: nowrap;
        border-bottom: 2px solid transparent;
        transition: all .2s;
        font-family: 'DM Sans', sans-serif;
        flex-shrink: 0;
    }

    .ls-rtab:hover {
        color: var(--purple)
    }

    .ls-rtab.active {
        color: var(--purple);
        border-bottom-color: var(--purple)
    }

    .ls-resource-view {
        padding: 0;
        min-height: 400px;
        width: 100%;
        max-width: 100%;
    }

    .ls-viewer-area {
        display: none;
        width: 100%;
        max-width: 100%;
    }

    .ls-viewer-area.active {
        display: flex;
        flex-direction: column
    }

    /* Video player — stays responsive even with no source loaded */
    .ls-video-wrap {
        position: relative;
        background: #000;
        aspect-ratio: 16/9;
        width: 100%;
        max-width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-sizing: border-box;
    }

    /* ── Content protection: watermark + blackout ─────────────────── */
    .ls-watermark {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: 5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, .35);
        font-size: .78rem;
        font-weight: 700;
        text-align: center;
        text-shadow: 0 1px 2px rgba(0, 0, 0, .5);
        transition: top .4s ease, left .4s ease;
        white-space: nowrap;
    }

    .ls-blackout {
        position: fixed;
        inset: 0;
        background: #000;
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        text-align: center;
        padding: 24px;
    }

    .ls-video-wrap video {
        width: 100%;
        height: 100%;
        max-width: 100%;
        object-fit: contain;
        display: block;
    }

    /* Fallback for browsers without aspect-ratio support */
    @supports not (aspect-ratio: 16/9) {
        .ls-video-wrap {
            position: relative;
            height: 0;
            padding-top: 56.25%;
        }
        .ls-video-wrap video {
            position: absolute;
            top: 0;
            left: 0;
        }
    }

    /* PDF viewer */
    .ls-pdf-wrap {
        width: 100%;
        max-width: 100%;
        height: 600px;
        background: #f5f5f5;
        overflow: hidden;
        box-sizing: border-box;
    }

    .ls-pdf-wrap embed,
    .ls-pdf-wrap iframe {
        width: 100%;
        height: 100%;
        max-width: 100%;
        border: none;
        display: block;
    }

    @media (max-width: 600px) {
        .ls-pdf-wrap {
            height: 420px;
        }
    }

    /* Audio player */
    .ls-audio-wrap {
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        background: linear-gradient(135deg, #f5f0ff, #ede9fa);
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }

    .ls-audio-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: var(--gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        box-shadow: 0 8px 30px rgba(107, 70, 193, .3)
    }

    .ls-audio-wrap audio {
        width: 100%;
        max-width: 500px
    }

    /* Document placeholder */
    .ls-doc-wrap {
        padding: 40px 20px;
        text-align: center;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    .ls-doc-icon {
        font-size: 3rem;
        color: var(--muted);
        margin-bottom: 12px
    }

    /* Text content */
    .ls-text-wrap {
        padding: 28px;
        font-size: .9rem;
        line-height: 1.75;
        color: var(--ink);
        max-width: 100%;
        word-wrap: break-word;
    }

    /* Description / Notes */
    .ls-desc-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        padding: 24px;
        margin-bottom: 24px;
        max-width: 100%;
        width: 100%;
        box-sizing: border-box;
        overflow-wrap: break-word;
    }

    .ls-section-title {
        font-size: .75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--muted);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 7px
    }

    .ls-desc-text {
        font-size: .88rem;
        line-height: 1.75;
        color: var(--ink);
        word-wrap: break-word;
    }

    /* Navigation */
    .ls-nav-row {
        display: flex;
        gap: 12px;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .ls-nav-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 20px;
        background: white;
        border: 1px solid var(--border);
        border-radius: 40px;
        font-size: .8rem;
        font-weight: 600;
        color: var(--purple);
        text-decoration: none;
        transition: all .2s;
        flex: 1;
        justify-content: center
    }

    .ls-nav-btn:hover {
        background: var(--purple);
        color: white;
        border-color: var(--purple)
    }

    .ls-nav-btn.disabled {
        pointer-events: none;
        opacity: .4
    }

    /* Sidebar cards */
    .ls-side-card {
        background: white;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        padding: 20px;
        margin-bottom: 20px;
        max-width: 100%;
        width: 100%;
        box-sizing: border-box;
        overflow-wrap: break-word;
    }

    /* Progress action */
    .ls-complete-btn {
        width: 100%;
        padding: 13px;
        background: var(--gradient);
        color: white;
        border: none;
        border-radius: 40px;
        font-size: .9rem;
        font-weight: 600;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: all .2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none
    }

    .ls-complete-btn:hover {
        opacity: .9;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(107, 70, 193, .3)
    }

    .ls-complete-btn.done {
        background: linear-gradient(135deg, #16a34a, #22c55e)
    }

    /* Resource list in sidebar */
    .ls-res-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        border-radius: 12px;
        cursor: pointer;
        transition: all .2s;
        border: 1px solid transparent
    }

    .ls-res-item:hover {
        background: var(--purple-light);
        border-color: var(--border)
    }

    .ls-res-item.active {
        background: var(--purple-light);
        border-color: var(--purple)
    }

    .ls-res-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        flex-shrink: 0
    }

    .ls-res-name {
        font-size: .78rem;
        font-weight: 600;
        color: var(--ink);
        word-break: break-word;
    }

    .ls-res-type {
        font-size: .68rem;
        color: var(--muted)
    }

    /* Quiz card */
    .ls-quiz-card {
        background: linear-gradient(135deg, #f0f4ff, #f5f0ff);
        border: 1px solid #c7d2fe;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 12px;
        max-width: 100%;
        box-sizing: border-box;
    }

    .ls-quiz-title {
        font-size: .85rem;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 5px
    }

    .ls-quiz-meta {
        font-size: .72rem;
        color: var(--muted);
        margin-bottom: 10px
    }

    .ls-quiz-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        background: var(--gradient);
        color: white;
        border: none;
        border-radius: 40px;
        font-size: .75rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all .2s;
        font-family: 'DM Sans', sans-serif
    }

    .ls-quiz-btn:hover {
        opacity: .9;
        color: white
    }

    .ls-quiz-passed {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        background: var(--green-light);
        color: var(--green);
        border-radius: 40px;
        font-size: .72rem;
        font-weight: 600
    }

    /* Info table */
    .ls-info-row {
        display: flex;
        padding: 9px 0;
        border-bottom: 1px solid var(--border);
        font-size: .82rem;
        flex-wrap: wrap;
    }

    .ls-info-row:last-child {
        border-bottom: none
    }

    .ls-info-label {
        width: 110px;
        font-weight: 600;
        color: var(--ink);
        flex-shrink: 0
    }

    .ls-info-val {
        color: var(--muted);
        word-break: break-word;
    }

    /* RESPONSIVE BREAKPOINTS */
    @media (max-width: 768px) {
        .sd-content {
            padding: 16px;
        }
        .ls-wrap {
            padding: 0 12px;
        }
        .ls-hero {
            padding: 26px 24px;
        }
        .ls-hero-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .sd-content {
            padding: 10px;
        }
        .ls-wrap {
            padding: 0 8px;
        }
        .ls-hero {
            padding: 22px 18px;
            border-radius: 20px;
        }
        .ls-hero-title {
            font-size: 1.3rem;
        }
        .ls-hero-meta {
            gap: 10px;
            font-size: .72rem;
        }
        .ls-desc-card,
        .ls-side-card {
            padding: 16px;
        }
        .ls-audio-wrap {
            padding: 28px 14px;
        }
        .ls-audio-icon {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }
        .ls-nav-row {
            flex-direction: column;
        }
        .ls-info-label {
            width: 90px;
            font-size: .78rem;
        }
    }
</style>
    <div class="ls-wrap">

        {{-- HERO --}}
        <div class="ls-hero mt-5">
            <div class="ls-hero-top">
                <a href="{{ route('student.lessons.lists') }}" class="ls-back"><i class="fas fa-arrow-left"></i> Back to
                    Lessons</a>
                @php
                    $statusLabel = $progress ? ucfirst(str_replace('_', ' ', $progress->status)) : 'Not Started';
                    $statusClass = $progress ? $progress->status : 'not_started';
                @endphp
                <span class="ls-status-badge {{ $statusClass }}">
                    <i
                        class="fas fa-{{ $statusClass === 'completed' ? 'check-circle' : ($statusClass === 'in_progress' ? 'play-circle' : 'circle') }}"></i>
                    {{ $statusLabel }}
                </span>
            </div>
            <div class="ls-hero-title">{{ $lesson->title }}</div>
            @if($lesson->title_arabic)
                <div style="font-size:1rem;color:rgba(255,255,255,.6);margin-bottom:8px;font-family:serif;">
                    {{ $lesson->title_arabic }}</div>
            @endif
            <div class="ls-hero-meta">
                @if($lesson->topic?->subject)
                    <span><i class="fas fa-book"></i> {{ $lesson->topic->subject->name }}</span>
                @endif
                @if($lesson->topic?->class)
                    <span><i class="fas fa-chalkboard"></i> {{ $lesson->topic->class->name }}</span>
                @endif
                @if($lesson->duration)
                    <span><i class="fas fa-clock"></i> {{ $lesson->duration }} min</span>
                @endif
                <span><i
                        class="fas fa-{{ $lesson->lesson_type === 'video' ? 'video' : ($lesson->lesson_type === 'audio' ? 'headphones' : ($lesson->lesson_type === 'pdf' ? 'file-pdf' : 'book')) }}"></i>
                    {{ ucfirst($lesson->lesson_type) }}</span>
                @if($lesson->teacher)
                    <span><i class="fas fa-user-tie"></i> {{ $lesson->teacher->firstname ?? '' }}
                        {{ $lesson->teacher->lastname ?? '' }}</span>
                @endif
            </div>
            {{-- Progress bar for in-progress --}}
            @if($progress && $progress->status !== 'not_started')
                <div class="ls-progress-bar">
                    <div class="ls-progress-fill" style="width:{{ $progress->status === 'completed' ? 100 : 50 }}%"></div>
                </div>
            @endif
        </div>

        <div class="ls-grid">

            {{-- MAIN CONTENT --}}
            <div>
                {{-- Resource Viewer --}}
                @if($lesson->resources && $lesson->resources->count() > 0)
                    <div class="ls-resource-box">
                        <div class="ls-resource-tabs" id="resourceTabs">
                            @foreach($lesson->resources as $i => $resource)
                                <button class="ls-rtab {{ $i === 0 ? 'active' : '' }}"
                                    onclick="showResource({{ $i }}, '{{ $resource->type }}', '{{ \Illuminate\Support\Facades\Storage::url($resource->file_path) }}', '{{ addslashes($resource->title) }}')"
                                    data-index="{{ $i }}">
                                    <i
                                        class="fas fa-{{ $resource->type === 'video' ? 'video' : ($resource->type === 'audio' ? 'headphones' : ($resource->type === 'pdf' ? 'file-pdf' : ($resource->type === 'image' ? 'image' : 'file'))) }}"></i>
                                    {{ Str::limit($resource->title ?? ucfirst($resource->type), 25) }}
                                </button>
                            @endforeach
                        </div>

                        <div class="ls-resource-view" id="resourceView">
                            {{-- Will be populated by JS --}}
                            @foreach($lesson->resources as $i => $resource)
                                @php $fileUrl = \Illuminate\Support\Facades\Storage::url($resource->file_path); @endphp
                                <div class="ls-viewer-area {{ $i === 0 ? 'active' : '' }}" id="viewer_{{ $i }}">
                                    @if($resource->type === 'video')
                                        <div class="ls-video-wrap">
                                            <video controls preload="metadata" id="videoPlayer_{{ $i }}"
                                                controlsList="nodownload noplaybackrate noremoteplayback"
                                                disablePictureInPicture disableRemotePlayback
                                                oncontextmenu="return false;"
                                                onplay="trackProgress({{ $lesson->id }})"
                                                ontimeupdate="savePosition(this, {{ $lesson->id }})"
                                                onended="lessonEnded({{ $lesson->id }})">
                                                <source src="{{ $fileUrl }}" type="video/mp4">
                                                <source src="{{ $fileUrl }}" type="video/webm">
                                                Your browser does not support the video tag.
                                            </video>
                                            <div class="ls-watermark" id="lsWatermark_{{ $i }}">
                                                {{ session('LoggedStudent') }} &middot; {{ now()->format('d M Y') }}
                                            </div>
                                        </div>
                                        <div
                                            style="padding:12px 16px;background:#f9f9ff;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;font-size:.75rem;color:var(--muted);">
                                            <span><i class="fas fa-info-circle"></i> Video progress is saved automatically</span>
                                            
                                        </div>

                                    @elseif($resource->type === 'audio')
                                        <div class="ls-audio-wrap">
                                            <div class="ls-audio-icon"><i class="fas fa-headphones"></i></div>
                                            <div style="text-align:center;">
                                                <div style="font-weight:700;font-size:1rem;color:var(--ink);margin-bottom:4px;">
                                                    {{ $resource->title }}</div>
                                                <div style="font-size:.75rem;color:var(--muted);">Audio Lesson</div>
                                            </div>
                                            <audio controls preload="metadata" style="width:100%;max-width:500px;"
                                                onplay="trackProgress({{ $lesson->id }})" onended="lessonEnded({{ $lesson->id }})">
                                                <source src="{{ $fileUrl }}" type="audio/mpeg">
                                                <source src="{{ $fileUrl }}" type="audio/wav">
                                                <source src="{{ $fileUrl }}" type="audio/ogg">
                                                Your browser does not support audio playback.
                                            </audio>
                                           
                                        </div>

                                    @elseif($resource->type === 'pdf')
                                        <div class="ls-pdf-wrap">
                                            <iframe src="{{ $fileUrl }}#toolbar=1&navpanes=1&scrollbar=1" title="{{ $resource->title }}"
                                                onload="trackProgress({{ $lesson->id }})"></iframe>
                                        </div>
                                        <div
                                            style="padding:12px 16px;background:#f9f9ff;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;font-size:.75rem;color:var(--muted);">
                                            <span><i class="fas fa-file-pdf" style="color:var(--red)"></i> {{ $resource->title }}</span>
                                            <div style="display:flex;gap:8px;">
                                                <a href="{{ $fileUrl }}" target="_blank" class="ls-nav-btn"
                                                    style="flex:none;padding:6px 14px;font-size:.72rem;"><i
                                                        class="fas fa-external-link-alt"></i> Open Full</a>
                                               
                                            </div>
                                        </div>

                                    @elseif($resource->type === 'image')
                                        <div style="padding:20px;text-align:center;background:#f9f9f9;">
                                            <img src="{{ $fileUrl }}" alt="{{ $resource->title }}"
                                                style="max-width:100%;max-height:500px;border-radius:12px;box-shadow:var(--shadow-md);">
                                        </div>

                                    @else
                                        <div class="ls-doc-wrap">
                                            <div class="ls-doc-icon"><i class="fas fa-file-alt"></i></div>
                                            <div style="font-weight:600;margin-bottom:8px;">{{ $resource->title }}</div>
                                          
                                           
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($lesson->video_url)
                    {{-- External video URL (YouTube/Vimeo) --}}
                    <div class="ls-resource-box">
                        <div
                            style="padding:12px 16px;border-bottom:1px solid var(--border);font-size:.78rem;font-weight:600;color:var(--muted);">
                            <i class="fas fa-video"></i> Video Lesson</div>
                        <div class="ls-video-wrap" style="aspect-ratio:16/9">
                            @php
                                $vUrl = $lesson->video_url;
                                if (str_contains($vUrl, 'youtube.com/watch')) {
                                    $vUrl = str_replace('watch?v=', 'embed/', $vUrl);
                                } elseif (str_contains($vUrl, 'youtu.be/')) {
                                    $vUrl = 'https://www.youtube.com/embed/' . basename($vUrl);
                                }
                            @endphp
                            <iframe src="{{ $vUrl }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen style="width:100%;height:100%;"></iframe>
                            <div class="ls-watermark" id="lsWatermarkExternal">
                                {{ session('LoggedStudent') }} &middot; {{ now()->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="ls-resource-box" style="padding:40px;text-align:center;">
                        <div style="font-size:2.5rem;color:var(--muted);margin-bottom:12px;"><i class="fas fa-book-open"></i>
                        </div>
                        <div style="font-weight:600;color:var(--ink);margin-bottom:6px;">Text / Reading Lesson</div>
                        <div style="color:var(--muted);font-size:.85rem;">Read the lesson content below</div>
                    </div>
                @endif

                {{-- Description --}}
                @if($lesson->description)
                    <div class="ls-desc-card">
                        <div class="ls-section-title"><i class="fas fa-align-left"></i> Lesson Description</div>
                        <div class="ls-desc-text">{!! nl2br(e($lesson->description)) !!}</div>
                    </div>
                @endif

                {{-- Notes --}}
                @if($lesson->notes)
                    <div class="ls-desc-card">
                        <div class="ls-section-title"><i class="fas fa-sticky-note" style="color:var(--gold)"></i> Teacher's
                            Notes</div>
                        <div class="ls-desc-text">{!! nl2br(e($lesson->notes)) !!}</div>
                    </div>
                @endif

                @if (false)
                                    {{-- Navigation --}}
                <div class="ls-nav-row">
                    @if($prevLesson)
                        <a href="{{ route('student.lessons.show', $prevLesson) }}" class="ls-nav-btn">
                            <i class="fas fa-arrow-left"></i> Previous: {{ Str::limit($prevLesson->title, 30) }}
                        </a>
                    @else
                        <span class="ls-nav-btn disabled"><i class="fas fa-arrow-left"></i> No Previous Lesson</span>
                    @endif
                    @if($nextLesson)
                        <a href="{{ route('student.lessons.show', $nextLesson) }}" class="ls-nav-btn">
                            Next: {{ Str::limit($nextLesson->title, 30) }} <i class="fas fa-arrow-right"></i>
                        </a>
                    @else
                        <span class="ls-nav-btn disabled">No Next Lesson <i class="fas fa-arrow-right"></i></span>
                    @endif
                </div>
                @endif
            </div>

            {{-- SIDEBAR --}}
            <div>
                {{-- Progress / Complete Action --}}
                <div class="ls-side-card">
                    <div class="ls-section-title"><i class="fas fa-chart-line"></i> Your Progress</div>
                    @if($progress && in_array($progress->status, ['completed', 'passed']))
                        <button class="ls-complete-btn done" disabled>
                            <i class="fas fa-check-circle"></i> Lesson Completed!
                        </button>
                        @if($progress->completed_at)
                            <div style="text-align:center;margin-top:8px;font-size:.72rem;color:var(--muted);">
                                Completed {{ $progress->completed_at->diffForHumans() }}
                            </div>
                        @endif
                    @else
                        <button class="ls-complete-btn" id="completeBtn" onclick="markComplete()">
                            <i class="fas fa-check"></i> Mark as Completed
                        </button>
                        <div style="margin-top:10px;font-size:.73rem;color:var(--muted);text-align:center;">
                            Mark this lesson as complete once you've finished studying it
                        </div>
                    @endif
                </div>

                {{-- Resources List --}}
                @if($lesson->resources && $lesson->resources->count() > 0)
                    <div class="ls-side-card">
                        <div class="ls-section-title"><i class="fas fa-paperclip"></i> Materials
                            ({{ $lesson->resources->count() }})</div>
                        <div style="display:flex;flex-direction:column;gap:6px;">
                            @foreach($lesson->resources as $i => $resource)
                                @php
                                    $resIcon = match ($resource->type) {
                                        'video' => 'fa-video',
                                        'audio' => 'fa-headphones',
                                        'pdf' => 'fa-file-pdf',
                                        'image' => 'fa-image',
                                        default => 'fa-file-alt',
                                    };
                                    $resColor = match ($resource->type) {
                                        'video' => '#6B46C1',
                                        'audio' => '#D97706',
                                        'pdf' => '#DC2626',
                                        'image' => '#16A34A',
                                        default => '#2563EB',
                                    };
                                    $resBg = match ($resource->type) {
                                        'video' => '#EDE9FA',
                                        'audio' => '#FEF3C7',
                                        'pdf' => '#FEE2E2',
                                        'image' => '#DCFCE7',
                                        default => '#DBEAFE',
                                    };
                                @endphp
                                <div class="ls-res-item {{ $i === 0 ? 'active' : '' }}" id="resItem_{{ $i }}"
                                    onclick="switchTab({{ $i }})">
                                    <div class="ls-res-icon" style="background:{{ $resBg }};color:{{ $resColor }}">
                                        <i class="fas {{ $resIcon }}"></i>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <div class="ls-res-name">{{ Str::limit($resource->title ?? ucfirst($resource->type), 30) }}
                                        </div>
                                        <div class="ls-res-type">{{ strtoupper($resource->type) }}
                                            @if($resource->file_size)
                                                · {{ round($resource->file_size / 1024) }} KB
                                            @endif
                                        </div>
                                    </div>
                                   
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Quizzes --}}
                @if($lesson->exams && $lesson->exams->count() > 0)
                    <div class="ls-side-card">
                        <div class="ls-section-title"><i class="fas fa-question-circle" style="color:var(--red)"></i> Lesson
                            Quizzes</div>
                        @foreach($lesson->exams as $quiz)
                            @php $quizResult = $quizResults[$quiz->id] ?? null; @endphp
                            <div class="ls-quiz-card">
                                <div class="ls-quiz-title">{{ $quiz->title }}</div>
                                <div class="ls-quiz-meta">
                                    {{ $quiz->questions->count() }} Questions
                                    @if($quiz->duration_minutes) · {{ $quiz->duration_minutes }} min @endif
                                    · Pass: {{ $quiz->pass_mark }}%
                                </div>
                                @if($quizResult && $quizResult->is_passed)
                                    <div class="ls-quiz-passed">
                                        <i class="fas fa-check-circle"></i> Passed ({{ round($quizResult->percentage) }}%)
                                    </div>
                                @else
                                    <a href="{{ route('exams.take', $quiz->id) }}" class="ls-quiz-btn">
                                        <i class="fas fa-play"></i>
                                        {{ $quizResult ? 'Retry Quiz' : 'Take Quiz' }}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Lesson Info --}}
                <div class="ls-side-card">
                    <div class="ls-section-title"><i class="fas fa-info-circle"></i> Lesson Info</div>
                    <div class="ls-info-row">
                        <div class="ls-info-label">Topic</div>
                        <div class="ls-info-val">{{ $lesson->topic?->title ?? '—' }}</div>
                    </div>
                    <div class="ls-info-row">
                        <div class="ls-info-label">Subject</div>
                        <div class="ls-info-val">{{ $lesson->topic?->subject?->name ?? '—' }}</div>
                    </div>
                    <div class="ls-info-row">
                        <div class="ls-info-label">Class</div>
                        <div class="ls-info-val">{{ $lesson->topic?->class?->name ?? '—' }}</div>
                    </div>
                    <div class="ls-info-row">
                        <div class="ls-info-label">Type</div>
                        <div class="ls-info-val">{{ ucfirst($lesson->lesson_type) }}</div>
                    </div>
                    @if($lesson->duration)
                        <div class="ls-info-row">
                            <div class="ls-info-label">Duration</div>
                            <div class="ls-info-val">{{ $lesson->duration }} minutes</div>
                        </div>
                    @endif
                    @if($lesson->teacher)
                        <div class="ls-info-row">
                            <div class="ls-info-label">Teacher</div>
                            <div class="ls-info-val">{{ $lesson->teacher->firstname ?? '' }}
                                {{ $lesson->teacher->lastname ?? '' }}</div>
                        </div>
                    @endif
                </div>
            </div>

        </div>{{-- /ls-grid --}}
    </div>{{-- /ls-wrap --}}

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const LESSON_ID = {{ $lesson->id }};
        const STUDENT_ID = {{ session('LoggedStudent') ?? 0 }};

        // ── Content protection layer ─────────────────────────────────
        // Deters casual screen recording/screenshots and traces any leak
        // back to the specific student. This is a JS-level deterrent —
        // it cannot block OS-level screenshots or a second camera, but it
        // stops most external screen recorders (which require switching
        // away from the app) and watermarks every frame with the student's ID.
        (function () {
            // 1. Moving watermark — makes any leaked clip traceable
            document.querySelectorAll('.ls-watermark').forEach(function (wm) {
                var positions = [
                    { top: '10%', left: '12%' },
                    { top: '10%', left: '65%' },
                    { top: '80%', left: '15%' },
                    { top: '80%', left: '60%' },
                    { top: '45%', left: '38%' }
                ];
                var i = 0;
                setInterval(function () {
                    i = (i + 1) % positions.length;
                    wm.style.top = positions[i].top;
                    wm.style.left = positions[i].left;
                }, 4000);
            });

            // 2. Blackout on tab/app blur — catches most external recorders,
            //    screen-share/mirroring, and app-switching
            var blackout = document.createElement('div');
            blackout.className = 'ls-blackout';
            blackout.innerHTML = '<div><i class="fas fa-lock" style="font-size:2rem;display:block;margin-bottom:12px"></i>Content paused for security</div>';
            document.body.appendChild(blackout);

            function pauseAllMedia() {
                document.querySelectorAll('video, audio').forEach(function (m) { m.pause(); });
            }

            document.addEventListener('visibilitychange', function () {
                if (document.hidden) {
                    pauseAllMedia();
                    blackout.style.display = 'flex';
                } else {
                    blackout.style.display = 'none';
                }
            });
            window.addEventListener('blur', function () {
                pauseAllMedia();
                blackout.style.display = 'flex';
            });
            window.addEventListener('focus', function () {
                blackout.style.display = 'none';
            });

            // 3. Basic deterrents — right-click, text/image selection & drag,
            //    save/print/devtools shortcuts, PrintScreen key
            document.addEventListener('contextmenu', function (e) { e.preventDefault(); });
            document.addEventListener('selectstart', function (e) { e.preventDefault(); });
            document.addEventListener('dragstart', function (e) { e.preventDefault(); });
            window.addEventListener('keydown', function (e) {
                if (e.key === 'PrintScreen') { pauseAllMedia(); }
                if ((e.ctrlKey || e.metaKey) && ['p', 's', 'u'].includes(e.key.toLowerCase())) e.preventDefault();
                if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && ['I', 'J', 'C'].includes(e.key))) e.preventDefault();
            });
        })();
        const IS_COMPLETED = {{ ($progress && in_array($progress->status, ['completed', 'passed'])) ? 'true' : 'false' }};
        let progressTracked = false;
        let timeSpent = {{ $progress?->time_spent_seconds ?? 0 }};
        let timeInterval = null;

        // Start counting time
        function startTimer() {
            if (!timeInterval) {
                timeInterval = setInterval(() => {
                    timeSpent++;
                    if (timeSpent % 30 === 0) saveTimeSpent();
                }, 1000);
            }
        }

        function saveTimeSpent() {
            fetch(`/student/lessons/${LESSON_ID}/progress`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '' },
                body: JSON.stringify({ time_spent: timeSpent })
            }).catch(() => { });
        }

        function trackProgress(lessonId) {
            if (!progressTracked) {
                progressTracked = true;
                startTimer();
                fetch(`/student/lessons/${lessonId}/start`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '' },
                    body: JSON.stringify({})
                }).catch(() => { });
            }
        }

        function savePosition(el, lessonId) {
            if (el.currentTime % 15 < 0.5) {
                fetch(`/student/lessons/${lessonId}/progress`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '' },
                    body: JSON.stringify({ last_position: Math.floor(el.currentTime), time_spent: timeSpent })
                }).catch(() => { });
            }
        }

        function lessonEnded(lessonId) {
            if (!IS_COMPLETED) {
                Swal.fire({
                    title: 'Lesson Complete!',
                    text: 'You\'ve reached the end. Mark this lesson as completed?',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, mark complete!',
                    confirmButtonColor: '#6B46C1',
                }).then(r => { if (r.isConfirmed) markComplete(); });
            }
        }

        function markComplete() {
            const btn = document.getElementById('completeBtn');
            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...'; }

            fetch(`/student/lessons/${LESSON_ID}/complete`, {
                method: 'POST',
                keepalive: true,
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '' },
                body: JSON.stringify({ time_spent: timeSpent })
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        if (btn) {
                            btn.className = 'ls-complete-btn done';
                            btn.innerHTML = '<i class="fas fa-check-circle"></i> Lesson Completed!';
                            btn.disabled = true;
                        }
                        Swal.fire({ title: 'Great Job! 🎉', text: 'Lesson marked as completed!', icon: 'success', confirmButtonColor: '#6B46C1', timer: 2500 });
                        // Update hero status badge
                        const badge = document.querySelector('.ls-status-badge');
                        if (badge) { badge.className = 'ls-status-badge completed'; badge.innerHTML = '<i class="fas fa-check-circle"></i> Completed'; }
                        const bar = document.querySelector('.ls-progress-fill');
                        if (bar) bar.style.width = '100%';
                    }
                })
                .catch(() => {
                    if (btn) { btn.disabled = false; btn.innerHTML = '<i class="fas fa-check"></i> Mark as Completed'; }
                    alert('Failed to save progress. Please try again.');
                });
        }

        // Resource tab switching
        function switchTab(index) {
            document.querySelectorAll('.ls-viewer-area').forEach((v, i) => v.classList.toggle('active', i === index));
            document.querySelectorAll('.ls-rtab').forEach((t, i) => t.classList.toggle('active', i === index));
            document.querySelectorAll('[id^="resItem_"]').forEach((r, i) => r.classList.toggle('active', i === index));
            trackProgress(LESSON_ID);
        }

        function showResource(index) { switchTab(index); }

        // Restore video position
        @if($progress && $progress->last_position_seconds)
            window.addEventListener('load', () => {
                const vid = document.getElementById('videoPlayer_0');
                if (vid) vid.currentTime = {{ $progress->last_position_seconds }};
            });
        @endif

        // Auto-track when page loads (PDF/text lessons)
        window.addEventListener('load', () => {
            startTimer();
            trackProgress(LESSON_ID);
        });
    </script>
@endsection