@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 fw-bold border-bottom pb-2">
        <i class="fas fa-user-circle me-2"></i>Hallo Selamat Datang, {{ $user->name }}!
    </h1>

    <div class="row g-4">
        {{-- Kolom Kiri: Riwayat Booking --}}
        <div class="col-lg-7">
            <div class="card shadow-sm border-light rounded-4 h-100">
                <div class="card-header bg-dark text-white fw-bold">
                    <i class="fas fa-history me-2"></i>Riwayat Booking Anda
                </div>
                <div class="card-body">
                    @if ($bookings->isEmpty())
                        <div class="text-center p-4">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Anda belum memiliki riwayat booking.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Servis</th>
                                        <th>No. Polisi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y, H:i') }}</td>
                                        <td>{{ $booking->service->name ?? '-' }}</td>
                                        <td class="text-uppercase">{{ $booking->plate_number }}</td>
                                        <td>
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
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                {{-- Paginasi Riwayat --}}
                @if ($bookings->hasPages())
                <div class="card-footer bg-light border-0">
                    {{ $bookings->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection