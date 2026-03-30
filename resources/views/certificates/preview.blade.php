<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate of Completion</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            text-align: center;
            padding: 60px;
            background: #f2f2f2;
            color: #2c3e50;
        }

        .certificate-container {
            background: #fff url('{{ asset('images/watermark.png') }}') no-repeat center;
            background-size: 60%;
            border: 16px solid #2c3e50;
            padding: 60px 40px;
            position: relative;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.15);
        }

        .certificate-title {
            font-size: 42px;
            font-weight: bold;
            color: #34495e;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 20px;
            color: #7f8c8d;
            margin: 15px 0;
        }

        .recipient-name {
            font-size: 32px;
            margin: 20px 0;
            font-style: italic;
            font-weight: 500;
            color: #2c3e50;
        }

        .course-title {
            font-size: 24px;
            font-weight: 600;
            color: #16a085;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .date {
            font-size: 16px;
            color: #7f8c8d;
            margin-top: 40px;
        }

        .signature {
            margin-top: 60px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 0 40px;
        }

        .signature .sig-block {
            width: 200px;
            border-top: 1px solid #2c3e50;
            text-align: center;
            font-size: 14px;
            padding-top: 5px;
            color: #34495e;
        }

        .logo {
            width: 100px;
            position: absolute;
            top: 40px;
            left: 40px;
        }

        .seal {
            width: 80px;
            position: absolute;
            bottom: 40px;
            right: 40px;
        }

        .certificate-container::before {
            content: '';
            background: url('{{ asset('assets/images/uplogo.png') }}') no-repeat center center;
            background-size: 60%;
            opacity: 0.10;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
    </style>
</head>

<body>
    <div class="certificate-container">
        <img src="{{ asset('assets/images/uplogo.png') }}" alt="Logo" class="logo">
        <h1 class="certificate-title">Certificate of Completion</h1>
        <p class="subtitle">This is to certify that</p>
        <div class="recipient-name">{{ Auth::user()->name ?? 'Recipient Name' }}</div>
        <p class="subtitle">has successfully completed the course</p>
        <div class="course-title">"{{ $course->title ?? 'Course Title' }}"</div>
        <p class="date">Awarded on {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>

        <div class="signature">
            <div class="sig-block">Instructor Name<br><em>Course Instructor</em></div>
            <div class="sig-block">Platform Admin<br><em>Administrator</em></div>
        </div>

        <img src="{{ asset('assets/images/uplogo.png') }}" alt="Official Seal" class="seal">
    </div>
</body>


</html>
