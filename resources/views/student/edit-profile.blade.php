@extends('layouts.master2')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

.container-custom {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
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
    box-shadow: 0 4px 15px rgba(107,70,193,0.3);
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(107,70,193,0.4);
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
.btn-secondary {
    background: var(--cream2);
    border: 1.5px solid var(--border);
    color: var(--ink2);
}
.btn-secondary:hover {
    background: var(--border);
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

/* Edit Profile Hero */
.edit-hero {
    background: linear-gradient(135deg, #1A0A2E 0%, #2D0F5C 50%, #4A1A1A 100%);
    padding: 80px 0 50px;
    position: relative;
    overflow: hidden;
}
.edit-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle at 20% 50%, rgba(107,70,193,0.3) 0%, transparent 50%),
                      radial-gradient(circle at 80% 50%, rgba(220,38,38,0.2) 0%, transparent 50%);
}
.edit-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
}
.edit-hero-icon {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    border: 2px solid rgba(255,255,255,0.2);
}
.edit-hero-icon i {
    font-size: 2.5rem;
    color: white;
}
.edit-hero h1 {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin-bottom: 8px;
    font-family: 'Playfair Display', serif;
}
.edit-hero p {
    color: rgba(255,255,255,0.7);
    font-size: 0.9rem;
}

/* Form Card */
.form-card {
    background: white;
    border-radius: 32px;
    border: 1px solid var(--border);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    margin-top: -30px;
    position: relative;
    z-index: 10;
}
.form-header {
    padding: 28px 32px;
    background: var(--cream2);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 12px;
}
.form-header i {
    font-size: 1.5rem;
    color: var(--purple);
}
.form-header h2 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--ink);
    font-family: 'Playfair Display', serif;
    margin: 0;
}
.form-body {
    padding: 32px;
}
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}
.form-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.form-field.full-width {
    grid-column: span 2;
}
.form-field label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.form-field label .required {
    color: var(--red);
    margin-left: 4px;
}
.form-control {
    padding: 14px 18px;
    border-radius: 16px;
    border: 1.5px solid var(--border2);
    background: white;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    color: var(--ink);
    transition: all 0.2s;
    outline: none;
    width: 100%;
}
.form-control:focus {
    border-color: var(--purple);
    box-shadow: 0 0 0 3px rgba(107,70,193,0.1);
}
.form-control::placeholder {
    color: var(--muted);
    opacity: 0.5;
}
select.form-control {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B6584' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 18px center;
}
.password-hint {
    font-size: 0.7rem;
    color: var(--muted);
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.password-hint i {
    font-size: 0.65rem;
    color: var(--gold);
}
.form-actions {
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid var(--border);
    display: flex;
    gap: 16px;
    justify-content: flex-end;
}

/* Alert Styles */
.alert-custom {
    padding: 16px 20px;
    border-radius: 20px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.85rem;
}
.alert-success {
    background: #DCFCE7;
    color: #166534;
    border-left: 4px solid #22c55e;
}
.alert-danger {
    background: var(--red-light);
    color: var(--red-dark);
    border-left: 4px solid var(--red);
}
.alert-warning {
    background: var(--gold-light);
    color: #92400e;
    border-left: 4px solid var(--gold);
}
.alert-custom i {
    font-size: 1.1rem;
}
.error-list {
    margin: 0;
    padding-left: 20px;
}
.error-list li {
    margin-bottom: 4px;
}

/* Back to Top */
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
    background: var(--gradient);
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(107,70,193,0.4);
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

/* Footer */
.site-footer {
    background: var(--ink);
    color: rgba(255,255,255,0.7);
    padding: 40px 0 30px;
    margin-top: 60px;
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
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }
    .form-field.full-width {
        grid-column: span 1;
    }
    .form-body {
        padding: 24px;
    }
    .form-header {
        padding: 20px 24px;
    }
    .form-actions {
        flex-direction: column;
    }
    .form-actions .btn {
        width: 100%;
        justify-content: center;
    }
    .header-actions .btn-outline {
        display: none;
    }
}

/* Password toggle */
.input-wrapper {
    position: relative;
}

.input-wrapper .toggle-password {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
    cursor: pointer;
    font-size: 0.9rem;
    transition: color 0.2s;
}

.input-wrapper .toggle-password:hover {
    color: var(--purple-dark);
}
</style>
@endsection

@section('content')

<!-- Site Header -->
<header class="site-header">
    <div class="header-inner">
        <a href="{{ url('/') }}" class="header-logo">
            <img src="{{ asset('assets/images/alhilal_logo.jpeg') }}" alt="AlHilal Academy">
            <div>
                <div class="header-logo-text">AlHilal Academy</div>
                <div class="header-logo-sub">Online Islamic Learning</div>
            </div>
        </a>
        <div class="header-actions">
            <a href="{{ url('/student/profile') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Profile
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
    
<!-- Edit Profile Hero -->
<section class="edit-hero">
    <div class="container-custom">
        <div class="edit-hero-content">
            <div class="edit-hero-icon">
                <i class="fas fa-user-edit"></i>
            </div>
            <h1>Edit Profile Information</h1>
            <p>Update your personal details and account settings</p>
        </div>
    </div>
</section>

<!-- Form Section -->
<section style="padding: 0 0 60px;">
    <div class="container-custom">
        <div class="form-card">
            <div class="form-header">
                <i class="fas fa-id-card"></i>
                <h2>Personal Information</h2>
            </div>
            
            <form action="{{ route('update-internal-user') }}" method="POST" id="userForm">
                @csrf
                <input type="hidden" name="user_id" id="user_id" value="{{ $info->id }}">
                
                <div class="form-body">
                    <!-- Alert Messages -->
                    @if ($errors->any())
                        <div class="alert-custom alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <div>
                                <strong>Please fix the following errors:</strong>
                                <ul class="error-list mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if (Session::get('success'))
                        <div class="alert-custom alert-success">
                            <i class="fas fa-check-circle"></i>
                            <div>{{ Session::get('success') }}</div>
                        </div>
                    @endif

                    @if (Session::get('fail'))
                        <div class="alert-custom alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>{{ Session::get('fail') }}</div>
                        </div>
                    @endif

                    <div class="form-grid">
                        <!-- Username -->
                        <div class="form-field">
                            <label>Username <span class="required">*</span></label>
                            <input type="text" name="username" id="username" class="form-control"
                                placeholder="Enter username" value="{{ @$info->username }}" required>
                        </div>

                        <!-- Email -->
                        <div class="form-field">
                            <label>Email Address <span class="required">*</span></label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Enter email address" value="{{ @$info->email }}" required>
                        </div>

                        <!-- First Name -->
                        <div class="form-field">
                            <label>First Name</label>
                            <input type="text" name="firstname" id="firstname" class="form-control"
                                placeholder="Enter first name" value="{{ @$info->firstname }}">
                        </div>

                        <!-- Last Name -->
                        <div class="form-field">
                            <label>Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control"
                                placeholder="Enter last name" value="{{ @$info->lastname }}">
                        </div>

                        <!-- Gender -->
                        <div class="form-field">
                            <label>Gender <span class="required">*</span></label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ (@$info->gender == 'Male') ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ (@$info->gender == 'Female') ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <!-- Phone Number -->
                        <div class="form-field">
                            <label>Phone Number</label>
                            <input type="tel" name="phonenumber" id="phonenumber" class="form-control"
                                placeholder="Enter phone number" value="{{ @$info->phonenumber }}">
                        </div>

                        <!-- Country -->
                        <div class="form-field full-width">
                            <label>Country</label>
                            <input type="text" name="country" id="country" class="form-control"
                                placeholder="Enter country" value="{{ @$info->country }}">
                        </div>

<!-- New Password -->
<div class="form-field password-field">
    <label>New Password</label>
    <div class="input-wrapper">
        <input type="password" name="password" id="password" class="form-control"
            placeholder="Leave blank to keep current password">
        <i class="fas fa-eye toggle-password"></i>
    </div>
    <div class="password-hint">
        <i class="fas fa-info-circle"></i>
        <span>Password must be at least 6 characters with uppercase, lowercase, number, and special character</span>
    </div>
</div>

<!-- Confirm Password -->
<div class="form-field password-field">
    <label>Confirm New Password</label>
    <div class="input-wrapper">
        <input type="password" name="confirm_password" id="confirm_password" class="form-control"
            placeholder="Confirm your new password">
        <i class="fas fa-eye toggle-password"></i>
    </div>
</div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ url('/student/profile') }}" class="btn" style="background-color:#C52D47;color:#FFF;">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" id="submitBtn" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-copyright">
            <p>© {{ date('Y') }} AlHilal Online Academy. All rights reserved.</p>
            <p style="margin-top: 8px;">Dedicated to authentic Islamic education for all — P.1 through S.6</p>
        </div>
    </div>
</footer>

<!-- Bottom Navigation -->
<nav class="bottom-nav">
    <a href="{{ url('/') }}" class="nav-item"><i class="fas fa-home"></i><span>Home</span></a>
    <a href="{{ url('/users/home-page') }}#curriculum" class="nav-item"><i class="fas fa-layer-group"></i><span>Lessons</span></a>
    <a href="{{ url('/student/profile') }}" class="nav-item"><i class="fas fa-user"></i><span>Profile</span></a>
    <a href="{{ url('/users/home-page') }}#contact" class="nav-item"><i class="fas fa-headset"></i><span>Support</span></a>
    <a href="https://wa.me/256702082209" class="nav-item nav-whatsapp"><i class="fab fa-whatsapp"></i><span>Chat</span></a>
</nav>

<!-- Back to Top Button -->
<a href="#" class="back-to-top" id="backToTopBtn">
    <i class="fas fa-chevron-up"></i>
</a>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Back to Top Button
const backBtn = document.getElementById('backToTopBtn');
window.addEventListener('scroll', () => {
    backBtn.classList.toggle('show', window.scrollY > 500);
});
backBtn.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Form Validation
document.getElementById('userForm').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('confirm_password').value.trim();
    const submitBtn = document.getElementById('submitBtn');

    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{6,}$/;

    // If only one password field is filled
    if ((password && !confirmPassword) || (!password && confirmPassword)) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Both Password and Confirm Password must be provided if you want to update the password.',
            confirmButtonColor: '#DC2626'
        });
        return false;
    }

    // If both password fields are filled
    if (password && confirmPassword) {
        if (password !== confirmPassword) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'Password and Confirm Password do not match.',
                confirmButtonColor: '#DC2626'
            });
            return false;
        }

        if (!passwordRegex.test(password)) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Weak Password',
                html: `Password must:<br>
                    <ul style="text-align: left; margin-top: 10px;">
                        <li>Be at least 6 characters</li>
                        <li>Contain one uppercase letter</li>
                        <li>Contain one lowercase letter</li>
                        <li>Contain one digit</li>
                        <li>Contain one special character (@$!%*?&#)</li>
                    </ul>`,
                confirmButtonColor: '#DC2626'
            });
            return false;
        }
    }

    // Show confirmation before submit
    event.preventDefault();
    
    Swal.fire({
        title: 'Confirm Update',
        text: 'Are you sure you want to update your profile information?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, update it!',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#6B46C1',
        cancelButtonColor: '#6B6584',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating profile...';
            submitBtn.disabled = true;
            
            // Submit the form
            document.getElementById('userForm').submit();
        }
    });
});

// Live password strength indicator (optional enhancement)
const passwordInput = document.getElementById('password');
const confirmInput = document.getElementById('confirm_password');

function checkPasswordStrength() {
    const password = passwordInput.value;
    const strengthMap = ['Very Weak', 'Weak', 'Medium', 'Strong', 'Very Strong'];
    let strength = 0;
    
    if (password.length >= 6) strength++;
    if (password.match(/[a-z]+/)) strength++;
    if (password.match(/[A-Z]+/)) strength++;
    if (password.match(/[0-9]+/)) strength++;
    if (password.match(/[@$!%*?&#]+/)) strength++;
    
    return { score: strength, label: strengthMap[strength - 1] || 'Very Weak' };
}

if (passwordInput) {
    passwordInput.addEventListener('input', function() {
        const strength = checkPasswordStrength();
        // Optional: Add visual feedback
    });
}
</script>

<script>
document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', () => {
        const input = icon.previousElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});
</script>
@endsection