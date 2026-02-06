@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0 rounded-4">
                {{-- Header Bersih dengan Ikon Merah sebagai Aksen --}}
                <div class="card-header bg-white border-bottom py-3 text-center">
                    <h5 class="fw-bold m-0 text-dark">
                        <i class="fas fa-info-circle me-2 text-danger"></i>Detail Riwayat Booking
                    </h5>
                </div>

                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        {{-- Nama Customer --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted small text-uppercase fw-bold">Nama Customer</span>
                            <span class="fw-bold text-dark">{{ $booking->customer_name }}</span>
                        </li>

                        {{-- WhatsApp (Highlight Ringan) --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0 bg-light rounded-3 my-1">
                            <span class="text-muted small text-uppercase fw-bold">No. WhatsApp</span>
                            <span class="fw-bold text-dark font-monospace">
                                <i class="fab fa-whatsapp text-success me-1"></i>{{ $booking->customer_whatsapp }}
                            </span>
                        </li>

                        {{-- Kendaraan --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted small text-uppercase fw-bold">Kendaraan</span>
                            <div class="text-end">
                                <div class="fw-bold text-dark">{{ $booking->vehicle_type }}</div>
                                <span class="badge bg-light text-secondary border">{{ $booking->plate_number }}</span>
                            </div>
                        </li>

                        {{-- Jadwal --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted small text-uppercase fw-bold">Jadwal</span>
                            <span class="fw-bold text-dark">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y, H:i') }} WIB
                            </span>
                        </li>

                        {{-- Layanan --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted small text-uppercase fw-bold">Layanan</span>
                            <span class="fw-bold text-danger">{{ $booking->service->name ?? '-' }}</span>
                        </li>

                        {{-- Status --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted small text-uppercase fw-bold">Status</span>
                            @php
                                $statusClass = [
                                    'pending'     => 'bg-warning-subtle text-warning-emphasis',
                                    'approved'    => 'bg-info-subtle text-info-emphasis',
                                    'on_progress' => 'bg-primary-subtle text-primary-emphasis',
                                    'done'        => 'bg-success-subtle text-success-emphasis',
                                    'cancelled'   => 'bg-danger-subtle text-danger-emphasis',
                                ][strtolower($booking->status)] ?? 'bg-secondary-subtle text-secondary-emphasis';
                            @endphp
                            <span class="badge rounded-pill {{ $statusClass }} px-3 py-2 fw-normal border">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </li>
                    </ul>
                </div>

                {{-- Footer Tombol --}}
                <div class="card-footer bg-white border-0 text-center pb-4 pt-0">
                    <a href="{{ route('customers.index') }}" class="btn btn-light shadow-sm px-4 rounded-pill border">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection