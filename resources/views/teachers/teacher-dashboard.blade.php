@extends('layouts.master2')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.css">

<style>
/* ── ROOT VARIABLES (matching homepage) ── */
:root {
    --purple:        #6B46C1;
    --purple-dark:   #4C2E8A;
    --purple-mid:    #7C3AED;
    --purple-light:  #EDE9FA;
    --red:           #DC2626;
    --red-light:     #FEE2E2;
    --red-dark:      #9B1C1C;
    --gold:          #D97706;
    --gold-light:    #FEF3C7;
    --green:         #16A34A;
    --green-light:   #DCFCE7;
    --cream:         #FDFBF7;
    --cream2:        #F7F3EE;
    --ink:           #1A0A2E;
    --ink2:          #3B2459;
    --muted:         #6B6584;
    --border:        rgba(107,70,193,0.12);
    --border2:       rgba(107,70,193,0.22);
    --gradient:      linear-gradient(135deg, var(--purple) 0%, var(--red) 100%);
    --gradient-soft: linear-gradient(135deg, #EDE9FA 0%, #FEE2E2 100%);
    --shadow-sm:     0 2px 12px rgba(107,70,193,0.08);
    --shadow-md:     0 8px 32px rgba(107,70,193,0.12);
    --shadow-lg:     0 20px 60px rgba(107,70,193,0.16);
    --shadow-xl:     0 32px 80px rgba(107,70,193,0.2);
    --sidebar-w:     270px;
    --topbar-h:      68px;
}

*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--ink);
    overflow-x: hidden;
}

::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--purple-light); }
::-webkit-scrollbar-thumb { background: var(--purple); border-radius: 10px; }

/* ── TYPOGRAPHY ── */
h1,h2,h3,h4 { font-family: 'Playfair Display', serif; line-height: 1.2; }

/* ── LAYOUT SHELL ── */
.dash-shell {
    display: flex;
    min-height: 100vh;
}

/* ══════════════════════════════════
   SIDEBAR
══════════════════════════════════ */
.sidebar {
    width: var(--sidebar-w);
    background: var(--ink);
    position: fixed;
    top: 0; left: 0; bottom: 0;
    z-index: 200;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    overflow-x: hidden;
    transition: transform 0.3s ease;
}

/* Sidebar background orbs */
.sidebar::before {
    content: '';
    position: absolute;
    width: 250px; height: 250px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(107,70,193,0.25) 0%, transparent 70%);
    top: -60px; right: -60px;
    pointer-events: none;
}
.sidebar::after {
    content: '';
    position: absolute;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(220,38,38,0.15) 0%, transparent 70%);
    bottom: 100px; left: -60px;
    pointer-events: none;
}

/* Logo area */
.sidebar-brand {
    padding: 24px 24px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    position: relative; z-index: 2;
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
}
.sidebar-brand-icon {
    width: 44px; height: 44px;
    border-radius: 14px;
    background: var(--gradient);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    color: white;
    box-shadow: 0 6px 20px rgba(107,70,193,0.4);
    flex-shrink: 0;
}
.sidebar-brand-text { flex: 1; overflow: hidden; }
.sidebar-brand-name {
    font-family: 'Playfair Display', serif;
    font-size: 0.95rem;
    font-weight: 700;
    color: white;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sidebar-brand-sub {
    font-size: 0.65rem;
    color: rgba(255,255,255,0.45);
    font-weight: 400;
    letter-spacing: 0.5px;
}

/* Teacher profile pill */
.sidebar-teacher {
    margin: 20px 16px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 18px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative; z-index: 2;
}
.teacher-avatar {
    width: 42px; height: 42px;
    border-radius: 50%;
    background: var(--gradient);
    display: flex; align-items: center; justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
    border: 2px solid rgba(255,255,255,0.2);
}
.teacher-info { flex: 1; overflow: hidden; }
.teacher-name {
    font-size: 0.85rem;
    font-weight: 600;
    color: white;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.teacher-role {
    font-size: 0.68rem;
    color: rgba(255,255,255,0.45);
    margin-top: 2px;
}
.teacher-status {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #4ade80;
    box-shadow: 0 0 8px rgba(74,222,128,0.6);
    flex-shrink: 0;
}

/* Nav section labels */
.nav-label {
    padding: 16px 24px 6px;
    font-size: 0.62rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.25);
    font-weight: 600;
    position: relative; z-index: 2;
}

/* Nav links */
.nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 16px 11px 24px;
    color: rgba(255,255,255,0.55);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 0;
    transition: all 0.2s ease;
    position: relative; z-index: 2;
    margin: 1px 0;
}
.nav-link:hover {
    color: rgba(255,255,255,0.9);
    background: rgba(255,255,255,0.06);
}
.nav-link.active {
    color: white;
    background: rgba(107,70,193,0.35);
    border-left: 3px solid var(--purple);
    padding-left: 21px;
}
.nav-link.active .nav-icon {
    color: #C084FC;
}
.nav-icon {
    width: 20px;
    text-align: center;
    font-size: 0.9rem;
    flex-shrink: 0;
}
.nav-badge {
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
.nav-badge-gold {
    background: var(--gold);
}

/* Sidebar bottom */
.sidebar-footer {
    margin-top: auto;
    padding: 16px;
    border-top: 1px solid rgba(255,255,255,0.08);
    position: relative; z-index: 2;
}
.sidebar-footer-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    border-radius: 12px;
    color: rgba(255,255,255,0.5);
    text-decoration: none;
    font-size: 0.82rem;
    font-weight: 500;
    transition: all 0.2s;
    width: 100%;
    background: none;
    border: none;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
}
.sidebar-footer-btn:hover {
    background: rgba(220,38,38,0.15);
    color: #FCA5A5;
}

/* ══════════════════════════════════
   MAIN CONTENT
══════════════════════════════════ */
.main-content {
    margin-left: var(--sidebar-w);
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* ── TOP BAR ── */
.topbar {
    height: var(--topbar-h);
    background: rgba(253,251,247,0.92);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0; z-index: 100;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 32px;
}
.topbar-left {
    display: flex;
    align-items: center;
    gap: 16px;
}
.topbar-page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--ink);
}
.topbar-breadcrumb {
    font-size: 0.78rem;
    color: var(--muted);
}
.topbar-breadcrumb span { color: var(--purple); }

.topbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
}

.topbar-search {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--cream2);
    border: 1px solid var(--border2);
    border-radius: 40px;
    padding: 8px 16px;
    font-size: 0.82rem;
    color: var(--muted);
    width: 220px;
    transition: all 0.2s;
}
.topbar-search:focus-within {
    border-color: var(--purple);
    background: white;
    box-shadow: 0 0 0 3px rgba(107,70,193,0.1);
}
.topbar-search input {
    border: none; background: none; outline: none;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.82rem; color: var(--ink); width: 100%;
}
.topbar-search input::placeholder { color: var(--muted); }

