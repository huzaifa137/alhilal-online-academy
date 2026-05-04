{{-- resources/views/terms-and-conditions.blade.php --}}
@extends('layouts.master2')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
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
    --border: rgba(107,70,193,0.12);
    --border2: rgba(107,70,193,0.22);
    --gradient: linear-gradient(135deg, var(--purple) 0%, var(--red) 100%);
    --gradient-soft: linear-gradient(135deg, #EDE9FA 0%, #FEE2E2 100%);
    --shadow-sm: 0 2px 12px rgba(107,70,193,0.08);
    --shadow-md: 0 8px 32px rgba(107,70,193,0.12);
    --shadow-lg: 0 20px 60px rgba(107,70,193,0.16);
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--ink);
    overflow-x: hidden;
}

::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--purple-light); }
::-webkit-scrollbar-thumb { background: var(--purple); border-radius: 10px; }

/* Typography */
.font-display { font-family: 'Playfair Display', serif; }
h1, h2, h3, h4 { font-family: 'Playfair Display', serif; line-height: 1.2; }

/* Container */
.container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 28px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.25s ease;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    border: none;
}
.btn-primary {
    background: var(--gradient);
    color: white;
    box-shadow: 0 6px 20px rgba(107,70,193,0.35);
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(107,70,193,0.45);
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

/* Site Header */
.site-header {
    position: sticky;
    top: 0;
    z-index: 999;
    background: rgba(253,251,247,0.95);
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

/* Hero Section */
.terms-hero {
    background: linear-gradient(135deg, #1A0A2E 0%, #2D0F5C 50%, #4A1A1A 100%);
    padding: 80px 0 60px;
    position: relative;
    overflow: hidden;
}
.terms-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle at 20% 50%, rgba(107,70,193,0.3) 0%, transparent 50%),
                      radial-gradient(circle at 80% 50%, rgba(220,38,38,0.2) 0%, transparent 50%);
}
.terms-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}
.terms-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(8px);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.8rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 24px;
}
.terms-hero h1 {
    font-size: clamp(2.2rem, 5vw, 3.5rem);
    font-weight: 800;
    color: white;
    margin-bottom: 20px;
}
.terms-hero p {
    font-size: 1rem;
    color: rgba(255,255,255,0.7);
    line-height: 1.7;
}
.terms-hero .last-updated {
    margin-top: 24px;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.5);
}

/* Main Content */
.terms-main {
    padding: 60px 0 80px;
}
.terms-grid {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 48px;
}
.terms-sidebar {
    position: sticky;
    top: 90px;
    height: fit-content;
}
.sidebar-card {
    background: white;
    border-radius: 24px;
    padding: 24px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
}
.sidebar-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--gradient);
    display: inline-block;
}
.sidebar-nav {
    list-style: none;
}
.sidebar-nav li {
    margin-bottom: 12px;
}
.sidebar-nav a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    color: var(--muted);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    border-radius: 12px;
    transition: all 0.2s;
}
.sidebar-nav a i {
    width: 20px;
    font-size: 0.9rem;
    color: var(--purple);
}
.sidebar-nav a:hover {
    background: var(--purple-light);
    color: var(--purple);
}
.sidebar-nav a.active {
    background: var(--gradient);
    color: white;
}
.sidebar-nav a.active i {
    color: white;
}

/* Terms Content */
.terms-content {
    background: white;
    border-radius: 28px;
    border: 1px solid var(--border);
    overflow: hidden;
    box-shadow: var(--shadow-md);
}
.terms-section {
    padding: 40px 48px;
    border-bottom: 1px solid var(--border);
    scroll-margin-top: 90px;
}
.terms-section:last-child {
    border-bottom: none;
}
.section-icon {
    width: 56px;
    height: 56px;
    background: var(--gradient-soft);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}
.section-icon i {
    font-size: 1.6rem;
    background: var(--gradient);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.terms-section h2 {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 20px;
}
.terms-section h3 {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--ink2);
    margin: 24px 0 12px;
}
.terms-section p {
    font-size: 0.95rem;
    color: var(--muted);
    line-height: 1.8;
    margin-bottom: 16px;
}
.terms-section ul, .terms-section ol {
    margin: 16px 0 16px 24px;
}
.terms-section li {
    font-size: 0.95rem;
    color: var(--muted);
    line-height: 1.8;
    margin-bottom: 8px;
}
.terms-section .highlight-box {
    background: var(--cream2);
    border-left: 4px solid var(--red);
    padding: 20px 24px;
    border-radius: 16px;
    margin: 24px 0;
}
.terms-section .highlight-box p {
    margin-bottom: 0;
}
.terms-section .grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin: 24px 0;
}
.info-card {
    background: var(--cream);
    border-radius: 16px;
    padding: 20px;
    border: 1px solid var(--border);
}
.info-card i {
    font-size: 1.8rem;
    margin-bottom: 12px;
    display: block;
}
.info-card h4 {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 8px;
}
.info-card p {
    font-size: 0.85rem;
    margin-bottom: 0;
}

/* Action Buttons */
.terms-actions {
    margin-top: 48px;
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

/* Footer */
.site-footer {
    background: var(--ink);
    color: rgba(255,255,255,0.7);
    padding: 50px 0 30px;
}
.footer-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    text-align: center;
}
.footer-links {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}
.footer-links a {
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    font-size: 0.85rem;
    transition: color 0.2s;
}
.footer-links a:hover {
    color: white;
}
.footer-copyright {
    font-size: 0.78rem;
}

/* Responsive */
@media (max-width: 900px) {
    .terms-grid {
        grid-template-columns: 1fr;
    }
    .terms-sidebar {
        position: static;
        order: 2;
    }
    .sidebar-card {
        margin-top: 30px;
    }
    .terms-section {
        padding: 30px 24px;
    }
    .terms-section .grid-2 {
        grid-template-columns: 1fr;
    }
    .header-actions .btn-outline {
        display: none;
    }
}
@media (max-width: 600px) {
    .terms-section {
        padding: 24px 20px;
    }
    .terms-section h2 {
        font-size: 1.3rem;
    }
    .terms-actions {
        flex-direction: column;
        align-items: center;
    }
    .terms-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

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
@endsection

@section('content')

<!-- Header -->
<header class="site-header">
    <div class="header-inner">
        <a href="{{ url('/') }}" class="header-logo">
            <img src="{{ asset('assets/images/al-hilaal_update.png') }}" alt="Al-Hilaal Online Academy">
            <div>
                <div class="header-logo-text">Al-Hilaal Online Academy</div>
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

<!-- Hero Section -->
<section class="terms-hero">
    <div class="terms-hero-content">
        <div class="terms-badge">
            <i class="fas fa-scroll"></i>
            <span>Legal & Policies</span>
        </div>
        <h1>Terms and <span style="background: linear-gradient(135deg, #C084FC, #F87171); -webkit-background-clip: text; background-clip: text; color: transparent;">Policies</span></h1>
        <p>Welcome to Al-Hilaal Online Academy. By accessing our platform, you agree to these terms and conditions. Please read them carefully before using our services.</p>
        <div class="last-updated">
            <i class="fas fa-calendar-alt"></i> Last Updated: January 15, 2026
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="terms-main">
    <div class="container">
        <div class="terms-grid">
            <!-- Sidebar Navigation -->
            <aside class="terms-sidebar">
                <div class="sidebar-card">
                    <div class="sidebar-title">Quick Navigation</div>
                    <ul class="sidebar-nav">
                        <li><a href="#introduction" class="active"><i class="fas fa-home"></i> Introduction</a></li>
                        <li><a href="#using-services"><i class="fas fa-book"></i> Using Our Services</a></li>
                        <li><a href="#privacy"><i class="fas fa-lock"></i> Privacy Policy</a></li>
                        <li><a href="#copyright"><i class="fas fa-copyright"></i> Copyright</a></li>
                        <li><a href="#terms-conditions"><i class="fas fa-file-contract"></i> Terms & Conditions</a></li>
                        <li><a href="#account"><i class="fas fa-user-circle"></i> Account Responsibilities</a></li>
                        <li><a href="#payments"><i class="fas fa-credit-card"></i> Payments & Refunds</a></li>
                        <li><a href="#conduct"><i class="fas fa-gavel"></i> Code of Conduct</a></li>
                        <li><a href="#termination"><i class="fas fa-ban"></i> Termination</a></li>
                        <li><a href="#contact"><i class="fas fa-envelope"></i> Contact Us</a></li>
                    </ul>
                </div>
            </aside>

            <!-- Terms Content -->
            <div class="terms-content">
                <!-- Introduction -->
                <section id="introduction" class="terms-section">
                    <div class="section-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h2>Welcome to Al-Hilaal Online Academy</h2>
                    <p>Al-Hilaal Online Academy is a premier online Islamic educational platform dedicated to providing quality Islamic education to students from Primary 1 through Senior 6. Our mission is to make authentic Islamic learning accessible, engaging, and effective for every Muslim student.</p>
                    <p>By registering for and using our platform, you agree to be bound by these Terms and Policies. Please review them carefully. If you do not agree with any part of these terms, you may not use our services.</p>
                    <div class="highlight-box">
                        <p><strong>📖 Faith-Based Learning:</strong> Our curriculum is rooted in the Quran and Sunnah, following the teachings of Ahlus Sunnah wal Jama'ah. All content is reviewed by qualified Islamic scholars to ensure authenticity and accuracy.</p>
                    </div>
                </section>

                <!-- Using Our Services -->
                <section id="using-services" class="terms-section">
                    <div class="section-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h2>Using Our Services</h2>
                    <p>Al-Hilaal Online Academy provides a comprehensive learning management system (LMS) that includes:</p>
                    <ul>
                        <li><strong>📹 Video Lessons</strong> - Pre-recorded lectures by qualified Islamic teachers</li>
                        <li><strong>🎧 Audio Tracks</strong> - Audio versions of lessons for listening on the go</li>
                        <li><strong>📄 PDF Notes</strong> - Downloadable study materials in Arabic and English</li>
                        <li><strong>📝 Interactive Quizzes</strong> - Auto-graded assessments after each lesson</li>
                        <li><strong>📊 Progress Tracking</strong> - Detailed reports for students, parents, and teachers</li>
                        <li><strong>🎓 Certificates</strong> - Recognized certifications upon level completion</li>
                    </ul>
                    <p>You must follow all applicable policies made available to you within the Services. Don't misuse our Services — for example, don't interfere with our Services or try to access them using a method other than the interface and the instructions that we provide.</p>
                    <p>Using our Services does not give you ownership of any intellectual property rights in our Services or the content you access. You may not use content from our Services unless you obtain permission from its owner or are otherwise permitted by law.</p>
                </section>

                <!-- Privacy Policy -->
                <section id="privacy" class="terms-section">
                    <div class="section-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h2>Privacy Policy</h2>
                    <p>We take your privacy seriously. When you use our services, you're trusting us with your information. This Privacy Policy describes how we collect, use, and protect your personal data.</p>
                    
                    <div class="grid-2">
                        <div class="info-card">
                            <i class="fas fa-database" style="color: var(--purple);"></i>
                            <h4>Information We Collect</h4>
                            <p>Full name, username, email address, phone number, academic level, learning progress, quiz scores, and usage patterns.</p>
                        </div>
                        <div class="info-card">
                            <i class="fas fa-shield-alt" style="color: var(--red);"></i>
                            <h4>How We Protect Data</h4>
                            <p>We use industry-standard encryption, secure servers, and regular security audits to protect your information.</p>
                        </div>
                    </div>
                    
                    <p><strong>Data Usage:</strong> We collect data to personalize your learning experience, track progress, generate reports, and improve our platform. We do not sell or share your personal data with third parties without your explicit consent, except as required by law.</p>
                    <p><strong>Parental Access:</strong> For students under 18, parents or legal guardians have the right to access their child's learning data and progress reports through their own parent dashboard.</p>
                    <p>For a complete understanding, please review our full <a href="#" style="color: var(--red); text-decoration: none; font-weight: 500;">Privacy Policy document</a>.</p>
                </section>

                <!-- Copyright -->
                <section id="copyright" class="terms-section">
                    <div class="section-icon">
                        <i class="fas fa-copyright"></i>
                    </div>
                    <h2>Copyright & Intellectual Property</h2>
                    <p>All content provided on this platform, including but not limited to:</p>
                    <ul>
                        <li>Video lectures and audio recordings</li>
                        <li>PDF notes, study guides, and worksheets</li>
                        <li>Quiz questions, assessments, and answer keys</li>
                        <li>Graphics, logos, and design elements</li>
                        <li>Course structures and curriculum layouts</li>
                    </ul>
                    <p>is the exclusive property of Al-Hilaal Online Academy or its content contributors and is protected by international copyright laws and Islamic ethical guidelines regarding knowledge sharing.</p>
                    <div class="highlight-box">
                        <p><strong>⚠️ Prohibited Actions:</strong> You may not reproduce, distribute, modify, create derivative works from, publicly display, or sell any content from our platform without explicit written permission from Al-Hilaal Online Academy.</p>
                    </div>
                    <p><strong>Personal Use Exception:</strong> You may download PDF notes for your personal study and offline revision. You may not share these materials with non-registered users or upload them to any other platform.</p>
                </section>

                <!-- Terms and Conditions -->
                <section id="terms-conditions" class="terms-section">
                    <div class="section-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h2>Terms and Conditions</h2>
                    <p>By registering on and using our platform, you agree to the following binding terms:</p>
                    <ul>
                        <li><strong>Age Requirement:</strong> You must be at least 13 years old to create an account. Students under 13 must have parental consent and a parent/guardian account linked to their profile.</li>
                        <li><strong>Account Responsibility:</strong> You are fully responsible for maintaining the confidentiality of your account credentials (username and password).</li>
                        <li><strong>Accurate Information:</strong> You agree to provide accurate, current, and complete information during registration and to update it as necessary.</li>
                        <li><strong>Single Account:</strong> Each user may maintain only one active account. Multiple accounts for the same individual are prohibited.</li>
                        <li><strong>Non-Transferable:</strong> Your account and subscription are non-transferable. You may not share your login credentials with others.</li>
                        <li><strong>Respect for Scholars:</strong> You agree to show proper respect to all teachers, scholars, and fellow students in all platform interactions.</li>
                        <li><strong>No Commercial Use:</strong> Our platform is for personal educational use only. Commercial use of any content or feature is strictly prohibited.</li>
                        <li><strong>Modification Rights:</strong> We reserve the right to modify, suspend, or discontinue any feature, course, or service without prior notice.</li>
                    </ul>
                </section>

                <!-- Account Responsibilities -->
                <section id="account" class="terms-section">
                    <div class="section-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h2>Account Responsibilities</h2>
                    <p>As a registered user of Al-Hilaal Online Academy, you agree to:</p>
                    <ul>
                        <li><strong>Secure Your Account:</strong> Keep your password confidential and notify us immediately of any unauthorized access to your account.</li>
                        <li><strong>Complete Lessons Honestly:</strong> Complete quizzes and assessments independently without external help to ensure accurate progress tracking.</li>
                        <li><strong>Parental Supervision:</strong> For minor students, parents should actively monitor their child's learning progress through the parent dashboard.</li>
                        <li><strong>Report Issues:</strong> Promptly report any technical issues, inappropriate content, or policy violations to our support team.</li>
                        <li><strong>Respect Learning Pace:</strong> While you can learn at your own pace, we encourage consistent engagement to achieve learning objectives.</li>
                    </ul>
                    <p><strong>Account Types:</strong> Our platform supports three account types — Student (for learners), Parent (to monitor child's progress), and Teacher (to manage classes and assessments). Each account type has specific permissions and responsibilities.</p>
                </section>

                <!-- Payments & Refunds -->
                <section id="payments" class="terms-section">
                    <div class="section-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h2>Payments & Refunds</h2>
                    <p>Al-Hilaal Online Academy offers both free and paid learning options:</p>
                    <ul>
                        <li><strong>Free Access:</strong> Basic access to select lessons and sample materials is available at no cost.</li>
                        <li><strong>Premium Subscription:</strong> Full access to all lessons, quizzes, progress tracking, and certificates requires a paid subscription.</li>
                        <li><strong>Payment Methods:</strong> We accept mobile money (MTN, Airtel), bank transfers, and credit/debit cards for Ugandan and international students.</li>
                        <li><strong>Billing Cycle:</strong> Subscriptions are billed monthly or annually based on your selected plan. Payments are non-refundable except as required by law.</li>
                        <li><strong>Cancellation:</strong> You may cancel your subscription at any time. Access will continue until the end of your current billing period.</li>
                        <li><strong>Refund Policy:</strong> We do not offer refunds for partially used subscription periods. However, we may provide refunds on a case-by-case basis for technical issues that prevented access.</li>
                    </ul>
                    <div class="highlight-box">
                        <p><strong>💡 Need-Based Scholarships:</strong> Al-Hilaal Online Academy offers limited need-based scholarships for deserving students. Contact our admissions team for more information.</p>
                    </div>
                </section>

                <!-- Code of Conduct -->
                <section id="conduct" class="terms-section">
                    <div class="section-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <h2>Islamic Code of Conduct</h2>
                    <p>As an Islamic educational platform, we expect all users to adhere to Islamic ethical standards:</p>
                    <ul>
                        <li><strong>Respectful Communication:</strong> Use kind, respectful language in all interactions with teachers and fellow students. Avoid backbiting, insults, or offensive speech.</li>
                        <li><strong>Academic Honesty:</strong> Complete all quizzes and assessments independently. Do not share answers or cheat in any form.</li>
                        <li><strong>Modest Appearance:</strong> If participating in live sessions or video submissions, dress modestly according to Islamic guidelines.</li>
                        <li><strong>No Disruptive Behavior:</strong> Do not spam, post irrelevant content, or disrupt the learning environment for others.</li>
                        <li><strong>Respect Prayer Times:</strong> We encourage students to pause learning during obligatory prayer times.</li>
                        <li><strong>Proper Intentions (Niyyah):</strong> Approach your learning with sincere intention to gain beneficial knowledge for the sake of Allah.</li>
                    </ul>
                    <p>Violation of this code of conduct may result in warnings, temporary suspension, or permanent account termination at our discretion.</p>
                </section>

                <!-- Termination -->
                <section id="termination" class="terms-section">
                    <div class="section-icon">
                        <i class="fas fa-ban"></i>
                    </div>
                    <h2>Termination of Access</h2>
                    <p>We reserve the right to suspend or terminate your account under the following circumstances:</p>
                    <ul>
                        <li><strong>Policy Violations:</strong> Engaging in activities that violate these Terms and Policies.</li>
                        <li><strong>Academic Dishonesty:</strong> Cheating on quizzes, sharing answers, or misrepresenting progress.</li>
                        <li><strong>Unauthorized Sharing:</strong> Sharing copyrighted content or login credentials with non-registered users.</li>
                        <li><strong>Disruptive Behavior:</strong> Harassing other users, posting inappropriate content, or disrupting platform operations.</li>
                        <li><strong>Non-Payment:</strong> Failure to pay subscription fees for premium access accounts.</li>
                    </ul>
                    <div class="highlight-box">
                        <p><strong>📋 Appeal Process:</strong> If your account has been terminated, you may contact our support team to appeal the decision. Appeals will be reviewed within 5-7 business days.</p>
                    </div>
                </section>

                <!-- Contact -->
                <section id="contact" class="terms-section">
                    <div class="section-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h2>Contact Us</h2>
                    <p>If you have any questions, concerns, or requests regarding these Terms and Policies, please reach out to us:</p>
                    
                    <div class="grid-2">
                        <div class="info-card">
                            <i class="fas fa-phone-alt" style="color: var(--purple);"></i>
                            <h4>Phone / WhatsApp</h4>
                            <p>+256 702 082 209</p>
                        </div>
                        <div class="info-card">
                            <i class="fas fa-envelope" style="color: var(--red);"></i>
                            <h4>Email</h4>
                            <p>info@alhilalacademy.org</p>
                        </div>
                        <div class="info-card">
                            <i class="fas fa-map-marker-alt" style="color: var(--gold);"></i>
                            <h4>Address</h4>
                            <p>Kampala, Uganda</p>
                        </div>
                        <div class="info-card">
                            <i class="fab fa-whatsapp" style="color: #25D366;"></i>
                            <h4>Live Chat</h4>
                            <p>Available 9 AM - 6 PM (EAT)</p>
                        </div>
                    </div>
                    
                    <p>We aim to respond to all inquiries within 24 hours during business days (Monday through Friday, excluding Islamic holidays).</p>
                </section>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="terms-actions">
            <a href="{{ url('/users/register') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> I Agree - Create Account
            </a>
            <a href="{{ url('/') }}" class="btn btn-outline">
                <i class="fas fa-home"></i> Return to Homepage
            </a>
            <a href="https://wa.me/256702082209" class="btn btn-outline">
                <i class="fab fa-whatsapp"></i> Questions? Chat with Us
            </a>
        </div>
    </div>
</main>

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

<!-- Footer -->
<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/users/login') }}">Login</a>
            <a href="{{ url('/users/register') }}">Register</a>
            <a href="#contact">Contact</a>
            <a href="#">Privacy Policy</a>
            <a href="#">FAQ</a>
        </div>
        <div class="footer-copyright">
            <p>© {{ date('Y') }} Al-Hilaal Online Academy. All rights reserved.</p>
            <p style="margin-top: 8px;">Dedicated to authentic Islamic education for all — P.1 through S.6</p>
        </div>
    </div>
</footer>

@endsection

@section('js')
<script>
// Active sidebar navigation on scroll
const sections = document.querySelectorAll('.terms-section');
const navLinks = document.querySelectorAll('.sidebar-nav a');

function updateActiveNav() {
    let current = '';
    const scrollPosition = window.scrollY + 120;
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionBottom = sectionTop + section.offsetHeight;
        
        if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        const href = link.getAttribute('href').substring(1);
        if (href === current) {
            link.classList.add('active');
        }
    });
}

window.addEventListener('scroll', updateActiveNav);
window.addEventListener('load', updateActiveNav);

// Smooth scroll for sidebar links
navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href').substring(1);
        const targetSection = document.getElementById(targetId);
        
        if (targetSection) {
            targetSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>
@endsection