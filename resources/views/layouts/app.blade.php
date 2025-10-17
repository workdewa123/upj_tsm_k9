<!DOCTYPE html>
<html>
<head>
    <title>Booking Service</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    @yield('content')
    <!-- Tambahkan Font Awesome untuk Ikon (Ditempatkan di sini jika tidak ada di app.blade.php) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzLlQ36k2UaYJtU378F7xXvP+sN4fFw/U6/A2uB4aU+M+F1U+A9P7y+W+W+Z+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Perlu CSS Kustom untuk efek "Soft Badge" -->
<style>
    /* Contoh implementasi Soft Badge jika tidak menggunakan Bootstrap kit lanjutan */
    .badge-soft-warning { background-color: #fff3cd; }
    .badge-soft-info { background-color: #cff4fc; }
    .badge-soft-primary { background-color: #cfe2ff; }
    .badge-soft-success { background-color: #d1e7dd; }
    .badge-soft-danger { background-color: #f8d7da; }
    /* Menambahkan padding ke body agar konten tidak tertutup fixed navbar */
    body { padding-top: 70px; }
</style>

<!-- ========================================================================= -->
<!-- NAVBAR ADMIN KEKINIAN (FIXED TOP) -->
<!-- ========================================================================= -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tools me-2"></i> Admin Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('booking.index') }}"><i class="fas fa-book me-1"></i> Semua Booking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customers.index') }}"><i class="fas fa-users me-1"></i> Customer</a>
                </li>
                <!-- Tautan ke Halaman Advisor -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('advisor.create') }}"><i class="fas fa-user-tie me-1"></i> Advisor</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-2">
                <li class="nav-item">
                    <a class="btn btn-outline-light btn-sm" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

</body>
</html>
