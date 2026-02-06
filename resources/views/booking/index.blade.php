@extends('layouts.app')

@section('content')
<style>
    /* Styling khusus untuk Pagination agar tetap senada dengan aksen merah */
    .page-item.active .page-link {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }
    .page-link {
        color: #dc3545;
    }
    .page-link:hover {
        color: #a71d2a;
    }
    /* Hover row tabel yang lebih halus */
    .table-hover tbody tr:hover {
        background-color: rgba(220, 53, 69, 0.03); /* Merah sangat tipis saat di-hover */
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark border-bottom pb-2 mb-0">
            <i class="fas fa-book-open me-2 text-danger"></i>Daftar Booking
        </h1>
        <a href="{{ route('booking.create') }}" class="btn btn-danger shadow-sm px-4">
            <i class="fas fa-plus me-2"></i>Booking Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Card dibuat bersih tanpa border merah --}}
    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    {{-- Header tabel warna netral (abu-abu muda) --}}
                    <thead class="table-light border-bottom">
                        <tr>
                            <th scope="col" class="py-3 px-4 text-secondary text-uppercase small fw-bold">Nama</th>
                            <th scope="col" class="py-3 px-4 text-secondary text-uppercase small fw-bold">Motor</th>
                            <th scope="col" class="py-3 px-4 text-secondary text-uppercase small fw-bold">Tanggal</th>
                            <th scope="col" class="py-3 px-4 text-secondary text-uppercase small fw-bold">Estimasi</th>
                            <th scope="col" class="py-3 px-4 text-secondary text-uppercase small fw-bold text-center">Status</th>
                            <th scope="col" class="py-3 px-4 text-secondary text-uppercase small fw-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        @php
                            $bookingTime = \Carbon\Carbon::parse($booking->booking_date);
                            $startTime = $bookingTime->copy()->addMinutes(15);
                            $endTime = $bookingTime->copy()->addMinutes(75);
                            $isOver = now()->greaterThan($endTime);
                        @endphp
                        <tr>
                            <td class="px-4 fw-bold text-dark">{{ $booking->customer_name }}</td>
                            <td class="px-4 text-muted">
                                <span class="d-block fw-bold text-dark text-uppercase">{{ $booking->plate_number }}</span>
                                <small>{{ $booking->vehicle_type }}</small>
                            </td>
                            <td class="px-4 text-secondary">{{ $bookingTime->format('d M Y, H:i') }}</td>
                            <td class="px-4 text-secondary">
                                {{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }} WIB
                                @if($isOver && !in_array($booking->status, ['done', 'cancelled']))
                                    <br><span class="badge bg-danger-subtle text-danger border border-danger-subtle mt-1" style="font-size: 0.7rem;">Lewat Estimasi!</span>
                                @endif
                            </td>
                            <td class="px-4 text-center">
                                <form action="{{ route('booking.updateStatus', $booking->id) }}" method="POST">
                                    @csrf
                                    {{-- Select box lebih minimalis --}}
                                    <select name="status" class="form-select form-select-sm border-0 bg-light fw-bold text-secondary text-center shadow-none" onchange="this.form.submit()" style="cursor: pointer;">
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="on_progress" {{ $booking->status == 'on_progress' ? 'selected' : '' }}>On Progress</option>
                                        <option value="done" {{ $booking->status == 'done' ? 'selected' : '' }}>Done</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 text-center">
                                <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-sm btn-light text-danger rounded-pill px-3 shadow-sm">
                                    Detail <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada data booking.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($bookings->hasPages())
            <div class="card-footer bg-white border-top-0 py-3">
                {{ $bookings->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection