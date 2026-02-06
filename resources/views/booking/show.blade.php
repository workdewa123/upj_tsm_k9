@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow border-0 rounded-4">
                {{-- Header Bersih dengan Ikon Merah --}}
                <div class="card-header bg-white border-bottom py-4 text-center">
                    <h4 class="fw-bold m-0 text-dark">
                        <i class="fas fa-clipboard-list me-2 text-danger"></i>Detail Booking #{{ $booking->id }}
                    </h4>
                </div>

                <div class="card-body p-4">
                    <ul class="list-group list-group-flush mb-4">
                        {{-- Nama Customer --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted small text-uppercase fw-bold">Nama Customer</span>
                            <span class="fw-bold fs-5 text-dark">{{ $booking->customer_name }}</span>
                        </li>
                        
                        {{-- No Polisi --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted small text-uppercase fw-bold">No. Polisi</span>
                            <span class="fw-bold text-uppercase badge bg-light text-dark border fs-6 px-3 py-2">
                                {{ $booking->plate_number }}
                            </span>
                        </li>

                        {{-- Jadwal --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted small text-uppercase fw-bold">Jadwal</span>
                            <span class="fw-bold text-dark">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y, H:i') }} WIB
                            </span>
                        </li>

                        {{-- Jenis Servis --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted small text-uppercase fw-bold">Jenis Servis</span>
                            <span class="fw-bold text-danger">{{ $booking->service->name ?? '-' }}</span>
                        </li>

                        {{-- Status Saat Ini --}}
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted small text-uppercase fw-bold">Status Saat Ini</span>
                            @php
                                $statusClass = [
                                    'pending'     => 'bg-warning-subtle text-warning-emphasis',
                                    'approved'    => 'bg-info-subtle text-info-emphasis',
                                    'on_progress' => 'bg-primary-subtle text-primary-emphasis',
                                    'done'        => 'bg-success-subtle text-success-emphasis',
                                    'cancelled'   => 'bg-danger-subtle text-danger-emphasis',
                                ][strtolower($booking->status)] ?? 'bg-secondary-subtle text-secondary-emphasis';
                            @endphp
                            <span class="badge rounded-pill {{ $statusClass }} px-3 py-2 border fw-normal">
                                {{ str_replace('_', ' ', ucfirst($booking->status)) }}
                            </span>
                        </li>
                    </ul>

                    {{-- Form Update Status --}}
                    <div class="card bg-light border-0 p-4 rounded-4 mt-2">
                        <form action="{{ route('booking.updateStatus', $booking->id) }}" method="POST">
                            @csrf
                            <label for="status" class="form-label fw-bold text-secondary mb-2">
                                <i class="fas fa-edit me-1"></i>Ubah Status Booking
                            </label>
                            <div class="input-group">
                                <select name="status" class="form-select border-0 shadow-sm" style="cursor: pointer;">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="on_progress" {{ $booking->status == 'on_progress' ? 'selected' : '' }}>On Progress</option>
                                    <option value="done" {{ $booking->status == 'done' ? 'selected' : '' }}>Done</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-danger px-4 shadow-sm fw-bold">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-footer bg-white border-top-0 text-center pb-4 pt-0">
                    <a href="{{ route('booking.index') }}" class="btn btn-light shadow-sm px-4 rounded-pill border">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection