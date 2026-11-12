<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Hotel Rose Palace')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Admin CSS -->
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-navy: #1a2332;
            --dark-navy: #0f1419;
            --gold: #c9a961;
            --light-bg: #f5f3f0;
            --text-gray: #666;
            --border-color: #e0e0e0;
        }

        body {
            background-color: var(--light-bg);
            color: var(--primary-navy);
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background-color: var(--primary-navy);
            color: white;
            padding: 30px 0;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 0 20px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            text-align: center;
        }

        .sidebar-header h4 {
            margin: 0;
            font-weight: 700;
            font-size: 20px;
            color: var(--gold);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(201, 169, 97, 0.1);
            color: var(--gold);
            border-left-color: var(--gold);
            padding-left: 16px;
        }

        .sidebar-menu i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }

        .sidebar-divider {
            height: 1px;
            background-color: rgba(255, 255, 255, 0.1);
            margin: 15px 0;
        }

        .sidebar-footer {
            padding: 0 20px;
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 6px;
        }

        .sidebar-user-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-navy);
            font-weight: 700;
            font-size: 14px;
            margin-right: 10px;
        }

        .sidebar-user-name {
            flex: 1;
        }

        .sidebar-user-name p {
            margin: 0;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
        }

        .sidebar-user-name strong {
            display: block;
            color: white;
            font-size: 13px;
            margin-top: 2px;
        }

        /* Main Content */
        .admin-main {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Top Bar */
        .admin-topbar {
            background-color: white;
            padding: 20px 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-left h1 {
            margin: 0;
            font-size: 24px;
            color: var(--primary-navy);
            font-weight: 700;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-clock {
            color: var(--text-gray);
            font-size: 14px;
        }

        .topbar-logout {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .topbar-logout:hover {
            background-color: #c0392b;
            text-decoration: none;
            color: white;
        }

        /* Main Content Area */
        .admin-content {
            padding: 30px;
            flex: 1;
            overflow-y: auto;
        }

        /* Alerts */
        .alert {
            border-radius: 6px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }

        /* Cards */
        .admin-card {
            background-color: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
        }

        .admin-card h5 {
            color: var(--primary-navy);
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* Tables */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .admin-table thead {
            background-color: var(--primary-navy);
            color: white;
        }

        .admin-table thead th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border: none;
        }

        .admin-table tbody td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .admin-table tbody tr:hover {
            background-color: var(--light-bg);
        }

        /* Forms */
        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 10px 12px;
            font-size: 14px;
            color: var(--primary-navy);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 169, 97, 0.1);
        }

        .form-label {
            color: var(--primary-navy);
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-navy);
            border-color: var(--primary-navy);
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--dark-navy);
            border-color: var(--dark-navy);
            color: white;
            text-decoration: none;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
            color: white;
            text-decoration: none;
        }

        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
            color: white;
            text-decoration: none;
        }

        .btn-gold {
            background-color: var(--gold);
            border-color: var(--gold);
            color: var(--primary-navy);
            font-weight: 600;
        }

        .btn-gold:hover {
            background-color: #b08e52;
            border-color: #b08e52;
            color: var(--primary-navy);
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                width: 200px;
            }

            .admin-main {
                margin-left: 200px;
            }

            .admin-content {
                padding: 15px;
            }

            .admin-topbar {
                padding: 15px;
            }
        }

        @media (max-width: 576px) {
            .admin-sidebar {
                display: none;
            }

            .admin-main {
                margin-left: 0;
            }
        }
    </style>

    @yield('extra_css')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h4><i class="fas fa-crown"></i> Admin Panel</h4>
                <small style="color: var(--gold);">Hotel Rose Palace</small>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.enquiries.index') }}" class="{{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
                        <i class="fas fa-inbox"></i>
                        <span>Enquiries</span>
                        @if($newEnquiries = \App\Models\Enquiry::where('status', 'new')->count())
                            <span class="badge bg-danger ms-auto">{{ $newEnquiries }}</span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.rooms.index') }}" class="{{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                        <i class="fas fa-door-open"></i>
                        <span>Rooms</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.room-types.index') }}" class="{{ request()->routeIs('admin.room-types.*') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i>
                        <span>Room Types</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-divider"></div>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="sidebar-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="sidebar-user-name">
                        <p>Logged in as</p>
                        <strong>{{ auth()->user()->name }}</strong>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Top Bar -->
            <div class="admin-topbar">
                <div class="topbar-left">
                    <h1>@yield('page_title', 'Dashboard')</h1>
                </div>
                <div class="topbar-right">
                    <div class="topbar-clock" id="current-time">
                        <i class="fas fa-clock"></i> <span id="time-display"></span>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="topbar-logout">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content Area -->
            <div class="admin-content">
                <!-- Alerts -->
                @if($message = session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ $message }}
                    </div>
                @endif

                @if($message = session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> Please fix the errors below:
                        <ul style="margin: 10px 0 0 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Update current time -->
    <script>
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('time-display').textContent = hours + ':' + minutes;
        }
        updateTime();
        setInterval(updateTime, 60000);
    </script>

    @yield('extra_js')
</body>
</html>
