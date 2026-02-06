@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-lg border-success rounded-4 text-center overflow-hidden">
                <div class="card-header bg-success text-white py-4">
                    <h3 class="fw-bold mb-0"><i class="fas fa-check-circle me-2"></i>Booking Berhasil!</h3>
                </div>
                <div class="card-body p-4 p-md-5">

                    <h6 class="text-uppercase text-muted fw-bold mb-2">Nomor Antrian Anda</h6>
                    {{-- Tampilkan Nomor Antrian Besar --}}
                    <div class="display-1 fw-bolder text-danger mb-4">
                        {{ $booking->queue_number }}
                    </div>

                    {{-- Detail Booking --}}
                    <div class="card bg-light border-0 rounded-3 mb-4 text-start shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-wrench me-3 text-danger fs-5"></i>
                                <div>
                                    <small class="text-muted d-block">Jenis Service</small>
                                    <strong>{{ $booking->service->name }}</strong>
                                </div>
                            </div>
                            <hr class="my-2 text-muted opacity-25">
                            @php
                                $bookingTime = \Carbon\Carbon::parse($booking->booking_date);
                                $endTime = $bookingTime->copy()->addMinutes(75)->format('H:i');
                            @endphp
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-clock me-3 text-danger fs-5"></i>
                                <div>
                                    <small class="text-muted d-block">Waktu Booking</small>
                                    <strong>{{ $bookingTime->format('d M Y, H:i') }} WIB</strong>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-hourglass-half me-3 text-danger fs-5"></i>
                                <div>
                                    <small class="text-muted d-block">Estimasi Layanan</small>
                                    <strong>{{ $bookingTime->format('H:i') }} - {{ $endTime }} WIB</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <span class="text-muted me-2">Status Saat Ini:</span>
                        @php
                            $statusClass = [
                                'pending'     => 'bg-warning text-dark',
                                'approved'    => 'bg-info text-dark',
                                'on_progress' => 'bg-primary',
                                'done'        => 'bg-success',
                                'cancelled'   => 'bg-danger',
                            ][strtolower($booking->status)] ?? 'bg-secondary';
                        @endphp
                        <span class="badge rounded-pill {{ $statusClass }} px-3">
                            {{ str_replace('_', ' ', ucfirst($booking->status)) }}
                        </span>
                    </div>

                    <div class="alert alert-warning d-flex align-items-center small text-start" role="alert">
                        <i class="fas fa-info-circle flex-shrink-0 me-2 fs-5"></i>
                        <div>
                            Silakan datang <strong>~15 menit sebelum</strong> waktu layanan. Notifikasi WhatsApp akan dikirimkan saat giliran Anda mendekat.
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('booking.queue') }}" class="btn btn-primary btn-lg shadow-sm">
                            <i class="fas fa-list-ol me-2"></i>Lihat Daftar Antrian
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger shadow-sm">
                            <i class="fas fa-home me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Memastikan Font Awesome dan JS Bootstrap dimuat --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
@endsection