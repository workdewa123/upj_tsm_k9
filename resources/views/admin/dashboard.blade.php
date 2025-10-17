@extends('layouts.app')

@section('content')

<!-- Memberi ruang di bawah fixed-top navbar -->
<div class="mt-5 pt-3">

    <!-- Bungkus konten dengan container untuk membatasi lebar dan menambahkan padding vertikal -->
    <div class="container py-4">

        <h1 class="mb-4 text-primary fw-bold border-bottom pb-2">Dashboard Administratif</h1>

        <!-- Bagian Statistik Ringkas (Card Modern) -->
        <div class="row mb-5 g-4">

            <!-- Card: Total Booking Hari Ini -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden h-100 bg-success text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-uppercase small opacity-75">Total Booking Hari Ini</h5>
                            <h1 class="card-text fw-bolder">{{ $totalBookingsToday ?? 0 }}</h1>
                        </div>
                        <i class="fas fa-calendar-check fa-3x opacity-50"></i> <!-- Ikon untuk booking -->
                    </div>
                </div>
            </div>

            <!-- Card: Booking Menunggu (Pending) -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden h-100 bg-warning text-dark">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-uppercase small opacity-75">Booking Menunggu (Pending)</h5>
                            <h1 class="card-text fw-bolder">{{ $pendingBookings ?? 0 }}</h1>
                        </div>
                        <i class="fas fa-hourglass-half fa-3x opacity-50"></i> <!-- Ikon untuk pending -->
                    </div>
                </div>
            </div>

            <!-- Card: Customer Terdaftar -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden h-100 bg-info text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-uppercase small opacity-75">Customer Terdaftar</h5>
                            <h1 class="card-text fw-bolder">{{ $registeredCustomers ?? 0 }}</h1>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i> <!-- Ikon untuk user -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Antrian Booking Hari Ini -->
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white fw-bold py-3 d-flex justify-content-between align-items-center">
                Antrian Booking Hari Ini
                <a href="{{ route('booking.index') }}" class="btn btn-sm btn-light text-primary fw-bold">Lihat Semua Antrian <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <div class="card-body p-0">

                @if ($queueBookings->isEmpty())
                    <div class="alert alert-light text-center m-0 py-4" role="alert">
                        <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                        <p class="mb-0 text-muted">Hore! Tidak ada antrian booking aktif hari ini.</p>
                    </div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($queueBookings as $booking)
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">

                                <!-- Antrian & Nama Customer -->
                                <div class="d-flex align-items-center flex-grow-1">
                                    <span class="badge bg-secondary rounded-pill me-3 fs-5 p-2 px-3 fw-bold">#{{ $booking->queue_number }}</span>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $booking->customer_name }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-motorcycle me-1"></i> {{ $booking->license_plate }} | <i class="fas fa-wrench me-1"></i> {{ $booking->service->name ?? 'Layanan Tidak Dikenal' }}
                                        </small>
                                    </div>
                                </div>

                                <!-- Status & Aksi -->
                                <div class="text-end d-flex flex-column align-items-end">
                                    <!-- Status Label -->
                                    @php
                                        $statusClass = [
                                            'pending' => 'badge-soft-warning text-warning border border-warning',
                                            'approved' => 'badge-soft-info text-info border border-info',
                                            'on_progress' => 'badge-soft-primary text-primary border border-primary',
                                            'done' => 'badge-soft-success text-success border border-success',
                                            'cancelled' => 'badge-soft-danger text-danger border border-danger',
                                        ][strtolower($booking->status)] ?? 'badge-soft-secondary text-secondary border border-secondary';
                                    @endphp
                                    <span class="badge {{ $statusClass }} text-uppercase mb-2 py-2 px-3 fw-bold">{{ $booking->status }}</span>

                                    <!-- Link ke Detail -->
                                    <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-sm btn-outline-primary fw-bold">Lihat Detail <i class="fas fa-chevron-right ms-1"></i></a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
