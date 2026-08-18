@extends('Student.layouts.sidebar')

@section('main-content')
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
            --c-accent: #6B46C1;
            --c-accent-lt: #EDE9FA;
            --c-emerald: #059669;
            --c-green-lt: #D1FAE5;
            --c-red: #DC2626;
            --c-red-lt: #FEE2E2;
            --c-gold: #D97706;
            --c-gold-lt: #FEF3C7;
            --radius-lg: 18px;
            --radius-xl: 24px;
            --radius-pill: 999px;
            --shadow-sm: 0 1px 3px rgba(107, 70, 193, .07);
            --shadow-md: 0 4px 16px rgba(107, 70, 193, .10);
            --shadow-lg: 0 12px 40px rgba(107, 70, 193, .14);
            --gradient: linear-gradient(135deg, #6B46C1 0%, #8B5CF6 100%)
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        .sl-wrap {
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            color: var(--c-ink)
        }

        .sl-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px
        }

        .sl-eyebrow {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--c-accent);
            margin-bottom: 6px
        }

        .sl-title {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--c-ink);
            line-height: 1.15;
            margin: 0
        }

        .sl-title em {
            font-style: italic;
            color: var(--c-accent)
        }

        .sl-subtitle {
            margin-top: 6px;
            font-size: .83rem;
            color: var(--c-muted)
        }

        .sl-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px
        }

        .sl-stat {
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-lg);
            padding: 20px;
            transition: all .22s;
            cursor: default
        }

        .sl-stat:hover {
            transform: translateY(-2px);
            border-color: var(--c-accent);
            box-shadow: var(--shadow-md)
        }

        .sl-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 16px
        }

        .sl-stat-num {
            font-family: 'DM Serif Display', serif;
            font-size: 1.8rem;
            color: var(--c-ink);
            line-height: 1.1
        }

        .sl-stat-label {
            font-size: .73rem;
            font-weight: 600;
            color: var(--c-muted);
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: .06em
        }

        .sl-search {
            position: relative;
            margin-bottom: 32px;
            max-width: 500px
        }

        .sl-search input {
            width: 100%;
            padding: 12px 20px 12px 48px;
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-pill);
            font-size: .84rem;
            font-family: 'DM Sans', sans-serif;
            background: var(--c-surface);
            transition: all .2s
        }

        .sl-search input:focus {
            outline: none;
            border-color: var(--c-accent);
            box-shadow: 0 0 0 3px rgba(107, 70, 193, .13)
        }

        .sl-search i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--c-muted)
        }

        .sl-class-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 28px;
            margin-top: 16px
        }

        .sl-class-card {
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-xl);
            overflow: hidden;
            transition: all .25s;
            height: fit-content;
            min-width: 0;
            box-shadow: var(--shadow-sm)
        }

        .sl-class-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-3px)
        }

        .sl-class-header {
            background: var(--gradient);
            padding: 20px;
            cursor: pointer;
            transition: all .2s
        }

        .sl-class-header:hover {
            background: linear-gradient(135deg, #4930C2 0%, #7C3AED 100%)
        }

        .sl-class-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px
        }

        .sl-class-header-left {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .sl-class-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, .15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem
        }

        .sl-class-name {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            color: white;
            overflow-wrap: anywhere
        }

        .sl-class-level {
            font-size: .7rem;
            opacity: .9;
            display: flex;
            align-items: center;
            gap: 4px;
            color: white
        }

        .sl-class-header-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap
        }

        .sl-subjects-badge {
            background: rgba(255, 255, 255, .2);
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            font-size: .7rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            color: white
        }

        .sl-chevron {
            font-size: .85rem;
            transition: transform .25s;
            transform: rotate(-90deg);
            color: white
        }

        .sl-class-content {
            display: none;
            background: var(--c-surface2);
            padding: 8px 0 16px;
            max-height: 70vh;
            overflow-y: auto
        }

        .sl-class-content::-webkit-scrollbar {
            width: 5px
        }

        .sl-class-content::-webkit-scrollbar-track {
            background: var(--c-border);
            border-radius: 10px
        }

        .sl-class-content::-webkit-scrollbar-thumb {
            background: var(--c-accent);
            border-radius: 10px
        }

        /* Class payment gate */
        .sl-class-gate {
            margin: 10px 12px;
            padding: 16px;
            background: var(--c-gold-lt);
            border: 1.5px solid var(--c-gold);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap
        }

        .sl-gate-text {
            font-size: .8rem;
            font-weight: 600;
            color: var(--c-gold)
        }

        .sl-gate-btn {
            padding: 8px 18px;
            background: var(--c-gold);
            color: white;
            border: none;
            border-radius: var(--radius-pill);
            font-size: .75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s
        }

        .sl-gate-btn:hover {
            background: #b45309;
            transform: translateY(-1px)
        }

        .sl-subject-section {
            border: 1px solid var(--c-border);
            background: var(--c-surface);
            margin: 8px 12px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm)
        }

        .sl-subject-header {
            padding: 12px 16px;
            background: var(--c-surface);
            cursor: pointer;
            transition: all .2s;
            border-left: 3px solid var(--c-accent)
        }

        .sl-subject-header:hover {
            background: var(--c-accent-lt)
        }

        .sl-subject-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px
        }

        .sl-subject-name {
            font-weight: 600;
            color: var(--c-ink);
            font-size: .85rem
        }

        .sl-subject-code {
            font-size: .65rem;
            color: var(--c-muted)
        }

        .sl-subject-badge {
            background: var(--c-accent-lt);
            color: var(--c-accent);
            padding: 3px 10px;
            border-radius: var(--radius-pill);
            font-size: .65rem;
            font-weight: 600
        }

        .sl-subject-content {
            display: none;
            background: var(--c-surface2);
            padding: 12px;
            border-top: 1px solid var(--c-border)
        }

        .sl-topic-section {
            padding: 12px;
            margin-bottom: 12px;
            background: var(--c-surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--c-border)
        }

        .sl-topic-title {
            font-weight: 700;
            color: var(--c-ink);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            font-size: .85rem;
            padding-left: 4px
        }

        .sl-topic-badge {
            background: var(--c-surface2);
            color: var(--c-muted);
            padding: 2px 8px;
            border-radius: var(--radius-pill);
            font-size: .65rem
        }

        .sl-topic-desc {
            font-size: .7rem;
            color: var(--c-muted);
            margin-bottom: 12px;
            padding-left: 4px
        }

        /* ── Study Materials (PDFs) ─────────────────────────────────────── */
        .sl-materials-section {
            padding: 12px;
            margin-top: 4px;
            background: var(--c-surface);
            border-radius: var(--radius-lg);
            border: 1px dashed var(--c-border)
        }

        .sl-materials-list {
            display: flex;
            flex-direction: column;
            gap: 8px
        }

        .sl-material-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            background: var(--c-surface2);
            border-radius: var(--radius-lg);
            border: 1px solid var(--c-border);
            flex-wrap: wrap
        }

        .sl-material-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            border-radius: 10px;
            background: var(--c-red-lt, #FEE2E2);
            color: var(--c-red, #DC2626);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem
        }

        .sl-material-info {
            flex: 1;
            min-width: 140px
        }

        .sl-material-title {
            font-size: .8rem;
            font-weight: 600;
            color: var(--c-ink);
            word-break: break-word
        }

        .sl-material-meta {
            font-size: .68rem;
            color: var(--c-muted);
            margin-top: 2px
        }

        .sl-material-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            background: var(--c-accent);
            color: #fff;
            border-radius: var(--radius-pill);
            font-size: .72rem;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap
        }

        .sl-material-btn:hover { color: #fff; opacity: .9 }

        .sl-material-locked {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            background: var(--c-surface2);
            color: var(--c-muted);
            border-radius: var(--radius-pill);
            font-size: .72rem;
            font-weight: 600;
            white-space: nowrap
        }

        @media (max-width: 560px) {
            .sl-material-item {
                flex-direction: row;
            }

            .sl-material-btn,
            .sl-material-locked {
                width: 100%;
                justify-content: center;
                margin-top: 6px
            }
        }

        .sl-lesson-item {
            padding: 12px;
            margin-bottom: 8px;
            background: var(--c-surface2);
            border-radius: var(--radius-lg);
            border: 1px solid var(--c-border);
            transition: all .2s
        }

        .sl-lesson-item:hover {
            background: var(--c-surface);
            border-color: var(--c-accent);
            box-shadow: var(--shadow-sm)
        }

        .sl-lesson-main {
            display: flex;
            align-items: flex-start;
            gap: 12px
        }

        .sl-lesson-icon {
            width: 36px;
            height: 36px;
            background: var(--c-accent-lt);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--c-accent);
            font-size: .9rem;
            flex-shrink: 0
        }

        .sl-lesson-details {
            flex: 1
        }

        .sl-lesson-title {
            font-weight: 600;
            color: var(--c-ink);
            margin-bottom: 6px;
            font-size: .85rem;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap
        }

        .sl-lesson-lock {
            color: var(--c-red);
            font-size: .7rem
        }

        .sl-lesson-meta {
            display: flex;
            gap: 12px;
            font-size: .65rem;
            color: var(--c-muted);
            flex-wrap: wrap
        }

        .sl-lesson-meta-item {
            display: flex;
            align-items: center;
            gap: 4px
        }

        .sl-lesson-footer {
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px dashed var(--c-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap
        }

        .sl-lesson-price {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--c-accent-lt);
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            font-size: .7rem;
            font-weight: 600;
            color: var(--c-accent)
        }

        .sl-lesson-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap
        }

        .sl-btn-pay {
            padding: 6px 14px;
            background: var(--c-gold);
            color: white;
            border: none;
            border-radius: var(--radius-pill);
            font-size: .7rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s
        }

        .sl-btn-pay:hover {
            background: #b45309;
            transform: translateY(-1px)
        }

        .sl-btn-view {
            padding: 6px 14px;
            background: var(--c-accent);
            color: white;
            border: none;
            border-radius: var(--radius-pill);
            font-size: .7rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s
        }

        .sl-btn-view:hover {
            background: #4930C2;
            transform: translateY(-1px)
        }

        .sl-badge-paid {
            background: var(--c-green-lt);
            color: var(--c-emerald);
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            font-size: .65rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px
        }

        .sl-badge-progress {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            font-size: .65rem;
            font-weight: 600
        }

        .sl-badge-progress.completed {
            background: var(--c-green-lt);
            color: var(--c-emerald)
        }

        .sl-badge-progress.inprogress {
            background: var(--c-gold-lt);
            color: var(--c-gold)
        }

        /* Quiz section under lesson */
        .sl-quiz-section {
            margin-top: 10px;
            padding: 10px 12px;
            background: linear-gradient(135deg, #f0f4ff, #f5f0ff);
            border: 1px solid #c7d2fe;
            border-radius: 12px
        }

        .sl-quiz-header {
            font-size: .72rem;
            font-weight: 700;
            color: #4338ca;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: .06em
        }

        .sl-quiz-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 7px 10px;
            background: white;
            border-radius: 10px;
            margin-bottom: 5px;
            border: 1px solid #e0e7ff
        }

        .sl-quiz-item:last-child {
            margin-bottom: 0
        }

        .sl-quiz-title {
            font-size: .75rem;
            font-weight: 600;
            color: var(--c-ink)
        }

        .sl-quiz-meta {
            font-size: .65rem;
            color: var(--c-muted);
            margin-top: 2px
        }

        .sl-btn-quiz {
            padding: 5px 12px;
            background: linear-gradient(135deg, #4338ca, #6B46C1);
            color: white;
            border: none;
            border-radius: var(--radius-pill);
            font-size: .7rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s
        }

        .sl-btn-quiz:hover {
            opacity: .85;
            transform: translateY(-1px)
        }

        .sl-quiz-passed {
            background: var(--c-green-lt);
            color: var(--c-emerald);
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            font-size: .65rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px
        }

        .sl-empty {
            text-align: center;
            padding: 72px 40px;
            background: var(--c-surface);
            border-radius: var(--radius-xl);
            border: 1.5px solid var(--c-border)
        }

        .sl-empty-ring {
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
            color: var(--c-muted)
        }

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
            text-decoration: none
        }

        .btn-primary-custom:hover {
            background: #4930C2;
            box-shadow: 0 6px 20px rgba(107, 70, 193, .32);
            transform: translateY(-1px);
            color: white
        }

        /* Modals */
        .sl-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center
        }

        .sl-modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(26, 22, 40, .6);
            backdrop-filter: blur(4px)
        }

        .sl-modal-content {
            position: relative;
            background: var(--c-surface);
            border-radius: var(--radius-xl);
            width: 90%;
            max-width: 520px;
            box-shadow: var(--shadow-lg);
            animation: slideIn .3s ease-out;
            overflow: hidden
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px) scale(.95)
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1)
            }
        }

        .sl-modal-head {
            background: var(--gradient);
            color: white;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .sl-modal-head h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600
        }

        .sl-modal-close {
            background: rgba(255, 255, 255, .2);
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .3s
        }

        .sl-modal-close:hover {
            background: rgba(255, 255, 255, .3);
            transform: rotate(90deg)
        }

        .sl-modal-body {
            padding: 24px
        }

        .sl-modal-footer {
            padding: 20px 24px;
            background: var(--c-surface2);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            border-top: 1px solid var(--c-border)
        }

        .sl-amount-display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--c-surface2);
            padding: 12px 20px;
            border-radius: var(--radius-lg);
            margin: 12px 0
        }

        .sl-amount-label {
            color: var(--c-muted);
            font-size: .8rem
        }

        .sl-amount-value {
            color: var(--c-accent);
            font-weight: 700;
            font-size: 1.2rem
        }

        .sl-methods-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 20px
        }

        .sl-method {
            background: var(--c-surface2);
            border: 2px solid var(--c-border);
            border-radius: var(--radius-lg);
            padding: 14px 10px;
            text-align: center;
            cursor: pointer;
            transition: all .3s;
            position: relative
        }

        .sl-method:hover {
            border-color: var(--c-accent);
            background: var(--c-accent-lt)
        }

        .sl-method.selected {
            border-color: var(--c-accent);
            background: var(--c-accent-lt)
        }

        .sl-method-icon {
            font-size: 1.3rem;
            color: var(--c-accent);
            margin-bottom: 7px
        }

        .sl-method-tick {
            position: absolute;
            top: 7px;
            right: 7px;
            color: var(--c-accent);
            display: none
        }

        .sl-method.selected .sl-method-tick {
            display: block
        }

        .sl-input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-lg);
            font-size: .9rem;
            font-family: 'DM Sans', sans-serif;
            transition: all .3s
        }

        .sl-input:focus {
            outline: none;
            border-color: var(--c-accent);
            box-shadow: 0 0 0 3px rgba(107, 70, 193, .13)
        }

        .btn-cancel {
            padding: 8px 20px;
            border: 1.5px solid var(--c-border);
            background: var(--c-surface);
            color: var(--c-muted);
            border-radius: var(--radius-pill);
            cursor: pointer;
            font-weight: 600;
            font-size: .75rem;
            transition: all .3s
        }

        .btn-cancel:hover {
            background: var(--c-red-lt);
            border-color: var(--c-red);
            color: var(--c-red)
        }

        .btn-confirm {
            padding: 8px 24px;
            background: var(--c-accent);
            border: none;
            color: white;
            border-radius: var(--radius-pill);
            cursor: pointer;
            font-weight: 600;
            font-size: .75rem;
            transition: all .3s
        }

        .btn-confirm:hover {
            background: #4930C2;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(107, 70, 193, .3)
        }

        /* Quiz Modal */
        .quiz-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(26, 22, 40, .7);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px
        }

        .quiz-modal-box {
            background: white;
            border-radius: 24px;
            width: 100%;
            max-width: 640px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(107, 70, 193, .2);
            animation: slideIn .3s ease
        }

        .quiz-modal-head {
            background: var(--gradient);
            padding: 20px 24px;
            border-radius: 24px 24px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1
        }

        .quiz-modal-head h3 {
            margin: 0;
            color: white;
            font-size: 1.05rem
        }

        .quiz-modal-body {
            padding: 24px
        }

        .q-block {
            margin-bottom: 20px;
            padding: 16px;
            background: #f7f6fb;
            border-radius: 14px;
            border: 1px solid #e3e0f0
        }

        .q-text {
            font-size: .85rem;
            font-weight: 600;
            color: var(--c-ink);
            margin-bottom: 12px
        }

        .q-opt {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            margin-bottom: 6px;
            border-radius: 10px;
            cursor: pointer;
            transition: all .2s;
            border: 1.5px solid transparent;
            font-size: .82rem;
            color: var(--c-ink)
        }

        .q-opt:hover {
            background: #ede9fa;
            border-color: #6B46C1
        }

        .q-opt input {
            flex-shrink: 0;
            accent-color: #6B46C1
        }

        .q-opt.correct {
            background: #d1fae5;
            border-color: #059669;
            color: #065f46
        }

        .q-opt.wrong {
            background: #fee2e2;
            border-color: #dc2626;
            color: #991b1b
        }

        .quiz-result {
            padding: 16px;
            border-radius: 14px;
            font-size: .85rem;
            font-weight: 600;
            margin-top: 16px;
            text-align: center
        }

        .quiz-result.passed {
            background: #d1fae5;
            color: #065f46
        }

        .quiz-result.failed {
            background: #fee2e2;
            color: #991b1b
        }

        @media(max-width:1100px) {
            .sl-class-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 24px
            }
        }

        @media(max-width:768px) {
            .sl-title {
                font-size: 1.5rem
            }

            .sl-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px
            }

            .sl-class-grid {
                grid-template-columns: 1fr;
                gap: 20px
            }

            .sl-methods-grid {
                grid-template-columns: 1fr
            }
        }

        /* ── FIX: GENEROUS SPACING FOR CONTENT ── */

        /* Main content container - give it generous padding */
        .sd-content {
            padding: 40px 60px !important;
            /* Even more generous */
        }

        /* Wrap the entire enrollment content with side margins */
        .sl-wrap {
            max-width: 100%;
            padding: 0 30px !important;
            /* More side spacing */
            padding-bottom: 3em !important;
        }

        /* For better responsive spacing */
        @media(max-width:1200px) {
            .sd-content {
                padding: 28px 32px !important;
            }

            .sl-wrap {
                padding: 0 16px !important;
            }
        }

        @media(max-width:768px) {
            .sd-content {
                padding: 20px 16px !important;
            }

            .sl-wrap {
                padding: 0 12px !important;
            }
        }

        @media(max-width:480px) {
            .sd-content {
                padding: 16px 12px !important;
            }

            .sl-wrap {
                padding: 0 8px !important;
            }
        }

        /* Ensure cards don't overflow */
        .sl-class-grid {
            width: 100%;
        }

        .sl-class-card {
            width: 100%;
            max-width: 100%;
        }

        /* Add some breathing room for the header */
        .sl-header {
            padding-right: 4px;
            padding-top: 2em;
        }

        /* Optional: Add a subtle container background to see the spacing better */
        .sd-content {
            background: var(--c-bg);
        }

        .sl-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
            /* Changed from 9999 */
            display: none;
            align-items: center;
            justify-content: center
        }

        .quiz-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(26, 22, 40, .7);
            z-index: 1100;
            /* Changed from 10000 */
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px
        }

        /* SweetAlert2 popup */
        .swal2-container {
            z-index: 99999 !important;
        }

        /* Optional: popup itself */
        .swal2-popup {
            z-index: 100000 !important;
        }

        /* ── Certificate Section ─────────────────────────────────────── */
        .sl-cert-section {
            padding: 0 20px 20px;
        }

        .sl-cert-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            margin-top: 6px;
        }

        .sl-cert-divider::before,
        .sl-cert-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(107, 70, 193, .25), transparent);
        }

        .sl-cert-divider-label {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: #6B46C1;
            white-space: nowrap;
        }

        .sl-cert-loading {
            text-align: center;
            color: #9892B0;
            font-size: .8rem;
            padding: 14px;
        }

        /* Eligible card */
        .sl-cert-eligible {
            background: linear-gradient(135deg, #F5F3FD 0%, #FEF3C7 100%);
            border: 1.5px solid #D97706;
            border-radius: 14px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .sl-cert-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6B46C1, #4C2E8A);
            border: 2px solid #D97706;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fff;
            flex-shrink: 0;
        }

        .sl-cert-info {
            flex: 1;
            min-width: 0;
        }

        .sl-cert-title {
            font-weight: 700;
            font-size: .95rem;
            color: #1A0A2E;
            margin-bottom: 3px;
        }

        .sl-cert-sub {
            font-size: .75rem;
            color: #6B6584;
        }

        .sl-cert-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .sl-cert-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 999px;
            font-size: .77rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }

        .sl-cert-btn-gold {
            background: linear-gradient(135deg, #D97706, #F59E0B);
            color: #fff;
            box-shadow: 0 2px 8px rgba(217, 119, 6, .3);
        }

        .sl-cert-btn-gold:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(217, 119, 6, .4);
            color: #fff;
        }

        .sl-cert-btn-outline {
            background: #fff;
            color: #6B46C1;
            border: 1.5px solid #6B46C1;
        }

        .sl-cert-btn-outline:hover {
            background: #EDE9FA;
        }

        /* Locked card */
        .sl-cert-locked {
            background: #F9F7FF;
            border: 1.5px dashed rgba(107, 70, 193, .25);
            border-radius: 14px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            opacity: .82;
        }

        .sl-cert-locked-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(107, 70, 193, .1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #6B46C1;
            flex-shrink: 0;
        }

        .sl-cert-locked-info {
            flex: 1;
        }

        .sl-cert-locked-title {
            font-weight: 600;
            font-size: .88rem;
            color: #3B2459;
            margin-bottom: 3px;
        }

        .sl-cert-progress-bar-wrap {
            background: rgba(107, 70, 193, .12);
            border-radius: 999px;
            height: 5px;
            margin-top: 8px;
            overflow: hidden;
        }

        .sl-cert-progress-bar {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, #6B46C1, #D97706);
            transition: width .6s ease;
        }

        /* ── Report Card Banner (blue accent) ─────────────────────────── */
        .sl-rc-card {
            background: linear-gradient(135deg, #EEF3FF 0%, #F5F3FD 100%);
            border: 1.5px solid #2563EB;
            border-radius: 14px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .sl-rc-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563EB, #1E3A8A);
            border: 2px solid #93C5FD;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            flex-shrink: 0;
        }

        .sl-rc-info { flex: 1; min-width: 0; }

        .sl-rc-title { font-weight: 700; font-size: .95rem; color: #1A0A2E; margin-bottom: 4px; }

        .sl-rc-stats {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 2px;
        }

        .sl-rc-stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 600;
            background: #fff;
            border: 1px solid #DDE3F5;
            color: #374151;
        }

        .sl-rc-actions { display: flex; gap: 8px; flex-wrap: wrap; }

        .sl-rc-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 999px;
            font-size: .77rem;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }

        .sl-rc-btn-blue {
            background: linear-gradient(135deg, #2563EB, #1E3A8A);
            color: #fff;
            box-shadow: 0 2px 8px rgba(37, 99, 235, .3);
        }

        .sl-rc-btn-blue:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(37, 99, 235, .4);
            color: #fff;
        }

        .sl-rc-btn-outline {
            background: #fff;
            color: #2563EB;
            border: 1.5px solid #2563EB;
        }

        .sl-rc-btn-outline:hover {
            background: #EEF3FF;
        }

        /* ── FIX: Keep modal footer buttons visible on small screens ── */
