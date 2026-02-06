@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">
            <i class="fas fa-history me-2 text-danger"></i>Riwayat Booking
        </h2>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary shadow-sm rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Pelanggan
        </a>
    </div>

    {{-- Card Tabel --}}
    <div class="card shadow border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="py-3 px-4 text-secondary text-uppercase small fw-bold">No. Polisi</th>
                        <th class="py-3 px-4 text-secondary text-uppercase small fw-bold">Tgl Booking</th>
                        <th class="py-3 px-4 text-secondary text-uppercase small fw-bold">Service</th>
                        <th class="py-3 px-4 text-secondary text-uppercase small fw-bold text-center">Status</th>
                        <th class="py-3 px-4 text-secondary text-uppercase small fw-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td class="px-4">
                                <span class="fw-bold text-dark text-uppercase bg-light border px-2 py-1 rounded">
                                    {{ $booking->plate_number }}
                                </span>
                            </td>
                            <td class="px-4 text-secondary">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 fw-medium text-dark">{{ $booking->service->name ?? '-' }}</td>
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
                                <span class="badge rounded-pill {{ $statusClass }} px-3 py-2 fw-normal border">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-4 text-center">
                                <a href="{{ route('booking.history.detail', $booking->id) }}" class="btn btn-sm btn-light text-primary rounded-pill px-3 border shadow-sm">
                                    <i class="fas fa-search me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- Tampilkan pesan jika kosong (Opsional, jika variabel bookings kosong) --}}
        @if($bookings->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="far fa-folder-open fa-3x mb-3 opacity-25"></i>
                <p>Belum ada riwayat booking untuk pelanggan ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection