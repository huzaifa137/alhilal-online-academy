@extends('Student.layouts.sidebar')

@section('main-content')
    <style>
        /* Additional styles for lessons page - complements master layout */
        .lessons-container {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* THREE COLUMN GRID for Class Cards - NOW USING CSS GRID WITH 3 COLUMNS */
        .class-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
            margin-top: 16px;
        }

        /* Each class card becomes a vertical column card */
        .class-card {
            background: white;
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.25s ease;
            height: fit-content;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .class-card:hover {
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
            transform: translateY(-3px);
        }

        /* Class header - gradient */
        .class-header {
            background: linear-gradient(135deg, var(--purple-dark) 0%, var(--purple) 100%);
            padding: 20px 20px;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .class-header:hover {
            background: linear-gradient(135deg, var(--purple) 0%, var(--purple-light) 100%);
        }

        /* Class content scrollable */
        .class-content {
            display: none;
            background: var(--cream);
            padding: 8px 0 16px 0;
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Subject inside a card */
        .subject-section {
            border-bottom: 1px solid var(--border);
            background: white;
            margin: 8px 12px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .subject-header {
            padding: 14px 18px;
            background: #FFFFFF;
            cursor: pointer;
            transition: all 0.2s ease;
            border-left: 4px solid var(--purple);
            margin: 0;
        }

        .subject-header:hover {
            background: var(--cream);
            padding-left: 22px;
        }

        .subject-content {
            display: none;
            background: var(--cream2);
            padding: 8px 12px 16px 12px;
            border-top: 1px solid var(--border);
        }

        /* Topic section inside subject */
        .topic-section {
            padding: 14px 8px 8px 8px;
            margin-bottom: 12px;
            background: white;
            border-radius: 18px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .topic-title {
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            font-size: 0.95rem;
            padding-left: 8px;
        }

        .lesson-item:hover {
            background: white;
            border-color: var(--purple-light);
            transform: translateX(4px);
            box-shadow: 0 3px 10px rgba(107, 70, 193, 0.08);
        }

        .lesson-info {
            flex: 1;
        }

        .lesson-title {
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .lesson-meta {
            display: flex;
            gap: 12px;
            font-size: 0.7rem;
            color: var(--muted);
            flex-wrap: wrap;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-published {
            background: #C6F6D5;
            color: #22543D;
        }

        .badge-draft {
            background: #FEEBC8;
            color: #7B341E;
        }

        .badge-archived {
            background: #FED7D7;
            color: #742A2A;
        }

        .lesson-type-icon {
            width: 38px;
            height: 38px;
            background: white;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 14px;
            color: var(--purple);
            font-size: 1.1rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--purple);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 4px;
        }

        .btn-create {
            background: var(--gradient);
            color: white;
            padding: 12px 28px;
            border-radius: 40px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(107, 70, 193, 0.3);
            color: white;
        }

        .search-box {
            position: relative;
            margin-bottom: 28px;
            max-width: 500px;
        }

        .search-box input {
            width: 100%;
            padding: 14px 20px 14px 48px;
            border: 1px solid var(--border);
            border-radius: 48px;
            font-size: 0.9rem;
            background: white;
            transition: all 0.2s;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(107, 70, 193, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 32px;
            border: 1px solid var(--border);
            grid-column: 1 / -1;
        }

        .recent-lesson-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .recent-lesson-item:hover {
            padding-left: 8px;
            background: var(--cream);
        }

        /* Card for recent section */
        .card {
            background: white;
            border-radius: 28px;
            border: 1px solid var(--border);
            margin-bottom: 36px;
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            background: white;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-subtitle {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 6px;
        }

        .card-body {
            padding: 8px 20px 20px 20px;
        }

        .fa-chevron-down {
            transition: transform 0.25s ease;
        }

        /* Custom scrollbar */
        .class-content::-webkit-scrollbar {
            width: 5px;
        }

        .class-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .class-content::-webkit-scrollbar-thumb {
            background: var(--purple-light);
            border-radius: 10px;
        }

        /* Responsive: 2 columns on tablet, 1 column on mobile */
        @media (max-width: 1100px) {
            .class-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }
        }

        @media (max-width: 700px) {
            .class-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        /* Class Header */
        .class-header {
            background: linear-gradient(135deg, var(--purple-dark) 0%, var(--purple) 100%);
            padding: 18px 20px;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px 20px 0 0;
        }

        .class-header:hover {
            background: linear-gradient(135deg, var(--purple) 0%, var(--purple-light) 100%);
        }

        .class-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .class-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .class-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .class-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .class-name {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            color: white;
        }

        .class-level {
            font-size: 0.75rem;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .class-header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .subjects-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .chevron-icon {
            font-size: 0.9rem;
            transition: transform 0.25s ease;
            transform: rotate(-90deg);
        }

        .lesson-payment-box {
            margin-top: 6px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .lesson-price {
            background: #f1f5f9;
            color: #0f172a;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
        }

        .lesson-payment-status {
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 600;
        }

        /* Attention styles */
        .lesson-payment-status.not-paid {
            background: #fee2e2;
            color: #b91c1c;
            animation: pulse 1.5s infinite;
        }

        .lesson-payment-status.paid {
            background: #dcfce7;
            color: #166534;
        }

        /* subtle pulse animation */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(185, 28, 28, 0.4);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(185, 28, 28, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(185, 28, 28, 0);
            }
        }

        .lesson-item {
            display: flex;
            flex-direction: column;
            /* 🔥 THIS FIXES YOUR ISSUE */
            padding: 16px;
            margin-bottom: 12px;
            background: var(--cream2);
            border-radius: 16px;
            border: 1px solid var(--border);
            transition: all 0.25s ease;
            cursor: pointer;
            width: 100%;
        }

        .lesson-status-section {
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px dashed var(--border);
            display: flex;
            justify-content: flex-end;
            /* aligns to right */
        }

        .lesson-item:hover {
            background: white;
            border-color: var(--purple-light);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 70, 193, 0.1);
        }

        .lesson-main-content {
            display: flex;
            align-items: center;
            flex: 1;
            gap: 14px;
        }

        .lesson-icon-box {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--purple);
            font-size: 1.2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            flex-shrink: 0;
        }

        .lesson-icon {
            color: var(--purple);
        }

        .lesson-details {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }

        .lesson-title-text {
            font-size: 1rem;
            font-weight: 600;
            color: var(--ink);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .lesson-title-arabic {
            font-size: 0.85rem;
            color: var(--muted);
        }

        .lesson-meta-info {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 0.75rem;
            color: var(--muted);
        }

        .lesson-meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .meta-icon {
            font-size: 0.75rem;
        }

        .lesson-payment-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .lesson-price-box,
        .lesson-payment-status-box {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .lesson-price-box {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(107, 70, 193, 0.08);
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--purple);
        }

        .price-icon {
            font-size: 0.8rem;
        }

        .lesson-payment-status-box {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .lesson-payment-status-box.paid {
            background: rgba(72, 187, 120, 0.15);
            color: var(--success);
        }

        .lesson-payment-status-box.not-paid {
            background: rgba(237, 137, 54, 0.15);
            color: var(--warning);
        }

        .status-icon {
            font-size: 0.75rem;
        }

        .lesson-publish-status-box {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .lesson-publish-status-box.published {
            background: #C6F6D5;
            color: #22543D;
        }

        .lesson-publish-status-box.draft {
            background: #FEEBC8;
            color: #7B341E;
        }

        .publish-icon {
            font-size: 0.75rem;
        }

        /* Payment Modal Styles */
        .payment-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }

        .payment-modal-content {
            position: relative;
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 480px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease-out;
            overflow: hidden;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .payment-modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .payment-modal-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .close-modal {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .close-modal:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .payment-modal-body {
            padding: 24px;
        }

        .lesson-info-section {
            text-align: center;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .lesson-info-section h4 {
            color: #1f2937;
            margin: 0 0 12px 0;
            font-size: 1.1rem;
        }

        .amount-display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #f3f4f6;
            padding: 12px 20px;
            border-radius: 12px;
        }

        .amount-label {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .amount-value {
            color: #7c3aed;
            font-weight: 700;
            font-size: 1.3rem;
        }

        .payment-methods-section {
            margin-bottom: 24px;
        }

        .payment-methods-section h5 {
            color: #374151;
            margin: 0 0 12px 0;
            font-size: 0.95rem;
        }

        .payment-methods-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .payment-method-card {
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .payment-method-card:hover {
            border-color: #7c3aed;
            background: #f5f3ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.1);
        }

        .payment-method-card.selected {
            border-color: #7c3aed;
            background: #f5f3ff;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
        }

        .method-icon {
            font-size: 1.5rem;
            color: #7c3aed;
            margin-bottom: 8px;
        }

        .payment-method-card span {
            font-size: 0.85rem;
            color: #374151;
            font-weight: 500;
        }

        .selected-indicator {
            position: absolute;
            top: 8px;
            right: 8px;
            color: #7c3aed;
            font-size: 1.1rem;
            display: none;
        }

        .payment-method-card.selected .selected-indicator {
            display: block;
        }

        .payment-input-section {
            margin-bottom: 8px;
        }

        .payment-input-section label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .amount-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .currency-prefix {
            position: absolute;
            left: 16px;
            color: #6b7280;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .payment-amount-input {
            width: 100%;
            padding: 14px 16px 14px 60px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
            outline: none;
        }

        .payment-amount-input:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .amount-hint {
            display: block;
            margin-top: 6px;
            color: #9ca3af;
            font-size: 0.8rem;
        }

        .payment-modal-footer {
            padding: 20px 24px;
            background: #f9fafb;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            border-top: 1px solid #e5e7eb;
        }

        .btn-cancel {
            padding: 10px 20px;
            border: 2px solid #e5e7eb;
            background: white;
            color: #374151;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: #f3f4f6;
        }

        .btn-confirm-payment {
            padding: 10px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        }

        .btn-confirm-payment:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
        }

        .btn-confirm-payment:active {
            transform: translateY(0);
        }
        
    </style>

    <div class="lessons-container">

        <!-- HEADER + CREATE -->
        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; flex-wrap: wrap; gap: 18px;">
            <div>
                <h1
                    style="font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; color: var(--ink); margin-bottom: 4px;">
                    My Lessons
                </h1>
                <p style="color: var(--muted); font-size: 0.9rem;">
                    Manage and organize all your lesson content · Three column view
                </p>
            </div>
            <a href="{{ route('teacher.lessons.create') }}" class="btn-create">
                <i class="fas fa-plus-circle"></i> Create New Lesson
            </a>
        </div>

        <!-- SEARCH -->
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search lessons by title, class, subject, or topic...">
        </div>

        <!-- STATS CARDS -->
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 22px; margin-bottom: 38px;">
            <div class="stat-card">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div class="stat-number">{{ $totalLessons ?? 0 }}</div>
                        <div class="stat-label">Total Lessons</div>
                    </div>
                    <div
                        style="width: 48px; height: 48px; background: rgba(107, 70, 193, 0.1); border-radius: 18px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-book" style="color: var(--purple); font-size: 1.4rem;"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div class="stat-number" style="color: var(--success);">{{ $publishedLessons ?? 0 }}</div>
                        <div class="stat-label">Published Lessons</div>
                    </div>
                    <div
                        style="width: 48px; height: 48px; background: rgba(72, 187, 120, 0.1); border-radius: 18px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-globe" style="color: var(--success); font-size: 1.4rem;"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div class="stat-number" style="color: var(--warning);">{{ $draftLessons ?? 0 }}</div>
                        <div class="stat-label">Draft Lessons</div>
                    </div>
                    <div
                        style="width: 48px; height: 48px; background: rgba(237, 137, 54, 0.1); border-radius: 18px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-pen-fancy" style="color: var(--warning); font-size: 1.4rem;"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div class="stat-number">{{ count($groupedLessons ?? []) }}</div>
                        <div class="stat-label">Classes</div>
                    </div>
                    <div
                        style="width: 48px; height: 48px; background: rgba(107, 70, 193, 0.1); border-radius: 18px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users" style="color: var(--purple); font-size: 1.4rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- THREE COLUMN GRID FOR CLASS CARDS - NOW EXACTLY 3 COLUMNS -->
        @if (isset($groupedLessons) && count($groupedLessons) > 0)
            <div id="classGridContainer" class="class-grid">
                @foreach ($groupedLessons as $className => $classData)
                    <div class="class-card" data-classname="{{ strtolower($className) }}">
                        <div class="class-header" onclick="toggleClass(this)">
                            <div class="class-header-content">
                                <div class="class-header-left">
                                    <div class="class-icon">
                                        <i class="fas fa-chalkboard"></i>
                                    </div>
                                    <div class="class-info">
                                        <h3 class="class-name">{{ $className }}</h3>
                                        @if (isset($classData['level']) && $classData['level'])
                                            <span class="class-level">
                                                <i class="fas fa-graduation-cap"></i>
                                                {{ $classData['level'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="class-header-right">
                                    <span class="subjects-badge">
                                        <i class="fas fa-book"></i>
                                        {{ count($classData['subjects']) }} Subjects
                                    </span>
                                    <i class="fas fa-chevron-down chevron-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="class-content" style="display: none;">
                            @foreach ($classData['subjects'] as $subjectName => $subjectData)
                                <div class="subject-section">
                                    <div class="subject-header" onclick="toggleSubject(this)">
                                        <div
                                            style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                                            <div>
                                                <i class="fas fa-book-open"
                                                    style="color: var(--purple); margin-right: 10px;"></i>
                                                <span style="font-weight: 600;">{{ $subjectName }}</span>
                                                @if (isset($subjectData['subject_code']) && $subjectData['subject_code'])
                                                    <span
                                                        style="font-size: 0.7rem; color: var(--muted); margin-left: 8px;">({{ $subjectData['subject_code'] }})</span>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="badge-status"
                                                    style="background: var(--cream2); color: var(--purple);">
                                                    <i class="fas fa-layer-group"></i> {{ count($subjectData['topics']) }}
                                                    Topics
                                                </span>
                                                <i class="fas fa-chevron-down" style="margin-left: 8px;"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="subject-content" style="display: none;">
                                        @foreach ($subjectData['topics'] as $topicName => $topicData)
                                            <div class="topic-section">
                                                <div class="topic-title">
                                                    <i class="fas fa-folder-open" style="color: var(--purple-light);"></i>
                                                    <span>{{ $topicName }}</span>
                                                    <span class="badge-status" style="background: var(--cream2);">
                                                        <i class="fas fa-video"></i> {{ count($topicData['lessons']) }}
                                                        Lessons
                                                    </span>
                                                </div>
                                                @if (isset($topicData['topic_description']) && $topicData['topic_description'])
                                                    <p
                                                        style="font-size: 0.75rem; color: var(--muted); margin-bottom: 12px; padding-left: 8px;">
                                                        {{ Str::limit($topicData['topic_description'], 120) }}
                                                    </p>
                                                @endif

                                                <div style="padding-left: 6px;">
                                                    @foreach ($topicData['lessons'] as $lesson)
                                                        <div class="lesson-item"
                                                            @if (strtolower($lesson->lesson_payment_status) === 'paid') onclick="window.location.href='{{ route('teacher.lessons.show', $lesson) }}'"
            @else
                onclick="showPaymentModal({{ $lesson->id }}, '{{ $lesson->title }}', '{{ $lesson->lesson_amount }}')" @endif
                                                            style="{{ strtolower($lesson->lesson_payment_status) !== 'paid' ? '' : '' }}">

                                                            <!-- TOP CONTENT -->
                                                            <div class="lesson-main-content">
                                                                <div class="lesson-details">
                                                                    <h4 class="lesson-title-text">
                                                                        {{ $lesson->title }}
                                                                        @if (strtolower($lesson->lesson_payment_status) !== 'paid')
                                                                            <i class="fas fa-lock"
                                                                                style="color: #ff6b6b; font-size: 0.8rem; margin-left: 5px;"></i>
                                                                        @endif
                                                                    </h4>

                                                                    <div class="lesson-meta-info">
                                                                        <div class="lesson-meta-item">
                                                                            <i class="fas fa-hourglass-half meta-icon"></i>
                                                                            <span>{{ $lesson->duration ?? 'N/A' }}
                                                                                min</span>
                                                                        </div>

                                                                        <div class="lesson-meta-item">
                                                                            <i
                                                                                class="fas fa-sort-numeric-down meta-icon"></i>
                                                                            <span>Lesson {{ $lesson->lesson_order }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- BOTTOM SECTION -->
                                                            <div class="lesson-status-section">
                                                                <div class="lesson-payment-container">
                                                                    <div class="lesson-price-box">
                                                                        <i class="fas fa-money-bill-wave price-icon"></i>
                                                                        <span class="lesson-price-text">
                                                                            {{ $lesson->lesson_amount ? 'UGX ' . number_format((int) str_replace(',', '', $lesson->lesson_amount)) : 'Free' }}
                                                                        </span>
                                                                    </div>

                                                                    <div
                                                                        class="lesson-payment-status-box {{ strtolower($lesson->lesson_payment_status) }}">
                                                                        <i
                                                                            class="fas {{ strtolower($lesson->lesson_payment_status) === 'paid' ? 'fa-check-circle' : 'fa-exclamation-triangle' }} status-icon"></i>
                                                                        <span>{{ $lesson->lesson_payment_status ?? 'Not Paid' }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-book-open fa-4x" style="color: var(--purple-light); margin-bottom: 20px;"></i>
                <h3 style="font-size: 1.3rem; color: var(--ink); margin-bottom: 8px;">No Lessons Yet</h3>
                <p style="color: var(--muted); margin-bottom: 24px;">You haven't created any lessons. Start creating your
                    first lesson!</p>
                <a href="{{ route('teacher.lessons.create') }}" class="btn-create">
                    <i class="fas fa-plus-circle"></i> Create Your First Lesson
                </a>
            </div>
        @endif
    </div>


    <!-- Payment Modal -->
    <div id="paymentModal" class="payment-modal" style="display: none;">
        <div class="payment-modal-overlay" onclick="closePaymentModal()"></div>
        <div class="payment-modal-content">
            <div class="payment-modal-header">
                <h3><i class="fas fa-credit-card"></i> Complete Payment</h3>
                <button class="close-modal" onclick="closePaymentModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="payment-modal-body">
                <div class="lesson-info-section">
                    <h4 id="modalLessonTitle"></h4>
                    <div class="amount-display">
                        <span class="amount-label">Amount Required:</span>
                        <span class="amount-value" id="modalLessonAmount"></span>
                    </div>
                </div>

                <div class="payment-methods-section">
                    <h5>Select Payment Method</h5>
                    <div class="payment-methods-grid">
                        <div class="payment-method-card" onclick="selectPaymentMethod('mtn')" id="mtnCard">
                            <div class="method-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <span>MTN Mobile Money</span>
                            <div class="selected-indicator">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>

                        <div class="payment-method-card" onclick="selectPaymentMethod('airtel')" id="airtelCard">
                            <div class="method-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <span>Airtel Money</span>
                            <div class="selected-indicator">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>

                        <div class="payment-method-card" onclick="selectPaymentMethod('card')" id="cardCard">
                            <div class="method-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <span>Bank Card</span>
                            <div class="selected-indicator">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="payment-input-section">
                    <label for="paymentAmount">Enter Amount (UGX)</label>
                    <div class="amount-input-wrapper">
                        <span class="currency-prefix">UGX</span>
                        <input type="number" id="paymentAmount" class="payment-amount-input" placeholder="Enter amount"
                            min="0" step="1000">
                    </div>
                    <small class="amount-hint" id="amountHint"></small>
                </div>
            </div>

            <div class="payment-modal-footer">
                <button class="btn-cancel" onclick="closePaymentModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="btn-confirm-payment" onclick="confirmPayment()">
                    <i class="fas fa-check"></i> Confirm Payment
                </button>
            </div>
        </div>
    </div>


@endsection

@section('js')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let selectedPaymentMethod = null;
        let currentLessonId = null;
        let requiredAmount = null;

        function showPaymentModal(lessonId, lessonTitle, amount) {
            currentLessonId = lessonId;
            requiredAmount = parseInt(amount.replace(/[^0-9]/g, ''));

            document.getElementById('modalLessonTitle').textContent = lessonTitle;
            document.getElementById('modalLessonAmount').textContent = 'UGX ' + requiredAmount.toLocaleString();
            document.getElementById('paymentAmount').value = requiredAmount;
            document.getElementById('amountHint').textContent = `Minimum amount: UGX ${requiredAmount.toLocaleString()}`;

            // Reset selection
            selectedPaymentMethod = null;
            document.querySelectorAll('.payment-method-card').forEach(card => {
                card.classList.remove('selected');
            });

            document.getElementById('paymentModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function selectPaymentMethod(method) {
            selectedPaymentMethod = method;

            // Remove selected class from all cards
            document.querySelectorAll('.payment-method-card').forEach(card => {
                card.classList.remove('selected');
            });

            // Add selected class to clicked card
            document.getElementById(method + 'Card').classList.add('selected');
        }

        async function confirmPayment() {
            // Validate payment method selected
            if (!selectedPaymentMethod) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Payment Method Required',
                    text: 'Please select a payment method to continue.',
                    confirmButtonColor: '#7c3aed'
                });
                return;
            }

            // Get entered amount
            const enteredAmount = parseInt(document.getElementById('paymentAmount').value);

            // Validate amount
            if (!enteredAmount || enteredAmount <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Amount',
                    text: 'Please enter a valid amount.',
                    confirmButtonColor: '#7c3aed'
                });
                return;
            }

            // Check if amount is sufficient
            if (enteredAmount < requiredAmount) {
                Swal.fire({
                    icon: 'error',
                    title: 'Insufficient Amount',
                    text: `The amount entered (UGX ${enteredAmount.toLocaleString()}) is less than the required amount (UGX ${requiredAmount.toLocaleString()}). Please enter sufficient amount.`,
                    confirmButtonColor: '#dc2626'
                });
                return;
            }

            // Show confirmation dialog
            const result = await Swal.fire({
                title: 'Confirm Payment',
                html: `
            <div style="text-align: left;">
                <p><strong>Lesson:</strong> ${document.getElementById('modalLessonTitle').textContent}</p>
                <p><strong>Payment Method:</strong> ${getPaymentMethodName(selectedPaymentMethod)}</p>
                <p><strong>Amount:</strong> UGX ${enteredAmount.toLocaleString()}</p>
                ${enteredAmount > requiredAmount ? `<p style="color: #f59e0b;"><i class="fas fa-info-circle"></i> Note: You are paying more than the required amount. Change will be UGX ${(enteredAmount - requiredAmount).toLocaleString()}</p>` : ''}
            </div>
        `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#7c3aed',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Pay Now',
                cancelButtonText: 'Cancel'
            });

            if (result.isConfirmed) {
                // Show processing state
                Swal.fire({
                    title: 'Processing Payment...',
                    text: 'Please wait while we process your payment.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    // Send AJAX request to process payment
                    const response = await fetch('{{ route('teacher.lessons.process-payment') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            lesson_id: currentLessonId,
                            amount: enteredAmount,
                            payment_method: selectedPaymentMethod,
                            required_amount: requiredAmount
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful!',
                            text: data.message || 'Your payment has been processed successfully.',
                            confirmButtonColor: '#7c3aed'
                        }).then(() => {
                            // Reload the page to update the lesson status
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Payment Failed',
                            text: data.message || 'Something went wrong. Please try again.',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your payment. Please try again.',
                        confirmButtonColor: '#dc2626'
                    });
                }
            }
        }

        function getPaymentMethodName(method) {
            const methods = {
                'mtn': 'MTN Mobile Money',
                'airtel': 'Airtel Money',
                'card': 'Bank Card'
            };
            return methods[method] || method;
        }

        // Close modal when clicking overlay
        document.querySelector('.payment-modal-overlay').addEventListener('click', closePaymentModal);

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePaymentModal();
            }
        });
    </script>

    <script>
        // Toggle class sections (accordion)
        function toggleClass(element) {
            const parentCard = element.closest('.class-card');
            const content = parentCard.querySelector('.class-content');
            const icon = element.querySelector('.fa-chevron-down');

            if (content.style.display === 'none' || !content.style.display || getComputedStyle(content).display ===
                'none') {
                content.style.display = 'block';
                if (icon) icon.style.transform = 'rotate(0deg)';
            } else {
                content.style.display = 'none';
                if (icon) icon.style.transform = 'rotate(-90deg)';
            }
        }

        // Toggle subject sections
        function toggleSubject(element) {
            const subjectDiv = element.closest('.subject-section');
            const content = subjectDiv.querySelector('.subject-content');
            const icon = element.querySelector('.fa-chevron-down');

            if (content.style.display === 'none' || !content.style.display || getComputedStyle(content).display ===
                'none') {
                content.style.display = 'block';
                if (icon) icon.style.transform = 'rotate(0deg)';
            } else {
                content.style.display = 'none';
                if (icon) icon.style.transform = 'rotate(-90deg)';
            }
        }

        // Search functionality
        function initSearch() {
            const searchInput = document.getElementById('searchInput');
            if (!searchInput) return;

            searchInput.addEventListener('keyup', function() {
                const term = this.value.toLowerCase();
                const cards = document.querySelectorAll('.class-card');

                cards.forEach(card => {
                    const classAttr = card.getAttribute('data-classname') || '';
                    const lessonsInside = card.querySelectorAll('.lesson-item');
                    let anyMatch = false;

                    lessonsInside.forEach(lesson => {
                        const text = lesson.innerText.toLowerCase();
                        if (term === '' || text.includes(term) || classAttr.includes(term)) {
                            lesson.style.display = '';
                            anyMatch = true;
                        } else {
                            lesson.style.display = 'none';
                        }
                    });

                    if (anyMatch || term === '') {
                        card.style.display = '';
                        if (term !== '') {
                            const contentDiv = card.querySelector('.class-content');
                            if (contentDiv) contentDiv.style.display = 'block';
                            const allSubContents = card.querySelectorAll('.subject-content');
                            allSubContents.forEach(sc => sc.style.display = 'block');
                            const icons = card.querySelectorAll('.fa-chevron-down');
                            icons.forEach(ic => ic.style.transform = 'rotate(0deg)');
                        }
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }

        // Expand/Collapse All functions (optional)
        window.expandAll = function() {
            document.querySelectorAll('.class-content').forEach(el => el.style.display = 'block');
            document.querySelectorAll('.subject-content').forEach(el => el.style.display = 'block');
            document.querySelectorAll('.fa-chevron-down').forEach(icon => icon.style.transform = 'rotate(0deg)');
        };

        window.collapseAll = function() {
            document.querySelectorAll('.class-content').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.subject-content').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.fa-chevron-down').forEach(icon => icon.style.transform = 'rotate(-90deg)');
        };

        // Keyboard shortcut: Ctrl+Shift+F to focus search
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.shiftKey && e.key === 'F') {
                e.preventDefault();
                const searchBox = document.getElementById('searchInput');
                if (searchBox) searchBox.focus();
            }
        });

        // Initialize search on page load
        document.addEventListener('DOMContentLoaded', function() {
            initSearch();
        });
    </script>
@endsection