.sl-modal-content {
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.sl-modal-body {
    overflow-y: auto;
    flex: 1 1 auto;
}

.sl-modal-footer {
    flex-shrink: 0;
}

@media (max-width: 560px) {
    .sl-modal {
        align-items: flex-end; /* anchor modal to bottom, avoids overflow above viewport */
    }

    .sl-modal-content {
        max-height: 85vh;
        width: 100%;
        border-radius: var(--radius-xl) var(--radius-xl) 0 0;
    }

    .sl-modal-footer {
        padding: 14px 20px;
    }
}
    </style>

    <div class="sl-wrap">
        @if(session('error'))
            <div
                style="margin-bottom:18px;padding:12px 18px;background:var(--c-red-lt);border:1px solid rgba(220,38,38,.25);border-radius:var(--radius-lg);color:var(--c-red);font-size:0.86rem;font-weight:600;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div
                style="margin-bottom:18px;padding:12px 18px;background:var(--c-green-lt);border:1px solid rgba(5,150,105,.25);border-radius:var(--radius-lg);color:var(--c-emerald);font-size:0.86rem;font-weight:600;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        <div class="sl-header">
            <div>
                <div class="sl-eyebrow"><i class="fas fa-graduation-cap"></i> My Learning</div>
                <h1 class="sl-title">My <em>Classes & Lessons</em></h1>
                <div class="sl-subtitle">View and access your enrolled classes, lessons, and quizzes</div>
            </div>
            <a href="{{ route('student.classes.browse') }}" class="btn-primary-custom">
                <i class="fas fa-plus-circle"></i> Browse More Classes
            </a>
        </div>

        <div class="sl-stats">
            <div class="sl-stat">
                <div class="sl-stat-icon" style="background:var(--c-accent-lt);color:var(--c-accent)"><i
                        class="fas fa-chalkboard"></i></div>
                <div class="sl-stat-num">{{ $enrolledClasses ?? 0 }}</div>
                <div class="sl-stat-label">Enrolled Classes</div>
            </div>
            <div class="sl-stat">
                <div class="sl-stat-icon" style="background:var(--c-green-lt);color:var(--c-emerald)"><i
                        class="fas fa-book"></i></div>
                <div class="sl-stat-num">{{ $totalLessons ?? 0 }}</div>
                <div class="sl-stat-label">Total Lessons</div>
            </div>
            <div class="sl-stat">
                <div class="sl-stat-icon" style="background:var(--c-gold-lt);color:var(--c-gold)"><i
                        class="fas fa-check-circle"></i></div>
                <div class="sl-stat-num">{{ $completedLessons ?? 0 }}</div>
                <div class="sl-stat-label">Completed</div>
            </div>
            <div class="sl-stat">
                <div class="sl-stat-icon" style="background:#e0e7ff;color:#4338ca"><i class="fas fa-layer-group"></i></div>
                <div class="sl-stat-num">{{ count($groupedLessons ?? []) }}</div>
                <div class="sl-stat-label">Active Classes</div>
            </div>
        </div>

        <div class="sl-search">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search lessons, classes, subjects, topics...">
        </div>

        @if(isset($groupedLessons) && count($groupedLessons) > 0)
                <div id="classGridContainer" class="sl-class-grid">
                    @foreach($groupedLessons as $className => $classData)
                            @php
                                $classPaid = $classData['class_paid'] ?? false;
                                $classPending = $classData['class_pending'] ?? false;
                                $enrollment = $classData['enrollment'] ?? null;
                            @endphp
                            <div class="sl-class-card" data-classname="{{ strtolower($className) }}">
                                <div class="sl-class-header" onclick="toggleClass(this)">
                                    <div class="sl-class-header-content">
                                        <div class="sl-class-header-left">
                                            <div class="sl-class-icon"><i class="fas fa-chalkboard"></i></div>
                                            <div>
                                                <h3 class="sl-class-name">{{ $className }}</h3>
                                                @if($classData['level'])
                                                    <span class="sl-class-level"><i class="fas fa-graduation-cap"></i>
                                                        {{ $classData['level'] }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="sl-class-header-right">
                                            @if($classPaid)
                                                <span class="sl-subjects-badge" style="background:rgba(5,150,105,.25)"><i
                                                        class="fas fa-check-circle"></i> Active</span>
                                            @else
                                                <span class="sl-subjects-badge" style="background:rgba(217,119,6,.3);"><i
                                                        class="fas fa-clock"></i> Pending</span>
                                            @endif
                                            <span class="sl-subjects-badge"><i class="fas fa-book"></i> {{ count($classData['subjects']) }}
                                                Subjects</span>
                                            <i class="fas fa-chevron-down sl-chevron" style="transform:rotate(0deg)"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="sl-class-content" style="display:block">
                                    {{-- Class Payment Gate --}}
                                    @if(!$classPaid)
                                        <div class="sl-class-gate" style="background:#f0fdf4; border-color:#16a34a;">
                                            <div>
                                                <div class="sl-gate-text" style="color:#15803d;">
                                                    <i class="fas fa-bolt"></i> Activate Class
                                                </div>
                                                <div style="font-size:.7rem;color:var(--c-muted);margin-top:3px">
                                                    Activate this class to unlock all its lessons
                                                </div>
                                            </div>
                                            <button class="sl-gate-btn" style="background:#16a34a;"
                                                onclick="showActivateClassModal({{ $classData['class_id'] }}, '{{ addslashes($className) }}')">
                                                <i class="fas fa-unlock"></i> Activate Class
                                            </button>
                                        </div>
                                    @endif

                                    @foreach($classData['subjects'] as $subjectName => $subjectData)
                                        <div class="sl-subject-section">
                                            <div class="sl-subject-header" onclick="toggleSubject(this)">
                                                <div class="sl-subject-header-content">
                                                    <div>
                                                        <i class="fas fa-book-open" style="color:var(--c-accent);margin-right:8px"></i>
                                                        <span class="sl-subject-name">{{ $subjectName }}</span>
                                                        @if($subjectData['subject_code'])
                                                            <span class="sl-subject-code">({{ $subjectData['subject_code'] }})</span>
                                                        @endif
                                                    </div>
                                                    <div style="display:flex;align-items:center;gap:8px">
                                                        <span class="sl-subject-badge"><i class="fas fa-layer-group"></i>
                                                            {{ count($subjectData['topics']) }} Topics</span>
                                                        <i class="fas fa-chevron-down" style="font-size:.7rem"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sl-subject-content" style="display:none">
                                                @foreach($subjectData['topics'] as $topicName => $topicData)
                                                    <div class="sl-topic-section">
                                                        <div class="sl-topic-title">
                                                            <i class="fas fa-folder-open" style="color:var(--c-accent)"></i>
                                                            <span>{{ $topicName }}</span>
                                                            <span class="sl-topic-badge"><i class="fas fa-video"></i>
                                                                {{ count($topicData['lessons']) }} Lessons</span>
                                                        </div>
                                                        @if($topicData['topic_description'])
                                                            <p class="sl-topic-desc">{{ Str::limit($topicData['topic_description'], 120) }}</p>
                                                        @endif

                                                        @foreach($topicData['lessons'] as $lesson)
                                                            @php
                                                                $lessonPaid = $lesson->is_paid_by_student ?? false;
                                                                $canAccessLesson = $classPaid && $lessonPaid;
                                                                $progress = $lesson->student_progress ?? null;
                                                                $hasQuizzes = ($lesson->quiz_count ?? 0) > 0;
                                                            @endphp
                                                            <div class="sl-lesson-item">
                                                                <div class="sl-lesson-main">
                                                                    <div class="sl-lesson-icon">
                                                                        <i class="fas fa-{{ $canAccessLesson ? 'play-circle' : 'lock' }}"></i>
                                                                    </div>
                                                                    <div class="sl-lesson-details">
                                                                        <div class="sl-lesson-title">
                                                                            {{ $lesson->title }}
                                                                            @if(!$classPaid)
                                                                                <span class="sl-lesson-lock"><i class="fas fa-lock"></i> Activate class
                                                                                    first</span>
                                                                            @elseif(!$lessonPaid)
                                                                                <span class="sl-lesson-lock"><i class="fas fa-lock"></i> Locked</span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="sl-lesson-meta">
                                                                            <span class="sl-lesson-meta-item"><i class="fas fa-hourglass-half"></i>
                                                                                {{ $lesson->duration ?? 'N/A' }} min</span>
                                                                            <span class="sl-lesson-meta-item"><i class="fas fa-sort-numeric-down"></i>
                                                                                Lesson {{ $lesson->lesson_order }}</span>
                                                                            <span class="sl-lesson-meta-item"><i
                                                                                    class="fas fa-{{ $lesson->lesson_type === 'video' ? 'video' : ($lesson->lesson_type === 'pdf' ? 'file-pdf' : 'headphones') }}"></i>
                                                                                {{ ucfirst($lesson->lesson_type) }}</span>
                                                                            @if($hasQuizzes)
                                                                                <span class="sl-lesson-meta-item" style="color:#4338ca"><i
                                                                                        class="fas fa-question-circle"></i> {{ $lesson->quiz_count }}
                                                                                    Quiz</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="sl-lesson-footer">
                                                                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                                                                        @if($lesson->lesson_amount)
                                                                            <div class="sl-lesson-price">
                                                                                <i class="fas fa-money-bill-wave"></i>
                                                                                UGX {{ number_format((int) str_replace(',', '', $lesson->lesson_amount)) }}
                                                                            </div>
                                                                        @else
                                                                            <div class="sl-lesson-price"
                                                                                style="background:var(--c-green-lt);color:var(--c-emerald)">
                                                                                <i class="fas fa-check-circle"></i> Free
                                                                            </div>
                                                                        @endif
                                                                        @if($progress === 'completed')
                                                                            <span class="sl-badge-progress completed"><i class="fas fa-check-circle"></i>
                                                                                Completed</span>
                                                                        @elseif($progress === 'in_progress')
                                                                            <span class="sl-badge-progress inprogress"><i class="fas fa-spinner"></i> In
                                                                                Progress</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="sl-lesson-actions">
                                                                        @if(!$classPaid)
                                                                            {{-- class must be paid first, button disabled --}}
                                                                        @elseif(!$lessonPaid && $lesson->lesson_amount)
                                                                            <button class="sl-btn-pay"
                                                                                onclick="showLessonPaymentModal({{ $lesson->id }}, '{{ addslashes($lesson->title) }}', '{{ (int) $lesson->lesson_amount }}')">
                                                                                <i class="fas fa-credit-card"></i> Pay
                                                                            </button>
                                                                        @else
                                                                            <a href="{{ route('student.lessons.show', $lesson) }}" class="sl-btn-view">
                                                                                <i class="fas fa-play"></i>
                                                                                {{ $progress === 'completed' ? 'Review' : ($progress === 'in_progress' ? 'Continue' : 'Start Lesson') }}
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                {{-- Quiz Section --}}
                                                                @if($hasQuizzes && $canAccessLesson)
                                                                    <div class="sl-quiz-section">
                                                                        <div class="sl-quiz-header">
                                                                            <i class="fas fa-question-circle"></i> Lesson Quiz
                                                                        </div>
                                                                        @php
                                                                            $lessonQuizzes = \App\Models\Academic\Exam::where('lesson_id', $lesson->id)
                                                                                ->where('exam_type', 'quiz')
                                                                                ->where('status', 'published')
                                                                                ->with('questions')
                                                                                ->get();
                                                                        @endphp
                                                                        @foreach($lessonQuizzes as $quiz)
                                                                            @php
                                                                                $studentId = session('LoggedStudent');
                                                                                $quizResult = \App\Models\Academic\ExamResult::where('exam_id', $quiz->id)
                                                                                    ->where('student_id', $studentId)
                                                                                    ->orderBy('attempt_number', 'desc')
                                                                                    ->first();
                                                                                $quizPassed = $quizResult && $quizResult->is_passed;
                                                                            @endphp
                                                                            <div class="sl-quiz-item">
                                                                                <div>
                                                                                    <div class="sl-quiz-title">{{ $quiz->title }}</div>
                                                                                    <div class="sl-quiz-meta">
                                                                                        {{ $quiz->questions->count() }} Questions · Pass {{ $quiz->pass_mark }}%
                                                                                        @if($quiz->duration_minutes) · {{ $quiz->duration_minutes }} min @endif
                                                                                        @if($quizResult) · Last: {{ round($quizResult->percentage, 1) }}% @endif
                                                                                    </div>
                                                                                </div>
                                                                                @if($quizPassed)
                                                                                    <span class="sl-quiz-passed"><i class="fas fa-check-circle"></i> Passed</span>
                                                                                @else
                                                                                    <button class="sl-btn-quiz"
                                                                                        onclick="takeQuiz({{ $quiz->id }}, '{{ addslashes($quiz->title) }}', {{ $quiz->duration_minutes ?? 0 }})">
                                                                                        <i class="fas fa-pencil-alt"></i>
                                                                                        {{ $quizResult ? 'Retry' : 'Attempt' }}
                                                                                    </button>
                                                                                @endif
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @elseif($hasQuizzes && !$canAccessLesson)
                                                                    <div class="sl-quiz-section" style="opacity:.5">
                                                                        <div class="sl-quiz-header"><i class="fas fa-lock"></i> Quiz locked — pay for lesson
                                                                            to access</div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- ── Study Materials (PDFs) for this class, across all subjects ───────────────── --}}
                                @php
                                    $classMaterials = collect($classData['subjects'])
                                        ->flatMap(function ($subjectData) {
                                            return $subjectData['materials'] ?? [];
                                        })
                                        ->values();
                                @endphp
                                @if($classMaterials->isNotEmpty())
                                    <div class="sl-materials-section">
                                        <div class="sl-topic-title">
                                            <i class="fas fa-file-pdf" style="color:var(--c-red)"></i>
                                            <span>Study Materials</span>
                                            <span class="sl-topic-badge"><i class="fas fa-paperclip"></i>
                                                {{ $classMaterials->count() }} PDF{{ $classMaterials->count() === 1 ? '' : 's' }}</span>
                                        </div>
                                        <div class="sl-materials-list">
                                            @foreach($classMaterials as $material)
                                                @php
                                                    $materialPaid = $material->is_paid_by_student ?? $material->isFree();
                                                    $canOpenMaterial = $classPaid && $materialPaid;
                                                @endphp
                                                <div class="sl-material-item">
                                                    <div class="sl-material-icon"><i class="fas fa-file-pdf"></i></div>
                                                    <div class="sl-material-info">
                                                        <div class="sl-material-title">{{ $material->title }}</div>
                                                        <div class="sl-material-meta">
                                                            PDF
                                                            @if($material->file_size_formatted) · {{ $material->file_size_formatted }} @endif
                                                            @if(!$material->isFree()) · UGX {{ number_format($material->amount) }} @endif
                                                            @if($material->description) · {{ Str::limit($material->description, 60) }} @endif
                                                        </div>
                                                    </div>
                                                    @if($canOpenMaterial)
                                                        <a href="{{ \Illuminate\Support\Facades\Storage::url($material->file_path) }}"
                                                            target="_blank" class="sl-material-btn">
                                                            <i class="fas fa-download"></i> Open
                                                        </a>
                                                    @elseif(!$classPaid)
                                                        <span class="sl-material-locked" title="Activate the class to unlock">
                                                            <i class="fas fa-lock"></i> Locked
                                                        </span>
                                                    @else
                                                        <button class="sl-material-btn" style="border:none;cursor:pointer;background:var(--c-red)"
                                                            onclick="showMaterialPaymentModal({{ $material->id }}, '{{ addslashes($material->title) }}', '{{ (int) $material->amount }}')">
                                                            <i class="fas fa-lock"></i> Pay UGX {{ number_format($material->amount) }}
                                                        </button>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- ── Report Card Section ─────────────────────────────────────────── --}}
                                <div class="sl-cert-section" id="rc-section-{{ $classData['class_id'] }}"
                                    data-class-id="{{ $classData['class_id'] }}">
                                    <div class="sl-cert-divider">
                                        <span class="sl-cert-divider-label"><i class="fas fa-chart-bar"></i> Report Card</span>
                                    </div>
                                    <div class="sl-cert-banner" id="rc-banner-{{ $classData['class_id'] }}">
                                        {{-- Placeholder shown before JS check --}}
                                        <div class="sl-cert-loading">
                                            <i class="fas fa-spinner fa-spin"></i> Loading your performance…
                                        </div>
                                    </div>
                                </div>

                                {{-- ── Certificate Section ─────────────────────────────────────────── --}}
                                <div class="sl-cert-section" id="cert-section-{{ $classData['class_id'] }}"
                                    data-class-id="{{ $classData['class_id'] }}">
                                    <div class="sl-cert-divider">
                                        <span class="sl-cert-divider-label"><i class="fas fa-certificate"></i> Class Certificate</span>
                                    </div>
                                    <div class="sl-cert-banner" id="cert-banner-{{ $classData['class_id'] }}">
                                        {{-- Placeholder shown before JS check --}}
                                        <div class="sl-cert-loading">
                                            <i class="fas fa-spinner fa-spin"></i> Checking eligibility…
                                        </div>
                                    </div>
                                </div>

                            </div>
                    @endforeach
            </div>
        @else
        <div class="sl-empty">
            <div class="sl-empty-ring"><i class="fas fa-graduation-cap"></i></div>
            <h3 style="font-size:1.1rem;color:var(--c-ink);margin-bottom:8px">No Classes Enrolled Yet</h3>
            <p style="color:var(--c-muted);margin-bottom:24px">You haven't enrolled in any classes yet. Browse available
                classes to get started!</p>
            <a href="{{ route('student.classes.browse') }}" class="btn-primary-custom">
                <i class="fas fa-plus-circle"></i> Browse & Enroll in Classes
            </a>
        </div>
    @endif
    </div>

    {{-- Class Payment Modal --}}
    <div id="classPayModal" class="sl-modal">
        <div class="sl-modal-overlay" onclick="closeClassPayModal()"></div>
        <div class="sl-modal-content">
            <div class="sl-modal-head">
                <h3><i class="fas fa-school"></i> Pay for Class</h3>
                <button class="sl-modal-close" onclick="closeClassPayModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="sl-modal-body">
                <div style="text-align:center;margin-bottom:20px">
                    <div style="font-size:1rem;font-weight:600;color:var(--c-ink)" id="classPayTitle"></div>
                    <div class="sl-amount-display">
                        <span class="sl-amount-label">Class Fee:</span>
                        <span class="sl-amount-value">UGX 50,000</span>
                    </div>
                    <div style="font-size:.75rem;color:var(--c-muted)">Pay once to unlock all lessons in this class</div>
                </div>
                <h5 style="font-size:.8rem;margin-bottom:12px;color:var(--c-ink)">Payment Method</h5>
                <div class="sl-methods-grid">
                    <div class="sl-method" onclick="selectMethod('class','mtn')" id="classMtn">
                        <div class="sl-method-icon"><i class="fas fa-mobile-alt"></i></div>
                        <span style="font-size:.73rem">MTN MoMo</span>
                        <div class="sl-method-tick"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <div class="sl-method" onclick="selectMethod('class','airtel')" id="classAirtel">
                        <div class="sl-method-icon"><i class="fas fa-mobile-alt"></i></div>
                        <span style="font-size:.73rem">Airtel Money</span>
                        <div class="sl-method-tick"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <div class="sl-method" onclick="selectMethod('class','card')" id="classCard">
                        <div class="sl-method-icon"><i class="fas fa-credit-card"></i></div>
                        <span style="font-size:.73rem">Bank Card</span>
                        <div class="sl-method-tick"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>

                {{-- Phone number field (shown for mobile money only) --}}
                <div id="classPhoneField" style="display:none;margin-bottom:14px">
                    <label style="font-size:.75rem;font-weight:600;margin-bottom:6px;display:block">
                        <i class="fas fa-phone"></i> Phone Number (e.g. +256712345678) 
                    </label>
                    <p><span style="color:red">Please note the phonenumber to start with +256 ... (country code)</span></p>
                    <input type="tel" id="classPayPhone" class="sl-input" placeholder="+256XXXXXXXXX">
                    <small style="font-size:.65rem;color:var(--c-muted);margin-top:4px;display:block">
                        You will receive a USSD prompt on this number to approve payment.
                    </small>
                </div>

                <label style="font-size:.75rem;font-weight:600;margin-bottom:6px;display:block">Enter Amount (UGX)</label>
                <input type="number" id="classPayAmount" class="sl-input" placeholder="Enter amount" value="50000" min="0"
                    step="1000">
            </div>
            <div class="sl-modal-footer">
                <button class="btn-cancel" onclick="closeClassPayModal()"><i class="fas fa-times"></i> Cancel</button>
                <button class="btn-confirm" onclick="confirmClassPayment()"><i class="fas fa-check"></i> Confirm
                    Payment</button>
            </div>
        </div>
    </div>

    {{-- Lesson Payment Modal --}}
    <div id="lessonPayModal" class="sl-modal">
        <div class="sl-modal-overlay" onclick="closeLessonPayModal()"></div>
        <div class="sl-modal-content">
            <div class="sl-modal-head">
                <h3><i class="fas fa-credit-card"></i> Pay for Lesson</h3>
                <button class="sl-modal-close" onclick="closeLessonPayModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="sl-modal-body">
                <div style="text-align:center;margin-bottom:20px">
                    <div style="font-size:1rem;font-weight:600;color:var(--c-ink)" id="lessonPayTitle"></div>
                    <div class="sl-amount-display">
                        <span class="sl-amount-label">Amount Required:</span> 
                        <span class="sl-amount-value" id="lessonPayAmountDisplay"></span>
                    </div>
                </div>
                <h5 style="font-size:.8rem;margin-bottom:12px;color:var(--c-ink)">Payment Method</h5>
                <div class="sl-methods-grid">
                    <div class="sl-method" onclick="selectMethod('lesson','mtn')" id="lessonMtn">
                        <div class="sl-method-icon"><i class="fas fa-mobile-alt"></i></div>
                        <span style="font-size:.73rem">MTN MoMo</span>
                        <div class="sl-method-tick"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <div class="sl-method" onclick="selectMethod('lesson','airtel')" id="lessonAirtel">
                        <div class="sl-method-icon"><i class="fas fa-mobile-alt"></i></div>
                        <span style="font-size:.73rem">Airtel Money</span>
                        <div class="sl-method-tick"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <div class="sl-method" onclick="selectMethod('lesson','card')" id="lessonCard">
                        <div class="sl-method-icon"><i class="fas fa-credit-card"></i></div>
                        <span style="font-size:.73rem">Bank Card</span>
                        <div class="sl-method-tick"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>

                {{-- Phone number field (shown for mobile money only) --}}
                <div id="lessonPhoneField" style="display:none;margin-bottom:14px">
                    <label style="font-size:.75rem;font-weight:600;margin-bottom:6px;display:block">
                        <i class="fas fa-phone"></i> Phone Number (e.g. +256712345678) 
                    </label>
                    <p><span style="color:red">Please note the phonenumber to start with +256 ... (country code)</span></p>
                    <input type="tel" id="lessonPayPhone" class="sl-input" placeholder="+256XXXXXXXXX">
                    <small style="font-size:.65rem;color:var(--c-muted);margin-top:4px;display:block">
                        You will receive a USSD prompt on this number to approve payment.
                    </small>
                </div>

                <label style="font-size:.75rem;font-weight:600;margin-bottom:6px;display:block">Enter Amount (UGX)</label>
                <input type="number" id="lessonPayAmount" class="sl-input" placeholder="Enter amount" min="0" step="1000">
                <small id="lessonAmountHint"
                    style="font-size:.65rem;color:var(--c-muted);margin-top:6px;display:block"></small>
            </div>
            <div class="sl-modal-footer">
                <button class="btn-cancel" onclick="closeLessonPayModal()"><i class="fas fa-times"></i> Cancel</button>
                <button class="btn-confirm" onclick="confirmLessonPayment()"><i class="fas fa-check"></i> Confirm
                    Payment</button>
            </div>
        </div>
    </div>

    {{-- Material Payment Modal --}}
    <div id="materialPayModal" class="sl-modal">
        <div class="sl-modal-overlay" onclick="closeMaterialPayModal()"></div>
        <div class="sl-modal-content">
            <div class="sl-modal-head">
                <h3><i class="fas fa-file-pdf"></i> Pay for PDF</h3>
                <button class="sl-modal-close" onclick="closeMaterialPayModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="sl-modal-body">
                <div style="text-align:center;margin-bottom:20px">
                    <div style="font-size:1rem;font-weight:600;color:var(--c-ink)" id="materialPayTitle"></div>
                    <div class="sl-amount-display">
                        <span class="sl-amount-label">Amount Required:</span>
                        <span class="sl-amount-value" id="materialPayAmountDisplay"></span>
                    </div>
                </div>
                <h5 style="font-size:.8rem;margin-bottom:12px;color:var(--c-ink)">Payment Method</h5>
                <div class="sl-methods-grid">
                    <div class="sl-method" onclick="selectMethod('material','mtn')" id="materialMtn">
                        <div class="sl-method-icon"><i class="fas fa-mobile-alt"></i></div>
                        <span style="font-size:.73rem">MTN MoMo</span>
                        <div class="sl-method-tick"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <div class="sl-method" onclick="selectMethod('material','airtel')" id="materialAirtel">
                        <div class="sl-method-icon"><i class="fas fa-mobile-alt"></i></div>
                        <span style="font-size:.73rem">Airtel Money</span>
                        <div class="sl-method-tick"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <div class="sl-method" onclick="selectMethod('material','card')" id="materialCard">
                        <div class="sl-method-icon"><i class="fas fa-credit-card"></i></div>
                        <span style="font-size:.73rem">Bank Card</span>
                        <div class="sl-method-tick"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>

                {{-- Phone number field (shown for mobile money only) --}}
                <div id="materialPhoneField" style="display:none;margin-bottom:14px">
                    <label style="font-size:.75rem;font-weight:600;margin-bottom:6px;display:block">
                        <i class="fas fa-phone"></i> Phone Number (e.g. +256712345678) 
                    </label>
                    <p><span style="color:red">Please note the phonenumber to start with +256 ... (country code)</span></p>
                    <input type="tel" id="materialPayPhone" class="sl-input" placeholder="+256XXXXXXXXX">
                    <small style="font-size:.65rem;color:var(--c-muted);margin-top:4px;display:block">
                        You will receive a USSD prompt on this number to approve payment.
                    </small>
                </div>

                <label style="font-size:.75rem;font-weight:600;margin-bottom:6px;display:block">Enter Amount (UGX)</label>
                <input type="number" id="materialPayAmount" class="sl-input" placeholder="Enter amount" min="0" step="1000">
                <small id="materialAmountHint"
                    style="font-size:.65rem;color:var(--c-muted);margin-top:6px;display:block"></small>
            </div>
            <div class="sl-modal-footer">
                <button class="btn-cancel" onclick="closeMaterialPayModal()"><i class="fas fa-times"></i> Cancel</button>
                <button class="btn-confirm" onclick="confirmMaterialPayment()"><i class="fas fa-check"></i> Confirm
                    Payment</button>
            </div>
        </div>
    </div>

    {{-- Quiz Modal --}}
    <div class="quiz-modal-overlay" id="quizModal">
        <div class="quiz-modal-box">
            <div class="quiz-modal-head">
                <h3 id="quizModalTitle"><i class="fas fa-question-circle"></i> Quiz</h3>
                <button onclick="closeQuizModal()" class="sl-modal-close"><i class="fas fa-times"></i></button>
            </div>
            <div class="quiz-modal-body">
                <div id="quizTimer"
                    style="text-align:right;font-size:.8rem;color:var(--c-accent);font-weight:700;margin-bottom:12px;display:none">
                    <i class="fas fa-clock"></i> <span id="timerDisplay">00:00</span>
                </div>
                <div id="quizQuestions"></div>
                <div id="quizResult" style="display:none"></div>
                <div style="display:flex;justify-content:flex-end;margin-top:16px">
                    <button id="quizSubmitBtn" onclick="submitQuiz()" class="btn-confirm" style="display:none">
                        <i class="fas fa-check"></i> Submit Quiz
                    </button>
                    <button id="quizCloseBtn" onclick="closeQuizModal()" class="btn-cancel"
                        style="display:none;margin-right:10px">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ── State ─────────────────────────────────────────
        let currentClassId = null;
        let currentClassMethod = null;
        let currentLessonId = null;
        let currentLessonMethod = null;
        let currentLessonRequired = null;
        let currentMaterialId = null;
        let currentMaterialMethod = null;
        let currentMaterialRequired = null;
        let currentExamId = null;
        let quizQuestions = [];
        let quizTimer = null;

        // ── Toggle Helpers ────────────────────────────────
        function toggleClass(el) {
            const card = el.closest('.sl-class-card');
            const content = card.querySelector('.sl-class-content');
            const icon = el.querySelector('.sl-chevron');
            const open = content.style.display === 'block';
            content.style.display = open ? 'none' : 'block';
            if (icon) icon.style.transform = open ? 'rotate(-90deg)' : 'rotate(0deg)';
        }

        function toggleSubject(el) {
            const section = el.closest('.sl-subject-section');
            const content = section.querySelector('.sl-subject-content');
            const open = content.style.display === 'block';
            content.style.display = open ? 'none' : 'block';
        }

        // ── Search ────────────────────────────────────────
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.sl-class-card').forEach(card => {
                const name = card.getAttribute('data-classname') || '';
                const lessons = card.querySelectorAll('.sl-lesson-item');
                let anyMatch = false;
                lessons.forEach(l => {
                    const match = !term || l.innerText.toLowerCase().includes(term) || name.includes(term);
                    l.style.display = match ? '' : 'none';
                    if (match) anyMatch = true;
                });
                if (anyMatch || !term) {
                    card.style.display = '';
                    if (term) {
                        card.querySelector('.sl-class-content').style.display = 'block';
                        card.querySelectorAll('.sl-subject-content').forEach(s => s.style.display = 'block');
                        card.querySelectorAll('.sl-chevron').forEach(i => i.style.transform = 'rotate(0deg)');
                    }
                } else { card.style.display = 'none'; }
            });
        });

        // ── Method Selection ──────────────────────────────
        function selectMethod(type, method) {
            const prefix = type === 'class' ? 'class' : (type === 'material' ? 'material' : 'lesson');
            ['Mtn', 'Airtel', 'Card'].forEach(m => document.getElementById(prefix + m).classList.remove('selected'));
            document.getElementById(prefix + method.charAt(0).toUpperCase() + method.slice(1)).classList.add('selected');

            // Show/hide phone field
            const phoneFieldId = type === 'class' ? 'classPhoneField' : (type === 'material' ? 'materialPhoneField' : 'lessonPhoneField');
            const phoneField = document.getElementById(phoneFieldId);
            if (method === 'card') {
                phoneField.style.display = 'none';
            } else {
                phoneField.style.display = 'block';
            }

            if (type === 'class') currentClassMethod = method;
            else if (type === 'material') currentMaterialMethod = method;
            else currentLessonMethod = method;
        }

        // ── Poll payment status after mobile money prompt ─
        let pollInterval = null;
        function startPolling(reference, onSuccess) {
            let attempts = 0;
            const maxAttempts = 40; // Poll up to ~2 min (every 3s)
            pollInterval = setInterval(async () => {
                attempts++;
                if (attempts > maxAttempts) {
                    clearInterval(pollInterval);
                    Swal.fire({
                        icon: 'info',
                        title: 'Still Processing',
                        text: 'Your payment is taking longer than expected. We\'ll update your lessons once it\'s confirmed. You can refresh the page to check.',
                        confirmButtonColor: '#6B46C1'
                    });
                    return;
                }
                try {
                    const res = await fetch(`{{ route('student.payment.status') }}?reference=${reference}`, {
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                    const data = await res.json();
                    if (data.paid) {
                        clearInterval(pollInterval);
                        onSuccess();
                    } else if (data.status === 'failed' || data.status === 'cancelled') {
                        clearInterval(pollInterval);
                        Swal.fire({ icon: 'error', title: 'Payment Failed', text: 'Your payment was not completed. Please try again.', confirmButtonColor: '#DC2626' });
                    }
                } catch (e) {
                    // Network hiccup, keep polling
                }
            }, 3000);
        }

        // ── Class Payment ─────────────────────────────────
        function showClassPaymentModal(classId, className) {
            currentClassId = classId;
            currentClassMethod = null;
            document.getElementById('classPayTitle').textContent = className;
            ['classMtn', 'classAirtel', 'classCard'].forEach(id => document.getElementById(id).classList.remove('selected'));
            document.getElementById('classPhoneField').style.display = 'none';
            document.getElementById('classPayPhone').value = '';
            document.getElementById('classPayModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeClassPayModal() {
            document.getElementById('classPayModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        async function confirmClassPayment() {
            if (!currentClassMethod) {
                Swal.fire({ icon: 'warning', title: 'Select Payment Method', text: 'Please choose a payment method.', confirmButtonColor: '#6B46C1' });
                return;
            }

            const amount = parseInt(document.getElementById('classPayAmount').value);
            if (!amount || amount < 500) {
                Swal.fire({ icon: 'warning', title: 'Invalid Amount', text: 'Minimum amount is UGX 500.', confirmButtonColor: '#6B46C1' });
                return;
            }

            const phone = document.getElementById('classPayPhone').value.trim();
            if (currentClassMethod !== 'card' && !phone) {
                Swal.fire({ icon: 'warning', title: 'Phone Number Required', text: 'Please enter your mobile money phone number.', confirmButtonColor: '#6B46C1' });
                return;
            }

            const methodLabel = currentClassMethod === 'card' ? 'Bank Card' :
                currentClassMethod === 'mtn' ? 'MTN MoMo' : 'Airtel Money';

            const r = await Swal.fire({
                title: 'Confirm Class Payment',
                html: `Pay <strong>UGX ${amount.toLocaleString()}</strong> via <strong>${methodLabel}</strong>${phone ? '<br>to: <strong>' + phone + '</strong>' : ''}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6B46C1',
                confirmButtonText: 'Yes, Pay Now'
            });
            if (!r.isConfirmed) return;

            Swal.fire({ title: 'Initiating Payment…', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            try {
                const payload = {
                    class_id: currentClassId,
                    amount,
                    payment_method: currentClassMethod,
                };
                if (currentClassMethod !== 'card') payload.phone_number = phone;

                const res = await fetch('{{ route("student.pay-class") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();

                if (!data.success) {
                    Swal.fire({ icon: 'error', title: 'Payment Failed', text: data.message, confirmButtonColor: '#DC2626' });
                    return;
                }

                // ── Card: redirect to MarzPay gateway ──────────────────────────────
                if (data.type === 'card_redirect' && data.redirect_url) {
                    closeClassPayModal();
                    Swal.fire({
                        icon: 'info',
                        title: 'Redirecting to Card Gateway',
                        text: 'You will be redirected to complete your card payment. Return here once done.',
                        confirmButtonColor: '#6B46C1',
                        confirmButtonText: 'Open Payment Page'
                    }).then(() => {
                        window.open(data.redirect_url, '_blank');
                    });
                    return;
                }

                // ── Mobile Money: show prompt & poll ───────────────────────────────
                closeClassPayModal();
                Swal.fire({
                    title: '📱 Check Your Phone!',
                    html: `<p>A payment prompt has been sent to <strong>${phone}</strong>.</p>
                                                   <p style="margin-top:10px;color:#7C748E;font-size:.85rem">Approve it on your phone to complete payment.</p>
                                                   <p style="margin-top:8px;color:#6B46C1;font-size:.8rem">Waiting for confirmation…</p>`,
                    icon: 'info',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: 'I\'ll check later',
                    confirmButtonColor: '#6B46C1',
                    showConfirmButton: false,
                });

                startPolling(data.reference, () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Successful! 🎉',
                        text: 'All lessons in this class are now unlocked.',
                        confirmButtonColor: '#6B46C1'
                    }).then(() => location.reload());
                });

            } catch (e) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.', confirmButtonColor: '#DC2626' });
            }
        }

        // ── Lesson Payment ────────────────────────────────
        function showLessonPaymentModal(lessonId, title, amount) {
            currentLessonId = lessonId;
            currentLessonRequired = Math.round(parseFloat(amount)) || 0;
            currentLessonMethod = null;
            document.getElementById('lessonPayTitle').textContent = title;
            document.getElementById('lessonPayAmountDisplay').textContent = 'UGX ' + currentLessonRequired.toLocaleString();
            document.getElementById('lessonPayAmount').value = currentLessonRequired;
            document.getElementById('lessonAmountHint').textContent = `Minimum: UGX ${currentLessonRequired.toLocaleString()}`;
            ['lessonMtn', 'lessonAirtel', 'lessonCard'].forEach(id => document.getElementById(id).classList.remove('selected'));
            document.getElementById('lessonPhoneField').style.display = 'none';
            document.getElementById('lessonPayPhone').value = '';
            document.getElementById('lessonPayModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeLessonPayModal() {
            document.getElementById('lessonPayModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        async function confirmLessonPayment() {
            if (!currentLessonMethod) {
                Swal.fire({ icon: 'warning', title: 'Select Payment Method', confirmButtonColor: '#6B46C1' });
                return;
            }

            const amountRaw = document.getElementById('lessonPayAmount').value;
            const amount = parseInt(amountRaw);

            // 1. Absolute floor — never allow below 500, no matter what the lesson costs
            if (!amountRaw || isNaN(amount) || amount < 500) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Amount',
                    text: 'Minimum amount is UGX 500.',
                    confirmButtonColor: '#6B46C1'
                });
                return;
            }

            // 2. Must also meet (or exceed) the lesson's actual required price
            if (amount < currentLessonRequired) {
                Swal.fire({
                    icon: 'error',
                    title: 'Insufficient Amount',
                    text: `This lesson requires at least UGX ${currentLessonRequired.toLocaleString()}.`,
                    confirmButtonColor: '#DC2626'
                });
                return;
            }

            const phone = document.getElementById('lessonPayPhone').value.trim();
            if (currentLessonMethod !== 'card' && !phone) {
                Swal.fire({ icon: 'warning', title: 'Phone Number Required', text: 'Please enter your mobile money phone number.', confirmButtonColor: '#6B46C1' });
                return;
            }

            const methodLabel = currentLessonMethod === 'card' ? 'Bank Card' :
                currentLessonMethod === 'mtn' ? 'MTN MoMo' : 'Airtel Money';

            const r = await Swal.fire({
                title: 'Confirm Payment',
                html: `Pay <strong>UGX ${amount.toLocaleString()}</strong> via <strong>${methodLabel}</strong>${phone ? '<br>to: <strong>' + phone + '</strong>' : ''}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6B46C1',
                confirmButtonText: 'Yes, Pay Now'
            });
            if (!r.isConfirmed) return;

            Swal.fire({ title: 'Initiating Payment…', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            try {
                const payload = {
                    lesson_id: currentLessonId,
                    amount,
                    payment_method: currentLessonMethod,
                    required_amount: currentLessonRequired,
                };
                if (currentLessonMethod !== 'card') payload.phone_number = phone;

                const res = await fetch('{{ route("student.pay-lesson") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();

                if (!data.success) {
                    Swal.fire({ icon: 'error', title: 'Payment Failed', text: data.message, confirmButtonColor: '#DC2626' });
                    return;
                }

                // ── Card redirect ──────────────────────────────────────────────────
                if (data.type === 'card_redirect' && data.redirect_url) {
                    closeLessonPayModal();
                    Swal.fire({
                        icon: 'info',
                        title: 'Redirecting to Card Gateway',
                        text: 'You will be redirected to complete your card payment.',
                        confirmButtonColor: '#6B46C1',
                        confirmButtonText: 'Open Payment Page'
                    }).then(() => {
                        window.open(data.redirect_url, '_blank');
                    });
                    return;
                }

                // ── Mobile Money polling ───────────────────────────────────────────
                closeLessonPayModal();
                Swal.fire({
                    title: '📱 Check Your Phone!',
                    html: `<p>A payment prompt has been sent to <strong>${phone}</strong>.</p>
                                                   <p style="margin-top:10px;color:#FFF;font-size:.85rem">Approve it on your phone to complete payment.</p>
                                                   <p style="margin-top:8px;color:#FFF;font-size:.8rem">Waiting for confirmation…</p>`,
                    icon: 'info',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: 'I\'ll check later',
                    showConfirmButton: false,
                });

                startPolling(data.reference, () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Lesson Unlocked! 🎉',
                        text: 'You can now access this lesson.',
                        confirmButtonColor: '#6B46C1'
                    }).then(() => location.reload());
                });

            } catch (e) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.', confirmButtonColor: '#DC2626' });
            }
        }

        // ── Material (PDF) Payment ─────────────────────────
        function showMaterialPaymentModal(materialId, title, amount) {
            currentMaterialId = materialId;
            currentMaterialRequired = Math.round(parseFloat(amount)) || 0;
            currentMaterialMethod = null;
            document.getElementById('materialPayTitle').textContent = title;
            document.getElementById('materialPayAmountDisplay').textContent = 'UGX ' + currentMaterialRequired.toLocaleString();
            document.getElementById('materialPayAmount').value = currentMaterialRequired;
            document.getElementById('materialAmountHint').textContent = `Minimum: UGX ${currentMaterialRequired.toLocaleString()}`;
            ['materialMtn', 'materialAirtel', 'materialCard'].forEach(id => document.getElementById(id).classList.remove('selected'));
            document.getElementById('materialPhoneField').style.display = 'none';
            document.getElementById('materialPayPhone').value = '';
            document.getElementById('materialPayModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeMaterialPayModal() {
            document.getElementById('materialPayModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        async function confirmMaterialPayment() {
            if (!currentMaterialMethod) {
                Swal.fire({ icon: 'warning', title: 'Select Payment Method', confirmButtonColor: '#6B46C1' });
                return;
            }

            const amountRaw = document.getElementById('materialPayAmount').value;
            const amount = parseInt(amountRaw);

            if (!amountRaw || isNaN(amount) || amount < 500) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Amount',
                    text: 'Minimum amount is UGX 500.',
                    confirmButtonColor: '#6B46C1'
                });
                return;
            }

            if (amount < currentMaterialRequired) {
                Swal.fire({
                    icon: 'error',
                    title: 'Insufficient Amount',
                    text: `This PDF requires at least UGX ${currentMaterialRequired.toLocaleString()}.`,
                    confirmButtonColor: '#DC2626'
                });
                return;
            }

            const phone = document.getElementById('materialPayPhone').value.trim();
            if (currentMaterialMethod !== 'card' && !phone) {
                Swal.fire({ icon: 'warning', title: 'Phone Number Required', text: 'Please enter your mobile money phone number.', confirmButtonColor: '#6B46C1' });
                return;
            }

            const methodLabel = currentMaterialMethod === 'card' ? 'Bank Card' :
                currentMaterialMethod === 'mtn' ? 'MTN MoMo' : 'Airtel Money';

            const r = await Swal.fire({
                title: 'Confirm Payment',
                html: `Pay <strong>UGX ${amount.toLocaleString()}</strong> via <strong>${methodLabel}</strong>${phone ? '<br>to: <strong>' + phone + '</strong>' : ''}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6B46C1',
                confirmButtonText: 'Yes, Pay Now'
            });
            if (!r.isConfirmed) return;

            Swal.fire({ title: 'Initiating Payment…', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            try {
                const payload = {
                    material_id: currentMaterialId,
                    amount,
                    payment_method: currentMaterialMethod,
                    required_amount: currentMaterialRequired,
                };
                if (currentMaterialMethod !== 'card') payload.phone_number = phone;

                const res = await fetch('{{ route("student.pay-material") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();

                if (!data.success) {
                    Swal.fire({ icon: 'error', title: 'Payment Failed', text: data.message, confirmButtonColor: '#DC2626' });
                    return;
                }

                // ── Card redirect ──────────────────────────────────────────────────
                if (data.type === 'card_redirect' && data.redirect_url) {
                    closeMaterialPayModal();
                    Swal.fire({
                        icon: 'info',
                        title: 'Redirecting to Card Gateway',
                        text: 'You will be redirected to complete your card payment.',
                        confirmButtonColor: '#6B46C1',
                        confirmButtonText: 'Open Payment Page'
                    }).then(() => {
                        window.open(data.redirect_url, '_blank');
                    });
                    return;
                }

                // ── Mobile Money polling ───────────────────────────────────────────
                closeMaterialPayModal();
                Swal.fire({
                    title: '📱 Check Your Phone!',
                    html: `<p>A payment prompt has been sent to <strong>${phone}</strong>.</p>
                                                   <p style="margin-top:10px;color:#FFF;font-size:.85rem">Approve it on your phone to complete payment.</p>
                                                   <p style="margin-top:8px;color:#FFF;font-size:.8rem">Waiting for confirmation…</p>`,
                    icon: 'info',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: 'I\'ll check later',
                    showConfirmButton: false,
                });

                startPolling(data.reference, () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'PDF Unlocked! 🎉',
                        text: 'You can now open this study material.',
                        confirmButtonColor: '#6B46C1'
                    }).then(() => location.reload());
                });

            } catch (e) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.', confirmButtonColor: '#DC2626' });
            }
        }

        // ── Quiz ──────────────────────────────────────────
        async function takeQuiz(examId, title, durationMinutes) {
            currentExamId = examId;
            Swal.fire({ title: 'Loading Quiz...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            try {
                const res = await fetch(`/exams/${examId}/take`, { headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                const data = await res.json();
                Swal.close();
                if (!data.success) { Swal.fire({ icon: 'error', title: 'Cannot Take Quiz', text: data.message }); return; }
                quizQuestions = data.questions;
                document.getElementById('quizModalTitle').innerHTML = `<i class="fas fa-question-circle"></i> ${title}`;
                renderQuizQuestions(data.quiz, data.questions, durationMinutes);
                document.querySelector('.quiz-modal-overlay').style.display = 'flex';
                document.body.style.overflow = 'hidden';
                if (durationMinutes > 0) startTimer(durationMinutes * 60);
            } catch (e) { Swal.close(); Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load quiz.' }); }
        }

        function renderQuizQuestions(quiz, questions, duration) {
            document.getElementById('quizResult').style.display = 'none';
            document.getElementById('quizSubmitBtn').style.display = 'inline-flex';
            document.getElementById('quizCloseBtn').style.display = 'none';
            const timer = document.getElementById('quizTimer');
            timer.style.display = duration > 0 ? 'block' : 'none';
            timer.dataset.duration = duration * 60;

            const container = document.getElementById('quizQuestions');
            container.innerHTML = `<div style="margin-bottom:16px;padding:12px;background:#f0f4ff;border-radius:12px;font-size:.82rem;color:#4338ca"><strong>Instructions:</strong> ${quiz.instructions || 'Answer all questions carefully.'} | Pass mark: ${quiz.pass_mark}%</div>` +
                questions.map((q, i) => `
                                        <div class="q-block">
                                            <div class="q-text">${i + 1}. ${q.question}</div>
                                            ${q.type === 'mcq' ? (Array.isArray(q.options) ? q.options : Object.values(q.options || {})).map((opt, oi) => `
                                                <label class="q-opt">
                                                    <input type="radio" name="q${q.id}" value="${opt}" style="width:auto"> ${opt}
                                                </label>`).join('') :
                        q.type === 'true_false' ? `
                                                <label class="q-opt"><input type="radio" name="q${q.id}" value="true" style="width:auto"> True</label>
                                                <label class="q-opt"><input type="radio" name="q${q.id}" value="false" style="width:auto"> False</label>` :
                            `<textarea name="q${q.id}" rows="3" style="width:100%;border:1.5px solid #e3e0f0;border-radius:10px;padding:10px;font-family:inherit;font-size:.82rem;resize:vertical" placeholder="Your answer..."></textarea>`}
                                        </div>`).join('');
        }

        function startTimer(seconds) {
            clearInterval(quizTimer);
            let remaining = seconds;
            const display = document.getElementById('timerDisplay');
            quizTimer = setInterval(() => {
                remaining--;
                const m = Math.floor(remaining / 60).toString().padStart(2, '0');
                const s = (remaining % 60).toString().padStart(2, '0');
                display.textContent = `${m}:${s}`;
                if (remaining <= 0) { clearInterval(quizTimer); submitQuiz(); }
            }, 1000);
        }

        async function submitQuiz() {
            clearInterval(quizTimer);
            const answers = [];
            quizQuestions.forEach(q => {
                let answer = '';
                if (q.type === 'mcq' || q.type === 'true_false') {
                    const sel = document.querySelector(`input[name="q${q.id}"]:checked`);
                    answer = sel ? sel.value : '';
                } else {
                    const ta = document.querySelector(`textarea[name="q${q.id}"]`);
                    answer = ta ? ta.value : '';
                }
                answers.push({ question_id: q.id, answer });
            });

            Swal.fire({ title: 'Submitting...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            try {
                const res = await fetch(`/exams/${currentExamId}/submit`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ answers }) });
                const data = await res.json();
                Swal.close();
                if (data.success) {
                    const r = data.result;
                    document.getElementById('quizSubmitBtn').style.display = 'none';
                    document.getElementById('quizTimer').style.display = 'none';
                    const resDiv = document.getElementById('quizResult');
                    resDiv.style.display = 'block';

                    if (r.is_passed) {
                        document.getElementById('quizCloseBtn').style.display = 'inline-flex';
                        resDiv.className = 'quiz-result passed';
                        resDiv.innerHTML = `<i class="fas fa-trophy"></i> Congratulations! You scored ${r.percentage}% (${r.score}/${r.total_marks}) — Quiz Passed! 🎉`;
                        setTimeout(() => location.reload(), 3000);
                    } else {
                        resDiv.className = 'quiz-result failed';
                        resDiv.innerHTML = `
                                        <i class="fas fa-times-circle"></i> You scored ${r.percentage}% (${r.score}/${r.total_marks}) — Need ${r.pass_mark ?? 60}% to pass.
                                        <div style="margin-top:12px;display:flex;align-items:center;justify-content:center;gap:10px">
                                            <button class="sl-btn-quiz" onclick="retryQuiz()">
                                                <i class="fas fa-redo"></i> Try Again
                                            </button>
                                        </div>`;
                        document.getElementById('quizCloseBtn').style.display = 'inline-flex';
                    }
                } else {
                    Swal.fire({ icon: 'error', title: 'Submission Failed', text: data.message });
                }
            } catch (e) { Swal.close(); Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to submit quiz.' }); }
        }

        function retryQuiz() {
            // Hide result panel and reset buttons
            const resDiv = document.getElementById('quizResult');
            resDiv.style.display = 'none';
            resDiv.innerHTML = '';
            document.getElementById('quizSubmitBtn').style.display = 'inline-flex';
            document.getElementById('quizCloseBtn').style.display = 'none';

            // Clear all selected answers and text inputs
            document.querySelectorAll('#quizQuestions input[type="radio"]').forEach(r => r.checked = false);
            document.querySelectorAll('#quizQuestions textarea').forEach(t => t.value = '');

            // Remove any correct/wrong highlight classes left from a previous attempt
            document.querySelectorAll('#quizQuestions .q-opt').forEach(opt => {
                opt.classList.remove('correct', 'wrong');
            });

            // Restart timer if the quiz had one
            const timerEl = document.getElementById('quizTimer');
            const duration = parseInt(timerEl.dataset.duration ?? 0);
            if (duration > 0) {
                timerEl.style.display = 'block';
                startTimer(duration);
            }
        }

        function closeQuizModal() {
            document.querySelector('.quiz-modal-overlay').style.display = 'none';
            document.body.style.overflow = '';
            clearInterval(quizTimer);
            location.reload();
        }

        async function showActivateClassModal(classId, className) {
            const confirmed = await Swal.fire({
                title: 'Activate Class?',
                html: `<p>You are about to activate <strong>${className}</strong>.</p>
                               <p style="margin-top:10px;font-size:.85rem;color:#FFF;">
                                   This will unlock the class and all its lessons for you.
                               </p>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6B46C1',
                confirmButtonText: '<i class="fas fa-unlock"></i> Yes, Activate',
                cancelButtonText: 'Cancel'
            });

            if (!confirmed.isConfirmed) return;

            Swal.fire({
                title: 'Activating Class…',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            try {
                const res = await fetch('{{ route("student.activate-class") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ class_id: classId })
                });

                const data = await res.json();

                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Class Activated! 🎉',
                        text: 'Your class and lessons are now unlocked.',
                        confirmButtonColor: '#16a34a',
                        confirmButtonText: 'OK'
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Activation Failed',
                        text: data.message,
                        confirmButtonColor: '#DC2626'
                    });
                }
            } catch (e) {
                Swal.fire(
                    {
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again.',
                        confirmButtonColor: '#DC2626'
                    });
            }
        }

        // ── Certificate eligibility check ─────────────────────────────────────
        async function checkCertEligibility(classId) {
            const banner = document.getElementById('cert-banner-' + classId);
            if (!banner) return;
            try {
                const res = await fetch(`/student/certificates/class/${classId}/check`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                const data = await res.json();

                if (data.eligible) {
                    banner.innerHTML = `
                            <div class="sl-cert-eligible">
                                <div class="sl-cert-icon-wrap">🎓</div>
                                <div class="sl-cert-info">
                                    <div class="sl-cert-title">🎉 Certificate Ready!</div>
                                    <div class="sl-cert-sub">You have completed all lessons and passed all quizzes for this class.</div>
                                </div>
                                <div class="sl-cert-actions">
                                    <a href="/student/certificates/class/${classId}/download" class="sl-cert-btn sl-cert-btn-gold">
                                        <i class="fas fa-download"></i> Download Certificate
                                    </a>
                                    <a href="javascript:void();" class="sl-cert-btn sl-cert-btn-outline" style="visibility: hidden;">
    <i class="fas fa-eye"></i> Preview
</a>
                                </div>
                            </div>`;
                } else {
                    const pct = data.lesson_progress_percentage || 0;
                    const done = data.completed_lessons || 0;
                    const total = data.total_lessons || 0;
                    const qpct = data.total_quizzes > 0
                        ? Math.round((data.passed_quizzes / data.total_quizzes) * 100)
                        : null;
                    const reasonText = data.reason || 'Complete all lessons and quizzes to earn your certificate.';
                    banner.innerHTML = `
                            <div class="sl-cert-locked">
                                <div class="sl-cert-locked-icon"><i class="fas fa-lock"></i></div>
                                <div class="sl-cert-locked-info">
                                    <div class="sl-cert-locked-title">Certificate Locked</div>
                                    <div style="font-size:.73rem;color:#6B6584;margin-bottom:4px;">${reasonText}</div>
                                    <div style="font-size:.7rem;color:#9892B0;">
                                        Lessons: ${done}/${total}
                                        ${qpct !== null ? ` &nbsp;·&nbsp; Quizzes: ${data.passed_quizzes}/${data.total_quizzes}` : ''}
                                    </div>
                                    <div class="sl-cert-progress-bar-wrap">
                                        <div class="sl-cert-progress-bar" style="width:${pct}%"></div>
                                    </div>
                                </div>
                            </div>`;
                }
            } catch (e) {
                if (banner) banner.innerHTML = '';
            }
        }

        // ── Report card live summary ────────────────────────────────────────
        async function loadReportCardSummary(classId) {
            const banner = document.getElementById('rc-banner-' + classId);
            if (!banner) return;
            try {
                const res = await fetch(`/student/report-card/class/${classId}/summary`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                const data = await res.json();

                if (!data.success) {
                    banner.innerHTML = '';
                    return;
                }

                const pct = data.overall_percentage !== null ? `${Number(data.overall_percentage).toFixed(1)}%` : '—';
                const grade = data.overall_grade || '—';
                const lessons = `${data.total_lessons_completed}/${data.total_lessons} lessons`;
                const quizzes = `${data.total_quizzes_taken}/${data.total_quizzes} quizzes`;
                const rank = data.rank_position ? `Rank ${data.rank_position}/${data.rank_out_of}` : null;

                banner.innerHTML = `
                        <div class="sl-rc-card">
                            <div class="sl-rc-icon-wrap"><i class="fas fa-chart-line"></i></div>
                            <div class="sl-rc-info">
                                <div class="sl-rc-title">Current Standing: ${grade} &nbsp;·&nbsp; ${pct}</div>
                                <div class="sl-rc-stats">
                                    <span class="sl-rc-stat-pill"><i class="fas fa-book"></i> ${lessons}</span>
                                    <span class="sl-rc-stat-pill"><i class="fas fa-question-circle"></i> ${quizzes}</span>
                                    ${rank ? `<span class="sl-rc-stat-pill"><i class="fas fa-trophy"></i> ${rank}</span>` : ''}
                                </div>
                            </div>
                            <div class="sl-rc-actions">
                                <a href="/student/report-card/class/${classId}/download" class="sl-rc-btn sl-rc-btn-blue">
                                    <i class="fas fa-download"></i> Download Report Card
                                </a>
                                <a href="/student/report-card/class/${classId}/preview" target="_blank" class="sl-rc-btn sl-rc-btn-outline">
                                    <i class="fas fa-eye"></i> Preview
                                </a>
                            </div>
                        </div>`;
            } catch (e) {
                if (banner) banner.innerHTML = '';
            }
        }

        // Run checks for every visible class card
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.sl-cert-section[data-class-id]').forEach(function (el) {
                if (el.id.startsWith('cert-section-')) {
                    checkCertEligibility(el.dataset.classId);
                } else if (el.id.startsWith('rc-section-')) {
                    loadReportCardSummary(el.dataset.classId);
                }
            });
        });
    </script>
@endsection