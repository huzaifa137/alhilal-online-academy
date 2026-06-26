@extends('Student.layouts.sidebar')

@section('main-content')
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --accent: #6B46C1;
            --accent-lt: #EDE9FA;
            --gold: #D97706;
            --gold-lt: #FEF3C7;
            --green: #059669;
            --green-lt: #D1FAE5;
            --red: #DC2626;
            --ink: #1A0A2E;
            --muted: #6B6584;
            --border: #E3E0F0;
            --surface: #fff;
            --bg: #F5F3FD;
            --radius: 18px;
            --shadow: 0 4px 20px rgba(107, 70, 193, .10);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .cc-wrap {
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            padding: 0 30px 60px;
        }

        .cc-header {
            padding-top: 2em;
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 16px;
        }

        .cc-eyebrow {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 6px;
        }

        .cc-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--ink);
        }

        .cc-title em {
            font-style: italic;
            color: var(--accent);
        }

        .cc-subtitle {
            color: var(--muted);
            font-size: .84rem;
            margin-top: 6px;
        }

        /* Stats */
        .cc-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 36px;
        }

        .cc-stat {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 22px 24px;
        }

        .cc-stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--accent);
        }

        .cc-stat-label {
            font-size: .73rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-top: 4px;
        }

        /* Grid */
        .cc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }

        .cc-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all .25s;
        }

        .cc-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(107, 70, 193, .15);
            border-color: var(--accent);
        }

        .cc-card-banner {
            background: linear-gradient(135deg, #6B46C1 0%, #4C2E8A 60%, #D97706 100%);
            padding: 20px 22px 16px;
            position: relative;
            overflow: hidden;
        }

        .cc-card-banner::after {
            content: '🎓';
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3rem;
            opacity: .2;
        }

        .cc-card-type {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .75);
            margin-bottom: 6px;
        }

        .cc-card-class {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
        }

        .cc-card-body {
            padding: 20px 22px;
        }

        .cc-card-student {
            font-size: 1rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 4px;
        }

        .cc-card-meta {
            font-size: .75rem;
            color: var(--muted);
            margin-bottom: 16px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .cc-card-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .cc-grade-row {
            display: flex;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .cc-pill {
            padding: 5px 14px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .cc-pill-green {
            background: var(--green-lt);
            color: var(--green);
        }

        .cc-pill-gold {
            background: var(--gold-lt);
            color: var(--gold);
        }

        .cc-pill-purple {
            background: var(--accent-lt);
            color: var(--accent);
        }

        .cc-cert-no {
            font-size: .7rem;
            color: var(--muted);
            margin-bottom: 16px;
            font-family: monospace;
        }

        .cc-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .cc-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: 999px;
            font-size: .77rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
        }

        .cc-btn-primary {
            background: var(--accent);
            color: #fff;
        }

        .cc-btn-primary:hover {
            background: #4C2E8A;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(107, 70, 193, .3);
            color: #fff;
        }

        .cc-btn-outline {
            background: #fff;
            color: var(--accent);
            border: 1.5px solid var(--accent);
        }

        .cc-btn-outline:hover {
            background: var(--accent-lt);
        }

        /* Empty state */
        .cc-empty {
            grid-column: 1/-1;
            text-align: center;
            padding: 80px 40px;
            background: var(--surface);
            border: 1.5px dashed var(--border);
            border-radius: var(--radius);
        }

        .cc-empty-icon {
            font-size: 3rem;
            margin-bottom: 16px;
            opacity: .5;
        }

        .cc-empty-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: var(--ink);
        }

        .cc-empty-text {
            color: var(--muted);
            font-size: .85rem;
            margin-bottom: 24px;
        }

        @media(max-width:768px) {
            .cc-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .cc-title {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="cc-wrap">
        {{-- Header --}}
        <div class="cc-header">
            <div>
                <div class="cc-eyebrow"><i class="fas fa-certificate"></i> My Achievements</div>
                <h1 class="cc-title">My <em>Certificates</em></h1>
                <p class="cc-subtitle">Certificates you have earned by completing classes</p>
            </div>
            <a href="{{ route('student.lessons.lists') }}" class="cc-btn cc-btn-outline">
                <i class="fas fa-book-open"></i> My Lessons
            </a>
        </div>

        {{-- Stats --}}
        <div class="cc-stats">
            <div class="cc-stat">
                <div class="cc-stat-num">{{ $issuedCertificates->count() }}</div>
                <div class="cc-stat-label">Certificates Earned</div>
            </div>
            <div class="cc-stat">
                <div class="cc-stat-num">{{ $issuedCertificates->whereNotNull('grade')->count() }}</div>
                <div class="cc-stat-label">With Grade</div>
            </div>
            <div class="cc-stat">
                <div class="cc-stat-num">
                    @if($issuedCertificates->whereNotNull('percentage')->count())
                        {{ number_format($issuedCertificates->whereNotNull('percentage')->avg('percentage'), 1) }}%
                    @else
                        —
                    @endif
                </div>
                <div class="cc-stat-label">Average Score</div>
            </div>
        </div>

        {{-- Flash --}}
        @if(session('fail'))
            <div
                style="background:#FEE2E2;border:1px solid #DC2626;border-radius:12px;padding:14px 18px;margin-bottom:24px;color:#9B1C1C;font-size:.84rem;">
                <i class="fas fa-exclamation-triangle"></i> {{ session('fail') }}
            </div>
        @endif

        {{-- Certificate cards --}}
        <div class="cc-grid">
            @forelse($issuedCertificates as $cert)
                @php
                    $studentName = auth()->user()?->fullname
                        ?? trim((auth()->user()?->firstname ?? '') . ' ' . (auth()->user()?->lastname ?? ''))
                        ?: 'Student';
                @endphp
                <div class="cc-card">
                    <div class="cc-card-banner">
                        <div class="cc-card-type"><i class="fas fa-graduation-cap"></i> Certificate of Completion</div>
                        <div class="cc-card-class">{{ $cert->class->name ?? 'Class' }}</div>
                        @if($cert->class->level)
                            <div style="font-size:.7rem;color:rgba(255,255,255,.7);margin-top:3px">
                                <i class="fas fa-layer-group"></i> {{ $cert->class->level->name }}
                            </div>
                        @endif
                    </div>
                    <div class="cc-card-body">
                        <div class="cc-card-student">{{ $studentName }}</div>
                        <div class="cc-card-meta">
                            @if($cert->issued_date)
                                <span><i class="fas fa-calendar-check"></i>
                                    {{ \Carbon\Carbon::parse($cert->issued_date)->format('d M Y') }}</span>
                            @endif
                            @if($cert->class->academicYear)
                                <span><i class="fas fa-clock"></i> {{ $cert->class->academicYear->name }}</span>
                            @endif
                        </div>

                        <div class="cc-grade-row">
                            <span class="cc-pill cc-pill-green"><i class="fas fa-check-circle"></i> Completed</span>
                            @if($cert->grade)
                                <span class="cc-pill cc-pill-gold"><i class="fas fa-star"></i> Grade {{ $cert->grade }}</span>
                            @endif
                            @if($cert->percentage !== null)
                                <span class="cc-pill cc-pill-purple">{{ number_format((float) $cert->percentage, 1) }}%</span>
                            @endif
                        </div>

                        <div class="cc-cert-no"><i class="fas fa-barcode"></i> {{ $cert->certificate_no }}</div>

                        <div class="cc-actions">
                            <a href="{{ route('student.certificates.download', $cert->class_id) }}"
                                class="cc-btn cc-btn-primary">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                            <a href="{{ route('student.certificates.preview', $cert->class_id) }}" class="cc-btn cc-btn-outline"
                                target="_blank">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="cc-empty">
                    <div class="cc-empty-icon">🎓</div>
                    <div class="cc-empty-title">No Certificates Yet</div>
                    <p class="cc-empty-text">Complete all lessons and quizzes in a class to earn your certificate.</p>
                    <a href="{{ route('student.lessons.lists') }}" class="cc-btn cc-btn-primary">
                        <i class="fas fa-book-open"></i> Go to My Lessons
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection