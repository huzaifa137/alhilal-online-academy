@extends('layouts.master2')

@section('css')
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            --border: rgba(107, 70, 193, 0.12);
            --border2: rgba(107, 70, 193, 0.22);
            --gradient: linear-gradient(135deg, var(--purple) 0%, var(--red) 100%);
            --gradient-soft: linear-gradient(135deg, #EDE9FA 0%, #FEE2E2 100%);
            --shadow-sm: 0 2px 12px rgba(107, 70, 193, 0.08);
            --shadow-md: 0 8px 32px rgba(107, 70, 193, 0.12);
            --shadow-lg: 0 20px 60px rgba(107, 70, 193, 0.16);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--ink);
            overflow-x: hidden;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: var(--purple-light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--purple);
            border-radius: 10px;
        }

        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.25s ease;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(107, 70, 193, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(107, 70, 193, 0.4);
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

        .btn-sm {
            padding: 8px 18px;
            font-size: 0.75rem;
        }

        /* Site Header */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 999;
            background: rgba(253, 251, 247, 0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .header-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            height: 70px;
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
            width: 42px;
            height: 42px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: var(--shadow-sm);
        }

        .header-logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--ink);
        }

        .header-logo-sub {
            font-size: 0.68rem;
            color: var(--muted);
        }

        .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        /* Profile Hero Section */
        .profile-hero {
            background: linear-gradient(135deg, #1A0A2E 0%, #2D0F5C 50%, #4A1A1A 100%);
            padding: 100px 0 60px;
            position: relative;
            overflow: hidden;
        }

        .profile-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 50%, rgba(107, 70, 193, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(220, 38, 38, 0.2) 0%, transparent 50%);
        }

        .profile-hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .profile-avatar-large {
            width: 120px;
            height: 120px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 4px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .profile-avatar-large span {
            font-size: 48px;
            font-weight: 700;
            color: white;
            font-family: 'Playfair Display', serif;
        }

        .profile-hero h1 {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
            font-family: 'Playfair Display', serif;
        }

        .profile-hero p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 16px;
        }

        .status-active {
            background: rgba(74, 222, 128, 0.15);
            border: 1px solid rgba(74, 222, 128, 0.3);
            color: #4ade80;
        }

        .status-banned {
            background: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #f87171;
        }

        .status-suspended {
            background: rgba(245, 158, 11, 0.15);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #fbbf24;
        }

        .status-locked {
            background: rgba(107, 114, 128, 0.15);
            border: 1px solid rgba(107, 114, 128, 0.3);
            color: #9ca3af;
        }

        /* Profile Main Content */
        .profile-main {
            padding: 60px 0 80px;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 32px;
        }

        /* Profile Card */
        .profile-card {
            background: white;
            border-radius: 28px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .profile-card-header {
            padding: 28px;
            text-align: center;
            border-bottom: 1px solid var(--border);
            background: var(--cream2);
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .profile-avatar span {
            font-size: 32px;
            font-weight: 700;
            color: white;
            font-family: 'Playfair Display', serif;
        }

        .profile-card-header h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--ink);
        }

        .profile-card-header p {
            font-size: 0.8rem;
            color: var(--muted);
        }

        .profile-card-body {
            padding: 24px;
        }

        .profile-info-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
        }

        .profile-info-row:last-child {
            border-bottom: none;
        }

        .profile-info-icon {
            width: 40px;
            height: 40px;
            background: var(--purple-light);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--purple);
            font-size: 1rem;
        }

        .profile-info-label {
            font-size: 0.7rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-info-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--ink);
        }

        .profile-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .stat-item {
            text-align: center;
            padding: 16px;
            background: var(--cream);
            border-radius: 20px;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            font-family: 'Playfair Display', serif;
            background: var(--gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .stat-label {
            font-size: 0.7rem;
            color: var(--muted);
            margin-top: 4px;
        }

        /* Details Card */
        .details-card {
            background: white;
            border-radius: 28px;
            border: 1px solid var(--border);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .details-header {
            padding: 24px 28px;
            background: var(--cream2);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .details-header h2 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--ink);
            font-family: 'Playfair Display', serif;
        }

        .details-body {
            padding: 28px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .info-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .info-field label {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-field .value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-field .value i {
            color: var(--purple);
            font-size: 0.9rem;
        }

        .full-width {
            grid-column: span 2;
        }

        .edit-section {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 80px;
            right: 24px;
            width: 46px;
            height: 46px;
            border-radius: 46px;
            background: var(--red);
            backdrop-filter: blur(8px);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background: var(--gradient);
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

        /* Bottom Nav */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 998;
            background: rgba(253, 251, 247, 0.97);
            backdrop-filter: blur(16px);
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-around;
            padding: 8px 0 12px;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            text-decoration: none;
            color: var(--muted);
            font-size: 0.65rem;
            font-weight: 500;
            flex: 1;
            transition: color 0.2s;
            cursor: pointer;
        }

        .nav-item i {
            font-size: 1.25rem;
            transition: transform 0.2s;
        }

        .nav-item:hover i {
            transform: translateY(-2px);
        }

        .nav-item.active {
            color: var(--purple);
            font-weight: 600;
        }

        .nav-item.nav-whatsapp {
            color: #25D366;
        }

        .nav-item.nav-whatsapp:hover {
            color: #128C7E;
        }

        /* Footer */
        .site-footer {
            background: var(--ink);
            color: rgba(255, 255, 255, 0.7);
            padding: 40px 0 30px;
            margin-top: 40px;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            text-align: center;
        }

        .footer-copyright {
            font-size: 0.78rem;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .profile-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: span 1;
            }

            .header-actions .btn-outline {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .profile-hero {
                padding: 80px 0 40px;
            }

            .profile-avatar-large {
                width: 90px;
                height: 90px;
            }

            .profile-avatar-large span {
                font-size: 36px;
            }

            .profile-hero h1 {
                font-size: 1.5rem;
            }

            .details-header {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Site Header -->
    <header class="site-header">
        <div class="header-inner">
            <a href="{{ url('/') }}" class="header-logo">
                <img src="{{ asset('assets/images/alhilal_logo.jpeg') }}" alt="Al-Hilal Online Academy">
                <div>
                    <div class="header-logo-text">Al-Hilal Online Academy</div>
                    <div class="header-logo-sub">Online Islamic Learning</div>
                </div>
            </a>
            <div class="header-actions">
                <a href="{{ url('/') }}" class="btn btn-outline btn-sm">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="{{ url('/users/logout') }}" class="btn btn-primary btn-sm" id="logoutLink">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('logoutLink').addEventListener('click', function(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you really want to sign out?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Sign out",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('user-logout') }}';
                }
            });
        });
    </script>

    <!-- Profile Hero Section -->
    <section class="profile-hero">
        <div class="container-custom">
            <div class="profile-hero-content">
                @php
                    $initial = strtoupper(substr($user->username ?? ($user->firstname ?? 'U'), 0, 1));
                    $fullName =
                        $user->fullname ??
                        ($user->firstname && $user->lastname
                            ? $user->firstname . ' ' . $user->lastname
                            : $user->username);
                @endphp
                <div class="profile-avatar-large">
                    <span>{{ $initial }}</span>
                </div>
                <h1>{{ $fullName }}</h1>
                <p>{{ $user->user_role == 1 ? 'Student Account' : 'Administrator Account' }}</p>

                @if ($user->account_status == 10)
                    <div class="status-badge status-active">
                        <i class="fas fa-check-circle"></i> Account Active
                    </div>
                @elseif($user->account_status == 0)
                    <div class="status-badge status-banned">
                        <i class="fas fa-ban"></i> Account Banned
                    </div>
                @elseif($user->account_status == 8)
                    <div class="status-badge status-locked">
                        <i class="fas fa-lock"></i> Account Locked
                    </div>
                @elseif($user->account_status == 9)
                    <div class="status-badge status-suspended">
                        <i class="fas fa-exclamation-triangle"></i> Account Suspended
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Profile Main Content -->
    <main class="profile-main">
        <div class="container-custom">
            <div class="profile-grid">
                <!-- Left Column - Profile Card -->
                <div class="profile-card">
                    <div class="profile-card-header">
                        <div class="profile-avatar">
                            <span>{{ $initial }}</span>
                        </div>
                        <h3>{{ $fullName }}</h3>
                        <p>Member since {{ $user->created_at ? date('F Y', strtotime($user->created_at)) : '2026' }}</p>
                    </div>
                    <div class="profile-card-body">
                        <div class="profile-info-row">
                            <div class="profile-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <div class="profile-info-label">Email Address</div>
                                <div class="profile-info-value">{{ $user->email ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <div class="profile-info-label">Phone Number</div>
                                <div class="profile-info-value">{{ $user->phonenumber ?? ($user->phone ?? '-') }}</div>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-icon">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div>
                                <div class="profile-info-label">Username</div>
                                <div class="profile-info-value">{{ $user->username ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-icon">
                                <i class="fas fa-flag"></i>
                            </div>
                            <div>
                                <div class="profile-info-label">Country / Region</div>
                                <div class="profile-info-value">{{ $user->country ?? 'Uganda' }}</div>
                            </div>
                        </div>

                        <div class="profile-stats">
                            <div class="stat-item">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Courses Enrolled</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">0</div>
                                <div class="stat-label">Certificates</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Details Card -->
                <div class="details-card">
                    <div class="details-header">
                        <h2><i class="fas fa-user-circle" style="color: var(--purple); margin-right: 8px;"></i> Personal
                            Information</h2>
                        <a href="{{ url('/student/edit-student-profile') }}" class="btn btn-outline btn-sm">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    </div>
                    <div class="details-body">
                        <div class="info-grid">
                            <div class="info-field">
                                <label>Full Name</label>
                                <div class="value">
                                    <i class="fas fa-user"></i>
                                    {{ $fullName }}
                                </div>
                            </div>
                            <div class="info-field">
                                <label>Username</label>
                                <div class="value">
                                    <i class="fas fa-at"></i>
                                    {{ $user->username ?? '-' }}
                                </div>
                            </div>
                            <div class="info-field">
                                <label>Email Address</label>
                                <div class="value">
                                    <i class="fas fa-envelope"></i>
                                    {{ $user->email ?? '-' }}
                                </div>
                            </div>
                            <div class="info-field">
                                <label>Phone Number</label>
                                <div class="value">
                                    <i class="fas fa-phone-alt"></i>
                                    {{ $user->phonenumber ?? ($user->phone ?? '-') }}
                                </div>
                            </div>
                            <div class="info-field">
                                <label>Gender</label>
                                <div class="value">
                                    <i class="fas fa-venus-mars"></i>
                                    {{ $user->gender ?? 'Not specified' }}
                                </div>
                            </div>
                            <div class="info-field">
                                <label>Account Type</label>
                                <div class="value">
                                    <i class="fas fa-graduation-cap"></i>
                                    {{ $user->user_role == 1 ? 'Student' : 'Administrator' }}
                                </div>
                            </div>
                            <div class="info-field full-width">
                                <label>Account Status</label>
                                <div class="value">
                                    @if ($user->account_status == 10)
                                        <span style="color: #4ade80;"><i class="fas fa-check-circle"></i> Active</span>
                                    @elseif($user->account_status == 0)
                                        <span style="color: #f87171;"><i class="fas fa-ban"></i> Banned</span>
                                    @elseif($user->account_status == 8)
                                        <span style="color: #9ca3af;"><i class="fas fa-lock"></i> Locked</span>
                                    @elseif($user->account_status == 9)
                                        <span style="color: #fbbf24;"><i class="fas fa-exclamation-triangle"></i>
                                            Suspended</span>
                                    @else
                                        <span>Unknown</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="edit-section">
                            <a href="{{ url('/student/edit-student-profile') }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Profile Information
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-copyright">
                <p>© {{ date('Y') }} Al-Hilal Online Academy. All rights reserved.</p>
                <p style="margin-top: 8px;">Dedicated to authentic Islamic education for all — P.1 through S.6</p>
            </div>
        </div>
    </footer>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ url('/') }}" class="nav-item"><i class="fas fa-home"></i><span>Home</span></a>
        <a href="{{ url('/users/home-page') }}#curriculum" class="nav-item"><i
                class="fas fa-layer-group"></i><span>Lessons</span></a>
        <a href="#" class="nav-item active"><i class="fas fa-user"></i><span>Profile</span></a>
        <a href="{{ url('/users/home-page') }}#contact" class="nav-item"><i
                class="fas fa-headset"></i><span>Support</span></a>
        <a href="https://wa.me/256702082209" class="nav-item nav-whatsapp"><i
                class="fab fa-whatsapp"></i><span>Chat</span></a>
    </nav>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTopBtn">
        <i class="fas fa-chevron-up"></i>
    </a>
@endsection

@section('js')
    <script>
        // Back to Top Button
        const backBtn = document.getElementById('backToTopBtn');
        window.addEventListener('scroll', () => {
            backBtn.classList.toggle('show', window.scrollY > 500);
        });
        backBtn.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Active nav highlight based on scroll
        const sections = document.querySelectorAll('section');
        const navItems = document.querySelectorAll('.nav-item');

        function updateNav() {
            let scrollPos = window.scrollY + 100;
            // For profile page, keep profile active
            navItems.forEach(n => n.classList.remove('active'));
            document.querySelector('.nav-item:nth-child(3)')?.classList.add('active');
        }
        window.addEventListener('scroll', updateNav);
    </script>
@endsection
