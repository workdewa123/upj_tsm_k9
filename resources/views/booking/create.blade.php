@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            @php
                use Illuminate\Support\Facades\Auth;
                $user = Auth::user();
            @endphp

            {{-- Kondisi jika kuota penuh --}}
            @if($todayActive >= 50)
                <div class="card text-center shadow-lg border-danger">
                    <div class="card-body p-5">
                        <h3 class="card-title fw-bold text-danger">Kuota Hari Ini Penuh</h3>
                        <p class="text-muted">Mohon maaf, antrian untuk hari ini sudah penuh. Silakan coba lagi besok.</p>
                        <a href="{{ url('/') }}" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
                    </div>
                </div>
            @else
                <div class="card shadow-lg border-danger-subtle rounded-4">
                    <div class="card-header bg-danger text-white text-center py-3">
                        <h3 class="fw-bold mb-0">Form Booking Servis</h3>
                    </div>
                    <div class="card-body p-4 p-md-5">

                        {{-- Menampilkan error validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('booking.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6 mb-3">
                                    <label for="vehicle_type" class="form-label">Jenis Kendaraan</label>
                                    <select name="vehicle_type" id="vehicle_type" class="form-select" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="matic">Matic</option>
                                        <option value="bebek">Bebek</option>
                                        <option value="cup">Cup</option>
                                        <option value="sport">Sport</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="plate_number" class="form-label">Plat Nomor</label>
                                    <input type="text" name="plate_number" id="plate_number" class="form-control text-uppercase" placeholder="Contoh: B 1234 ABC" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="service_id" class="form-label">Jenis Servis</label>
                                    <select name="service_id" id="service_id" class="form-select" required>
                                        <option value="">-- Pilih Servis --</option>
                                        @foreach(\App\Models\Service::all() as $service)
                                            <option value="{{ $service->id }}">
                                                {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="booking_date" class="form-label">Tanggal & Jam Booking</label>
                                    <input type="datetime-local" name="booking_date" id="booking_date" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="customer_name" class="form-label">Nama Customer</label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control bg-light" value="{{ $user->name }}" readonly required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="customer_whatsapp" class="form-label">No. WhatsApp</label>
                                    <input type="text" name="customer_whatsapp" id="customer_whatsapp" class="form-control" value="{{ $user->phone ?? '' }}" placeholder="Contoh: 08123456789" required>
                                </div>
                            </div>

                            {{-- Input tersembunyi dari kode asli --}}
                            <input type="hidden" name="quota" value="1">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-danger btn-lg fw-bold">Konfirmasi Booking</button>
                            </div>
                            <div class="card-footer bg-light text-center">
                                <a href="{{ route('booking.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Booking
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection