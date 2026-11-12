<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Hotel Rose Palace Admin</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-navy: #1a2332;
            --secondary-gold: #d4af37;
            --accent-burgundy: #6d1f3b;
            --bg-ivory: #faf8f3;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-ivory);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--primary-navy);
            color: white;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 25px 20px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 2px solid var(--secondary-gold);
        }

        .sidebar-header h3 {
            color: var(--secondary-gold);
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu .menu-item {
            padding: 12px 25px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--secondary-gold);
        }

        .sidebar-menu .menu-item.active {
            background: rgba(212, 175, 55, 0.15);
            color: var(--secondary-gold);
            border-left-color: var(--secondary-gold);
        }

        .sidebar-menu .menu-item i {
            width: 25px;
            margin-right: 12px;
            font-size: 16px;
        }

        .sidebar-menu .menu-section {
            padding: 15px 25px 8px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-navbar h4 {
            margin: 0;
            color: var(--primary-navy);
            font-weight: 700;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 15px;
            background: var(--bg-ivory);
            border-radius: 25px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--secondary-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-navy);
            font-weight: 700;
        }

        .btn-logout {
            background: var(--accent-burgundy);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #5a1830;
            transform: translateY(-2px);
        }

        /* Content Area */
        .content-area {
            padding: 30px;
        }

        /* Stats Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-left: 4px solid var(--secondary-gold);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .stat-card h3 {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-navy);
            margin-bottom: 5px;
        }

        .stat-card p {
            color: #666;
            margin: 0;
            font-size: 14px;
        }

        .bg-gold-light { background: rgba(212, 175, 55, 0.1); color: var(--secondary-gold); }
        .bg-blue-light { background: rgba(26, 35, 50, 0.1); color: var(--primary-navy); }
        .bg-green-light { background: rgba(40, 167, 69, 0.1); color: #28a745; }
        .bg-red-light { background: rgba(109, 31, 59, 0.1); color: var(--accent-burgundy); }

        /* Tables */
        .table-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table-card h5 {
            color: var(--primary-navy);
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-area {
                padding: 15px;
            }
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
        }

        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-hotel"></i> Rose Palace</h3>
            <small>Admin Dashboard</small>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section">Main Menu</div>
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>

            <div class="menu-section">Management</div>
            <a href="{{ route('admin.enquiries.index') }}" class="menu-item {{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Enquiries
            </a>
            <a href="{{ route('admin.room-types.index') }}" class="menu-item {{ request()->routeIs('admin.room-types.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> Room Types
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="menu-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                <i class="fas fa-bed"></i> Rooms
            </a>
            <a href="{{ route('admin.settings.index') }}" class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings
            </a>

            <div class="menu-section">Account</div>
            <a href="{{ route('admin.profile.show') }}" class="menu-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <i class="fas fa-user"></i> My Profile
            </a>
            <a href="{{ route('home') }}" class="menu-item" target="_blank">
                <i class="fas fa-globe"></i> View Website
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <h4>@yield('page-title', 'Dashboard')</h4>

            <div class="user-menu">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight: 600; font-size: 14px; color: var(--primary-navy);">
                            {{ Auth::user()->name }}
                        </div>
                        <div style="font-size: 12px; color: #666;">
                            Administrator
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-logout">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
