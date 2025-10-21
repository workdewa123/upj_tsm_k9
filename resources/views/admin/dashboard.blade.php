@extends('layouts.app')

@section('content')

<div class="pt-3">
    <div class="container py-4">

        <h1 class="mb-4 fw-bold border-bottom pb-2" style="color: #343a40af;">
            <i class="fas fa-tachometer-alt text-danger me-2"></i>Dashboard Administratif
        </h1>

        <div class="row mb-5 g-4">

            <div class="col-md-4">
                <div class="card shadow-lg border-0 text-white bg-danger">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-uppercase small opacity-75">Total Booking Hari Ini</h5>
                            <p class="card-text fw-bolder display-4">{{ $totalBookingsToday ?? 0 }}</p>
                        </div>
                        <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-lg border-0 text-white bg-secondary">
                     <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-uppercase small opacity-75">Booking Menunggu</h5>
                            <p class="card-text fw-bolder display-4">{{ $pendingBookings ?? 0 }}</p>
                        </div>
                        <i class="fas fa-hourglass-half fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-lg border-0 text-white bg-danger">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-uppercase small opacity-75">Customer Terdaftar</h5>
                            <p class="card-text fw-bolder display-4">{{ $registeredCustomers ?? 0 }}</p>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-secondary text-white fw-bold py-3 d-flex justify-content-between align-items-center">
                <span><i class="fas fa-stream me-2"></i>Antrian Booking Hari Ini</span>
                <a href="{{ route('booking.index') }}" class="btn btn-sm btn-light text-dark fw-bold">
                    Lihat Semua <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
            <div class="card-body p-0">
                @if ($queueBookings->isEmpty())
                    <div class="text-center p-5">
                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                        <h4 class="text-muted">Tidak Ada Antrian</h4>
                        <p class="text-muted">Semua pekerjaan hari ini sudah selesai. Kerja bagus!</p>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach ($queueBookings as $booking)
                            <a href="{{ route('booking.show', $booking->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger rounded-pill me-3 fs-5 p-2 px-3 fw-bold">#{{ $booking->queue_number }}</span>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $booking->customer_name }}</h6>
                                        <small class="text-muted">
                                            {{ $booking->service->name ?? 'Layanan Tidak Dikenal' }}
                                        </small>
                                    </div>
                                </div>
                                <div>
                                    @php
                                        $statusClass = [
                                            'pending'     => 'bg-warning text-dark',
                                            'approved'    => 'bg-info text-dark',
                                            'on_progress' => 'bg-primary',
                                            'done'        => 'bg-success',
                                            'cancelled'   => 'bg-danger',
                                        ][strtolower($booking->status)] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge rounded-pill {{ $statusClass }}">{{ str_replace('_', ' ', ucfirst($booking->status)) }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection