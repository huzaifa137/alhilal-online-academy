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

.font-display { font-family: 'Playfair Display', serif; }

.container-custom {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Profile Header */
.profile-header {
    background: linear-gradient(135deg, var(--ink) 0%, var(--purple-dark) 100%);
    position: relative;
    overflow: hidden;
    padding: 80px 0 120px;
    margin-top: 68px;
}

.profile-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 20% 30%, rgba(107,70,193,0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(220,38,38,0.2) 0%, transparent 50%);
    pointer-events: none;
}

.profile-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(to top, var(--cream), transparent);
}

.profile-avatar {
    position: relative;
    width: 140px;
    height: 140px;
    margin: 0 auto 20px;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: var(--shadow-lg);
}

.profile-avatar-initial {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: var(--gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 700;
    color: white;
    border: 4px solid white;
    box-shadow: var(--shadow-lg);
}

.profile-name {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin-bottom: 8px;
    font-family: 'Playfair Display', serif;
}

.profile-role {
    display: inline-block;
    padding: 6px 16px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(8px);
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    color: rgba(255,255,255,0.9);
    margin-bottom: 16px;
}

.profile-reg-number {
    color: rgba(255,255,255,0.7);
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 24px;
    margin-top: -60px;
    position: relative;
    z-index: 2;
    margin-bottom: 48px;
}

.stat-card {
    background: white;
    border-radius: 24px;
    padding: 24px;
    text-align: center;
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
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.stat-card:hover::before {
    transform: scaleX(1);
}

.stat-icon {
    width: 56px;
    height: 56px;
    background: var(--gradient-soft);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 1.5rem;
    color: var(--purple);
}

.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: var(--ink);
    font-family: 'Playfair Display', serif;
    line-height: 1;
    margin-bottom: 8px;
}

.stat-label {
    font-size: 0.8rem;
    color: var(--muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Profile Content */
.profile-content {
    background: white;
    border-radius: 28px;
    border: 1px solid var(--border);
    overflow: hidden;
    margin-bottom: 48px;
}

.profile-tabs {
    display: flex;
    border-bottom: 1px solid var(--border);
    background: var(--cream);
    padding: 0 32px;
}

.tab-btn {
    padding: 18px 24px;
    background: none;
    border: none;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--muted);
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
    font-family: 'DM Sans', sans-serif;
}

.tab-btn:hover {
    color: var(--purple);
}

.tab-btn.active {
    color: var(--purple);
}

.tab-btn.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--gradient);
    border-radius: 3px 3px 0 0;
}

.tab-pane {
    display: none;
    padding: 32px;
    animation: fadeIn 0.3s ease;
}

.tab-pane.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Form Styles */
.form-section {
    margin-bottom: 32px;
}

.form-section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--border);
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-section-title i {
    color: var(--purple);
    font-size: 1.2rem;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-bottom: 24px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--ink2);
    margin-bottom: 8px;
}

.form-group label i {
    margin-right: 6px;
    color: var(--purple);
    font-size: 0.75rem;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid var(--border2);
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    color: var(--ink);
    transition: all 0.2s;
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: var(--purple);
    box-shadow: 0 0 0 3px rgba(107,70,193,0.1);
}

.form-control.readonly {
    background: var(--cream2);
    color: var(--muted);
    cursor: not-allowed;
}

.input-hint {
    font-size: 0.7rem;
    color: var(--muted);
    margin-top: 6px;
}

.error-message {
    font-size: 0.7rem;
    color: var(--red);
    margin-top: 6px;
    display: none;
}

.error-message.show {
    display: block;
}

.btn-save {
    background: var(--gradient);
    color: white;
    border: none;
    padding: 14px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'DM Sans', sans-serif;
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107,70,193,0.35);
}

.btn-save:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Info Cards */
.info-card {
    background: var(--cream);
    border-radius: 20px;
    padding: 20px;
    margin-bottom: 24px;
    border: 1px solid var(--border);
}

.info-card-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--ink2);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 0.85rem;
    color: var(--muted);
}

.info-value {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--ink);
}

/* Activity Timeline */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--gradient);
}

