@extends('layouts.master2')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,700&family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ╔══════════════════════════════════════════════════════════════╗
   ║  ALHILAL ACADEMY — ADMIN COMMAND CENTRE                     ║
   ║  Design: Luxury Editorial × Data-Dense Command Interface    ║
   ╚══════════════════════════════════════════════════════════════╝ */

:root {
    /* Brand palette — inherited from homepage */
    --purple:        #6B46C1;
    --purple-dark:   #4C2E8A;
    --purple-mid:    #7C3AED;
    --purple-light:  #EDE9FA;
    --purple-xlight: #F5F3FF;
    --red:           #DC2626;
    --red-light:     #FEE2E2;
    --red-dark:      #9B1C1C;
    --gold:          #D97706;
    --gold-light:    #FEF3C7;
    --gold-dark:     #92400E;
    --green:         #16A34A;
    --green-light:   #DCFCE7;
    --blue:          #2563EB;
    --blue-light:    #DBEAFE;
    --cyan:          #0891B2;
    --cyan-light:    #CFFAFE;
    --cream:         #FDFBF7;
    --cream2:        #F7F3EE;
    --cream3:        #F0EBE3;
    --ink:           #1A0A2E;
    --ink2:          #3B2459;
    --ink3:          #2D1854;
    --muted:         #6B6584;
    --muted2:        #9490A8;
    --border:        rgba(107,70,193,0.10);
    --border2:       rgba(107,70,193,0.20);
    --border3:       rgba(107,70,193,0.30);
    --gradient:      linear-gradient(135deg, var(--purple) 0%, var(--red) 100%);
    --gradient-gold: linear-gradient(135deg, var(--gold) 0%, var(--red) 100%);
    --gradient-cool: linear-gradient(135deg, var(--blue) 0%, var(--purple) 100%);
    --gradient-soft: linear-gradient(135deg, #EDE9FA 0%, #FEE2E2 100%);
    --gradient-dark: linear-gradient(135deg, #1A0A2E 0%, #2D0F5C 50%, #4A1A1A 100%);
    --shadow-xs:     0 1px 4px rgba(107,70,193,0.06);
    --shadow-sm:     0 2px 12px rgba(107,70,193,0.08);
    --shadow-md:     0 8px 32px rgba(107,70,193,0.12);
    --shadow-lg:     0 20px 60px rgba(107,70,193,0.16);
    --shadow-xl:     0 32px 80px rgba(107,70,193,0.22);
    --shadow-ink:    0 20px 60px rgba(26,10,46,0.3);
    --sidebar-w:     280px;
    --topbar-h:      70px;
    --radius-sm:     10px;
    --radius-md:     16px;
    --radius-lg:     22px;
    --radius-xl:     28px;
    --transition:    all 0.25s cubic-bezier(0.4,0,0.2,1);
}

*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream2);
    color: var(--ink);
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
}

::-webkit-scrollbar { width: 4px; height: 4px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--purple); border-radius: 10px; }

/* ── TYPOGRAPHY ── */
h1,h2,h3,h4,h5 { font-family: 'Playfair Display', serif; line-height: 1.15; }
.mono { font-family: 'DM Mono', monospace; }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   LAYOUT SHELL
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.admin-shell { display: flex; min-height: 100vh; }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   SIDEBAR — Deep ink with luxury refinement
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.sidebar {
    width: var(--sidebar-w);
    background: #0F0720;
    position: fixed;
    top: 0; left: 0; bottom: 0;
    z-index: 200;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    overflow-x: hidden;
    transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
    border-right: 1px solid rgba(107,70,193,0.15);
}

/* Animated mesh background */
.sidebar-mesh {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}
.mesh-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
}
.mesh-orb-1 {
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(107,70,193,0.22) 0%, transparent 70%);
    top: -60px; right: -80px;
    animation: orb-drift-1 8s ease-in-out infinite;
}
.mesh-orb-2 {
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(220,38,38,0.14) 0%, transparent 70%);
    bottom: 120px; left: -80px;
    animation: orb-drift-2 10s ease-in-out infinite;
}
.mesh-orb-3 {
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(217,119,6,0.1) 0%, transparent 70%);
    top: 50%; right: -40px;
    animation: orb-drift-1 12s ease-in-out infinite reverse;
}
@keyframes orb-drift-1 {
    0%,100% { transform: translate(0, 0) scale(1); }
    50%      { transform: translate(-20px, 20px) scale(1.1); }
}
@keyframes orb-drift-2 {
    0%,100% { transform: translate(0, 0) scale(1); }
    50%      { transform: translate(20px, -20px) scale(1.08); }
}

/* Sidebar brand */
.sidebar-brand {
    padding: 22px 22px 18px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    position: relative; z-index: 2;
    display: flex; align-items: center; gap: 13px;
    text-decoration: none;
}
.brand-logomark {
    width: 46px; height: 46px;
    border-radius: 15px;
    background: var(--gradient);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; color: white;
    box-shadow: 0 8px 24px rgba(107,70,193,0.5);
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
}
.brand-logomark::after {
    content: '';
    position: absolute;
    top: -50%; left: -50%;
    width: 200%; height: 200%;
    background: conic-gradient(transparent 30%, rgba(255,255,255,0.12) 50%, transparent 70%);
    animation: shine-spin 4s linear infinite;
}
@keyframes shine-spin { to { transform: rotate(360deg); } }
.brand-text-wrap { flex: 1; overflow: hidden; }
.brand-name {
    font-family: 'Playfair Display', serif;
    font-size: 0.98rem;
    font-weight: 700;
    color: white;
    line-height: 1.2;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.brand-tagline { font-size: 0.63rem; color: rgba(255,255,255,0.35); letter-spacing: 1px; margin-top: 2px; }
.brand-version {
    font-size: 0.58rem;
    font-family: 'DM Mono', monospace;
    background: rgba(107,70,193,0.3);
    color: #C084FC;
    padding: 2px 7px; border-radius: 20px;
    border: 1px solid rgba(107,70,193,0.3);
}

/* Admin identity card */
.sidebar-admin-card {
    margin: 16px 14px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: var(--radius-md);
    padding: 14px 16px;
    display: flex; align-items: center; gap: 12px;
    position: relative; z-index: 2;
    cursor: pointer;
    transition: var(--transition);
}
.sidebar-admin-card:hover { background: rgba(255,255,255,0.07); }
.admin-ava {
    width: 40px; height: 40px;
    border-radius: 12px;
    background: var(--gradient);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 0.95rem;
    flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(107,70,193,0.4);
    border: 2px solid rgba(255,255,255,0.15);
}
.admin-ava-info { flex: 1; overflow: hidden; }
.admin-name {
    font-size: 0.84rem; font-weight: 600; color: white;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    line-height: 1.3;
}
.admin-role {
    font-size: 0.65rem; color: rgba(255,255,255,0.4);
    margin-top: 1px; letter-spacing: 0.5px;
}
.admin-status-dot {
    width: 8px; height: 8px;
    border-radius: 50%; background: #4ade80;
    box-shadow: 0 0 10px rgba(74,222,128,0.7);
    flex-shrink: 0;
    animation: pulse-green 2s ease-in-out infinite;
}
@keyframes pulse-green {
    0%,100% { transform: scale(1); opacity: 1; }
    50%      { transform: scale(1.4); opacity: 0.7; }
}

/* System health indicator strip */
.sys-health-strip {
    margin: 0 14px 4px;
    padding: 10px 14px;
    background: rgba(74,222,128,0.07);
    border: 1px solid rgba(74,222,128,0.15);
    border-radius: var(--radius-sm);
    display: flex; align-items: center; gap: 10px;
    position: relative; z-index: 2;
}
.health-dot { width: 6px; height: 6px; border-radius: 50%; background: #4ade80; flex-shrink: 0; }
.health-text { font-size: 0.68rem; color: rgba(255,255,255,0.45); flex: 1; }
.health-text strong { color: #86efac; font-weight: 600; }
.health-mini-bars { display: flex; gap: 3px; align-items: flex-end; }
.health-bar {
    width: 3px; background: rgba(74,222,128,0.4); border-radius: 2px;
    animation: bar-bounce 1.2s ease-in-out infinite;
}
.health-bar:nth-child(1) { height: 8px; animation-delay: 0s; }
.health-bar:nth-child(2) { height: 14px; animation-delay: 0.2s; }
.health-bar:nth-child(3) { height: 10px; animation-delay: 0.4s; }
.health-bar:nth-child(4) { height: 16px; animation-delay: 0.1s; }
.health-bar:nth-child(5) { height: 6px; animation-delay: 0.3s; }
@keyframes bar-bounce {
    0%,100% { opacity: 0.4; transform: scaleY(0.8); }
    50%      { opacity: 1; transform: scaleY(1.2); }
}

/* Nav section labels */
.nav-section-label {
    padding: 18px 22px 7px;
    font-size: 0.59rem;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.2);
    font-weight: 700;
    position: relative; z-index: 2;
    display: flex; align-items: center; gap: 8px;
}
.nav-section-label::after {
    content: '';
    flex: 1; height: 1px;
    background: rgba(255,255,255,0.06);
}

/* Nav links */
.nav-item {
    display: flex; align-items: center; gap: 11px;
    padding: 10px 14px 10px 22px;
    color: rgba(255,255,255,0.45);
    text-decoration: none;
    font-size: 0.845rem; font-weight: 500;
    border-radius: 0;
    transition: var(--transition);
    position: relative; z-index: 2;
    margin: 1px 0;
    letter-spacing: 0.1px;
}
.nav-item:hover {
    color: rgba(255,255,255,0.88);
    background: rgba(255,255,255,0.05);
    padding-left: 26px;
}
.nav-item.active {
    color: white;
    background: rgba(107,70,193,0.28);
    border-left: 3px solid var(--purple-mid);
    padding-left: 19px;
}
.nav-item.active .nav-ico { color: #C084FC; }
.nav-ico {
    width: 18px; text-align: center;
    font-size: 0.88rem; flex-shrink: 0;
    transition: color 0.2s;
}
.nav-badge {
    margin-left: auto;
    font-size: 0.6rem; font-weight: 700;
    padding: 2px 7px; border-radius: 20px;
    min-width: 20px; text-align: center;
    letter-spacing: 0.3px;
}
.nb-red    { background: rgba(220,38,38,0.25);  color: #FCA5A5; border: 1px solid rgba(220,38,38,0.3); }
.nb-gold   { background: rgba(217,119,6,0.25);  color: #FCD34D; border: 1px solid rgba(217,119,6,0.3); }
.nb-purple { background: rgba(107,70,193,0.3);  color: #C084FC; border: 1px solid rgba(107,70,193,0.4); }
.nb-green  { background: rgba(22,163,74,0.25);  color: #86efac; border: 1px solid rgba(22,163,74,0.3); }
.nav-new {
    margin-left: auto;
    font-size: 0.55rem; font-weight: 700;
    padding: 1px 6px; border-radius: 20px;
    background: var(--gradient);
    color: white; letter-spacing: 1px;
    text-transform: uppercase;
}

/* Sidebar footer */
.sidebar-footer {
    margin-top: auto;
    padding: 14px;
    border-top: 1px solid rgba(255,255,255,0.06);
    position: relative; z-index: 2;
    display: flex; flex-direction: column; gap: 2px;
}
.sidebar-foot-btn {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 14px;
    border-radius: var(--radius-sm);
    color: rgba(255,255,255,0.38);
    text-decoration: none; font-size: 0.8rem; font-weight: 500;
    transition: var(--transition);
    cursor: pointer; border: none; background: none;
    font-family: 'DM Sans', sans-serif; width: 100%; text-align: left;
}
.sidebar-foot-btn:hover { background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.7); }
.sidebar-foot-btn.danger:hover { background: rgba(220,38,38,0.12); color: #FCA5A5; }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   MAIN CONTENT
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.main-wrap {
    margin-left: var(--sidebar-w);
    flex: 1; display: flex; flex-direction: column; min-height: 100vh;
}

/* ── TOP BAR ── */
.topbar {
    height: var(--topbar-h);
    background: rgba(253,251,247,0.95);
    backdrop-filter: blur(20px) saturate(1.4);
    border-bottom: 1px solid var(--border2);
    position: sticky; top: 0; z-index: 100;
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 32px;
    transition: box-shadow 0.3s;
}
.topbar.scrolled { box-shadow: var(--shadow-md); }

.topbar-left { display: flex; align-items: center; gap: 18px; }
.topbar-hamburger {
    display: none; width: 38px; height: 38px;
    border-radius: 10px; background: var(--cream2);
    border: 1px solid var(--border2); color: var(--ink);
    align-items: center; justify-content: center;
    font-size: 0.95rem; cursor: pointer;
}
.topbar-page {
    display: flex; flex-direction: column;
}
.topbar-page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem; font-weight: 700; color: var(--ink); line-height: 1.2;
}
.topbar-crumb {
    font-size: 0.72rem; color: var(--muted);
    display: flex; align-items: center; gap: 4px;
}
.topbar-crumb i { font-size: 0.55rem; }
.topbar-crumb .crumb-active { color: var(--purple); font-weight: 500; }

.topbar-right { display: flex; align-items: center; gap: 10px; }

.topbar-search {
    display: flex; align-items: center; gap: 8px;
    background: white; border: 1.5px solid var(--border2);
    border-radius: 40px; padding: 8px 18px;
    width: 260px; transition: var(--transition);
}
.topbar-search:focus-within {
    border-color: var(--purple);
    box-shadow: 0 0 0 3px rgba(107,70,193,0.1);
}
.topbar-search i { color: var(--muted); font-size: 0.8rem; flex-shrink: 0; }
.topbar-search input {
    border: none; background: none; outline: none;
    font-family: 'DM Sans', sans-serif; font-size: 0.82rem;
    color: var(--ink); width: 100%;
}
.topbar-search input::placeholder { color: var(--muted2); }

.tb-icon-btn {
    width: 40px; height: 40px;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    background: white; border: 1.5px solid var(--border2);
    color: var(--muted); cursor: pointer; font-size: 0.92rem;
    transition: var(--transition); position: relative;
    text-decoration: none;
}
.tb-icon-btn:hover { background: var(--purple-xlight); color: var(--purple); border-color: var(--border3); }
.tb-badge {
    position: absolute; top: 4px; right: 4px;
    width: 9px; height: 9px;
    border-radius: 50%; border: 2px solid white;
}
.tb-badge-red  { background: var(--red); }
.tb-badge-gold { background: var(--gold); }

.tb-date-chip {
    display: flex; align-items: center; gap: 7px;
    background: white; border: 1.5px solid var(--border2);
    border-radius: 40px; padding: 7px 14px;
    font-size: 0.78rem; color: var(--ink); font-weight: 500;
    white-space: nowrap;
}
.tb-date-chip i { color: var(--purple); }

.tb-avatar {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: var(--gradient);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 0.88rem;
    cursor: pointer;
    border: 2.5px solid var(--purple-light);
    box-shadow: 0 4px 14px rgba(107,70,193,0.3);
    transition: var(--transition);
}
.tb-avatar:hover { transform: scale(1.06); box-shadow: var(--shadow-md); }

/* ── Floating dropdowns ── */
.floating-drop {
    position: fixed;
    background: white;
    border: 1.5px solid var(--border2);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
    z-index: 500;
    display: none;
    overflow: hidden;
    animation: drop-in 0.22s cubic-bezier(0.34,1.56,0.64,1);
}
.floating-drop.open { display: block; }
@keyframes drop-in {
    from { opacity: 0; transform: scale(0.94) translateY(-8px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}

/* Notification drop */
#notifDrop { width: 380px; top: calc(var(--topbar-h) + 8px); right: 120px; }
.drop-header {
    padding: 18px 22px 14px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
}
.drop-title { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 700; color: var(--ink); }
.drop-action { font-size: 0.72rem; font-weight: 600; color: var(--purple); cursor: pointer; }
.notif-tabs {
    display: flex; gap: 0;
    border-bottom: 1px solid var(--border);
}
.notif-tab {
    flex: 1; padding: 10px; text-align: center;
    font-size: 0.76rem; font-weight: 600; color: var(--muted);
    cursor: pointer; border-bottom: 2px solid transparent;
    transition: var(--transition);
}
.notif-tab.active { color: var(--purple); border-color: var(--purple); }
.notif-list { max-height: 340px; overflow-y: auto; }
.notif-row {
    display: flex; gap: 12px; align-items: flex-start;
    padding: 14px 22px;
    border-bottom: 1px solid var(--border);
    transition: background 0.15s; cursor: pointer;
}
.notif-row:last-child { border-bottom: none; }
.notif-row:hover { background: var(--cream2); }
.notif-row.unread { background: var(--purple-xlight); }
.notif-row.unread:hover { background: #EAE4F8; }
.notif-ico {
    width: 38px; height: 38px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem; flex-shrink: 0;
}
.ni-p { background: var(--purple-light); color: var(--purple); }
.ni-r { background: var(--red-light);    color: var(--red);    }
.ni-g { background: var(--gold-light);   color: var(--gold);   }
.ni-gr{ background: var(--green-light);  color: var(--green);  }
.notif-body { flex: 1; }
.notif-msg { font-size: 0.82rem; color: var(--ink); line-height: 1.45; }
.notif-msg strong { color: var(--ink); font-weight: 600; }
.notif-ts { font-size: 0.68rem; color: var(--muted); margin-top: 3px; }
.notif-unread-dot {
    width: 7px; height: 7px;
    border-radius: 50%; background: var(--purple);
    flex-shrink: 0; margin-top: 6px;
}
.drop-footer { padding: 12px 22px; border-top: 1px solid var(--border); text-align: center; }
.drop-footer a { font-size: 0.78rem; font-weight: 600; color: var(--purple); text-decoration: none; }

/* Profile drop */
#profileDrop { width: 240px; top: calc(var(--topbar-h) + 8px); right: 32px; }
.profile-drop-head {
    padding: 22px;
    background: var(--gradient-dark);
    text-align: center; position: relative; overflow: hidden;
}
.profile-drop-head::before {
    content: '';
    position: absolute;
    width: 150px; height: 150px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(107,70,193,0.3) 0%, transparent 70%);
    top: -40px; right: -40px;
}
.pdh-ava {
    width: 54px; height: 54px;
    border-radius: 16px;
    background: var(--gradient);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 1.3rem;
    margin: 0 auto 10px;
    border: 2.5px solid rgba(255,255,255,0.25);
    box-shadow: 0 8px 24px rgba(107,70,193,0.4);
    position: relative; z-index: 2;
}
.pdh-name { font-size: 0.92rem; font-weight: 700; color: white; position: relative; z-index: 2; }
.pdh-role {
    font-size: 0.68rem; color: rgba(255,255,255,0.55);
    margin-top: 3px; position: relative; z-index: 2;
}
.pdh-badge {
    display: inline-flex; align-items: center; gap: 4px;
    background: rgba(74,222,128,0.2);
    border: 1px solid rgba(74,222,128,0.3);
    color: #86efac; font-size: 0.62rem; font-weight: 600;
    padding: 2px 9px; border-radius: 20px; margin-top: 6px;
    position: relative; z-index: 2;
}
.pdh-badge i { font-size: 0.55rem; }
.pdh-item {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 18px;
    font-size: 0.83rem; color: var(--ink); font-weight: 500;
    text-decoration: none; transition: background 0.15s;
    border-bottom: 1px solid var(--border);
    cursor: pointer; border: none; width: 100%;
    background: none; font-family: 'DM Sans', sans-serif; text-align: left;
}
.pdh-item:hover { background: var(--cream2); }
.pdh-item i { width: 16px; color: var(--purple); font-size: 0.85rem; }
.pdh-item.danger { color: var(--red); }
.pdh-item.danger i { color: var(--red); }
.pdh-divider { height: 1px; background: var(--border); margin: 4px 0; }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   PAGE BODY
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.page-body { flex: 1; padding: 28px 30px 40px; display: flex; flex-direction: column; gap: 24px; }

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

/* Diagonal watermark number */
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
.grid-3-panel { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }

/* ── BASE CARD ── */
.card {
    background: white;
    border-radius: var(--radius-lg);
    border: 1.5px solid var(--border);
    overflow: hidden;
    transition: var(--transition);
}
.card-head {
    padding: 20px 24px 16px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: flex-start; justify-content: space-between;
}
.card-head-left {}
.card-head-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.02rem; font-weight: 700; color: var(--ink);
}
.card-head-sub { font-size: 0.74rem; color: var(--muted); margin-top: 2px; }
.card-head-right { display: flex; gap: 8px; align-items: center; }
.card-body { padding: 22px 24px; }
.card-body-0 { padding: 0 24px 20px; }
.card-link {
    font-size: 0.76rem; font-weight: 600; color: var(--purple);
    text-decoration: none; display: flex; align-items: center; gap: 4px;
    transition: gap 0.2s;
}
.card-link:hover { gap: 7px; color: var(--purple-dark); }

/* Pill filter buttons */
.pill-filters { display: flex; gap: 6px; }
.pill {
    padding: 5px 12px; border-radius: 20px;
    font-size: 0.72rem; font-weight: 600;
    cursor: pointer; border: 1.5px solid var(--border2);
    background: transparent; color: var(--muted);
    transition: var(--transition); font-family: 'DM Sans', sans-serif;
}
.pill.active, .pill:hover { background: var(--purple); border-color: var(--purple); color: white; }

/* Chart wrapper */
.chart-box { position: relative; }

/* ── REVENUE / ENROLLMENT AREA CHART ── */
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

/* Status badges */
.badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 20px;
    font-size: 0.7rem; font-weight: 600; white-space: nowrap;
}
.badge i { font-size: 5px; }
.badge-active   { background: var(--green-light); color: var(--green); }
.badge-pending  { background: var(--gold-light);  color: var(--gold); }
.badge-inactive { background: var(--red-light);   color: var(--red); }
.badge-review   { background: var(--blue-light);  color: var(--blue); }
.badge-purple   { background: var(--purple-light); color: var(--purple); }

/* Role tags */
.role-tag {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: var(--radius-sm);
    font-size: 0.7rem; font-weight: 600;
    border: 1px solid;
}
.rt-admin   { background: var(--purple-xlight); color: var(--purple);   border-color: var(--border2); }
.rt-teacher { background: var(--blue-light);    color: var(--blue);     border-color: rgba(37,99,235,0.2); }
.rt-student { background: var(--green-light);   color: var(--green);    border-color: rgba(22,163,74,0.2); }

/* Action dots */
.action-dots {
    display: inline-flex; align-items: center; gap: 6px;
    cursor: pointer; position: relative;
}
.action-dot { width: 4px; height: 4px; border-radius: 50%; background: var(--muted2); transition: background 0.2s; }
.action-dots:hover .action-dot { background: var(--purple); }

/* Progress cell */
.prog-cell { display: flex; align-items: center; gap: 8px; min-width: 100px; }
.prog-bar-bg { flex: 1; height: 5px; background: var(--cream3); border-radius: 40px; overflow: hidden; }
.prog-bar-fill { height: 100%; border-radius: 40px; background: var(--gradient); }
.prog-pct { font-size: 0.74rem; font-weight: 600; color: var(--ink); white-space: nowrap; min-width: 32px; text-align: right; }

/* Mini score */
.score-cell {
    font-family: 'DM Mono', monospace;
    font-size: 0.82rem; font-weight: 500;
}
.score-high { color: var(--green); }
.score-mid  { color: var(--gold); }
.score-low  { color: var(--red); }

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

/* ── DONUT CHARTS MINI ── */
.donut-row { display: flex; gap: 20px; }
.donut-item { display: flex; flex-direction: column; align-items: center; gap: 6px; flex: 1; }
.donut-chart-wrap { position: relative; width: 80px; height: 80px; }
.donut-label-inside {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    flex-direction: column;
}
.donut-pct { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 700; color: var(--ink); line-height: 1; }
.donut-title { font-size: 0.72rem; color: var(--muted); text-align: center; font-weight: 500; margin-top: 2px; }

/* ── QUICK STATS MINI TILES ── */
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

/* ── RECENT ENROLLMENTS CARDS ── */
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

/* ── CALENDAR MINI ── */
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

/* ── FEEDBACK / RATING BARS ── */
.rating-rows { display: flex; flex-direction: column; gap: 10px; }
.rating-row { display: flex; align-items: center; gap: 12px; }
.rating-label { font-size: 0.8rem; color: var(--ink); font-weight: 500; width: 90px; flex-shrink: 0; }
.rating-bar-wrap { flex: 1; height: 8px; background: var(--cream3); border-radius: 40px; overflow: hidden; }
.rating-fill { height: 100%; border-radius: 40px; transition: width 1s ease; }
.rating-pct { font-size: 0.76rem; font-weight: 600; color: var(--ink); width: 38px; text-align: right; flex-shrink: 0; }

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

/* ── OVERLAY / MOBILE ── */
.sidebar-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(15,7,32,0.6); backdrop-filter: blur(4px);
    z-index: 190;
}
.sidebar-overlay.on { display: block; }

/* ── RESPONSIVE ── */
@media (max-width: 1400px) {
    .kpi-row { grid-template-columns: repeat(4, 1fr); }
    .kpi-row .kpi-card:last-child { display: none; }
    .sys-cards { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 1100px) {
    :root { --sidebar-w: 260px; }
    .grid-6-4 { grid-template-columns: 1fr; }
    .grid-4-6 { grid-template-columns: 1fr; }
    .grid-7-5 { grid-template-columns: 1fr; }
    .grid-3   { grid-template-columns: 1fr 1fr; }
    .kpi-row  { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 900px) {
    .sidebar { transform: translateX(-100%); }
    .sidebar.on { transform: translateX(0); }
    .main-wrap { margin-left: 0; }
    .topbar-hamburger { display: flex; }
    .topbar-search, .tb-date-chip { display: none; }
    .kpi-row { grid-template-columns: repeat(2, 1fr); }
    .grid-2  { grid-template-columns: 1fr; }
    .grid-3  { grid-template-columns: 1fr; }
    .enroll-grid { grid-template-columns: 1fr; }
    .donut-row { flex-wrap: wrap; }
    .page-body { padding: 16px; }
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

<div class="sidebar-overlay" id="overlay"></div>

<div class="admin-shell">

    {{-- ╔══════════════════════════════════════
         ║  SIDEBAR
         ╚══════════════════════════════════════ --}}
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-mesh">
            <div class="mesh-orb mesh-orb-1"></div>
            <div class="mesh-orb mesh-orb-2"></div>
            <div class="mesh-orb mesh-orb-3"></div>
        </div>

        {{-- Brand --}}
        <a href="{{ url('home') }}" class="sidebar-brand">
            <div class="brand-logomark"><i class="fas fa-graduation-cap"></i></div>
            <div class="brand-text-wrap">
                <div class="brand-name">AlHilal Academy</div>
                <div class="brand-tagline">Online Learning Platform</div>
            </div>
            <div class="brand-version">v2.4</div>
        </a>

        {{-- Admin identity --}}
        <div class="sidebar-admin-card">
            <div class="admin-ava">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}</div>
            <div class="admin-ava-info">
                <div class="admin-name">{{ auth()->user()->name ?? 'Super Admin' }}</div>
                <div class="admin-role">Super Administrator · Full Access</div>
            </div>
            <div class="admin-status-dot"></div>
        </div>

        {{-- System health --}}
        <div class="sys-health-strip">
            <div class="health-dot"></div>
            <div class="health-text">All systems <strong>operational</strong></div>
            <div class="health-mini-bars">
                <div class="health-bar"></div>
                <div class="health-bar"></div>
                <div class="health-bar"></div>
                <div class="health-bar"></div>
                <div class="health-bar"></div>
            </div>
        </div>

        {{-- OVERVIEW --}}
        <div class="nav-section-label">Overview</div>
        <a href="{{ url('admin.dashboard') }}" class="nav-item active">
            <i class="fas fa-th-large nav-ico"></i> Command Centre
        </a>
        <a href="{{ url('admin.analytics') ?? '#' }}" class="nav-item">
            <i class="fas fa-chart-area nav-ico"></i> Analytics
            <span class="nav-new">New</span>
        </a>
        <a href="{{ url('admin.reports') ?? '#' }}" class="nav-item">
            <i class="fas fa-file-chart-line nav-ico"></i> Reports
        </a>

        {{-- PEOPLE --}}
        <div class="nav-section-label">People</div>
        <a href="{{ url('admin.students') ?? '#' }}" class="nav-item">
            <i class="fas fa-user-graduate nav-ico"></i> Students
            <span class="nav-badge nb-purple">{{ $totalStudents ?? '142' }}</span>
        </a>
        <a href="{{ url('admin.teachers') ?? '#' }}" class="nav-item">
            <i class="fas fa-chalkboard-teacher nav-ico"></i> Teachers
            <span class="nav-badge nb-purple">{{ $totalTeachers ?? '18' }}</span>
        </a>
        <a href="{{ url('admin.parents') ?? '#' }}" class="nav-item">
            <i class="fas fa-users nav-ico"></i> Parents / Guardians
        </a>
        <a href="{{ url('admin.enrollments') ?? '#' }}" class="nav-item">
            <i class="fas fa-user-plus nav-ico"></i> Enrollments
            <span class="nav-badge nb-green">7</span>
        </a>

        {{-- ACADEMICS --}}
        <div class="nav-section-label">Academics</div>
        <a href="{{ url('admin.classes') ?? '#' }}" class="nav-item">
            <i class="fas fa-chalkboard nav-ico"></i> Classes
        </a>
        <a href="{{ url('admin.curriculum') ?? '#' }}" class="nav-item">
            <i class="fas fa-book-open nav-ico"></i> Curriculum
        </a>
        <a href="{{ url('admin.assignments') ?? '#' }}" class="nav-item">
            <i class="fas fa-tasks nav-ico"></i> Assignments
        </a>
        <a href="{{ url('admin.exams') ?? '#' }}" class="nav-item">
            <i class="fas fa-clipboard-list nav-ico"></i> Exams & Quizzes
            <span class="nav-badge nb-gold">3</span>
        </a>
        <a href="{{ url('admin.attendance') ?? '#' }}" class="nav-item">
            <i class="fas fa-calendar-check nav-ico"></i> Attendance
        </a>

        {{-- PLATFORM --}}
        <div class="nav-section-label">Platform</div>
        <a href="{{ url('admin.content') ?? '#' }}" class="nav-item">
            <i class="fas fa-photo-video nav-ico"></i> Content Library
        </a>
        <a href="{{ url('admin.announcements') ?? '#' }}" class="nav-item">
            <i class="fas fa-bullhorn nav-ico"></i> Announcements
        </a>
        <a href="{{ url('admin.messages') ?? '#' }}" class="nav-item">
            <i class="fas fa-comment-dots nav-ico"></i> Messages
            <span class="nav-badge nb-red">12</span>
        </a>
        <a href="{{ url('admin.payments') ?? '#' }}" class="nav-item">
            <i class="fas fa-credit-card nav-ico"></i> Payments
        </a>

        {{-- SYSTEM --}}
        <div class="nav-section-label">System</div>
        <a href="{{ url('admin.settings') ?? '#' }}" class="nav-item">
            <i class="fas fa-cog nav-ico"></i> Settings
        </a>
        <a href="{{ url('admin.permissions') ?? '#' }}" class="nav-item">
            <i class="fas fa-shield-alt nav-ico"></i> Roles & Permissions
        </a>
        <a href="{{ url('admin.logs') ?? '#' }}" class="nav-item">
            <i class="fas fa-history nav-ico"></i> Audit Logs
        </a>
        <a href="{{ url('admin.backup') ?? '#' }}" class="nav-item">
            <i class="fas fa-database nav-ico"></i> Backup & System
        </a>

        {{-- Footer --}}
        <div class="sidebar-footer">
            <a href="{{ url('admin.profile') ?? '#' }}" class="sidebar-foot-btn">
                <i class="fas fa-user-circle" style="width:16px;text-align:center;"></i> My Profile
            </a>
            <a href="{{ url('admin.help') ?? '#' }}" class="sidebar-foot-btn">
                <i class="fas fa-question-circle" style="width:16px;text-align:center;"></i> Help & Support
            </a>
            <form method="POST" action="{{ url('logout') }}">
                @csrf
                <button type="submit" class="sidebar-foot-btn danger">
                    <i class="fas fa-sign-out-alt" style="width:16px;text-align:center;"></i> Sign Out
                </button>
            </form>
        </div>

    </aside>

    {{-- ╔══════════════════════════════════════
         ║  MAIN WRAPPER
         ╚══════════════════════════════════════ --}}
    <div class="main-wrap">

        {{-- TOP BAR --}}
        <div class="topbar" id="topbar">
            <div class="topbar-left">
                <button class="topbar-hamburger" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-page">
                    <div class="topbar-page-title">Command Centre</div>
                    <div class="topbar-crumb">
                        <span>Admin</span>
                        <i class="fas fa-chevron-right"></i>
                        <span class="crumb-active">Dashboard</span>
                    </div>
                </div>
            </div>

            <div class="topbar-right">
                <div class="topbar-search">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search students, teachers, classes…">
                    <i class="fas fa-slash" style="font-size:0.65rem;opacity:0.3;"></i>
                </div>

                <div class="tb-date-chip">
                    <i class="fas fa-calendar-alt"></i>
                    {{ now()->format('D, d M Y') }}
                </div>

                <button class="tb-icon-btn" onclick="openDrop('notifDrop')" id="notifTrigger">
                    <i class="fas fa-bell"></i>
                    <span class="tb-badge tb-badge-red"></span>
                </button>

                <a href="#" class="tb-icon-btn">
                    <i class="fas fa-comment-dots"></i>
                    <span class="tb-badge tb-badge-gold"></span>
                </a>

                <a href="#" class="tb-icon-btn" title="Full screen">
                    <i class="fas fa-expand-alt"></i>
                </a>

                <div class="tb-avatar" onclick="openDrop('profileDrop')" id="profileTrigger">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </div>

        {{-- NOTIFICATION DROPDOWN --}}
        <div class="floating-drop" id="notifDrop" style="width:380px;top:78px;right:120px;">
            <div class="drop-header">
                <div class="drop-title">Notifications</div>
                <span class="drop-action">Mark all read</span>
            </div>
            <div class="notif-tabs">
                <div class="notif-tab active">All <span style="background:var(--red);color:white;font-size:0.6rem;padding:1px 5px;border-radius:10px;margin-left:4px;">8</span></div>
                <div class="notif-tab">Urgent</div>
                <div class="notif-tab">System</div>
            </div>
            <div class="notif-list">
                <div class="notif-row unread">
                    <div class="notif-ico ni-r"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="notif-body">
                        <div class="notif-msg"><strong>Server CPU</strong> spike detected — 94% usage at 10:22 AM</div>
                        <div class="notif-ts">2 minutes ago · System</div>
                    </div>
                    <div class="notif-unread-dot"></div>
                </div>
                <div class="notif-row unread">
                    <div class="notif-ico ni-p"><i class="fas fa-user-plus"></i></div>
                    <div class="notif-body">
                        <div class="notif-msg"><strong>7 new enrollment requests</strong> awaiting approval</div>
                        <div class="notif-ts">15 minutes ago · Enrollments</div>
                    </div>
                    <div class="notif-unread-dot"></div>
                </div>
                <div class="notif-row unread">
                    <div class="notif-ico ni-g"><i class="fas fa-credit-card"></i></div>
                    <div class="notif-body">
                        <div class="notif-msg">Payment of <strong>UGX 450,000</strong> received from Kamara family</div>
                        <div class="notif-ts">1 hour ago · Payments</div>
                    </div>
                    <div class="notif-unread-dot"></div>
                </div>
                <div class="notif-row">
                    <div class="notif-ico ni-gr"><i class="fas fa-check-circle"></i></div>
                    <div class="notif-body">
                        <div class="notif-msg">Database backup <strong>completed successfully</strong></div>
                        <div class="notif-ts">3 hours ago · System</div>
                    </div>
                </div>
                <div class="notif-row">
                    <div class="notif-ico ni-p"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="notif-body">
                        <div class="notif-msg">New teacher application from <strong>Sheikh Musa Balikuddembe</strong></div>
                        <div class="notif-ts">Yesterday, 4:15 PM</div>
                    </div>
                </div>
            </div>
            <div class="drop-footer"><a href="#">View all notifications <i class="fas fa-arrow-right"></i></a></div>
        </div>

        {{-- PROFILE DROPDOWN --}}
        <div class="floating-drop" id="profileDrop" style="width:240px;top:78px;right:32px;">
            <div class="profile-drop-head">
                <div class="pdh-ava">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                <div class="pdh-name">{{ auth()->user()->name ?? 'Super Admin' }}</div>
                <div class="pdh-role">Super Administrator</div>
                <div class="pdh-badge"><i class="fas fa-circle"></i> Online</div>
            </div>
            <a href="#" class="pdh-item"><i class="fas fa-user"></i> My Profile</a>
            <a href="#" class="pdh-item"><i class="fas fa-cog"></i> System Settings</a>
            <a href="#" class="pdh-item"><i class="fas fa-shield-alt"></i> Security</a>
            <a href="#" class="pdh-item"><i class="fas fa-question-circle"></i> Help Center</a>
            <div class="pdh-divider"></div>
            <form method="POST" action="{{ url('logout') }}">
                @csrf
                <button type="submit" class="pdh-item danger"><i class="fas fa-sign-out-alt"></i> Sign Out</button>
            </form>
        </div>

        {{-- ═══════════════════════════════
             PAGE BODY
        ═══════════════════════════════ --}}
        <div class="page-body">

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

                <div class="kpi-card">
                    <div class="kpi-watermark">142</div>
                    <div class="kpi-top">
                        <div class="kpi-ico ki-p"><i class="fas fa-user-graduate"></i></div>
                        <div class="kpi-trend kt-up"><i class="fas fa-arrow-up"></i> 8.4%</div>
                    </div>
                    <div class="kpi-num">142</div>
                    <div class="kpi-label">Total Students</div>
                    <div class="kpi-footer"><strong>+11</strong> enrolled this month · <strong>7</strong> pending</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-watermark">18</div>
                    <div class="kpi-top">
                        <div class="kpi-ico ki-b"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="kpi-trend kt-up"><i class="fas fa-arrow-up"></i> 2 new</div>
                    </div>
                    <div class="kpi-num">18</div>
                    <div class="kpi-label">Active Teachers</div>
                    <div class="kpi-footer"><strong>16</strong> teaching today · <strong>2</strong> on leave</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-watermark">24</div>
                    <div class="kpi-top">
                        <div class="kpi-ico ki-r"><i class="fas fa-chalkboard"></i></div>
                        <div class="kpi-trend kt-flat"><i class="fas fa-minus"></i> Stable</div>
                    </div>
                    <div class="kpi-num">24</div>
                    <div class="kpi-label">Active Classes</div>
                    <div class="kpi-footer"><strong>8</strong> sessions scheduled today</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-watermark">87</div>
                    <div class="kpi-top">
                        <div class="kpi-ico ki-gr"><i class="fas fa-chart-line"></i></div>
                        <div class="kpi-trend kt-up"><i class="fas fa-arrow-up"></i> 5%</div>
                    </div>
                    <div class="kpi-num">87%</div>
                    <div class="kpi-label">Completion Rate</div>
                    <div class="kpi-footer">Up from <strong>82%</strong> last month</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-watermark">3.8M</div>
                    <div class="kpi-top">
                        <div class="kpi-ico ki-g"><i class="fas fa-hand-holding-usd"></i></div>
                        <div class="kpi-trend kt-up"><i class="fas fa-arrow-up"></i> 12%</div>
                    </div>
                    <div class="kpi-num">3.8M</div>
                    <div class="kpi-label">Revenue (UGX)</div>
                    <div class="kpi-footer"><strong>3</strong> pending · UGX 620K overdue</div>
                </div>

            </div>

            {{-- ── MAIN CHART + LEADERBOARD ── --}}
            <div class="grid-7-5">

                {{-- Enrollment + Revenue Chart --}}
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
                        {{-- Legend --}}
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

                {{-- Top Teachers Leaderboard --}}
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

                            <div class="lb-item">
                                <div class="lb-rank lb-rank-1">1</div>
                                <div class="lb-ava ua-1">SH</div>
                                <div class="lb-info">
                                    <div class="lb-name">Sheikh Haruna Kato</div>
                                    <div class="lb-subject">Quran & Tajweed</div>
                                </div>
                                <div class="lb-score">
                                    <div class="lb-score-num">98.2</div>
                                    <div class="lb-score-lbl">avg score</div>
                                </div>
                            </div>

                            <div class="lb-item">
                                <div class="lb-rank lb-rank-2">2</div>
                                <div class="lb-ava ua-2">US</div>
                                <div class="lb-info">
                                    <div class="lb-name">Ustadha Safiyya</div>
                                    <div class="lb-subject">Arabic Language</div>
                                </div>
                                <div class="lb-score">
                                    <div class="lb-score-num">95.7</div>
                                    <div class="lb-score-lbl">avg score</div>
                                </div>
                            </div>

                            <div class="lb-item">
                                <div class="lb-rank lb-rank-3">3</div>
                                <div class="lb-ava ua-3">MN</div>
                                <div class="lb-info">
                                    <div class="lb-name">Mwalimu Nasur</div>
                                    <div class="lb-subject">Fiqh & Aqeedah</div>
                                </div>
                                <div class="lb-score">
                                    <div class="lb-score-num">93.1</div>
                                    <div class="lb-score-lbl">avg score</div>
                                </div>
                            </div>

                            <div class="lb-item">
                                <div class="lb-rank lb-rank-n">4</div>
                                <div class="lb-ava ua-4">IK</div>
                                <div class="lb-info">
                                    <div class="lb-name">Imam Kasirye</div>
                                    <div class="lb-subject">Seerah & History</div>
                                </div>
                                <div class="lb-score">
                                    <div class="lb-score-num">90.8</div>
                                    <div class="lb-score-lbl">avg score</div>
                                </div>
                            </div>

                            <div class="lb-item">
                                <div class="lb-rank lb-rank-n">5</div>
                                <div class="lb-ava ua-5">FA</div>
                                <div class="lb-info">
                                    <div class="lb-name">Fatima Al-Amin</div>
                                    <div class="lb-subject">Islamic Studies</div>
                                </div>
                                <div class="lb-score">
                                    <div class="lb-score-num">88.4</div>
                                    <div class="lb-score-lbl">avg score</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- ── ALL USERS TABLE + ACTIVITY ── --}}
            <div class="grid-6-4">

                {{-- Users Management Table --}}
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
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-ava ua-1">AK</div>
                                            <div><div class="user-name">Aisha Kamara</div><div class="user-meta">aisha@alhilal.ac</div></div>
                                        </div>
                                    </td>
                                    <td><span class="role-tag rt-student"><i class="fas fa-user-graduate"></i> Student</span></td>
                                    <td><div class="prog-cell"><div class="prog-bar-bg"><div class="prog-bar-fill" style="width:88%;"></div></div><div class="prog-pct">88%</div></div></td>
                                    <td class="text-center"><span class="score-cell score-high">94.2</span></td>
                                    <td><span class="badge badge-active"><i class="fas fa-circle"></i> Active</span></td>
                                    <td class="text-right" style="font-size:0.75rem;color:var(--muted);">Jan 2025</td>
                                    <td><div class="action-dots"><div class="action-dot"></div><div class="action-dot"></div><div class="action-dot"></div></div></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-ava ua-2">SH</div>
                                            <div><div class="user-name">Sheikh Haruna</div><div class="user-meta">haruna@alhilal.ac</div></div>
                                        </div>
                                    </td>
                                    <td><span class="role-tag rt-teacher"><i class="fas fa-chalkboard-teacher"></i> Teacher</span></td>
                                    <td><div class="prog-cell"><div class="prog-bar-bg"><div class="prog-bar-fill" style="width:100%;"></div></div><div class="prog-pct">100%</div></div></td>
                                    <td class="text-center"><span class="score-cell score-high">98.2</span></td>
                                    <td><span class="badge badge-active"><i class="fas fa-circle"></i> Active</span></td>
                                    <td class="text-right" style="font-size:0.75rem;color:var(--muted);">Aug 2024</td>
                                    <td><div class="action-dots"><div class="action-dot"></div><div class="action-dot"></div><div class="action-dot"></div></div></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-ava ua-3">IS</div>
                                            <div><div class="user-name">Ibrahim Ssekatawa</div><div class="user-meta">ibrahim@alhilal.ac</div></div>
                                        </div>
                                    </td>
                                    <td><span class="role-tag rt-student"><i class="fas fa-user-graduate"></i> Student</span></td>
                                    <td><div class="prog-cell"><div class="prog-bar-bg"><div class="prog-bar-fill" style="width:74%;"></div></div><div class="prog-pct">74%</div></div></td>
                                    <td class="text-center"><span class="score-cell score-high">81.5</span></td>
                                    <td><span class="badge badge-active"><i class="fas fa-circle"></i> Active</span></td>
                                    <td class="text-right" style="font-size:0.75rem;color:var(--muted);">Feb 2025</td>
                                    <td><div class="action-dots"><div class="action-dot"></div><div class="action-dot"></div><div class="action-dot"></div></div></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-ava ua-4">MN</div>
                                            <div><div class="user-name">Mariam Nakato</div><div class="user-meta">mariam@alhilal.ac</div></div>
                                        </div>
                                    </td>
                                    <td><span class="role-tag rt-student"><i class="fas fa-user-graduate"></i> Student</span></td>
                                    <td><div class="prog-cell"><div class="prog-bar-bg"><div class="prog-bar-fill" style="width:61%;"></div></div><div class="prog-pct">61%</div></div></td>
                                    <td class="text-center"><span class="score-cell score-mid">67.3</span></td>
                                    <td><span class="badge badge-pending"><i class="fas fa-circle"></i> Pending</span></td>
                                    <td class="text-right" style="font-size:0.75rem;color:var(--muted);">Mar 2025</td>
                                    <td><div class="action-dots"><div class="action-dot"></div><div class="action-dot"></div><div class="action-dot"></div></div></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-ava ua-5">US</div>
                                            <div><div class="user-name">Ustadha Safiyya</div><div class="user-meta">safiyya@alhilal.ac</div></div>
                                        </div>
                                    </td>
                                    <td><span class="role-tag rt-teacher"><i class="fas fa-chalkboard-teacher"></i> Teacher</span></td>
                                    <td><div class="prog-cell"><div class="prog-bar-bg"><div class="prog-bar-fill" style="width:100%;"></div></div><div class="prog-pct">100%</div></div></td>
                                    <td class="text-center"><span class="score-cell score-high">95.7</span></td>
                                    <td><span class="badge badge-active"><i class="fas fa-circle"></i> Active</span></td>
                                    <td class="text-right" style="font-size:0.75rem;color:var(--muted);">Sep 2024</td>
                                    <td><div class="action-dots"><div class="action-dot"></div><div class="action-dot"></div><div class="action-dot"></div></div></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-ava ua-6">FA</div>
                                            <div><div class="user-name">Fatuma Atieno</div><div class="user-meta">fatuma@alhilal.ac</div></div>
                                        </div>
                                    </td>
                                    <td><span class="role-tag rt-student"><i class="fas fa-user-graduate"></i> Student</span></td>
                                    <td><div class="prog-cell"><div class="prog-bar-bg"><div class="prog-bar-fill" style="width:42%;"></div></div><div class="prog-pct">42%</div></div></td>
                                    <td class="text-center"><span class="score-cell score-low">51.0</span></td>
                                    <td><span class="badge badge-inactive"><i class="fas fa-circle"></i> Inactive</span></td>
                                    <td class="text-right" style="font-size:0.75rem;color:var(--muted);">Jan 2025</td>
                                    <td><div class="action-dots"><div class="action-dot"></div><div class="action-dot"></div><div class="action-dot"></div></div></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-ava ua-7">YM</div>
                                            <div><div class="user-name">Yusuf Mugenyi</div><div class="user-meta">yusuf@alhilal.ac</div></div>
                                        </div>
                                    </td>
                                    <td><span class="role-tag rt-student"><i class="fas fa-user-graduate"></i> Student</span></td>
                                    <td><div class="prog-cell"><div class="prog-bar-bg"><div class="prog-bar-fill" style="width:95%;"></div></div><div class="prog-pct">95%</div></div></td>
                                    <td class="text-center"><span class="score-cell score-high">97.1</span></td>
                                    <td><span class="badge badge-active"><i class="fas fa-circle"></i> Active</span></td>
                                    <td class="text-right" style="font-size:0.75rem;color:var(--muted);">Nov 2024</td>
                                    <td><div class="action-dots"><div class="action-dot"></div><div class="action-dot"></div><div class="action-dot"></div></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Activity Timeline --}}
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
                            <div class="tl-item">
                                <div class="tl-icon-col">
                                    <div class="tl-ico ni-p"><i class="fas fa-user-plus"></i></div>
                                    <div class="tl-line"></div>
                                </div>
                                <div class="tl-body">
                                    <div class="tl-msg">New student <strong>Omar Kiggundu</strong> enrolled <span class="tl-tag" style="background:var(--purple-light);color:var(--purple);">Enrollment</span></div>
                                    <div class="tl-time">2 min ago · by Admin</div>
                                </div>
                            </div>
                            <div class="tl-item">
                                <div class="tl-icon-col">
                                    <div class="tl-ico ni-g"><i class="fas fa-credit-card"></i></div>
                                    <div class="tl-line"></div>
                                </div>
                                <div class="tl-body">
                                    <div class="tl-msg">Payment <strong>UGX 450,000</strong> confirmed from Kamara <span class="tl-tag" style="background:var(--gold-light);color:var(--gold);">Finance</span></div>
                                    <div class="tl-time">1 hr ago · auto-system</div>
                                </div>
                            </div>
                            <div class="tl-item">
                                <div class="tl-icon-col">
                                    <div class="tl-ico ni-r"><i class="fas fa-exclamation-triangle"></i></div>
                                    <div class="tl-line"></div>
                                </div>
                                <div class="tl-body">
                                    <div class="tl-msg">CPU spike <strong>94%</strong> — auto-scaled resolved <span class="tl-tag" style="background:var(--red-light);color:var(--red);">System</span></div>
                                    <div class="tl-time">1.5 hrs ago · auto</div>
                                </div>
                            </div>
                            <div class="tl-item">
                                <div class="tl-icon-col">
                                    <div class="tl-ico ni-gr"><i class="fas fa-database"></i></div>
                                    <div class="tl-line"></div>
                                </div>
                                <div class="tl-body">
                                    <div class="tl-msg">Daily <strong>backup completed</strong> — 2.4GB stored <span class="tl-tag" style="background:var(--green-light);color:var(--green);">System</span></div>
                                    <div class="tl-time">3 hrs ago · cron job</div>
                                </div>
                            </div>
                            <div class="tl-item">
                                <div class="tl-icon-col">
                                    <div class="tl-ico ni-p"><i class="fas fa-chalkboard-teacher"></i></div>
                                    <div class="tl-line"></div>
                                </div>
                                <div class="tl-body">
                                    <div class="tl-msg">Teacher <strong>Mwalimu Nasur</strong> published Fiqh lesson <span class="tl-tag" style="background:var(--blue-light);color:var(--blue);">Content</span></div>
                                    <div class="tl-time">Yesterday, 5:10 PM</div>
                                </div>
                            </div>
                            <div class="tl-item">
                                <div class="tl-icon-col">
                                    <div class="tl-ico ni-gr"><i class="fas fa-star"></i></div>
                                    <div class="tl-line"></div>
                                </div>
                                <div class="tl-body">
                                    <div class="tl-msg"><strong>Yusuf Mugenyi</strong> achieved Perfect Score on Tajweed quiz <span class="tl-tag" style="background:var(--green-light);color:var(--green);">Academic</span></div>
                                    <div class="tl-time">Yesterday, 2:45 PM</div>
                                </div>
                            </div>
                            <div class="tl-item">
                                <div class="tl-icon-col">
                                    <div class="tl-ico ni-g"><i class="fas fa-cog"></i></div>
                                    <div class="tl-line"></div>
                                </div>
                                <div class="tl-body">
                                    <div class="tl-msg">Platform settings updated — <strong>email notifications</strong> enabled <span class="tl-tag" style="background:var(--gold-light);color:var(--gold);">Settings</span></div>
                                    <div class="tl-time">2 days ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── 3-PANEL ROW ── --}}
            <div class="grid-3">

                {{-- Attendance Donut + Subject Breakdown --}}
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

                {{-- Subject Performance Rating --}}
                <div class="card">
                    <div class="card-head">
                        <div class="card-head-left">
                            <div class="card-head-title">Subject Performance</div>
                            <div class="card-head-sub">Avg. student scores by subject</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="rating-rows">
                            <div class="rating-row">
                                <div class="rating-label">Quran</div>
                                <div class="rating-bar-wrap"><div class="rating-fill" style="width:96%;background:var(--gradient);"></div></div>
                                <div class="rating-pct">96%</div>
                            </div>
                            <div class="rating-row">
                                <div class="rating-label">Tajweed</div>
                                <div class="rating-bar-wrap"><div class="rating-fill" style="width:91%;background:linear-gradient(90deg,var(--purple),var(--blue));"></div></div>
                                <div class="rating-pct">91%</div>
                            </div>
                            <div class="rating-row">
                                <div class="rating-label">Arabic</div>
                                <div class="rating-bar-wrap"><div class="rating-fill" style="width:84%;background:linear-gradient(90deg,var(--blue),var(--cyan));"></div></div>
                                <div class="rating-pct">84%</div>
                            </div>
                            <div class="rating-row">
                                <div class="rating-label">Fiqh</div>
                                <div class="rating-bar-wrap"><div class="rating-fill" style="width:79%;background:linear-gradient(90deg,var(--gold),var(--red));"></div></div>
                                <div class="rating-pct">79%</div>
                            </div>
                            <div class="rating-row">
                                <div class="rating-label">Aqeedah</div>
                                <div class="rating-bar-wrap"><div class="rating-fill" style="width:86%;background:linear-gradient(90deg,var(--green),var(--cyan));"></div></div>
                                <div class="rating-pct">86%</div>
                            </div>
                            <div class="rating-row">
                                <div class="rating-label">Seerah</div>
                                <div class="rating-bar-wrap"><div class="rating-fill" style="width:88%;background:linear-gradient(90deg,#DB2777,var(--purple));"></div></div>
                                <div class="rating-pct">88%</div>
                            </div>
                            <div class="rating-row">
                                <div class="rating-label">Islamic St.</div>
                                <div class="rating-bar-wrap"><div class="rating-fill" style="width:77%;background:linear-gradient(90deg,var(--red),var(--gold));"></div></div>
                                <div class="rating-pct">77%</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mini Calendar + Events --}}
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
                                <!-- Days row 1 -->
                                <div class="cal-day other-month">30</div><div class="cal-day other-month">31</div>
                                <div class="cal-day">1</div><div class="cal-day has-event">2</div><div class="cal-day">3</div><div class="cal-day">4</div><div class="cal-day">5</div>
                                <!-- Days row 2 -->
                                <div class="cal-day today">6</div><div class="cal-day">7</div><div class="cal-day has-event">8</div><div class="cal-day">9</div><div class="cal-day">10</div><div class="cal-day">11</div><div class="cal-day">12</div>
                                <!-- Days row 3 -->
                                <div class="cal-day">13</div><div class="cal-day has-event">14</div><div class="cal-day">15</div><div class="cal-day has-event">16</div><div class="cal-day">17</div><div class="cal-day">18</div><div class="cal-day">19</div>
                                <!-- Days row 4 -->
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
                        <div class="sys-card">
                            <div class="sys-card-top">
                                <div class="sys-card-label"><i class="fas fa-microchip" style="margin-right:4px;"></i>CPU Usage</div>
                                <div class="sys-card-status scs-ok"><div class="sys-card-dot dot-green"></div> Normal</div>
                            </div>
                            <div class="sys-card-num">34<span style="font-size:1rem;">%</span></div>
                            <div class="sys-card-sub">Peak today: 94% at 10:22 AM</div>
                            <div class="sys-prog"><div class="sys-prog-bar"><div class="sys-prog-fill spf-green" style="width:34%;"></div></div></div>
                        </div>
                        <div class="sys-card">
                            <div class="sys-card-top">
                                <div class="sys-card-label"><i class="fas fa-memory" style="margin-right:4px;"></i>RAM Usage</div>
                                <div class="sys-card-status scs-warn"><div class="sys-card-dot dot-gold"></div> Moderate</div>
                            </div>
                            <div class="sys-card-num">71<span style="font-size:1rem;">%</span></div>
                            <div class="sys-card-sub">6.4 GB of 9 GB allocated</div>
                            <div class="sys-prog"><div class="sys-prog-bar"><div class="sys-prog-fill spf-gold" style="width:71%;"></div></div></div>
                        </div>
                        <div class="sys-card">
                            <div class="sys-card-top">
                                <div class="sys-card-label"><i class="fas fa-hdd" style="margin-right:4px;"></i>Disk Space</div>
                                <div class="sys-card-status scs-ok"><div class="sys-card-dot dot-green"></div> Healthy</div>
                            </div>
                            <div class="sys-card-num">48<span style="font-size:1rem;">%</span></div>
                            <div class="sys-card-sub">241 GB of 500 GB used</div>
                            <div class="sys-prog"><div class="sys-prog-bar"><div class="sys-prog-fill spf-purple" style="width:48%;"></div></div></div>
                        </div>
                        <div class="sys-card">
                            <div class="sys-card-top">
                                <div class="sys-card-label"><i class="fas fa-users" style="margin-right:4px;"></i>Active Sessions</div>
                                <div class="sys-card-status scs-ok"><div class="sys-card-dot dot-green"></div> Live</div>
                            </div>
                            <div class="sys-card-num">63</div>
                            <div class="sys-card-sub">Peak today: 112 users online</div>
                            <div class="sys-prog"><div class="sys-prog-bar"><div class="sys-prog-fill spf-purple" style="width:56%;"></div></div></div>
                        </div>
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
                            <div class="enroll-card">
                                <div class="enroll-ava ua-1">OK</div>
                                <div class="enroll-info">
                                    <div class="enroll-name">Omar Kiggundu</div>
                                    <div class="enroll-class">Arabic Beginners</div>
                                </div>
                                <div style="display:flex;flex-direction:column;gap:4px;align-items:flex-end;">
                                    <div class="enroll-time">10 min ago</div>
                                    <span class="badge badge-pending" style="font-size:0.62rem;">Pending</span>
                                </div>
                            </div>
                            <div class="enroll-card">
                                <div class="enroll-ava ua-2">ZM</div>
                                <div class="enroll-info">
                                    <div class="enroll-name">Zahra Mutebi</div>
                                    <div class="enroll-class">Quran Level 1</div>
                                </div>
                                <div style="display:flex;flex-direction:column;gap:4px;align-items:flex-end;">
                                    <div class="enroll-time">45 min ago</div>
                                    <span class="badge badge-pending" style="font-size:0.62rem;">Pending</span>
                                </div>
                            </div>
                            <div class="enroll-card">
                                <div class="enroll-ava ua-3">HA</div>
                                <div class="enroll-info">
                                    <div class="enroll-name">Hassan Atuhaire</div>
                                    <div class="enroll-class">Fiqh Grade 4</div>
                                </div>
                                <div style="display:flex;flex-direction:column;gap:4px;align-items:flex-end;">
                                    <div class="enroll-time">2 hrs ago</div>
                                    <span class="badge badge-review" style="font-size:0.62rem;">Review</span>
                                </div>
                            </div>
                            <div class="enroll-card">
                                <div class="enroll-ava ua-4">NB</div>
                                <div class="enroll-info">
                                    <div class="enroll-name">Nadia Babirye</div>
                                    <div class="enroll-class">Tajweed Adv.</div>
                                </div>
                                <div style="display:flex;flex-direction:column;gap:4px;align-items:flex-end;">
                                    <div class="enroll-time">Yesterday</div>
                                    <span class="badge badge-active" style="font-size:0.62rem;">Approved</span>
                                </div>
                            </div>
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

        </div>{{-- /page-body --}}

    </div>{{-- /main-wrap --}}
</div>{{-- /admin-shell --}}

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   CHART.JS GLOBAL DEFAULTS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
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

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   UI INTERACTIONS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */

/* Dropdown management */
function openDrop(id) {
    const drop = document.getElementById(id);
    const isOpen = drop.classList.contains('open');
    document.querySelectorAll('.floating-drop').forEach(d => d.classList.remove('open'));
    if (!isOpen) drop.classList.add('open');
}
document.addEventListener('click', e => {
    if (!e.target.closest('.floating-drop') && !e.target.closest('#notifTrigger') && !e.target.closest('#profileTrigger')) {
        document.querySelectorAll('.floating-drop').forEach(d => d.classList.remove('open'));
    }
});

/* Sidebar mobile */
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('on');
    document.getElementById('overlay').classList.toggle('on');
}
document.getElementById('overlay').addEventListener('click', toggleSidebar);

/* Topbar shadow on scroll */
window.addEventListener('scroll', () => {
    document.getElementById('topbar').classList.toggle('scrolled', window.scrollY > 10);
});

/* Pill filter toggle */
document.querySelectorAll('.pill-filters').forEach(group => {
    group.querySelectorAll('.pill').forEach(pill => {
        pill.addEventListener('click', () => {
            group.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
        });
    });
});

/* Chart period toggle (visual only — swap datasets for real impl) */
function setPeriod(btn, period) {
    btn.closest('.pill-filters').querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
}

/* Staggered entrance animations */
const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity   = '1';
            entry.target.style.transform = 'translateY(0) scale(1)';
            io.unobserve(entry.target);
        }
    });
}, { threshold: 0.08 });

document.querySelectorAll('.kpi-card, .card, .lb-item, .sys-card, .enroll-card, .mini-tile').forEach((el, i) => {
    el.style.opacity   = '0';
    el.style.transform = 'translateY(20px) scale(0.98)';
    el.style.transition = `opacity 0.5s ease ${i * 0.04}s, transform 0.5s cubic-bezier(0.4,0,0.2,1) ${i * 0.04}s`;
    io.observe(el);
});

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

/* Topbar fullscreen toggle */
document.querySelector('[title="Full screen"]').addEventListener('click', () => {
    if (!document.fullscreenElement) document.documentElement.requestFullscreen().catch(() => {});
    else document.exitFullscreen();
});
</script>
@endsection