.topbar-btn {
    width: 38px; height: 38px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    background: var(--cream2);
    border: 1px solid var(--border);
    color: var(--muted);
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s;
    position: relative;
    text-decoration: none;
}
.topbar-btn:hover {
    background: var(--purple-light);
    color: var(--purple);
    border-color: var(--border2);
}
.topbar-btn .dot {
    position: absolute;
    top: 6px; right: 6px;
    width: 8px; height: 8px;
    background: var(--red);
    border-radius: 50%;
    border: 2px solid var(--cream);
}

.topbar-avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: var(--gradient);
    display: flex; align-items: center; justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    border: 2px solid var(--purple-light);
    box-shadow: var(--shadow-sm);
    transition: all 0.2s;
}
.topbar-avatar:hover {
    box-shadow: var(--shadow-md);
    transform: scale(1.05);
}

/* ── PAGE BODY ── */
.page-body {
    flex: 1;
    padding: 32px;
    display: flex;
    flex-direction: column;
    gap: 28px;
}

/* ── WELCOME BANNER ── */
.welcome-banner {
    background: linear-gradient(135deg, var(--ink) 0%, #2D0F5C 50%, #4A1A1A 100%);
    border-radius: 24px;
    padding: 32px 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}
.welcome-banner::before {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg, transparent, transparent 60px, rgba(255,255,255,0.02) 60px, rgba(255,255,255,0.02) 61px),
        repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(255,255,255,0.02) 60px, rgba(255,255,255,0.02) 61px);
}
.welcome-orb-1 {
    position: absolute;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(107,70,193,0.3) 0%, transparent 70%);
    top: -80px; right: 100px;
    pointer-events: none;
}
.welcome-orb-2 {
    position: absolute;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(220,38,38,0.2) 0%, transparent 70%);
    bottom: -60px; right: 40px;
    pointer-events: none;
}
.welcome-text { position: relative; z-index: 2; }
.welcome-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    padding: 5px 14px;
    border-radius: 40px;
    font-size: 0.72rem;
    color: rgba(255,255,255,0.7);
    letter-spacing: 1.5px;
    text-transform: uppercase;
    font-weight: 600;
    margin-bottom: 14px;
}
.welcome-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #4ade80;
    box-shadow: 0 0 8px rgba(74,222,128,0.6);
    animation: pulse-dot 2s ease-in-out infinite;
}
@keyframes pulse-dot {
    0%,100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.3); }
}
.welcome-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: white;
    margin-bottom: 8px;
}
.welcome-title span {
    background: linear-gradient(135deg, #C084FC, #F87171);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.welcome-sub { font-size: 0.9rem; color: rgba(255,255,255,0.55); }

.welcome-actions { position: relative; z-index: 2; display: flex; gap: 10px; align-items: center; }
.btn-banner {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 22px;
    border-radius: 40px;
    font-weight: 600; font-size: 0.85rem;
    text-decoration: none; border: none; cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all 0.25s;
}
.btn-banner-primary {
    background: var(--gradient);
    color: white;
    box-shadow: 0 6px 20px rgba(107,70,193,0.35);
}
.btn-banner-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(107,70,193,0.45); color: white; }
.btn-banner-ghost {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    color: white;
    backdrop-filter: blur(8px);
}
.btn-banner-ghost:hover { background: rgba(255,255,255,0.18); color: white; }

/* ── KPI STATS ROW ── */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}
.kpi-card {
    background: white;
    border-radius: 20px;
    padding: 24px;
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
    transition: all 0.25s;
}
.kpi-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--gradient);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s;
}
.kpi-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
}
.kpi-card:hover::before { transform: scaleX(1); }

.kpi-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 16px; }
.kpi-icon {
    width: 46px; height: 46px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
}
.kpi-icon-purple { background: var(--purple-light); color: var(--purple); }
.kpi-icon-red    { background: var(--red-light);    color: var(--red);    }
.kpi-icon-gold   { background: var(--gold-light);   color: var(--gold);   }
.kpi-icon-green  { background: var(--green-light);  color: var(--green);  }

.kpi-trend {
    display: flex; align-items: center; gap: 4px;
    font-size: 0.72rem; font-weight: 600;
    padding: 3px 9px; border-radius: 20px;
}
.kpi-trend-up   { background: var(--green-light); color: var(--green); }
.kpi-trend-down { background: var(--red-light);   color: var(--red);   }

.kpi-num {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1;
    margin-bottom: 4px;
}
.kpi-label { font-size: 0.8rem; color: var(--muted); font-weight: 500; }
.kpi-sub { font-size: 0.72rem; color: var(--muted); margin-top: 8px; padding-top: 8px; border-top: 1px solid var(--border); }
.kpi-sub strong { color: var(--ink); }

/* ── TWO-COLUMN GRID ── */
.cols-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px;
}
.cols-3 {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 22px;
}

/* ── CARD BASE ── */
.card {
    background: white;
    border-radius: 20px;
    border: 1px solid var(--border);
    overflow: hidden;
}
.card-header {
    padding: 22px 24px 18px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--ink);
}
.card-subtitle { font-size: 0.78rem; color: var(--muted); margin-top: 2px; }
.card-body { padding: 24px; }
.card-link {
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--purple);
    text-decoration: none;
    display: flex; align-items: center; gap: 5px;
}
.card-link:hover { color: var(--purple-dark); }

/* ── CHART CONTAINER ── */
.chart-wrap { position: relative; height: 240px; }

/* ── MY CLASSES ── */
.class-list { display: flex; flex-direction: column; gap: 0; }
.class-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 0;
    border-bottom: 1px solid var(--border);
    transition: background 0.2s;
}
.class-item:last-child { border-bottom: none; }
.class-color-bar {
    width: 4px; height: 42px;
    border-radius: 4px;
    flex-shrink: 0;
}
.class-info { flex: 1; }
.class-name { font-size: 0.9rem; font-weight: 600; color: var(--ink); margin-bottom: 3px; }
.class-meta { font-size: 0.74rem; color: var(--muted); display: flex; gap: 12px; }
.class-meta i { margin-right: 3px; }
.class-actions { display: flex; gap: 8px; }
.btn-sm-action {
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 0.74rem;
    font-weight: 600;
    border: none; cursor: pointer;
    text-decoration: none;
    display: inline-flex; align-items: center; gap: 5px;
    transition: all 0.2s;
    font-family: 'DM Sans', sans-serif;
}
.btn-sm-purple {
    background: var(--purple-light);
    color: var(--purple);
}
.btn-sm-purple:hover { background: var(--purple); color: white; }
.btn-sm-outline {
    background: transparent;
    border: 1px solid var(--border2);
    color: var(--muted);
}
.btn-sm-outline:hover { border-color: var(--purple); color: var(--purple); }

/* ── UPCOMING SESSIONS ── */
.session-list { display: flex; flex-direction: column; gap: 12px; }
.session-item {
    display: flex;
    gap: 14px;
    align-items: flex-start;
}
.session-time-col { text-align: center; flex-shrink: 0; }
.session-time {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1;
}
.session-ampm { font-size: 0.65rem; color: var(--muted); font-weight: 500; text-transform: uppercase; }
.session-connector {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0 2px;
}
.session-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    border: 2px solid var(--purple);
    background: white;
    flex-shrink: 0;
}
.session-line {
    width: 2px;
    flex: 1;
    background: var(--border2);
    min-height: 30px;
}
.session-info {
    flex: 1;
    background: var(--cream);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 12px 16px;
    transition: all 0.2s;
}
.session-info:hover { border-color: var(--purple); box-shadow: var(--shadow-sm); }
.session-name { font-size: 0.88rem; font-weight: 600; color: var(--ink); margin-bottom: 4px; }
.session-tags { display: flex; gap: 6px; flex-wrap: wrap; }
.session-tag {
    font-size: 0.68rem; font-weight: 600;
    padding: 2px 8px; border-radius: 20px;
    background: var(--purple-light); color: var(--purple);
}
.session-tag-red   { background: var(--red-light); color: var(--red); }
.session-tag-gold  { background: var(--gold-light); color: var(--gold); }
.session-tag-green { background: var(--green-light); color: var(--green); }

/* ── RECENT STUDENTS ── */
.student-table { width: 100%; border-collapse: collapse; }
.student-table th {
    text-align: left;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    color: var(--muted);
    padding: 0 16px 12px;
    border-bottom: 1px solid var(--border);
}
.student-table td {
    padding: 14px 16px;
    font-size: 0.85rem;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}
.student-table tr:last-child td { border-bottom: none; }
.student-table tbody tr { transition: background 0.15s; }
.student-table tbody tr:hover { background: var(--cream2); }

.student-cell { display: flex; align-items: center; gap: 10px; }
.student-ava {
    width: 34px; height: 34px;
    border-radius: 50%;
    background: var(--gradient);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 0.8rem;
    flex-shrink: 0;
}
.student-ava-2  { background: linear-gradient(135deg, var(--gold) 0%, var(--red) 100%); }
.student-ava-3  { background: linear-gradient(135deg, var(--green) 0%, var(--purple) 100%); }
.student-ava-4  { background: linear-gradient(135deg, #0EA5E9 0%, var(--purple) 100%); }
.student-ava-5  { background: linear-gradient(135deg, var(--red) 0%, var(--gold) 100%); }

.student-name  { font-weight: 600; color: var(--ink); font-size: 0.85rem; }
.student-class { font-size: 0.72rem; color: var(--muted); }

.progress-mini-wrap { display: flex; align-items: center; gap: 8px; }
.progress-mini-bar {
    flex: 1; height: 6px;
    background: var(--purple-light);
    border-radius: 40px;
    overflow: hidden;
}
.progress-mini-fill {
    height: 100%;
    border-radius: 40px;
    background: var(--gradient);
}
.progress-mini-pct { font-size: 0.75rem; font-weight: 600; color: var(--ink); white-space: nowrap; }

.status-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 20px;
    font-size: 0.7rem; font-weight: 600;
}
.status-active   { background: var(--green-light);  color: var(--green); }
.status-pending  { background: var(--gold-light);   color: var(--gold);  }
.status-inactive { background: var(--red-light);    color: var(--red);   }

/* ── MINI ACTIVITY FEED ── */
.activity-list { display: flex; flex-direction: column; }
.activity-item {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    padding: 14px 0;
    border-bottom: 1px solid var(--border);
}
.activity-item:last-child { border-bottom: none; }
.activity-icon {
    width: 36px; height: 36px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
}
.act-purple { background: var(--purple-light); color: var(--purple); }
.act-red    { background: var(--red-light);    color: var(--red);    }
.act-gold   { background: var(--gold-light);   color: var(--gold);   }
.act-green  { background: var(--green-light);  color: var(--green);  }

.activity-text { flex: 1; }
.activity-msg  { font-size: 0.83rem; color: var(--ink); font-weight: 500; line-height: 1.4; }
.activity-msg strong { color: var(--purple); }
.activity-time { font-size: 0.7rem; color: var(--muted); margin-top: 3px; }

/* ── QUICK ACTIONS ── */
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}
.qa-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 20px 12px;
    background: white;
    border: 1px solid var(--border);
    border-radius: 18px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.25s;
    position: relative;
    overflow: hidden;
    font-family: 'DM Sans', sans-serif;
}
.qa-btn::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: var(--gradient);
    transform: scaleX(0);
    transition: transform 0.25s;
    transform-origin: left;
}
.qa-btn:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: var(--border2); }
.qa-btn:hover::before { transform: scaleX(1); }
.qa-icon {
    width: 46px; height: 46px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
}
.qa-label { font-size: 0.8rem; font-weight: 600; color: var(--ink); text-align: center; }

/* ── ASSIGNMENT CARDS ── */
.assignment-list { display: flex; flex-direction: column; gap: 12px; }
.assignment-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    background: var(--cream);
    border: 1px solid var(--border);
    border-radius: 14px;
    transition: all 0.2s;
}
.assignment-item:hover { border-color: var(--purple); box-shadow: var(--shadow-sm); }
.assignment-icon {
    width: 40px; height: 40px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.95rem;
    flex-shrink: 0;
}
.assignment-info { flex: 1; }
.assignment-name { font-size: 0.87rem; font-weight: 600; color: var(--ink); margin-bottom: 3px; }
.assignment-meta { font-size: 0.73rem; color: var(--muted); display: flex; gap: 10px; }
.assignment-right { text-align: right; }
.assignment-due { font-size: 0.72rem; font-weight: 600; color: var(--red); margin-bottom: 4px; }
.assignment-submissions { font-size: 0.72rem; color: var(--muted); }
.assignment-btn {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 600;
    background: var(--purple-light);
    color: var(--purple);
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s;
    font-family: 'DM Sans', sans-serif;
}
.assignment-btn:hover { background: var(--purple); color: white; }

/* ── NOTIFICATION DROPDOWN ── */
.notif-dropdown {
    position: absolute;
    top: calc(var(--topbar-h) + 6px);
    right: 80px;
    width: 340px;
    background: white;
    border: 1px solid var(--border2);
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    z-index: 300;
    display: none;
    overflow: hidden;
}
.notif-dropdown.open { display: block; animation: slideDown 0.2s ease; }
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.notif-head {
    padding: 16px 20px 14px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
}
.notif-head-title { font-size: 0.9rem; font-weight: 700; color: var(--ink); font-family: 'Playfair Display', serif; }
.notif-mark-all { font-size: 0.72rem; color: var(--purple); cursor: pointer; font-weight: 600; }
.notif-item {
    display: flex; gap: 12px; align-items: flex-start;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    transition: background 0.15s;
    cursor: pointer;
}
.notif-item:last-child { border-bottom: none; }
.notif-item:hover { background: var(--cream2); }
.notif-item.unread { background: var(--purple-light); }
.notif-item.unread:hover { background: #E4DCF8; }
.notif-item-icon {
    width: 36px; height: 36px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem;
    flex-shrink: 0;
}
.notif-item-text { flex: 1; }
.notif-item-msg { font-size: 0.82rem; color: var(--ink); line-height: 1.4; }
.notif-item-msg strong { color: var(--ink); }
.notif-item-time { font-size: 0.68rem; color: var(--muted); margin-top: 3px; }

/* ── PROFILE DROPDOWN ── */
.profile-dropdown {
    position: absolute;
    top: calc(var(--topbar-h) + 6px);
    right: 32px;
    width: 220px;
    background: white;
    border: 1px solid var(--border2);
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    z-index: 300;
    display: none;
    overflow: hidden;
}
.profile-dropdown.open { display: block; animation: slideDown 0.2s ease; }
.profile-dropdown-head {
    padding: 18px 20px;
    background: var(--gradient);
    text-align: center;
}
.profile-dropdown-ava {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 1.2rem;
    margin: 0 auto 8px;
    border: 2px solid rgba(255,255,255,0.3);
}
.profile-dropdown-name { font-size: 0.9rem; font-weight: 700; color: white; }
.profile-dropdown-role { font-size: 0.72rem; color: rgba(255,255,255,0.7); margin-top: 2px; }
.profile-dropdown-item {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 20px;
    font-size: 0.83rem;
    color: var(--ink);
    text-decoration: none;
    transition: background 0.15s;
    font-weight: 500;
    border-bottom: 1px solid var(--border);
    cursor: pointer;
    border: none; width: 100%;
    background: none; font-family: 'DM Sans', sans-serif;
    text-align: left;
}
.profile-dropdown-item:last-child { border-bottom: none; }
.profile-dropdown-item:hover { background: var(--cream2); }
.profile-dropdown-item i { width: 16px; color: var(--purple); font-size: 0.85rem; }
.profile-dropdown-item.danger { color: var(--red); }
.profile-dropdown-item.danger i { color: var(--red); }

/* ── MOBILE OVERLAY ── */
.sidebar-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(26,10,46,0.5);
    backdrop-filter: blur(3px);
    z-index: 190;
}
.hamburger {
    display: none;
    width: 38px; height: 38px;
    border-radius: 10px;
    background: var(--cream2);
    border: 1px solid var(--border);
    color: var(--ink);
    align-items: center; justify-content: center;
    font-size: 1rem;
    cursor: pointer;
}

/* ── RESPONSIVE ── */
@media (max-width: 1200px) {
    .kpi-grid { grid-template-columns: repeat(2, 1fr); }
    .quick-actions-grid { grid-template-columns: repeat(4, 1fr); }
}
@media (max-width: 900px) {
    .cols-2 { grid-template-columns: 1fr; }
    .cols-3 { grid-template-columns: 1fr; }
    .sidebar { transform: translateX(-100%); }
    .sidebar.mobile-open { transform: translateX(0); }
    .sidebar-overlay.active { display: block; }
    .main-content { margin-left: 0; }
    .hamburger { display: flex; }
    .topbar-search { display: none; }
    .welcome-banner { flex-direction: column; gap: 20px; align-items: flex-start; }
    .page-body { padding: 16px; }
}
@media (max-width: 600px) {
    .kpi-grid { grid-template-columns: 1fr; }
    .quick-actions-grid { grid-template-columns: repeat(2, 1fr); }
    .welcome-title { font-size: 1.4rem; }
}
</style>
@endsection

@section('content')

{{-- Sidebar Overlay (mobile) --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="dash-shell">

    {{-- ══════════════════ SIDEBAR ══════════════════ --}}
    <aside class="sidebar" id="sidebar">

        {{-- Brand --}}
        <a href="{{ url('home') }}" class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="sidebar-brand-text">
                <div class="sidebar-brand-name">AlHilal Academy</div>
                <div class="sidebar-brand-sub">Teacher Portal</div>
            </div>
        </a>

        {{-- Teacher profile --}}
        <div class="sidebar-teacher">
            <div class="teacher-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 1)) }}
            </div>
            <div class="teacher-info">
                <div class="teacher-name">{{ auth()->user()->name ?? 'Teacher Name' }}</div>
                <div class="teacher-role">Islamic Studies · Senior</div>
            </div>
            <div class="teacher-status"></div>
        </div>

        {{-- Nav: Core --}}
        <div class="nav-label">Core</div>
        <a href="{{ url('teacher.dashboard') }}" class="nav-link active">
            <i class="fas fa-th-large nav-icon"></i>
            Dashboard
        </a>
        <a href="{{ url('teacher.classes') ?? '#' }}" class="nav-link">
            <i class="fas fa-chalkboard nav-icon"></i>
            My Classes
            <span class="nav-badge">6</span>
        </a>
        <a href="{{ url('teacher.students') ?? '#' }}" class="nav-link">
            <i class="fas fa-users nav-icon"></i>
            Students
        </a>
        <a href="{{ url('teacher.schedule') ?? '#' }}" class="nav-link">
            <i class="fas fa-calendar-alt nav-icon"></i>
            Schedule
        </a>
        <a href="{{ url('teacher.attendance') ?? '#' }}" class="nav-link">
            <i class="fas fa-clipboard-check nav-icon"></i>
            Attendance
        </a>

        {{-- Nav: Content --}}
        <div class="nav-label">Content</div>
        <a href="{{ url('teacher.lessons') ?? '#' }}" class="nav-link">
            <i class="fas fa-book-open nav-icon"></i>
            Lessons
        </a>
        <a href="{{ url('teacher.assignments') ?? '#' }}" class="nav-link">
            <i class="fas fa-tasks nav-icon"></i>
            Assignments
            <span class="nav-badge nav-badge-gold">3</span>
        </a>
        <a href="{{ url('teacher.quizzes') ?? '#' }}" class="nav-link">
            <i class="fas fa-pencil-alt nav-icon"></i>
            Quizzes
        </a>
        <a href="{{ url('teacher.resources') ?? '#' }}" class="nav-link">
            <i class="fas fa-folder nav-icon"></i>
            Resources
        </a>

        {{-- Nav: Communication --}}
        <div class="nav-label">Communication</div>
        <a href="{{ url('teacher.messages') ?? '#' }}" class="nav-link">
            <i class="fas fa-comment-dots nav-icon"></i>
            Messages
            <span class="nav-badge">5</span>
        </a>
        <a href="{{ url('teacher.announcements') ?? '#' }}" class="nav-link">
            <i class="fas fa-bullhorn nav-icon"></i>
            Announcements
        </a>
        <a href="{{ url('teacher.reports') ?? '#' }}" class="nav-link">
            <i class="fas fa-chart-bar nav-icon"></i>
            Reports
        </a>

        {{-- Footer --}}
        <div class="sidebar-footer">
            <a href="{{ url('teacher.profile') ?? '#' }}" class="sidebar-footer-btn">
                <i class="fas fa-user-cog"></i> Profile Settings
            </a>
            <form method="POST" action="{{ url('logout') }}">
                @csrf
                <button type="submit" class="sidebar-footer-btn">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </button>
            </form>
        </div>

    </aside>
    {{-- /sidebar --}}

    {{-- ══════════════════ MAIN ══════════════════ --}}
    <div class="main-content">

        {{-- TOP BAR --}}
        <div class="topbar">
            <div class="topbar-left">
                {{-- Mobile hamburger --}}
                <button class="hamburger" id="hamburger" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <div class="topbar-page-title">Dashboard</div>
                    <div class="topbar-breadcrumb">Home / <span>Teacher Dashboard</span></div>
                </div>
            </div>

            <div class="topbar-right">
                <div class="topbar-search">
                    <i class="fas fa-search" style="color:var(--muted);font-size:0.8rem;flex-shrink:0;"></i>
                    <input type="text" placeholder="Search students, classes…">
                </div>

                {{-- Notification --}}
                <button class="topbar-btn" id="notifBtn" onclick="toggleDropdown('notifDropdown','notifBtn')">
                    <i class="fas fa-bell"></i>
                    <span class="dot"></span>
                </button>

                {{-- Messages --}}
                <a href="#" class="topbar-btn">
                    <i class="fas fa-comment-dots"></i>
                    <span class="dot" style="background:var(--gold);"></span>
                </a>

                {{-- Avatar --}}
                <div class="topbar-avatar" id="profileBtn" onclick="toggleDropdown('profileDropdown','profileBtn')">
                    {{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 1)) }}
                </div>
            </div>
        </div>

        {{-- NOTIFICATION DROPDOWN --}}
        <div class="notif-dropdown" id="notifDropdown">
            <div class="notif-head">
                <div class="notif-head-title">Notifications</div>
                <span class="notif-mark-all">Mark all read</span>
            </div>
            <div class="notif-item unread">
                <div class="notif-item-icon act-purple"><i class="fas fa-user-plus"></i></div>
                <div class="notif-item-text">
                    <div class="notif-item-msg"><strong>Aisha Kamara</strong> enrolled in Fiqh Level 3</div>
                    <div class="notif-item-time">2 minutes ago</div>
                </div>
            </div>
            <div class="notif-item unread">
                <div class="notif-item-icon act-gold"><i class="fas fa-exclamation-circle"></i></div>
                <div class="notif-item-text">
                    <div class="notif-item-msg">Assignment <strong>"Tajweed Rules Ch.4"</strong> deadline in 2 days</div>
                    <div class="notif-item-time">1 hour ago</div>
                </div>
            </div>
            <div class="notif-item">
                <div class="notif-item-icon act-green"><i class="fas fa-check-circle"></i></div>
                <div class="notif-item-text">
                    <div class="notif-item-msg"><strong>Ibrahim Ssekatawa</strong> passed the Quran quiz</div>
                    <div class="notif-item-time">3 hours ago</div>
                </div>
            </div>
            <div class="notif-item">
                <div class="notif-item-icon act-red"><i class="fas fa-calendar-times"></i></div>
                <div class="notif-item-text">
                    <div class="notif-item-msg">Session cancelled by admin: <strong>Sat Aqeedah</strong></div>
                    <div class="notif-item-time">Yesterday</div>
                </div>
            </div>
        </div>

        {{-- PROFILE DROPDOWN --}}
        <div class="profile-dropdown" id="profileDropdown">
            <div class="profile-dropdown-head">
                <div class="profile-dropdown-ava">{{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 1)) }}</div>
                <div class="profile-dropdown-name">{{ auth()->user()->name ?? 'Teacher Name' }}</div>
                <div class="profile-dropdown-role">Senior Teacher · Islamic Studies</div>
            </div>
            <a href="#" class="profile-dropdown-item"><i class="fas fa-user"></i> My Profile</a>
            <a href="#" class="profile-dropdown-item"><i class="fas fa-cog"></i> Settings</a>
            <a href="#" class="profile-dropdown-item"><i class="fas fa-question-circle"></i> Help Center</a>
            <form method="POST" action="{{ url('logout') }}">
                @csrf
                <button type="submit" class="profile-dropdown-item danger">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </button>
            </form>
        </div>

        {{-- ═══ PAGE BODY ═══ --}}
        <div class="page-body">

            {{-- ── WELCOME BANNER ── --}}
            <div class="welcome-banner">
                <div class="welcome-orb-1"></div>
                <div class="welcome-orb-2"></div>
                <div class="welcome-text">
                    <div class="welcome-eyebrow">
                        <span class="welcome-dot"></span>
                        {{ now()->format('l, d M Y') }}
                    </div>
                    <div class="welcome-title">
                        Assalamu Alaikum, <span>{{ auth()->user()->first_name ?? 'Teacher' }}</span>
                    </div>
                    <div class="welcome-sub">
                        You have <strong style="color:#C084FC;">3 classes today</strong> and <strong style="color:#F87171;">5 pending submissions</strong> awaiting your review.
                    </div>
                </div>
                <div class="welcome-actions">
                    <a href="#" class="btn-banner btn-banner-primary">
                        <i class="fas fa-plus"></i> New Session
                    </a>
                    <a href="#" class="btn-banner btn-banner-ghost">
                        <i class="fas fa-calendar-alt"></i> View Schedule
                    </a>
                </div>
            </div>

            {{-- ── KPI STATS ── --}}
            <div class="kpi-grid">

                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon kpi-icon-purple"><i class="fas fa-users"></i></div>
                        <div class="kpi-trend kpi-trend-up"><i class="fas fa-arrow-up"></i> 8%</div>
                    </div>
                    <div class="kpi-num">142</div>
                    <div class="kpi-label">Total Students</div>
                    <div class="kpi-sub"><strong>+11</strong> enrolled this month</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon kpi-icon-red"><i class="fas fa-chalkboard"></i></div>
                        <div class="kpi-trend kpi-trend-up"><i class="fas fa-arrow-up"></i> 2</div>
                    </div>
                    <div class="kpi-num">6</div>
                    <div class="kpi-label">Active Classes</div>
                    <div class="kpi-sub"><strong>3 classes</strong> scheduled today</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon kpi-icon-gold"><i class="fas fa-tasks"></i></div>
                        <div class="kpi-trend kpi-trend-down"><i class="fas fa-arrow-down"></i> 5</div>
                    </div>
                    <div class="kpi-num">5</div>
                    <div class="kpi-label">Pending Reviews</div>
                    <div class="kpi-sub"><strong>2 urgent</strong> due tomorrow</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon kpi-icon-green"><i class="fas fa-chart-line"></i></div>
                        <div class="kpi-trend kpi-trend-up"><i class="fas fa-arrow-up"></i> 5%</div>
                    </div>
                    <div class="kpi-num">87%</div>
                    <div class="kpi-label">Avg. Completion Rate</div>
                    <div class="kpi-sub">Up from <strong>82%</strong> last month</div>
                </div>

            </div>

            {{-- ── QUICK ACTIONS ── --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Quick Actions</div>
                        <div class="card-subtitle">Jump straight to your most common tasks</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="quick-actions-grid">
                        <a href="#" class="qa-btn">
                            <div class="qa-icon kpi-icon-purple"><i class="fas fa-plus-circle"></i></div>
                            <div class="qa-label">Add Lesson</div>
                        </a>
                        <a href="#" class="qa-btn">
                            <div class="qa-icon kpi-icon-red"><i class="fas fa-file-alt"></i></div>
                            <div class="qa-label">New Assignment</div>
                        </a>
                        <a href="#" class="qa-btn">
                            <div class="qa-icon kpi-icon-gold"><i class="fas fa-clipboard-list"></i></div>
                            <div class="qa-label">Take Attendance</div>
                        </a>
                        <a href="#" class="qa-btn">
                            <div class="qa-icon kpi-icon-green"><i class="fas fa-pencil-alt"></i></div>
                            <div class="qa-label">Create Quiz</div>
                        </a>
                        <a href="#" class="qa-btn">
                            <div class="qa-icon" style="background:#EDE9FA;color:#7C3AED;"><i class="fas fa-chart-bar"></i></div>
                            <div class="qa-label">View Reports</div>
                        </a>
                        <a href="#" class="qa-btn">
                            <div class="qa-icon" style="background:#DBEAFE;color:#2563EB;"><i class="fas fa-video"></i></div>
                            <div class="qa-label">Start Session</div>
                        </a>
                        <a href="#" class="qa-btn">
                            <div class="qa-icon" style="background:#FCE7F3;color:#DB2777;"><i class="fas fa-bullhorn"></i></div>
                            <div class="qa-label">Announcement</div>
                        </a>
                        <a href="#" class="qa-btn">
                            <div class="qa-icon" style="background:#D1FAE5;color:#059669;"><i class="fas fa-envelope"></i></div>
                            <div class="qa-label">Message Parent</div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── CHART + UPCOMING SESSIONS ── --}}
            <div class="cols-3">

                {{-- Engagement Chart --}}
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Student Engagement</div>
                            <div class="card-subtitle">Lesson completions over the last 7 days</div>
                        </div>
                        <a href="#" class="card-link">Full Report <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="chart-wrap">
                            <canvas id="engagementChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Today's Schedule --}}
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Today's Sessions</div>
                            <div class="card-subtitle">{{ now()->format('d M Y') }}</div>
                        </div>
                        <a href="#" class="card-link">All <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="session-list">

                            <div class="session-item">
                                <div class="session-time-col">
                                    <div class="session-time">8:00</div>
                                    <div class="session-ampm">AM</div>
                                </div>
                                <div class="session-connector">
                                    <div class="session-dot" style="border-color:var(--purple);"></div>
                                    <div class="session-line"></div>
                                </div>
                                <div class="session-info">
                                    <div class="session-name">Quran Recitation — Level 2</div>
                                    <div class="session-tags">
                                        <span class="session-tag">28 Students</span>
                                        <span class="session-tag-gold">60 min</span>
                                    </div>
                                </div>
                            </div>

                            <div class="session-item">
                                <div class="session-time-col">
                                    <div class="session-time">10:30</div>
                                    <div class="session-ampm">AM</div>
                                </div>
                                <div class="session-connector">
                                    <div class="session-dot" style="border-color:var(--red);"></div>
                                    <div class="session-line"></div>
                                </div>
                                <div class="session-info">
                                    <div class="session-name">Fiqh Foundations — Grade 5</div>
                                    <div class="session-tags">
                                        <span class="session-tag">34 Students</span>
                                        <span class="session-tag-red">45 min</span>
                                    </div>
                                </div>
                            </div>

                            <div class="session-item">
                                <div class="session-time-col">
                                    <div class="session-time">2:00</div>
                                    <div class="session-ampm">PM</div>
                                </div>
                                <div class="session-connector">
                                    <div class="session-dot" style="border-color:var(--green);"></div>
                                    <div class="session-line" style="min-height:0;"></div>
                                </div>
                                <div class="session-info">
                                    <div class="session-name">Arabic Language — Beginners</div>
                                    <div class="session-tags">
                                        <span class="session-tag">19 Students</span>
                                        <span class="session-tag-green">90 min</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- ── MY CLASSES ── --}}
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">My Classes</div>
                        <div class="card-subtitle">All active classes you're teaching this term</div>
                    </div>
                    <a href="#" class="card-link">Manage All <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="card-body" style="padding-top:0;">
                    <div class="class-list">

                        <div class="class-item">
                            <div class="class-color-bar" style="background:var(--gradient);"></div>
                            <div class="class-info">
                                <div class="class-name">Quran Recitation — Level 2</div>
                                <div class="class-meta">
                                    <span><i class="fas fa-users"></i>28 Students</span>
                                    <span><i class="fas fa-calendar"></i>Mon, Wed, Fri</span>
                                    <span><i class="fas fa-clock"></i>8:00 AM</span>
                                </div>
                            </div>
                            <div class="class-actions">
                                <a href="#" class="btn-sm-action btn-sm-purple"><i class="fas fa-eye"></i> View</a>
                                <a href="#" class="btn-sm-action btn-sm-outline"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>

                        <div class="class-item">
                            <div class="class-color-bar" style="background:linear-gradient(135deg,var(--red),var(--gold));"></div>
                            <div class="class-info">
                                <div class="class-name">Fiqh Foundations — Grade 5</div>
                                <div class="class-meta">
                                    <span><i class="fas fa-users"></i>34 Students</span>
                                    <span><i class="fas fa-calendar"></i>Tue, Thu</span>
                                    <span><i class="fas fa-clock"></i>10:30 AM</span>
                                </div>
                            </div>
                            <div class="class-actions">
                                <a href="#" class="btn-sm-action btn-sm-purple"><i class="fas fa-eye"></i> View</a>
                                <a href="#" class="btn-sm-action btn-sm-outline"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>

                        <div class="class-item">
                            <div class="class-color-bar" style="background:linear-gradient(135deg,var(--green),#0EA5E9);"></div>
                            <div class="class-info">
                                <div class="class-name">Arabic Language — Beginners</div>
                                <div class="class-meta">
                                    <span><i class="fas fa-users"></i>19 Students</span>
                                    <span><i class="fas fa-calendar"></i>Mon, Wed</span>
                                    <span><i class="fas fa-clock"></i>2:00 PM</span>
                                </div>
                            </div>
                            <div class="class-actions">
                                <a href="#" class="btn-sm-action btn-sm-purple"><i class="fas fa-eye"></i> View</a>
                                <a href="#" class="btn-sm-action btn-sm-outline"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>

                        <div class="class-item">
                            <div class="class-color-bar" style="background:linear-gradient(135deg,#7C3AED,#0EA5E9);"></div>
                            <div class="class-info">
                                <div class="class-name">Aqeedah — Secondary Level</div>
                                <div class="class-meta">
                                    <span><i class="fas fa-users"></i>22 Students</span>
                                    <span><i class="fas fa-calendar"></i>Sat</span>
                                    <span><i class="fas fa-clock"></i>9:00 AM</span>
                                </div>
                            </div>
                            <div class="class-actions">
                                <a href="#" class="btn-sm-action btn-sm-purple"><i class="fas fa-eye"></i> View</a>
                                <a href="#" class="btn-sm-action btn-sm-outline"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>

                        <div class="class-item">
                            <div class="class-color-bar" style="background:linear-gradient(135deg,var(--gold),var(--red));"></div>
                            <div class="class-info">
                                <div class="class-name">Tajweed Advanced — Level 4</div>
                                <div class="class-meta">
                                    <span><i class="fas fa-users"></i>16 Students</span>
                                    <span><i class="fas fa-calendar"></i>Fri</span>
                                    <span><i class="fas fa-clock"></i>4:00 PM</span>
                                </div>
                            </div>
                            <div class="class-actions">
                                <a href="#" class="btn-sm-action btn-sm-purple"><i class="fas fa-eye"></i> View</a>
                                <a href="#" class="btn-sm-action btn-sm-outline"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>

                        <div class="class-item">
                            <div class="class-color-bar" style="background:linear-gradient(135deg,#DB2777,var(--purple));"></div>
                            <div class="class-info">
                                <div class="class-name">Seerah of the Prophet ﷺ</div>
                                <div class="class-meta">
                                    <span><i class="fas fa-users"></i>23 Students</span>
                                    <span><i class="fas fa-calendar"></i>Tue, Sat</span>
                                    <span><i class="fas fa-clock"></i>11:00 AM</span>
                                </div>
                            </div>
                            <div class="class-actions">
                                <a href="#" class="btn-sm-action btn-sm-purple"><i class="fas fa-eye"></i> View</a>
                                <a href="#" class="btn-sm-action btn-sm-outline"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ── STUDENTS + ACTIVITY ── --}}
            <div class="cols-2">

                {{-- Recent Students --}}
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Recent Students</div>
                            <div class="card-subtitle">Latest activity across your classes</div>
                        </div>
                        <a href="#" class="card-link">All Students <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="card-body" style="padding:0 24px;">
                        <table class="student-table">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-ava">AK</div>
                                            <div>
                                                <div class="student-name">Aisha Kamara</div>
                                                <div class="student-class">Quran Level 2</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress-mini-wrap">
                                            <div class="progress-mini-bar"><div class="progress-mini-fill" style="width:88%;"></div></div>
                                            <div class="progress-mini-pct">88%</div>
                                        </div>
                                    </td>
                                    <td><span class="status-badge status-active"><i class="fas fa-circle" style="font-size:5px;"></i> Active</span></td>
                                    <td><a href="#" class="assignment-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-ava student-ava-2">IS</div>
                                            <div>
                                                <div class="student-name">Ibrahim Ssekatawa</div>
                                                <div class="student-class">Fiqh Grade 5</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress-mini-wrap">
                                            <div class="progress-mini-bar"><div class="progress-mini-fill" style="width:74%;"></div></div>
                                            <div class="progress-mini-pct">74%</div>
                                        </div>
                                    </td>
                                    <td><span class="status-badge status-active"><i class="fas fa-circle" style="font-size:5px;"></i> Active</span></td>
                                    <td><a href="#" class="assignment-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-ava student-ava-3">MN</div>
                                            <div>
                                                <div class="student-name">Mariam Nakato</div>
                                                <div class="student-class">Arabic Beginners</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress-mini-wrap">
                                            <div class="progress-mini-bar"><div class="progress-mini-fill" style="width:61%;"></div></div>
                                            <div class="progress-mini-pct">61%</div>
                                        </div>
                                    </td>
                                    <td><span class="status-badge status-pending"><i class="fas fa-circle" style="font-size:5px;"></i> Pending</span></td>
                                    <td><a href="#" class="assignment-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-ava student-ava-4">YM</div>
                                            <div>
                                                <div class="student-name">Yusuf Mugenyi</div>
                                                <div class="student-class">Tajweed Adv.</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress-mini-wrap">
                                            <div class="progress-mini-bar"><div class="progress-mini-fill" style="width:95%;"></div></div>
                                            <div class="progress-mini-pct">95%</div>
                                        </div>
                                    </td>
                                    <td><span class="status-badge status-active"><i class="fas fa-circle" style="font-size:5px;"></i> Active</span></td>
                                    <td><a href="#" class="assignment-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="student-cell">
                                            <div class="student-ava student-ava-5">FA</div>
                                            <div>
                                                <div class="student-name">Fatuma Atieno</div>
                                                <div class="student-class">Aqeedah Sec.</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress-mini-wrap">
                                            <div class="progress-mini-bar"><div class="progress-mini-fill" style="width:42%;"></div></div>
                                            <div class="progress-mini-pct">42%</div>
                                        </div>
                                    </td>
                                    <td><span class="status-badge status-inactive"><i class="fas fa-circle" style="font-size:5px;"></i> Inactive</span></td>
                                    <td><a href="#" class="assignment-btn">View</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Activity Feed --}}
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Recent Activity</div>
                            <div class="card-subtitle">Live updates from your classes</div>
                        </div>
                    </div>
                    <div class="card-body" style="padding-top:0;">
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon act-green"><i class="fas fa-check-circle"></i></div>
                                <div class="activity-text">
                                    <div class="activity-msg"><strong>Yusuf Mugenyi</strong> completed Tajweed Quiz — scored 94%</div>
                                    <div class="activity-time">5 minutes ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon act-purple"><i class="fas fa-file-upload"></i></div>
                                <div class="activity-text">
                                    <div class="activity-msg"><strong>Aisha Kamara</strong> submitted assignment: Seerah Essay</div>
                                    <div class="activity-time">22 minutes ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon act-gold"><i class="fas fa-exclamation-triangle"></i></div>
                                <div class="activity-text">
                                    <div class="activity-msg"><strong>Fatuma Atieno</strong> has not logged in for 7 days</div>
                                    <div class="activity-time">1 hour ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon act-purple"><i class="fas fa-user-plus"></i></div>
                                <div class="activity-text">
                                    <div class="activity-msg"><strong>New student</strong> Omar Kiggundu joined Arabic Beginners</div>
                                    <div class="activity-time">2 hours ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon act-red"><i class="fas fa-comment-alt"></i></div>
                                <div class="activity-text">
                                    <div class="activity-msg"><strong>Mariam Nakato</strong> asked a question in Fiqh forum</div>
                                    <div class="activity-time">3 hours ago</div>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon act-green"><i class="fas fa-star"></i></div>
                                <div class="activity-text">
                                    <div class="activity-msg"><strong>Ibrahim Ssekatawa</strong> earned a Memorization Badge 🏅</div>
                                    <div class="activity-time">Yesterday, 4:30 PM</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── PENDING ASSIGNMENTS ── --}}
            <div class="cols-2">

                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Pending Assignments</div>
                            <div class="card-subtitle">Submissions awaiting your feedback</div>
                        </div>
                        <a href="#" class="card-link">All Assignments <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="assignment-list">

                            <div class="assignment-item">
                                <div class="assignment-icon kpi-icon-red"><i class="fas fa-file-alt"></i></div>
                                <div class="assignment-info">
                                    <div class="assignment-name">Tajweed Rules — Chapter 4</div>
                                    <div class="assignment-meta">
                                        <span><i class="fas fa-chalkboard" style="margin-right:4px;"></i>Tajweed Adv.</span>
                                        <span><i class="fas fa-users" style="margin-right:4px;"></i>16 students</span>
                                    </div>
                                </div>
                                <div class="assignment-right">
                                    <div class="assignment-due">Due Tomorrow</div>
                                    <div class="assignment-submissions">11/16 submitted</div>
                                </div>
                                <a href="#" class="assignment-btn">Review</a>
                            </div>

                            <div class="assignment-item">
                                <div class="assignment-icon kpi-icon-purple"><i class="fas fa-pencil-alt"></i></div>
                                <div class="assignment-info">
                                    <div class="assignment-name">Five Pillars Essay</div>
                                    <div class="assignment-meta">
                                        <span><i class="fas fa-chalkboard" style="margin-right:4px;"></i>Fiqh Grade 5</span>
                                        <span><i class="fas fa-users" style="margin-right:4px;"></i>34 students</span>
                                    </div>
                                </div>
                                <div class="assignment-right">
                                    <div class="assignment-due" style="color:var(--gold);">Due in 3 days</div>
                                    <div class="assignment-submissions">28/34 submitted</div>
                                </div>
                                <a href="#" class="assignment-btn">Review</a>
                            </div>

                            <div class="assignment-item">
                                <div class="assignment-icon kpi-icon-gold"><i class="fas fa-microphone"></i></div>
                                <div class="assignment-info">
                                    <div class="assignment-name">Surah Al-Mulk Recitation</div>
                                    <div class="assignment-meta">
                                        <span><i class="fas fa-chalkboard" style="margin-right:4px;"></i>Quran Level 2</span>
                                        <span><i class="fas fa-users" style="margin-right:4px;"></i>28 students</span>
                                    </div>
                                </div>
                                <div class="assignment-right">
                                    <div class="assignment-due" style="color:var(--green);">Due in 5 days</div>
                                    <div class="assignment-submissions">7/28 submitted</div>
                                </div>
                                <a href="#" class="assignment-btn">Review</a>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Attendance Summary --}}
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Attendance Overview</div>
                            <div class="card-subtitle">This week across all classes</div>
                        </div>
                        <a href="#" class="card-link">Full Report <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="chart-wrap" style="height:200px;margin-bottom:16px;">
                            <canvas id="attendanceChart"></canvas>
                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:4px;">
                            <div style="background:var(--green-light);border-radius:14px;padding:14px;text-align:center;">
                                <div style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:var(--green);">91%</div>
                                <div style="font-size:0.75rem;color:var(--green);font-weight:600;margin-top:2px;">Present Rate</div>
                            </div>
                            <div style="background:var(--red-light);border-radius:14px;padding:14px;text-align:center;">
                                <div style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:var(--red);">9%</div>
                                <div style="font-size:0.75rem;color:var(--red);font-weight:600;margin-top:2px;">Absent Rate</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        {{-- /page-body --}}

    </div>
    {{-- /main-content --}}

</div>
{{-- /dash-shell --}}

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ── Engagement Line Chart ──────────────────────────────────
const engCtx = document.getElementById('engagementChart').getContext('2d');

const engGrad = engCtx.createLinearGradient(0, 0, 0, 240);
engGrad.addColorStop(0, 'rgba(107,70,193,0.3)');
engGrad.addColorStop(1, 'rgba(107,70,193,0)');

new Chart(engCtx, {
    type: 'line',
    data: {
        labels: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
        datasets: [{
            label: 'Completions',
            data: [42, 68, 54, 89, 73, 95, 61],
            borderColor: '#6B46C1',
            backgroundColor: engGrad,
            borderWidth: 2.5,
            fill: true,
            tension: 0.45,
            pointBackgroundColor: '#6B46C1',
            pointRadius: 4,
            pointHoverRadius: 6,
        }, {
            label: 'Logins',
            data: [55, 80, 66, 102, 88, 110, 74],
            borderColor: '#DC2626',
            backgroundColor: 'transparent',
            borderWidth: 2,
            fill: false,
            tension: 0.45,
            pointBackgroundColor: '#DC2626',
            pointRadius: 3,
            pointHoverRadius: 5,
            borderDash: [5, 3],
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                align: 'end',
                labels: {
                    boxWidth: 10,
                    boxHeight: 10,
                    font: { family: 'DM Sans', size: 11 },
                    color: '#6B6584',
                    usePointStyle: true,
                }
            },
            tooltip: {
                backgroundColor: '#1A0A2E',
                titleFont: { family: 'Playfair Display', size: 13 },
                bodyFont: { family: 'DM Sans', size: 12 },
                padding: 12,
                cornerRadius: 12,
            }
        },
        scales: {
            x: {
                grid: { color: 'rgba(107,70,193,0.08)' },
                ticks: { font: { family: 'DM Sans', size: 11 }, color: '#6B6584' }
            },
            y: {
                grid: { color: 'rgba(107,70,193,0.08)' },
                ticks: { font: { family: 'DM Sans', size: 11 }, color: '#6B6584' }
            }
        }
    }
});

