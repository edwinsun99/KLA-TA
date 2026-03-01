<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Integrated Service Delivery 2026')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-ungu: #6a0dad;
            --secondary-orange: #ff8c00;
            --hover-bg: #f3e5f5;
            --header-height: 70px;
            --sidebar-mini-width: 72px;
            --sidebar-expand-width: 240px;
            --transition-speed: 0.3s;
        }

        body {
            margin: 0;
            background-color: #f9f9f9;
            font-family: 'Roboto', Arial, sans-serif;
            overflow-x: hidden;
        }

        /* --- HEADER --- */
        .header {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--header-height);
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 2000; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .header-left { display: flex; align-items: center; gap: 10px; }
        .header-left img { height: 45px; object-fit: contain; }

        .header-center { flex: 0 1 600px; margin: 0 20px; }
        .search-input { border-radius: 20px 0 0 20px !important; border-color: #ddd; }
        .search-btn { 
            border-radius: 0 20px 20px 0 !important; 
            background: #f8f8f8; 
            border: 1px solid #ddd;
            border-left: none;
            padding: 0 15px;
        }

        .header-right { display: flex; align-items: center; gap: 15px; }

        /* --- SIDEBAR --- */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0; bottom: 0;
            width: var(--sidebar-mini-width);
            background: #ffffff;
            overflow-y: auto;
            overflow-x: hidden;
            transition: width var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1500;
            border-right: 1px solid #e5e5e5;
        }

        .sidebar.expanded { width: var(--sidebar-expand-width); }

        .menu-item {
            display: flex;
            align-items: center;
            height: 50px;
            padding: 0 24px;
            text-decoration: none;
            color: #444;
            transition: 0.2s;
            white-space: nowrap;
            border-left: 4px solid transparent;
        }

        .menu-item:hover { background: var(--hover-bg); color: var(--primary-ungu); }
        .menu-item.active { 
            border-left-color: var(--secondary-orange); 
            background: var(--hover-bg); 
            color: var(--primary-ungu); 
            font-weight: 600;
        }
        
        .menu-item i { font-size: 1.4rem; min-width: 28px; margin-right: 20px; color: var(--primary-ungu); }
        .menu-item span { font-size: 14px; opacity: 0; transition: opacity 0.2s; }
        .sidebar.expanded .menu-item span { opacity: 1; }

        /* --- CONTENT --- */
        .content {
            padding: 25px;
            margin-top: var(--header-height);
            margin-left: var(--sidebar-mini-width);
            transition: margin-left var(--transition-speed) ease;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1400;
            display: none;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { display: block; }
        .hide-caret::after { display: none !important; }
    </style>
</head>

<body>
    <div id="overlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <header class="header">
        <div class="header-left">
            <i class="bi bi-list fs-2 text-dark" style="cursor:pointer" onclick="toggleSidebar()"></i>
            <a href="{{ route('cm.home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </a>
        </div>

        <div class="header-center">
            <form action="{{ route('cm.case.search') }}" method="GET" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control search-input" placeholder="Search by COF ID, SN, or Phone...">
                <button class="btn search-btn" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <div class="header-right">
            
            <div class="dropdown">
                <a href="#" class="dropdown-toggle hide-caret" data-bs-toggle="dropdown">
                    <img src="{{ Auth::user()->profile_photo ? asset('storage/'.Auth::user()->profile_photo) : asset('images/default-avatar.png') }}" 
                         width="45" height="45" class="rounded-circle border border-2" style="object-fit: cover; border-color: var(--primary-ungu) !important;">
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3 mt-3 shadow-lg border-0" style="width: 280px; border-radius: 15px;">
                    <li class="text-center pb-3 border-bottom mb-2">
                        <img src="{{ Auth::user()->profile_photo ? asset('storage/'.Auth::user()->profile_photo) : asset('images/default-avatar.png') }}" 
                             width="70" height="70" class="rounded-circle mb-2 border" style="object-fit: cover;">
                        <div class="fw-bold fs-5 text-dark">{{ Auth::user()->username }}</div>
                        <div class="fw-bold text-purple small">Call Management</div>
                    </li>
                    <li><a class="dropdown-item py-2" href="{{ route('cm.profile.edit') }}"><i class="bi bi-person-gear me-2"></i> Edit Profil</a></li>
                    <li><a class="dropdown-item py-2 text-danger" href="#" onclick="confirmLogout(event)"><i class="bi bi-box-arrow-right me-2"></i> Sign Out</a></li>
                </ul>
            </div>
        </div>
    </header>

    <nav class="sidebar" id="mySidebar">
        <a href="{{ route('cm.home') }}" class="menu-item mt-2 {{ request()->routeIs('cm.home') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> <span>Home</span>
        </a>

        <a href="{{ route('cm.quotreq.index') }}" class="menu-item {{ request()->routeIs('ce.quotreq.index') ? 'active' : '' }}">
            <i class="bi bi-gem"></i> <span>Quotation Request</span>
        </a>

        <a href="{{ route('cm.case.index') }}" class="menu-item {{ request()->routeIs('cm.case.index') ? 'active' : '' }}">
            <i class="bi bi-folder"></i> <span>View Case</span>
        </a>
    </nav>

    <main class="content" id="mainContent">
        @yield('content')
    </main>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("mySidebar");
            const overlay = document.getElementById("overlay");
            sidebar.classList.toggle("expanded");
            overlay.classList.toggle("active");
        }
        function confirmLogout(event) {
            event.preventDefault();
            if (confirm('Sign out from your account?')) { document.getElementById('logout-form').submit(); }
        }
    </script>
</body>
</html>