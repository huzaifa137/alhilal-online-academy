<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Ugandan Programmer</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #6B46C1 0%, #DC2626 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .splash-container {
            text-align: center;
            padding: 32px;
            animation: fadeInScale 0.6s ease-out;
        }

        .logo-wrapper {
            animation: floatAnimation 2s ease-in-out infinite;
        }

        /* Logo Image Styling */
        .logo-image {
            max-width: 200px;
            width: 100%;
            height: auto;
            filter: drop-shadow(0 10px 25px rgba(0,0,0,0.2));
            border-radius: 20px;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes floatAnimation {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .loading-bar {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
            overflow: hidden;
        }

        .loading-progress {
            width: 0%;
            height: 100%;
            background: white;
            border-radius: 3px;
            animation: loadProgress 2s ease-out forwards;
        }

        @keyframes loadProgress {
            0% {
                width: 0%;
            }
            100% {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="splash-container">
        <div class="logo-wrapper">
            <!-- Using your AlHilal Online.jpeg image - just the logo -->
            <img src="{{ asset('assets/images/alhilal_logo.jpeg') }}" alt="AlHilal Online Logo" class="logo-image">
        </div>
        <div class="loading-bar">
            <div class="loading-progress"></div>
        </div>
    </div>

    <script>
        // Auto redirect to login page after 2 seconds
        setTimeout(() => {
            window.location.href = "{{ route('users.login') }}";
        }, 2000);
    </script>
</body>
</html>