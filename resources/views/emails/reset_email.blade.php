<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Summary of Password Reset Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
    </style>
</head>
<body>

    <h1>Summary of Password Reset Email</h1>

    <p>Dear <span style="color:green"> {{ $username }}, </span></p>

    <p>This email is to inform you that a request has been made to reset the password for the supplier portal account associated with your email address, {{ $email }}. However, no changes have been made to your account at this time.</p>

    <p>You can reset your password by clicking the provided link: {{ $resetUrl }}. If you did not request this password reset, please disregard this email, or you may inform us by replying directly. Remember, this is an automated message from the UP, so do not reply to this email.</p>

</body>
</html>
