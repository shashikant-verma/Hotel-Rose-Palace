<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Rose Palace - Where Elegance Meets Comfort')</title>
    <meta name="description" content="@yield('meta_description', 'Experience luxury hospitality at Hotel Rose Palace, Surat. Premium rooms, dining, and world-class amenities.')">
    <meta name="keywords" content="@yield('meta_keywords', 'hotel, luxury, Surat, rooms, booking, hospitality')">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite CSS -->
    @vite('resources/css/app.css')
    
    @yield('extra_css')
</head>
<body>
    <!-- Navigation -->
    @include('components.navbar')
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('components.footer')
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Vite JS -->
    @vite('resources/js/app.js')
    
    @yield('extra_js')
</body>
</html>
