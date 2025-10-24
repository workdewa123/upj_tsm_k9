<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Booking Service TSM')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzLlQ36k2UaYJtU378F7xXvP+sN4fFw/U6/A2uB4aU+M+F1U+A9P7y+W+W+Z+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            background-color: #f8f9fa; /* Latar belakang area konten */
            padding-top: 56px; /* Tinggi navbar fixed-top */
        }

        /* Navbar Atas */
        .navbar {
            z-index: 1030; /* Pastikan di atas elemen lain */
        }

        /* Sidebar Styling (Icon-Only, tidak lagi fixed di kiri) */
        .sidebar {
            width: 4.5rem; /* Lebar tetap */
            background-color: #f8f9fa; /* bg-body-tertiary */
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); /* Optional: shadow */
            height: calc(100vh - 56px); /* Tinggi sisa viewport */
            /* Dihapus: position: fixed, top, left, bottom, z-index, transisi */
             display: flex; /* Aktifkan flexbox */
             flex-direction: column; /* Susun vertikal */
             flex-shrink: 0; /* Jangan menyusut */
             overflow-y: auto; /* Scroll jika perlu (untuk profile) */
        }

        /* Konten Utama */
        .main-content {
             flex-grow: 1; /* Ambil sisa ruang horizontal */
             overflow-y: auto; /* Konten bisa di-scroll */
             height: calc(100vh - 56px); /* Tinggi sisa viewport */
             padding: 1.5rem; /* Padding area konten */
        }

        /* Wrapper untuk menempatkan sidebar dan konten utama berdampingan */
        .admin-layout-wrapper {
            display: flex;
            height: calc(100vh - 56px); /* Mengisi sisa tinggi setelah navbar */
        }

        /* Sidebar Nav Link Styling */
        .sidebar .nav-link {
            padding: .75rem 1rem;
            color: #dc3545; /* Ikon warna merah */
            text-align: center;
            font-size: 1.25rem;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover {
            background-color: #e9ecef;
            color: #ae212f; /* Merah gelap hover */
        }

        .sidebar .nav-link.active {
            background-color: #dc3545; /* Background merah aktif */
            color: #fff; /* Ikon putih aktif */
            border-left-color: #ae212f; /* Border kiri */
        }

        /* Profile Dropdown di Bawah Sidebar */
        .sidebar .profile-dropdown {
             margin-top: auto; /* Dorong ke bawah */
             border-top: 1px solid #dee2e6;
        }
        .sidebar .dropdown-toggle::after { display: none; }
        .sidebar .profile-image { width: 32px; height: 32px; }
        .sidebar .profile-dropdown .dropdown-menu {
             /* Pastikan dropdown muncul di tempat yang benar */
            position: absolute !important;
            inset: auto 0px 0px auto !important;
            transform: translate3d(calc(4.5rem + 5px), -45px, 0px) !important;
        }

        /* Style untuk toggler icon navbar */
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .navbar-toggler { border: none; padding: 0.25rem 0.5rem; }
        .navbar-toggler:focus { box-shadow: none; }

        /* Responsive: Sidebar disembunyikan di mobile, konten full width */
        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed; /* Kembali fixed agar bisa di-toggle */
                transform: translateX(-100%); /* Sembunyikan */
                z-index: 1040; /* Di atas overlay */
                 height: 100vh; /* Tinggi penuh saat mobile */
                 padding-top: 56px; /* Ruang untuk navbar */
                 transition: transform 0.3s ease-in-out;
            }
             .sidebar.show {
                transform: translateX(0); /* Tampilkan */
            }
            .admin-layout-wrapper {
                 display: block; /* Hapus flex */
                 height: auto;
            }
            .main-content {
                height: auto; /* Tinggi otomatis */
                 width: 100%; /* Lebar penuh */
            }
             .navbar {
                 width: 100%; /* Navbar full width di mobile */
             }
        }

    </style>
</head>
<body>

    @auth
        @if(Auth::user()->role === 'admin')
            {{-- ================= NAVBAR ATAS (ADMIN) ================= --}}
            <nav class="navbar navbar-expand-md navbar-dark bg-danger shadow-sm fixed-top">
                <div class="container-fluid">
                    {{-- Tombol Toggler untuk Sidebar di Mobile --}}
                    {{-- data-bs-target diubah ke #sidebarMenu --}}
                     <button class="navbar-toggler d-md-none me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    {{-- Brand/Logo --}}
                    <a class="navbar-brand fw-bold ms-md-3" href="{{ route('admin.dashboard') }}"> {{-- <i class="fas fa-tools fs-4 text-center d-block text-white"></i> --}}<i class="fas fa-tools me-2 text-white"></i>
                       Admin Panel
                    </a>

                    {{-- Spacer --}}
                    <div class="d-flex flex-grow-1"></div>

                    {{-- Navigasi Kanan (HANYA Logout di layar besar) --}}
                    <ul class="navbar-nav flex-row align-items-center d-none d-md-flex">
                         {{-- Profile sekarang ada di sidebar --}}
                         <li class="nav-item me-3">
                              <span class="nav-link text-white"><i class="fas fa-user-circle fa-lg"></i> <span class="ms-1">{{ Auth::user()->name }}</span></span>
                         </li>
                         {{-- Tombol Logout --}}
                         <li class="nav-item">
                            <form id="logout-form-admin-nav" action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm d-flex align-items-center">
                                    <i class="fas fa-sign-out-alt me-1"></i>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

             {{-- Wrapper untuk Layout Admin (Sidebar + Konten) --}}
             <div class="admin-layout-wrapper">

                {{-- ================= SIDEBAR (ADMIN - ICON ONLY) ================= --}}
                {{-- Dikeluarkan dari navbar, ID ditambahkan, collapse ditambahkan --}}
                <div class="d-flex flex-column flex-shrink-0 sidebar collapse d-md-flex" id="sidebarMenu">
                    {{-- Navigasi Utama --}}
                    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }} py-3 border-bottom rounded-0"
                               title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="right">
                                <i class="fas fa-fw fa-home"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('booking.index') }}" class="nav-link {{ Route::is('booking.index') || Route::is('booking.show') ? 'active' : '' }} py-3 border-bottom rounded-0"
                               title="Semua Booking" data-bs-toggle="tooltip" data-bs-placement="right">
                                 <i class="fas fa-fw fa-book-open"></i>
                            </a>
                        </li>
                        @if(Route::has('booking.queue'))
                        <li>
                            <a href="{{ route('booking.queue') }}" class="nav-link {{ Route::is('booking.queue') ? 'active' : '' }} py-3 border-bottom rounded-0"
                               title="Antrian Hari Ini" data-bs-toggle="tooltip" data-bs-placement="right">
                                 <i class="fas fa-fw fa-clipboard-list"></i>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="{{ route('customers.index') }}" class="nav-link {{ Route::is('customers.index') || Route::is('customers.bookings') ? 'active' : '' }} py-3 border-bottom rounded-0"
                               title="Customer" data-bs-toggle="tooltip" data-bs-placement="right">
                                <i class="fas fa-fw fa-users"></i>
                            </a>
                        </li>
                         @if(Route::has('advisor.create'))
                        <li>
                            <a href="{{ route('advisor.create') }}" class="nav-link {{ Route::is('advisor.create') ? 'active' : '' }} py-3 border-bottom rounded-0"
                               title="Advisor Form" data-bs-toggle="tooltip" data-bs-placement="right">
                                 <i class="fas fa-fw fa-user-tie"></i>
                            </a>
                        </li>
                         @endif
                    </ul>

                    {{-- Profile Dropdown di bawah --}}
                    <div class="dropdown border-top profile-dropdown">
                        <a href="#" class="d-flex align-items-center justify-content-center p-3 link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                             <i class="fas fa-user-circle fs-4 text-secondary"></i>
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            @if(Route::has('profile'))
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                 <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
                                 <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                                    Sign out
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- AKHIR SIDEBAR ICON ONLY --}}

                {{-- ================= KONTEN UTAMA (Admin) ================= --}}
                <div class="main-content">
                    <main> {{-- Hapus class container/container-fluid dari sini --}}
                         @yield('content')
                    </main>
                </div>

            </div> {{-- Akhir admin-layout-wrapper --}}


        @elseif(Auth::user()->role === 'customer')
            {{-- ================= NAVBAR ATAS (CUSTOMER - Layout normal) ================= --}}
             <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
                {{-- ... (Navbar customer tetap sama) ... --}}
                <div class="container">
                    <a class="navbar-brand" href="{{ route('customer.dashboard') }}">
                        <i class="fas fa-motorcycle me-2"></i> Bengkel Servis
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#customerNavbarNav" aria-controls="customerNavbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="customerNavbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('customer.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('customer.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                                </a>
                            </li>
                            @if(Route::has('booking.create'))
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('booking.create') ? 'active fw-bold' : '' }}" href="{{ route('booking.create') }}">
                                    <i class="fas fa-calendar-plus me-1"></i> Buat Booking
                                </a>
                            </li>
                            @endif
                            @if(Route::has('profile'))
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('profile') ? 'active fw-bold' : '' }}" href="{{ route('profile') }}">
                                    <i class="fas fa-user-edit me-1"></i> Edit Profil
                                </a>
                            </li>
                            @endif
                        </ul>
                         <ul class="navbar-nav ms-2">
                            <li class="nav-item">
                                 <form id="logout-form-customer" action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center">
                                         <i class="fas fa-sign-out-alt me-1"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            {{-- Konten Customer (Langsung di bawah navbar) --}}
            <main class="container py-4"> {{-- Customer pakai container biasa --}}
                @yield('content')
            </main>
        @endif
    @else
        {{-- Jika tidak login (Tamu) --}}
        <main> {{-- Tanpa navbar, tanpa padding atas --}}
             @yield('content')
        </main>
    @endif


    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script untuk mengaktifkan Tooltip Bootstrap --}}
    <script>
        // Inisialisasi semua tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

    @yield('scripts') {{-- Tempat untuk script tambahan per halaman --}}

</body>
</html>