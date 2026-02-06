@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container py-5">
    
    {{-- Header Sambutan --}}
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h2 class="fw-bold text-dark mb-0">
                <i class="fas fa-user-circle me-2 text-danger"></i>Hallo, {{ $user->name }}!
            </h2>
            <p class="text-muted mb-0 mt-1">Selamat datang di panel pelanggan bengkel kami.</p>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-danger rounded-pill px-3 py-2">
                <i class="fas fa-star me-1"></i> Member Customer
            </span>
        </div>
    </div>

    <div class="row g-4">
        {{-- KOLOM KIRI: Riwayat Booking (Kode Asli + Sedikit Styling) --}}
        <div class="col-lg-7">
            
            {{-- Highlight Booking Terakhir (Jika Ada) --}}
            @if($bookings->isNotEmpty() && $bookings->first()->status != 'done' && $bookings->first()->status != 'cancelled')
            <div class="card shadow-sm border-danger border-start border-4 rounded-3 mb-4">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold mb-2">Aktivitas Terkini</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="fw-bold mb-1">{{ $bookings->first()->service->name ?? 'Servis' }}</h5>
                            <p class="mb-0 text-muted small">
                                <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($bookings->first()->booking_date)->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div class="text-end">
                             @php
                                $latestStatus = strtolower($bookings->first()->status);
                                $statusBadge = [
                                    'pending'     => 'bg-warning text-dark',
                                    'approved'    => 'bg-info text-dark',
                                    'on_progress' => 'bg-primary',
                                ][$latestStatus] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $statusBadge }} rounded-pill px-3">{{ ucfirst($latestStatus) }}</span>
                            <div class="small text-muted mt-1">{{ $bookings->first()->plate_number }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Tabel Riwayat --}}
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-history me-2 text-danger"></i>Riwayat Servis</h5>
                </div>
                <div class="card-body p-0">
                    @if ($bookings->isEmpty())
                        <div class="text-center p-5">
                            <div class="mb-3">
                                <i class="fas fa-clipboard-list fa-3x text-muted opacity-50"></i>
                            </div>
                            <h6 class="text-muted">Belum ada riwayat booking.</h6>
                            <a href="{{ route('booking.create') }}" class="btn btn-sm btn-outline-danger mt-2">Buat Booking Pertama</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-secondary small text-uppercase">
                                    <tr>
                                        <th class="ps-4">Tanggal</th>
                                        <th>Servis</th>
                                        <th>Kendaraan</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                                            <div class="small text-muted">{{ \Carbon\Carbon::parse($booking->booking_date)->format('H:i') }} WIB</div>
                                        </td>
                                        <td>{{ $booking->service->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $booking->plate_number }}</span>
                                            <div class="small text-muted text-capitalize mt-1">{{ $booking->vehicle_type ?? 'Motor' }}</div>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $statusClass = [
                                                    'pending'     => 'bg-warning text-dark',
                                                    'approved'    => 'bg-info text-dark',
                                                    'on_progress' => 'bg-primary',
                                                    'done'        => 'bg-success',
                                                    'cancelled'   => 'bg-danger',
                                                ][strtolower($booking->status)] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge rounded-pill {{ $statusClass }}" style="font-weight: 500; font-size: 0.75rem;">
                                                {{ str_replace('_', ' ', ucfirst($booking->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                @if ($bookings->hasPages())
                <div class="card-footer bg-white border-top-0 py-3">
                    {{ $bookings->links() }}
                </div>
                @endif
            </div>
        </div>

        {{-- KOLOM KANAN: Informasi & Fitur Tambahan (BARU) --}}
        <div class="col-lg-5">
            
           {{-- 1. Kartu Booking Cepat (Versi Sederhana & Bersih) --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4 bg-danger text-white">
                <div class="card-body p-4 d-md-flex align-items-center justify-content-between text-center text-md-start">
                    <div class="mb-3 mb-md-0">
                        <h4 class="fw-bold mb-1">Booking Servis Baru?</h4>
                        <p class="mb-0 text-white-50">Jadwalkan servis Anda secara online sekarang.</p>
                    </div>
                    <a href="{{ route('booking.create') }}" class="btn btn-light text-danger fw-bold rounded-pill px-4 shadow-sm text-nowrap">
                        <i class="fas fa-plus-circle me-2"></i> Buat Booking
                    </a>
                </div>
            </div>

            {{-- 2. Kartu Profil Ringkas --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-user text-secondary fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Profil Saya</h6>
                            <small class="text-muted">Informasi Akun</small>
                        </div>
                         @if(Route::has('profile'))
                        <a href="{{ route('profile') }}" class="btn btn-sm btn-outline-secondary ms-auto rounded-pill px-3">
                            Edit
                        </a>
                        @endif
                    </div>
                    
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 pb-2">
                            <span class="text-muted"><i class="fas fa-envelope me-2 text-center" style="width: 20px;"></i> Email</span>
                            <span class="fw-medium text-dark">{{ $user->email }}</span>
                        </li>
                        {{--  <li class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 py-2">
                            <span class="text-muted"><i class="fas fa-phone me-2 text-center" style="width: 20px;"></i> WhatsApp</span>
                            <span class="fw-medium text-dark">{{ $bookings->customer_whatsapp ?? '-' }}</span>
                        </li>--}}
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center border-0 pt-2">
                            <span class="text-muted"><i class="fas fa-calendar-check me-2 text-center" style="width: 20px;"></i> Total Booking</span>
                            <span class="fw-bold text-danger">{{ $bookings->total() ?? 0 }}x</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- 3. Kartu Informasi Bengkel & Bantuan --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white fw-bold border-bottom py-3">
                    <i class="fas fa-info-circle me-2 text-danger"></i>Info & Bantuan
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <i class="fas fa-clock text-muted mt-1 me-3"></i>
                        <div>
                            <span class="d-block fw-bold text-dark">Jam Operasional</span>
                            <span class="text-muted small">Senin - Sabtu: 08:00 - 17:00 WIB</span><br>
                            <span class="text-danger small fw-bold">Minggu: Libur</span>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <i class="fas fa-map-marker-alt text-muted mt-1 me-3"></i>
                        <div>
                            <span class="d-block fw-bold text-dark">Lokasi Bengkel</span>
                            <span class="text-muted small">Jl. Contoh No. 123, Kota Bengkel, Indonesia</span>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <a href="https://wa.me/62881036002207" target="_blank" class="btn btn-outline-success">
                            <i class="fab fa-whatsapp me-2"></i> Hubungi Admin
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection