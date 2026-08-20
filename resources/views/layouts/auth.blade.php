<!-- resources/views/layouts/auth.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentication')</title>
    <!-- Tailwind CSS CDN (or use your Vite build) -->
     <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        amber: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                            950: '#451a03',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-amber-50 min-h-screen flex items-center justify-center p-4 antialiased">
    <div class="w-full max-w-md">
        @yield('content')
    </div>
</body>
</html>