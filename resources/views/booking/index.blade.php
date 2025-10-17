@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-primary fw-bold border-bottom pb-2">Daftar Booking</h1>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="py-3 px-4">Nama</th>
                            <th scope="col" class="py-3 px-4">Motor</th>
                            <th scope="col" class="py-3 px-4">Tanggal</th>
                            <th scope="col" class="py-3 px-4">Estimasi</th>
                            <th scope="col" class="py-3 px-4">Status</th>
                            <th scope="col" class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        @php
                            $bookingTime = \Carbon\Carbon::parse($booking->booking_date);
                            $startTime = $bookingTime->copy()->addMinutes(15);
                            $endTime = $bookingTime->copy()->addMinutes(75);
                            $isOver = now()->greaterThan($endTime);
                        @endphp
                        <tr>
                            <td class="px-4 align-middle">{{ $booking->customer_name }}</td>
                            <td class="px-4 align-middle">{{ $booking->vehicle_type }} - {{ $booking->plate_number }}</td>
                            <td class="px-4 align-middle">{{ $bookingTime->format('d-m-Y H:i') }}</td>
                            <td class="px-4 align-middle">
                                {{ $startTime->format('H:i') }} - {{ $endTime->format('H:i') }} WIB
                                @if($isOver)
                                    <br><span class="text-danger fw-bold">Sudah Melewati Estimasi!</span>
                                @endif
                            </td>
                            <td class="px-4 align-middle">
                                <form action="{{ route('booking.updateStatus', $booking->id) }}" method="POST">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="on_progress" {{ $booking->status == 'on_progress' ? 'selected' : '' }}>On Progress</option>
                                        <option value="done" {{ $booking->status == 'done' ? 'selected' : '' }}>Done</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 align-middle">
                                <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<div class="container py-1">
    {{ $bookings->links() }}
</div>
@endsection
