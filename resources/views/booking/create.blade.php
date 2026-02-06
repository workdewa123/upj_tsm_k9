@extends('layouts.app')

@section('title', 'Buat Booking Baru')

@section('content')
<div class="container py-4">
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
        $services = \App\Models\Service::all(); 
        $backRoute = ($user->role === 'admin') ? route('booking.index') : route('customers.dashboard');
    @endphp

    {{-- HEADER: Judul & Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark border-bottom pb-2 mb-0">
            <i class="fas fa-calendar-plus me-2 text-danger"></i>Booking Servis
        </h1>
        <a href="{{ $backRoute }}" class="btn btn-light shadow-sm px-4 border">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">

            {{-- 1. Kondisi jika kuota penuh --}}
            @if($todayActive >= 50)
                <div class="card shadow border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <i class="fas fa-calendar-times fa-4x text-danger opacity-25"></i>
                        </div>
                        <h2 class="fw-bold text-dark">Kuota Penuh</h2>
                        <p class="text-secondary fs-5 mb-4">Mohon maaf, antrian booking untuk hari ini sudah mencapai batas (50 Antrian).</p>
                        <a href="{{ $backRoute }}" class="btn btn-danger fw-bold rounded-3 px-4 shadow">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>

            @else
                {{-- 2. Form Booking --}}
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">
                        
                        {{-- Alert Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center mb-4" role="alert">
                                <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                                <div>
                                    <ul class="mb-0 ps-3 small">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('booking.store') }}" method="POST">
                            @csrf

                            {{-- Bagian 1: Data Kendaraan & Servis --}}
                            <div class="mb-4">
                                <h6 class="text-uppercase text-danger fw-bold small mb-3">
                                    <i class="fas fa-motorcycle me-2"></i>Informasi Kendaraan
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="vehicle_type" class="form-label fw-bold text-secondary small text-uppercase">Jenis Kendaraan</label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-white border-end-0 text-danger"><i class="fas fa-list"></i></span>
                                            <select name="vehicle_type" id="vehicle_type" class="form-select border-start-0 ps-0 @error('vehicle_type') is-invalid @enderror" required>
                                                <option value="">-- Pilih Jenis --</option>
                                                <option value="matic">Matic</option>
                                                <option value="bebek">Bebek</option>
                                                <option value="cup">Cup</option>
                                                <option value="sport">Sport</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="plate_number" class="form-label fw-bold text-secondary small text-uppercase">Plat Nomor</label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-white border-end-0 text-danger"><i class="fas fa-id-card"></i></span>
                                            <input type="text" name="plate_number" id="plate_number" class="form-control border-start-0 ps-0 text-uppercase fw-bold" placeholder="B 1234 ABC" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="service_id" class="form-label fw-bold text-secondary small text-uppercase">Pilih Paket Servis</label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-white border-end-0 text-danger"><i class="fas fa-tools"></i></span>
                                            <select name="service_id" id="service_id" class="form-select border-start-0 ps-0" required>
                                                <option value="">-- Pilih Paket Servis --</option>
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}">
                                                        {{ $service->name }} — Rp {{ number_format($service->price, 0, ',', '.') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 opacity-25">

                            {{-- Bagian 2: Data Jadwal & Kontak --}}
                            <div class="mb-4">
                                <h6 class="text-uppercase text-danger fw-bold small mb-3">
                                    <i class="fas fa-user-clock me-2"></i>Jadwal & Kontak
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-12 mb-2">
                                        <label for="booking_date" class="form-label fw-bold text-secondary small text-uppercase">Rencana Tanggal & Jam</label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-white border-end-0 text-danger"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="datetime-local" name="booking_date" id="booking_date" class="form-control border-start-0 ps-0" required>
                                        </div>
                                        <div class="form-text text-muted small mt-1"><i class="fas fa-info-circle me-1"></i>Pilih waktu operasional (08:00 - 17:00).</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="customer_name" class="form-label fw-bold text-secondary small text-uppercase">Nama Pemilik</label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-white border-end-0 text-secondary"><i class="fas fa-user"></i></span>
                                            <input type="text" name="customer_name" id="customer_name" class="form-control border-start-0 ps-0 bg-light" value="{{ $user->name }}" readonly required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="customer_whatsapp" class="form-label fw-bold text-secondary small text-uppercase">WhatsApp Aktif</label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-white border-end-0 text-danger"><i class="fab fa-whatsapp"></i></span>
                                            <input type="text" name="customer_whatsapp" id="customer_whatsapp" class="form-control border-start-0 ps-0" value="{{ $user->phone ?? '' }}" placeholder="08xxxxxxxxxx" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Input Hidden --}}
                            <input type="hidden" name="quota" value="1">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            {{-- Tombol Aksi --}}
                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-danger btn-lg shadow fw-bold rounded-3 py-3">
                                    <i class="fas fa-paper-plane me-2"></i> Konfirmasi Booking
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection