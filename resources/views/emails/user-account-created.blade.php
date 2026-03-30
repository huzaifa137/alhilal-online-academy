<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 0;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 30px;
        }
        .welcome-message {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .account-details {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .detail-row {
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .detail-label {
            font-weight: bold;
            color: #495057;
            display: inline-block;
            width: 100px;
        }
        .detail-value {
            color: #212529;
            font-family: monospace;
            font-size: 14px;
        }
        .password-box {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .password-box .detail-value {
            font-weight: bold;
            font-size: 16px;
            color: #856404;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .warning {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            border-radius: 4px;
        }
        .warning p {
            margin: 0;
            color: #721c24;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
                margin: 10px;
            }
            .content {
                padding: 20px;
            }
            .button {
                display: block;
                text-align: center;
            }
            .detail-label {
                display: block;
                width: auto;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to {{ config('app.name') }}! 🎉</h1>
        </div>
        
        <div class="content">
            <div class="welcome-message">
                <p>Hello <strong>{{ $username }}</strong>,</p>
                <p>Your account has been successfully created in the {{ config('app.name') }} system.</p>
            </div>
            
            <div class="account-details">
                <div class="detail-row">
                    <span class="detail-label">Username:</span>
                    <span class="detail-value">{{ $username }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Account Type:</span>
                    <span class="detail-value">Internal User</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Created Date:</span>
                    <span class="detail-value">{{ now()->format('F j, Y H:i:s') }}</span>
                </div>
            </div>
            
            <div class="password-box">
                <div class="detail-row">
                    <span class="detail-label">Temporary Password:</span>
                    <span class="detail-value">1212</span>
                </div>
                <p style="margin-top: 10px; font-size: 12px; color: #856404;">
                    ⚠️ Please change this password after your first login for security reasons.
                </p>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="button">Login to Your Account</a>
            </div>
            
            <div class="warning">
                <p><strong>⚠️ Security Note:</strong></p>
                <p>This password is temporary. We strongly recommend changing it immediately after logging in. Never share your password with anyone.</p>
            </div>
            
            <p><strong>Getting Started:</strong></p>
            <ul>
                <li>Use the button above to access your account</li>
                <li>Login with your username/email and the temporary password provided</li>
                <li>You'll be prompted to change your password on first login</li>
                <li>Update your profile information and preferences</li>
            </ul>
            
            <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
            
            <p>Best regards,<br>
            <strong>{{ config('app.name') }} Team</strong></p>
        </div>
        
        <div class="footer">
            <p>This is an automated message from {{ config('app.name') }}. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p><a href="{{ url('/privacy') }}">Privacy Policy</a> | <a href="{{ url('/terms') }}">Terms of Service</a></p>
        </div>
    </div>
</body>
</html>