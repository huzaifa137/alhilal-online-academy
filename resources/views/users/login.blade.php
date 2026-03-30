@extends('layouts.master2')
@section('css')
@endsection
@section('content')
    <!-- Mobile-Optimized Header with Logo -->
    <div style="text-align: center; padding: 40px 20px 30px; background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%); border-radius: 0 0 30px 30px;">
        <img src="{{ asset('assets/images/alhilal_logo.jpeg') }}" alt="Logo" style="max-width: 100px; border-radius: 20px; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
        <h1 style="color: white; font-size: 1.8rem; margin: 10px 0 5px; font-weight: 700;">AlHilal Online Academy</h1>
        <p style="color: rgba(255,255,255,0.9); font-size: 0.9rem;">Sign in to continue learning</p>
    </div>

    <!-- Mobile-Optimized Form Container -->
    <div style="max-width: 500px; margin: -20px auto 0; padding: 0 16px 40px 16px;">
        <div style="background: white; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden;">
            <div style="padding: 30px 24px 35px;">
                <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 8px; background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%); -webkit-background-clip: text; background-clip: text; color: transparent;">Welcome Back! 👋</h2>
                <p style="color: #6c6c6c; font-size: 0.85rem; margin-bottom: 28px; border-bottom: 1px solid #f0f0f0; padding-bottom: 12px;">
                    <i class="fas fa-info-circle"></i> Login with <strong>Username</strong> or <strong>Email</strong>
                </p>

                @include('sweetalert::alert')

                @if (Session::get('success'))
                    <div style="background: #e6f4ea; color: #2b7a4b; padding: 12px 16px; border-radius: 16px; font-size: 0.85rem; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-check-circle"></i> {{ Session::get('success') }}
                    </div>
                @endif

                @if (Session::get('fail'))
                    <div style="background: #fee2e2; color: #DC2626; padding: 12px 16px; border-radius: 16px; font-size: 0.85rem; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; border-left: 3px solid #DC2626;">
                        <i class="fas fa-exclamation-circle"></i> {{ Session::get('fail') }}
                    </div>
                @endif

                <form action="{{ route('auth-user-check') }}" method="POST" id="loginForm">
                    @csrf

                    <!-- Username/Email Field (Now accepts both) -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-size: 0.85rem; font-weight: 500; color: #333;">
                            Username or Email <span style="color: #DC2626;">*</span>
                        </label>
                        <div style="display: flex; align-items: stretch;">
                            <div style="padding: 12px 14px; background: #f5f5f5; border: 1.5px solid #e8e8e8; border-right: none; border-radius: 30px 0 0 30px; display: flex; align-items: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9B6B9F" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <input type="text" id="login" name="login" class="form-control" placeholder="Enter your username or email" style="flex: 1; padding: 12px 15px; border: 1.5px solid #e8e8e8; border-left: none; border-radius: 0 30px 30px 0; font-size: 15px; outline: none; transition: all 0.2s; font-family: inherit;" value="{{ old('login') }}" required>
                        </div>
                    </div>
                    <span class="text-danger" id="loginError"></span>

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
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" style="width: 100%; padding: 12px 40px 12px 15px; border: 1.5px solid #e8e8e8; border-left: none; border-radius: 0 30px 30px 0; font-size: 15px; outline: none; font-family: inherit;" required>
                                <svg class="toggle-password" onclick="togglePassword('password', this)" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; width: 20px; height: 20px; fill: #888;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 13c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div id="passwordStrength" style="font-size: 11px; margin-bottom: 15px; margin-left: 12px;"></div>

                    <!-- Forgot Password Link -->
                    <div style="text-align: right; margin-bottom: 20px;">
                        <a href="{{ url('/users/forgot-password') }}" style="background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%); -webkit-background-clip: text; background-clip: text; color: transparent; text-decoration: none; font-size: 0.85rem; font-weight: 500;">Forgot password?</a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" id="login_button" style="width: 100%; padding: 15px; background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%); color: white; border: none; border-radius: 50px; font-size: 16px; font-weight: 600; cursor: pointer; transition: transform 0.2s, opacity 0.2s; margin-bottom: 20px;">
                        <i class="fas fa-arrow-right-to-bracket"></i> Login
                    </button>
                </form>

                <!-- Register Link -->
                <div style="text-align: center; padding-top: 15px; border-top: 1px solid #f0f0f0;">
                    <span style="color: #6c6c6c;">Don't have an account?</span>
                    <a href="{{ url('/users/register') }}" style="background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%); -webkit-background-clip: text; background-clip: text; color: transparent; font-weight: 600; text-decoration: none; margin-left: 5px;">Register Here</a>
                </div>
                <div style="text-align: center; margin-top: 12px;">
                    <small style="color: #999; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fas fa-info-circle"></i> 
                        <span>Login using your <strong>Username</strong> or <strong>Email</strong> address</span>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <style>
        .toggle-password {
            cursor: pointer;
        }
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
    <script type="text/javascript">
        function togglePassword(fieldId, icon) {
            const input = document.getElementById(fieldId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                var button = $('#login_button');
                button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Logging in...');

                let login = $('#login').val().trim();
                let password = $('#password').val();

                $('#login').removeClass('is-invalid is-valid');
                $('#password').removeClass('is-invalid is-valid');

                let errorMessages = [];

                if (!login) {
                    errorMessages.push("Username or Email is required.");
                    $('#login').addClass('is-invalid');
                } else {
                    $('#login').addClass('is-valid');
                }

                if (!password) {
                    errorMessages.push("Password is required.");
                    $('#password').addClass('is-invalid');
                } else {
                    $('#password').addClass('is-valid');
                }

                if (errorMessages.length > 0) {
                    let errorList = '<ul style="text-align: left;">';
                    errorMessages.forEach((err, i) => {
                        errorList += `<li>${i + 1}. ${err}</li>`;
                    });
                    errorList += '</ul>';

                    Swal.fire({
                        title: 'Validation Error',
                        html: errorList,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });

                    button.prop('disabled', false).html('<i class="fas fa-arrow-right-to-bracket"></i> Login');
                    return;
                }

                $.ajax({
                    url: "{{ route('auth-user-check') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        login: login,
                        password: password
                    },
                    success: function(response) {
                        if (response.status) {
                            window.location.href = response.redirect_url;
                        } else {
                            Swal.fire({
                                title: response.title ?? 'Login Failed',
                                text: response.message ?? 'We don\'t recognize the username/email or password you provided.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                $('#login_button').prop('disabled', false).html('<i class="fas fa-arrow-right-to-bracket"></i> Login');
                            });
                        }
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
                        $('#login_button').prop('disabled', false).html('<i class="fas fa-arrow-right-to-bracket"></i> Login');
                    }
                });
            });
        });
    </script>
@endsection