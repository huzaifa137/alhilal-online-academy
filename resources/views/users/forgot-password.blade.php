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
    --cream: #FDFBF7;
    --cream2: #F7F3EE;
    --ink: #1A0A2E;
    --ink2: #3B2459;
    --muted: #6B6584;
    --border: rgba(107,70,193,0.12);
    --border2: rgba(107,70,193,0.22);
    --gradient: linear-gradient(135deg, var(--purple) 0%, var(--red) 100%);
    --shadow-sm: 0 2px 12px rgba(107,70,193,0.08);
    --shadow-md: 0 8px 32px rgba(107,70,193,0.14);
    --shadow-lg: 0 20px 60px rgba(107,70,193,0.18);
}

*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; height: 100%; }

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--ink);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* ── PAGE LAYOUT ── */
.fp-wrapper {
    flex: 1;
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 100vh;
}

/* ── LEFT PANEL ── */
.fp-left {
    position: relative;
    background: linear-gradient(145deg, #1A0A2E 0%, #2D1060 45%, #4A1020 100%);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 60px 56px;
    overflow: hidden;
}

/* Geometric patterns */
.fp-left-pattern {
    position: absolute; inset: 0;
    opacity: 0.035;
    background-image:
        repeating-linear-gradient(0deg, transparent, transparent 40px, rgba(255,255,255,0.6) 40px, rgba(255,255,255,0.6) 41px),
        repeating-linear-gradient(90deg, transparent, transparent 40px, rgba(255,255,255,0.6) 40px, rgba(255,255,255,0.6) 41px);
}
.fp-left-orb-1 {
    position: absolute;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(107,70,193,0.4) 0%, transparent 65%);
    top: -180px; right: -180px;
    pointer-events: none;
}
.fp-left-orb-2 {
    position: absolute;
    width: 350px; height: 350px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(220,38,38,0.3) 0%, transparent 65%);
    bottom: -120px; left: -100px;
    pointer-events: none;
}
.fp-left-orb-3 {
    position: absolute;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
}

/* Back link */
.fp-back-link {
    position: absolute;
    top: 32px; left: 40px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    font-size: 0.82rem;
    font-weight: 500;
    transition: color 0.2s;
    z-index: 10;
}
.fp-back-link:hover { color: white; }
.fp-back-link i { font-size: 0.75rem; }

/* Left content */
.fp-left-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 400px;
}

.fp-left-icon-wrap {
    position: relative;
    width: 110px; height: 110px;
    margin: 0 auto 36px;
}
.fp-left-icon-ring {
    position: absolute; inset: 0;
    border-radius: 50%;
    border: 1.5px solid rgba(255,255,255,0.12);
    animation: ring-pulse 3s ease-in-out infinite;
}
.fp-left-icon-ring-2 {
    position: absolute;
    inset: -14px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.06);
    animation: ring-pulse 3s ease-in-out infinite 0.8s;
}
@keyframes ring-pulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.05); }
}
.fp-left-icon-circle {
    width: 110px; height: 110px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    border: 1.5px solid rgba(255,255,255,0.15);
    display: flex; align-items: center; justify-content: center;
    position: relative; z-index: 2;
}
.fp-left-icon-circle i {
    font-size: 2.5rem;
    background: var(--gradient);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.fp-left-content h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.9rem;
    font-weight: 700;
    color: white;
    line-height: 1.2;
    margin-bottom: 14px;
}
.fp-left-content p {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.6);
    line-height: 1.75;
    margin-bottom: 36px;
}

/* Steps */
.fp-steps {
    display: flex;
    flex-direction: column;
    gap: 16px;
    text-align: left;
    width: 100%;
}
.fp-step {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 14px 18px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    transition: background 0.2s;
}
.fp-step:hover { background: rgba(255,255,255,0.08); }
.fp-step-num {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: var(--gradient);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.72rem;
    font-weight: 700;
    color: white;
    flex-shrink: 0;
    margin-top: 1px;
}
.fp-step-text h5 {
    font-size: 0.85rem;
    font-weight: 600;
    color: white;
    margin-bottom: 3px;
}
.fp-step-text p {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.5);
    line-height: 1.5;
    margin: 0;
}

/* Security badge */
.fp-security-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 28px;
    padding: 8px 18px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 40px;
    font-size: 0.75rem;
    font-weight: 500;
    color: rgba(255,255,255,0.6);
}
.fp-security-badge i { color: #4ade80; font-size: 0.8rem; }

/* ── RIGHT PANEL ── */
.fp-right {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 60px 48px;
    background: var(--cream);
    position: relative;
}

/* Top logo area for right panel */
.fp-right-top {
    position: absolute;
    top: 32px; left: 48px; right: 48px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.fp-right-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}
.fp-right-logo img {
    width: 38px; height: 38px;
    border-radius: 10px;
    object-fit: cover;
    box-shadow: var(--shadow-sm);
}
.fp-right-logo-text {
    font-family: 'Playfair Display', serif;
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.2;
}
.fp-right-logo-sub {
    font-size: 0.65rem;
    color: var(--muted);
    font-family: 'DM Sans', sans-serif;
}

/* Form card */
.fp-form-wrap {
    width: 100%;
    max-width: 420px;
}

.fp-form-heading {
    margin-bottom: 36px;
}
.fp-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: var(--red);
    margin-bottom: 12px;
}
.fp-eyebrow::before {
    content: '';
    width: 20px; height: 2px;
    background: var(--red);
    border-radius: 2px;
}
.fp-form-heading h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.2;
    margin-bottom: 10px;
}
.fp-form-heading p {
    font-size: 0.88rem;
    color: var(--muted);
    line-height: 1.65;
}

/* Alert boxes */
.fp-alert {
    display: none;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 18px;
    border-radius: 16px;
    font-size: 0.85rem;
    line-height: 1.55;
    margin-bottom: 22px;
    animation: alert-in 0.3s ease;
}
@keyframes alert-in {
    from { opacity: 0; transform: translateY(-6px); }
    to { opacity: 1; transform: translateY(0); }
}
.fp-alert.show { display: flex; }
.fp-alert-success { background: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
.fp-alert-error { background: var(--red-light); color: var(--red-dark); border: 1px solid #FECACA; }
.fp-alert i { margin-top: 2px; flex-shrink: 0; }

/* Form elements */
.fp-form-group { margin-bottom: 20px; }
.fp-label {
    display: block;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--ink2);
    margin-bottom: 9px;
}
.fp-label span { color: var(--red); margin-left: 2px; }

.fp-input-wrap {
    position: relative;
    display: flex;
    align-items: stretch;
}
.fp-input-icon {
    padding: 0 14px;
    background: var(--cream2);
    border: 1.5px solid var(--border2);
    border-right: none;
    border-radius: 50px 0 0 50px;
    display: flex;
    align-items: center;
    color: var(--purple);
    font-size: 0.95rem;
    transition: border-color 0.2s;
}
.fp-input {
    flex: 1;
    padding: 13px 18px;
    border: 1.5px solid var(--border2);
    border-left: none;
    border-radius: 0 50px 50px 0;
    background: white;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.92rem;
    color: var(--ink);
    outline: none;
    transition: all 0.2s;
}
.fp-input:focus {
    border-color: var(--purple);
    box-shadow: 2px 0 0 2px rgba(107,70,193,0.08), 0 0 0 2px rgba(107,70,193,0.08);
}
.fp-input:focus + .fp-input-icon,
.fp-input-wrap:focus-within .fp-input-icon {
    border-color: var(--purple);
    background: var(--purple-light);
    color: var(--purple-dark);
}
.fp-input.is-valid { border-color: #16A34A; }
.fp-input.is-invalid { border-color: var(--red); }

/* Info hint */
.fp-hint {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 14px 18px;
    background: var(--purple-light);
    border-radius: 14px;
    margin-bottom: 24px;
    border: 1px solid rgba(107,70,193,0.15);
}
.fp-hint i { color: var(--purple); font-size: 0.85rem; margin-top: 2px; flex-shrink: 0; }
.fp-hint p { font-size: 0.8rem; color: var(--ink2); line-height: 1.6; }
.fp-hint p strong { color: var(--purple); }

/* Submit button */
.fp-submit-btn {
    width: 100%;
    padding: 15px;
    background: var(--gradient);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-family: 'DM Sans', sans-serif;
    box-shadow: 0 6px 20px rgba(107,70,193,0.3);
    margin-bottom: 22px;
    letter-spacing: 0.2px;
}
.fp-submit-btn:hover:not(:disabled) {
    box-shadow: 0 10px 28px rgba(107,70,193,0.4);
    transform: translateY(-2px);
}
.fp-submit-btn:disabled {
    opacity: 0.75;
    cursor: not-allowed;
    transform: none;
}
.fp-spinner {
    width: 18px; height: 18px;
    border: 2.5px solid rgba(255,255,255,0.35);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.75s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Footer links */
.fp-form-footer {
    text-align: center;
    padding-top: 18px;
    border-top: 1px solid var(--border);
}
.fp-form-footer p {
    font-size: 0.83rem;
    color: var(--muted);
    margin-bottom: 8px;
}
.fp-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    background: var(--gradient);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    transition: opacity 0.2s;
}
.fp-link:hover { opacity: 0.8; }

/* Footer bottom */
.fp-page-footer {
    background: var(--ink);
    text-align: center;
    padding: 18px 24px;
    font-size: 0.75rem;
    color: rgba(255,255,255,0.35);
}
.fp-page-footer a { color: rgba(255,255,255,0.5); text-decoration: none; }
.fp-page-footer a:hover { color: white; }

/* ── SUCCESS STATE ── */
.fp-success-state {
    display: none;
    text-align: center;
    animation: alert-in 0.4s ease;
}
.fp-success-state.show { display: block; }
.fp-success-icon-wrap {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: #DCFCE7;
    border: 2px solid #BBF7D0;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
    color: #16A34A;
}
.fp-success-state h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: 10px;
}
.fp-success-state p {
    font-size: 0.88rem;
    color: var(--muted);
    line-height: 1.7;
    margin-bottom: 28px;
    max-width: 340px;
    margin-left: auto;
    margin-right: auto;
}
.fp-email-shown {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--purple-light);
    border: 1px solid rgba(107,70,193,0.2);
    padding: 10px 20px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--purple-dark);
    margin-bottom: 24px;
}
.fp-success-actions { display: flex; flex-direction: column; gap: 12px; }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
    .fp-wrapper { grid-template-columns: 1fr; }
    .fp-left { display: none; }
    .fp-right {
        padding: 100px 28px 60px;
        justify-content: flex-start;
        min-height: 100vh;
    }
    .fp-right-top { left: 28px; right: 28px; }
    .fp-form-wrap { max-width: 100%; }
}
@media (max-width: 480px) {
    .fp-right { padding: 90px 20px 48px; }
    .fp-right-top { left: 20px; right: 20px; }
    .fp-form-heading h1 { font-size: 1.7rem; }
}
</style>
@endsection

