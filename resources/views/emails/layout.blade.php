<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name'))</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            color: #1f2937;
        }

        .email-wrapper {
            width: 100%;
            padding: 30px 0;
        }

        .email-content {
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .email-header {
            background-color: #0ea5e9;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .email-body {
            padding: 30px;
        }

        .email-footer {
            font-size: 12px;
            color: #6b7280;
            text-align: center;
            padding: 20px;
        }

        .button {
            display: inline-block;
            background-color: #0ea5e9;
            color: white;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #0284c7;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <div class="email-header">
                <h2>@yield('header', config('app.name'))</h2>
            </div>
            <div class="email-body">
                @yield('content')
            </div>
        </div>
        <div class="email-footer">
            &copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
