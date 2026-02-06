<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Booking Service TSM')</title>

    {{-- Google Fonts: Poppins (Lebih tebal dan jelas untuk UI) --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        :root {
            --header-height: 70px;
            --sidebar-width: 80px; /* Sidebar Ikon Ramping */
            --primary-color: #dc3545; /* Merah Bootstrap */
            --bg-light: #f4f6f9;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            overflow-x: hidden; /* Mencegah scroll horizontal */
        }

        /* --- 1. NAVBAR (Header) --- */
        .admin-header {
            height: var(--header-height);
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .brand-logo {
            font-size: 1.25rem;
            font-weight: 700;
            color: #212529;
            text-decoration: none;
            display: flex;
            align-items: center;
            /* Pastikan logo tidak bergeser */
            min-width: 200px; 
        }

        /* --- 2. SIDEBAR (Kiri Bawah Navbar) --- */
        .admin-sidebar {
            position: fixed;
            top: var(--header-height); /* Tepat di bawah navbar */
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background-color: #212529; /* Gelap Solid agar jelas */
            z-index: 1020;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 1rem;
            transition: transform 0.3s ease;
        }

        /* Item Sidebar */
        .sidebar-link {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd; /* Abu-abu terang */
            border-radius: 10px;
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .sidebar-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: #ffffff;
        }

        /* Aktif State (Merah) */
        .sidebar-link.active {
            background-color: var(--primary-color);
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(220, 53, 69, 0.3);
        }

        /* --- 3. KONTEN UTAMA (Kanan Bawah Navbar) --- */
        .admin-main {
            margin-top: var(--header-height);
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: calc(100vh - var(--header-height));
            transition: margin-left 0.3s ease;
        }

        /* --- 4. DROPDOWN PROFILE --- */
        .profile-btn {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            border: 1px solid #dee2e6;
            background: white;
            color: #212529;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .profile-btn:hover {
            background-color: #f8f9fa;
        }

        /* --- RESPONSIVE MOBILE --- */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%); /* Sembunyikan sidebar */
            }
            .admin-sidebar.show {
                transform: translateX(0); /* Tampilkan jika ditoggle */
            }
            .admin-main {
                margin-left: 0; /* Konten full width */
                padding: 1rem;
            }
            /* Tombol Toggle Sidebar (Hanya muncul di mobile) */
            .sidebar-toggler {
                display: block !important;
            }
        }
    </style>
</head>
<body>

    @auth
        @if(Auth::user()->role === 'admin')
            
            {{-- ================= HEADER / NAVBAR (Putih Bersih) ================= --}}
            <header class="admin-header justify-content-between">
                <div class="d-flex align-items-center">
                    {{-- Tombol Menu (Mobile Only) --}}
                    <button class="btn btn-link text-dark p-0 me-3 d-none sidebar-toggler" onclick="toggleSidebar()">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    
                    {{-- LOGO JELAS & BESAR --}}
                    <a href="{{ route('admin.dashboard') }}" class="brand-logo">
                        <i class="fas fa-tools text-danger me-2 fs-4"></i>
                        <span>ADMIN<span class="text-danger">PANEL</span></span>
                    </a>
                </div>

                {{-- Bagian Kanan Header --}}
                <div class="dropdown">
                    <a href="#" class="profile-btn dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fs-5 text-secondary"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        @if(Route::has('profile'))
                        <li><a class="dropdown-item py-2" href="{{ route('profile') }}"><i class="fas fa-user me-2 text-muted"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger fw-bold">
                                    <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </header>

            {{-- ================= SIDEBAR (Gelap & Ramping) ================= --}}
            <aside class="admin-sidebar" id="adminSidebar">
                
                {{-- Menu Navigasi --}}
                <div class="d-flex flex-column gap-2 w-100 align-items-center">
                    
                    {{-- Dashboard --}}
                    <a href="{{ route('admin.dashboard') }}" 
                       class="sidebar-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" 
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                        <i class="fas fa-th-large"></i>
                    </a>

                    {{-- Semua Booking --}}
                    <a href="{{ route('booking.index') }}" 
                       class="sidebar-link {{ Route::is('booking.index') || Route::is('booking.show') ? 'active' : '' }}" 
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Semua Booking">
                        <i class="fas fa-book-open"></i>
                    </a>

                    {{-- Antrian (Jika ada) --}}
                    @if(Route::has('booking.queue'))
                    <a href="{{ route('booking.queue') }}" 
                       class="sidebar-link {{ Route::is('booking.queue') ? 'active' : '' }}" 
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Antrian Hari Ini">
                        <i class="fas fa-clock"></i>
                    </a>
                    @endif

                    {{-- Customer --}}
                    <a href="{{ route('customers.index') }}" 
                       class="sidebar-link {{ Route::is('customers.index') || Route::is('customers.bookings') ? 'active' : '' }}" 
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Data Customer">
                        <i class="fas fa-users"></i>
                    </a>

                    {{-- Advisor (Jika ada) --}}
                    @if(Route::has('advisor.index'))
                    <a href="{{ route('advisor.index') }}" 
                       class="sidebar-link {{ Route::is('advisor.index') ? 'active' : '' }}" 
                       data-bs-toggle="tooltip" data-bs-placement="right" title="Data Advisor">
                        <i class="fas fa-user-tie"></i>
                    </a>
                    @endif

                </div>

                {{-- Spacer untuk mendorong logout ke bawah (opsional, tapi logout sudah di header) --}}
                <div class="mt-auto mb-3">
                    {{-- Ikon info/bantuan opsional di bawah --}}
                    <a href="#" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="right" title="Bantuan">
                        <i class="far fa-question-circle"></i>
                    </a>
                </div>
            </aside>

            {{-- ================= KONTEN UTAMA ================= --}}
            <main class="admin-main">
                @yield('content')
            </main>


        {{-- ================= LAYOUT CUSTOMER (TIDAK BERUBAH) ================= --}}
        @elseif(Auth::user()->role === 'customer')
             <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top" style="height: 70px;">
                <div class="container">
                    <a class="navbar-brand fw-bold" href="{{ route('customers.dashboard') }}">
                        <i class="fas fa-motorcycle me-2 text-danger"></i> Bengkel Servis
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#customerNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="customerNav">
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="nav-item"><a class="nav-link text-white" href="{{ route('customers.dashboard') }}">Dashboard</a></li>
                            @if(Route::has('booking.create'))
                            <li class="nav-item"><a class="nav-link text-white" href="{{ route('booking.create') }}">Buat Booking</a></li>
                            @endif
                            <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger rounded-pill px-4 btn-sm">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <main class="container py-5" style="margin-top: 80px;">
                @yield('content')
            </main>
        @endif
    @else
        {{-- LAYOUT TAMU --}}
        <main>
             @yield('content')
        </main>
    @endif

    {{-- Script Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // 1. Script Toggle Sidebar untuk Mobile
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('show');
        }

        // 2. Script Tooltip Bootstrap (Wajib untuk Sidebar Icon-Only)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    
    @yield('scripts')
</body>
</html>