@section('content')

<div style="display: flex; flex-direction: column; min-height: 100vh;">

    <div class="fp-wrapper">

        {{-- ══════════════ LEFT PANEL ══════════════ --}}
        <div class="fp-left">
            <div class="fp-left-pattern"></div>
            <div class="fp-left-orb-1"></div>
            <div class="fp-left-orb-2"></div>
            <div class="fp-left-orb-3"></div>

            <a href="{{ url('/users/login') }}" class="fp-back-link">
                <i class="fas fa-arrow-left"></i> Back to Login
            </a>

            <div class="fp-left-content">
                <div class="fp-left-icon-wrap">
                    <div class="fp-left-icon-ring"></div>
                    <div class="fp-left-icon-ring-2"></div>
                    <div class="fp-left-icon-circle">
                        <i class="fas fa-key"></i>
                    </div>
                </div>

                <h2>Account<br>Recovery</h2>
                <p>Reset your password securely in three simple steps. Your Al-Hilal Online Academy account and learning progress will remain safe.</p>

                <div class="fp-steps">
                    <div class="fp-step">
                        <div class="fp-step-num">1</div>
                        <div class="fp-step-text">
                            <h5>Enter Your Email</h5>
                            <p>Provide the email address linked to your account.</p>
                        </div>
                    </div>
                    <div class="fp-step">
                        <div class="fp-step-num">2</div>
                        <div class="fp-step-text">
                            <h5>Check Your Inbox</h5>
                            <p>We'll send a secure reset link within seconds.</p>
                        </div>
                    </div>
                    <div class="fp-step">
                        <div class="fp-step-num">3</div>
                        <div class="fp-step-text">
                            <h5>Set New Password</h5>
                            <p>Click the link and choose a strong new password.</p>
                        </div>
                    </div>
                </div>

                <div class="fp-security-badge">
                    <i class="fas fa-shield-halved"></i>
                    <span>SSL Encrypted · Link expires in 60 minutes</span>
                </div>
            </div>
        </div>

        {{-- ══════════════ RIGHT PANEL ══════════════ --}}
        <div class="fp-right">

            {{-- Top logo --}}
            <div class="fp-right-top">
                <a href="{{ url('/') }}" class="fp-right-logo">
                    <img src="{{ asset('assets/images/alhilal_logo.jpeg') }}" alt="Al-Hilal Online Academy">
                    <div>
                        <div class="fp-right-logo-text">Al-Hilal Online Academy</div>
                        <div class="fp-right-logo-sub">Online Islamic Learning</div>
                    </div>
                </a>
                <a href="{{ url('/users/login') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:0.8rem;font-weight:600;color:var(--muted);text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='var(--purple)'" onmouseout="this.style.color='var(--muted)'">
                    <i class="fas fa-arrow-left" style="font-size:0.72rem;"></i> Back to Login
                </a>
            </div>

            <div class="fp-form-wrap">

                {{-- Heading --}}
                <div class="fp-form-heading">
                    <div class="fp-eyebrow">Password Recovery</div>
                    <h1>Forgot your<br>password?</h1>
                    <p>No worries — enter your registered email address and we'll send you a secure reset link right away.</p>
                </div>

                @include('sweetalert::alert')

                @if(Session::get('success'))
                    <div class="fp-alert fp-alert-success show">
                        <i class="fas fa-circle-check"></i>
                        <div>{{ Session::get('success') }}</div>
                    </div>
                @endif

                @if(Session::get('fail'))
                    <div class="fp-alert fp-alert-error show">
                        <i class="fas fa-circle-exclamation"></i>
                        <div>{{ Session::get('fail') }}</div>
                    </div>
                @endif

                {{-- JS alert boxes --}}
                <div class="fp-alert fp-alert-success" id="alertSuccess">
                    <i class="fas fa-circle-check"></i>
                    <div id="alertSuccessText"></div>
                </div>
                <div class="fp-alert fp-alert-error" id="alertError">
                    <i class="fas fa-circle-exclamation"></i>
                    <div id="alertErrorText"></div>
                </div>

                {{-- ── DEFAULT FORM STATE ── --}}
                <div id="formState">
                    <form action="{{ url('user-generate-forgot-password-link') }}" method="POST" id="forgotPasswordForm">
                        @csrf

                        <div class="fp-form-group">
                            <label class="fp-label" for="email">Email Address <span>*</span></label>
                            <div class="fp-input-wrap">
                                <div class="fp-input-icon"><i class="fas fa-envelope"></i></div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="fp-input"
                                    placeholder="your@email.com"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    required
                                >
                            </div>
                        </div>

                        <div class="fp-hint">
                            <i class="fas fa-circle-info"></i>
                            <p>The reset link will expire in <strong>60 minutes</strong>. If you don't see the email, please check your spam or junk folder.</p>
                        </div>

                        <button type="submit" class="fp-submit-btn" id="submitBtn">
                            <i class="fas fa-paper-plane"></i>
                            Send Reset Link
                        </button>
                    </form>

                    <div class="fp-form-footer">
                        <p>Remembered your password?</p>
                        <a href="{{ url('/users/login') }}" class="fp-link">
                            <i class="fas fa-arrow-right-to-bracket"></i> Sign In to Your Account
                        </a>
                        <p style="margin-top: 12px;">Don't have an account?
                            <a href="{{ url('/users/register') }}" class="fp-link" style="margin-left: 4px;">
                                <i class="fas fa-user-plus"></i> Register Here
                            </a>
                        </p>
                    </div>
                </div>

                {{-- ── SUCCESS STATE ── --}}
                <div class="fp-success-state" id="successState">
                    <div class="fp-success-icon-wrap">
                        <i class="fas fa-envelope-circle-check"></i>
                    </div>
                    <h3>Check Your Email!</h3>
                    <p>We've sent a password reset link to:</p>
                    <div class="fp-email-shown" id="emailShown">
                        <i class="fas fa-envelope"></i>
                        <span id="emailShownText"></span>
                    </div>
                    <p>Click the link in the email to set a new password. The link expires in 60 minutes.</p>
                    <div class="fp-success-actions">
                        <button onclick="resendEmail()" class="fp-submit-btn" style="margin-bottom: 0;">
                            <i class="fas fa-rotate-right"></i> Resend Email
                        </button>
                        <a href="{{ url('/users/login') }}" class="fp-link" style="justify-content: center; font-size: 0.88rem; margin-top: 4px;">
                            <i class="fas fa-arrow-left"></i> Back to Login
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Page footer --}}
    <div class="fp-page-footer">
        &copy; {{ date('Y') }} Al-Hilal Online Academy &nbsp;·&nbsp;
        <a href="{{ url('/') }}">Home</a> &nbsp;·&nbsp;
        <a href="{{ url('/users/login') }}">Login</a> &nbsp;·&nbsp;
        <a href="{{ url('/users/register') }}">Register</a>
        &nbsp;·&nbsp; info@alhilalacademy.org
    </div>

</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const form       = document.getElementById('forgotPasswordForm');
const submitBtn  = document.getElementById('submitBtn');
const emailInput = document.getElementById('email');
const formState  = document.getElementById('formState');
const successState = document.getElementById('successState');
const alertSuccess = document.getElementById('alertSuccess');
const alertError   = document.getElementById('alertError');

function showAlert(type, message) {
    alertSuccess.classList.remove('show');
    alertError.classList.remove('show');
    if (type === 'success') {
        document.getElementById('alertSuccessText').textContent = message;
        alertSuccess.classList.add('show');
    } else {
        document.getElementById('alertErrorText').textContent = message;
        alertError.classList.add('show');
    }
}

function setLoading(loading) {
    if (loading) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<div class="fp-spinner"></div> Sending…';
    } else {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Reset Link';
    }
}

function showSuccess(email) {
    formState.style.display = 'none';
    document.getElementById('emailShownText').textContent = email;
    successState.classList.add('show');
    alertSuccess.classList.remove('show');
    alertError.classList.remove('show');
}

function resendEmail() {
    successState.classList.remove('show');
    formState.style.display = 'block';
    emailInput.focus();
}

// Real-time validation visual feedback
emailInput.addEventListener('input', function() {
    alertError.classList.remove('show');
    const val = this.value.trim();
    if (val.length === 0) {
        this.classList.remove('is-valid','is-invalid');
    } else if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
        this.classList.add('is-valid');
        this.classList.remove('is-invalid');
    } else {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    }
});

