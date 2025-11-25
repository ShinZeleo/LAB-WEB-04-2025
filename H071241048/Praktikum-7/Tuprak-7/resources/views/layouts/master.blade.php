<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplor Pariwisata Nusantara - Mojokerto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero-section { 
            background: url('images/Home.jpg') no-repeat center center;
            background-size: cover;
            height: 600px;
            display: flex;
            align-items: center;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .nav-link {
            transition-property: color;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header with Navigation -->
    <nav class="bg-gradient-to-r from-blue-900 to-indigo-800 text-white sticky top-0 z-50 shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a class="flex items-center space-x-2 text-xl font-bold" href="{{ url('/') }}">
                    <i class="fas fa-mountain-sun"></i>
                    <span>Eksplor Pariwisata Nusantara</span>
                </a>
                <div class="flex space-x-6">
                    <a class="nav-link font-medium hover:text-blue-300" href="{{ url('/') }}">Home</a>
                    <a class="nav-link font-medium hover:text-blue-300" href="{{ url('/tentang') }}">Tentang</a>
                    <a class="nav-link font-medium hover:text-blue-300" href="{{ url('/destinasi') }}">Destinasi</a>
                    <a class="nav-link font-medium hover:text-blue-300" href="{{ url('/kuliner') }}">Kuliner</a>
                    <a class="nav-link font-medium hover:text-blue-300" href="{{ url('/galeri') }}">Galeri</a>
                    <a class="nav-link font-medium hover:text-blue-300" href="{{ url('/kontak') }}">Kontak</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-blue-800 to-indigo-900 text-white py-12 mt-16">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <p class="text-lg mb-2">&copy; {{ date('Y') }} Eksplor Pariwisata Mojokerto. All rights reserved.</p>
                <p class="text-blue-200">Menjelajahi Keindahan dan Kekayaan Mojokerto</p>
            </div>
        </div>
    </footer>
</body>
</html>