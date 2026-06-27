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
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(0deg, transparent, transparent 40px, rgba(255, 255, 255, 0.015) 40px, rgba(255, 255, 255, 0.015) 41px),
                repeating-linear-gradient(90deg, transparent, transparent 40px, rgba(255, 255, 255, 0.015) 40px, rgba(255, 255, 255, 0.015) 41px);
        }

        .banner-orb-a {
            position: absolute;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(107, 70, 193, 0.32) 0%, transparent 70%);
            top: -100px;
            right: 200px;
            pointer-events: none;
        }

        .banner-orb-b {
            position: absolute;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.22) 0%, transparent 70%);
            bottom: -80px;
            right: 60px;
            pointer-events: none;
        }

        .banner-orb-c {
            position: absolute;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(217, 119, 6, 0.15) 0%, transparent 70%);
            top: -40px;
            left: 400px;
            pointer-events: none;
        }

        .banner-left {
            padding: 32px 40px;
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .banner-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.13);
            backdrop-filter: blur(6px);
            padding: 5px 14px;
            border-radius: 40px;
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.65);
            letter-spacing: 1.8px;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 14px;
            width: fit-content;
        }

        .eyebrow-live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #4ade80;
            box-shadow: 0 0 10px rgba(74, 222, 128, 0.7);
            animation: pulse-green 2s ease-in-out infinite;
        }

        .banner-title {
            font-size: clamp(1.6rem, 3vw, 2.1rem);
            font-weight: 800;
            color: white;
            margin-bottom: 8px;
            line-height: 1.15;
        }

        .banner-title-grad {
            background: linear-gradient(135deg, #C084FC 0%, #F87171 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .banner-sub {
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.52);
            line-height: 1.6;
            max-width: 500px;
        }

        .banner-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            align-items: center;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 20px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.83rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: var(--transition);
        }

        .bta-primary {
            background: var(--gradient);
            color: white;
            box-shadow: 0 6px 20px rgba(107, 70, 193, 0.4);
        }

        .bta-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(107, 70, 193, 0.5);
            color: white;
        }

        .bta-ghost {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
        }

        .bta-ghost:hover {
            background: rgba(255, 255, 255, 0.18);
            color: white;
        }

        .banner-metrics {
            padding: 28px 36px 28px 20px;
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 16px;
            border-left: 1px solid rgba(255, 255, 255, 0.08);
        }

        .banner-metric-item {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .bm-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: white;
            line-height: 1;
        }

        .bm-label {
            font-size: 0.68rem;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 2px;
        }

        .bm-trend {
            font-size: 0.68rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 3px;
            margin-top: 3px;
        }

        .bm-up {
            color: #86efac;
        }

        .bm-divider {
            width: 100%;
            height: 1px;
            background: rgba(255, 255, 255, 0.07);
        }

        /* KPI */
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
            position: relative;
            overflow: hidden;
            transition: var(--transition);
            cursor: pointer;
        }

        .kpi-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            border-color: var(--border2);
        }

        .kpi-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .kpi-card:hover::after {
            transform: scaleX(1);
        }

        .kpi-watermark {
            position: absolute;
            top: -10px;
            right: -8px;
            font-family: 'Playfair Display', serif;
            font-size: 5rem;
            font-weight: 800;
            color: rgba(107, 70, 193, 0.04);
            line-height: 1;
            pointer-events: none;
            user-select: none;
        }

        .kpi-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .kpi-ico {
            width: 44px;
            height: 44px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
        }

        .ki-p {
            background: var(--purple-light);
            color: var(--purple);
        }

        .ki-r {
            background: var(--red-light);
            color: var(--red);
        }

        .ki-g {
            background: var(--gold-light);
            color: var(--gold);
        }

        .ki-gr {
            background: var(--green-light);
            color: var(--green);
        }

        .ki-b {
            background: var(--blue-light);
            color: var(--blue);
        }

        .kpi-trend {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
        }

        .kt-up {
            background: var(--green-light);
            color: var(--green);
        }

        .kt-flat {
            background: var(--cream3);
            color: var(--muted);
        }

        .kpi-num {
            font-family: 'Playfair Display', serif;
            font-size: 2.1rem;
            font-weight: 800;
            color: var(--ink);
            line-height: 1;
            margin-bottom: 4px;
        }

        .kpi-label {
            font-size: 0.78rem;
            color: var(--muted);
            font-weight: 500;
        }

        .kpi-footer {
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid var(--border);
            font-size: 0.71rem;
            color: var(--muted);
        }

        .kpi-footer strong {
            color: var(--ink);
            font-weight: 600;
        }

        /* Grids */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .grid-6-4 {
            display: grid;
            grid-template-columns: 6fr 4fr;
            gap: 20px;
        }

        .grid-7-5 {
            display: grid;
            grid-template-columns: 7fr 5fr;
            gap: 20px;
        }

        .main-chart-wrap {
            position: relative;
            height: 270px;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            padding: 0 16px 12px;
            font-size: 0.67rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted2);
            border-bottom: 2px solid var(--border);
            white-space: nowrap;
        }

        .data-table td {
            padding: 13px 16px;
            font-size: 0.84rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: var(--cream2);
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .data-table th.text-right,
        .data-table td.text-right {
            text-align: right;
        }

        .data-table th.text-center,
        .data-table td.text-center {
            text-align: center;
        }

        /* User cell */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-ava {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.78rem;
            flex-shrink: 0;
        }

        .ua-1 {
            background: var(--gradient);
        }

        .ua-2 {
            background: linear-gradient(135deg, var(--gold), var(--red));
        }

        .ua-3 {
            background: linear-gradient(135deg, var(--green), #0EA5E9);
        }

        .ua-4 {
            background: linear-gradient(135deg, #0EA5E9, var(--purple));
        }

        .ua-5 {
            background: linear-gradient(135deg, #DB2777, var(--purple));
        }

        .ua-6 {
            background: linear-gradient(135deg, var(--cyan), var(--green));
        }

        .ua-7 {
            background: linear-gradient(135deg, var(--gold), var(--green));
        }

        .ua-8 {
            background: linear-gradient(135deg, var(--red), #DB2777);
        }

        .user-name {
            font-weight: 600;
            font-size: 0.84rem;
            color: var(--ink);
            line-height: 1.2;
        }

        .user-meta {
            font-size: 0.71rem;
            color: var(--muted);
        }

        /* Progress */
        .prog-cell {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 100px;
        }

        .prog-bar-bg {
            flex: 1;
            height: 5px;
            background: var(--cream3);
            border-radius: 40px;
            overflow: hidden;
        }

        .prog-bar-fill {
            height: 100%;
            border-radius: 40px;
            background: var(--gradient);
        }

        .prog-pct {
            font-size: 0.74rem;
            font-weight: 600;
            color: var(--ink);
            white-space: nowrap;
            min-width: 32px;
            text-align: right;
        }

        .score-cell {
            font-family: 'DM Mono', monospace;
            font-size: 0.82rem;
            font-weight: 500;
        }

        .score-high {
            color: var(--green);
        }

        .score-mid {
            color: var(--gold);
        }

        .score-low {
            color: var(--red);
        }

        /* Timeline */
        .timeline {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .tl-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .tl-item:last-child {
            border-bottom: none;
        }

        .tl-icon-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
            flex-shrink: 0;
            padding-top: 3px;
        }

        .tl-ico {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.82rem;
            flex-shrink: 0;
        }

        .tl-line {
            width: 1.5px;
            flex: 1;
            min-height: 12px;
            background: var(--border2);
            margin-top: 4px;
        }

        .tl-item:last-child .tl-line {
            display: none;
        }

        .tl-body {
            flex: 1;
            padding-bottom: 2px;
        }

        .tl-msg {
            font-size: 0.82rem;
            color: var(--ink);
            line-height: 1.45;
            font-weight: 500;
        }

        .tl-msg strong {
            color: var(--purple);
            font-weight: 600;
        }

        .tl-time {
            font-size: 0.68rem;
            color: var(--muted);
            margin-top: 3px;
        }

        .tl-tag {
            display: inline-block;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 1px 7px;
            border-radius: 20px;
            margin-left: 6px;
        }

        /* Leaderboard */
        .leaderboard {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .lb-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            transition: var(--transition);
            cursor: pointer;
        }

        .lb-item:hover {
            border-color: var(--border3);
            box-shadow: var(--shadow-sm);
        }

        .lb-rank {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }

        .lb-rank-1 {
            color: var(--gold);
        }

        .lb-rank-2 {
            color: var(--muted);
        }

        .lb-rank-3 {
            color: #CD7F32;
        }

        .lb-rank-n {
            color: var(--muted2);
            font-size: 0.85rem;
        }

        .lb-ava {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .lb-info {
            flex: 1;
        }

        .lb-name {
            font-size: 0.86rem;
            font-weight: 600;
            color: var(--ink);
        }

        .lb-subject {
            font-size: 0.71rem;
            color: var(--muted);
        }

        .lb-score {
            text-align: right;
        }

        .lb-score-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1;
        }

        .lb-score-lbl {
            font-size: 0.65rem;
            color: var(--muted);
        }

        /* Rating bars */
        .rating-rows {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .rating-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .rating-label {
            font-size: 0.8rem;
            color: var(--ink);
            font-weight: 500;
            width: 90px;
            flex-shrink: 0;
        }

        .rating-bar-wrap {
            flex: 1;
            height: 8px;
            background: var(--cream3);
            border-radius: 40px;
            overflow: hidden;
        }

        .rating-fill {
            height: 100%;
            border-radius: 40px;
            transition: width 1s ease;
        }

        .rating-pct {
            font-size: 0.76rem;
            font-weight: 600;
            color: var(--ink);
            width: 38px;
            text-align: right;
        }

        /* Cmd strip */
        .cmd-strip {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .cmd-btn {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 18px;
            border-radius: var(--radius-md);
            font-size: 0.82rem;
            font-weight: 600;
            border: 1.5px solid var(--border2);
            background: white;
            color: var(--ink);
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            font-family: 'DM Sans', sans-serif;
            white-space: nowrap;
        }

        .cmd-btn:hover {
            border-color: var(--purple);
            color: var(--purple);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .cmd-btn-primary {
            background: var(--gradient);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(107, 70, 193, 0.3);
        }

        .cmd-btn-primary:hover {
            color: white;
            box-shadow: 0 8px 22px rgba(107, 70, 193, 0.4);
        }

        /* Enroll grid */
        .enroll-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .enroll-card {
            padding: 14px 16px;
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
        }

        .enroll-card:hover {
            border-color: var(--purple);
            box-shadow: var(--shadow-sm);
        }

        .enroll-ava {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.82rem;
            flex-shrink: 0;
        }

        .enroll-info {
            flex: 1;
            overflow: hidden;
        }

        .enroll-name {
            font-size: 0.83rem;
            font-weight: 600;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .enroll-class {
            font-size: 0.7rem;
            color: var(--muted);
        }

        .enroll-time {
            font-size: 0.68rem;
            color: var(--muted2);
            white-space: nowrap;
        }

        /* Sys cards */
        .sys-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .sys-card {
            background: white;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            transition: var(--transition);
        }

        .sys-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-sm);
        }

        .sys-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .sys-card-label {
            font-size: 0.72rem;
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sys-card-status {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .scs-ok {
            color: var(--green);
        }

        .scs-warn {
            color: var(--gold);
        }

        .sys-card-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .dot-green {
            background: var(--green);
            box-shadow: 0 0 6px rgba(22, 163, 74, 0.6);
        }

        .dot-gold {
            background: var(--gold);
        }

        .sys-card-num {
            font-family: 'DM Mono', monospace;
            font-size: 1.6rem;
            font-weight: 500;
            color: var(--ink);
            line-height: 1;
        }

        .sys-card-sub {
            font-size: 0.7rem;
            color: var(--muted);
            margin-top: 4px;
        }

        .sys-prog {
            margin-top: 10px;
        }

        .sys-prog-bar {
            height: 4px;
            background: var(--cream3);
            border-radius: 40px;
            overflow: hidden;
        }

        .sys-prog-fill {
            height: 100%;
            border-radius: 40px;
            transition: width 1s ease;
        }

        .spf-green {
            background: var(--green);
        }

        .spf-gold {
            background: var(--gold);
        }

        .spf-purple {
            background: var(--gradient);
        }

        /* Mini tiles */
        .mini-tiles {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .mini-tile {
            padding: 14px 16px;
            border-radius: var(--radius-md);
            border: 1.5px solid var(--border);
            background: var(--cream);
            transition: var(--transition);
        }

        .mini-tile:hover {
            border-color: var(--border3);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .mt-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.65rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 4px;
        }

        .mt-label {
            font-size: 0.72rem;
            color: var(--muted);
            font-weight: 500;
        }

        .mt-ico {
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        /* Calendar */
        .mini-cal {}

        .cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .cal-month {
            font-family: 'Playfair Display', serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--ink);
        }

        .cal-nav {
            display: flex;
            gap: 4px;
        }

        .cal-nav-btn {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            border: 1px solid var(--border2);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            color: var(--muted);
            cursor: pointer;
            transition: var(--transition);
        }

        .cal-nav-btn:hover {
            background: var(--purple);
            color: white;
            border-color: var(--purple);
        }

        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }

        .cal-dow {
            text-align: center;
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--muted2);
            padding: 4px 0;
        }

        .cal-day {
            text-align: center;
            padding: 7px 2px;
            font-size: 0.78rem;
            color: var(--muted);
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            line-height: 1;
        }

        .cal-day:hover {
            background: var(--purple-light);
            color: var(--purple);
        }

        .cal-day.today {
            background: var(--gradient);
            color: white;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(107, 70, 193, 0.35);
        }

        .cal-day.other-month {
            color: var(--muted2);
            opacity: 0.4;
        }

        .cal-events {
            margin-top: 14px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .cal-event {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            border-left: 3px solid;
            background: var(--cream);
            font-size: 0.78rem;
        }

        .ce-purple {
            border-color: var(--purple);
        }

        .ce-red {
            border-color: var(--red);
        }

        .ce-gold {
            border-color: var(--gold);
        }

        .cal-event-name {
            font-weight: 600;
            color: var(--ink);
            flex: 1;
        }

        .cal-event-time {
            font-size: 0.68rem;
            color: var(--muted);
            white-space: nowrap;
        }

        /* Responsive */
        @media(max-width:1400px) {
            .kpi-row {
                grid-template-columns: repeat(4, 1fr);
            }

            .kpi-row .kpi-card:last-child {
                display: none;
            }

            .sys-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:1100px) {

            .grid-6-4,
            .grid-7-5 {
                grid-template-columns: 1fr;
            }

            .grid-3 {
                grid-template-columns: 1fr 1fr;
            }

            .kpi-row {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media(max-width:900px) {
            .kpi-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .grid-2,
            .grid-3 {
                grid-template-columns: 1fr;
            }

            .enroll-grid {
                grid-template-columns: 1fr;
            }

            .command-banner {
                grid-template-columns: 1fr;
            }

            .banner-metrics {
                border-left: none;
                border-top: 1px solid rgba(255, 255, 255, 0.08);
                flex-direction: row;
                padding: 20px 28px;
                gap: 24px;
            }

            .bm-divider {
                width: 1px;
                height: auto;
            }

            .banner-metric-item {
                align-items: flex-start;
            }
        }

        @media(max-width:600px) {
            .kpi-row {
                grid-template-columns: 1fr;
            }

            .sys-cards {
                grid-template-columns: 1fr 1fr;
            }

            .mini-tiles {
                grid-template-columns: 1fr;
            }

            .banner-actions {
                flex-direction: column;
                align-items: flex-start;
            }
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
                <span
                    class="banner-title-grad">{{ auth()->user()->firstname ?? auth()->user()->name ?? 'Administrator' }}</span>
            </div>
            <div class="banner-sub">
                AlHilal Academy is running smoothly. You have
                <strong style="color:#C084FC;">{{ $pendingEnrollments }} enrollment requests</strong>,
                <strong style="color:#F87171;">{{ $totalEnrollments }} active enrollments</strong> and
                <strong style="color:#FCD34D;">{{ $totalExams }} exams</strong> in the system.
                @if($currentAcademicYear)
                    · Academic Year <strong style="color:#86efac;">{{ $currentAcademicYear->name }}</strong>
                @endif
            </div>
            <div class="banner-actions">
                <a href="{{ route('admin.students') }}" class="btn-action bta-primary"><i class="fas fa-users"></i> Manage
                    Students</a>
                <a href="{{ route('admin.enrollments') }}" class="btn-action bta-ghost"><i class="fas fa-user-plus"></i>
                    Enrollments
                    @if($pendingEnrollments > 0)
                        <span
                            style="background:var(--red);color:white;font-size:0.6rem;padding:1px 6px;border-radius:20px;">{{ $pendingEnrollments }}</span>
                    @endif
                </a>
            </div>
        </div>

        <div class="banner-metrics">
            <div class="banner-metric-item">
                <div class="bm-num">{{ $totalStudents }}</div>
                <div class="bm-label">Total Students</div>
                <div class="bm-trend bm-up"><i class="fas fa-user-graduate"></i> Active Learners</div>
            </div>
            <div class="bm-divider"></div>
            <div class="banner-metric-item">
                <div class="bm-num">{{ $totalTeachers }}</div>
                <div class="bm-label">Active Teachers</div>
                <div class="bm-trend bm-up"><i class="fas fa-chalkboard-teacher"></i> Educators</div>
            </div>
            <div class="bm-divider"></div>
            <div class="banner-metric-item">
                <div class="bm-num">{{ $overallCompletionRate }}%</div>
                <div class="bm-label">Completion Rate</div>
                <div class="bm-trend bm-up"><i class="fas fa-chart-line"></i> Overall Progress</div>
            </div>
        </div>
    </div>

    {{-- ── QUICK CMD STRIP ── --}}
    <div class="card">
        <div class="card-body" style="padding:16px 22px;">
            <div class="cmd-strip">
                <a href="{{ route('admin.students') }}" class="cmd-btn cmd-btn-primary"><i class="fas fa-user-graduate"></i>
                    Students</a>
                <a href="{{ route('admin.teachers') }}" class="cmd-btn"><i class="fas fa-chalkboard-teacher"></i>
                    Teachers</a>
                <a href="{{ route('admin.enrollments') }}" class="cmd-btn"><i class="fas fa-user-plus"></i> Enrollments
                    @if($pendingEnrollments > 0)
                        <span
                            style="background:var(--red);color:white;font-size:0.6rem;padding:1px 6px;border-radius:20px;">{{ $pendingEnrollments }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.payments') }}" class="cmd-btn"><i class="fas fa-credit-card"></i> Payments</a>
                <a href="{{ route('admin.certificates.index') }}" class="cmd-btn"><i class="fas fa-certificate"></i>
                    Certificates</a>
                <a href="{{ route('admin.reports') }}" class="cmd-btn"><i class="fas fa-chart-bar"></i> Reports</a>
                <!-- <a href="{{ route('admin.sections.index') }}" class="cmd-btn"><i class="fas fa-layer-group"></i>
                    Sections</a>
                <a href="{{ route('users.user-information') }}" class="cmd-btn"><i class="fas fa-database"></i> All
                    Users</a> -->
            </div>
        </div>
    </div>

    {{-- ── KPI CARDS ── --}}
    <div class="kpi-row">
        <a href="{{ route('admin.students') }}" class="kpi-card" style="text-decoration:none;">
            <div class="kpi-watermark">{{ $totalStudents }}</div>
            <div class="kpi-top">
                <div class="kpi-ico ki-p"><i class="fas fa-user-graduate"></i></div>
                <div class="kpi-trend kt-up"><i class="fas fa-arrow-up"></i> Students</div>
            </div>
            <div class="kpi-num">{{ $totalStudents }}</div>
            <div class="kpi-label">Total Students</div>
            <div class="kpi-footer"><strong>{{ $totalEnrollments }}</strong> active enrollments</div>
        </a>
        <a href="{{ route('admin.teachers') }}" class="kpi-card" style="text-decoration:none;">
            <div class="kpi-watermark">{{ $totalTeachers }}</div>
            <div class="kpi-top">
                <div class="kpi-ico ki-b"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="kpi-trend kt-up"><i class="fas fa-arrow-up"></i> Teachers</div>
            </div>
            <div class="kpi-num">{{ $totalTeachers }}</div>
            <div class="kpi-label">Active Teachers</div>
            <div class="kpi-footer">Across <strong>{{ $totalClasses }}</strong> active classes</div>
        </a>
        <div class="kpi-card">
            <div class="kpi-watermark">{{ $totalClasses }}</div>
            <div class="kpi-top">
                <div class="kpi-ico ki-r"><i class="fas fa-chalkboard"></i></div>
                <div class="kpi-trend kt-flat"><i class="fas fa-minus"></i> Stable</div>
            </div>
            <div class="kpi-num">{{ $totalClasses }}</div>
            <div class="kpi-label">Active Classes</div>
            <div class="kpi-footer"><strong>{{ $totalSubjects }}</strong> subjects · <strong>{{ $totalTopics }}</strong>
                topics</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-watermark">{{ $overallCompletionRate }}%</div>
            <div class="kpi-top">
                <div class="kpi-ico ki-gr"><i class="fas fa-chart-line"></i></div>
                <div class="kpi-trend kt-up"><i class="fas fa-arrow-up"></i> {{ $overallCompletionRate }}%</div>
            </div>
            <div class="kpi-num">{{ $overallCompletionRate }}%</div>
            <div class="kpi-label">Completion Rate</div>
            <div class="kpi-footer"><strong>{{ $totalCompletions }}</strong> lessons completed</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-watermark">{{ $totalLessons }}</div>
            <div class="kpi-top">
                <div class="kpi-ico ki-g"><i class="fas fa-book"></i></div>
                <div class="kpi-trend kt-up"><i class="fas fa-arrow-up"></i> Content</div>
            </div>
            <div class="kpi-num">{{ $totalLessons }}</div>
            <div class="kpi-label">Total Lessons</div>
            <div class="kpi-footer"><strong>{{ $publishedLessons }}</strong> published ·
                {{ $totalLessons - $publishedLessons }} drafts</div>
        </div>
    </div>

    {{-- ── MAIN CHART + LEADERBOARD ── --}}
    <div class="grid-7-5">
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Enrollment & Revenue Trends</div>
                    <div class="card-head-sub">Monthly overview across the last 12 months</div>
                </div>
                <div class="card-head-right">
                    <div class="pill-filters">
                        <button class="pill active" onclick="setPeriod(this,'12m')">12M</button>
                        <button class="pill" onclick="setPeriod(this,'6m')">6M</button>
                        <button class="pill" onclick="setPeriod(this,'3m')">3M</button>
                    </div>
                    <a href="{{ route('admin.reports') }}" class="card-link" style="margin-left:8px;">Export <i
                            class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="main-chart-wrap">
                    <canvas id="mainChart"></canvas>
                </div>
                <div style="display:flex;gap:20px;margin-top:16px;padding-top:14px;border-top:1px solid var(--border);">
                    <div style="display:flex;align-items:center;gap:7px;font-size:0.78rem;color:var(--muted);">
                        <span
                            style="width:24px;height:3px;background:var(--purple);border-radius:2px;display:inline-block;"></span>
                        Enrollments
                    </div>
                    <div style="display:flex;align-items:center;gap:7px;font-size:0.78rem;color:var(--muted);">
                        <span
                            style="width:24px;height:3px;background:var(--green);border-radius:2px;display:inline-block;"></span>
                        Completions
                    </div>
                    <div style="display:flex;align-items:center;gap:7px;font-size:0.78rem;color:var(--muted);">
                        <span
                            style="width:24px;height:3px;background:var(--gold);border-radius:2px;display:inline-block;"></span>
                        Revenue (UGX)
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
                <a href="{{ route('admin.teachers') }}" class="card-link">Full List <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div class="leaderboard">
                    @php $avaClasses = ['ua-1', 'ua-2', 'ua-3', 'ua-4', 'ua-5'];
                    $rankClasses = ['lb-rank-1', 'lb-rank-2', 'lb-rank-3', 'lb-rank-n', 'lb-rank-n']; @endphp
                    @forelse($topTeachers as $i => $teacher)
                        <div class="lb-item">
                            <div class="lb-rank {{ $rankClasses[$i] ?? 'lb-rank-n' }}">{{ $i + 1 }}</div>
                            <div class="lb-ava {{ $avaClasses[$i] ?? 'ua-1' }}">
                                {{ strtoupper(substr($teacher->firstname ?? 'T', 0, 1) . substr($teacher->lastname ?? '', 0, 1)) }}
                            </div>
                            <div class="lb-info">
                                <div class="lb-name">{{ $teacher->firstname }} {{ $teacher->lastname }}</div>
                                <div class="lb-subject">{{ $teacher->lesson_count }} lessons</div>
                            </div>
                            <div class="lb-score">
                                <div class="lb-score-num">{{ $teacher->avg_score }}</div>
                                <div class="lb-score-lbl">avg score</div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center;padding:30px;color:var(--muted);font-size:0.85rem;">
                            <i class="fas fa-chalkboard-teacher"
                                style="font-size:2rem;opacity:0.3;display:block;margin-bottom:8px;"></i>
                            No teacher performance data yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ── USER TABLE + ACTIVITY ── --}}
    <div class="grid-6-4">
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Recent Users</div>
                    <div class="card-head-sub">Latest registered students</div>
                </div>
                <div class="card-head-right">
                    <a href="{{ route('admin.students') }}" class="card-link">All Students <i
                            class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="card-body-0">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Progress</th>
                            <th class="text-center">Score</th>
                            <th>Status</th>
                            <th class="text-right">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStudents as $i => $user)
                            @php
                                $initials = strtoupper(substr($user->firstname ?? 'U', 0, 1) . substr($user->lastname ?? 'S', 0, 1));
                                $completedCount = \App\Models\Academic\StudentProgress::where('student_id', $user->id)->whereIn('status', ['completed', 'passed'])->count();
                                $totalCount = \App\Models\Academic\StudentProgress::where('student_id', $user->id)->count();
                                $progress = $totalCount > 0 ? round(($completedCount / $totalCount) * 100) : 0;
                                $avgScore = \App\Models\Academic\ExamResult::where('student_id', $user->id)->avg('percentage');
                                $avgScore = $avgScore ? number_format($avgScore, 1) : '—';
                                $scoreClass = $avgScore === '—' ? '' : ($avgScore >= 80 ? 'score-high' : ($avgScore >= 60 ? 'score-mid' : 'score-low'));
                                $statusLabel = $user->account_status == 10 ? 'Active' : 'Inactive';
                                $avaClass = 'ua-' . (($i % 8) + 1);
                            @endphp
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-ava {{ $avaClass }}">{{ $initials }}</div>
                                        <div>
                                            <div class="user-name">{{ $user->firstname ?? '' }} {{ $user->lastname ?? '' }}
                                            </div>
                                            <div class="user-meta">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="prog-cell">
                                        <div class="prog-bar-bg">
                                            <div class="prog-bar-fill" style="width:{{ $progress }}%;"></div>
                                        </div>
                                        <div class="prog-pct">{{ $progress }}%</div>
                                    </div>
                                </td>
                                <td class="text-center"><span class="score-cell {{ $scoreClass }}">{{ $avgScore }}</span></td>
                                <td><span class="badge badge-{{ strtolower($statusLabel) }}"><i class="fas fa-circle"></i>
                                        {{ $statusLabel }}</span></td>
                                <td class="text-right" style="font-size:0.75rem;color:var(--muted);">
                                    {{ $user->created_at?->format('M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;padding:24px;color:var(--muted);">No students
                                    registered yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Recent Activity</div>
                    <div class="card-head-sub">Platform-wide events · live</div>
                </div>
                <a href="{{ route('admin.enrollments') }}" class="card-link">Enrollments <i
                        class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body" style="padding-top:0;">
                <div class="timeline">
                    @forelse($recentEnrollments as $enrollment)
                        <div class="tl-item">
                            <div class="tl-icon-col">
                                <div class="tl-ico ni-p"><i class="fas fa-user-plus"></i></div>
                                <div class="tl-line"></div>
                            </div>
                            <div class="tl-body">
                                <div class="tl-msg">
                                    <strong>{{ $enrollment->student?->firstname ?? '' }}
                                        {{ $enrollment->student?->lastname ?? 'Unknown' }}</strong>
                                    enrolled in <strong>{{ $enrollment->class?->name ?? 'a class' }}</strong>
                                    <span class="tl-tag"
                                        style="background:var(--purple-light);color:var(--purple);">Enrollment</span>
                                </div>
                                <div class="tl-time">{{ $enrollment->created_at?->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                    @endforelse

                    @forelse($recentLessons as $lesson)
                        <div class="tl-item">
                            <div class="tl-icon-col">
                                <div class="tl-ico ni-gr"><i class="fas fa-book"></i></div>
                                <div class="tl-line"></div>
                            </div>
                            <div class="tl-body">
                                <div class="tl-msg">
                                    <strong>{{ $lesson->teacher?->firstname ?? '' }}
                                        {{ $lesson->teacher?->lastname ?? '' }}</strong>
                                    {{ $lesson->status === 'published' ? 'published' : 'created' }} lesson
                                    <strong>{{ Str::limit($lesson->title, 35) }}</strong>
                                    <span class="tl-tag"
                                        style="background:var(--green-light);color:var(--green);">Content</span>
                                </div>
                                <div class="tl-time">{{ $lesson->created_at?->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                    @endforelse

                    @if($recentEnrollments->isEmpty() && $recentLessons->isEmpty())
                        <div style="padding:24px;text-align:center;color:var(--muted);font-size:.85rem;">No recent activity yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ── 3-PANEL ROW ── --}}
    <div class="grid-3">
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Platform Overview</div>
                    <div class="card-head-sub">Content & Academic</div>
                </div>
            </div>
            <div class="card-body">
                <div class="rating-rows">
                    <div class="rating-row">
                        <div class="rating-label">Lessons</div>
                        <div class="rating-bar-wrap">
                            <div class="rating-fill"
                                style="width:{{ $totalLessons > 0 ? min(100, round($publishedLessons / $totalLessons * 100)) : 0 }}%;background:var(--gradient);">
                            </div>
                        </div>
                        <div class="rating-pct">{{ $totalLessons > 0 ? round($publishedLessons / $totalLessons * 100) : 0 }}%
                        </div>
                    </div>
                    <div class="rating-row">
                        <div class="rating-label">Completion</div>
                        <div class="rating-bar-wrap">
                            <div class="rating-fill"
                                style="width:{{ $overallCompletionRate }}%;background:linear-gradient(90deg,var(--green),var(--cyan));">
                            </div>
                        </div>
                        <div class="rating-pct">{{ $overallCompletionRate }}%</div>
                    </div>
                    <div class="rating-row">
                        <div class="rating-label">Enrollment</div>
                        <div class="rating-bar-wrap">
                            <div class="rating-fill"
                                style="width:{{ $totalStudents > 0 ? min(100, round($totalEnrollments / $totalStudents * 100)) : 0 }}%;background:linear-gradient(90deg,var(--blue),var(--purple));">
                            </div>
                        </div>
                        <div class="rating-pct">
                            {{ $totalStudents > 0 ? min(100, round($totalEnrollments / $totalStudents * 100)) : 0 }}%</div>
                    </div>
                    <div class="rating-row">
                        <div class="rating-label">Published</div>
                        <div class="rating-bar-wrap">
                            <div class="rating-fill"
                                style="width:{{ $totalLessons > 0 ? round($publishedLessons / $totalLessons * 100) : 0 }}%;background:linear-gradient(90deg,var(--gold),var(--red));">
                            </div>
                        </div>
                        <div class="rating-pct">{{ $publishedLessons }}</div>
                    </div>
                </div>
                <div style="margin-top:18px;display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div
                        style="text-align:center;padding:12px;background:var(--cream);border-radius:var(--radius-sm);border:1px solid var(--border);">
                        <div
                            style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--purple);">
                            {{ $totalExams }}</div>
                        <div style="font-size:0.7rem;color:var(--muted);">Exams</div>
                    </div>
                    <div
                        style="text-align:center;padding:12px;background:var(--cream);border-radius:var(--radius-sm);border:1px solid var(--border);">
                        <div
                            style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--gold);">
                            {{ $totalCertificates }}</div>
                        <div style="font-size:0.7rem;color:var(--muted);">Certificates</div>
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
                    @forelse($subjectPerformance as $i => $subject)
                        @php
                            $colors = ['var(--gradient)', 'linear-gradient(90deg,var(--purple),var(--blue))', 'linear-gradient(90deg,var(--blue),var(--cyan))', 'linear-gradient(90deg,var(--gold),var(--red))', 'linear-gradient(90deg,var(--green),var(--cyan))', 'linear-gradient(90deg,#DB2777,var(--purple))', 'linear-gradient(90deg,var(--red),var(--gold))'];
                        @endphp
                        <div class="rating-row">
                            <div class="rating-label">{{ Str::limit($subject->name, 10) }}</div>
                            <div class="rating-bar-wrap">
                                <div class="rating-fill"
                                    style="width:{{ $subject->avg_score }}%;background:{{ $colors[$i % count($colors)] }};">
                                </div>
                            </div>
                            <div class="rating-pct">{{ $subject->avg_score }}%</div>
                        </div>
                    @empty
                        @php
                            $demoSubjects = [['Quran', 96], ['Tajweed', 91], ['Arabic', 84], ['Fiqh', 79], ['Aqeedah', 86], ['Seerah', 88], ['Islamic St.', 77]];
                            $demoColors = ['var(--gradient)', 'linear-gradient(90deg,var(--purple),var(--blue))', 'linear-gradient(90deg,var(--blue),var(--cyan))', 'linear-gradient(90deg,var(--gold),var(--red))', 'linear-gradient(90deg,var(--green),var(--cyan))', 'linear-gradient(90deg,#DB2777,var(--purple))', 'linear-gradient(90deg,var(--red),var(--gold))'];
                        @endphp
                        @foreach($demoSubjects as $i => $s)
                            <div class="rating-row">
                                <div class="rating-label">{{ $s[0] }}</div>
                                <div class="rating-bar-wrap">
                                    <div class="rating-fill" style="width:{{ $s[1] }}%;background:{{ $demoColors[$i] }};"></div>
                                </div>
                                <div class="rating-pct">{{ $s[1] }}%</div>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Academic Calendar</div>
                    <div class="card-head-sub">{{ now()->format('F Y') }}</div>
                </div>
            </div>
            <div class="card-body">
                <div class="mini-cal">
                    <div class="cal-header">
                        <div class="cal-month">{{ now()->format('F Y') }}</div>
                    </div>
                    <div class="cal-grid">
                        <div class="cal-dow">Su</div>
                        <div class="cal-dow">Mo</div>
                        <div class="cal-dow">Tu</div>
                        <div class="cal-dow">We</div>
                        <div class="cal-dow">Th</div>
                        <div class="cal-dow">Fr</div>
                        <div class="cal-dow">Sa</div>
                        @php
                            $startDay = now()->startOfMonth()->dayOfWeek;
                            $daysInMonth = now()->daysInMonth;
                            $today = now()->day;
                            $prevDays = now()->startOfMonth()->subDays(1);
                        @endphp
                        @for($blank = 0; $blank < $startDay; $blank++)
                            <div class="cal-day other-month">{{ $prevDays->subDays($startDay - $blank - 1)->day }}</div>
                        @endfor
                        @for($d = 1; $d <= $daysInMonth; $d++)
                            <div class="cal-day {{ $d == $today ? 'today' : '' }}">{{ $d }}</div>
                        @endfor
                    </div>
                    @if($currentAcademicYear)
                        <div class="cal-events" style="margin-top:12px;">
                            <div class="cal-event ce-purple">
                                <div class="cal-event-name">{{ $currentAcademicYear->name }}</div>
                                <div class="cal-event-time">Current Year</div>
                            </div>
                            <div class="cal-event ce-gold">
                                <div class="cal-event-name">{{ $totalEnrollments }} Active Enrollments</div>
                                <div class="cal-event-time">This term</div>
                            </div>
                            @if($pendingEnrollments > 0)
                                <div class="cal-event ce-red">
                                    <div class="cal-event-name">{{ $pendingEnrollments }} Pending Approvals</div>
                                    <div class="cal-event-time">Action needed</div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ── SYSTEM HEALTH ── --}}
    <div class="card">
        <div class="card-head">
            <div class="card-head-left">
                <div class="card-head-title">System Overview</div>
                <div class="card-head-sub">Platform-wide metrics at a glance</div>
            </div>
            <div class="card-head-right">
                <div style="display:flex;align-items:center;gap:6px;font-size:0.74rem;color:var(--green);font-weight:600;">
                    <div class="sys-card-dot dot-green" style="animation:pulse-green 2s ease-in-out infinite;"></div>
                    All Systems Operational
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="sys-cards">
                <div class="sys-card">
                    <div class="sys-card-top">
                        <div class="sys-card-label"><i class="fas fa-user-graduate" style="margin-right:4px;"></i>Students
                        </div>
                        <div class="sys-card-status scs-ok">
                            <div class="sys-card-dot dot-green"></div> Active
                        </div>
                    </div>
                    <div class="sys-card-num">{{ $totalStudents }}</div>
                    <div class="sys-card-sub">{{ $totalEnrollments }} enrolled · {{ $pendingEnrollments }} pending</div>
                    <div class="sys-prog">
                        <div class="sys-prog-bar">
                            <div class="sys-prog-fill spf-green"
                                style="width:{{ $totalStudents > 0 ? min(100, round($totalEnrollments / $totalStudents * 100)) : 0 }}%;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sys-card">
                    <div class="sys-card-top">
                        <div class="sys-card-label"><i class="fas fa-book" style="margin-right:4px;"></i>Lessons</div>
                        <div class="sys-card-status scs-ok">
                            <div class="sys-card-dot dot-green"></div> Live
                        </div>
                    </div>
                    <div class="sys-card-num">{{ $publishedLessons }}</div>
                    <div class="sys-card-sub">{{ $publishedLessons }} of {{ $totalLessons }} published</div>
                    <div class="sys-prog">
                        <div class="sys-prog-bar">
                            <div class="sys-prog-fill spf-purple"
                                style="width:{{ $totalLessons > 0 ? round($publishedLessons / $totalLessons * 100) : 0 }}%;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sys-card">
                    <div class="sys-card-top">
                        <div class="sys-card-label"><i class="fas fa-chart-line" style="margin-right:4px;"></i>Progress
                        </div>
                        <div class="sys-card-status {{ $overallCompletionRate >= 70 ? 'scs-ok' : 'scs-warn' }}">
                            <div class="sys-card-dot {{ $overallCompletionRate >= 70 ? 'dot-green' : 'dot-gold' }}"></div>
                            {{ $overallCompletionRate >= 70 ? 'Good' : 'Growing' }}
                        </div>
                    </div>
                    <div class="sys-card-num">{{ $overallCompletionRate }}<span style="font-size:1rem;">%</span></div>
                    <div class="sys-card-sub">{{ $totalCompletions }} lessons completed by students</div>
                    <div class="sys-prog">
                        <div class="sys-prog-bar">
                            <div class="sys-prog-fill {{ $overallCompletionRate >= 70 ? 'spf-green' : 'spf-gold' }}"
                                style="width:{{ $overallCompletionRate }}%;"></div>
                        </div>
                    </div>
                </div>
                <div class="sys-card">
                    <div class="sys-card-top">
                        <div class="sys-card-label"><i class="fas fa-credit-card" style="margin-right:4px;"></i>Payments
                        </div>
                        <div class="sys-card-status {{ $pendingPayments > 0 ? 'scs-warn' : 'scs-ok' }}">
                            <div class="sys-card-dot {{ $pendingPayments > 0 ? 'dot-gold' : 'dot-green' }}"></div>
                            {{ $pendingPayments > 0 ? 'Pending' : 'Clear' }}
                        </div>
                    </div>
                    <div class="sys-card-num">{{ number_format($totalRevenue / 1000, 0) }}K</div>
                    <div class="sys-card-sub">UGX collected · {{ $pendingPayments }} pending</div>
                    <div class="sys-prog">
                        <div class="sys-prog-bar">
                            <div class="sys-prog-fill spf-purple" style="width:80%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── RECENT ENROLLMENTS + PAYMENTS ── --}}
    <div class="grid-2">
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Recent Enrollments</div>
                    <div class="card-head-sub">{{ $pendingEnrollments }} pending approval</div>
                </div>
                <a href="{{ route('admin.enrollments') }}" class="card-link">Manage <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div class="enroll-grid">
                    @php $avaClasses = ['ua-1', 'ua-2', 'ua-3', 'ua-4', 'ua-5', 'ua-6', 'ua-7', 'ua-8']; @endphp
                    @forelse($recentEnrollments->take(4) as $i => $enrollment)
                        @php
                            $status = $enrollment->status;
                            $badgeClass = match ($status) { 'active' => 'badge-active', 'pending' => 'badge-pending', 'rejected' => 'badge-inactive', default => 'badge-review'};
                            $statusLabel = match ($status) { 'active' => 'Active', 'pending' => 'Pending', 'rejected' => 'Rejected', default => 'Review'};
                        @endphp
                        <div class="enroll-card">
                            <div class="enroll-ava {{ $avaClasses[$i % 8] }}">
                                {{ strtoupper(substr($enrollment->student?->firstname ?? 'U', 0, 1) . substr($enrollment->student?->lastname ?? 'S', 0, 1)) }}
                            </div>
                            <div class="enroll-info">
                                <div class="enroll-name">{{ $enrollment->student?->firstname }}
                                    {{ $enrollment->student?->lastname }}</div>
                                <div class="enroll-class">{{ $enrollment->class?->name ?? 'Unknown class' }}</div>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:4px;align-items:flex-end;">
                                <div class="enroll-time">{{ $enrollment->created_at?->diffForHumans() }}</div>
                                <span class="badge {{ $badgeClass }}" style="font-size:0.62rem;">{{ $statusLabel }}</span>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column:span 2;text-align:center;padding:20px;color:var(--muted);">No recent
                            enrollments.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-head-title">Payment Overview</div>
                    <div class="card-head-sub">Financial summary · current period</div>
                </div>
                <a href="{{ route('admin.payments') }}" class="card-link">Finance <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="card-body">
                <div style="display:flex;justify-content:center;position:relative;height:150px;margin-bottom:16px;">
                    <canvas id="revenueDonut"></canvas>
                    <div
                        style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;flex-direction:column;pointer-events:none;">
                        <span
                            style="font-size:0.65rem;color:var(--muted);font-weight:600;letter-spacing:1px;text-transform:uppercase;">Collected</span>
                        <span
                            style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:800;color:var(--ink);line-height:1;">{{ $totalRevenue > 0 ? round($totalRevenue / ($totalRevenue + $overdueAmount + 1) * 100) : 0 }}%</span>
                    </div>
                </div>
                <div class="mini-tiles">
                    <div class="mini-tile">
                        <div class="mt-ico" style="color:var(--green);">💰</div>
                        <div class="mt-num" style="color:var(--green);">{{ number_format($totalRevenue / 1000, 0) }}K</div>
                        <div class="mt-label">UGX Collected</div>
                    </div>
                    <div class="mini-tile">
                        <div class="mt-ico" style="color:var(--red);">⏳</div>
                        <div class="mt-num" style="color:var(--red);">{{ $pendingPayments }}</div>
                        <div class="mt-label">Pending Payments</div>
                    </div>
                    <div class="mini-tile">
                        <div class="mt-ico" style="color:var(--gold);">🔔</div>
                        <div class="mt-num" style="color:var(--gold);">{{ $totalEnrollments }}</div>
                        <div class="mt-label">Active Students</div>
                    </div>
                    <div class="mini-tile">
                        <div class="mt-ico" style="color:var(--purple);">📊</div>
                        <div class="mt-num" style="color:var(--purple);">{{ $totalCertificates }}</div>
                        <div class="mt-label">Certificates Issued</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        Chart.defaults.font.family = 'DM Sans';
        Chart.defaults.color = '#6B6584';

        const tooltipStyle = {
            backgroundColor: '#0F0720',
            titleFont: { family: 'Playfair Display', size: 13, weight: 700 },
            bodyFont: { family: 'DM Sans', size: 12 },
            padding: 14, cornerRadius: 14, displayColors: true,
            borderColor: 'rgba(107,70,193,0.3)', borderWidth: 1,
        };

        // Real monthly data from controller
        const monthlyData = @json($monthlyData);
        const labels = monthlyData.map(d => d.label);
        const enrollments = monthlyData.map(d => d.enrollments);
        const completions = monthlyData.map(d => d.completions);
        const revenues = monthlyData.map(d => Math.round(d.revenue / 1000));

        (function () {
            const ctx = document.getElementById('mainChart').getContext('2d');
            const gPurp = ctx.createLinearGradient(0, 0, 0, 270);
            gPurp.addColorStop(0, 'rgba(107,70,193,0.28)');
            gPurp.addColorStop(1, 'rgba(107,70,193,0)');
            const gGreen = ctx.createLinearGradient(0, 0, 0, 270);
            gGreen.addColorStop(0, 'rgba(22,163,74,0.2)');
            gGreen.addColorStop(1, 'rgba(22,163,74,0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [
                        { label: 'Enrollments', data: enrollments, borderColor: '#6B46C1', backgroundColor: gPurp, borderWidth: 2.5, fill: true, tension: 0.42, pointBackgroundColor: '#6B46C1', pointRadius: 4, pointHoverRadius: 7, yAxisID: 'y' },
                        { label: 'Completions', data: completions, borderColor: '#16A34A', backgroundColor: gGreen, borderWidth: 2, fill: true, tension: 0.42, pointBackgroundColor: '#16A34A', pointRadius: 3, pointHoverRadius: 6, yAxisID: 'y' },
                        { label: 'Revenue (×1K UGX)', data: revenues, borderColor: '#D97706', backgroundColor: 'transparent', borderWidth: 2, fill: false, tension: 0.42, borderDash: [6, 4], pointBackgroundColor: '#D97706', pointRadius: 3, pointHoverRadius: 5, yAxisID: 'y1' },
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: { legend: { display: false }, tooltip: tooltipStyle },
                    scales: {
                        x: { grid: { color: 'rgba(107,70,193,0.06)' }, ticks: { font: { size: 11 } } },
                        y: { type: 'linear', position: 'left', grid: { color: 'rgba(107,70,193,0.06)' }, ticks: { font: { size: 11 } } },
                        y1: { type: 'linear', position: 'right', grid: { drawOnChartArea: false }, ticks: { font: { size: 11 }, callback: v => v + 'K' } }
                    }
                }
            });
        })();

        // Revenue donut
        (function () {
            const ctx = document.getElementById('revenueDonut').getContext('2d');
            const total = {{ $totalRevenue }};
            const pending = {{ $overdueAmount }};
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Collected', 'Pending/Failed'],
                    datasets: [{ data: [Math.max(total, 1), Math.max(pending, total > 0 ? 0 : 1)], backgroundColor: ['#16A34A', '#D97706'], borderColor: 'white', borderWidth: 3, hoverOffset: 6 }]
                },
                options: { responsive: false, cutout: '70%', plugins: { legend: { display: false }, tooltip: tooltipStyle }, width: 150, height: 150 }
            });
        })();

        function setPeriod(btn, period) {
            btn.closest('.pill-filters').querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
        }

        document.querySelectorAll('.kpi-card').forEach(card => {
            card.addEventListener('mouseenter', () => { const n = card.querySelector('.kpi-num'); if (n) { n.style.transform = 'scale(1.04)'; n.style.transition = 'transform 0.2s ease'; } });
            card.addEventListener('mouseleave', () => { const n = card.querySelector('.kpi-num'); if (n) n.style.transform = 'scale(1)'; });
        });
    </script>
@endsection