form.addEventListener('submit', async function(e) {
    e.preventDefault();

    const email = emailInput.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!email) {
        showAlert('error', 'Please enter your email address.');
        emailInput.classList.add('is-invalid');
        emailInput.focus();
        return;
    }
    if (!emailRegex.test(email)) {
        showAlert('error', 'Please enter a valid email address (e.g. you@example.com).');
        emailInput.classList.add('is-invalid');
        emailInput.focus();
        return;
    }

    // Confirmation dialog
    const result = await Swal.fire({
        title: 'Send Reset Link?',
        html: `We'll send a password reset link to:<br><strong style="color:#6B46C1;">${email}</strong>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#6B46C1',
        cancelButtonColor: '#6B6584',
        confirmButtonText: '<i class="fas fa-paper-plane"></i> Yes, send it',
        cancelButtonText: 'Cancel',
        customClass: { popup: 'swal-rounded' }
    });

    if (!result.isConfirmed) return;

    setLoading(true);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email })
        });

        const data = await response.json();

        if (response.ok && data.status) {
            showSuccess(email);
            Swal.fire({
                title: 'Link Sent!',
                text: 'Check your inbox for the reset link.',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        } else {
            showAlert('error', data.message || 'We couldn\'t find an account with that email address.');
            emailInput.classList.add('is-invalid');
        }
    } catch (err) {
        // Fallback: submit the form the traditional way
        form.submit();
    } finally {
        setLoading(false);
    }
});

// Enter key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !submitBtn.disabled && document.getElementById('formState').style.display !== 'none') {
        e.preventDefault();
        form.dispatchEvent(new Event('submit'));
    }
});
</script>
@endsection