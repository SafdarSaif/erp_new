<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .email-container {
            background-color: #ffffff;
            max-width: 650px;
            margin: 40px auto;
            border-radius: 12px;
            padding: 35px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            border-top: 6px solid #3498db;
            overflow: hidden;
        }

        .category-badge {
            display: inline-block;
            background: #3498db;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 50px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .email-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .email-header img {
            width: 70px;
            margin-bottom: 12px;
        }

        h2 {
            font-size: 28px;
            margin: 0;
            color: #2c3e50;
            font-weight: 700;
        }

        p {
            font-size: 16px;
            line-height: 1.8;
            color: #555555;
            margin: 18px 0;
        }

        .details {
            background-color: #f9fafc;
            border-left: 5px solid #3498db;
            padding: 18px 22px;
            border-radius: 8px;
            margin: 25px 0;
            color: #444;
            font-size: 15px;
        }

        .button {
            display: inline-block;
            text-decoration: none;
            background: linear-gradient(90deg, #3498db 0%, #217dbb 100%);
            color: #fff;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .button:hover {
            background: linear-gradient(90deg, #217dbb 0%, #1a5a8a 100%);
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #888888;
            margin-top: 35px;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .email-container {
                padding: 25px 20px;
            }

            h2 {
                font-size: 22px;
            }

            p,
            .details {
                font-size: 15px;
            }

            .button {
                padding: 12px 24px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">

        <!-- Optional Category Badge -->
        @if(!empty($header))
        <div class="category-badge">
            {{ $header->name ?? $header }}
        </div>
        @endif

        <!-- Header with logo -->
        <div class="email-header">
            <img src="{{ $logo ?? 'https://via.placeholder.com/70x70?text=Logo' }}" alt="Logo">
            <h2>{{ $title }}</h2>
        </div>

        <!-- Main description -->
        <p>{{ $description }}</p>

        <!-- Optional Details Box -->
        @if(!empty($details))
        <div class="details">
            {{ $details }}
        </div>
        @endif

        <!-- Optional Action Button -->
        @if(!empty($action_link))
        <p style="text-align:center; margin:30px 0;">
            <a href="{{ $action_link }}" class="button">Take Action</a>
        </p>
        @endif

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
