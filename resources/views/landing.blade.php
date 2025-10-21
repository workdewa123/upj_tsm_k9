@extends('layouts.app')

@section('title', 'Selamat Datang di Bengkel Kami')

@section('content')
{{-- CSS Khusus untuk Landing Page --}}
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://placehold.co/1920x1080/888/fff?text=Gambar+Bengkel+Anda');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 8rem 0;
    }
    .section-title {
        font-weight: 700;
        color: #343a40;
    }
    .service-icon {
        font-size: 3rem;
        color: #0d6efd;
    }
    .gallery-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 0.5rem;
        transition: transform 0.3s ease-in-out;
    }
    .gallery-img:hover {
        transform: scale(1.05);
    }
</style>

{{-- 1. Hero Section --}}
<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-3 fw-bold">Servis Motor Profesional & Terpercaya</h1>
        <p class="lead my-4 col-md-8 mx-auto">
            Solusi booking servis online tanpa antri. Kami memberikan pelayanan terbaik dengan mekanik berpengalaman dan suku cadang orisinal untuk performa motor Anda.
        </p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a href="{{ route('booking.create') }}" class="btn btn-primary btn-lg px-4 gap-3">
                <i class="fas fa-calendar-alt me-2"></i>Booking Servis Sekarang
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">Login Pelanggan</a>
        </div>
    </div>
</div>

{{-- Tempat untuk section selanjutnya --}}

{{-- 2. Tentang Kami & Keunggulan --}}
<div class="container px-4 py-5">
    <h2 class="pb-2 border-bottom section-title text-center mb-5">Kenapa Memilih Kami?</h2>
    <div class="row row-cols-1 row-cols-md-2 align-items-md-center g-5 py-5">
      <div class="col d-flex flex-column align-items-start gap-2">
        <h2 class="fw-bold text-body-emphasis">Servis Cepat, Hasil Hebat.</h2>
        <p class="text-body-secondary">Kami berkomitmen untuk memberikan pelayanan servis yang tidak hanya cepat tetapi juga berkualitas tinggi. Dengan sistem booking online, Anda bisa mengucapkan selamat tinggal pada antrian panjang dan ketidakpastian.</p>
        <a href="{{ route('booking.create') }}" class="btn btn-primary btn-lg">Booking Sekarang</a>
      </div>

      <div class="col">
        <div class="row row-cols-1 row-cols-sm-2 g-4">
          <div class="col d-flex flex-column gap-2">
            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-4 rounded-3 mb-2" style="width: 3rem; height: 3rem;">
              <i class="fas fa-tools"></i>
            </div>
            <h4 class="fw-semibold mb-0">Mekanik Profesional</h4>
            <p class="text-body-secondary">Tim kami terdiri dari mekanik bersertifikat dan berpengalaman.</p>
          </div>

          <div class="col d-flex flex-column gap-2">
            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-4 rounded-3 mb-2" style="width: 3rem; height: 3rem;">
                <i class="fas fa-certificate"></i>
            </div>
            <h4 class="fw-semibold mb-0">Suku Cadang Asli</h4>
            <p class="text-body-secondary">Kami hanya menggunakan suku cadang orisinal untuk motor Anda.</p>
          </div>

          <div class="col d-flex flex-column gap-2">
            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-4 rounded-3 mb-2" style="width: 3rem; height: 3rem;">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <h4 class="fw-semibold mb-0">Harga Transparan</h4>
            <p class="text-body-secondary">Tidak ada biaya tersembunyi. Estimasi biaya diberikan di awal.</p>
          </div>

          <div class="col d-flex flex-column gap-2">
            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-4 rounded-3 mb-2" style="width: 3rem; height: 3rem;">
                <i class="fas fa-clock"></i>
            </div>
            <h4 class="fw-semibold mb-0">Pengerjaan Tepat Waktu</h4>
            <p class="text-body-secondary">Kami menghargai waktu Anda dengan pengerjaan sesuai estimasi.</p>
          </div>
        </div>
      </div>
    </div>
</div>

{{-- 3. Galeri Kegiatan --}}
<div class="bg-light">
    <div class="container px-4 py-5 text-center">
        <h2 class="section-title mb-5">Galeri Bengkel Kami</h2>
        <div class="row gx-4 gy-4">
            <div class="col-md-4">
                <img src={{ asset('images/gbr_1.png') }} alt="Proses Servis" class="gallery-img shadow">
            </div>
            <div class="col-md-4">
                <img src="https://placehold.co/600x400/555/fff?text=Mekanik+Bekerja" alt="Mekanik Bekerja" class="gallery-img shadow">
            </div>
            <div class="col-md-4">
                <img src="https://placehold.co/600x400/555/fff?text=Pengecekan+Mesin" alt="Pengecekan Mesin" class="gallery-img shadow">
            </div>
            <div class="col-md-4">
                <img src="https://imgx.gridoto.com/crop/0x0:0x0/700x465/photo/gridoto/2018/01/19/67284655.jpg" alt="Suasana Bengkel" class="gallery-img shadow">
            </div>
            <div class="col-md-4">
                <img src="https://placehold.co/600x400/555/fff?text=Ganti+Oli" alt="Ganti Oli" class="gallery-img shadow">
            </div>
            <div class="col-md-4">
                <img src="https://placehold.co/600x400/555/fff?text=Pelanggan+Puas" alt="Pelanggan Puas" class="gallery-img shadow">
            </div>
        </div>
    </div>
</div>

{{-- 4. Footer --}}
<div class="container">
  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <div class="col-md-4 d-flex align-items-center">
      <span class="mb-3 mb-md-0 text-body-secondary">© {{ date('Y') }} Bengkel TSM, Inc</span>
    </div>

    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
      <li class="ms-3"><a class="text-body-secondary" href="#"><i class="fab fa-twitter"></i></a></li>
      <li class="ms-3"><a class="text-body-secondary" href="#"><i class="fab fa-instagram"></i></a></li>
      <li class="ms-3"><a class="text-body-secondary" href="#"><i class="fab fa-facebook"></i></a></li>
    </ul>
  </footer>
</div>

@endsection