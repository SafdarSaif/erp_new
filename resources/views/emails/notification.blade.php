<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        /* GLOBAL -------------------------- */
        body {
            margin: 0;
            background: #eef2f7;
            padding: 35px 15px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #444;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        /* HEADER -------------------------- */
        .header {
            background: #ffffff;
            padding: 35px 30px 25px 30px;
            text-align: center;
            border-bottom: 1px solid #e8eef3;
        }

        .header img.logo {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        .category {
            display: inline-block;
            background: #007bff;
            color: #fff;
            padding: 7px 18px;
            font-size: 13px;
            border-radius: 20px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            font-weight: 600;
        }

        h1.title {
            font-size: 26px;
            margin: 5px 0;
            font-weight: 700;
            color: #2c3e50;
        }

        .theme-info {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .theme-address {
            font-size: 12px;
            color: #777;
            margin-bottom: 10px;
        }

        /* BODY CONTENT -------------------------- */
        .content {
            padding: 35px 30px;
        }

        .content p {
            font-size: 16px;
            line-height: 1.75;
            color: #555;
            margin-top: 0;
        }

        /* DETAILS BOX -------------------------- */
        .details-box {
            background: #f7f9fc;
            border-left: 4px solid #007bff;
            padding: 18px 22px;
            border-radius: 8px;
            margin: 25px 0;
            color: #444;
            font-size: 15px;
        }

        /* BUTTON -------------------------- */
        .btn-center {
            text-align: center;
            margin: 35px 0;
        }

        .btn {
            display: inline-block;
            background: #007bff;
            padding: 14px 35px;
            color: #fff !important;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: 0.25s;
            box-shadow: 0 6px 18px rgba(0, 123, 255, 0.25);
        }

        .btn:hover {
            background: #0067d4;
        }

        /* FOOTER -------------------------- */
        .footer {
            text-align: center;
            padding: 22px;
            background: #f8fafc;
            font-size: 13px;
            color: #777;
            border-top: 1px solid #e8eef3;
        }

        /* RESPONSIVE -------------------------- */
        @media (max-width: 600px) {

            .content,
            .header {
                padding: 22px 18px;
            }

            h1.title {
                font-size: 22px;
            }

            .btn {
                padding: 12px 26px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- HEADER -->
        <div class="header">

            <!-- CATEGORY -->
            @if(!empty($header))
            <div class="category">{{ $header->name ?? $header }}</div>
            @endif

            <!-- TITLE -->
            <h1 class="title">{{ $title }}</h1>
        </div>

        <!-- CONTENT -->
        <div class="content">
            <p>{{ $description }}</p>

            @if(!empty($details))
            <div class="details-box">
                {!! $details !!}
            </div>
            @endif

            @if(!empty($action_link))
            <div class="btn-center">
                <a href="{{ $action_link }}" class="btn">Take Action</a>
            </div>
            @endif
        </div>

        <!-- FOOTER -->
       <!-- FOOTER -->
@php
    $theme = \App\Models\Theme::where('is_active', 1)->first();
@endphp

<div class="footer" style="background:#f8fafc; border-top:1px solid #e8eef3; text-align:center; padding:20px 15px; font-size:13px; color:#555; line-height:1.6;">

    @if($theme)
        {{-- Theme Name --}}
        <div style="font-weight:600; margin-bottom:3px;">{{ $theme->name }}</div>

        {{-- Address --}}
        @if($theme->address)
            <div style="font-size:12px; color:#777; margin-bottom:5px;">
                {!! $theme->address !!}
            </div>
        @endif

        {{-- Copyright --}}
        <div style="font-size:12px; color:#777;">
            © {{ date('Y') }} {{ $theme->name }} — All Rights Reserved.
        </div>
    @else
        <div style="font-size:12px; color:#777;">
            © {{ date('Y') }} {{ config('app.name') }} — All Rights Reserved.
        </div>
    @endif

</div>



    </div>

</body>

</html>
