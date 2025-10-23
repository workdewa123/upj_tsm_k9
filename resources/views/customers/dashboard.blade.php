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

        {{-- Kolom Kanan: Form Create Booking --}}
        <div class="col-lg-5">
            <div class="card shadow-sm border-danger-subtle rounded-4 h-100">
                <div class="card-header bg-danger text-white fw-bold">
                   <i class="fas fa-calendar-plus me-2"></i>Buat Booking Baru
                </div>
                <div class="card-body">
                    {{-- Kondisi jika kuota penuh --}}
                    @if($todayActive >= 50)
                        <div class="alert alert-danger text-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Kuota antrian hari ini sudah penuh.
                        </div>
                    @else
                        {{-- Menampilkan error validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mb-3">
                                <ul class="mb-0 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Form Create Booking (diambil dari create.blade.php) --}}
                        <form action="{{ route('booking.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="vehicle_type" class="form-label small">Jenis Kendaraan</label>
                                <select name="vehicle_type" id="vehicle_type" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="matic">Matic</option>
                                    <option value="bebek">Bebek</option>
                                    <option value="cup">Cup</option>
                                    <option value="sport">Sport</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="plate_number" class="form-label small">Plat Nomor</label>
                                <input type="text" name="plate_number" id="plate_number" class="form-control form-control-sm text-uppercase" placeholder="B 1234 ABC" required>
                            </div>
                            <div class="mb-3">
                                <label for="service_id" class="form-label small">Jenis Servis</label>
                                <select name="service_id" id="service_id" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih Servis --</option>
                                    @foreach($services as $service) {{-- Menggunakan $services dari controller --}}
                                        <option value="{{ $service->id }}">
                                            {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="mb-3">
                                <label for="booking_date" class="form-label small">Tanggal & Jam</label>
                                <input type="datetime-local" name="booking_date" id="booking_date" class="form-control form-control-sm" required>
                            </div>
                            <div class="mb-3">
                                <label for="customer_whatsapp" class="form-label small">No. WhatsApp</label>
                                <input type="text" name="customer_whatsapp" id="customer_whatsapp" class="form-control form-control-sm" value="{{ $user->phone ?? '' }}" required>
                            </div>

                            {{-- Input tersembunyi --}}
                            <input type="hidden" name="customer_name" value="{{ $user->name }}">
                            <input type="hidden" name="quota" value="1">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger fw-bold">Booking Sekarang</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection