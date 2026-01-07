<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etalase Ekonomi Lokal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        html,
        body {
            background: transparent !important;
            background-attachment: initial;
        }
    </style>
</head>

<body class="min-h-screen text-gray-800">

    @include('layouts.partials.navbar')

    <main class="container mx-auto px-4 py-8">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    @include('layouts.partials.footer')

    <!-- Alpine.js for lightweight interactivity -->
    <script src="https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
</body>

</html>