.timeline-item {
    position: relative;
    margin-bottom: 24px;
}

.timeline-dot {
    position: absolute;
    left: -30px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: var(--purple);
    border: 2px solid white;
    box-shadow: 0 0 0 2px var(--purple-light);
}

.timeline-content {
    background: var(--cream);
    padding: 16px;
    border-radius: 16px;
}

.timeline-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 4px;
}

.timeline-date {
    font-size: 0.7rem;
    color: var(--muted);
}

/* Loading Overlay */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(26,10,46,0.8);
    backdrop-filter: blur(4px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.loading-overlay.active {
    display: flex;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 3px solid var(--purple-light);
    border-top-color: var(--purple);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Toast Notifications */
.toast-notification {
    position: fixed;
    bottom: 100px;
    right: 24px;
    background: white;
    border-radius: 16px;
    padding: 16px 24px;
    box-shadow: var(--shadow-lg);
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 9998;
    transform: translateX(400px);
    transition: transform 0.3s ease;
    border-left: 4px solid var(--purple);
}

.toast-notification.show {
    transform: translateX(0);
}

.toast-success {
    border-left-color: #10B981;
}

.toast-error {
    border-left-color: var(--red);
}

.toast-icon {
    font-size: 1.2rem;
}

.toast-success .toast-icon {
    color: #10B981;
}

.toast-error .toast-icon {
    color: var(--red);
}

.toast-message {
    font-size: 0.85rem;
    color: var(--ink);
}

/* Responsive */
@media (max-width: 768px) {
    .profile-header {
        padding: 60px 0 100px;
        margin-top: 60px;
    }
    
    .profile-name {
        font-size: 1.5rem;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-top: -40px;
    }
    
    .stat-card {
        padding: 16px;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
    
    .profile-tabs {
        padding: 0 16px;
        overflow-x: auto;
    }
    
    .tab-btn {
        padding: 14px 16px;
        font-size: 0.8rem;
        white-space: nowrap;
    }
    
    .tab-pane {
        padding: 20px;
    }
    
    .form-row {
        gap: 16px;
    }
    
    .toast-notification {
        bottom: 80px;
        right: 16px;
        left: 16px;
        padding: 12px 16px;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>

<!-- Profile Header -->
<div class="profile-header">
    <div class="container-custom text-center">
        <div class="profile-avatar">
            @php
                $initial = strtoupper(substr($user->firstname, 0, 1) . substr($user->lastname, 0, 1));
            @endphp
            <div class="profile-avatar-initial">
                {{ $initial }}
            </div>
        </div>
        <h1 class="profile-name">{{ $user->firstname }} {{ $user->lastname }}</h1>
        <div class="profile-role">
            @php
                $roleNames = [1 => 'Student', 2 => 'Teacher', 3 => 'Admin'];
                $roleName = $roleNames[$user->user_role] ?? 'Student';
            @endphp
            <i class="fas {{ $user->user_role == 1 ? 'fa-graduation-cap' : ($user->user_role == 2 ? 'fa-chalkboard-user' : 'fa-user-tie') }}"></i>
            {{ $roleName }}
        </div>
        <div class="profile-reg-number">
            <i class="fas fa-id-card"></i>
            Registration Number: {{ $user->reg_number ?? 'Pending' }}
        </div>
    </div>
</div>

<div class="container-custom">
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="stat-number">{{ $stats['total_lessons_completed'] ?? 0 }}</div>
            <div class="stat-label">Lessons Completed</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-number">{{ $stats['total_quizzes_passed'] ?? 0 }}</div>
            <div class="stat-label">Quizzes Passed</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-award"></i>
            </div>
            <div class="stat-number">{{ $stats['certificates_earned'] ?? 0 }}</div>
            <div class="stat-label">Certificates</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-number">{{ $stats['current_level'] ?? 'N/A' }}</div>
            <div class="stat-label">Current Level</div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="profile-content">
        <div class="profile-tabs">
            <button class="tab-btn active" data-tab="info">
                <i class="fas fa-user"></i> Personal Info
            </button>
            <button class="tab-btn" data-tab="security">
                <i class="fas fa-lock"></i> Security
            </button>
            <button class="tab-btn" data-tab="activity">
                <i class="fas fa-history"></i> Activity
            </button>
        </div>

        <!-- Personal Info Tab -->
        <div class="tab-pane active" id="tab-info">
            <form id="profileForm">
                @csrf
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-user-circle"></i>
                        Basic Information
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> First Name</label>
                            <input type="text" name="firstname" class="form-control" value="{{ $user->firstname }}" required>
                            <div class="error-message" data-field="firstname"></div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Last Name</label>
                            <input type="text" name="lastname" class="form-control" value="{{ $user->lastname }}" required>
                            <div class="error-message" data-field="lastname"></div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-at"></i> Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                            <div class="input-hint">Only letters, numbers, and underscores</div>
                            <div class="error-message" data-field="username"></div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                            <div class="input-hint">Optional but recommended for communication</div>
                            <div class="error-message" data-field="email"></div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Phone Number</label>
                            <input type="tel" name="phonenumber" class="form-control" value="{{ $user->phonenumber }}" required>
                            <div class="input-hint">Example: +256 700 123456 or 0700123456</div>
                            <div class="error-message" data-field="phonenumber"></div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-id-card"></i> Registration Number</label>
                            <input type="text" class="form-control readonly" value="{{ $user->reg_number ?? 'Pending' }}" readonly disabled>
                        </div>
                    </div>
                </div>
                
                <div style="text-align: right;">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Tab -->
        <div class="tab-pane" id="tab-security">
            <form id="passwordForm">
                @csrf
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-key"></i>
                        Change Password
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Current Password</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Enter your current password">
                        <div class="error-message" data-field="current_password"></div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-key"></i> New Password</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
                            <div class="input-hint">Minimum 8 characters with uppercase, lowercase, number, and special character</div>
                            <div class="error-message" data-field="new_password"></div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-check-circle"></i> Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm new password">
                            <div class="error-message" data-field="new_password_confirmation"></div>
                        </div>
                    </div>
                </div>
                
                <div style="text-align: right;">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-sync-alt"></i> Update Password
                    </button>
                </div>
            </form>
            
            <div class="info-card" style="margin-top: 24px;">
                <div class="info-card-title">
                    <i class="fas fa-shield-alt"></i>
                    Account Security Tips
                </div>
                <ul style="padding-left: 20px; color: var(--muted); font-size: 0.85rem; line-height: 1.8;">
                    <li>Use a strong, unique password that you don't use elsewhere</li>
                    <li>Enable two-factor authentication for added security (coming soon)</li>
                    <li>Never share your password with anyone</li>
                    <li>Contact support immediately if you notice suspicious activity</li>
                </ul>
            </div>
        </div>

        <!-- Activity Tab -->
        <div class="tab-pane" id="tab-activity">
            <div class="form-section">
                <div class="form-section-title">
                    <i class="fas fa-clock"></i>
                    Recent Activity
                </div>
                
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Account Created</div>
                            <div class="timeline-date">
                                <i class="fas fa-calendar-alt"></i> 
                                {{ \Carbon\Carbon::parse($user->created_at)->format('F j, Y \a\t g:i A') }}
                            </div>
                        </div>
                    </div>
                    
                    @if($user->updated_at && $user->updated_at != $user->created_at)
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">Profile Last Updated</div>
                            <div class="timeline-date">
                                <i class="fas fa-calendar-alt"></i> 
                                {{ \Carbon\Carbon::parse($user->updated_at)->format('F j, Y \a\t g:i A') }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="info-card">
                <div class="info-card-title">
                    <i class="fas fa-chart-simple"></i>
                    Account Summary
                </div>
                <div class="info-row">
                    <span class="info-label">Account Status</span>
                    <span class="info-value">
                        @if($user->account_status == 10)
                            <span style="color: #10B981;"><i class="fas fa-check-circle"></i> Active</span>
                        @elseif($user->account_status == 0)
                            <span style="color: var(--red);"><i class="fas fa-ban"></i> Suspended</span>
                        @else
                            <span style="color: var(--gold);"><i class="fas fa-hourglass-half"></i> Pending</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Registration Status</span>
                    <span class="info-value">
                        @if($user->registration_status == 1)
                            <span style="color: #10B981;">Completed</span>
                        @else
                            <span style="color: var(--gold);">Pending</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Member Since</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toastNotification" class="toast-notification">
    <div class="toast-icon"></div>
    <div class="toast-message"></div>
</div>

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Tab switching
    $('.tab-btn').click(function() {
        const tabId = $(this).data('tab');
        
        $('.tab-btn').removeClass('active');
        $(this).addClass('active');
        
        $('.tab-pane').removeClass('active');
        $('#tab-' + tabId).addClass('active');
    });
    
    // Clear previous errors
    function clearErrors(form) {
        form.find('.error-message').removeClass('show').text('');
        form.find('.form-control').removeClass('is-invalid');
    }
    
    // Show errors
    function showErrors(form, errors) {
        $.each(errors, function(field, messages) {
            const errorDiv = form.find(`.error-message[data-field="${field}"]`);
            if (errorDiv.length) {
                errorDiv.text(messages[0]).addClass('show');
                form.find(`[name="${field}"]`).addClass('is-invalid');
            }
        });
    }
    
    // Show toast notification
    function showToast(message, type = 'success') {
        const toast = $('#toastNotification');
        toast.removeClass('toast-success toast-error').addClass(`toast-${type}`);
        toast.find('.toast-icon').html(type === 'success' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-exclamation-circle"></i>');
        toast.find('.toast-message').text(message);
        toast.addClass('show');
        
        setTimeout(() => {
            toast.removeClass('show');
        }, 3000);
    }
    
    // Show loading overlay
    function showLoading() {
        $('#loadingOverlay').addClass('active');
    }
    
    function hideLoading() {
        $('#loadingOverlay').removeClass('active');
    }
    
    // Handle profile form submission
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        
        clearErrors($(this));
        showLoading();
        
        $.ajax({
            url: '{{ route("profile.update") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status) {
                    showToast(response.message, 'success');
                    
                    // Update displayed name in header
                    const firstName = $('input[name="firstname"]').val();
                    const lastName = $('input[name="lastname"]').val();
                    $('.profile-name').text(firstName + ' ' + lastName);
                    
                    // Update avatar initial if needed
                    const initial = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
                    $('.profile-avatar-initial').text(initial);
                    
                    // Optionally reload page to refresh all data
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    showErrors($('#profileForm'), xhr.responseJSON.errors);
                    showToast('Please fix the errors in the form', 'error');
                } else {
                    showToast(xhr.responseJSON.message || 'An error occurred. Please try again.', 'error');
                }
            },
            complete: function() {
                hideLoading();
            }
        });
    });
    
    // Handle password form submission
    $('#passwordForm').on('submit', function(e) {
        e.preventDefault();
        
        clearErrors($(this));
        
        const newPassword = $('input[name="new_password"]').val();
        const confirmPassword = $('input[name="new_password_confirmation"]').val();
        
        if (newPassword !== confirmPassword) {
            showErrors($(this), {
                'new_password_confirmation': ['Password confirmation does not match.']
            });
            showToast('Password confirmation does not match.', 'error');
            return;
        }
        
        showLoading();
        
        $.ajax({
            url: '{{ route("profile.update") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.status) {
                    showToast(response.message, 'success');
                    $('#passwordForm')[0].reset();
                    clearErrors($('#passwordForm'));
                }
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    showErrors($('#passwordForm'), xhr.responseJSON.errors);
                    showToast('Please fix the errors in the form', 'error');
                } else {
                    showToast(xhr.responseJSON.message || 'An error occurred. Please try again.', 'error');
                }
            },
            complete: function() {
                hideLoading();
            }
        });
    });
    
    // Add input event listeners to clear errors on typing
    $('.form-control').on('input', function() {
        const fieldName = $(this).attr('name');
        $(this).removeClass('is-invalid');
        $(`.error-message[data-field="${fieldName}"]`).removeClass('show').text('');
    });
});
</script>
@endsection