// ── Attendance Doughnut Chart ─────────────────────────────
const attCtx = document.getElementById('attendanceChart').getContext('2d');
new Chart(attCtx, {
    type: 'doughnut',
    data: {
        labels: ['Present', 'Absent', 'Late'],
        datasets: [{
            data: [91, 6, 3],
            backgroundColor: ['#16A34A', '#DC2626', '#D97706'],
            borderColor: '#FDFBF7',
            borderWidth: 3,
            hoverOffset: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    boxWidth: 10,
                    boxHeight: 10,
                    font: { family: 'DM Sans', size: 11 },
                    color: '#6B6584',
                    padding: 12,
                    usePointStyle: true,
                }
            },
            tooltip: {
                backgroundColor: '#1A0A2E',
                titleFont: { family: 'Playfair Display', size: 13 },
                bodyFont: { family: 'DM Sans', size: 12 },
                padding: 12,
                cornerRadius: 12,
            }
        }
    }
});

// ── Sidebar Mobile Toggle ─────────────────────────────────
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('mobile-open');
    overlay.classList.toggle('active');
}
document.getElementById('sidebarOverlay').addEventListener('click', toggleSidebar);

// ── Dropdown Toggle ───────────────────────────────────────
function toggleDropdown(dropId, btnId) {
    const drop = document.getElementById(dropId);
    const isOpen = drop.classList.contains('open');
    // Close all
    document.querySelectorAll('.notif-dropdown, .profile-dropdown').forEach(d => d.classList.remove('open'));
    if (!isOpen) drop.classList.add('open');
}
document.addEventListener('click', (e) => {
    if (!e.target.closest('#notifBtn') && !e.target.closest('#notifDropdown')) {
        document.getElementById('notifDropdown').classList.remove('open');
    }
    if (!e.target.closest('#profileBtn') && !e.target.closest('#profileDropdown')) {
        document.getElementById('profileDropdown').classList.remove('open');
    }
});

// ── Header scroll shadow ──────────────────────────────────
window.addEventListener('scroll', () => {
    document.querySelector('.topbar').style.boxShadow =
        window.scrollY > 10 ? '0 4px 20px rgba(107,70,193,0.1)' : 'none';
});

// ── KPI card entrance animation ───────────────────────────
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.kpi-card, .card, .qa-btn').forEach((el, i) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(16px)';
    el.style.transition = `opacity 0.4s ease ${i * 0.05}s, transform 0.4s ease ${i * 0.05}s`;
    observer.observe(el);
});
</script>
@endsection