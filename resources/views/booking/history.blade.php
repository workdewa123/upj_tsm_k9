@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">
            <i class="fas fa-history me-2 text-danger"></i>Riwayat Service
        </h2>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light border-bottom">
                    <tr>
                        <th class="py-3 px-4 text-secondary text-uppercase small fw-bold">Tanggal</th>
                        <th class="py-3 px-4 text-secondary text-uppercase small fw-bold">No Polisi</th>
                        <th class="py-3 px-4 text-secondary text-uppercase small fw-bold">Kendaraan</th>
                        <th class="py-3 px-4 text-secondary text-uppercase small fw-bold">Service</th>
                        <th class="py-3 px-4 text-secondary text-uppercase small fw-bold text-center">Status</th>
                        <th class="py-3 px-4 text-secondary text-uppercase small fw-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="px-4 fw-medium text-dark">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                            <td class="px-4 text-uppercase fw-bold text-dark">{{ $booking->plate_number }}</td>
                            <td class="px-4 text-muted">{{ $booking->vehicle_type }}</td>
                            <td class="px-4 text-danger fw-medium">{{ $booking->service->name }}</td>
                            <td class="px-4 text-center">
                                @php
                                    $statusClass = [
                                        'pending'     => 'bg-warning-subtle text-warning-emphasis',
                                        'approved'    => 'bg-info-subtle text-info-emphasis',
                                        'on_progress' => 'bg-primary-subtle text-primary-emphasis',
                                        'done'        => 'bg-success-subtle text-success-emphasis',
                                        'cancelled'   => 'bg-danger-subtle text-danger-emphasis',
                                    ][strtolower($booking->status)] ?? 'bg-secondary-subtle text-secondary-emphasis';
                                @endphp
                                <span class="badge rounded-pill {{ $statusClass }} border px-3 py-2 fw-normal">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-4 text-center">
                                <a href="{{ route('booking.history.detail', [$booking->customer_whatsapp, $booking->id]) }}" class="btn btn-sm btn-light text-primary rounded-pill px-3 border shadow-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="far fa-folder-open fa-3x mb-3 opacity-25"></i>
                                <p>Belum ada riwayat service.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection