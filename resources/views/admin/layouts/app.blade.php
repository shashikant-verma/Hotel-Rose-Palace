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
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* ═══════════════════════════════════════════════════════════════════════
           LUXURY DESIGN SYSTEM - CHAMPAGNE SANDSTONE & BURGUNDY ROSE
           Admin Layout (Phases 10-13)
        ═══════════════════════════════════════════════════════════════════════ */

        :root {
            /* Champagne Sandstone & Burgundy Rose Color Palette */
            --color-sandstone-base: #EDE4D8;
            --color-champagne: #F7F1E8;
            --color-beige: #E2D5C3;
            --color-border-subtle: #D8CBB8;
            --color-burgundy-rose: #6E2C3A;
            --color-burgundy-dark: #58222E;
            --color-brass-gold: #B88A44;
            --color-charcoal-deep: #2E1F22;
            --color-mauve-grey: #5E4B4E;
            --color-cream: #FAF6F0;
            
            /* Functional Colors */
            --color-success: #27ae60;
            --color-warning: #F39C12;
            --color-danger: #E74C3C;
            --color-info: #3498DB;
            
            /* Typography */
            --font-heading: 'Playfair Display', 'Cormorant Garamond', Georgia, serif;
            --font-ui: 'Plus Jakarta Sans', 'Inter', sans-serif;
            
            /* Layout */
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: var(--font-ui);
            background-color: var(--color-sandstone-base);
            color: var(--color-charcoal-deep);
        }

        body {
            padding-top: 70px;
        }

        /* ─── TOPBAR ────────────────────────────────────────────────────────────── */
        .admin-topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: 70px;
            background-color: var(--color-champagne);
            border-bottom: 1px solid var(--color-border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            z-index: 999;
            box-shadow: 0 2px 8px rgba(46, 31, 34, 0.06);
        }

        .admin-topbar .topbar-title {
            font-family: var(--font-heading);
            font-size: 22px;
            font-weight: 700;
            color: var(--color-charcoal-deep);
            margin: 0;
        }

        .admin-topbar .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-topbar .view-site-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background-color: var(--color-beige);
            color: var(--color-charcoal-deep);
            border: 1px solid var(--color-border-subtle);
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .admin-topbar .view-site-btn:hover {
            background-color: var(--color-cream);
            border-color: var(--color-brass-gold);
            color: var(--color-burgundy-rose);
        }

        /* ─── SIDEBAR ───────────────────────────────────────────────────────────── */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--color-beige);
            border-right: 1px solid var(--color-border-subtle);
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 24px 16px;
            border-bottom: 1px solid var(--color-border-subtle);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header svg {
            width: 36px;
            height: 36px;
        }

        .sidebar-header-text {
            font-family: var(--font-heading);
            font-size: 16px;
            font-weight: 700;
            color: var(--color-charcoal-deep);
            line-height: 1.2;
        }

        .sidebar-menu {
            padding: 24px 0;
        }

        .sidebar-menu-section-title {
            padding: 8px 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--color-mauve-grey);
            margin-top: 16px;
            display: block;
        }

        .sidebar-menu-section-title:first-child {
            margin-top: 0;
        }

        .sidebar-menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: var(--color-mauve-grey);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            border-left: 3px solid transparent;
        }

        .sidebar-menu-item i {
            width: 20px;
            text-align: center;
            flex-shrink: 0;
            font-size: 16px;
        }

        .sidebar-menu-item:hover {
            background-color: rgba(110, 44, 58, 0.06);
            color: var(--color-charcoal-deep);
        }

        .sidebar-menu-item.active {
            background-color: rgba(110, 44, 58, 0.12);
            color: var(--color-burgundy-rose);
            border-left-color: var(--color-burgundy-rose);
            border-radius: 0 50px 50px 0;
        }

        .sidebar-menu-item.active i {
            color: var(--color-brass-gold);
        }

        /* ─── MAIN CONTENT ──────────────────────────────────────────────────────── */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            padding: 32px;
            background-color: var(--color-sandstone-base);
        }

        /* ─── STAT CARDS ────────────────────────────────────────────────────────── */
        .stat-card {
            background: var(--color-champagne);
            border: 1px solid var(--color-border-subtle);
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(46, 31, 34, 0.06);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(46, 31, 34, 0.12);
            border-color: var(--color-brass-gold);
        }

        .stat-card .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
            background: rgba(184, 138, 68, 0.1);
            color: var(--color-brass-gold);
        }

        .stat-card h3 {
            font-family: var(--font-heading);
            font-size: 36px;
            font-weight: 700;
            color: var(--color-charcoal-deep);
            margin-bottom: 8px;
            line-height: 1;
        }

        .stat-card p {
            color: var(--color-mauve-grey);
            margin: 0;
            font-size: 14px;
        }

        /* ─── TABLES ────────────────────────────────────────────────────────────── */
        .table-card {
            background: var(--color-champagne);
            border: 1px solid var(--color-border-subtle);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(46, 31, 34, 0.06);
            margin-bottom: 24px;
        }

        .table-card h5 {
            color: var(--color-charcoal-deep);
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .table-card .table {
            margin-bottom: 0;
        }

        .table-card .table thead {
            background-color: var(--color-beige);
            border: none;
        }

        .table-card .table thead th {
            color: var(--color-charcoal-deep);
            font-weight: 700;
            border: 1px solid var(--color-border-subtle);
            padding: 12px 16px;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .table-card .table tbody td {
            color: var(--color-charcoal-deep);
            border: 1px solid var(--color-border-subtle);
            padding: 12px 16px;
            vertical-align: middle;
        }

        .table-card .table tbody tr:hover {
            background-color: rgba(226, 213, 195, 0.3);
        }

        /* ─── BUTTONS ───────────────────────────────────────────────────────────── */
        .btn-primary {
            background-color: var(--color-burgundy-rose);
            border-color: var(--color-burgundy-rose);
            color: var(--color-champagne);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--color-burgundy-dark);
            border-color: var(--color-burgundy-dark);
            color: var(--color-champagne);
            box-shadow: 0 4px 16px rgba(110, 44, 58, 0.3);
        }

        .btn-secondary {
            background-color: var(--color-beige);
            border-color: var(--color-border-subtle);
            color: var(--color-charcoal-deep);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: var(--color-cream);
            border-color: var(--color-burgundy-rose);
            color: var(--color-burgundy-rose);
        }

        .btn-outline-primary {
            color: var(--color-burgundy-rose);
            border-color: var(--color-burgundy-rose);
        }

        .btn-outline-primary:hover {
            background-color: var(--color-burgundy-rose);
            border-color: var(--color-burgundy-rose);
            color: var(--color-champagne);
        }

        /* ─── BADGES ────────────────────────────────────────────────────────────── */
        .badge {
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            font-family: var(--font-ui);
        }

        .bg-primary { background-color: var(--color-burgundy-rose) !important; }
        .bg-success { background-color: var(--color-success) !important; }
        .bg-warning { background-color: var(--color-warning) !important; }
        .bg-danger { background-color: var(--color-danger) !important; }
        .bg-info { background-color: var(--color-info) !important; }

        /* ─── FORMS ─────────────────────────────────────────────────────────────── */
        .form-label {
            color: var(--color-charcoal-deep);
            font-weight: 700;
            font-family: var(--font-ui);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control, .form-select {
            background-color: var(--color-cream);
            border: 1px solid var(--color-border-subtle);
            color: var(--color-charcoal-deep);
            font-family: var(--font-ui);
            border-radius: 8px;
            padding: 10px 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--color-white);
            border-color: var(--color-burgundy-rose);
            box-shadow: 0 0 0 3px rgba(110, 44, 58, 0.1);
            color: var(--color-charcoal-deep);
        }

        .form-control::placeholder {
            color: var(--color-mauve-grey);
        }

        /* ─── ALERTS ────────────────────────────────────────────────────────────── */
        .alert {
            border-radius: 10px;
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background-color: rgba(39, 174, 96, 0.1);
            color: #1e5631;
            border-left: 4px solid #27ae60;
        }

        .alert-danger {
            background-color: rgba(231, 76, 60, 0.1);
            color: #6d2c2c;
            border-left: 4px solid #E74C3C;
        }

        .alert-warning {
            background-color: rgba(243, 156, 18, 0.1);
            color: #7a5a1e;
            border-left: 4px solid #F39C12;
        }

        /* ─── RESPONSIVE ────────────────────────────────────────────────────────── */
        @media (max-width: 768px) {
            :root {
                --sidebar-width: 0;
            }

            body {
                padding-top: 0;
            }

            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 240px;
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-topbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                margin-top: 70px;
                padding: 16px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-card h3 {
                font-size: 28px;
            }

            .table-card {
                padding: 16px;
            }

            .table-responsive {
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .admin-topbar {
                flex-direction: column;
                height: auto;
                gap: 12px;
                padding: 12px 16px;
            }

            .admin-topbar .topbar-title {
                font-size: 18px;
            }

            .main-content {
                padding: 12px;
            }

            .stat-card {
                padding: 12px;
            }
        }

        /* ─── USER MENU ─────────────────────────────────────────────────────────── */
        .user-profile-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--color-brass-gold), var(--color-burgundy-rose));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
        }

        .user-info-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .user-name {
            font-weight: 700;
            font-size: 14px;
            color: var(--color-charcoal-deep);
        }

        .user-role {
            font-size: 12px;
            color: var(--color-mauve-grey);
        }
        /* ─── PMS ENHANCEMENTS & HOUSEKEEPING TOKENS ──────────────────────── */
        .badge-housekeeping {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }
        .badge-housekeeping-clean {
            background-color: rgba(39, 174, 96, 0.15);
            color: #1e5631;
            border-color: rgba(39, 174, 96, 0.35);
        }
        .badge-housekeeping-clean:hover {
            background-color: #27ae60;
            color: #ffffff;
        }
        .badge-housekeeping-dirty {
            background-color: rgba(243, 156, 18, 0.18);
            color: #8c5b08;
            border-color: rgba(243, 156, 18, 0.45);
        }
        .badge-housekeeping-dirty:hover {
            background-color: #f39c12;
            color: #ffffff;
        }
        .badge-housekeeping-maintenance {
            background-color: rgba(231, 76, 60, 0.15);
            color: #8a2419;
            border-color: rgba(231, 76, 60, 0.4);
        }
        .badge-housekeeping-maintenance:hover {
            background-color: #e74c3c;
            color: #ffffff;
        }

        .btn-whatsapp-pms {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #25D366 0%, #1ea952 100%);
            color: #ffffff !important;
            border: none;
            border-radius: 50px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(37, 211, 102, 0.25);
            transition: all 0.2s ease;
        }
        .btn-whatsapp-pms:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(37, 211, 102, 0.35);
            color: #ffffff !important;
        }

        .btn-pms-checkin {
            background-color: #27ae60;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-pms-checkin:hover {
            background-color: #219653;
            color: #ffffff;
        }

        .btn-pms-checkout {
            background-color: #6E2C3A;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-pms-checkout:hover {
            background-color: #58222E;
            color: #ffffff;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="sidebar-header">
            <svg width="36" height="36" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="19" cy="19" r="18" stroke="#6E2C3A" stroke-width="1.2"/>
                <path d="M19 6 L22 12 L28 13.5 L23.5 18.5 L24.8 25 L19 22 L13.2 25 L14.5 18.5 L10 13.5 L16 12 Z" fill="none" stroke="#6E2C3A" stroke-width="1" stroke-linejoin="round"/>
            </svg>
            <div class="sidebar-header-text">
                Hotel Rose<br>Palace
            </div>
        </div>

        <div class="sidebar-menu">
            <span class="sidebar-menu-section-title">Front Desk & PMS</span>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('admin.calendar') }}" class="sidebar-menu-item {{ request()->routeIs('admin.calendar') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Occupancy Calendar
            </a>

            <span class="sidebar-menu-section-title">Reservations</span>
            <a href="{{ route('admin.enquiries.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
                <i class="fas fa-concierge-bell"></i> Room Bookings
            </a>
            <a href="{{ route('admin.banquets.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.banquets.*') ? 'active' : '' }}">
                <i class="fas fa-champagne-glasses"></i> Banquet Bookings
            </a>

            <span class="sidebar-menu-section-title">Hotel Inventory</span>
            <a href="{{ route('admin.rooms.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                <i class="fas fa-bed"></i> Rooms & Housekeeping
            </a>
            <a href="{{ route('admin.room-types.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.room-types.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> Room Types
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                <i class="fas fa-images"></i> Gallery
            </a>
            <a href="{{ route('admin.amenities.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.amenities.*') ? 'active' : '' }}">
                <i class="fas fa-list-check"></i> Amenities
            </a>
            <a href="{{ route('admin.settings.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings
            </a>

            <span class="sidebar-menu-section-title">Account</span>
            <a href="{{ route('admin.profile.show') }}" class="sidebar-menu-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Profile
            </a>
            <a href="{{ route('home') }}" class="sidebar-menu-item" target="_blank">
                <i class="fas fa-globe"></i> View Site
            </a>
            <a href="{{ route('admin.logout') }}" class="sidebar-menu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Topbar -->
    <div class="admin-topbar">
        <h5 class="topbar-title">@yield('page-title', 'Dashboard')</h5>
        <div class="topbar-actions">
            <a href="{{ route('home') }}" class="view-site-btn" target="_blank">
                <i class="fas fa-eye"></i> View Site ↗
            </a>
            <div class="user-profile-section">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="user-info-text">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">Administrator</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Warning!</strong> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
