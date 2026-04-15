@extends('Admin.layouts.admin-master')

@section('title', 'Admin Dashboard')
@section('page-title', 'Command Centre')
@section('breadcrumb', 'Dashboard')

@section('additional-css')
<style>
    /* ── HERO COMMAND BANNER ── */
    .command-banner {
        border-radius: var(--radius-xl);
        background: var(--gradient-dark);
        padding: 0;
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr auto;
        min-height: 160px;
    }
    .banner-bg-grid {
        position: absolute; inset: 0;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 40px, rgba(255,255,255,0.015) 40px, rgba(255,255,255,0.015) 41px),
            repeating-linear-gradient(90deg, transparent, transparent 40px, rgba(255,255,255,0.015) 40px, rgba(255,255,255,0.015) 41px);
    }
    .banner-orb-a {
        position: absolute;
        width: 360px; height: 360px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(107,70,193,0.32) 0%, transparent 70%);
        top: -100px; right: 200px;
        pointer-events: none;
    }
    .banner-orb-b {
        position: absolute;
        width: 250px; height: 250px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(220,38,38,0.22) 0%, transparent 70%);
        bottom: -80px; right: 60px;
        pointer-events: none;
    }
    .banner-orb-c {
        position: absolute;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(217,119,6,0.15) 0%, transparent 70%);
        top: -40px; left: 400px;
        pointer-events: none;
    }
    .banner-left {
        padding: 32px 40px;
        position: relative; z-index: 2;
        display: flex; flex-direction: column; justify-content: center;
    }
    .banner-eyebrow {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.13);
        backdrop-filter: blur(6px);
        padding: 5px 14px; border-radius: 40px;
        font-size: 0.7rem; color: rgba(255,255,255,0.65);
        letter-spacing: 1.8px; text-transform: uppercase; font-weight: 600;
        margin-bottom: 14px; width: fit-content;
    }
    .eyebrow-live-dot {
        width: 7px; height: 7px;
        border-radius: 50%; background: #4ade80;
        box-shadow: 0 0 10px rgba(74,222,128,0.7);
        animation: pulse-green 2s ease-in-out infinite;
    }
    .banner-title {
        font-size: clamp(1.6rem, 3vw, 2.1rem);
        font-weight: 800; color: white; margin-bottom: 8px;
        line-height: 1.15;
    }
    .banner-title-grad {
        background: linear-gradient(135deg, #C084FC 0%, #F87171 100%);
        -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .banner-sub { font-size: 0.88rem; color: rgba(255,255,255,0.52); line-height: 1.6; max-width: 500px; }
    .banner-actions { display: flex; gap: 10px; margin-top: 20px; align-items: center; }

    .btn-action {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 20px; border-radius: 40px;
        font-weight: 600; font-size: 0.83rem;
        text-decoration: none; border: none; cursor: pointer;
        font-family: 'DM Sans', sans-serif; transition: var(--transition);
        letter-spacing: 0.1px;
    }
    .bta-primary {
        background: var(--gradient); color: white;
        box-shadow: 0 6px 20px rgba(107,70,193,0.4);
    }
    .bta-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(107,70,193,0.5); color: white; }
    .bta-ghost {
        background: rgba(255,255,255,0.1); color: white;
        border: 1px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(8px);
    }
    .bta-ghost:hover { background: rgba(255,255,255,0.18); color: white; }
    .bta-outline {
        background: transparent; color: var(--purple);
        border: 1.5px solid var(--border3);
    }
    .bta-outline:hover { background: var(--purple); color: white; }

    /* Banner right — live metrics strip */
    .banner-metrics {
        padding: 28px 36px 28px 20px;
        position: relative; z-index: 2;
        display: flex; flex-direction: column; justify-content: center;
        gap: 16px;
        border-left: 1px solid rgba(255,255,255,0.08);
    }
    .banner-metric-item { display: flex; flex-direction: column; align-items: flex-end; }
    .bm-num {
        font-family: 'Playfair Display', serif;
        font-size: 1.9rem; font-weight: 700; color: white; line-height: 1;
    }
    .bm-label { font-size: 0.68rem; color: rgba(255,255,255,0.4); margin-top: 2px; letter-spacing: 0.5px; }
    .bm-trend {
        font-size: 0.68rem; font-weight: 600;
        display: flex; align-items: center; gap: 3px;
        margin-top: 3px;
    }
    .bm-up   { color: #86efac; }
    .bm-down { color: #FCA5A5; }
    .bm-divider { width: 100%; height: 1px; background: rgba(255,255,255,0.07); }

    /* ── KPI ROW ── */
    .kpi-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
    }
    .kpi-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 22px 22px 20px;
        border: 1.5px solid var(--border);
        position: relative; overflow: hidden;
        transition: var(--transition);
        cursor: pointer;
    }
    .kpi-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); border-color: var(--border2); }
    .kpi-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0; height: 3px;
        background: var(--gradient);
        transform: scaleX(0); transform-origin: left;
        transition: transform 0.3s ease;
    }
    .kpi-card:hover::after { transform: scaleX(1); }

    .kpi-watermark {
        position: absolute;
        top: -10px; right: -8px;
        font-family: 'Playfair Display', serif;
        font-size: 5rem; font-weight: 800;
        color: rgba(107,70,193,0.04);
        line-height: 1; pointer-events: none;
        user-select: none;
    }
    .kpi-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
    .kpi-ico {
        width: 44px; height: 44px; border-radius: 13px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.05rem;
    }
    .ki-p  { background: var(--purple-light); color: var(--purple); }
    .ki-r  { background: var(--red-light);    color: var(--red);    }
    .ki-g  { background: var(--gold-light);   color: var(--gold);   }
    .ki-gr { background: var(--green-light);  color: var(--green);  }
    .ki-b  { background: var(--blue-light);   color: var(--blue);   }
    .ki-c  { background: var(--cyan-light);   color: var(--cyan);   }

    .kpi-trend {
        display: flex; align-items: center; gap: 4px;
        font-size: 0.7rem; font-weight: 700;
        padding: 3px 8px; border-radius: 20px;
    }
    .kt-up   { background: var(--green-light); color: var(--green); }
    .kt-down { background: var(--red-light);   color: var(--red);   }
    .kt-flat { background: var(--cream3);      color: var(--muted); }

    .kpi-num {
        font-family: 'Playfair Display', serif;
        font-size: 2.1rem; font-weight: 800; color: var(--ink); line-height: 1; margin-bottom: 4px;
    }
    .kpi-label { font-size: 0.78rem; color: var(--muted); font-weight: 500; }
    .kpi-footer { margin-top: 12px; padding-top: 10px; border-top: 1px solid var(--border); font-size: 0.71rem; color: var(--muted); }
    .kpi-footer strong { color: var(--ink); font-weight: 600; }

    /* ── SECTION GRID HELPERS ── */
    .grid-2   { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .grid-3   { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
    .grid-6-4 { display: grid; grid-template-columns: 6fr 4fr; gap: 20px; }
    .grid-4-6 { display: grid; grid-template-columns: 4fr 6fr; gap: 20px; }
    .grid-7-5 { display: grid; grid-template-columns: 7fr 5fr; gap: 20px; }

    /* Chart wrapper */
    .main-chart-wrap { position: relative; height: 270px; }

    /* ── DATA TABLE ── */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th {
        text-align: left; padding: 0 16px 12px;
        font-size: 0.67rem; font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; color: var(--muted2);
        border-bottom: 2px solid var(--border);
        white-space: nowrap;
    }
    .data-table td {
        padding: 13px 16px; font-size: 0.84rem;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    .data-table tbody tr { transition: background 0.15s; }
    .data-table tbody tr:hover { background: var(--cream2); }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table th.text-right, .data-table td.text-right { text-align: right; }
    .data-table th.text-center, .data-table td.text-center { text-align: center; }

    /* User cell */
    .user-cell { display: flex; align-items: center; gap: 10px; }
    .user-ava {
        width: 34px; height: 34px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: 0.78rem;
        flex-shrink: 0;
    }
    .ua-1 { background: var(--gradient); }
    .ua-2 { background: linear-gradient(135deg, var(--gold), var(--red)); }
    .ua-3 { background: linear-gradient(135deg, var(--green), #0EA5E9); }
    .ua-4 { background: linear-gradient(135deg, #0EA5E9, var(--purple)); }
    .ua-5 { background: linear-gradient(135deg, #DB2777, var(--purple)); }
    .ua-6 { background: linear-gradient(135deg, var(--cyan), var(--green)); }
    .ua-7 { background: linear-gradient(135deg, var(--gold), var(--green)); }
    .ua-8 { background: linear-gradient(135deg, var(--red), #DB2777); }
    .user-name { font-weight: 600; font-size: 0.84rem; color: var(--ink); line-height: 1.2; }
    .user-meta { font-size: 0.71rem; color: var(--muted); }

    /* Progress cell */
    .prog-cell { display: flex; align-items: center; gap: 8px; min-width: 100px; }
    .prog-bar-bg { flex: 1; height: 5px; background: var(--cream3); border-radius: 40px; overflow: hidden; }
    .prog-bar-fill { height: 100%; border-radius: 40px; background: var(--gradient); }
    .prog-pct { font-size: 0.74rem; font-weight: 600; color: var(--ink); white-space: nowrap; min-width: 32px; text-align: right; }

    /* Score cell */
    .score-cell {
        font-family: 'DM Mono', monospace;
        font-size: 0.82rem; font-weight: 500;
    }
    .score-high { color: var(--green); }
    .score-mid  { color: var(--gold); }
    .score-low  { color: var(--red); }

    /* Action dots */
    .action-dots {
        display: inline-flex; align-items: center; gap: 6px;
        cursor: pointer; position: relative;
    }
    .action-dot { width: 4px; height: 4px; border-radius: 50%; background: var(--muted2); transition: background 0.2s; }
    .action-dots:hover .action-dot { background: var(--purple); }

    /* ── ACTIVITY TIMELINE ── */
    .timeline { display: flex; flex-direction: column; gap: 0; }
    .tl-item {
        display: flex; gap: 14px; align-items: flex-start;
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
    }
    .tl-item:last-child { border-bottom: none; }
    .tl-icon-col {
        display: flex; flex-direction: column; align-items: center;
        gap: 0; flex-shrink: 0; padding-top: 3px;
    }
    .tl-ico {
        width: 34px; height: 34px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.82rem; flex-shrink: 0;
    }
    .tl-line {
        width: 1.5px; flex: 1; min-height: 12px;
        background: var(--border2); margin-top: 4px;
    }
    .tl-item:last-child .tl-line { display: none; }
    .tl-body { flex: 1; padding-bottom: 2px; }
    .tl-msg { font-size: 0.82rem; color: var(--ink); line-height: 1.45; font-weight: 500; }
    .tl-msg strong { color: var(--purple); font-weight: 600; }
    .tl-time { font-size: 0.68rem; color: var(--muted); margin-top: 3px; }
    .tl-tag {
        display: inline-block;
        font-size: 0.65rem; font-weight: 600;
        padding: 1px 7px; border-radius: 20px;
        margin-left: 6px;
    }

    /* ── TOP TEACHERS LEADERBOARD ── */
    .leaderboard { display: flex; flex-direction: column; gap: 10px; }
    .lb-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 14px;
        background: var(--cream);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-md);
        transition: var(--transition); cursor: pointer;
    }
    .lb-item:hover { border-color: var(--border3); box-shadow: var(--shadow-sm); }
    .lb-rank {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem; font-weight: 700;
        width: 24px; text-align: center;
        flex-shrink: 0; line-height: 1;
    }
    .lb-rank-1 { color: var(--gold); }
    .lb-rank-2 { color: var(--muted); }
    .lb-rank-3 { color: #CD7F32; }
    .lb-rank-n { color: var(--muted2); font-size: 0.85rem; }
    .lb-ava {
        width: 38px; height: 38px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;
    }
    .lb-info { flex: 1; }
    .lb-name { font-size: 0.86rem; font-weight: 600; color: var(--ink); line-height: 1.2; }
    .lb-subject { font-size: 0.71rem; color: var(--muted); }
    .lb-score { text-align: right; }
    .lb-score-num {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem; font-weight: 700; color: var(--ink); line-height: 1;
    }
    .lb-score-lbl { font-size: 0.65rem; color: var(--muted); }

    /* ── RATING BARS ── */
    .rating-rows { display: flex; flex-direction: column; gap: 10px; }
    .rating-row { display: flex; align-items: center; gap: 12px; }
    .rating-label { font-size: 0.8rem; color: var(--ink); font-weight: 500; width: 90px; flex-shrink: 0; }
    .rating-bar-wrap { flex: 1; height: 8px; background: var(--cream3); border-radius: 40px; overflow: hidden; }
    .rating-fill { height: 100%; border-radius: 40px; transition: width 1s ease; }
    .rating-pct { font-size: 0.76rem; font-weight: 600; color: var(--ink); width: 38px; text-align: right; flex-shrink: 0; }

    /* ── MINI CALENDAR ── */
    .mini-cal { }
    .cal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
    .cal-month { font-family: 'Playfair Display', serif; font-size: 0.95rem; font-weight: 700; color: var(--ink); }
    .cal-nav { display: flex; gap: 4px; }
    .cal-nav-btn {
        width: 28px; height: 28px; border-radius: 8px;
        border: 1px solid var(--border2); background: white;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; color: var(--muted); cursor: pointer; transition: var(--transition);
    }
    .cal-nav-btn:hover { background: var(--purple); color: white; border-color: var(--purple); }
    .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
    .cal-dow { text-align: center; font-size: 0.65rem; font-weight: 600; color: var(--muted2); padding: 4px 0; }
    .cal-day {
        text-align: center; padding: 7px 2px;
        font-size: 0.78rem; color: var(--muted);
        border-radius: 8px; cursor: pointer; transition: var(--transition);
        line-height: 1;
    }
    .cal-day:hover { background: var(--purple-light); color: var(--purple); }
    .cal-day.today { background: var(--gradient); color: white; font-weight: 700; box-shadow: 0 4px 12px rgba(107,70,193,0.35); }
    .cal-day.has-event { position: relative; color: var(--ink); font-weight: 600; }
    .cal-day.has-event::after {
        content: '';
        position: absolute;
        bottom: 3px; left: 50%; transform: translateX(-50%);
        width: 4px; height: 4px; border-radius: 50%;
        background: var(--red);
    }
    .cal-day.other-month { color: var(--muted2); opacity: 0.4; }
    .cal-events { margin-top: 14px; display: flex; flex-direction: column; gap: 8px; }
    .cal-event {
        display: flex; align-items: center; gap: 10px;
        padding: 9px 12px; border-radius: var(--radius-sm);
        border-left: 3px solid;
        background: var(--cream); font-size: 0.78rem;
    }
    .ce-purple { border-color: var(--purple); }
    .ce-red    { border-color: var(--red); }
    .ce-gold   { border-color: var(--gold); }
    .cal-event-name { font-weight: 600; color: var(--ink); flex: 1; }
    .cal-event-time { font-size: 0.68rem; color: var(--muted); white-space: nowrap; }

    /* ── QUICK ACTIONS COMMAND STRIP ── */
    .cmd-strip { display: flex; gap: 10px; flex-wrap: wrap; }
    .cmd-btn {
        display: flex; align-items: center; gap: 9px;
        padding: 10px 18px;
        border-radius: var(--radius-md);
        font-size: 0.82rem; font-weight: 600;
        border: 1.5px solid var(--border2);
        background: white; color: var(--ink);
        cursor: pointer; text-decoration: none;
        transition: var(--transition); font-family: 'DM Sans', sans-serif;
        white-space: nowrap;
    }
    .cmd-btn:hover { border-color: var(--purple); color: var(--purple); transform: translateY(-2px); box-shadow: var(--shadow-sm); }
    .cmd-btn i { font-size: 0.9rem; }
    .cmd-btn-primary { background: var(--gradient); color: white; border-color: transparent; box-shadow: 0 4px 14px rgba(107,70,193,0.3); }
    .cmd-btn-primary:hover { color: white; box-shadow: 0 8px 22px rgba(107,70,193,0.4); }

    /* ── ENROLLMENT CARDS ── */
    .enroll-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .enroll-card {
        padding: 14px 16px;
        background: var(--cream);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-md);
        display: flex; align-items: center; gap: 12px;
        transition: var(--transition); cursor: pointer;
    }
    .enroll-card:hover { border-color: var(--purple); box-shadow: var(--shadow-sm); }
    .enroll-ava {
        width: 38px; height: 38px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: 0.82rem; flex-shrink: 0;
    }
    .enroll-info { flex: 1; overflow: hidden; }
    .enroll-name { font-size: 0.83rem; font-weight: 600; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .enroll-class { font-size: 0.7rem; color: var(--muted); }
    .enroll-time { font-size: 0.68rem; color: var(--muted2); white-space: nowrap; }

    /* ── SYSTEM HEALTH CARDS ── */
    .sys-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
    .sys-card {
        background: white;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-md);
        padding: 18px 20px;
        transition: var(--transition);
    }
    .sys-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-sm); }
    .sys-card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .sys-card-label { font-size: 0.72rem; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
    .sys-card-status {
        display: flex; align-items: center; gap: 4px;
        font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
    }
    .scs-ok   { color: var(--green); }
    .scs-warn { color: var(--gold); }
    .scs-err  { color: var(--red); }
    .sys-card-dot { width: 6px; height: 6px; border-radius: 50%; }
    .dot-green { background: var(--green); box-shadow: 0 0 6px rgba(22,163,74,0.6); }
    .dot-gold  { background: var(--gold);  box-shadow: 0 0 6px rgba(217,119,6,0.6); }
    .dot-red   { background: var(--red);   box-shadow: 0 0 6px rgba(220,38,38,0.6); }
    .sys-card-num {
        font-family: 'DM Mono', monospace;
        font-size: 1.6rem; font-weight: 500; color: var(--ink); line-height: 1;
    }
    .sys-card-sub { font-size: 0.7rem; color: var(--muted); margin-top: 4px; }
    .sys-prog { margin-top: 10px; }
    .sys-prog-bar { height: 4px; background: var(--cream3); border-radius: 40px; overflow: hidden; }
    .sys-prog-fill { height: 100%; border-radius: 40px; transition: width 1s ease; }
    .spf-green { background: var(--green); }
    .spf-gold  { background: var(--gold); }
    .spf-red   { background: var(--red); }
    .spf-purple{ background: var(--gradient); }

    /* ── MINI TILES ── */
    .mini-tiles { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .mini-tile {
        padding: 14px 16px;
        border-radius: var(--radius-md);
        border: 1.5px solid var(--border);
        background: var(--cream);
        transition: var(--transition);
    }
    .mini-tile:hover { border-color: var(--border3); transform: translateY(-2px); box-shadow: var(--shadow-sm); }
    .mt-num {
        font-family: 'Playfair Display', serif;
        font-size: 1.65rem; font-weight: 700; line-height: 1; margin-bottom: 4px;
    }
    .mt-label { font-size: 0.72rem; color: var(--muted); font-weight: 500; }
    .mt-ico { font-size: 1.1rem; margin-bottom: 8px; }

    /* ── RESPONSIVE ── */
    @media (max-width: 1400px) {
        .kpi-row { grid-template-columns: repeat(4, 1fr); }
        .kpi-row .kpi-card:last-child { display: none; }
        .sys-cards { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 1100px) {
        .grid-6-4, .grid-4-6, .grid-7-5 { grid-template-columns: 1fr; }
        .grid-3 { grid-template-columns: 1fr 1fr; }
        .kpi-row { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 900px) {
        .kpi-row { grid-template-columns: repeat(2, 1fr); }
        .grid-2, .grid-3 { grid-template-columns: 1fr; }
        .enroll-grid { grid-template-columns: 1fr; }
        .command-banner { grid-template-columns: 1fr; }
        .banner-metrics { border-left: none; border-top: 1px solid rgba(255,255,255,0.08); flex-direction: row; padding: 20px 28px; gap: 24px; }
        .bm-divider { width: 1px; height: auto; }
        .banner-metric-item { align-items: flex-start; }
    }
    @media (max-width: 600px) {
        .kpi-row { grid-template-columns: 1fr; }
        .sys-cards { grid-template-columns: 1fr 1fr; }
        .mini-tiles { grid-template-columns: 1fr; }
        .banner-actions { flex-direction: column; align-items: flex-start; }
    }
</style>
@endsection

@section('content')
    {{-- ── COMMAND BANNER ── --}}
    <div class="command-banner">
        <div class="banner-bg-grid"></div>
        <div class="banner-orb-a"></div>
        <div class="banner-orb-b"></div>
        <div class="banner-orb-c"></div>

        <div class="banner-left">
            <div class="banner-eyebrow">
                <span class="eyebrow-live-dot"></span>
                Live Dashboard · {{ now()->format('l, d F Y') }}
            </div>
            <div class="banner-title">
                Assalamu Alaikum,
                <span class="banner-title-grad">{{ auth()->user()->first_name ?? 'Administrator' }}</span>
            </div>
            <div class="banner-sub">
                AlHilal Academy is running smoothly. You have
                <strong style="color:#C084FC;">7 enrollment requests</strong>,
                <strong style="color:#F87171;">3 pending payments</strong> and
                <strong style="color:#FCD34D;">2 exam schedules</strong> requiring your attention today.
            </div>
            <div class="banner-actions">
                <a href="#" class="btn-action bta-primary"><i class="fas fa-plus"></i> Quick Add</a>
                <a href="#" class="btn-action bta-ghost"><i class="fas fa-file-export"></i> Export Report</a>
                <a href="#" class="btn-action bta-ghost"><i class="fas fa-cog"></i> Settings</a>
            </div>
        </div>

        <div class="banner-metrics">
            <div class="banner-metric-item">
                <div class="bm-num">{{ $totalStudents ?? '142' }}</div>
                <div class="bm-label">Total Students</div>
                <div class="bm-trend bm-up"><i class="fas fa-arrow-up"></i> +11 this month</div>
            </div>
            <div class="bm-divider"></div>
            <div class="banner-metric-item">
                <div class="bm-num">{{ $totalTeachers ?? '18' }}</div>
                <div class="bm-label">Active Teachers</div>
                <div class="bm-trend bm-up"><i class="fas fa-arrow-up"></i> +2 new</div>
            </div>
            <div class="bm-divider"></div>
            <div class="banner-metric-item">
                <div class="bm-num">91%</div>
                <div class="bm-label">Attendance Rate</div>
                <div class="bm-trend bm-up"><i class="fas fa-arrow-up"></i> +3% vs last week</div>
            </div>
        </div>
    </div>

    {{-- ── QUICK CMD STRIP ── --}}
    <div class="card">
        <div class="card-body" style="padding:16px 22px;">
            <div class="cmd-strip">
                <a href="#" class="cmd-btn cmd-btn-primary"><i class="fas fa-user-plus"></i> Add Student</a>
                <a href="#" class="cmd-btn"><i class="fas fa-chalkboard-teacher"></i> Add Teacher</a>
                <a href="#" class="cmd-btn"><i class="fas fa-calendar-plus"></i> Schedule Class</a>
                <a href="#" class="cmd-btn"><i class="fas fa-bullhorn"></i> Announcement</a>
                <a href="#" class="cmd-btn"><i class="fas fa-file-invoice"></i> Generate Invoice</a>
                <a href="#" class="cmd-btn"><i class="fas fa-clipboard-list"></i> Take Attendance</a>
                <a href="#" class="cmd-btn"><i class="fas fa-database"></i> Backup Now</a>
                <a href="#" class="cmd-btn"><i class="fas fa-chart-bar"></i> Full Analytics</a>
            </div>
        </div>
    </div>

    {{-- ── KPI CARDS ── --}}
    <div class="kpi-row">
        @php
            $kpiCards = [
                ['watermark' => '142', 'icon' => 'ki-p', 'icon_class' => 'fa-user-graduate', 'trend' => 'kt-up', 'trend_icon' => 'fa-arrow-up', 'trend_text' => '8.4%', 'num' => '142', 'label' => 'Total Students', 'footer' => '<strong>+11</strong> enrolled this month · <strong>7</strong> pending'],
                ['watermark' => '18', 'icon' => 'ki-b', 'icon_class' => 'fa-chalkboard-teacher', 'trend' => 'kt-up', 'trend_icon' => 'fa-arrow-up', 'trend_text' => '2 new', 'num' => '18', 'label' => 'Active Teachers', 'footer' => '<strong>16</strong> teaching today · <strong>2</strong> on leave'],
                ['watermark' => '24', 'icon' => 'ki-r', 'icon_class' => 'fa-chalkboard', 'trend' => 'kt-flat', 'trend_icon' => 'fa-minus', 'trend_text' => 'Stable', 'num' => '24', 'label' => 'Active Classes', 'footer' => '<strong>8</strong> sessions scheduled today'],
                ['watermark' => '87', 'icon' => 'ki-gr', 'icon_class' => 'fa-chart-line', 'trend' => 'kt-up', 'trend_icon' => 'fa-arrow-up', 'trend_text' => '5%', 'num' => '87%', 'label' => 'Completion Rate', 'footer' => 'Up from <strong>82%</strong> last month'],
                ['watermark' => '3.8M', 'icon' => 'ki-g', 'icon_class' => 'fa-hand-holding-usd', 'trend' => 'kt-up', 'trend_icon' => 'fa-arrow-up', 'trend_text' => '12%', 'num' => '3.8M', 'label' => 'Revenue (UGX)', 'footer' => '<strong>3</strong> pending · UGX 620K overdue'],
            ];
        @endphp

        @foreach($kpiCards as $card)
        <div class="kpi-card">
            <div class="kpi-watermark">{{ $card['watermark'] }}</div>
            <div class="kpi-top">
                <div class="kpi-ico {{ $card['icon'] }}"><i class="fas {{ $card['icon_class'] }}"></i></div>
                <div class="kpi-trend {{ $card['trend'] }}"><i class="fas {{ $card['trend_icon'] }}"></i> {{ $card['trend_text'] }}</div>
            </div>
            <div class="kpi-num">{{ $card['num'] }}</div>
            <div class="kpi-label">{{ $card['label'] }}</div>
            <div class="kpi-footer">{!! $card['footer'] !!}</div>
        </div>
        @endforeach
    </div>

    {{-- ── MAIN CHART + LEADERBOARD ── --}}
    <div class="grid-7-5">
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Enrollment & Revenue Trends</div>
                    <div class="card-head-sub">Monthly overview across the academic year</div>
                </div>
                <div class="card-head-right">
                    <div class="pill-filters">
                        <button class="pill active" onclick="setPeriod(this,'12m')">12M</button>
                        <button class="pill" onclick="setPeriod(this,'6m')">6M</button>
                        <button class="pill" onclick="setPeriod(this,'3m')">3M</button>
                    </div>
                    <a href="#" class="card-link" style="margin-left:8px;">Export <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="main-chart-wrap">
                    <canvas id="mainChart"></canvas>
                </div>
                <div style="display:flex;gap:20px;margin-top:16px;padding-top:14px;border-top:1px solid var(--border);">
                    <div style="display:flex;align-items:center;gap:7px;font-size:0.78rem;color:var(--muted);">
                        <span style="width:24px;height:3px;background:var(--purple);border-radius:2px;display:inline-block;"></span>
                        Enrollments
                    </div>
                    <div style="display:flex;align-items:center;gap:7px;font-size:0.78rem;color:var(--muted);">
                        <span style="width:24px;height:3px;background:var(--red);border-radius:2px;display:inline-block;"></span>
                        Revenue (×10K UGX)
                    </div>
                    <div style="display:flex;align-items:center;gap:7px;font-size:0.78rem;color:var(--muted);">
                        <span style="width:24px;height:3px;background:var(--gold);border-radius:2px;display:inline-block;border-style:dashed;border-width:0 0 2px;"></span>
                        Completions
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Top Teachers</div>
                    <div class="card-head-sub">Ranked by student performance</div>
                </div>
                <a href="#" class="card-link">Full List <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div class="leaderboard">
                    @php
                        $teachers = [
                            ['rank' => 1, 'rank_class' => 'lb-rank-1', 'initials' => 'SH', 'ava_class' => 'ua-1', 'name' => 'Sheikh Haruna Kato', 'subject' => 'Quran & Tajweed', 'score' => '98.2'],
                            ['rank' => 2, 'rank_class' => 'lb-rank-2', 'initials' => 'US', 'ava_class' => 'ua-2', 'name' => 'Ustadha Safiyya', 'subject' => 'Arabic Language', 'score' => '95.7'],
                            ['rank' => 3, 'rank_class' => 'lb-rank-3', 'initials' => 'MN', 'ava_class' => 'ua-3', 'name' => 'Mwalimu Nasur', 'subject' => 'Fiqh & Aqeedah', 'score' => '93.1'],
                            ['rank' => 4, 'rank_class' => 'lb-rank-n', 'initials' => 'IK', 'ava_class' => 'ua-4', 'name' => 'Imam Kasirye', 'subject' => 'Seerah & History', 'score' => '90.8'],
                            ['rank' => 5, 'rank_class' => 'lb-rank-n', 'initials' => 'FA', 'ava_class' => 'ua-5', 'name' => 'Fatima Al-Amin', 'subject' => 'Islamic Studies', 'score' => '88.4'],
                        ];
                    @endphp

                    @foreach($teachers as $teacher)
                    <div class="lb-item">
                        <div class="lb-rank {{ $teacher['rank_class'] }}">{{ $teacher['rank'] }}</div>
                        <div class="lb-ava {{ $teacher['ava_class'] }}">{{ $teacher['initials'] }}</div>
                        <div class="lb-info">
                            <div class="lb-name">{{ $teacher['name'] }}</div>
                            <div class="lb-subject">{{ $teacher['subject'] }}</div>
                        </div>
                        <div class="lb-score">
                            <div class="lb-score-num">{{ $teacher['score'] }}</div>
                            <div class="lb-score-lbl">avg score</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ── ALL USERS TABLE + ACTIVITY ── --}}
    <div class="grid-6-4">
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">User Management</div>
                    <div class="card-head-sub">All platform users · sorted by last activity</div>
                </div>
                <div class="card-head-right">
                    <div class="pill-filters">
                        <button class="pill active">All</button>
                        <button class="pill">Students</button>
                        <button class="pill">Teachers</button>
                    </div>
                    <a href="#" class="card-link">Manage <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="card-body-0">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Progress</th>
                            <th class="text-center">Score</th>
                            <th>Status</th>
                            <th class="text-right">Joined</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $users = [
                                ['initials' => 'AK', 'ava_class' => 'ua-1', 'name' => 'Aisha Kamara', 'email' => 'aisha@alhilal.ac', 'role' => 'Student', 'role_class' => 'rt-student', 'role_icon' => 'fa-user-graduate', 'progress' => 88, 'score' => '94.2', 'score_class' => 'score-high', 'status' => 'Active', 'joined' => 'Jan 2025'],
                                ['initials' => 'SH', 'ava_class' => 'ua-2', 'name' => 'Sheikh Haruna', 'email' => 'haruna@alhilal.ac', 'role' => 'Teacher', 'role_class' => 'rt-teacher', 'role_icon' => 'fa-chalkboard-teacher', 'progress' => 100, 'score' => '98.2', 'score_class' => 'score-high', 'status' => 'Active', 'joined' => 'Aug 2024'],
                                ['initials' => 'IS', 'ava_class' => 'ua-3', 'name' => 'Ibrahim Ssekatawa', 'email' => 'ibrahim@alhilal.ac', 'role' => 'Student', 'role_class' => 'rt-student', 'role_icon' => 'fa-user-graduate', 'progress' => 74, 'score' => '81.5', 'score_class' => 'score-high', 'status' => 'Active', 'joined' => 'Feb 2025'],
                                ['initials' => 'MN', 'ava_class' => 'ua-4', 'name' => 'Mariam Nakato', 'email' => 'mariam@alhilal.ac', 'role' => 'Student', 'role_class' => 'rt-student', 'role_icon' => 'fa-user-graduate', 'progress' => 61, 'score' => '67.3', 'score_class' => 'score-mid', 'status' => 'Pending', 'joined' => 'Mar 2025'],
                                ['initials' => 'US', 'ava_class' => 'ua-5', 'name' => 'Ustadha Safiyya', 'email' => 'safiyya@alhilal.ac', 'role' => 'Teacher', 'role_class' => 'rt-teacher', 'role_icon' => 'fa-chalkboard-teacher', 'progress' => 100, 'score' => '95.7', 'score_class' => 'score-high', 'status' => 'Active', 'joined' => 'Sep 2024'],
                                ['initials' => 'FA', 'ava_class' => 'ua-6', 'name' => 'Fatuma Atieno', 'email' => 'fatuma@alhilal.ac', 'role' => 'Student', 'role_class' => 'rt-student', 'role_icon' => 'fa-user-graduate', 'progress' => 42, 'score' => '51.0', 'score_class' => 'score-low', 'status' => 'Inactive', 'joined' => 'Jan 2025'],
                                ['initials' => 'YM', 'ava_class' => 'ua-7', 'name' => 'Yusuf Mugenyi', 'email' => 'yusuf@alhilal.ac', 'role' => 'Student', 'role_class' => 'rt-student', 'role_icon' => 'fa-user-graduate', 'progress' => 95, 'score' => '97.1', 'score_class' => 'score-high', 'status' => 'Active', 'joined' => 'Nov 2024'],
                            ];
                        @endphp

                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-ava {{ $user['ava_class'] }}">{{ $user['initials'] }}</div>
                                    <div>
                                        <div class="user-name">{{ $user['name'] }}</div>
                                        <div class="user-meta">{{ $user['email'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="role-tag {{ $user['role_class'] }}">
                                    <i class="fas {{ $user['role_icon'] }}"></i> {{ $user['role'] }}
                                </span>
                            </td>
                            <td>
                                <div class="prog-cell">
                                    <div class="prog-bar-bg"><div class="prog-bar-fill" style="width:{{ $user['progress'] }}%;"></div></div>
                                    <div class="prog-pct">{{ $user['progress'] }}%</div>
                                </div>
                            </td>
                            <td class="text-center"><span class="score-cell {{ $user['score_class'] }}">{{ $user['score'] }}</span></td>
                            <td>
                                <span class="badge badge-{{ strtolower($user['status']) }}">
                                    <i class="fas fa-circle"></i> {{ $user['status'] }}
                                </span>
                            </td>
                            <td class="text-right" style="font-size:0.75rem;color:var(--muted);">{{ $user['joined'] }}</td>
                            <td><div class="action-dots"><div class="action-dot"></div><div class="action-dot"></div><div class="action-dot"></div></div></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Audit Activity</div>
                    <div class="card-head-sub">Platform-wide events · live</div>
                </div>
                <a href="#" class="card-link">All Logs <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body" style="padding-top:0;">
                <div class="timeline">
                    @php
                        $activities = [
                            ['icon' => 'ni-p', 'icon_class' => 'fa-user-plus', 'msg' => 'New student <strong>Omar Kiggundu</strong> enrolled', 'tag' => 'Enrollment', 'tag_bg' => 'var(--purple-light)', 'tag_color' => 'var(--purple)', 'time' => '2 min ago · by Admin'],
                            ['icon' => 'ni-g', 'icon_class' => 'fa-credit-card', 'msg' => 'Payment <strong>UGX 450,000</strong> confirmed from Kamara', 'tag' => 'Finance', 'tag_bg' => 'var(--gold-light)', 'tag_color' => 'var(--gold)', 'time' => '1 hr ago · auto-system'],
                            ['icon' => 'ni-r', 'icon_class' => 'fa-exclamation-triangle', 'msg' => 'CPU spike <strong>94%</strong> — auto-scaled resolved', 'tag' => 'System', 'tag_bg' => 'var(--red-light)', 'tag_color' => 'var(--red)', 'time' => '1.5 hrs ago · auto'],
                            ['icon' => 'ni-gr', 'icon_class' => 'fa-database', 'msg' => 'Daily <strong>backup completed</strong> — 2.4GB stored', 'tag' => 'System', 'tag_bg' => 'var(--green-light)', 'tag_color' => 'var(--green)', 'time' => '3 hrs ago · cron job'],
                            ['icon' => 'ni-p', 'icon_class' => 'fa-chalkboard-teacher', 'msg' => 'Teacher <strong>Mwalimu Nasur</strong> published Fiqh lesson', 'tag' => 'Content', 'tag_bg' => 'var(--blue-light)', 'tag_color' => 'var(--blue)', 'time' => 'Yesterday, 5:10 PM'],
                            ['icon' => 'ni-gr', 'icon_class' => 'fa-star', 'msg' => '<strong>Yusuf Mugenyi</strong> achieved Perfect Score on Tajweed quiz', 'tag' => 'Academic', 'tag_bg' => 'var(--green-light)', 'tag_color' => 'var(--green)', 'time' => 'Yesterday, 2:45 PM'],
                            ['icon' => 'ni-g', 'icon_class' => 'fa-cog', 'msg' => 'Platform settings updated — <strong>email notifications</strong> enabled', 'tag' => 'Settings', 'tag_bg' => 'var(--gold-light)', 'tag_color' => 'var(--gold)', 'time' => '2 days ago'],
                        ];
                    @endphp

                    @foreach($activities as $activity)
                    <div class="tl-item">
                        <div class="tl-icon-col">
                            <div class="tl-ico {{ $activity['icon'] }}"><i class="fas {{ $activity['icon_class'] }}"></i></div>
                            <div class="tl-line"></div>
                        </div>
                        <div class="tl-body">
                            <div class="tl-msg">
                                {!! $activity['msg'] !!}
                                <span class="tl-tag" style="background:{{ $activity['tag_bg'] }};color:{{ $activity['tag_color'] }};">{{ $activity['tag'] }}</span>
                            </div>
                            <div class="tl-time">{{ $activity['time'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ── 3-PANEL ROW ── --}}
    <div class="grid-3">
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Attendance</div>
                    <div class="card-head-sub">This week · all classes</div>
                </div>
            </div>
            <div class="card-body">
                <div style="display:flex;justify-content:center;margin-bottom:20px;position:relative;height:160px;">
                    <canvas id="attendDonut"></canvas>
                    <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;flex-direction:column;pointer-events:none;">
                        <span style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:800;color:var(--ink);line-height:1;">91%</span>
                        <span style="font-size:0.68rem;color:var(--muted);margin-top:2px;">Present</span>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.78rem;">
                        <div style="display:flex;align-items:center;gap:6px;"><span style="width:10px;height:10px;border-radius:3px;background:var(--green);display:inline-block;"></span> Present</div>
                        <strong>129 students</strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.78rem;">
                        <div style="display:flex;align-items:center;gap:6px;"><span style="width:10px;height:10px;border-radius:3px;background:var(--red);display:inline-block;"></span> Absent</div>
                        <strong>9 students</strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:0.78rem;">
                        <div style="display:flex;align-items:center;gap:6px;"><span style="width:10px;height:10px;border-radius:3px;background:var(--gold);display:inline-block;"></span> Late</div>
                        <strong>4 students</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Subject Performance</div>
                    <div class="card-head-sub">Avg. student scores by subject</div>
                </div>
            </div>
            <div class="card-body">
                <div class="rating-rows">
                    @php
                        $subjects = [
                            ['name' => 'Quran', 'pct' => 96, 'color' => 'var(--gradient)'],
                            ['name' => 'Tajweed', 'pct' => 91, 'color' => 'linear-gradient(90deg,var(--purple),var(--blue))'],
                            ['name' => 'Arabic', 'pct' => 84, 'color' => 'linear-gradient(90deg,var(--blue),var(--cyan))'],
                            ['name' => 'Fiqh', 'pct' => 79, 'color' => 'linear-gradient(90deg,var(--gold),var(--red))'],
                            ['name' => 'Aqeedah', 'pct' => 86, 'color' => 'linear-gradient(90deg,var(--green),var(--cyan))'],
                            ['name' => 'Seerah', 'pct' => 88, 'color' => 'linear-gradient(90deg,#DB2777,var(--purple))'],
                            ['name' => 'Islamic St.', 'pct' => 77, 'color' => 'linear-gradient(90deg,var(--red),var(--gold))'],
                        ];
                    @endphp

                    @foreach($subjects as $subject)
                    <div class="rating-row">
                        <div class="rating-label">{{ $subject['name'] }}</div>
                        <div class="rating-bar-wrap"><div class="rating-fill" style="width:{{ $subject['pct'] }}%;background:{{ $subject['color'] }};"></div></div>
                        <div class="rating-pct">{{ $subject['pct'] }}%</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Upcoming Events</div>
                    <div class="card-head-sub">{{ now()->format('F Y') }}</div>
                </div>
                <a href="#" class="card-link">Full Cal <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div class="mini-cal">
                    <div class="cal-header">
                        <div class="cal-month">{{ now()->format('F Y') }}</div>
                        <div class="cal-nav">
                            <button class="cal-nav-btn"><i class="fas fa-chevron-left"></i></button>
                            <button class="cal-nav-btn"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                    <div class="cal-grid">
                        <div class="cal-dow">Su</div><div class="cal-dow">Mo</div><div class="cal-dow">Tu</div>
                        <div class="cal-dow">We</div><div class="cal-dow">Th</div><div class="cal-dow">Fr</div><div class="cal-dow">Sa</div>
                        <div class="cal-day other-month">30</div><div class="cal-day other-month">31</div>
                        <div class="cal-day">1</div><div class="cal-day has-event">2</div><div class="cal-day">3</div><div class="cal-day">4</div><div class="cal-day">5</div>
                        <div class="cal-day today">6</div><div class="cal-day">7</div><div class="cal-day has-event">8</div><div class="cal-day">9</div><div class="cal-day">10</div><div class="cal-day">11</div><div class="cal-day">12</div>
                        <div class="cal-day">13</div><div class="cal-day has-event">14</div><div class="cal-day">15</div><div class="cal-day has-event">16</div><div class="cal-day">17</div><div class="cal-day">18</div><div class="cal-day">19</div>
                        <div class="cal-day">20</div><div class="cal-day">21</div><div class="cal-day">22</div><div class="cal-day has-event">23</div><div class="cal-day">24</div><div class="cal-day">25</div><div class="cal-day">26</div>
                    </div>

                    <div class="cal-events">
                        <div class="cal-event ce-purple">
                            <div class="cal-event-name">Mid-Term Exams Begin</div>
                            <div class="cal-event-time">Apr 8</div>
                        </div>
                        <div class="cal-event ce-red">
                            <div class="cal-event-name">Parent-Teacher Meeting</div>
                            <div class="cal-event-time">Apr 14</div>
                        </div>
                        <div class="cal-event ce-gold">
                            <div class="cal-event-name">Quran Recitation Event</div>
                            <div class="cal-event-time">Apr 23</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── SYSTEM HEALTH ── --}}
    <div class="card">
        <div class="card-head">
            <div class="card-head-left">
                <div class="card-head-title">System Health Monitor</div>
                <div class="card-head-sub">Real-time infrastructure metrics · auto-refreshes every 60s</div>
            </div>
            <div class="card-head-right">
                <div style="display:flex;align-items:center;gap:6px;font-size:0.74rem;color:var(--green);font-weight:600;">
                    <div class="sys-card-dot dot-green" style="animation:pulse-green 2s ease-in-out infinite;"></div>
                    All Systems Operational
                </div>
                <a href="#" class="card-link" style="margin-left:8px;">Details <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="card-body">
            <div class="sys-cards">
                @php
                    $sysCards = [
                        ['icon' => 'fa-microchip', 'label' => 'CPU Usage', 'status' => 'Normal', 'status_class' => 'scs-ok', 'dot' => 'dot-green', 'num' => '34', 'sub' => 'Peak today: 94% at 10:22 AM', 'prog_class' => 'spf-green', 'prog_width' => '34'],
                        ['icon' => 'fa-memory', 'label' => 'RAM Usage', 'status' => 'Moderate', 'status_class' => 'scs-warn', 'dot' => 'dot-gold', 'num' => '71', 'sub' => '6.4 GB of 9 GB allocated', 'prog_class' => 'spf-gold', 'prog_width' => '71'],
                        ['icon' => 'fa-hdd', 'label' => 'Disk Space', 'status' => 'Healthy', 'status_class' => 'scs-ok', 'dot' => 'dot-green', 'num' => '48', 'sub' => '241 GB of 500 GB used', 'prog_class' => 'spf-purple', 'prog_width' => '48'],
                        ['icon' => 'fa-users', 'label' => 'Active Sessions', 'status' => 'Live', 'status_class' => 'scs-ok', 'dot' => 'dot-green', 'num' => '63', 'sub' => 'Peak today: 112 users online', 'prog_class' => 'spf-purple', 'prog_width' => '56'],
                    ];
                @endphp

                @foreach($sysCards as $card)
                <div class="sys-card">
                    <div class="sys-card-top">
                        <div class="sys-card-label"><i class="fas {{ $card['icon'] }}" style="margin-right:4px;"></i>{{ $card['label'] }}</div>
                        <div class="sys-card-status {{ $card['status_class'] }}">
                            <div class="sys-card-dot {{ $card['dot'] }}"></div> {{ $card['status'] }}
                        </div>
                    </div>
                    <div class="sys-card-num">{{ $card['num'] }}<span style="font-size:1rem;">%</span></div>
                    <div class="sys-card-sub">{{ $card['sub'] }}</div>
                    <div class="sys-prog"><div class="sys-prog-bar"><div class="sys-prog-fill {{ $card['prog_class'] }}" style="width:{{ $card['prog_width'] }}%;"></div></div></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── RECENT ENROLLMENTS + PENDING PAYMENTS ── --}}
    <div class="grid-2">
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Recent Enrollments</div>
                    <div class="card-head-sub">7 pending approval · sorted by date</div>
                </div>
                <a href="#" class="card-link">Manage <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div class="enroll-grid">
                    @php
                        $enrollments = [
                            ['initials' => 'OK', 'ava_class' => 'ua-1', 'name' => 'Omar Kiggundu', 'class' => 'Arabic Beginners', 'time' => '10 min ago', 'status' => 'Pending', 'badge' => 'badge-pending'],
                            ['initials' => 'ZM', 'ava_class' => 'ua-2', 'name' => 'Zahra Mutebi', 'class' => 'Quran Level 1', 'time' => '45 min ago', 'status' => 'Pending', 'badge' => 'badge-pending'],
                            ['initials' => 'HA', 'ava_class' => 'ua-3', 'name' => 'Hassan Atuhaire', 'class' => 'Fiqh Grade 4', 'time' => '2 hrs ago', 'status' => 'Review', 'badge' => 'badge-review'],
                            ['initials' => 'NB', 'ava_class' => 'ua-4', 'name' => 'Nadia Babirye', 'class' => 'Tajweed Adv.', 'time' => 'Yesterday', 'status' => 'Approved', 'badge' => 'badge-active'],
                        ];
                    @endphp

                    @foreach($enrollments as $enrollment)
                    <div class="enroll-card">
                        <div class="enroll-ava {{ $enrollment['ava_class'] }}">{{ $enrollment['initials'] }}</div>
                        <div class="enroll-info">
                            <div class="enroll-name">{{ $enrollment['name'] }}</div>
                            <div class="enroll-class">{{ $enrollment['class'] }}</div>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:4px;align-items:flex-end;">
                            <div class="enroll-time">{{ $enrollment['time'] }}</div>
                            <span class="badge {{ $enrollment['badge'] }}" style="font-size:0.62rem;">{{ $enrollment['status'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Payment Overview</div>
                    <div class="card-head-sub">Fees tracking · current term</div>
                </div>
                <a href="#" class="card-link">Finance <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div style="display:flex;justify-content:center;position:relative;height:150px;margin-bottom:16px;">
                    <canvas id="revenueDonut"></canvas>
                    <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;flex-direction:column;pointer-events:none;">
                        <span style="font-size:0.65rem;color:var(--muted);font-weight:600;letter-spacing:1px;text-transform:uppercase;">Collected</span>
                        <span style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:800;color:var(--ink);line-height:1;">78%</span>
                    </div>
                </div>
                <div class="mini-tiles">
                    <div class="mini-tile">
                        <div class="mt-ico" style="color:var(--green);">💰</div>
                        <div class="mt-num" style="color:var(--green);">3.8M</div>
                        <div class="mt-label">UGX Collected</div>
                    </div>
                    <div class="mini-tile">
                        <div class="mt-ico" style="color:var(--red);">⏳</div>
                        <div class="mt-num" style="color:var(--red);">620K</div>
                        <div class="mt-label">UGX Overdue</div>
                    </div>
                    <div class="mini-tile">
                        <div class="mt-ico" style="color:var(--gold);">🔔</div>
                        <div class="mt-num" style="color:var(--gold);">3</div>
                        <div class="mt-label">Pending</div>
                    </div>
                    <div class="mini-tile">
                        <div class="mt-ico" style="color:var(--purple);">📊</div>
                        <div class="mt-num" style="color:var(--purple);">4.9M</div>
                        <div class="mt-label">UGX Total Due</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━
       CHART.JS INITIALIZATION
    ━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
    
    Chart.defaults.font.family = 'DM Sans';
    Chart.defaults.color       = '#6B6584';
    
    const tooltipStyle = {
        backgroundColor: '#0F0720',
        titleFont: { family: 'Playfair Display', size: 13, weight: 700 },
        bodyFont:  { family: 'DM Sans', size: 12 },
        padding: 14, cornerRadius: 14, displayColors: true,
        borderColor: 'rgba(107,70,193,0.3)', borderWidth: 1,
    };
    
    /* ── MAIN AREA CHART ── */
    (function() {
        const ctx   = document.getElementById('mainChart').getContext('2d');
        const gPurp = ctx.createLinearGradient(0, 0, 0, 270);
        gPurp.addColorStop(0, 'rgba(107,70,193,0.28)');
        gPurp.addColorStop(1, 'rgba(107,70,193,0)');
        const gRed  = ctx.createLinearGradient(0, 0, 0, 270);
        gRed.addColorStop(0, 'rgba(220,38,38,0.2)');
        gRed.addColorStop(1, 'rgba(220,38,38,0)');
    
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar','Apr'],
                datasets: [
                    {
                        label: 'Enrollments',
                        data: [38, 42, 51, 59, 64, 72, 80, 88, 95, 108, 128, 142],
                        borderColor: '#6B46C1',
                        backgroundColor: gPurp,
                        borderWidth: 2.5, fill: true, tension: 0.42,
                        pointBackgroundColor: '#6B46C1', pointRadius: 4, pointHoverRadius: 7,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Revenue (×10K UGX)',
                        data: [180, 210, 250, 290, 310, 340, 370, 400, 430, 460, 350, 380],
                        borderColor: '#DC2626',
                        backgroundColor: gRed,
                        borderWidth: 2, fill: true, tension: 0.42,
                        pointBackgroundColor: '#DC2626', pointRadius: 3, pointHoverRadius: 6,
                        yAxisID: 'y1',
                    },
                    {
                        label: 'Completions',
                        data: [32, 36, 44, 50, 55, 65, 72, 80, 88, 98, 110, 124],
                        borderColor: '#D97706',
                        backgroundColor: 'transparent',
                        borderWidth: 2, fill: false, tension: 0.42,
                        borderDash: [6, 4],
                        pointBackgroundColor: '#D97706', pointRadius: 3, pointHoverRadius: 5,
                        yAxisID: 'y',
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { display: false }, tooltip: tooltipStyle },
                scales: {
                    x: { grid: { color: 'rgba(107,70,193,0.06)' }, ticks: { font: { size: 11 } } },
                    y: {
                        type: 'linear', position: 'left',
                        grid: { color: 'rgba(107,70,193,0.06)' },
                        ticks: { font: { size: 11 } }
                    },
                    y1: {
                        type: 'linear', position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: { font: { size: 11 }, callback: v => v + 'K' }
                    }
                }
            }
        });
    })();
    
    /* ── ATTENDANCE DONUT ── */
    (function() {
        const ctx = document.getElementById('attendDonut').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Present','Absent','Late'],
                datasets: [{
                    data: [91, 6, 3],
                    backgroundColor: ['#16A34A', '#DC2626', '#D97706'],
                    borderColor: 'white', borderWidth: 3, hoverOffset: 6,
                }]
            },
            options: {
                responsive: false, cutout: '72%',
                plugins: { legend: { display: false }, tooltip: tooltipStyle },
                width: 160, height: 160,
            }
        });
    })();
    
    /* ── REVENUE DONUT ── */
    (function() {
        const ctx = document.getElementById('revenueDonut').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Collected','Pending','Overdue'],
                datasets: [{
                    data: [78, 9, 13],
                    backgroundColor: ['#16A34A', '#D97706', '#DC2626'],
                    borderColor: 'white', borderWidth: 3, hoverOffset: 6,
                }]
            },
            options: {
                responsive: false, cutout: '70%',
                plugins: { legend: { display: false }, tooltip: tooltipStyle },
                width: 150, height: 150,
            }
        });
    })();
    
    /* Chart period toggle */
    function setPeriod(btn, period) {
        btn.closest('.pill-filters').querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
    }
    
    /* KPI hover ripple numbers */
    document.querySelectorAll('.kpi-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            const num = card.querySelector('.kpi-num');
            if (num) {
                num.style.transform = 'scale(1.04)';
                num.style.transition = 'transform 0.2s ease';
            }
        });
        card.addEventListener('mouseleave', () => {
            const num = card.querySelector('.kpi-num');
            if (num) num.style.transform = 'scale(1)';
        });
    });
</script>
@endsection