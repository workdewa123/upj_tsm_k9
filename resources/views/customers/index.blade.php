@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">
            <i class="fas fa-users me-2 text-danger"></i>Daftar Customer
        </h2>
        {{-- Jika ada tombol tambah customer, bisa diletakkan di sini --}}
    </div>

    @if ($customers->isEmpty())
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body text-center p-5">
                <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                    <i class="fas fa-users-slash fa-3x text-secondary opacity-50"></i>
                </div>
                <h5 class="fw-bold text-dark">Belum ada customer</h5>
                <p class="mb-0 text-muted">Belum ada data customer yang terdaftar di sistem.</p>
            </div>
        </div>
    @else
        <div class="card shadow border-0 rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th scope="col" class="py-3 px-4 text-center text-secondary small text-uppercase fw-bold" style="width: 5%;">#</th>
                            <th scope="col" class="py-3 px-4 text-secondary small text-uppercase fw-bold">Nama Customer</th>
                            <th scope="col" class="py-3 px-4 text-secondary small text-uppercase fw-bold">Email</th>
                            <th scope="col" class="py-3 px-4 text-secondary small text-uppercase fw-bold">No. WhatsApp</th>
                            <th scope="col" class="py-3 px-4 text-center text-secondary small text-uppercase fw-bold">Total Booking</th>
                            <th scope="col" class="py-3 px-4 text-center text-secondary small text-uppercase fw-bold" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $index => $customer)
                            <tr>
                                <td class="px-4 text-center text-muted fw-bold">{{ $customers->firstItem() + $index }}</td>
                                <td class="px-4">
                                    <span class="fw-bold text-dark">{{ $customer->name }}</span>
                                </td>
                                <td class="px-4 text-secondary">{{ $customer->email }}</td>
                                <td class="px-4">
                                    @if ($customer->bookings->isNotEmpty())
                                        @php
                                            $whatsappNumber = $customer->bookings->first()->customer_whatsapp;
                                        @endphp
                                        <span class="font-monospace text-dark">
                                            <i class="fab fa-whatsapp text-success me-1"></i>{{ $whatsappNumber }}
                                        </span>
                                    @else
                                        <span class="text-muted small fst-italic">Belum ada data</span>
                                    @endif
                                </td>
                                <td class="px-4 text-center">
                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 border border-danger-subtle">
                                        {{ $customer->bookings->count() }} Booking
                                    </span>
                                </td>
                                <td class="px-4 text-center">
                                    @if ($customer->bookings->isNotEmpty())
                                        <a href="{{ route('customers.bookings', ['email' => $customer->email, 'whatsapp' => $whatsappNumber ?? 'N/A']) }}" 
                                           class="btn btn-sm btn-light text-danger rounded-pill px-3 border shadow-sm fw-bold">
                                            <i class="fas fa-history me-1"></i>Riwayat
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-light text-muted border rounded-pill px-3" disabled>
                                            <i class="fas fa-ban me-1"></i>Kosong
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Footer Paginasi --}}
            @if($customers instanceof \Illuminate\Pagination\LengthAwarePaginator && $customers->hasPages())
                <div class="card-footer bg-white border-top-0 py-3">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>
    @endif
</div>

{{-- Script Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection