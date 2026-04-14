<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Al-Hilal Academy' }}</title>
    <style>
        /* Reset styles for email clients */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #FDFBF7 0%, #F7F3EE 100%);
            color: #1A0A2E;
            padding: 20px;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #FDFBF7;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(107, 70, 193, 0.16);
            border: 1px solid rgba(107, 70, 193, 0.12);
        }

        /* Header Section */
        .email-header {
            background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%);
            padding: 48px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .email-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            transform: rotate(45deg);
        }

        .logo {
            font-size: 48px;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
        }

        .email-header h1 {
            color: white;
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .email-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            position: relative;
            z-index: 1;
        }

        /* Content Section */
        .email-content {
            padding: 40px 32px;
        }

        .welcome-message {
            background: linear-gradient(135deg, #EDE9FA 0%, #FEE2E2 100%);
            padding: 24px;
            border-radius: 16px;
            margin-bottom: 32px;
            border-left: 4px solid #6B46C1;
        }

        .welcome-message h2 {
            color: #4C2E8A;
            font-size: 22px;
            margin-bottom: 8px;
        }

        .welcome-message p {
            color: #3B2459;
            font-size: 15px;
        }

        /* Account Details Card */
        .details-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
            border: 1px solid rgba(107, 70, 193, 0.12);
            box-shadow: 0 2px 12px rgba(107, 70, 193, 0.08);
        }

        .details-card h3 {
            color: #4C2E8A;
            font-size: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .details-card h3::before {
            content: '📋';
            font-size: 20px;
        }

        .detail-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid rgba(107, 70, 193, 0.08);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 120px;
            font-weight: 600;
            color: #6B6584;
        }

        .detail-value {
            flex: 1;
            color: #1A0A2E;
            font-weight: 500;
        }

        .detail-value strong {
            background: #EDE9FA;
            padding: 4px 8px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 14px;
        }

        /* Important Notes */
        .important-notes {
            background: #FEF3C7;
            border-left: 4px solid #D97706;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 32px;
        }

        .important-notes h4 {
            color: #D97706;
            font-size: 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .important-notes h4::before {
            content: '⚠️';
        }

        .important-notes ul {
            margin-left: 20px;
            color: #3B2459;
        }

        .important-notes li {
            margin-bottom: 8px;
            font-size: 14px;
        }

        /* Action Button */
        .action-button {
            text-align: center;
            margin: 32px 0;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%);
            color: white !important;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 12px rgba(107, 70, 193, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 70, 193, 0.4);
        }

        /* Help Section */
        .help-section {
            background: #F7F3EE;
            padding: 24px;
            border-radius: 16px;
            margin-top: 32px;
            text-align: center;
        }

        .help-section h4 {
            color: #4C2E8A;
            font-size: 16px;
            margin-bottom: 12px;
        }

        .help-section p {
            color: #6B6584;
            font-size: 14px;
            margin-bottom: 16px;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .contact-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #6B46C1;
            font-size: 13px;
        }

        /* Footer */
        .email-footer {
            background: #EDE9FA;
            padding: 32px;
            text-align: center;
            border-top: 1px solid rgba(107, 70, 193, 0.12);
        }

        .social-links {
            margin-bottom: 20px;
        }

        .social-links a {
            color: #6B46C1;
            text-decoration: none;
            margin: 0 10px;
            font-size: 20px;
        }

        .copyright {
            color: #6B6584;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .address {
            color: #6B6584;
            font-size: 11px;
        }

        @media (max-width: 480px) {
            .email-content {
                padding: 24px 20px;
            }

            .email-header {
                padding: 32px 20px;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-label {
                width: 100%;
                margin-bottom: 4px;
            }

            .btn {
                padding: 12px 24px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-header">
            <div class="logo">{{ $logo ?? '🎓' }}</div>
            <h1>{{ $header_title ?? 'Al-Hilal Online Academy' }}</h1>
            <p>{{ $header_subtitle ?? '' }}</p>
        </div>

        <div class="email-content">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="social-links">
                <a href="#" style="text-decoration: none;">📘</a>
                <a href="#" style="text-decoration: none;">🐦</a>
                <a href="#" style="text-decoration: none;">📸</a>
                <a href="#" style="text-decoration: none;">💼</a>
            </div>
            <div class="copyright">
                © {{ date('Y') }} Al-Hilal Online Academy. All rights reserved.
            </div>
            <div class="address">
                Kampala, Uganda | info@alhilalacademy.com | +256 700 123456
            </div>
            <div class="address" style="margin-top: 10px;">
                This email was sent to {{ $email }}. If you didn't create this account, please contact us immediately.
            </div>
        </div>
    </div>
</body>

</html>