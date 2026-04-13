@extends('layouts.master2')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<style>
:root {
    --purple: #6B46C1;
    --purple-dark: #4C2E8A;
    --purple-light: #EDE9FA;
    --red: #DC2626;
    --red-light: #FEE2E2;
    --red-dark: #9B1C1C;
    --gold: #D97706;
    --gold-light: #FEF3C7;
    --cream: #FDFBF7;
    --cream2: #F7F3EE;
    --ink: #1A0A2E;
    --ink2: #3B2459;
    --muted: #6B6584;
    --border: rgba(107,70,193,0.12);
    --border2: rgba(107,70,193,0.22);
    --gradient: linear-gradient(135deg, var(--purple) 0%, var(--red) 100%);
    --gradient-soft: linear-gradient(135deg, #EDE9FA 0%, #FEE2E2 100%);
    --shadow-sm: 0 2px 12px rgba(107,70,193,0.08);
    --shadow-md: 0 8px 32px rgba(107,70,193,0.12);
    --shadow-lg: 0 20px 60px rgba(107,70,193,0.16);
    --shadow-xl: 0 32px 80px rgba(107,70,193,0.2);
}

*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

html { scroll-behavior: smooth; }

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--ink);
    padding-bottom: 80px;
    overflow-x: hidden;
}

::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--purple-light); }
::-webkit-scrollbar-thumb { background: var(--purple); border-radius: 10px; }

/* ── TYPOGRAPHY ── */
.font-display { font-family: 'Playfair Display', serif; }
h1,h2,h3 { font-family: 'Playfair Display', serif; line-height: 1.15; }

/* ── UTILITY ── */
.container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.section { padding: 80px 0; }
.section-sm { padding: 56px 0; }
.text-center { text-align: center; }

.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: var(--red);
    margin-bottom: 14px;
}
.eyebrow::before {
    content: '';
    width: 24px; height: 2px;
    background: var(--red);
    border-radius: 2px;
}

.section-heading {
    font-size: clamp(1.9rem, 4vw, 2.6rem);
    font-weight: 700;
    color: var(--ink);
    line-height: 1.2;
    margin-bottom: 16px;
}

.section-sub {
    font-size: 1rem;
    color: var(--muted);
    line-height: 1.7;
    max-width: 560px;
}
.text-center .section-sub { margin: 0 auto; }

/* ── BUTTONS ── */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 28px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.25s ease;
    font-family: 'DM Sans', sans-serif;
    letter-spacing: 0.2px;
}
.btn-primary {
    background: var(--gradient);
    color: white;
    box-shadow: 0 6px 20px rgba(107,70,193,0.35);
}
.btn-primary:hover {
    box-shadow: 0 10px 28px rgba(107,70,193,0.45);
    transform: translateY(-2px);
    color: white;
}
.btn-outline {
    background: transparent;
    border: 1.5px solid var(--purple);
    color: var(--purple);
}
.btn-outline:hover {
    background: var(--purple);
    color: white;
    transform: translateY(-2px);
}
.btn-ghost {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
}
.btn-ghost:hover {
    background: rgba(255,255,255,0.25);
    color: white;
}
.btn-sm { padding: 7px 18px; font-size: 0.78rem; }
.btn-red {
    background: var(--red);
    color: white;
    box-shadow: 0 6px 20px rgba(220,38,38,0.3);
}
.btn-red:hover { background: var(--red-dark); transform: translateY(-2px); color: white; }

/* ── TOP HEADER ── */
.site-header {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 999;
    background: rgba(253,251,247,0.92);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
    transition: box-shadow 0.3s;
}
.site-header.scrolled { box-shadow: var(--shadow-md); }
.header-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    height: 68px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.header-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
}
.header-logo img {
    width: 42px; height: 42px;
    border-radius: 12px;
    object-fit: cover;
    box-shadow: var(--shadow-sm);
}
.header-logo-text { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 700; color: var(--ink); line-height: 1.2; }
.header-logo-sub { font-size: 0.68rem; color: var(--muted); font-family: 'DM Sans', sans-serif; font-weight: 400; }
.header-actions { display: flex; gap: 10px; align-items: center; }

/* ── HERO ── */
.hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: var(--ink);
    padding-top: 68px;
}
.hero-bg {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, #1A0A2E 0%, #2D0F5C 40%, #4A1A1A 100%);
}
.hero-pattern {
    position: absolute; inset: 0;
    opacity: 0.04;
    background-image:
        repeating-linear-gradient(0deg, transparent, transparent 60px, rgba(255,255,255,0.5) 60px, rgba(255,255,255,0.5) 61px),
        repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(255,255,255,0.5) 60px, rgba(255,255,255,0.5) 61px);
}
.hero-orb-1 {
    position: absolute;
    width: 600px; height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(107,70,193,0.35) 0%, transparent 70%);
    top: -100px; right: -150px;
    pointer-events: none;
}
.hero-orb-2 {
    position: absolute;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(220,38,38,0.25) 0%, transparent 70%);
    bottom: 0; left: -100px;
    pointer-events: none;
}
.hero-inner {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 80px 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    backdrop-filter: blur(6px);
    padding: 7px 16px;
    border-radius: 40px;
    font-size: 0.78rem;
    font-weight: 500;
    color: rgba(255,255,255,0.9);
    margin-bottom: 24px;
}
.hero-badge-dot {
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
.hero-title {
    font-size: clamp(2.5rem, 5vw, 3.8rem);
    font-weight: 800;
    color: white;
    line-height: 1.1;
    margin-bottom: 20px;
    letter-spacing: -0.5px;
}
.hero-title-accent {
    background: linear-gradient(135deg, #C084FC, #F87171);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.hero-desc {
    font-size: 1.05rem;
    color: rgba(255,255,255,0.72);
    line-height: 1.75;
    margin-bottom: 36px;
    max-width: 480px;
}
.hero-actions { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 48px; }
.hero-stats {
    display: flex;
    gap: 32px;
    padding-top: 28px;
    border-top: 1px solid rgba(255,255,255,0.1);
}
.hero-stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 1.9rem;
    font-weight: 700;
    color: white;
    line-height: 1;
}
.hero-stat-label { font-size: 0.78rem; color: rgba(255,255,255,0.55); margin-top: 4px; }
.hero-visual { position: relative; }
.hero-card-main {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.12);
    backdrop-filter: blur(20px);
    border-radius: 28px;
    padding: 28px;
    position: relative;
    overflow: hidden;
}
.hero-card-main::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; height: 3px;
    background: var(--gradient);
}
.progress-row { display: flex; flex-direction: column; gap: 14px; }
.progress-item {}
.progress-label { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.82rem; color: rgba(255,255,255,0.7); }
.progress-bar-bg { background: rgba(255,255,255,0.1); border-radius: 40px; height: 8px; overflow: hidden; }
.progress-bar-fill { height: 100%; border-radius: 40px; background: var(--gradient); position: relative; }
.progress-bar-fill::after {
    content: '';
    position: absolute;
    right: 0; top: 50%;
    transform: translateY(-50%);
    width: 14px; height: 14px;
    background: white;
    border-radius: 50%;
    box-shadow: 0 0 10px rgba(107,70,193,0.6);
}
.hero-float-card {
    position: absolute;
    background: white;
    border-radius: 20px;
    padding: 14px 18px;
    box-shadow: var(--shadow-lg);
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.82rem;
    font-weight: 500;
    color: var(--ink);
    animation: float-y 3s ease-in-out infinite;
}
.hero-float-card-2 { animation-delay: 1.5s; }
@keyframes float-y {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}
.float-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
}

/* ── ABOUT / FEATURES STRIP ── */
.features-strip {
    background: white;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 60px 0;
}
.features-strip-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
}
.strip-feature {
    padding: 28px 32px;
    border-right: 1px solid var(--border);
    position: relative;
    transition: background 0.2s;
}
.strip-feature:last-child { border-right: none; }
.strip-feature:hover { background: var(--cream2); }
.strip-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    margin-bottom: 16px;
}
.strip-icon-purple { background: var(--purple-light); color: var(--purple); }
.strip-icon-red { background: var(--red-light); color: var(--red); }
.strip-icon-gold { background: var(--gold-light); color: var(--gold); }
.strip-icon-green { background: #DCFCE7; color: #16A34A; }
.strip-feature h4 { font-size: 1rem; font-weight: 600; margin-bottom: 6px; color: var(--ink); font-family: 'DM Sans', sans-serif; }
.strip-feature p { font-size: 0.84rem; color: var(--muted); line-height: 1.6; }

/* ── ABOUT SECTION ── */
.about-section { background: var(--cream); }
.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
.about-mini-cards {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 36px;
}
.mini-card {
    background: white;
    border-radius: 20px;
    padding: 22px;
    border: 1px solid var(--border);
    transition: all 0.25s;
    position: relative;
    overflow: hidden;
}
.mini-card::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: var(--gradient);
    transform: scaleX(0);
    transition: transform 0.25s;
    transform-origin: left;
}
.mini-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
.mini-card:hover::before { transform: scaleX(1); }
.mini-card i { font-size: 1.6rem; margin-bottom: 10px; }
.mini-card h4 { font-size: 0.95rem; font-weight: 600; color: var(--ink); margin-bottom: 4px; font-family: 'DM Sans'; }
.mini-card p { font-size: 0.78rem; color: var(--muted); }
.about-visual-side { position: relative; }
.about-image-wrap {
    border-radius: 32px;
    overflow: hidden;
    position: relative;
    aspect-ratio: 4/5;
    background: linear-gradient(135deg, var(--ink) 0%, var(--purple-dark) 100%);
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 32px;
}
.about-image-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(26,10,46,0.95) 0%, rgba(26,10,46,0.3) 60%, transparent 100%);
}
.about-image-content {
    position: relative; z-index: 2;
    color: white;
}
.about-image-content h3 { font-size: 1.5rem; font-weight: 700; margin-bottom: 8px; }
.about-image-content p { font-size: 0.85rem; opacity: 0.75; line-height: 1.6; }
.about-floating-badge {
    position: absolute;
    top: 28px; right: -20px;
    background: white;
    border-radius: 18px;
    padding: 16px 20px;
    box-shadow: var(--shadow-lg);
    text-align: center;
    min-width: 110px;
}
.about-floating-badge .num {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    background: var(--gradient);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    line-height: 1;
}
.about-floating-badge .lbl { font-size: 0.72rem; color: var(--muted); margin-top: 4px; font-weight: 500; }
.about-text p {
    font-size: 0.98rem;
    color: var(--muted);
    line-height: 1.8;
    margin-bottom: 16px;
}

/* ── STATS BANNER ── */
.stats-banner {
    background: linear-gradient(135deg, var(--purple-dark) 0%, var(--ink) 100%);
    padding: 64px 0;
    position: relative;
    overflow: hidden;
}
.stats-banner::before {
    content: '';
    position: absolute; inset: 0;
    background-image: radial-gradient(circle at 20% 50%, rgba(107,70,193,0.3) 0%, transparent 50%),
                      radial-gradient(circle at 80% 50%, rgba(220,38,38,0.2) 0%, transparent 50%);
}
.stats-grid {
    position: relative;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
}
.stat-item {
    text-align: center;
    padding: 28px;
    border-right: 1px solid rgba(255,255,255,0.1);
    position: relative;
}
.stat-item:last-child { border-right: none; }
.stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 3rem;
    font-weight: 800;
    color: white;
    line-height: 1;
    margin-bottom: 8px;
    display: block;
}
.stat-lbl { font-size: 0.82rem; color: rgba(255,255,255,0.55); font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
.stat-divider {
    position: absolute;
    bottom: 0; left: 50%;
    transform: translateX(-50%);
    width: 24px; height: 2px;
    background: var(--gradient);
    border-radius: 2px;
}

/* ── CURRICULUM SECTION ── */
.curriculum-section { background: var(--cream2); }
.level-accordion {
    margin-top: 48px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.level-card {
    background: white;
    border-radius: 20px;
    border: 1px solid var(--border);
    overflow: hidden;
    transition: box-shadow 0.2s;
}
.level-card:hover { box-shadow: var(--shadow-sm); }
.level-header-btn {
    width: 100%;
    padding: 20px 28px;
    background: none;
    border: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    text-align: left;
    gap: 16px;
    transition: background 0.2s;
}
.level-header-btn:hover { background: var(--cream); }
.level-header-btn.active { background: var(--purple); }
.level-header-left { display: flex; align-items: center; gap: 16px; }
.level-number {
    width: 40px; height: 40px;
    background: var(--gradient-soft);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--purple);
}
.level-header-btn.active .level-number {
    background: rgba(255,255,255,0.2);
    color: white;
}
.level-title { font-size: 1rem; font-weight: 600; color: var(--ink); font-family: 'DM Sans'; }
.level-header-btn.active .level-title { color: white; }
.level-meta { font-size: 0.78rem; color: var(--muted); margin-top: 2px; }
.level-header-btn.active .level-meta { color: rgba(255,255,255,0.65); }
.level-toggle {
    width: 32px; height: 32px;
    background: var(--purple-light);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--purple);
    font-size: 0.75rem;
    transition: transform 0.3s, background 0.2s;
    flex-shrink: 0;
}
.level-header-btn.active .level-toggle {
    background: rgba(255,255,255,0.2);
    color: white;
    transform: rotate(180deg);
}
.level-body {
    padding: 24px 28px;
    border-top: 1px solid var(--border);
    background: var(--cream);
    display: none;
}
.level-body.open { display: block; }
.class-tabs-row {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 24px;
}
.class-tab-btn {
    padding: 7px 18px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    border: 1.5px solid var(--border2);
    background: white;
    color: var(--ink2);
    transition: all 0.2s;
    font-family: 'DM Sans', sans-serif;
}
.class-tab-btn.active {
    background: var(--gradient);
    color: white;
    border-color: transparent;
    box-shadow: 0 4px 12px rgba(107,70,193,0.3);
}
.subjects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 14px;
}
.subject-card {
    background: white;
    border-radius: 16px;
    padding: 18px;
    border: 1px solid var(--border);
    transition: all 0.2s;
}
.subject-card:hover { box-shadow: var(--shadow-sm); border-color: var(--border2); }
.subject-card-head {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 14px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
}
.subject-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: var(--purple-light);
    color: var(--purple);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem;
}
.subject-title { font-size: 0.9rem; font-weight: 600; color: var(--ink); }
.lesson-list { display: flex; flex-direction: column; gap: 8px; }
.lesson-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    background: var(--cream);
    border-radius: 10px;
    gap: 8px;
    flex-wrap: wrap;
}
.lesson-info { display: flex; align-items: center; gap: 8px; flex: 1; min-width: 0; }
.lesson-type-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
    white-space: nowrap;
}
.badge-video { background: #EDE9FA; color: var(--purple); }
.badge-audio { background: var(--red-light); color: var(--red); }
.badge-pdf { background: var(--gold-light); color: var(--gold); }
.lesson-title-text { font-size: 0.78rem; color: var(--ink); font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 140px; }
.lesson-actions { display: flex; gap: 6px; align-items: center; flex-shrink: 0; }
.btn-view-lesson {
    background: var(--red);
    color: white;
    border: none;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    cursor: pointer;
    font-family: 'DM Sans';
    transition: 0.2s;
}
.btn-view-lesson:hover { background: var(--red-dark); }
.btn-quiz-lesson {
    background: var(--purple);
    color: white;
    border: none;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    cursor: pointer;
    font-family: 'DM Sans';
    transition: 0.2s;
}
.btn-quiz-lesson:hover { background: var(--purple-dark); }
.quiz-passed-badge {
    background: #DCFCE7;
    color: #16A34A;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    display: inline-flex; align-items: center; gap: 4px;
}

/* ── PROGRESS / FEATURES ── */
.progress-section { background: white; }
.progress-cards-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-top: 48px;
}
.progress-card {
    border-radius: 24px;
    padding: 36px 28px;
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
    transition: all 0.3s;
}
.progress-card::after {
    content: '';
    position: absolute;
    top: 0; right: 0;
    width: 120px; height: 120px;
    border-radius: 50%;
    opacity: 0.07;
    transform: translate(30%, -30%);
}
.progress-card-1 { background: var(--purple-light); }
.progress-card-1::after { background: var(--purple); }
.progress-card-2 { background: var(--red-light); }
.progress-card-2::after { background: var(--red); }
.progress-card-3 { background: var(--gold-light); }
.progress-card-3::after { background: var(--gold); }
.progress-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-md); }
.progress-card-icon {
    width: 56px; height: 56px;
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 22px;
    position: relative; z-index: 1;
}
.progress-card-1 .progress-card-icon { background: white; color: var(--purple); }
.progress-card-2 .progress-card-icon { background: white; color: var(--red); }
.progress-card-3 .progress-card-icon { background: white; color: var(--gold); }
.progress-card h3 { font-size: 1.25rem; font-weight: 700; margin-bottom: 12px; color: var(--ink); position: relative; z-index: 1; }
.progress-card p { font-size: 0.88rem; color: var(--muted); line-height: 1.7; position: relative; z-index: 1; }

/* ── TESTIMONIALS ── */
.testimonials-section { background: var(--cream2); }
.testimonial-card {
    background: white;
    border-radius: 24px;
    padding: 28px;
    border: 1px solid var(--border);
    height: 100%;
    display: flex; flex-direction: column;
    transition: all 0.2s;
}
.testimonial-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
.testimonial-stars { display: flex; gap: 3px; margin-bottom: 16px; }
.testimonial-stars i { color: var(--gold); font-size: 0.85rem; }
.testimonial-text {
    font-size: 0.92rem;
    color: var(--muted);
    line-height: 1.75;
    flex: 1;
    font-style: italic;
    margin-bottom: 20px;
}
.testimonial-quote-icon {
    font-size: 3rem;
    line-height: 0;
    font-family: Georgia, serif;
    color: var(--purple-light);
    position: absolute;
    top: 18px; right: 24px;
    opacity: 0.5;
}
.testimonial-user { display: flex; align-items: center; gap: 12px; }
.testimonial-avatar {
    width: 48px; height: 48px;
    border-radius: 50%;
    background-size: cover; background-position: center;
    border: 2px solid var(--purple-light);
}
.testimonial-name { font-weight: 600; font-size: 0.88rem; color: var(--ink); }
.testimonial-role { font-size: 0.75rem; color: var(--muted); }
.swiper-pagination-bullet { background: var(--purple) !important; }
.swiper-pagination-bullet-active { background: var(--red) !important; }

/* ── CONTACT ── */
.contact-section { background: white; }
.contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: start; }
.contact-info h2 { margin-bottom: 16px; }
.contact-info .section-sub { margin-bottom: 32px; }
.contact-detail-row {
    display: flex; gap: 16px;
    align-items: flex-start;
    margin-bottom: 22px;
}
.contact-detail-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: var(--purple-light);
    color: var(--purple);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 1rem;
}
.contact-detail-label { font-size: 0.75rem; color: var(--muted); font-weight: 500; margin-bottom: 3px; }
.contact-detail-value { font-size: 0.92rem; font-weight: 600; color: var(--ink); }
.contact-form-card {
    background: var(--cream);
    border-radius: 28px;
    padding: 36px;
    border: 1px solid var(--border);
}
.form-group { margin-bottom: 18px; }
.form-group label {
    display: block;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--ink2);
    margin-bottom: 8px;
}
.form-control-alhilal {
    width: 100%;
    padding: 13px 18px;
    border-radius: 50px;
    border: 1.5px solid var(--border2);
    background: white;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    color: var(--ink);
    transition: all 0.2s;
    outline: none;
}
.form-control-alhilal:focus {
    border-color: var(--purple);
    box-shadow: 0 0 0 3px rgba(107,70,193,0.1);
}
textarea.form-control-alhilal {
    border-radius: 20px;
    min-height: 100px;
    resize: vertical;
}

/* ── FOOTER ── */
.site-footer {
    background: var(--ink);
    color: rgba(255,255,255,0.7);
    padding: 60px 0 30px;
}
.footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 60px;
    margin-bottom: 48px;
    padding-bottom: 48px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}
.footer-brand { }
.footer-logo-row { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
.footer-logo-img { width: 44px; height: 44px; border-radius: 12px; object-fit: cover; }
.footer-logo-name { font-family: 'Playfair Display', serif; font-size: 1.1rem; color: white; font-weight: 700; }
.footer-brand p { font-size: 0.85rem; line-height: 1.7; max-width: 280px; }
.footer-social { display: flex; gap: 10px; margin-top: 20px; }
.footer-social-btn {
    width: 38px; height: 38px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.1);
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    font-size: 0.85rem;
    transition: all 0.2s;
}
.footer-social-btn:hover { background: var(--purple); border-color: var(--purple); color: white; }
.footer-col h5 { font-size: 0.85rem; font-weight: 600; color: white; margin-bottom: 16px; letter-spacing: 0.5px; }
.footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
.footer-col ul li a { font-size: 0.83rem; color: rgba(255,255,255,0.55); text-decoration: none; transition: color 0.2s; }
.footer-col ul li a:hover { color: white; }
.footer-bottom { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
.footer-bottom p { font-size: 0.78rem; }

/* ── BOTTOM NAV ── */
.bottom-nav {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    z-index: 998;
    background: rgba(253,251,247,0.97);
    backdrop-filter: blur(16px);
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: space-around;
    padding: 8px 0 12px;
}
.nav-item {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    text-decoration: none;
    color: var(--muted);
    font-size: 0.65rem;
    font-weight: 500;
    flex: 1;
    transition: color 0.2s;
    cursor: pointer;
}
.nav-item i { font-size: 1.25rem; transition: transform 0.2s; }
.nav-item:hover i { transform: translateY(-2px); }
.nav-item.active { color: var(--purple); font-weight: 600; }
.nav-item.nav-whatsapp { color: #25D366; }
.nav-item.nav-whatsapp:hover { color: #128C7E; }

/* ── MODALS ── */
.modal-backdrop {
    display: none;
    position: fixed; inset: 0;
    background: rgba(26,10,46,0.85);
    z-index: 2000;
    backdrop-filter: blur(6px);
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.modal-backdrop.open { display: flex; }
.modal-box {
    background: white;
    border-radius: 28px;
    padding: 32px;
    max-width: 500px;
    width: 100%;
    position: relative;
    animation: modal-in 0.3s ease;
    max-height: 85vh;
    overflow-y: auto;
    border-top: 4px solid transparent;
    border-image: var(--gradient) 1;
    border-top-left-radius: 28px;
    border-top-right-radius: 28px;
}
@keyframes modal-in {
    from { transform: translateY(-24px) scale(0.96); opacity: 0; }
    to { transform: translateY(0) scale(1); opacity: 1; }
}
.modal-close {
    position: absolute;
    top: 16px; right: 16px;
    width: 32px; height: 32px;
    border-radius: 50%;
    border: none;
    background: var(--cream2);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem;
    color: var(--muted);
    font-family: 'DM Sans';
    transition: 0.2s;
}
.modal-close:hover { background: var(--red-light); color: var(--red); }
.modal-icon { font-size: 2.5rem; color: var(--purple); margin-bottom: 12px; }
.modal-title { font-size: 1.3rem; font-weight: 700; color: var(--ink); margin-bottom: 8px; }
.modal-desc { font-size: 0.88rem; color: var(--muted); line-height: 1.6; margin-bottom: 20px; }
.quiz-question-block {
    background: var(--cream2);
    border-radius: 16px;
    padding: 16px;
    margin-bottom: 12px;
}
.quiz-question-block p { font-size: 0.88rem; font-weight: 600; color: var(--ink); margin-bottom: 10px; }
.quiz-option-label {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 12px;
    margin: 4px 0;
    cursor: pointer;
    border-radius: 10px;
    font-size: 0.82rem;
    color: var(--ink);
    transition: 0.15s;
}
.quiz-option-label:hover { background: var(--purple-light); }
.quiz-option-label input { width: auto; margin: 0; }
.quiz-result-box {
    border-radius: 16px;
    padding: 16px;
    font-weight: 600;
    font-size: 0.9rem;
    text-align: center;
    margin-top: 14px;
    display: none;
}
.quiz-result-pass { background: #DCFCE7; color: #166534; }
.quiz-result-fail { background: var(--red-light); color: var(--red-dark); }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
    .hero-inner { grid-template-columns: 1fr; gap: 40px; }
    .hero-visual { display: none; }
    .about-grid { grid-template-columns: 1fr; gap: 40px; }
    .progress-cards-grid { grid-template-columns: 1fr; }
    .contact-grid { grid-template-columns: 1fr; gap: 40px; }
    .footer-grid { grid-template-columns: 1fr; gap: 32px; }
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .stat-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.1); }
    .features-strip-grid { grid-template-columns: repeat(2, 1fr); }
    .strip-feature { border-right: none; border-bottom: 1px solid var(--border); }
    .header-actions .btn-outline { display: none; }
}
@media (max-width: 600px) {
    .hero-title { font-size: 2rem; }
    .hero-stats { gap: 20px; flex-wrap: wrap; }
    .features-strip-grid { grid-template-columns: 1fr; }
    .subjects-grid { grid-template-columns: 1fr; }
    .footer-bottom { flex-direction: column; text-align: center; }
    .progress-cards-grid { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('content')

<!-- ════════════════════ SITE HEADER ════════════════════ -->
<header class="site-header" id="siteHeader">
    <div class="header-inner">
        <a href="{{ url('/') }}" class="header-logo">
            <img src="{{ asset('assets/images/alhilal_logo.jpeg') }}" alt="Al-Hilal Online Academy">
            <div>
                <div class="header-logo-text">Al-Hilal Online Academy</div>
                <div class="header-logo-sub">Online Islamic Learning</div>
            </div>
        </a>
        <div class="header-actions">
            <a href="{{ url('/users/register') }}" class="btn btn-outline btn-sm">Register</a>
            <a href="{{ url('/users/login') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-right-to-bracket"></i> Sign In
            </a>
        </div>
    </div>
</header>

<!-- ════════════════════ HERO ════════════════════ -->
<section class="hero" id="home">
    <div class="hero-bg"></div>
    <div class="hero-pattern"></div>
    <div class="hero-orb-1"></div>
    <div class="hero-orb-2"></div>

    <div class="hero-inner">
        <!-- Left: Copy -->
        <div class="hero-left">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Now enrolling for 2026/2027
            </div>
            <h1 class="hero-title">
                Islamic Education<br>
                for <span class="hero-title-accent">Every</span><br>
                Level, P.1 – S.6
            </h1>
            <p class="hero-desc">
                Video lessons, audio tracks, and PDF notes — with quizzes after each lesson to reinforce learning. Track your progress, earn certificates, and grow in knowledge.
            </p>
            <div class="hero-actions">
                <a href="#curriculum" class="btn btn-primary">
                    <i class="fas fa-layer-group"></i> Explore Curriculum
                </a>
                <a href="{{ url('/users/register') }}" class="btn btn-ghost">
                    <i class="fas fa-user-plus"></i> Get Started Free
                </a>
            </div>
            <div class="hero-stats">
                <div>
                    <div class="hero-stat-num" data-count="500">500+</div>
                    <div class="hero-stat-label">Lessons</div>
                </div>
                <div>
                    <div class="hero-stat-num" data-count="60">60+</div>
                    <div class="hero-stat-label">Subjects</div>
                </div>
                <div>
                    <div class="hero-stat-num" data-count="5">5</div>
                    <div class="hero-stat-label">Levels</div>
                </div>
                <div>
                    <div class="hero-stat-num" data-count="20">20+</div>
                    <div class="hero-stat-label">Classes</div>
                </div>
            </div>
        </div>

        <!-- Right: Visual Card -->
        <div class="hero-visual">
            <div class="hero-card-main" style="position: relative;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                    <img src="{{ asset('assets/images/alhilal_logo.jpeg') }}" style="width: 44px; height: 44px; border-radius: 12px; object-fit: cover;">
                    <div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: white;">Student Progress</div>
                        <div style="font-size: 0.72rem; color: rgba(255,255,255,0.5);">2026/2027 Academic Year</div>
                    </div>
                    <div style="margin-left: auto; background: rgba(74,222,128,0.15); border: 1px solid rgba(74,222,128,0.3); color: #4ade80; padding: 4px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 600;">Active</div>
                </div>
                <div class="progress-row">
                    <div class="progress-item">
                        <div class="progress-label"><span>Quran Recitation</span><span>87%</span></div>
                        <div class="progress-bar-bg"><div class="progress-bar-fill" style="width: 87%;"></div></div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-label"><span>Islamic Studies</span><span>72%</span></div>
                        <div class="progress-bar-bg"><div class="progress-bar-fill" style="width: 72%;"></div></div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-label"><span>Arabic Language</span><span>65%</span></div>
                        <div class="progress-bar-bg"><div class="progress-bar-fill" style="width: 65%;"></div></div>
                    </div>
                    <div class="progress-item">
                        <div class="progress-label"><span>Fiqh & Ethics</span><span>91%</span></div>
                        <div class="progress-bar-bg"><div class="progress-bar-fill" style="width: 91%;"></div></div>
                    </div>
                </div>
                <div style="margin-top: 22px; padding-top: 18px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; gap: 16px; justify-content: space-between;">
                    <div style="text-align: center;">
                        <div style="font-size: 1.4rem; font-weight: 700; color: white; font-family: 'Playfair Display', serif;">12</div>
                        <div style="font-size: 0.68rem; color: rgba(255,255,255,0.5);">Quizzes Passed</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.4rem; font-weight: 700; color: white; font-family: 'Playfair Display', serif;">3</div>
                        <div style="font-size: 0.68rem; color: rgba(255,255,255,0.5);">Certificates</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.4rem; font-weight: 700; color: white; font-family: 'Playfair Display', serif;">S.3</div>
                        <div style="font-size: 0.68rem; color: rgba(255,255,255,0.5);">Current Level</div>
                    </div>
                </div>
            </div>

            <!-- Floating badges -->
            <div class="hero-float-card" style="bottom: -20px; left: -30px;">
                <div class="float-icon" style="background: #DCFCE7; color: #16A34A;">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <div style="font-size: 0.82rem; font-weight: 600;">Quiz Passed!</div>
                    <div style="font-size: 0.72rem; color: var(--muted);">Tafsir — Lesson 7</div>
                </div>
            </div>
            <div class="hero-float-card hero-float-card-2" style="top: -16px; right: -24px;">
                <div class="float-icon" style="background: #EDE9FA; color: var(--purple);">
                    <i class="fas fa-certificate"></i>
                </div>
                <div>
                    <div style="font-size: 0.82rem; font-weight: 600;">New Certificate</div>
                    <div style="font-size: 0.72rem; color: var(--muted);">Level 2 Complete</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════ FEATURES STRIP ════════════════════ -->
<div class="features-strip">
    <div class="container">
        <div class="features-strip-grid">
            <div class="strip-feature">
                <div class="strip-icon strip-icon-purple"><i class="fas fa-video"></i></div>
                <h4>Video Lessons</h4>
                <p>Engaging recorded lessons taught by qualified Islamic scholars, available on any device.</p>
            </div>
            <div class="strip-feature">
                <div class="strip-icon strip-icon-red"><i class="fas fa-headphones"></i></div>
                <h4>Audio Tracks</h4>
                <p>Listen and learn anywhere. Perfect for commuting or revision sessions on the go.</p>
            </div>
            <div class="strip-feature">
                <div class="strip-icon strip-icon-gold"><i class="fas fa-file-pdf"></i></div>
                <h4>PDF Notes</h4>
                <p>Detailed study notes in Arabic and English. Download for offline reference and revision.</p>
            </div>
            <div class="strip-feature">
                <div class="strip-icon strip-icon-green"><i class="fas fa-trophy"></i></div>
                <h4>Certifications</h4>
                <p>Earn recognized certificates after passing all quizzes and completing a full level.</p>
            </div>
        </div>
    </div>
</div>

<!-- ════════════════════ ABOUT ════════════════════ -->
<section class="about-section section" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-text">
                <span class="eyebrow">Our Learning Model</span>
                <h2 class="section-heading">Learn, Test,<br>Then Succeed</h2>
                <p>Al-Hilal Online Academy brings structured Islamic education to students from Primary 1 through Senior 6. Every lesson is carefully crafted by qualified teachers and comes with assessments to ensure genuine understanding.</p>
                <p>Our platform serves students, parents, and teachers with dedicated dashboards — providing full visibility into progress, quiz results, reports, and certificates.</p>
                <a href="#curriculum" class="btn btn-primary" style="margin-top: 8px;">
                    <i class="fas fa-book-open"></i> Browse All Levels
                </a>
                <div class="about-mini-cards">
                    <div class="mini-card">
                        <i class="fas fa-video" style="color: var(--purple);"></i>
                        <h4>Video Lessons</h4>
                        <p>Watch & Learn</p>
                    </div>
                    <div class="mini-card">
                        <i class="fas fa-question-circle" style="color: var(--red);"></i>
                        <h4>Post-Lesson Quizzes</h4>
                        <p>Test & Track</p>
                    </div>
                    <div class="mini-card">
                        <i class="fas fa-chart-line" style="color: var(--gold);"></i>
                        <h4>Progress Reports</h4>
                        <p>For students & parents</p>
                    </div>
                    <div class="mini-card">
                        <i class="fas fa-certificate" style="color: #16A34A;"></i>
                        <h4>Certificates</h4>
                        <p>On level completion</p>
                    </div>
                </div>
            </div>
            <div class="about-visual-side">
                <div class="about-image-wrap">
                    <div style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(26,10,46,0.8) 0%, rgba(107,70,193,0.6) 50%, rgba(220,38,38,0.4) 100%);"></div>
                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; opacity: 0.06;">
                        <div style="font-size: 12rem; font-family: 'Playfair Display', serif; color: white; line-height: 1;">﷽</div>
                    </div>
                    <div class="about-image-content" style="position: relative; z-index: 2; padding: 32px;">
                        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); padding: 6px 14px; border-radius: 30px; font-size: 0.75rem; color: rgba(255,255,255,0.8); font-weight: 500; margin-bottom: 20px;">
                            <i class="fas fa-quran"></i> Bismillahir Rahmanir Raheem
                        </div>
                        <h3 style="font-size: 2rem; color: white; margin-bottom: 12px;">Structured<br>Islamic Studies</h3>
                        <p style="color: rgba(255,255,255,0.65); font-size: 0.88rem; line-height: 1.7; max-width: 300px;">From foundational Quran recitation to advanced Tafsir, Hadith, and Fiqh — a complete Islamic curriculum.</p>
                        <div style="margin-top: 28px; display: flex; gap: 20px;">
                            <div>
                                <div style="font-size: 1.6rem; font-weight: 700; color: white; font-family: 'Playfair Display', serif;">P.1–S.6</div>
                                <div style="font-size: 0.72rem; color: rgba(255,255,255,0.5);">All School Levels</div>
                            </div>
                            <div style="width: 1px; background: rgba(255,255,255,0.1);"></div>
                            <div>
                                <div style="font-size: 1.6rem; font-weight: 700; color: white; font-family: 'Playfair Display', serif;">100%</div>
                                <div style="font-size: 0.72rem; color: rgba(255,255,255,0.5);">Online & Mobile</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-floating-badge">
                    <div class="num">1,200+</div>
                    <div class="lbl">Students Enrolled</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════ STATS ════════════════════ -->
<div class="stats-banner">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-num" data-count="5">5</span>
                <div class="stat-lbl">School Levels</div>
                <div class="stat-divider"></div>
            </div>
            <div class="stat-item">
                <span class="stat-num" data-count="20">20+</span>
                <div class="stat-lbl">Classes</div>
                <div class="stat-divider"></div>
            </div>
            <div class="stat-item">
                <span class="stat-num" data-count="60">60+</span>
                <div class="stat-lbl">Subjects</div>
                <div class="stat-divider"></div>
            </div>
            <div class="stat-item">
                <span class="stat-num" data-count="500">500+</span>
                <div class="stat-lbl">Lessons</div>
                <div class="stat-divider"></div>
            </div>
        </div>
    </div>
</div>

<!-- ════════════════════ CURRICULUM ════════════════════ -->
<section class="curriculum-section section" id="curriculum">
    <div class="container">
        <div class="text-center">
            <span class="eyebrow" style="justify-content: center;">Structured Curriculum</span>
            <h2 class="section-heading">Classes, Subjects & Lessons</h2>
            <p class="section-sub">Every lesson comes with content + a quiz. Pass the quiz to complete the lesson and track your progress toward a certificate.</p>
        </div>
        <div class="level-accordion" id="levelsContainer"></div>
    </div>
</section>

<!-- ════════════════════ PROGRESS / FEATURES ════════════════════ -->
<section class="progress-section section" id="features">
    <div class="container">
        <div class="text-center">
            <span class="eyebrow" style="justify-content: center;">Assessment & Recognition</span>
            <h2 class="section-heading">Track Your Progress</h2>
            <p class="section-sub">Complete quizzes after every lesson to test your understanding, earn certificates, and demonstrate mastery.</p>
        </div>
        <div class="progress-cards-grid">
            <div class="progress-card progress-card-1">
                <div class="progress-card-icon"><i class="fas fa-pen-nib"></i></div>
                <h3>Lesson Quizzes</h3>
                <p>Auto-graded quizzes after every lesson. Instant feedback with correct answers shown — so you understand, not just pass. Termly assessments available for all levels.</p>
            </div>
            <div class="progress-card progress-card-2">
                <div class="progress-card-icon"><i class="fas fa-chart-bar"></i></div>
                <h3>Progress Reports</h3>
                <p>Detailed reports for students, parents, and teachers. Track lesson completion rates, quiz scores, attendance, and improvement areas all in one dashboard.</p>
            </div>
            <div class="progress-card progress-card-3">
                <div class="progress-card-icon"><i class="fas fa-award"></i></div>
                <h3>Certifications</h3>
                <p>Earn an official Al-Hilal Online Academy certificate upon completing each level with all quizzes passed. Share your achievement and advance to the next level.</p>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════ TESTIMONIALS ════════════════════ -->
<section class="testimonials-section section" id="testimony">
    <div class="container">
        <div class="text-center">
            <span class="eyebrow" style="justify-content: center;">Student Stories</span>
            <h2 class="section-heading">What Our Community Says</h2>
        </div>
        <div class="swiper testimonialSwiper" style="margin-top: 48px; overflow: hidden; padding-bottom: 40px;">
            <div class="swiper-wrapper">
                <div class="swiper-slide" style="height: auto;">
                    <div class="testimonial-card" style="position: relative;">
                        <div style="position: absolute; top: 18px; right: 24px; font-size: 3rem; line-height: 0; font-family: Georgia, serif; color: var(--purple-light); opacity: 0.5; padding-top: 24px;">"</div>
                        <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testimonial-text">"The quizzes after each lesson truly reinforce what I learn. Seeing my progress chart go up is so motivating — I've never felt this engaged with Islamic studies before."</p>
                        <div class="testimonial-user">
                            <div class="testimonial-avatar" style="background-image: url('https://randomuser.me/api/portraits/women/68.jpg');"></div>
                            <div><div class="testimonial-name">Amina Hussein</div><div class="testimonial-role">S.3 Student</div></div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide" style="height: auto;">
                    <div class="testimonial-card" style="position: relative;">
                        <div style="position: absolute; top: 18px; right: 24px; font-size: 3rem; line-height: 0; font-family: Georgia, serif; color: var(--purple-light); opacity: 0.5; padding-top: 24px;">"</div>
                        <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testimonial-text">"The quiz-before-advancing system ensures students genuinely understand before moving on. As a teacher, the reporting dashboard saves me hours every week."</p>
                        <div class="testimonial-user">
                            <div class="testimonial-avatar" style="background-image: url('https://randomuser.me/api/portraits/men/45.jpg');"></div>
                            <div><div class="testimonial-name">Ustadh Rashid</div><div class="testimonial-role">Level 4 Teacher</div></div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide" style="height: auto;">
                    <div class="testimonial-card" style="position: relative;">
                        <div style="position: absolute; top: 18px; right: 24px; font-size: 3rem; line-height: 0; font-family: Georgia, serif; color: var(--purple-light); opacity: 0.5; padding-top: 24px;">"</div>
                        <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testimonial-text">"Direct WhatsApp access to my teacher when I'm stuck is amazing. And the PDF notes are perfect for offline revision before my S.4 exams."</p>
                        <div class="testimonial-user">
                            <div class="testimonial-avatar" style="background-image: url('https://randomuser.me/api/portraits/men/32.jpg');"></div>
                            <div><div class="testimonial-name">Ibrahim Ssemanda</div><div class="testimonial-role">S.4 Candidate</div></div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide" style="height: auto;">
                    <div class="testimonial-card" style="position: relative;">
                        <div style="position: absolute; top: 18px; right: 24px; font-size: 3rem; line-height: 0; font-family: Georgia, serif; color: var(--purple-light); opacity: 0.5; padding-top: 24px;">"</div>
                        <div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testimonial-text">"My children love the platform. As a parent, I can monitor their lesson completion and quiz scores from my own account. This level of transparency is exactly what I needed."</p>
                        <div class="testimonial-user">
                            <div class="testimonial-avatar" style="background-image: url('https://randomuser.me/api/portraits/women/44.jpg');"></div>
                            <div><div class="testimonial-name">Fatuma Nakato</div><div class="testimonial-role">Parent of Two Students</div></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<!-- Minimal but elegant Back to Top - Add to your CSS section -->
<style>
.back-to-top {
    position: fixed;
    bottom: 80px;
    right: 24px;
    width: 46px;
    height: 46px;
    border-radius: 46px;
    background: #D8382E;
    backdrop-filter: blur(8px);
    color: white;
    border: 1px solid rgba(255,255,255,0.2);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    z-index: 997;
    opacity: 0;
    visibility: hidden;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    background: linear-gradient(135deg, var(--purple) 0%, var(--red) 100%);
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(107, 70, 193, 0.4);
}

@media (max-width: 768px) {
    .back-to-top {
        bottom: 72px;
        right: 16px;
        width: 40px;
        height: 40px;
        font-size: 0.9rem;
    }
}
</style>

<!-- HTML -->
<a href="#" class="back-to-top" id="backToTopBtn">
    <i class="fas fa-chevron-up"></i>
</a>

<!-- JavaScript -->
<script>
const backBtn = document.getElementById('backToTopBtn');
window.addEventListener('scroll', () => {
    backBtn.classList.toggle('show', window.scrollY > 500);
});
backBtn.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>
<!-- ════════════════════ CONTACT ════════════════════ -->
<section class="contact-section section" id="contact">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <span class="eyebrow">Get In Touch</span>
                <h2 class="section-heading">Enroll Your Child<br>Today</h2>
                <p class="section-sub">Questions about enrollment, tuition, or the curriculum? Reach out and our team will respond within 24 hours.</p>
                <div style="margin-top: 36px;">
                    <div class="contact-detail-row">
                        <div class="contact-detail-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <div class="contact-detail-label">Phone / WhatsApp</div>
                            <div class="contact-detail-value">+256 702 082 209</div>
                        </div>
                    </div>
                    <div class="contact-detail-row">
                        <div class="contact-detail-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <div class="contact-detail-label">Email</div>
                            <div class="contact-detail-value">info@alhilalacademy.org</div>
                        </div>
                    </div>
                    <div class="contact-detail-row">
                        <div class="contact-detail-icon"><i class="fab fa-whatsapp"></i></div>
                        <div>
                            <div class="contact-detail-label">Live Chat</div>
                            <div class="contact-detail-value">WhatsApp us anytime</div>
                        </div>
                    </div>
                </div>
                <a href="https://wa.me/256702082209?text=Assalamu+Alaikum!+I'd+like+to+enroll+at+AlHilal+Academy." target="_blank" class="btn btn-primary" style="margin-top: 12px;">
                    <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                </a>
            </div>
            <div class="contact-form-card">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px; color: var(--ink);">Send Us a Message</h3>
                <form id="contactForm">
                    @csrf
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" id="fullname" class="form-control-alhilal" placeholder="Your full name">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="emailContact" class="form-control-alhilal" placeholder="your@email.com">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" class="form-control-alhilal" placeholder="+256 ...">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control-alhilal" placeholder="Tell us about your child's level and questions..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════ FOOTER ════════════════════ -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="footer-logo-row">
                    <img src="{{ asset('assets/images/alhilal_logo.jpeg') }}" alt="Al-Hilal Online Academy" class="footer-logo-img">
                    <div class="footer-logo-name">Al-Hilal Online Academy</div>
                </div>
                <p>Delivering structured Islamic education from P.1 to S.6 — with video, audio, PDF, quizzes, and certification. Learning made accessible for every Muslim student.</p>
                <div class="footer-social">
                    <a href="#" class="footer-social-btn"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="footer-social-btn"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="footer-social-btn"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="footer-social-btn"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h5>Platform</h5>
                <ul>
                    <li><a href="#curriculum">Curriculum</a></li>
                    <li><a href="#features">Track Progress</a></li>
                    <li><a href="#testimony">Testimonials</a></li>
                    <li><a href="{{ url('/users/login') }}">Student Portal</a></li>
                    <li><a href="{{ url('/users/register') }}">Register</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h5>Support</h5>
                <ul>
                    <li><a href="#contact">Contact Us</a></li>
                    <li><a href="https://wa.me/256702082209" target="_blank">WhatsApp Chat</a></li>
                    <li><a href="mailto:info@alhilalacademy.org">Email Us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© {{ date('Y') }} Al-Hilal Online Academy. All rights reserved.</p>
            <p>Made with <i class="fas fa-heart" style="color: var(--red);"></i> for Islamic Education</p>
        </div>
    </div>
</footer>

<!-- ════════════════════ BOTTOM NAV ════════════════════ -->
<nav class="bottom-nav">
    <a href="#home" class="nav-item active"><i class="fas fa-home"></i><span>Home</span></a>
    <a href="#curriculum" class="nav-item"><i class="fas fa-layer-group"></i><span>Lessons</span></a>
    <a href="#features" class="nav-item"><i class="fas fa-chart-line"></i><span>Reports</span></a>
    <a href="#contact" class="nav-item"><i class="fas fa-award"></i><span>Certificates</span></a>
    <a href="#" class="nav-item nav-whatsapp" id="whatsappChat"><i class="fab fa-whatsapp"></i><span>Chat</span></a>
</nav>

<!-- ════════════════════ MODALS ════════════════════ -->
<div id="lessonModal" class="modal-backdrop">
    <div class="modal-box">
        <button class="modal-close" onclick="document.getElementById('lessonModal').classList.remove('open')"><i class="fas fa-times"></i></button>
        <div class="modal-icon"><i class="fas fa-play-circle"></i></div>
        <div class="modal-title" id="modalLessonTitle">Lesson Title</div>
        <div class="modal-desc" id="modalLessonDescription">Click play to start this lesson.</div>
        <button class="btn btn-primary" style="width: 100%; justify-content: center;" onclick="document.getElementById('lessonModal').classList.remove('open')">
            <i class="fas fa-times"></i> Close
        </button>
    </div>
</div>

<div id="quizModal" class="modal-backdrop">
    <div class="modal-box">
        <button class="modal-close" id="closeQuizBtn"><i class="fas fa-times"></i></button>
        <div class="modal-icon" style="color: var(--red);"><i class="fas fa-question-circle"></i></div>
        <div class="modal-title" id="quizTitle">Lesson Quiz</div>
        <div id="quizQuestions"></div>
        <button class="btn btn-red" id="submitQuizBtn" style="width: 100%; justify-content: center; margin-top: 16px;">
            <i class="fas fa-check"></i> Submit Quiz
        </button>
        <div id="quizResult" class="quiz-result-box"></div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ── Data ──────────────────────────────────────────────────
const levelsData = [
    { name: 'Lower Primary', range: 'P.1 – P.3', classes: ['P.1','P.2','P.3'], subjectsPerClass: 4, icon: '<i class="fa-solid fa-seedling"></i>' },
    { name: 'Upper Primary', range: 'P.4 – P.7', classes: ['P.4','P.5','P.6','P.7'], subjectsPerClass: 5, icon: '<i class="fa-solid fa-book"></i>' },
    { name: 'Lower Secondary', range: 'S.1 – S.2', classes: ['S.1','S.2'], subjectsPerClass: 8, icon: '<i class="fa-solid fa-graduation-cap"></i>' },
    { name: 'Middle Secondary', range: 'S.3 – S.4', classes: ['S.3','S.4'], subjectsPerClass: 10, icon: '<i class="fa-solid fa-bolt"></i>' },
    { name: 'Advanced Secondary', range: 'S.5 – S.6', classes: ['S.5','S.6'], subjectsPerClass: 12, icon: '<i class="fa-solid fa-trophy"></i>' }
];
const subjectNames = {
    primary: ['Quran Recitation','Islamic Studies','Arabic Language','Du\'a & Adab','Seerah','Taharah & Salah'],
    secondary: ['Quran & Tafsir','Hadith Studies','Fiqh (Islamic Law)','Arabic Literature','Seerah & History','Islamic Aqeedah','Du\'a & Azkar','Islamic Economics','Usul al-Fiqh','Comparative Religion','Tajweed Advanced','Islamic Ethics']
};

let quizPassedLessons = JSON.parse(localStorage.getItem('alhilal_quizPassed') || '{}');
function markQuizPassed(id) { quizPassedLessons[id] = true; localStorage.setItem('alhilal_quizPassed', JSON.stringify(quizPassedLessons)); }
function isQuizPassed(id) { return !!quizPassedLessons[id]; }

function generateLessons(subj, cls) {
    const types = ['video','audio','pdf'];
    return [
        { id: `${cls}-${subj}-1`, title: `Introduction to ${subj}`, type: types[0] },
        { id: `${cls}-${subj}-2`, title: `Core Concepts: ${subj}`, type: types[1] },
        { id: `${cls}-${subj}-3`, title: `${subj} — Advanced Review`, type: types[2] }
    ];
}

function generateQuiz(title) {
    return [
        { q: `What is the central topic of "${title}"?`, opts: ['Islamic Knowledge','World History','Mathematics','Natural Sciences'], correct: 0 },
        { q: 'What is the best approach to understanding Islamic lessons?', opts: ['Memorisation only','Understanding context','Speed reading','Skipping difficult parts'], correct: 1 },
        { q: 'How does this topic connect to the Quran and Sunnah?', opts: ['Directly','Only culturally','Not at all','Only historically'], correct: 0 },
        { q: 'What is the best way to apply this knowledge?', opts: ['Share with others','Practice regularly','Reflect and implement','All of the above'], correct: 3 },
        { q: 'Which scholarly tradition is most relevant here?', opts: ['Imam Bukhari','Imam Abu Hanifa','Imam Ghazali','Depends on context'], correct: 3 }
    ];
}

// ── Render Curriculum ─────────────────────────────────────
function renderCurriculum() {
    const container = document.getElementById('levelsContainer');
    container.innerHTML = '';
    levelsData.forEach((level, li) => {
        const card = document.createElement('div');
        card.className = 'level-card';
        card.innerHTML = `
            <button class="level-header-btn" id="lvl-btn-${li}">
                <div class="level-header-left">
                    <div class="level-number">${level.icon}</div>
                    <div>
                        <div class="level-title">${level.name}</div>
                        <div class="level-meta">${level.range} &nbsp;·&nbsp; ${level.classes.length} Classes</div>
                    </div>
                </div>
                <div class="level-toggle"><i class="fas fa-chevron-down"></i></div>
            </button>
            <div class="level-body" id="lvl-body-${li}">
                <div class="class-tabs-row" id="tabs-${li}">
                    ${level.classes.map(cls => `<button class="class-tab-btn" data-cls="${cls}">${cls}</button>`).join('')}
                </div>
                <div id="subjects-${li}"></div>
            </div>`;
        container.appendChild(card);

        const btn = card.querySelector(`#lvl-btn-${li}`);
        const body = card.querySelector(`#lvl-body-${li}`);
        btn.addEventListener('click', (e) => {
            if (e.target.closest('.class-tab-btn')) return;
            const open = body.classList.contains('open');
            body.classList.toggle('open', !open);
            btn.classList.toggle('active', !open);
        });

        const tabs = card.querySelectorAll('.class-tab-btn');
        tabs.forEach(t => t.addEventListener('click', () => {
            tabs.forEach(x => x.classList.remove('active'));
            t.classList.add('active');
            renderSubjects(li, t.dataset.cls, level, card);
        }));
        tabs[0]?.classList.add('active');
        renderSubjects(li, level.classes[0], level, card);
    });
}

function renderSubjects(li, cls, level, card) {
    const isSecondary = li >= 2;
    const list = isSecondary ? subjectNames.secondary : subjectNames.primary;
    const sel = list.slice(0, level.subjectsPerClass);
    const container = card.querySelector(`#subjects-${li}`);
    const typeLabels = { video: 'VIDEO', audio: 'AUDIO', pdf: 'PDF' };
    const typeIcons = { video: 'fas fa-video', audio: 'fas fa-headphones', pdf: 'fas fa-file-pdf' };
    const badgeClass = { video: 'badge-video', audio: 'badge-audio', pdf: 'badge-pdf' };
    let html = '<div class="subjects-grid">';
    sel.forEach(subj => {
        const lessons = generateLessons(subj, cls);
        let lhtml = '<div class="lesson-list">';
        lessons.forEach(l => {
            const passed = isQuizPassed(l.id);
            lhtml += `
                <div class="lesson-row">
                    <div class="lesson-info">
                        <span class="lesson-type-badge ${badgeClass[l.type]}"><i class="${typeIcons[l.type]}"></i> ${typeLabels[l.type]}</span>
                        <span class="lesson-title-text" title="${l.title}">${l.title}</span>
                    </div>
                    <div class="lesson-actions">
                        <button class="btn-view-lesson" data-lesson='${JSON.stringify(l)}'>View</button>
                        ${passed
                            ? '<span class="quiz-passed-badge"><i class="fas fa-check-circle"></i> Passed</span>'
                            : `<button class="btn-quiz-lesson" data-lesson='${JSON.stringify(l)}'>Quiz</button>`
                        }
                    </div>
                </div>`;
        });
        lhtml += '</div>';
        html += `
            <div class="subject-card">
                <div class="subject-card-head">
                    <div class="subject-icon"><i class="fas fa-star-of-life"></i></div>
                    <div class="subject-title">${subj}</div>
                </div>
                ${lhtml}
            </div>`;
    });
    html += '</div>';
    container.innerHTML = html;

    container.querySelectorAll('.btn-view-lesson').forEach(b => b.addEventListener('click', e => {
        e.stopPropagation();
        openLesson(JSON.parse(b.dataset.lesson));
    }));
    container.querySelectorAll('.btn-quiz-lesson').forEach(b => b.addEventListener('click', e => {
        e.stopPropagation();
        openQuiz(JSON.parse(b.dataset.lesson));
    }));
}

// ── Modals ────────────────────────────────────────────────
function openLesson(l) {
    document.getElementById('modalLessonTitle').textContent = l.title;
    document.getElementById('modalLessonDescription').textContent = `This is a ${l.type} lesson. Click play in the student portal to begin.`;
    document.getElementById('lessonModal').classList.add('open');
}

let activeQuizLesson = null;
function openQuiz(l) {
    activeQuizLesson = l;
    document.getElementById('quizTitle').textContent = `Quiz: ${l.title}`;
    const quizData = generateQuiz(l.title);
    window._currentQuiz = quizData;
    let html = '';
    quizData.forEach((q, i) => {
        html += `<div class="quiz-question-block"><p>${i+1}. ${q.q}</p>`;
        q.opts.forEach((opt, oi) => {
            html += `<label class="quiz-option-label"><input type="radio" name="q${i}" value="${oi}"> ${opt}</label>`;
        });
        html += '</div>';
    });
    document.getElementById('quizQuestions').innerHTML = html;
    document.getElementById('quizResult').style.display = 'none';
    document.getElementById('quizResult').className = 'quiz-result-box';
    document.getElementById('quizModal').classList.add('open');
}

document.getElementById('submitQuizBtn').addEventListener('click', () => {
    const qd = window._currentQuiz;
    let correct = 0;
    qd.forEach((q, i) => {
        const sel = document.querySelector(`input[name="q${i}"]:checked`);
        if (sel && parseInt(sel.value) === q.correct) correct++;
    });
    const pct = Math.round((correct / qd.length) * 100);
    const passed = pct >= 60;
    const rb = document.getElementById('quizResult');
    rb.style.display = 'block';
    rb.className = `quiz-result-box ${passed ? 'quiz-result-pass' : 'quiz-result-fail'}`;
    rb.innerHTML = passed
        ? `<i class="fas fa-check-circle"></i> Passed! You scored ${pct}% (${correct}/${qd.length})`
        : `<i class="fas fa-times-circle"></i> ${pct}% — You need 60% to pass. Try again!`;
    if (passed && activeQuizLesson) {
        markQuizPassed(activeQuizLesson.id);
        renderCurriculum();
    }
});
document.getElementById('closeQuizBtn').addEventListener('click', () => document.getElementById('quizModal').classList.remove('open'));

window.addEventListener('click', e => {
    if (e.target === document.getElementById('lessonModal')) document.getElementById('lessonModal').classList.remove('open');
    if (e.target === document.getElementById('quizModal')) document.getElementById('quizModal').classList.remove('open');
});

// ── Header scroll ─────────────────────────────────────────
window.addEventListener('scroll', () => {
    document.getElementById('siteHeader').classList.toggle('scrolled', window.scrollY > 40);
});

// ── Bottom nav active ─────────────────────────────────────
const sections = document.querySelectorAll('section[id], .hero[id]');
const navItems = document.querySelectorAll('.nav-item:not(.nav-whatsapp)');
function updateNav() {
    let sp = window.scrollY + 100;
    sections.forEach(s => {
        if (sp >= s.offsetTop && sp < s.offsetTop + s.offsetHeight) {
            const id = s.id;
            navItems.forEach(n => { n.classList.remove('active'); if (n.getAttribute('href') === `#${id}`) n.classList.add('active'); });
        }
    });
}
window.addEventListener('scroll', updateNav);

// ── Smooth scroll ─────────────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const t = document.querySelector(a.getAttribute('href'));
        if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
});

// ── WhatsApp ──────────────────────────────────────────────
document.getElementById('whatsappChat').addEventListener('click', e => {
    e.preventDefault();
    window.open('https://wa.me/256702082209?text=' + encodeURIComponent('Assalamu Alaikum! I need assistance with my lessons on Al-Hilal Online Academy.'), '_blank');
});

// ── Contact form ──────────────────────────────────────────
$('#contactForm').on('submit', function(e) {
    e.preventDefault();
    const name = $('#fullname').val().trim(), email = $('#emailContact').val().trim();
    if (!name || !email) { Swal.fire('Incomplete', 'Please fill in your name and email.', 'warning'); return; }
    Swal.fire({ title: 'Message Sent!', html: `Thank you <strong>${name}</strong>! Our team will contact you soon regarding enrollment.`, icon: 'success', confirmButtonColor: '#6B46C1' });
    this.reset();
});

// ── Swiper ────────────────────────────────────────────────
new Swiper('.testimonialSwiper', {
    loop: true, slidesPerView: 1, spaceBetween: 24,
    pagination: { el: '.swiper-pagination', clickable: true },
    autoplay: { delay: 5000 },
    breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
});

// ── Init ──────────────────────────────────────────────────
renderCurriculum();
</script>
@endsection