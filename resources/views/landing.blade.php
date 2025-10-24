@extends('layouts.app')

@section('title', 'Selamat Datang di Bengkel Kami')

@section('content')
{{-- CSS Khusus TIDAK DIGUNAKAN, mengandalkan Bootstrap murni --}}
<style>
    /* Hapus atau komentari style sebelumnya jika ada */
    /* .hero-section { ... } */
    /* .section-title { ... } */
    /* .gallery-img { ... } */
    /* .gallery-img:hover { ... } */

    /* Tambahkan style untuk background hero jika ingin tetap pakai gambar */
    .hero-section-bg {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset("images/gbr_1.png") }}'); /* Ganti dengan gambar Anda */
        background-size: cover;
        background-position: center;
    }

    .gallery-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 0.5rem;
    }

    /* Warna ikon fitur menjadi merah */
    .feature-icon-small {
        background-color: var(--bs-danger-bg-subtle) !important; /* Warna latar merah muda */
        color: var(--bs-danger-text-emphasis) !important; /* Warna ikon merah */
    }
</style>

{{-- 1. Hero Section --}}
{{-- Tambahkan class hero-section-bg untuk background gambar --}}
<div class="hero-section-bg text-center text-white py-5">
    <div class="container py-lg-5">
        <h1 class="display-3 fw-bold">Servis Motor Profesional & Terpercaya</h1>
        <p class="lead my-4 col-md-8 mx-auto text-white-50">
            Solusi booking servis online tanpa antri. Pelayanan terbaik dengan mekanik berpengalaman dan suku cadang orisinal.
        </p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            {{-- Tombol utama menjadi merah --}}
            <a href="{{ route('booking.create') }}" class="btn btn-danger btn-lg px-4 gap-3">
                <i class="fas fa-calendar-alt me-2"></i>Booking Servis Sekarang
            </a>
            {{-- Tombol sekunder tetap outline light agar kontras --}}
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">Login Pelanggan</a>
        </div>
    </div>
</div>

{{-- 2. Tentang Kami & Keunggulan --}}
<div class="container px-4 py-5">
    {{-- Judul section dengan border merah --}}
    <h2 class="pb-2 border-bottom border-danger text-center mb-5 fw-bold text-dark">Kenapa Memilih Kami?</h2>
    <div class="row row-cols-1 row-cols-md-2 align-items-md-center g-5 py-5">
      <div class="col d-flex flex-column align-items-start gap-2">
        <h2 class="fw-bold text-body-emphasis">Servis Cepat, Hasil Hebat.</h2>
        <p class="text-body-secondary">Komitmen kami adalah memberikan pelayanan servis berkualitas tinggi dengan cepat. Sistem booking online membebaskan Anda dari antrian panjang.</p>
        {{-- Tombol menjadi merah --}}
        <a href="{{ route('booking.create') }}" class="btn btn-danger btn-lg">Booking Sekarang</a>
      </div>

      <div class="col">
        <div class="row row-cols-1 row-cols-sm-2 g-4">
          {{-- Mengganti text-bg-primary menjadi text-bg-danger pada ikon fitur --}}
          <div class="col d-flex flex-column gap-2">
            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center fs-4 rounded-3 mb-2" style="width: 3rem; height: 3rem;">
              <i class="fas fa-tools"></i>
            </div>
            <h4 class="fw-semibold mb-0 text-dark">Mekanik Profesional</h4>
            <p class="text-body-secondary">Tim mekanik kami bersertifikat dan berpengalaman.</p>
          </div>

          <div class="col d-flex flex-column gap-2">
            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center fs-4 rounded-3 mb-2" style="width: 3rem; height: 3rem;">
                <i class="fas fa-certificate"></i>
            </div>
            <h4 class="fw-semibold mb-0 text-dark">Suku Cadang Asli</h4>
            <p class="text-body-secondary">Hanya menggunakan suku cadang orisinal untuk motor Anda.</p>
          </div>

          <div class="col d-flex flex-column gap-2">
            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center fs-4 rounded-3 mb-2" style="width: 3rem; height: 3rem;">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <h4 class="fw-semibold mb-0 text-dark">Harga Transparan</h4>
            <p class="text-body-secondary">Estimasi biaya jelas di awal, tanpa biaya tersembunyi.</p>
          </div>

          <div class="col d-flex flex-column gap-2">
            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center fs-4 rounded-3 mb-2" style="width: 3rem; height: 3rem;">
                <i class="fas fa-clock"></i>
            </div>
            <h4 class="fw-semibold mb-0 text-dark">Pengerjaan Tepat Waktu</h4>
            <p class="text-body-secondary">Menghargai waktu Anda dengan pengerjaan sesuai estimasi.</p>
          </div>
        </div>
      </div>
    </div>
</div>

{{-- 3. Galeri Kegiatan --}}
<div class="bg-light">
    <div class="container px-4 py-5 text-center">
         {{-- Judul section dengan warna merah --}}
        <h2 class="mb-5 fw-bold text-danger">Galeri Bengkel Kami</h2>
        <div class="row gx-4 gy-4">
            {{-- Ganti URL gambar sesuai kebutuhan --}}
            <div class="col-md-4">
                <img src="{{ asset('images/gbr_1.png') }}" alt="Proses Servis" class="gallery-img shadow-sm">
            </div>
            <div class="col-md-4">
                <img src="https://placehold.co/600x400/dc3545/fff?text=Mekanik+Bekerja" alt="Mekanik Bekerja" class="gallery-img shadow-sm">
            </div>
            <div class="col-md-4">
                <img src="https://placehold.co/600x400/6c757d/fff?text=Pengecekan+Mesin" alt="Pengecekan Mesin" class="gallery-img shadow-sm">
            </div>
            <div class="col-md-4">
                <img src="https://imgx.gridoto.com/crop/0x0:0x0/700x465/photo/gridoto/2018/01/19/67284655.jpg" alt="Suasana Bengkel" class="gallery-img shadow-sm">
            </div>
            <div class="col-md-4">
                <img src="https://placehold.co/600x400/ffc107/fff?text=Ganti+Oli" alt="Ganti Oli" class="gallery-img shadow-sm">
            </div>
            <div class="col-md-4">
                <img src="https://placehold.co/600x400/198754/fff?text=Pelanggan+Puas" alt="Pelanggan Puas" class="gallery-img shadow-sm">
            </div>
        </div>
    </div>
</div>

{{-- 4. Footer --}}
<div class="container">
  {{-- Border atas footer menjadi merah --}}
  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top border-danger-subtle">
    <div class="col-md-4 d-flex align-items-center">
      <span class="mb-3 mb-md-0 text-body-secondary">© {{ date('Y') }} Bengkel TSM</span>
    </div>

    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
      {{-- Ganti href="#" dengan link sosial media Anda --}}
      <li class="ms-3"><a class="text-danger" href="#"><i class="fab fa-twitter"></i></a></li>
      <li class="ms-3"><a class="text-danger" href="#"><i class="fab fa-instagram"></i></a></li>
      <li class="ms-3"><a class="text-danger" href="#"><i class="fab fa-facebook"></i></a></li>
    </ul>
  </footer>
</div>

@endsection