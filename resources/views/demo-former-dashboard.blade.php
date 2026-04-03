@extends('layouts.master2')

@section('css')
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700;800&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* ═══════════════════════════════════════════════
       ALHILAL DESIGN SYSTEM — STUDENT DASHBOARD
    ═══════════════════════════════════════════════ */
        :root {
            --purple: #6B46C1;
            --purple-dark: #4C2E8A;
            --purple-mid: #7C55CC;
            --purple-light: #EDE9FA;
            --purple-xlight: #F5F3FD;
            --red: #DC2626;
            --red-light: #FEE2E2;
            --red-dark: #9B1C1C;
            --gold: #D97706;
            --gold-light: #FEF3C7;
            --green: #16A34A;
            --green-light: #DCFCE7;
            --blue: #2563EB;
            --blue-light: #DBEAFE;
            --cream: #FDFBF7;
            --cream2: #F7F3EE;
            --ink: #1A0A2E;
            --ink2: #3B2459;
            --muted: #6B6584;
            --muted2: #9892B0;
            --border: rgba(107, 70, 193, 0.10);
            --border2: rgba(107, 70, 193, 0.20);
            --gradient: linear-gradient(135deg, var(--purple) 0%, var(--red) 100%);
            --gradient-soft: linear-gradient(135deg, #EDE9FA 0%, #FEE2E2 100%);
            --gradient-gold: linear-gradient(135deg, #D97706 0%, #F59E0B 100%);
            --gradient-green: linear-gradient(135deg, #16A34A 0%, #22C55E 100%);
            --sidebar-w: 260px;
            --header-h: 68px;
            --shadow-xs: 0 1px 6px rgba(107, 70, 193, 0.06);
            --shadow-sm: 0 2px 12px rgba(107, 70, 193, 0.08);
            --shadow-md: 0 6px 24px rgba(107, 70, 193, 0.12);
            --shadow-lg: 0 16px 48px rgba(107, 70, 193, 0.15);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            --radius-xl: 30px;
        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            border: none;
            background: none;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: var(--purple-light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--purple);
            border-radius: 10px;
        }

        /* ── SIDEBAR ── */
        .sd-sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--ink);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 200;
            transition: transform 0.3s ease;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sd-sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(26, 10, 46, 0.6);
            z-index: 199;
            backdrop-filter: blur(3px);
        }

        .sd-brand {
            padding: 24px 22px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sd-brand img {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .sd-brand-text {
            line-height: 1.3;
        }

        .sd-brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 0.92rem;
            font-weight: 700;
            color: white;
        }

        .sd-brand-sub {
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 400;
        }

        .sd-student-card {
            margin: 16px 14px;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sd-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
            font-family: 'Playfair Display', serif;
        }

        .sd-student-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: white;
            line-height: 1.3;
        }

        .sd-student-class {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.45);
            margin-top: 2px;
        }

        .sd-online-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4ade80;
            margin-left: auto;
            flex-shrink: 0;
            box-shadow: 0 0 6px rgba(74, 222, 128, 0.6);
            animation: blink 2s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .sd-nav {
            padding: 10px 0 20px;
            flex: 1;
        }

        .sd-nav-section {
            padding: 14px 20px 6px;
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.25);
        }

        .sd-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
            position: relative;
            border-radius: 0;
            margin: 1px 10px;
            border-radius: var(--radius-sm);
            cursor: pointer;
        }

        .sd-nav-item i {
            width: 20px;
            text-align: center;
            font-size: 0.95rem;
            flex-shrink: 0;
            transition: color 0.2s;
        }

        .sd-nav-item:hover {
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.85);
        }

        .sd-nav-item.active {
            background: var(--gradient);
            color: white;
            box-shadow: 0 4px 14px rgba(107, 70, 193, 0.4);
        }

        .sd-nav-item.active i {
            color: white;
        }

        .sd-nav-badge {
            margin-left: auto;
            background: var(--red);
            color: white;
            font-size: 0.62rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
            min-width: 20px;
            text-align: center;
        }

        .sd-sidebar-footer {
            padding: 16px 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
        }

        .sd-logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 11px 16px;
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.2);
            border-radius: var(--radius-sm);
            color: rgba(255, 100, 100, 0.8);
            font-size: 0.82rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .sd-logout-btn:hover {
            background: rgba(220, 38, 38, 0.2);
            color: #fc8b8b;
        }

        /* ── MAIN CONTENT ── */
        .sd-main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOP HEADER ── */
        .sd-header {
            height: var(--header-h);
            background: rgba(253, 251, 247, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-xs);
        }

        .sd-menu-toggle {
            display: none;
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            background: var(--purple-light);
            color: var(--purple);
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .sd-header-greeting {
            flex: 1;
        }

        .sd-header-greeting h2 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
        }

        .sd-header-greeting p {
            font-size: 0.75rem;
            color: var(--muted);
        }

        .sd-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sd-header-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            background: var(--cream2);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 0.9rem;
            position: relative;
            transition: all 0.2s;
            cursor: pointer;
        }

        .sd-header-icon-btn:hover {
            background: var(--purple-light);
            color: var(--purple);
            border-color: var(--border2);
        }

        .sd-notif-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--red);
            border: 1.5px solid var(--cream);
        }

        .sd-header-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 0.85rem;
            cursor: pointer;
            border: 2px solid var(--purple-light);
            font-family: 'Playfair Display', serif;
        }

        /* ── PAGE CONTENT ── */
        .sd-content {
            padding: 28px;
            flex: 1;
        }

        /* ── SECTION TITLES ── */
        .sd-section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .sd-section-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sd-section-title::before {
            content: '';
            width: 4px;
            height: 18px;
            background: var(--gradient);
            border-radius: 4px;
            display: inline-block;
        }

        .sd-view-all {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--purple);
            display: flex;
            align-items: center;
            gap: 5px;
            transition: gap 0.2s;
        }

        .sd-view-all:hover {
            gap: 8px;
        }

        /* ── WELCOME BANNER ── */
        .sd-welcome-banner {
            background: var(--ink);
            border-radius: var(--radius-xl);
            padding: 28px 36px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            position: relative;
            overflow: hidden;
        }

        .sd-welcome-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 10% 50%, rgba(107, 70, 193, 0.35) 0%, transparent 50%),
                radial-gradient(circle at 90% 20%, rgba(220, 38, 38, 0.25) 0%, transparent 50%);
        }

        .sd-welcome-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.03;
            background-image:
                repeating-linear-gradient(45deg, rgba(255, 255, 255, 0.5) 0px, rgba(255, 255, 255, 0.5) 1px, transparent 1px, transparent 60px),
                repeating-linear-gradient(-45deg, rgba(255, 255, 255, 0.5) 0px, rgba(255, 255, 255, 0.5) 1px, transparent 1px, transparent 60px);
        }

        .sd-welcome-left {
            position: relative;
            z-index: 2;
        }

        .sd-welcome-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 5px 14px;
            border-radius: 40px;
            font-size: 0.72rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 12px;
        }

        .sd-welcome-badge i {
            color: #4ade80;
        }

        .sd-welcome-left h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: white;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        .sd-welcome-left p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
            max-width: 420px;
        }

        .sd-welcome-actions {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
            flex-shrink: 0;
        }

        .sd-continue-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            background: var(--gradient);
            color: white;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.25s;
            box-shadow: 0 6px 20px rgba(107, 70, 193, 0.4);
            white-space: nowrap;
        }

        .sd-continue-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(107, 70, 193, 0.5);
            color: white;
        }

        .sd-streak {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.65);
        }

        .sd-streak i {
            color: var(--gold);
        }

        /* ── STAT CARDS ── */
        .sd-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .sd-stat-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 22px 20px;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: all 0.25s;
        }

        .sd-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: var(--border2);
        }

        .sd-stat-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .sd-stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .sd-stat-icon-purple {
            background: var(--purple-light);
            color: var(--purple);
        }

        .sd-stat-icon-red {
            background: var(--red-light);
            color: var(--red);
        }

        .sd-stat-icon-gold {
            background: var(--gold-light);
            color: var(--gold);
        }

        .sd-stat-icon-green {
            background: var(--green-light);
            color: var(--green);
        }

        .sd-stat-trend {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
        }

        .sd-trend-up {
            background: var(--green-light);
            color: var(--green);
        }

        .sd-trend-down {
            background: var(--red-light);
            color: var(--red);
        }

        .sd-stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1;
            margin-bottom: 5px;
        }

        .sd-stat-label {
            font-size: 0.78rem;
            color: var(--muted);
            font-weight: 500;
        }

        .sd-stat-bar {
            height: 4px;
            background: var(--cream2);
            border-radius: 4px;
            margin-top: 14px;
            overflow: hidden;
        }

        .sd-stat-bar-fill {
            height: 100%;
            border-radius: 4px;
            background: var(--gradient);
        }

        /* ── MAIN GRID ── */
        .sd-main-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
            margin-bottom: 28px;
        }

        /* ── PROGRESS OVERVIEW ── */
        .sd-progress-card {
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .sd-card-header {
            padding: 20px 24px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sd-card-body {
            padding: 20px 24px 24px;
        }

        .sd-subject-progress-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .sd-subject-prog-item {}

        .sd-subject-prog-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .sd-subject-prog-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sd-subject-prog-icon {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .sd-subject-prog-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--ink);
        }

        .sd-subject-prog-lessons {
            font-size: 0.72rem;
            color: var(--muted);
            margin-top: 1px;
        }

        .sd-subject-prog-pct {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--ink);
        }

        .sd-prog-bar {
            height: 8px;
            background: var(--cream2);
            border-radius: 8px;
            overflow: hidden;
        }

        .sd-prog-bar-fill {
            height: 100%;
            border-radius: 8px;
            transition: width 1s ease;
            position: relative;
        }

        .sd-prog-bar-fill::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            background: white;
            border-radius: 50%;
            border: 2px solid currentColor;
            opacity: 0.9;
        }

        /* ── QUICK ACTIONS ── */
        .sd-quick-panel {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .sd-quick-card {
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            padding: 20px;
        }

        .sd-quick-actions-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 16px;
        }

        .sd-quick-action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 16px 10px;
            background: var(--cream2);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--ink2);
            transition: all 0.2s;
        }

        .sd-quick-action-btn:hover {
            background: var(--purple-light);
            border-color: var(--border2);
            color: var(--purple);
            transform: translateY(-2px);
        }

        .sd-quick-action-btn i {
            font-size: 1.3rem;
        }

        .sd-quick-action-btn.btn-primary-action {
            background: var(--gradient);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(107, 70, 193, 0.3);
        }

        .sd-quick-action-btn.btn-primary-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(107, 70, 193, 0.4);
            background: var(--gradient);
            color: white;
        }

        /* ── ANNOUNCEMENT CARD ── */
        .sd-announce-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .sd-announce-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .sd-announce-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
        }

        .sd-announce-title {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 3px;
        }

        .sd-announce-text {
            font-size: 0.75rem;
            color: var(--muted);
            line-height: 1.5;
        }

        .sd-announce-time {
            font-size: 0.68rem;
            color: var(--muted2);
            margin-left: auto;
            flex-shrink: 0;
            padding-top: 2px;
        }

        /* ── LESSONS TABLE SECTION ── */
        .sd-lessons-section {
            margin-bottom: 28px;
        }

        .sd-tabs {
            display: flex;
            gap: 6px;
            margin-bottom: 20px;
        }

        .sd-tab {
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--muted);
            background: var(--cream2);
            border: 1.5px solid var(--border);
            cursor: pointer;
            transition: all 0.2s;
        }

        .sd-tab.active {
            background: var(--gradient);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(107, 70, 193, 0.28);
        }

        .sd-lessons-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .sd-lesson-card {
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            overflow: hidden;
            transition: all 0.25s;
        }

        .sd-lesson-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--border2);
        }

        .sd-lesson-card-top {
            padding: 18px 18px 14px;
            position: relative;
        }

        .sd-lesson-subject-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.68rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            margin-bottom: 10px;
        }

        .sd-lesson-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.35;
            margin-bottom: 8px;
        }

        .sd-lesson-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.72rem;
            color: var(--muted);
        }

        .sd-lesson-meta i {
            font-size: 0.68rem;
        }

        .sd-lesson-type-icon {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 32px;
            height: 32px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
        }

        .sd-lesson-card-bottom {
            padding: 12px 18px 16px;
            border-top: 1px solid var(--border);
            background: var(--cream);
        }

        .sd-lesson-progress-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.72rem;
            color: var(--muted);
        }

        .sd-lesson-prog-bar {
            height: 5px;
            background: var(--cream2);
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 12px;
        }

        .sd-lesson-prog-fill {
            height: 100%;
            border-radius: 5px;
            background: var(--gradient);
        }

        .sd-lesson-actions {
            display: flex;
            gap: 8px;
        }

        .sd-btn-view {
            flex: 1;
            padding: 8px;
            background: var(--red);
            color: white;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .sd-btn-view:hover {
            background: var(--red-dark);
            transform: translateY(-1px);
        }

        .sd-btn-quiz {
            flex: 1;
            padding: 8px;
            background: var(--purple-light);
            color: var(--purple);
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1.5px solid var(--border2);
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .sd-btn-quiz:hover {
            background: var(--purple);
            color: white;
            border-color: transparent;
        }

        .sd-btn-passed {
            flex: 1;
            padding: 8px;
            background: var(--green-light);
            color: var(--green);
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            pointer-events: none;
        }

        /* ── BOTTOM GRID ── */
        .sd-bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        /* ── LEADERBOARD ── */
        .sd-leaderboard-card {
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .sd-leader-list {
            padding: 4px 0;
        }

        .sd-leader-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 20px;
            transition: background 0.15s;
        }

        .sd-leader-item:hover {
            background: var(--cream);
        }

        .sd-leader-rank {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .rank-1 {
            background: var(--gradient-gold);
            color: white;
        }

        .rank-2 {
            background: linear-gradient(135deg, #94A3B8, #CBD5E1);
            color: white;
        }

        .rank-3 {
            background: linear-gradient(135deg, #D97706, #F59E0B);
            color: white;
        }

        .rank-other {
            background: var(--cream2);
            color: var(--muted);
        }

        .sd-leader-avatar-sm {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
            font-family: 'Playfair Display', serif;
        }

        .sd-leader-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--ink);
            flex: 1;
        }

        .sd-leader-name span {
            font-size: 0.7rem;
            color: var(--muted);
            font-weight: 400;
            display: block;
        }

        .sd-leader-score {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--purple);
        }

        .sd-leader-item.is-me {
            background: var(--purple-xlight);
            border-left: 3px solid var(--purple);
        }

        .sd-leader-item.is-me .sd-leader-name {
            color: var(--purple-dark);
        }

        /* ── CERTIFICATES ── */
        .sd-cert-list {
            padding: 4px 0;
        }

        .sd-cert-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }

        .sd-cert-item:last-child {
            border-bottom: none;
        }

        .sd-cert-item:hover {
            background: var(--cream);
        }

        .sd-cert-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .sd-cert-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 2px;
        }

        .sd-cert-date {
            font-size: 0.7rem;
            color: var(--muted);
        }

        .sd-cert-download {
            margin-left: auto;
            flex-shrink: 0;
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--purple-light);
            color: var(--purple);
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .sd-cert-download:hover {
            background: var(--purple);
            color: white;
        }

        /* ── UPCOMING EXAMS ── */
        .sd-exam-list {
            padding: 4px 0;
        }

        .sd-exam-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }

        .sd-exam-item:last-child {
            border-bottom: none;
        }

        .sd-exam-item:hover {
            background: var(--cream);
        }

        .sd-exam-date-box {
            width: 44px;
            flex-shrink: 0;
            text-align: center;
            background: var(--purple-light);
            border-radius: 10px;
            padding: 6px 4px;
            border: 1px solid var(--border2);
        }

        .sd-exam-day {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--purple);
            line-height: 1;
            font-family: 'Playfair Display', serif;
        }

        .sd-exam-month {
            font-size: 0.6rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sd-exam-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 2px;
        }

        .sd-exam-subject {
            font-size: 0.7rem;
            color: var(--muted);
        }

        .sd-exam-badge {
            margin-left: auto;
            flex-shrink: 0;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 700;
        }

        .badge-soon {
            background: var(--red-light);
            color: var(--red);
        }

        .badge-upcoming {
            background: var(--gold-light);
            color: var(--gold);
        }

        .badge-later {
            background: var(--blue-light);
            color: var(--blue);
        }

        /* ── MODAL OVERLAY ── */
        .sd-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 500;
            background: rgba(26, 10, 46, 0.8);
            backdrop-filter: blur(6px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .sd-modal.open {
            display: flex;
        }

        .sd-modal-box {
            background: white;
            border-radius: var(--radius-xl);
            padding: 32px;
            max-width: 480px;
            width: 100%;
            position: relative;
            animation: modal-pop 0.3s ease;
            max-height: 85vh;
            overflow-y: auto;
            border-top: 4px solid var(--purple);
        }

        @keyframes modal-pop {
            from {
                transform: translateY(-20px) scale(0.97);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .sd-modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--cream2);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .sd-modal-close:hover {
            background: var(--red-light);
            color: var(--red);
        }

        .sd-modal-icon {
            font-size: 2.5rem;
            color: var(--purple);
            margin-bottom: 12px;
        }

        .sd-modal-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .sd-modal-sub {
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .quiz-q-block {
            background: var(--cream2);
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 10px;
        }

        .quiz-q-block p {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 10px;
        }

        .quiz-opt {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 0.8rem;
            color: var(--ink);
            cursor: pointer;
            transition: 0.15s;
            margin: 3px 0;
        }

        .quiz-opt:hover {
            background: var(--purple-light);
        }

        .quiz-opt input {
            accent-color: var(--purple);
        }

        .quiz-result-box {
            border-radius: 14px;
            padding: 14px 16px;
            font-weight: 600;
            font-size: 0.88rem;
            text-align: center;
            margin-top: 12px;
        }

        .qr-pass {
            background: var(--green-light);
            color: #166534;
        }

        .qr-fail {
            background: var(--red-light);
            color: var(--red-dark);
        }

        .sd-submit-quiz-btn {
            width: 100%;
            padding: 13px;
            background: var(--gradient);
            color: white;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 14px;
            transition: all 0.25s;
            box-shadow: 0 6px 18px rgba(107, 70, 193, 0.3);
        }

        .sd-submit-quiz-btn:hover {
            box-shadow: 0 10px 24px rgba(107, 70, 193, 0.4);
            transform: translateY(-2px);
        }

        /* ── RESPONSIVE ── */
        @media(max-width:1200px) {
            .sd-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .sd-bottom-grid {
                grid-template-columns: 1fr 1fr;
            }

            .sd-lessons-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:960px) {
            .sd-main-grid {
                grid-template-columns: 1fr;
            }

            .sd-bottom-grid {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width:768px) {
            .sd-sidebar {
                transform: translateX(-100%);
            }

            .sd-sidebar.open {
                transform: translateX(0);
            }

            .sd-sidebar-overlay.open {
                display: block;
            }

            .sd-main {
                margin-left: 0;
            }

            .sd-menu-toggle {
                display: flex;
            }

            .sd-content {
                padding: 16px;
            }

            .sd-welcome-banner {
                flex-direction: column;
                align-items: flex-start;
                padding: 24px;
            }

            .sd-welcome-actions {
                align-items: flex-start;
                width: 100%;
            }

            .sd-lessons-grid {
                grid-template-columns: 1fr;
            }

            .sd-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:480px) {
            .sd-stats-grid {
                grid-template-columns: 1fr;
            }

            .sd-quick-actions-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
@endsection

@section('content')
    {{-- Sidebar Overlay --}}
    <div class="sd-sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- ════════════ SIDEBAR ════════════ --}}
    <aside class="sd-sidebar" id="sidebar">

        {{-- Brand --}}
        <div class="sd-brand">
            <img src="{{ asset('assets/images/alhilal_logo.jpeg') }}" alt="AlHilal Academy">
            <div class="sd-brand-text">
                <div class="sd-brand-name">AlHilal Academy</div>
                <div class="sd-brand-sub">Student Portal</div>
            </div>
        </div>

        {{-- Student card --}}
        <div class="sd-student-card">
            <div class="sd-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 2)) }}</div>
            <div>
                <div class="sd-student-name">{{ auth()->user()->name ?? 'Student Name' }}</div>
                <div class="sd-student-class">{{ auth()->user()->class ?? 'S.3 — Level 3' }}</div>
            </div>
            <div class="sd-online-dot"></div>
        </div>

        {{-- Navigation --}}
        <nav class="sd-nav">
            <div class="sd-nav-section">Main Menu</div>

            <a href="#" class="sd-nav-item active" data-section="overview">
                <i class="fas fa-grid-2"></i> Dashboard
            </a>
            <a href="#" class="sd-nav-item" data-section="lessons">
                <i class="fas fa-play-circle"></i> My Lessons
            </a>
            <a href="#" class="sd-nav-item" data-section="quizzes">
                <i class="fas fa-question-circle"></i> Quizzes
                <span class="sd-nav-badge">3</span>
            </a>
            <a href="#" class="sd-nav-item" data-section="exams">
                <i class="fas fa-pen-to-square"></i> Exams
            </a>
            <a href="#" class="sd-nav-item" data-section="reports">
                <i class="fas fa-chart-bar"></i> My Reports
            </a>
            <a href="#" class="sd-nav-item" data-section="certificates">
                <i class="fas fa-award"></i> Certificates
            </a>

            <div class="sd-nav-section">Resources</div>

            <a href="#" class="sd-nav-item" data-section="curriculum">
                <i class="fas fa-layer-group"></i> Curriculum
            </a>
            <a href="#" class="sd-nav-item" data-section="schedule">
                <i class="fas fa-calendar-days"></i> Schedule
            </a>
            <a href="#" class="sd-nav-item" data-section="notifications">
                <i class="fas fa-bell"></i> Notifications
                <span class="sd-nav-badge">5</span>
            </a>

            <div class="sd-nav-section">Account</div>

            <a href="#" class="sd-nav-item" data-section="profile">
                <i class="fas fa-user-circle"></i> My Profile
            </a>
            <a href="#" class="sd-nav-item" data-section="settings">
                <i class="fas fa-gear"></i> Settings
            </a>
            <a href="https://wa.me/256702082209?text={{ urlencode('Assalamu Alaikum! I need help with my lessons.') }}"
                target="_blank" class="sd-nav-item">
                <i class="fab fa-whatsapp" style="color:#4ade80;"></i> Ask Teacher
            </a>
        </nav>

        {{-- Sidebar footer --}}
        <div class="sd-sidebar-footer">
            <a href="{{ url('logout') }}" class="sd-logout-btn"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-arrow-right-from-bracket"></i> Sign Out
            </a>
            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display:none;">@csrf</form>
        </div>

    </aside>

    {{-- ════════════ MAIN AREA ════════════ --}}
    <div class="sd-main">

        {{-- ── TOP HEADER ── --}}
        <header class="sd-header">
            <button class="sd-menu-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <div class="sd-header-greeting">
                <h2>Assalamu Alaikum, {{ explode(' ', auth()->user()->name ?? 'Student')[0] }} 👋</h2>
                <p>{{ now()->format('l, d F Y') }} &nbsp;·&nbsp; Keep up the great work!</p>
            </div>
            <div class="sd-header-actions">
                <div class="sd-header-icon-btn" title="Search">
                    <i class="fas fa-magnifying-glass"></i>
                </div>
                <div class="sd-header-icon-btn" title="Notifications" onclick="openModal('notifModal')">
                    <i class="fas fa-bell"></i>
                    <span class="sd-notif-dot"></span>
                </div>
                <div class="sd-header-avatar" title="Profile">
                    {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 2)) }}
                </div>
            </div>
        </header>

        {{-- ── PAGE CONTENT ── --}}
        <div class="sd-content">

            {{-- ── WELCOME BANNER ── --}}
            <div class="sd-welcome-banner">
                <div class="sd-welcome-pattern"></div>
                <div class="sd-welcome-left">
                    <div class="sd-welcome-badge">
                        <i class="fas fa-circle-check"></i>
                        You completed 3 lessons this week
                    </div>
                    <h1>Continue Your<br>Islamic Journey</h1>
                    <p>You're 72% through <strong style="color:rgba(255,255,255,0.85);">Tafsir — Chapter 5</strong>. Pick
                        up right where you left off and keep your streak alive!</p>
                </div>
                <div class="sd-welcome-actions">
                    <a href="#" class="sd-continue-btn" onclick="openModal('lessonModal')">
                        <i class="fas fa-play"></i> Continue Lesson
                    </a>
                    <div class="sd-streak">
                        <i class="fas fa-fire"></i>
                        <span>7-day streak — keep it going!</span>
                    </div>
                </div>
            </div>

            {{-- ── STAT CARDS ── --}}
            <div class="sd-stats-grid">
                <div class="sd-stat-card">
                    <div class="sd-stat-card-top">
                        <div class="sd-stat-icon sd-stat-icon-purple"><i class="fas fa-play-circle"></i></div>
                        <div class="sd-stat-trend sd-trend-up"><i class="fas fa-arrow-up"></i> 12%</div>
                    </div>
                    <div class="sd-stat-num" data-count="34">34</div>
                    <div class="sd-stat-label">Lessons Completed</div>
                    <div class="sd-stat-bar">
                        <div class="sd-stat-bar-fill" style="width:68%;"></div>
                    </div>
                </div>
                <div class="sd-stat-card">
                    <div class="sd-stat-card-top">
                        <div class="sd-stat-icon sd-stat-icon-green"><i class="fas fa-check-circle"></i></div>
                        <div class="sd-stat-trend sd-trend-up"><i class="fas fa-arrow-up"></i> 8%</div>
                    </div>
                    <div class="sd-stat-num" data-count="28">28</div>
                    <div class="sd-stat-label">Quizzes Passed</div>
                    <div class="sd-stat-bar">
                        <div class="sd-stat-bar-fill" style="width:78%;background:var(--gradient-green);"></div>
                    </div>
                </div>
                <div class="sd-stat-card">
                    <div class="sd-stat-card-top">
                        <div class="sd-stat-icon sd-stat-icon-gold"><i class="fas fa-award"></i></div>
                        <div class="sd-stat-trend sd-trend-up"><i class="fas fa-arrow-up"></i> 1 new</div>
                    </div>
                    <div class="sd-stat-num" data-count="3">3</div>
                    <div class="sd-stat-label">Certificates Earned</div>
                    <div class="sd-stat-bar">
                        <div class="sd-stat-bar-fill" style="width:60%;background:var(--gradient-gold);"></div>
                    </div>
                </div>
                <div class="sd-stat-card">
                    <div class="sd-stat-card-top">
                        <div class="sd-stat-icon sd-stat-icon-red"><i class="fas fa-star"></i></div>
                        <div class="sd-stat-trend sd-trend-up"><i class="fas fa-arrow-up"></i> 5pts</div>
                    </div>
                    <div class="sd-stat-num" data-count="87">87</div>
                    <div class="sd-stat-label">Avg. Quiz Score %</div>
                    <div class="sd-stat-bar">
                        <div class="sd-stat-bar-fill" style="width:87%;"></div>
                    </div>
                </div>
            </div>

            {{-- ── MAIN GRID ── --}}
            <div class="sd-main-grid">

                {{-- Subject Progress --}}
                <div class="sd-progress-card">
                    <div class="sd-card-header">
                        <div class="sd-section-title">Subject Progress</div>
                        <a href="#" class="sd-view-all">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="sd-card-body">
                        <div class="sd-subject-progress-list">

                            <div class="sd-subject-prog-item">
                                <div class="sd-subject-prog-top">
                                    <div class="sd-subject-prog-info">
                                        <div class="sd-subject-prog-icon"
                                            style="background:var(--purple-light);color:var(--purple)"><i
                                                class="fas fa-book-quran"></i></div>
                                        <div>
                                            <div class="sd-subject-prog-name">Quran & Tafsir</div>
                                            <div class="sd-subject-prog-lessons">12 / 15 lessons</div>
                                        </div>
                                    </div>
                                    <div class="sd-subject-prog-pct">80%</div>
                                </div>
                                <div class="sd-prog-bar">
                                    <div class="sd-prog-bar-fill"
                                        style="width:80%;color:var(--purple);background:var(--gradient);"></div>
                                </div>
                            </div>

                            <div class="sd-subject-prog-item">
                                <div class="sd-subject-prog-top">
                                    <div class="sd-subject-prog-info">
                                        <div class="sd-subject-prog-icon"
                                            style="background:var(--red-light);color:var(--red)"><i
                                                class="fas fa-scroll"></i></div>
                                        <div>
                                            <div class="sd-subject-prog-name">Hadith Studies</div>
                                            <div class="sd-subject-prog-lessons">8 / 15 lessons</div>
                                        </div>
                                    </div>
                                    <div class="sd-subject-prog-pct">53%</div>
                                </div>
                                <div class="sd-prog-bar">
                                    <div class="sd-prog-bar-fill"
                                        style="width:53%;color:var(--red);background:linear-gradient(135deg,var(--red),#F87171);">
                                    </div>
                                </div>
                            </div>

                            <div class="sd-subject-prog-item">
                                <div class="sd-subject-prog-top">
                                    <div class="sd-subject-prog-info">
                                        <div class="sd-subject-prog-icon"
                                            style="background:var(--gold-light);color:var(--gold)"><i
                                                class="fas fa-scale-balanced"></i></div>
                                        <div>
                                            <div class="sd-subject-prog-name">Fiqh (Islamic Law)</div>
                                            <div class="sd-subject-prog-lessons">10 / 12 lessons</div>
                                        </div>
                                    </div>
                                    <div class="sd-subject-prog-pct">83%</div>
                                </div>
                                <div class="sd-prog-bar">
                                    <div class="sd-prog-bar-fill"
                                        style="width:83%;color:var(--gold);background:var(--gradient-gold);"></div>
                                </div>
                            </div>

                            <div class="sd-subject-prog-item">
                                <div class="sd-subject-prog-top">
                                    <div class="sd-subject-prog-info">
                                        <div class="sd-subject-prog-icon"
                                            style="background:var(--green-light);color:var(--green)"><i
                                                class="fas fa-language"></i></div>
                                        <div>
                                            <div class="sd-subject-prog-name">Arabic Language</div>
                                            <div class="sd-subject-prog-lessons">6 / 15 lessons</div>
                                        </div>
                                    </div>
                                    <div class="sd-subject-prog-pct">40%</div>
                                </div>
                                <div class="sd-prog-bar">
                                    <div class="sd-prog-bar-fill"
                                        style="width:40%;color:var(--green);background:var(--gradient-green);"></div>
                                </div>
                            </div>

                            <div class="sd-subject-prog-item">
                                <div class="sd-subject-prog-top">
                                    <div class="sd-subject-prog-info">
                                        <div class="sd-subject-prog-icon"
                                            style="background:var(--blue-light);color:var(--blue)"><i
                                                class="fas fa-mosque"></i></div>
                                        <div>
                                            <div class="sd-subject-prog-name">Seerah & History</div>
                                            <div class="sd-subject-prog-lessons">11 / 14 lessons</div>
                                        </div>
                                    </div>
                                    <div class="sd-subject-prog-pct">79%</div>
                                </div>
                                <div class="sd-prog-bar">
                                    <div class="sd-prog-bar-fill"
                                        style="width:79%;color:var(--blue);background:linear-gradient(135deg,var(--blue),#60A5FA);">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Right panel --}}
                <div class="sd-quick-panel">

                    {{-- Quick Actions --}}
                    <div class="sd-quick-card">
                        <div class="sd-section-title">Quick Actions</div>
                        <div class="sd-quick-actions-grid">
                            <button class="sd-quick-action-btn btn-primary-action" onclick="openModal('lessonModal')">
                                <i class="fas fa-play-circle"></i> Resume Lesson
                            </button>
                            <button class="sd-quick-action-btn" onclick="openModal('quizModal')">
                                <i class="fas fa-question-circle"></i> Take Quiz
                            </button>
                            <button class="sd-quick-action-btn">
                                <i class="fas fa-file-pdf"></i> PDF Notes
                            </button>
                            <button class="sd-quick-action-btn">
                                <i class="fas fa-award"></i> My Certs
                            </button>
                            <a href="https://wa.me/256702082209" target="_blank" class="sd-quick-action-btn"
                                style="color:var(--green);">
                                <i class="fab fa-whatsapp"></i> Chat Teacher
                            </a>
                            <button class="sd-quick-action-btn">
                                <i class="fas fa-chart-line"></i> My Reports
                            </button>
                        </div>
                    </div>

                    {{-- Announcements --}}
                    <div class="sd-quick-card">
                        <div class="sd-section-title">Announcements</div>
                        <div style="margin-top:14px;">
                            <div class="sd-announce-item">
                                <div class="sd-announce-icon" style="background:var(--red-light);color:var(--red);"><i
                                        class="fas fa-bullhorn"></i></div>
                                <div style="flex:1;">
                                    <div class="sd-announce-title">Termly Exams — April 2025</div>
                                    <div class="sd-announce-text">All S.3 exams begin April 28th. Ensure all lesson quizzes
                                        are passed before then.</div>
                                </div>
                                <div class="sd-announce-time">2h ago</div>
                            </div>
                            <div class="sd-announce-item">
                                <div class="sd-announce-icon" style="background:var(--gold-light);color:var(--gold);"><i
                                        class="fas fa-star"></i></div>
                                <div style="flex:1;">
                                    <div class="sd-announce-title">New: Fiqh Chapter 6 Uploaded</div>
                                    <div class="sd-announce-text">Ustadh Rashid has added 3 new video lessons to Fiqh,
                                        Level 3.</div>
                                </div>
                                <div class="sd-announce-time">1d ago</div>
                            </div>
                            <div class="sd-announce-item">
                                <div class="sd-announce-icon" style="background:var(--green-light);color:var(--green);"><i
                                        class="fas fa-certificate"></i></div>
                                <div style="flex:1;">
                                    <div class="sd-announce-title">Certificate Ready!</div>
                                    <div class="sd-announce-text">Your Level 2 completion certificate is ready to download.
                                    </div>
                                </div>
                                <div class="sd-announce-time">3d ago</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── LESSONS SECTION ── --}}
            <div class="sd-lessons-section">
                <div class="sd-section-head">
                    <div class="sd-section-title">My Lessons</div>
                    <a href="#" class="sd-view-all">View All Lessons <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="sd-tabs">
                    <button class="sd-tab active" data-tab="inprogress">In Progress</button>
                    <button class="sd-tab" data-tab="completed">Completed</button>
                    <button class="sd-tab" data-tab="todo">To Do</button>
                </div>
                <div class="sd-lessons-grid" id="lessonsGrid">
                    <!-- Rendered by JS -->
                </div>
            </div>

            {{-- ── BOTTOM GRID ── --}}
            <div class="sd-bottom-grid">

                {{-- Leaderboard --}}
                <div class="sd-leaderboard-card">
                    <div class="sd-card-header" style="padding:18px 20px 12px;">
                        <div class="sd-section-title">Class Leaderboard</div>
                        <span style="font-size:0.72rem;color:var(--muted);font-weight:500;">This Month</span>
                    </div>
                    <div class="sd-leader-list">
                        <div class="sd-leader-item">
                            <div class="sd-leader-rank rank-1"><i class="fas fa-crown" style="font-size:0.65rem;"></i>
                            </div>
                            <div class="sd-leader-avatar-sm">FA</div>
                            <div class="sd-leader-name">Fatuma Abubakar<span>98% avg score</span></div>
                            <div class="sd-leader-score">1,240 pts</div>
                        </div>
                        <div class="sd-leader-item">
                            <div class="sd-leader-rank rank-2">2</div>
                            <div class="sd-leader-avatar-sm" style="background:linear-gradient(135deg,#475569,#94A3B8);">
                                MK</div>
                            <div class="sd-leader-name">Muhammad Kato<span>94% avg score</span></div>
                            <div class="sd-leader-score">1,180 pts</div>
                        </div>
                        <div class="sd-leader-item is-me">
                            <div class="sd-leader-rank rank-3">3</div>
                            <div class="sd-leader-avatar-sm">{{ strtoupper(substr(auth()->user()->name ?? 'ST', 0, 2)) }}
                            </div>
                            <div class="sd-leader-name">{{ auth()->user()->name ?? 'You' }} <span
                                    style="color:var(--purple);">← You · 87% avg</span></div>
                            <div class="sd-leader-score" style="color:var(--purple);">1,090 pts</div>
                        </div>
                        <div class="sd-leader-item">
                            <div class="sd-leader-rank rank-other">4</div>
                            <div class="sd-leader-avatar-sm" style="background:linear-gradient(135deg,#B45309,#F59E0B);">
                                AN</div>
                            <div class="sd-leader-name">Aisha Nakimuli<span>82% avg score</span></div>
                            <div class="sd-leader-score">980 pts</div>
                        </div>
                        <div class="sd-leader-item">
                            <div class="sd-leader-rank rank-other">5</div>
                            <div class="sd-leader-avatar-sm" style="background:linear-gradient(135deg,#1D4ED8,#60A5FA);">
                                IS</div>
                            <div class="sd-leader-name">Ibrahim Ssemanda<span>78% avg score</span></div>
                            <div class="sd-leader-score">910 pts</div>
                        </div>
                    </div>
                </div>

                {{-- Certificates --}}
                <div class="sd-leaderboard-card">
                    <div class="sd-card-header" style="padding:18px 20px 12px;">
                        <div class="sd-section-title">My Certificates</div>
                        <a href="#" class="sd-view-all" style="font-size:0.72rem;">All <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="sd-cert-list">
                        <div class="sd-cert-item">
                            <div class="sd-cert-icon" style="background:var(--gold-light);color:var(--gold)"><i
                                    class="fas fa-medal"></i></div>
                            <div>
                                <div class="sd-cert-name">Level 2 Completion</div>
                                <div class="sd-cert-date"><i class="fas fa-calendar-check"
                                        style="font-size:0.65rem;margin-right:4px;"></i>Issued: March 15, 2025</div>
                            </div>
                            <div class="sd-cert-download"><i class="fas fa-download"></i></div>
                        </div>
                        <div class="sd-cert-item">
                            <div class="sd-cert-icon" style="background:var(--purple-light);color:var(--purple)"><i
                                    class="fas fa-award"></i></div>
                            <div>
                                <div class="sd-cert-name">Quran Recitation — P.6</div>
                                <div class="sd-cert-date"><i class="fas fa-calendar-check"
                                        style="font-size:0.65rem;margin-right:4px;"></i>Issued: Jan 10, 2025</div>
                            </div>
                            <div class="sd-cert-download"><i class="fas fa-download"></i></div>
                        </div>
                        <div class="sd-cert-item">
                            <div class="sd-cert-icon" style="background:var(--green-light);color:var(--green)"><i
                                    class="fas fa-certificate"></i></div>
                            <div>
                                <div class="sd-cert-name">Level 1 — Full Completion</div>
                                <div class="sd-cert-date"><i class="fas fa-calendar-check"
                                        style="font-size:0.65rem;margin-right:4px;"></i>Issued: Sept 5, 2024</div>
                            </div>
                            <div class="sd-cert-download"><i class="fas fa-download"></i></div>
                        </div>
                        <div class="sd-cert-item" style="opacity:0.5;pointer-events:none;">
                            <div class="sd-cert-icon" style="background:var(--cream2);color:var(--muted)"><i
                                    class="fas fa-lock"></i></div>
                            <div>
                                <div class="sd-cert-name">Level 3 Completion</div>
                                <div class="sd-cert-date">Complete all S.3 lessons to unlock</div>
                            </div>
                            <div class="sd-cert-download" style="background:var(--cream2);color:var(--muted);"><i
                                    class="fas fa-lock"></i></div>
                        </div>
                    </div>
                </div>

                {{-- Upcoming Exams --}}
                <div class="sd-leaderboard-card">
                    <div class="sd-card-header" style="padding:18px 20px 12px;">
                        <div class="sd-section-title">Upcoming Exams</div>
                        <a href="#" class="sd-view-all" style="font-size:0.72rem;">Schedule <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="sd-exam-list">
                        <div class="sd-exam-item">
                            <div class="sd-exam-date-box">
                                <div class="sd-exam-day">28</div>
                                <div class="sd-exam-month">Apr</div>
                            </div>
                            <div>
                                <div class="sd-exam-name">Tafsir — Term Exam</div>
                                <div class="sd-exam-subject"><i class="fas fa-clock"
                                        style="font-size:0.65rem;margin-right:3px;"></i>90 mins · S.3 Level</div>
                            </div>
                            <div class="sd-exam-badge badge-soon">5 days</div>
                        </div>
                        <div class="sd-exam-item">
                            <div class="sd-exam-date-box">
                                <div class="sd-exam-day">02</div>
                                <div class="sd-exam-month">May</div>
                            </div>
                            <div>
                                <div class="sd-exam-name">Arabic Language Test</div>
                                <div class="sd-exam-subject"><i class="fas fa-clock"
                                        style="font-size:0.65rem;margin-right:3px;"></i>60 mins · S.3 Level</div>
                            </div>
                            <div class="sd-exam-badge badge-upcoming">9 days</div>
                        </div>
                        <div class="sd-exam-item">
                            <div class="sd-exam-date-box">
                                <div class="sd-exam-day">10</div>
                                <div class="sd-exam-month">May</div>
                            </div>
                            <div>
                                <div class="sd-exam-name">Fiqh — Chapter Assessment</div>
                                <div class="sd-exam-subject"><i class="fas fa-clock"
                                        style="font-size:0.65rem;margin-right:3px;"></i>75 mins · S.3 Level</div>
                            </div>
                            <div class="sd-exam-badge badge-later">17 days</div>
                        </div>
                        <div class="sd-exam-item">
                            <div class="sd-exam-date-box">
                                <div class="sd-exam-day">18</div>
                                <div class="sd-exam-month">May</div>
                            </div>
                            <div>
                                <div class="sd-exam-name">Seerah — Term End Exam</div>
                                <div class="sd-exam-subject"><i class="fas fa-clock"
                                        style="font-size:0.65rem;margin-right:3px;"></i>90 mins · S.3 Level</div>
                            </div>
                            <div class="sd-exam-badge badge-later">25 days</div>
                        </div>
                    </div>
                </div>

            </div>

        </div>{{-- /sd-content --}}
    </div>{{-- /sd-main --}}

    {{-- ════════════ MODALS ════════════ --}}

    {{-- Lesson Modal --}}
    <div class="sd-modal" id="lessonModal">
        <div class="sd-modal-box">
            <button class="sd-modal-close" onclick="closeModal('lessonModal')"><i class="fas fa-times"></i></button>
            <div class="sd-modal-icon"><i class="fas fa-play-circle"></i></div>
            <div class="sd-modal-title">Tafsir — Chapter 5, Lesson 3</div>
            <div class="sd-modal-sub">Video Lesson · 24 minutes · Ustadh Rashid Al-Farouq</div>
            <div
                style="background:var(--ink);border-radius:16px;aspect-ratio:16/9;display:flex;align-items:center;justify-content:center;margin-bottom:18px;position:relative;overflow:hidden;">
                <div
                    style="position:absolute;inset:0;background:radial-gradient(circle at center,rgba(107,70,193,0.3),transparent 70%);">
                </div>
                <button
                    style="width:60px;height:60px;border-radius:50%;background:var(--gradient);color:white;font-size:1.3rem;border:none;cursor:pointer;box-shadow:0 8px 24px rgba(107,70,193,0.5);z-index:2;transition:transform 0.2s;"
                    onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="fas fa-play"></i>
                </button>
            </div>
            <div style="display:flex;gap:10px;">
                <button onclick="closeModal('lessonModal')"
                    style="flex:1;padding:11px;background:var(--cream2);border-radius:50px;font-size:0.85rem;font-weight:600;color:var(--muted);border:1px solid var(--border);">Close</button>
                <button onclick="closeModal('lessonModal');openModal('quizModal')"
                    style="flex:1;padding:11px;background:var(--gradient);color:white;border-radius:50px;font-size:0.85rem;font-weight:600;box-shadow:0 4px 14px rgba(107,70,193,0.3);">Take
                    Quiz <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
    </div>

    {{-- Quiz Modal --}}
    <div class="sd-modal" id="quizModal">
        <div class="sd-modal-box">
            <button class="sd-modal-close" onclick="closeModal('quizModal')"><i class="fas fa-times"></i></button>
            <div class="sd-modal-icon" style="color:var(--red);"><i class="fas fa-question-circle"></i></div>
            <div class="sd-modal-title" id="qzTitle">Tafsir — Chapter 5 Quiz</div>
            <div class="sd-modal-sub">Answer all questions. You need 60% or above to pass.</div>
            <div id="qzQuestions"></div>
            <div class="quiz-result-box" id="qzResult" style="display:none;"></div>
            <button class="sd-submit-quiz-btn" id="qzSubmitBtn">
                <i class="fas fa-check"></i> Submit Answers
            </button>
        </div>
    </div>

    {{-- Notification Modal --}}
    <div class="sd-modal" id="notifModal">
        <div class="sd-modal-box" style="max-width:400px;">
            <button class="sd-modal-close" onclick="closeModal('notifModal')"><i class="fas fa-times"></i></button>
            <div class="sd-modal-title" style="margin-bottom:18px;">Notifications</div>
            <div style="display:flex;flex-direction:column;gap:0;">
                <div
                    style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:var(--red-light);color:var(--red);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-bell"></i></div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:600;color:var(--ink);margin-bottom:3px;">Exam Reminder:
                            Tafsir in 5 days</div>
                        <div style="font-size:0.75rem;color:var(--muted);">Make sure you've passed all 15 lesson quizzes
                            before the exam.</div>
                    </div>
                </div>
                <div
                    style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:var(--gold-light);color:var(--gold);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-book-open"></i></div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:600;color:var(--ink);margin-bottom:3px;">3 New Fiqh
                            Lessons Added</div>
                        <div style="font-size:0.75rem;color:var(--muted);">Ustadh Rashid uploaded Chapter 6 with video +
                            PDF notes.</div>
                    </div>
                </div>
                <div
                    style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:var(--green-light);color:var(--green);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-award"></i></div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:600;color:var(--ink);margin-bottom:3px;">Certificate
                            Ready to Download</div>
                        <div style="font-size:0.75rem;color:var(--muted);">Your Level 2 completion certificate is now
                            available.</div>
                    </div>
                </div>
                <div
                    style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:var(--purple-light);color:var(--purple);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-trophy"></i></div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:600;color:var(--ink);margin-bottom:3px;">You're #3 on the
                            Class Leaderboard!</div>
                        <div style="font-size:0.75rem;color:var(--muted);">Keep passing quizzes to move up this month.
                        </div>
                    </div>
                </div>
                <div style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:var(--blue-light);color:var(--blue);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-comment"></i></div>
                    <div>
                        <div style="font-size:0.82rem;font-weight:600;color:var(--ink);margin-bottom:3px;">Teacher replied
                            to your question</div>
                        <div style="font-size:0.75rem;color:var(--muted);">Ustadh Rashid answered your question on Hadith
                            Ch. 3.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ── MODAL HELPERS ────────────────────────────────────────
        function openModal(id) {
            document.getElementById(id).classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
            document.body.style.overflow = '';
        }
        window.addEventListener('click', e => {
            document.querySelectorAll('.sd-modal').forEach(m => {
                if (e.target === m) closeModal(m.id);
            });
        });

        // ── SIDEBAR TOGGLE ────────────────────────────────────────
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }

        // ── NAV ACTIVE STATE ─────────────────────────────────────
        document.querySelectorAll('.sd-nav-item[data-section]').forEach(item => {
            item.addEventListener('click', e => {
                e.preventDefault();
                document.querySelectorAll('.sd-nav-item').forEach(n => n.classList.remove('active'));
                item.classList.add('active');
                if (window.innerWidth < 768) toggleSidebar();
            });
        });

        // ── LESSON DATA ──────────────────────────────────────────
        const lessonData = {
            inprogress: [{
                    title: 'Tafsir — Surah Al-Baqarah Part 3',
                    subject: 'Quran & Tafsir',
                    icon: 'fas fa-book-quran',
                    subjColor: 'purple',
                    type: 'video',
                    typeIcon: 'fas fa-video',
                    duration: '24 min',
                    progress: 72,
                    passed: false
                },
                {
                    title: 'Principles of Hadith Authentication',
                    subject: 'Hadith Studies',
                    icon: 'fas fa-scroll',
                    subjColor: 'red',
                    type: 'audio',
                    typeIcon: 'fas fa-headphones',
                    duration: '18 min',
                    progress: 45,
                    passed: false
                },
                {
                    title: 'Wudu & Salah — Advanced Rules',
                    subject: 'Fiqh',
                    icon: 'fas fa-scale-balanced',
                    subjColor: 'gold',
                    type: 'pdf',
                    typeIcon: 'fas fa-file-pdf',
                    duration: '30 min',
                    progress: 88,
                    passed: false
                },
            ],
            completed: [{
                    title: 'Introduction to Tafsir Methodology',
                    subject: 'Quran & Tafsir',
                    icon: 'fas fa-book-quran',
                    subjColor: 'purple',
                    type: 'video',
                    typeIcon: 'fas fa-video',
                    duration: '20 min',
                    progress: 100,
                    passed: true
                },
                {
                    title: 'The Life of Prophet Muhammad ﷺ',
                    subject: 'Seerah',
                    icon: 'fas fa-mosque',
                    subjColor: 'blue',
                    type: 'video',
                    typeIcon: 'fas fa-video',
                    duration: '32 min',
                    progress: 100,
                    passed: true
                },
                {
                    title: 'Arabic Alphabet & Pronunciation',
                    subject: 'Arabic',
                    icon: 'fas fa-language',
                    subjColor: 'green',
                    type: 'pdf',
                    typeIcon: 'fas fa-file-pdf',
                    duration: '15 min',
                    progress: 100,
                    passed: true
                },
            ],
            todo: [{
                    title: 'Hadith of Jibreel — Commentary',
                    subject: 'Hadith Studies',
                    icon: 'fas fa-scroll',
                    subjColor: 'red',
                    type: 'video',
                    typeIcon: 'fas fa-video',
                    duration: '28 min',
                    progress: 0,
                    passed: false
                },
                {
                    title: 'Zakat — Calculation & Rules',
                    subject: 'Fiqh',
                    icon: 'fas fa-scale-balanced',
                    subjColor: 'gold',
                    type: 'audio',
                    typeIcon: 'fas fa-headphones',
                    duration: '22 min',
                    progress: 0,
                    passed: false
                },
                {
                    title: 'Arabic Verb Conjugation Basics',
                    subject: 'Arabic',
                    icon: 'fas fa-language',
                    subjColor: 'green',
                    type: 'pdf',
                    typeIcon: 'fas fa-file-pdf',
                    duration: '20 min',
                    progress: 0,
                    passed: false
                },
            ]
        };

        const colorMap = {
            purple: {
                tag: 'background:var(--purple-light);color:var(--purple)',
                icon: 'background:var(--purple-light);color:var(--purple)'
            },
            red: {
                tag: 'background:var(--red-light);color:var(--red)',
                icon: 'background:var(--red-light);color:var(--red)'
            },
            gold: {
                tag: 'background:var(--gold-light);color:var(--gold)',
                icon: 'background:var(--gold-light);color:var(--gold)'
            },
            blue: {
                tag: 'background:var(--blue-light);color:var(--blue)',
                icon: 'background:var(--blue-light);color:var(--blue)'
            },
            green: {
                tag: 'background:var(--green-light);color:var(--green)',
                icon: 'background:var(--green-light);color:var(--green)'
            },
        };

        let activeTab = 'inprogress';

        function renderLessons(tab) {
            const grid = document.getElementById('lessonsGrid');
            const lessons = lessonData[tab];
            grid.innerHTML = lessons.map((l, i) => `
        <div class="sd-lesson-card">
            <div class="sd-lesson-card-top">
                <div class="sd-lesson-type-icon" style="${colorMap[l.subjColor].icon}"><i class="${l.typeIcon}"></i></div>
                <span class="sd-lesson-subject-tag" style="${colorMap[l.subjColor].tag}">
                    <i class="${l.icon}" style="font-size:0.65rem;"></i> ${l.subject}
                </span>
                <div class="sd-lesson-title">${l.title}</div>
                <div class="sd-lesson-meta">
                    <span><i class="fas fa-clock"></i> ${l.duration}</span>
                    <span><i class="fas fa-${l.type}"></i> ${l.type.charAt(0).toUpperCase()+l.type.slice(1)}</span>
                    ${l.progress > 0 ? `<span><i class="fas fa-chart-simple"></i> ${l.progress}%</span>` : ''}
                </div>
            </div>
            <div class="sd-lesson-card-bottom">
                ${l.progress > 0 ? `
                    <div class="sd-lesson-progress-row"><span>Progress</span><span>${l.progress}%</span></div>
                    <div class="sd-lesson-prog-bar"><div class="sd-lesson-prog-fill" style="width:${l.progress}%;"></div></div>
                    ` : '<div style="height:4px;margin-bottom:12px;"></div>'}
                <div class="sd-lesson-actions">
                    <button class="sd-btn-view" onclick="openModal('lessonModal')">
                        <i class="fas fa-play"></i> ${l.progress > 0 && l.progress < 100 ? 'Resume' : l.progress === 100 ? 'Review' : 'Start'}
                    </button>
                    ${l.passed
                        ? '<span class="sd-btn-passed"><i class="fas fa-check-circle"></i> Quiz Passed</span>'
                        : `<button class="sd-btn-quiz" onclick="openModal('quizModal')"><i class="fas fa-question-circle"></i> Quiz</button>`
                    }
                </div>
            </div>
        </div>
    `).join('');
        }

        // ── TABS ─────────────────────────────────────────────────
        document.querySelectorAll('.sd-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.sd-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                activeTab = tab.dataset.tab;
                renderLessons(activeTab);
            });
        });

        // ── QUIZ LOGIC ───────────────────────────────────────────
        const quizData = [{
                q: 'What is the primary linguistic meaning of "Tafsir"?',
                opts: ['Explanation & Elucidation', 'Memorisation', 'Recitation', 'Translation'],
                correct: 0
            },
            {
                q: 'Which companion was most renowned for his knowledge of Tafsir?',
                opts: ['Abu Bakr (RA)', 'Abdullah ibn Masood (RA)', 'Bilal (RA)', 'Umar (RA)'],
                correct: 1
            },
            {
                q: 'What is a prerequisite for giving a valid Tafsir?',
                opts: ['Knowledge of Arabic language', 'Only memorising Quran', 'Knowing all scholars',
                    'Writing skill'],
                correct: 0
            },
            {
                q: 'What does "Tafsir bil-Mathur" refer to?',
                opts: ['Tafsir by personal opinion', 'Tafsir based on narrations & tradition', 'Tafsir through science',
                    'Tafsir by dreams'
                ],
                correct: 1
            },
            {
                q: 'Which surah is this chapter\'s Tafsir focused on?',
                opts: ['Al-Fatiha', 'Al-Baqarah', 'Al-Imran', 'An-Nisa'],
                correct: 1
            }
        ];

        function renderQuiz() {
            document.getElementById('qzQuestions').innerHTML = quizData.map((q, i) => `
        <div class="quiz-q-block">
            <p>${i+1}. ${q.q}</p>
            ${q.opts.map((opt, oi) => `
                    <label class="quiz-opt">
                        <input type="radio" name="qz${i}" value="${oi}" style="width:auto;"> ${opt}
                    </label>`).join('')}
        </div>`).join('');
            document.getElementById('qzResult').style.display = 'none';
        }

        document.getElementById('qzSubmitBtn').addEventListener('click', () => {
            let correct = 0;
            quizData.forEach((q, i) => {
                const sel = document.querySelector(`input[name="qz${i}"]:checked`);
                if (sel && parseInt(sel.value) === q.correct) correct++;
            });
            const pct = Math.round((correct / quizData.length) * 100);
            const passed = pct >= 60;
            const rb = document.getElementById('qzResult');
            rb.style.display = 'block';
            rb.className = `quiz-result-box ${passed ? 'qr-pass' : 'qr-fail'}`;
            rb.innerHTML = passed ?
                `<i class="fas fa-check-circle"></i> Excellent! You scored ${pct}% (${correct}/${quizData.length}) — Quiz Passed!` :
                `<i class="fas fa-times-circle"></i> You scored ${pct}% — You need 60% to pass. Review the lesson and try again.`;
            if (passed) {
                Swal.fire({
                    title: 'Quiz Passed! 🎉',
                    html: `Congratulations! You scored <strong>${pct}%</strong>.`,
                    icon: 'success',
                    confirmButtonColor: '#6B46C1',
                    timer: 3000
                });
            }
        });

        // ── INIT ─────────────────────────────────────────────────
        renderLessons('inprogress');
        renderQuiz();
    </script>
@endsection
