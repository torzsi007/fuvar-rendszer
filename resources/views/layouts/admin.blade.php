<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - FuvarRendszer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .btn-blue { background-color: #3b82f6; color: white; }
        .btn-blue:hover { background-color: #2563eb; }
        .btn-gray { background-color: #6b7280; color: white; }
        .btn-gray:hover { background-color: #4b5563; }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">🚚 FuvarRendszer Admin</h1>
            <div class="space-x-4">
                <span class="text-gray-700">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800">Kijelentkezés</button>
                </form>
            </div>
        </div>
    </nav>
    
    <div class="container mx-auto px-4 py-8">
        @yield('content')
    </div>
</body>
</html>
