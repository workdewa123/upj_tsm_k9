@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4 text-center text-md-start">
        <h2 class="fw-bold text-dark">
            <i class="fas fa-stream me-2 text-danger"></i>Antrian Hari Ini
        </h2>
        <p class="text-muted">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            @if($queueBookings->isEmpty())
                <div class="text-center p-5">
                    <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                        <i class="fas fa-clipboard-check fa-3x text-secondary opacity-50"></i>
                    </div>
                    <h5 class="text-dark fw-bold">Tidak Ada Antrian</h5>
                    <p class="text-muted">Belum ada booking yang masuk antrian hari ini.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th scope="col" class="py-3 px-4 text-center text-secondary small text-uppercase fw-bold" style="width: 15%;">No. Antrian</th>
                                <th scope="col" class="py-3 px-4 text-secondary small text-uppercase fw-bold">Nama Customer</th>
                                <th scope="col" class="py-3 px-4 text-secondary small text-uppercase fw-bold">Service</th>
                                <th scope="col" class="py-3 px-4 text-center text-secondary small text-uppercase fw-bold" style="width: 20%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($queueBookings as $booking)
                                <tr>
                                    <td class="px-4 text-center">
                                        {{-- Nomor Antrian Merah & Menonjol --}}
                                        <div class="d-inline-block bg-danger text-white rounded-circle fs-5 fw-bold d-flex align-items-center justify-content-center shadow-sm mx-auto" style="width: 45px; height: 45px;">
                                            {{ $booking->queue_number }}
                                        </div>
                                    </td>
                                    <td class="px-4 fw-bold text-dark">{{ $booking->customer_name }}</td>
                                    <td class="px-4 text-secondary">{{ $booking->service->name ?? '-' }}</td>
                                    <td class="px-4 text-center">
                                        @php
                                            // Status Badge Pastel
                                            $statusClass = [
                                                'pending'     => 'bg-warning-subtle text-warning-emphasis',
                                                'approved'    => 'bg-info-subtle text-info-emphasis',
                                                'on_progress' => 'bg-primary-subtle text-primary-emphasis',
                                                'done'        => 'bg-success-subtle text-success-emphasis',
                                                'cancelled'   => 'bg-danger-subtle text-danger-emphasis',
                                            ][strtolower($booking->status)] ?? 'bg-secondary-subtle text-secondary-emphasis';
                                        @endphp
                                        <span class="badge rounded-pill {{ $statusClass }} px-3 py-2 fw-normal">
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
        @if ($queueBookings->hasPages())
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $queueBookings->links() }}
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection