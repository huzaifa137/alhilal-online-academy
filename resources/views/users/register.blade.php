@extends('layouts.master2')
@section('css')
@endsection
@section('content')


    <!-- Mobile-Optimized Header with Logo -->
    <div style="text-align: center; padding: 40px 20px 30px; background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%); border-radius: 0 0 30px 30px;">
        <img src="{{ asset('assets/images/alhilal_logo.jpeg') }}" alt="Logo" style="max-width: 100px; border-radius: 20px; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
        <h1 style="color: white; font-size: 1.8rem; margin: 10px 0 5px; font-weight: 700;">AlHilal Online Academy</h1>
        <p style="color: rgba(255,255,255,0.9); font-size: 0.9rem;">Join our studying community</p>
    </div>

    <!-- Mobile-Optimized Form Container -->
    <div style="max-width: 500px; margin: -20px auto 0; padding: 0 16px 40px 16px;">
        <div style="background: white; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden;">
            <div style="padding: 30px 24px 35px;">
                <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 8px; background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%); -webkit-background-clip: text; background-clip: text; color: transparent;">Register Account</h2>
                <p style="color: #6c6c6c; font-size: 0.85rem; margin-bottom: 28px; border-bottom: 1px solid #f0f0f0; padding-bottom: 12px;">
                    <i class="fas fa-info-circle"></i> After registration, login with <strong>Username</strong> OR <strong>Email</strong>
                </p>

                <form action="{{ route('user-account-creation') }}" method="POST" id="registerForm">
                    @csrf

                    <!-- Full Name Field (Required) -->
                    <div style="margin-bottom: 18px;">
                        <label style="display: block; margin-bottom: 8px; font-size: 0.85rem; font-weight: 500; color: #333;">
                            Full Name <span style="color: #DC2626;">*</span>
                        </label>
                        <div style="display: flex; align-items: stretch;">
                            <div style="padding: 12px 14px; background: #f5f5f5; border: 1.5px solid #e8e8e8; border-right: none; border-radius: 30px 0 0 30px; display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9B6B9F" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <input type="text" id="student_fullname" name="fullname" placeholder="Enter your full name" value="{{ old('fullname') }}" style="flex: 1; padding: 12px 15px; border: 1.5px solid #e8e8e8; border-left: none; border-radius: 0 30px 30px 0; font-size: 15px; outline: none; transition: all 0.2s; font-family: inherit;">
                        </div>
                    </div>

                    <!-- Username Field (Required for Login) -->
                    <div style="margin-bottom: 18px;">
                        <label style="display: block; margin-bottom: 8px; font-size: 0.85rem; font-weight: 500; color: #333;">
                            Username <span style="color: #DC2626;">*</span>
                            <span style="font-size: 0.7rem; color: #6c6c6c; font-weight: normal;">(used for login)</span>
                        </label>
                        <div style="display: flex; align-items: stretch;">
                            <div style="padding: 12px 14px; background: #f5f5f5; border: 1.5px solid #e8e8e8; border-right: none; border-radius: 30px 0 0 30px; display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9B6B9F" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <input type="text" id="student_username" name="username" placeholder="Choose a username (letters, numbers, underscore)" value="{{ old('username') }}" style="flex: 1; padding: 12px 15px; border: 1.5px solid #e8e8e8; border-left: none; border-radius: 0 30px 30px 0; font-size: 15px; outline: none; transition: all 0.2s; font-family: inherit;">
                        </div>
                        <small style="font-size: 0.7rem; color: #6c6c6c; margin-left: 12px;">Example: john_doe, johndoe123</small>
                    </div>

                    <!-- Email Field (Required - Also for Login) -->
                    <div style="margin-bottom: 18px;">
                        <label style="display: block; margin-bottom: 8px; font-size: 0.85rem; font-weight: 500; color: #333;">
                            Email Address <span style="color: #DC2626;">*</span>
                            <span style="font-size: 0.7rem; color: #6c6c6c; font-weight: normal;">(also used for login)</span>
                        </label>
                        <div style="display: flex; align-items: stretch;">
                            <div style="padding: 12px 14px; background: #f5f5f5; border: 1.5px solid #e8e8e8; border-right: none; border-radius: 30px 0 0 30px; display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9B6B9F" stroke-width="2">
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                    <path d="m22 7-10 7L2 7"></path>
                                </svg>
                            </div>
                            <input type="email" id="student_mail" name="email" placeholder="Enter your email address" value="{{ old('email') }}" style="flex: 1; padding: 12px 15px; border: 1.5px solid #e8e8e8; border-left: none; border-radius: 0 30px 30px 0; font-size: 15px; outline: none; transition: all 0.2s; font-family: inherit;">
                        </div>
                    </div>

                    <!-- Phone Number Field (Required) -->
                    <div style="margin-bottom: 18px;">
                        <label style="display: block; margin-bottom: 8px; font-size: 0.85rem; font-weight: 500; color: #333;">
                            Phone Number <span style="color: #DC2626;">*</span>
                            <span style="font-size: 0.7rem; color: #6c6c6c; font-weight: normal;">(for account recovery and notifications)</span>
                        </label>
                        <div style="display: flex; align-items: stretch;">
                            <div style="padding: 12px 14px; background: #f5f5f5; border: 1.5px solid #e8e8e8; border-right: none; border-radius: 30px 0 0 30px; display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9B6B9F" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <input type="tel" id="student_phone" name="phone" placeholder="Enter your phone number (e.g., +256 700 123456)" value="{{ old('phone') }}" style="flex: 1; padding: 12px 15px; border: 1.5px solid #e8e8e8; border-left: none; border-radius: 0 30px 30px 0; font-size: 15px; outline: none; transition: all 0.2s; font-family: inherit;">
                        </div>
                        <small style="font-size: 0.7rem; color: #6c6c6c; margin-left: 12px;">Ugandan format: +256 700 123456 or 0700123456</small>
                    </div>

                    <!-- Password Field -->
                    <div style="margin-bottom: 8px;">
                        <label style="display: block; margin-bottom: 8px; font-size: 0.85rem; font-weight: 500; color: #333;">
                            Password <span style="color: #DC2626;">*</span>
                        </label>
                        <div style="display: flex; align-items: stretch;">
                            <div style="padding: 12px 14px; background: #f5f5f5; border: 1.5px solid #e8e8e8; border-right: none; border-radius: 30px 0 0 30px; display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9B6B9F" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                            <div style="flex: 1; position: relative;">
                                <input type="password" id="student_password" name="password" placeholder="Create a strong password" style="width: 100%; padding: 12px 40px 12px 15px; border: 1.5px solid #e8e8e8; border-left: none; border-radius: 0 30px 30px 0; font-size: 15px; outline: none; font-family: inherit;">
                                <svg class="toggle-password" onclick="togglePassword('student_password')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; width: 20px; height: 20px; fill: #888;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 13c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div id="passwordStrength" style="font-size: 11px; margin-bottom: 15px; margin-left: 12px;"></div>
                    <small style="font-size: 0.7rem; color: #6c6c6c; margin-left: 12px; display: block; margin-top: -8px; margin-bottom: 12px;">
                        Requirements: 8+ chars, 1 uppercase, 1 lowercase, 1 number, 1 special (@$!%*?&)
                    </small>

                    <!-- Confirm Password Field -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-size: 0.85rem; font-weight: 500; color: #333;">
                            Confirm Password <span style="color: #DC2626;">*</span>
                        </label>
                        <div style="display: flex; align-items: stretch;">
                            <div style="padding: 12px 14px; background: #f5f5f5; border: 1.5px solid #e8e8e8; border-right: none; border-radius: 30px 0 0 30px; display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9B6B9F" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                            <div style="flex: 1; position: relative;">
                                <input type="password" id="student_confirm_password" name="password_confirmation" placeholder="Confirm your password" style="width: 100%; padding: 12px 40px 12px 15px; border: 1.5px solid #e8e8e8; border-left: none; border-radius: 0 30px 30px 0; font-size: 15px; outline: none; font-family: inherit;">
                                <svg class="toggle-password" onclick="toggleConfirmPassword('student_confirm_password')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; width: 20px; height: 20px; fill: #888;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 13c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Terms Checkbox -->
                    <div style="margin: 20px 0 25px;">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" id="termsCheckbox" style="width: 18px; height: 18px; accent-color: #6B46C1;">
                            <span style="color: #555; font-size: 0.85rem;">I agree to the <a href="{{ url('/users/terms-and-conditions') }}" style="color: #DC2626; text-decoration: none; font-weight: 500;">terms and policies</a></span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="button" id="submitUserInformation" style="width: 100%; padding: 15px; background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%); color: white; border: none; border-radius: 50px; font-size: 16px; font-weight: 600; cursor: pointer; transition: transform 0.2s, opacity 0.2s; margin-bottom: 20px;">
                        <i class="fas fa-user-plus"></i> Create a new account
                    </button>
                </form>

                <!-- Login Link -->
                <div style="text-align: center; padding-top: 15px; border-top: 0px solid #f0f0f0;">
                    <span style="color: #6c6c6c;">Already have an account?</span>
                    <a href="{{ url('/users/login') }}" style="background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%); -webkit-background-clip: text; background-clip: text; color: transparent; font-weight: 600; text-decoration: none; margin-left: 5px;">Login Here</a>
                </div>
                <div style="text-align: center; padding-top: 15px; border-top: 0px solid #f0f0f0;">
                    <span style="color: #6c6c6c;">Return to </span>
                    <a href="{{ url('/users/home-page') }}"
                        style="background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%); -webkit-background-clip: text; background-clip: text; color: transparent; font-weight: 600; text-decoration: none; margin-left: 5px;">Homepage</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .toggle-password {
            cursor: pointer;
        }
        .strength-weak { color: #dc3545; }
        .strength-medium { color: #ffc107; }
        .strength-strong { color: #28a745; }
        input:focus {
            border-color: #6B46C1 !important;
            box-shadow: 0 0 0 2px rgba(107, 70, 193, 0.1);
        }
        .is-valid {
            border-color: #28a745 !important;
        }
        .is-invalid {
            border-color: #dc3545 !important;
        }
        button:hover {
            opacity: 0.95;
            transform: scale(0.98);
        }
    </style>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function toggleConfirmPassword(fieldId) {
            const input = document.getElementById(fieldId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function checkPasswordStrength(password) {
            let strength = 0;
            let message = '';
            let className = '';
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]+/)) strength++;
            if (password.match(/[A-Z]+/)) strength++;
            if (password.match(/[0-9]+/)) strength++;
            if (password.match(/[@$!%*?&]+/)) strength++;
            
            switch(strength) {
                case 0:
                case 1:
                    message = '⚠️ Very Weak';
                    className = 'strength-weak';
                    break;
                case 2:
                    message = '⚠️ Weak';
                    className = 'strength-weak';
                    break;
                case 3:
                    message = '📈 Medium';
                    className = 'strength-medium';
                    break;
                case 4:
                    message = '✅ Strong';
                    className = 'strength-strong';
                    break;
                case 5:
                    message = '✅✅ Very Strong';
                    className = 'strength-strong';
                    break;
            }
            
            if (password.length === 0) {
                message = '';
                className = '';
            }
            
            return { message, className };
        }

        // Phone number validation (required)
        function validatePhoneNumber(phone) {
            // Allows international format (+256...), Ugandan format (07...), with spaces and dashes
            const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,20}$/;
            return phoneRegex.test(phone);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Real-time password strength
            $('#student_password').on('keyup', function() {
                const password = $(this).val();
                const strength = checkPasswordStrength(password);
                $('#passwordStrength').html(`<span class="${strength.className}">${strength.message}</span>`);
                
                const confirm = $('#student_confirm_password').val();
                if (confirm) {
                    if (password === confirm) {
                        $('#student_confirm_password').removeClass('is-invalid').addClass('is-valid');
                    } else {
                        $('#student_confirm_password').removeClass('is-valid').addClass('is-invalid');
                    }
                }
            });
            
            $('#student_confirm_password').on('keyup', function() {
                const password = $('#student_password').val();
                const confirm = $(this).val();
                if (password === confirm && password !== '') {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            });

            $('#submitUserInformation').on('click', function(e) {
                e.preventDefault();

                var button = $(this);
                button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Creating account...');

                var fullname = $('#student_fullname').val().trim();
                var username = $('#student_username').val().trim();
                var email = $('#student_mail').val().trim();
                var phone = $('#student_phone').val().trim();
                var password = $('#student_password').val();
                var confirmPassword = $('#student_confirm_password').val();
                var termsAccepted = $('#termsCheckbox').is(':checked');

                var errorMessages = [];

                $('#student_fullname, #student_username, #student_mail, #student_phone, #student_password, #student_confirm_password, #termsCheckbox').removeClass('is-invalid is-valid');

                // Full Name validation
                if (!fullname) {
                    errorMessages.push("Full Name is required.");
                    $('#student_fullname').addClass('is-invalid');
                } else if (fullname.length < 3) {
                    errorMessages.push("Full Name must be at least 3 characters long.");
                    $('#student_fullname').addClass('is-invalid');
                } else {
                    $('#student_fullname').addClass('is-valid');
                }

                // Username validation
                if (!username) {
                    errorMessages.push("Username is required. You'll use this to login.");
                    $('#student_username').addClass('is-invalid');
                } else if (username.length < 3) {
                    errorMessages.push("Username must be at least 3 characters long.");
                    $('#student_username').addClass('is-invalid');
                } else if (!/^[a-zA-Z0-9_]+$/.test(username)) {
                    errorMessages.push("Username can only contain letters, numbers, and underscores.");
                    $('#student_username').addClass('is-invalid');
                } else {
                    $('#student_username').addClass('is-valid');
                }

                // Email validation
                var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!email) {
                    errorMessages.push("Email is required. You'll also use this to login.");
                    $('#student_mail').addClass('is-invalid');
                } else if (!emailRegex.test(email)) {
                    errorMessages.push("Please enter a valid email address.");
                    $('#student_mail').addClass('is-invalid');
                } else {
                    $('#student_mail').addClass('is-valid');
                }

                // Phone number validation (Required)
                if (!phone) {
                    errorMessages.push("Phone number is required for account recovery.");
                    $('#student_phone').addClass('is-invalid');
                } else if (!validatePhoneNumber(phone)) {
                    errorMessages.push("Please enter a valid phone number. Example: +256 700 123456 or 0700123456");
                    $('#student_phone').addClass('is-invalid');
                } else {
                    $('#student_phone').addClass('is-valid');
                }

                // Password validation
                if (!password) {
                    errorMessages.push("Password is required.");
                    $('#student_password').addClass('is-invalid');
                } else {
                    var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                    if (!passwordRegex.test(password)) {
                        errorMessages.push("Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).");
                        $('#student_password').addClass('is-invalid');
                    } else {
                        $('#student_password').addClass('is-valid');
                    }
                }

                // Confirm password validation
                if (!confirmPassword) {
                    errorMessages.push("Confirm Password is required.");
                    $('#student_confirm_password').addClass('is-invalid');
                } else if (password !== confirmPassword) {
                    errorMessages.push("Passwords do not match.");
                    $('#student_password').addClass('is-invalid');
                    $('#student_confirm_password').addClass('is-invalid');
                } else if (password && password === confirmPassword) {
                    $('#student_confirm_password').addClass('is-valid');
                }

                // Terms validation
                if (!termsAccepted) {
                    errorMessages.push("Please agree to the terms and policy.");
                    $('#termsCheckbox').addClass('is-invalid');
                } else {
                    $('#termsCheckbox').addClass('is-valid');
                }

                if (errorMessages.length > 0) {
                    var errorList = '<ul style="text-align: left;">';
                    errorMessages.forEach(function(error, index) {
                        errorList += '<li>' + (index + 1) + '. ' + error + '</li>';
                    });
                    errorList += '</ul>';

                    Swal.fire({
                        title: 'Validation Error!',
                        html: errorList,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });

                    button.prop('disabled', false).html('<i class="fas fa-user-plus"></i> Create a new account');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Please confirm that all the information is correct before creating your account.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, create my account!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form_data = new FormData();
                        form_data.append('_token', '{{ csrf_token() }}');
                        form_data.append('fullname', fullname);
                        form_data.append('username', username);
                        form_data.append('email', email);
                        form_data.append('phone', phone);
                        form_data.append('password', password);
                        form_data.append('password_confirmation', confirmPassword);
                        form_data.append('terms', termsAccepted ? '1' : '0');

                        $.ajax({
                            url: "{{ route('user-account-creation') }}",
                            method: "POST",
                            data: form_data,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: response.title || 'Account Created Successfully!',
                                        html: response.message || 'Your account has been successfully created. You can now login using your username or email.',
                                        confirmButtonText: 'Go to Student Dashboard'
                                    }).then(() => {
                                        window.location.href = "{{ url('/') }}";
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: response.title || 'Account Creation Failed',
                                        html: response.message || 'There was an issue creating your account. Please try again.',
                                        confirmButtonText: 'OK'
                                    });
                                }
                                button.prop('disabled', false).html('<i class="fas fa-user-plus"></i> Create a new account');
                            },
                            error: function(data) {
                                try {
                                    const response = data.responseJSON;
                                    if (response && response.message) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            html: response.message,
                                            confirmButtonText: 'OK'
                                        });
                                    } else if (response && response.errors) {
                                        var errorHtml = '<ul style="text-align: left;">';
                                        Object.values(response.errors).forEach(function(error) {
                                            errorHtml += '<li>' + error + '</li>';
                                        });
                                        errorHtml += '</ul>';
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Validation Error',
                                            html: errorHtml,
                                            confirmButtonText: 'OK'
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            html: 'An unexpected error occurred. Please try again.',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                } catch (e) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        html: 'An unexpected error occurred. Please try again.',
                                        confirmButtonText: 'OK'
                                    });
                                }
                                button.prop('disabled', false).html('<i class="fas fa-user-plus"></i> Create a new account');
                            }
                            // error: function(data) {
                            // $('body').html(data.responseText);
                            // }
                        });
                    } else {
                        button.prop('disabled', false).html('<i class="fas fa-user-plus"></i> Create a new account');
                    }
                });
            });
        });
    </script>
@endsection