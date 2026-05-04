@extends('Teacher.layouts.teacher-master')

@section('title', 'Settings')
@section('page-title', 'System Settings')
@section('breadcrumb', 'Settings')

@section('content')

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap"
        rel="stylesheet">

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
            --c-indigo: #4F46E5;
            --c-pink: #D946A8;
            --c-emerald: #059669;
            --c-amber: #D97706;
            --c-red: #DC2626;
            --c-red-lt: #FEE2E2;
            --c-green-lt: #D1FAE5;
            --radius-lg: 18px;
            --radius-xl: 24px;
            --radius-pill: 999px;
            --shadow-sm: 0 1px 3px rgba(91, 63, 217, .07), 0 1px 2px rgba(0, 0, 0, .04);
            --shadow-md: 0 4px 16px rgba(91, 63, 217, .10), 0 2px 6px rgba(0, 0, 0, .05);
            --shadow-lg: 0 12px 40px rgba(91, 63, 217, .14), 0 4px 12px rgba(0, 0, 0, .06);
        }

        /* ─── BASE ─────────────────────────────────── */
        .s-wrap {
            font-family: 'DM Sans', sans-serif;
            width: 100%;
            color: var(--c-ink);
        }

        /* ─── PAGE HEADER ───────────────────────────── */
        .s-page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .s-page-eyebrow {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--c-accent);
            margin-bottom: 6px;
        }

        .s-page-title {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--c-ink);
            line-height: 1.15;
            margin: 0;
        }

        .s-page-title em {
            font-style: italic;
            color: var(--c-accent);
        }

        .s-page-subtitle {
            margin-top: 6px;
            font-size: .83rem;
            color: var(--c-muted);
            font-weight: 400;
        }

        /* ─── STAT RAIL ─────────────────────────────── */
        .s-stat-rail {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
            margin-bottom: 28px;
        }

        .s-stat {
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-lg);
            padding: 20px 18px 18px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: border-color .22s, box-shadow .22s, transform .22s;
        }

        .s-stat::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            opacity: 0;
            background: linear-gradient(135deg, rgba(91, 63, 217, .06) 0%, transparent 70%);
            transition: opacity .22s;
        }

        .s-stat:hover {
            border-color: var(--c-accent);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .s-stat:hover::after {
            opacity: 1;
        }

        .s-stat.is-active {
            border-color: var(--c-accent);
            box-shadow: 0 0 0 3px rgba(91, 63, 217, .12), var(--shadow-md);
            background: linear-gradient(160deg, #EAE6FF 0%, #fff 60%);
        }

        .s-stat.is-active::after {
            opacity: 1;
        }

        .s-stat__dot {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin-bottom: 14px;
            position: relative;
            z-index: 1;
        }

        .s-stat__num {
            font-family: 'DM Serif Display', serif;
            font-size: 2rem;
            line-height: 1;
            color: var(--c-ink);
            position: relative;
            z-index: 1;
        }

        .s-stat__lbl {
            font-size: .73rem;
            font-weight: 600;
            color: var(--c-muted);
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: .06em;
            position: relative;
            z-index: 1;
        }

        /* active indicator bar */
        .s-stat::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            border-radius: 99px 0 0 99px;
            background: var(--c-accent);
            transform: scaleY(0);
            transform-origin: top;
            transition: transform .25s cubic-bezier(.4, 0, .2, 1);
        }

        .s-stat.is-active::before {
            transform: scaleY(1);
        }

        /* ─── MAIN CARD ─────────────────────────────── */
        .s-card {
            background: var(--c-surface);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .s-card-head {
            padding: 22px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 14px;
            border-bottom: 1.5px solid var(--c-border);
            background: var(--c-surface2);
        }

        .s-card-label {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .s-card-icon {
            width: 34px;
            height: 34px;
            background: var(--c-accent-lt);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--c-accent);
            font-size: .9rem;
            flex-shrink: 0;
        }

        .s-card-title {
            font-family: 'DM Serif Display', serif;
            font-size: 1.15rem;
            font-weight: 400;
            color: var(--c-ink);
            margin: 0;
        }

        .s-card-sub {
            font-size: .76rem;
            color: var(--c-muted);
            margin-top: 1px;
        }

        /* ─── BUTTON PRIMARY ────────────────────────── */
        .btn-add {
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
        }

        .btn-add:hover {
            background: #4930C2;
            box-shadow: 0 6px 20px rgba(91, 63, 217, .32);
            transform: translateY(-1px);
        }

        .btn-add:active {
            transform: translateY(0);
        }

        /* ─── TABLE ─────────────────────────────────── */
        .s-table-wrap {
            overflow-x: auto;
        }

        .s-table {
            width: 100%;
            border-collapse: collapse;
        }

        .s-table thead th {
            text-align: left;
            padding: 13px 20px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
            color: var(--c-muted);
            background: var(--c-surface2);
            border-bottom: 1.5px solid var(--c-border);
            white-space: nowrap;
        }

        .s-table tbody td {
            padding: 14px 20px;
            font-size: .84rem;
            color: var(--c-ink);
            border-bottom: 1px solid var(--c-border);
            vertical-align: middle;
        }

        .s-table tbody tr:last-child td {
            border-bottom: none;
        }

        .s-table tbody tr {
            transition: background .15s;
        }

        .s-table tbody tr:hover {
            background: var(--c-surface2);
        }

        /* ID chip */
        .id-chip {
            display: inline-block;
            background: var(--c-accent-lt);
            color: var(--c-accent);
            font-size: .68rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: var(--radius-pill);
        }

        /* ─── BADGES ────────────────────────────────── */
        .s-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 11px;
            border-radius: var(--radius-pill);
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .03em;
            text-transform: capitalize;
        }

        .s-badge .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .s-badge-active {
            background: var(--c-green-lt);
            color: var(--c-emerald);
        }

        .s-badge-active .dot {
            background: var(--c-emerald);
        }

        .s-badge-inactive {
            background: var(--c-red-lt);
            color: var(--c-red);
        }

        .s-badge-inactive .dot {
            background: var(--c-red);
        }

        .s-badge-published {
            background: var(--c-green-lt);
            color: var(--c-emerald);
        }

        .s-badge-published .dot {
            background: var(--c-emerald);
        }

        .s-badge-draft {
            background: #FEF3C7;
            color: var(--c-amber);
        }

        .s-badge-draft .dot {
            background: var(--c-amber);
        }

        .s-badge-archived {
            background: #F3F4F6;
            color: #6B7280;
        }

        .s-badge-archived .dot {
            background: #9CA3AF;
        }

        .s-badge-category {
            background: var(--c-accent-lt);
            color: var(--c-accent);
        }

        /* ─── ACTION BUTTONS ────────────────────────── */
        .s-actions {
            display: flex;
            gap: 6px;
        }

        .s-icon-btn {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            border: 1.5px solid var(--c-border);
            background: var(--c-surface);
            color: var(--c-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            transition: all .18s;
        }

        .s-icon-btn:hover {
            border-color: var(--c-accent);
            color: var(--c-accent);
            background: var(--c-accent-lt);
        }

        .s-icon-btn.del:hover {
            border-color: var(--c-red);
            color: var(--c-red);
            background: var(--c-red-lt);
        }

        /* ─── EMPTY STATE ───────────────────────────── */
        .s-empty {
            text-align: center;
            padding: 72px 40px;
        }

        .s-empty-ring {
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

        .s-empty p {
            color: var(--c-muted);
            font-size: .88rem;
            margin: 0;
        }

        /* ─── MODAL ─────────────────────────────────── */
        .s-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(26, 22, 40, .48);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .s-modal-overlay.active {
            display: flex;
        }

        .s-modal {
            background: var(--c-surface);
            border-radius: var(--radius-xl);
            width: min(520px, 92vw);
            max-height: 88vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            animation: modalIn .26s cubic-bezier(.34, 1.56, .64, 1);
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(24px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .s-modal-head {
            padding: 22px 24px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1.5px solid var(--c-border);
        }

        .s-modal-head-title {
            font-family: 'DM Serif Display', serif;
            font-size: 1.1rem;
            font-weight: 400;
            color: var(--c-ink);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .s-modal-head-icon {
            width: 30px;
            height: 30px;
            background: var(--c-accent-lt);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--c-accent);
            font-size: .82rem;
        }

        .s-modal-close {
            width: 30px;
            height: 30px;
            border: none;
            background: var(--c-surface2);
            border-radius: 8px;
            cursor: pointer;
            color: var(--c-muted);
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s, color .15s;
        }

        .s-modal-close:hover {
            background: var(--c-red-lt);
            color: var(--c-red);
        }

        .s-modal-body {
            padding: 24px;
        }

        .s-modal-foot {
            padding: 16px 24px;
            border-top: 1.5px solid var(--c-border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* ─── FORM FIELDS ───────────────────────────── */
        .fg {
            margin-bottom: 18px;
        }

        .fg label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: var(--c-ink);
            margin-bottom: 7px;
            letter-spacing: .01em;
        }

        .fg label span {
            color: var(--c-accent);
        }

        .fg input,
        .fg select,
        .fg textarea {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid var(--c-border);
            border-radius: 11px;
            font-family: 'DM Sans', sans-serif;
            font-size: .84rem;
            color: var(--c-ink);
            background: var(--c-surface);
            transition: border-color .18s, box-shadow .18s;
            box-sizing: border-box;
        }

        .fg input:focus,
        .fg select:focus,
        .fg textarea:focus {
            outline: none;
            border-color: var(--c-accent);
            box-shadow: 0 0 0 3px rgba(91, 63, 217, .13);
        }

        .fg input::placeholder,
        .fg textarea::placeholder {
            color: #C4BDD6;
        }

        .fg textarea {
            resize: vertical;
        }

        .fg input[type="color"] {
            height: 42px;
            padding: 4px 8px;
            cursor: pointer;
        }

        .fg-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* ─── MODAL BUTTONS ─────────────────────────── */
        .btn-cancel {
            display: inline-flex;
            align-items: center;
            padding: 9px 20px;
            border-radius: var(--radius-pill);
            border: 1.5px solid var(--c-border);
            background: var(--c-surface);
            color: var(--c-muted);
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s, border-color .15s;
        }

        .btn-cancel:hover {
            background: var(--c-surface2);
            border-color: var(--c-muted);
        }

        /* ─── NOTIFICATION ──────────────────────────── */
        .s-toast {
            position: fixed;
            top: 24px;
            right: 24px;
            padding: 13px 20px;
            border-radius: var(--radius-lg);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: .84rem;
            font-weight: 500;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 28px rgba(0, 0, 0, .18);
            animation: toastIn .3s cubic-bezier(.34, 1.36, .64, 1);
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .s-toast.success {
            background: var(--c-emerald);
        }

        .s-toast.error {
            background: var(--c-red);
        }

        /* ─── RESPONSIVE ────────────────────────────── */
        @media (max-width: 1100px) {
            .s-stat-rail {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 700px) {
            .s-stat-rail {
                grid-template-columns: repeat(2, 1fr);
            }

            .s-table thead {
                display: none;
            }

            .s-table tbody tr {
                display: block;
                border: 1.5px solid var(--c-border);
                border-radius: var(--radius-lg);
                margin: 12px 16px;
                padding: 8px 4px;
            }

            .s-table tbody td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 10px 14px;
                border-bottom: 1px solid var(--c-border);
            }

            .s-table tbody td:last-child {
                border-bottom: none;
            }

            .s-table tbody td::before {
                content: attr(data-label);
                font-size: .7rem;
                font-weight: 700;
                color: var(--c-muted);
                min-width: 90px;
            }

            .fg-row {
                grid-template-columns: 1fr;
            }

            .s-page-title {
                font-size: 1.5rem;
            }
        }
    </style>

    <div class="s-wrap">

        {{-- Page Header --}}
        <div class="s-page-header">
            <div>
                <div class="s-page-eyebrow">⚙ System Configuration</div>
                <h1 class="s-page-title">Settings <em>&amp; Data</em></h1>
                <div class="s-page-subtitle">Manage sections, levels, classes, subjects and topics</div>
            </div>
        </div>

        {{-- Stat Rail --}}
        <div class="s-stat-rail">
            <div class="s-stat" data-section="sections">
                <div class="s-stat__dot" style="background:#EAE6FF; color:#5B3FD9;">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="s-stat__num">{{ $stats['sections'] }}</div>
                <div class="s-stat__lbl">Sections</div>
            </div>
            <div class="s-stat" data-section="levels">
                <div class="s-stat__dot" style="background:#E0E7FF; color:#4F46E5;">
                    <i class="fas fa-level-up-alt"></i>
                </div>
                <div class="s-stat__num">{{ $stats['levels'] }}</div>
                <div class="s-stat__lbl">Levels</div>
            </div>
            <div class="s-stat" data-section="classes">
                <div class="s-stat__dot" style="background:#FCE7F3; color:#D946A8;">
                    <i class="fas fa-chalkboard"></i>
                </div>
                <div class="s-stat__num">{{ $stats['classes'] }}</div>
                <div class="s-stat__lbl">Classes</div>
            </div>
            <div class="s-stat" data-section="subjects">
                <div class="s-stat__dot" style="background:#D1FAE5; color:#059669;">
                    <i class="fas fa-book"></i>
                </div>
                <div class="s-stat__num">{{ $stats['subjects'] }}</div>
                <div class="s-stat__lbl">Subjects</div>
            </div>
            <div class="s-stat" data-section="topics">
                <div class="s-stat__dot" style="background:#FEF3C7; color:#D97706;">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="s-stat__num">{{ $stats['topics'] }}</div>
                <div class="s-stat__lbl">Topics</div>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="s-card">
            <div class="s-card-head">
                <div class="s-card-label">
                    <div class="s-card-icon" id="panel-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <div class="s-card-title" id="panel-title">Sections Management</div>
                        <div class="s-card-sub" id="panel-sub">Manage your sections</div>
                    </div>
                </div>
                <button class="btn-add" id="addNewBtn">
                    <i class="fas fa-plus"></i> Add New
                </button>
            </div>

            <div class="s-table-wrap" id="data-container">
                <div class="s-empty">
                    <div class="s-empty-ring"><i class="fas fa-database"></i></div>
                    <p>Loading data…</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Modal --}}
    <div id="itemModal" class="s-modal-overlay">
        <div class="s-modal">
            <div class="s-modal-head">
                <div class="s-modal-head-title">
                    <div class="s-modal-head-icon"><i class="fas fa-pen" id="modal-icon"></i></div>
                    <span id="modal-title">Add New Item</span>
                </div>
                <button class="s-modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="s-modal-body">
                <form id="itemForm">
                    <input type="hidden" id="item_id" name="item_id">
                    <div id="form-fields"></div>
                </form>
            </div>
            <div class="s-modal-foot">
                <button class="btn-cancel" onclick="closeModal()">
                    <i class="fas fa-times"></i> &nbsp; Cancel
                </button>

                <button class="btn-add" onclick="saveItem()">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentSection = 'sections';
        let currentData = [];

        const META = {
            sections: { title: 'Sections Management', sub: 'Manage academic sections', icon: 'fa-layer-group' },
            levels: { title: 'Levels Management', sub: 'Manage academic levels', icon: 'fa-level-up-alt' },
            classes: { title: 'Classes Management', sub: 'Manage class rooms', icon: 'fa-chalkboard' },
            subjects: { title: 'Subjects Management', sub: 'Manage subjects & courses', icon: 'fa-book' },
            topics: { title: 'Topics Management', sub: 'Manage learning topics', icon: 'fa-tag' },
        };

        document.addEventListener('DOMContentLoaded', function () {
            loadSection('sections');
            document.querySelectorAll('.s-stat').forEach(card => {
                card.addEventListener('click', function () {
                    document.querySelectorAll('.s-stat').forEach(c => c.classList.remove('is-active'));
                    this.classList.add('is-active');
                    loadSection(this.getAttribute('data-section'));
                });
            });
            document.querySelector('.s-stat[data-section="sections"]').classList.add('is-active');
        });

        function loadSection(section) {
            currentSection = section;
            const m = META[section];
            document.getElementById('panel-title').textContent = m.title;
            document.getElementById('panel-sub').textContent = m.sub;
            document.getElementById('panel-icon').innerHTML = `<i class="fas ${m.icon}"></i>`;

            fetch(`/teacher/settings/${section}`)
                .then(r => r.json())
                .then(data => { currentData = data; renderTable(section, data); });
        }

        function badgeClass(val) {
            const v = (val || '').toLowerCase();
            if (v === 'active') return 's-badge-active';
            if (v === 'inactive') return 's-badge-inactive';
            if (v === 'published') return 's-badge-published';
            if (v === 'draft') return 's-badge-draft';
            if (v === 'archived') return 's-badge-archived';
            return 's-badge-category';
        }

        function renderTable(section, data) {
            const box = document.getElementById('data-container');
            if (!data.length) {
                box.innerHTML = `<div class="s-empty">
                                            <div class="s-empty-ring"><i class="fas fa-inbox"></i></div>
                                            <p>No ${section} found. Click <strong>Add New</strong> to create one.</p>
                                        </div>`;
                return;
            }

            const cols = getColumns(section);
            let html = `<table class="s-table"><thead><tr>`;
            cols.forEach(c => { html += `<th>${c.label}</th>`; });
            html += `<th>Actions</th></tr></thead><tbody>`;

            data.forEach(item => {
                html += `<tr>`;
                cols.forEach(c => {
                    let val = getNestedValue(item, c.key);
                    if (c.type === 'id') {
                        val = `<span class="id-chip">#${val}</span>`;
                    } else if (c.type === 'status') {
                        const bc = badgeClass(val);
                        val = `<span class="s-badge ${bc}"><span class="dot"></span>${val || '—'}</span>`;
                    } else if (c.type === 'badge') {
                        val = `<span class="s-badge s-badge-category">${val || '—'}</span>`;
                    } else {
                        val = val || '<span style="color:var(--c-muted)">—</span>';
                    }
                    html += `<td data-label="${c.label}">${val}</td>`;
                });
                html += `<td data-label="Actions">
                                            <div class="s-actions">
                                                <button class="s-icon-btn" onclick="editItem(${item.id})" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <button class="s-icon-btn del" onclick="deleteItem(${item.id})" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td></tr>`;
            });

            html += `</tbody></table>`;
            box.innerHTML = html;
        }

        function getColumns(section) {
            const map = {
                sections: [
                    { label: 'ID', key: 'id', type: 'id' },
                    { label: 'Name', key: 'name', type: 'text' },
                    { label: 'Code', key: 'code', type: 'text' },
                    { label: 'Description', key: 'description', type: 'text' },
                    { label: 'Sort Order', key: 'sort_order', type: 'text' },
                    { label: 'Status', key: 'status', type: 'status' },
                ],
                levels: [
                    { label: 'ID', key: 'id', type: 'id' },
                    { label: 'Section', key: 'section.name', type: 'text' },
                    { label: 'Name', key: 'name', type: 'text' },
                    { label: 'Code', key: 'code', type: 'text' },
                    { label: 'Description', key: 'description', type: 'text' },
                    { label: 'Sort Order', key: 'sort_order', type: 'text' },
                    { label: 'Status', key: 'status', type: 'status' },
                ],
                classes: [
                    { label: 'ID', key: 'id', type: 'id' },
                    { label: 'Level', key: 'level.name', type: 'text' },
                    { label: 'Section', key: 'level.section.name', type: 'text' },
                    { label: 'Name', key: 'name', type: 'text' },
                    { label: 'Code', key: 'code', type: 'text' },
                    { label: 'Capacity', key: 'capacity', type: 'text' },
                    { label: 'Room', key: 'room_number', type: 'text' },
                    { label: 'Status', key: 'status', type: 'status' },
                ],
                subjects: [
                    { label: 'ID', key: 'id', type: 'id' },
                    { label: 'Section', key: 'section.name', type: 'text' },  // Added this line
                    { label: 'Name', key: 'name', type: 'text' },
                    { label: 'Arabic Name', key: 'name_arabic', type: 'text' },
                    { label: 'Code', key: 'code', type: 'text' },
                    { label: 'Category', key: 'category', type: 'badge' },
                    { label: 'Sort Order', key: 'sort_order', type: 'text' },
                    { label: 'Status', key: 'status', type: 'status' },
                ],
                topics: [
                    { label: 'ID', key: 'id', type: 'id' },
                    { label: 'Title', key: 'title', type: 'text' },
                    { label: 'Subject', key: 'subject.name', type: 'text' },
                    { label: 'Class', key: 'class.name', type: 'text' },
                    { label: 'Level', key: 'class.level.name', type: 'text' },
                    { label: 'Order', key: 'order_no', type: 'text' },
                    { label: 'Status', key: 'status', type: 'status' },
                ],
            };
            return map[section] || [];
        }

        function getNestedValue(obj, path) {
            return path.split('.').reduce((o, k) => o?.[k], obj);
        }

        function showAddModal() {
            const label = currentSection.slice(0, -1);
            document.getElementById('modal-title').textContent = `Add New ${label.charAt(0).toUpperCase() + label.slice(1)}`;
            document.getElementById('item_id').value = '';
            loadFormFields(currentSection, null);
            document.getElementById('itemModal').classList.add('active');
        }

        function editItem(id) {
            const item = currentData.find(i => i.id === id);
            if (!item) return;
            const label = currentSection.slice(0, -1);
            document.getElementById('modal-title').textContent = `Edit ${label.charAt(0).toUpperCase() + label.slice(1)}`;
            document.getElementById('item_id').value = id;
            loadFormFields(currentSection, item);
            document.getElementById('itemModal').classList.add('active');
        }

        async function loadFormFields(section, data) {
            const ff = document.getElementById('form-fields');

            const field = (label, name, type, val, opts = {}) => {
                const req = opts.required ? ' <span>*</span>' : '';
                if (type === 'textarea') {
                    return `<div class="fg"><label>${label}${req}</label><textarea name="${name}" rows="3"${opts.required ? ' required' : ''}>${val || ''}</textarea></div>`;
                }
                if (type === 'select') {
                    const options = (opts.options || []).map(o => `<option value="${o.value}" ${val == o.value ? 'selected' : ''}>${o.label}</option>`).join('');
                    return `<div class="fg"><label>${label}${req}</label><select name="${name}"${opts.required ? ' required' : ''}><option value="">Select ${label}</option>${options}</select></div>`;
                }
                if (type === 'color') {
                    return `<div class="fg"><label>${label}</label><input type="color" name="${name}" value="${val || '#5B3FD9'}"></div>`;
                }
                return `<div class="fg"><label>${label}${req}</label><input type="${type}" name="${name}" value="${val || ''}"${opts.placeholder ? ` placeholder="${opts.placeholder}"` : ''}${opts.required ? ' required' : ''}></div>`;
            };

            const statusOpts = { options: [{ value: 'active', label: 'Active' }, { value: 'inactive', label: 'Inactive' }] };

            if (section === 'sections') {
                ff.innerHTML =
                    field('Name', 'name', 'text', data?.name, { required: true }) +
                    field('Code', 'code', 'text', data?.code, { required: true }) +
                    field('Description', 'description', 'textarea', data?.description) +
                    `<div class="fg-row">` +
                    field('Sort Order', 'sort_order', 'number', data?.sort_order ?? 0) +
                    field('Status', 'status', 'select', data?.status ?? 'active', statusOpts) +
                    `</div>`;

            } else if (section === 'levels') {
                const secs = await fetch('/teacher/settings/sections').then(r => r.json());
                ff.innerHTML =
                    field('Section', 'section_id', 'select', data?.section_id, { required: true, options: secs.map(s => ({ value: s.id, label: s.name })) }) +
                    field('Name', 'name', 'text', data?.name, { required: true }) +
                    field('Code', 'code', 'text', data?.code, { required: true }) +
                    field('Description', 'description', 'textarea', data?.description) +
                    `<div class="fg-row">` +
                    field('Sort Order', 'sort_order', 'number', data?.sort_order ?? 0) +
                    field('Status', 'status', 'select', data?.status ?? 'active', statusOpts) +
                    `</div>`;

            } else if (section === 'classes') {
                const lvls = await fetch('/teacher/settings/levels').then(r => r.json());
                ff.innerHTML =
                    field('Level', 'level_id', 'select', data?.level_id, { required: true, options: lvls.map(l => ({ value: l.id, label: l.name })) }) +
                    `<div class="fg-row">` +
                    field('Name', 'name', 'text', data?.name, { required: true }) +
                    field('Code', 'code', 'text', data?.code, { required: true }) +
                    `</div>` +
                    `<div class="fg-row">` +
                    field('Capacity', 'capacity', 'number', data?.capacity) +
                    field('Room Number', 'room_number', 'text', data?.room_number) +
                    `</div>` +
                    field('Description', 'description', 'textarea', data?.description) +
                    field('Status', 'status', 'select', data?.status ?? 'active', statusOpts);

            } else if (section === 'subjects') {
                // Fetch sections for dropdown
                const sectionsRes = await fetch('/teacher/settings/sections');
                const sections = await sectionsRes.json();

                ff.innerHTML =
                    field('Section', 'section_id', 'select', data?.section_id, {
                        required: true,
                        options: sections.map(s => ({ value: s.id, label: s.name }))
                    }) +
                    `<div class="fg-row">` +
                    field('Name', 'name', 'text', data?.name, { required: true }) +
                    field('Name (Arabic)', 'name_arabic', 'text', data?.name_arabic) +
                    `</div>` +
                    `<div class="fg-row">` +
                    field('Code', 'code', 'text', data?.code, { required: true }) +
                    field('Category', 'category', 'text', data?.category) +
                    `</div>` +
                    field('Description', 'description', 'textarea', data?.description) +
                    `<div class="fg-row">` +
                    field('Icon (FontAwesome)', 'icon', 'text', data?.icon, { placeholder: 'fa-book' }) +
                    field('Color', 'color', 'color', data?.color) +
                    `</div>` +
                    `<div class="fg-row">` +
                    field('Sort Order', 'sort_order', 'number', data?.sort_order ?? 0) +
                    field('Status', 'status', 'select', data?.status ?? 'active', statusOpts) +
                    `</div>`;

            }

            else if (section === 'topics') {
                // Fetch all classes and subjects
                const [classesRes, allSubjectsRes] = await Promise.all([
                    fetch('/teacher/settings/classes'),
                    fetch('/teacher/settings/subjects')
                ]);

                const allClasses = await classesRes.json();
                const allSubjects = await allSubjectsRes.json();

                // We'll create dynamic filtering
                const topicStatusOpts = {
                    options: [
                        { value: 'published', label: 'Published' },
                        { value: 'draft', label: 'Draft' },
                        { value: 'archived', label: 'Archived' },
                    ]
                };

                // Build initial subjects list based on existing class selection
                let initialSubjects = allSubjects;
                if (data?.class_id) {
                    const selectedClass = allClasses.find(c => c.id == data.class_id);
                    if (selectedClass && selectedClass.level && selectedClass.level.section_id) {
                        initialSubjects = allSubjects.filter(s => s.section_id == selectedClass.level.section_id);
                    }
                }

                ff.innerHTML = `
                <div class="fg-row">
                    <div class="fg">
                        <label>Class <span>*</span></label>
                        <select id="topic_class_id" name="class_id" required onchange="filterSubjectsByClass()">
                            <option value="">Select Class</option>
                            ${allClasses.map(c => `<option value="${c.id}" ${data?.class_id == c.id ? 'selected' : ''} data-section-id="${c.level?.section_id || ''}">${c.name} (${c.level?.name || ''})</option>`).join('')}
                        </select>
                    </div>
                    <div class="fg">
                        <label>Subject <span>*</span></label>
                        <select id="topic_subject_id" name="subject_id" required>
                            <option value="">Select Subject</option>
                            ${initialSubjects.map(s => `<option value="${s.id}" ${data?.subject_id == s.id ? 'selected' : ''}>${s.name}</option>`).join('')}
                        </select>
                    </div>
                </div>
                <div class="fg-row">
                    ${field('Title', 'title', 'text', data?.title, { required: true })}
                    ${field('Title (Arabic)', 'title_arabic', 'text', data?.title_arabic)}
                </div>
                ${field('Description', 'description', 'textarea', data?.description)}
                ${field('Learning Objectives', 'learning_objectives', 'textarea', data?.learning_objectives)}
                <div class="fg-row">
                    ${field('Order Number', 'order_no', 'number', data?.order_no ?? 0)}
                    ${field('Status', 'status', 'select', data?.status ?? 'published', topicStatusOpts)}
                </div>
            `;
            }
        }

        // Function to filter subjects based on selected class
        window.filterSubjectsByClass = async function () {
            const classSelect = document.getElementById('topic_class_id');
            const subjectSelect = document.getElementById('topic_subject_id');

            if (!classSelect || !subjectSelect) return;

            const selectedClassId = classSelect.value;

            if (!selectedClassId) {
                subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                return;
            }

            try {
                // Fetch all classes to get section info
                const classesRes = await fetch('/teacher/settings/classes');
                const classes = await classesRes.json();
                const selectedClass = classes.find(c => c.id == selectedClassId);

                if (!selectedClass || !selectedClass.level) {
                    subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                    return;
                }

                const sectionId = selectedClass.level.section_id;

                // Fetch subjects filtered by section
                const subjectsRes = await fetch('/teacher/settings/subjects');
                const allSubjects = await subjectsRes.json();

                // Filter subjects by section_id
                const filteredSubjects = allSubjects.filter(s => s.section_id == sectionId);

                // Update subject dropdown
                let options = '<option value="">Select Subject</option>';
                filteredSubjects.forEach(subject => {
                    options += `<option value="${subject.id}">${subject.name}</option>`;
                });

                subjectSelect.innerHTML = options;

                // If editing and subject belongs to this section, keep selection
                const editingSubjectId = document.getElementById('itemForm').querySelector('[name="subject_id"]')?.value;
                if (editingSubjectId && filteredSubjects.some(s => s.id == editingSubjectId)) {
                    subjectSelect.value = editingSubjectId;
                }

            } catch (error) {
                console.error('Error filtering subjects:', error);
            }
        };

        function saveItem() {
            const id = document.getElementById('item_id').value;
            const form = document.getElementById('itemForm');
            const data = Object.fromEntries(new FormData(form).entries());
            const url = id ? `/teacher/settings/${currentSection}/${id}` : `/teacher/settings/${currentSection}`;
            const method = id ? 'PUT' : 'POST';

fetch(url, {
    method,
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json',
    },
    body: JSON.stringify(data),
})
.then(async (response) => {
    let res;

    try {
        res = await response.json();
    } catch (e) {
        const text = await response.text();
        toast('error', text || 'Invalid server response');
        return;
    }

    if (!response.ok) {
        if (res.errors) {
            const messages = Object.values(res.errors).flat().join('\n');
            toast('error', messages);
        } else {
            toast('error', res.message || 'Error occurred');
        }
        return;
    }

    closeModal();
    loadSection(currentSection);
    toast('success', res.message);
})
.catch((err) => {
    console.error('Fetch error:', err);
    toast('error', err.message || 'Network error');
});
        }

        function deleteItem(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to undo this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {

                    // 🔄 Show loading state
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait while we delete the item.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/teacher/settings/${currentSection}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                    })
                        .then(r => r.json())
                        .then(res => {

                            if (res.success) {
                                loadSection(currentSection);

                                // ✅ Success with OK button (no auto close)
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: res.message,
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#3085d6'
                                });

                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: res.message,
                                    confirmButtonText: 'OK'
                                });
                            }

                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong.',
                                confirmButtonText: 'OK'
                            });
                        });

                }
            });
        }

        function closeModal() {
            document.getElementById('itemModal').classList.remove('active');
        }

        function toast(type, msg) {
            const el = document.createElement('div');
            el.className = `s-toast ${type}`;
            el.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i> ${msg}`;
            document.body.appendChild(el);
            setTimeout(() => el.remove(), 3200);
        }

        document.getElementById('addNewBtn').addEventListener('click', showAddModal);
        document.getElementById('itemModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });
    </script>
@endsection