<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate</title>
    <style>

        
        body {
            font-family: 'Georgia', serif;
            text-align: center;
            padding: 60px 20px;
            background: #f2f2f2;
            color: #2c3e50;
        }

        .certificate-container {
            background: #fff url("{{ public_path('images/watermark.png') }}") no-repeat center;
            background-size: 60%;
            border: 16px solid #2c3e50;
            padding: 60px 40px;
            position: relative;
            width: 100%;
            margin: auto;
        }

        .certificate-title {
            font-size: 42px;
            font-weight: bold;
            color: #34495e;
            margin-bottom: 10px;
        }

        .recipient-name {
            font-size: 32px;
            margin: 20px 0;
            font-style: italic;
            font-weight: 500;
        }

        .course-title {
            font-size: 24px;
            font-weight: 600;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .date {
            font-size: 16px;
            margin-top: 40px;
        }

        .signature {
            margin-top: 60px;
            display: flex;
            justify-content: space-around;
            font-size: 14px;
        }

        .signature .sig-block {
            width: 200px;
            border-top: 1px solid #2c3e50;
            padding-top: 5px;
        }

        .logo {
            width: 80px;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .seal {
            width: 70px;
            position: absolute;
            bottom: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <img src="{{ public_path('assets/images/uplogo.png') }}" class="logo" alt="Logo">
        <h1 class="certificate-title">Certificate of Completion</h1>
        <p>This is to certify that</p>
        <div class="recipient-name">
            {{ $user->firstname }} {{ $user->lastname }}
        </div>
        <p>has successfully completed the course</p>
        <div class="course-title">"{{ $course->title }}"</div>
        <p class="date">Awarded on {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>
        <div class="signature">
            <div class="sig-block">Instructor Name<br><em>Course Instructor</em></div>
            <div class="sig-block">Platform Admin<br><em>Administrator</em></div>
        </div>
        <img src="{{ public_path('assets/images/uplogo.png') }}" class="seal" alt="Seal">
    </div>
</body>
</html>
