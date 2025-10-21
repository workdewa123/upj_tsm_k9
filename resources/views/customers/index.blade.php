@extends('layouts.app')

@section('content')
{{-- Tidak memerlukan Font Awesome lagi karena sudah ada di layout utama --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzLlQ36k2UaYJtU378F7xXvP+sN4fFw/U6/A2uB4aU+M+F1U+A9P7y+W+W+Z+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

<div class="container py-4">

    <h1 class="mb-4 fw-bold border-bottom border-danger pb-2 text-danger">
        <i class="fas fa-users me-2"></i>Daftar Customer
    </h1>

    @if ($customers->isEmpty())
        <div class="card shadow-sm border-light">
            <div class="card-body text-center p-5">
                <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                <p class="mb-0 text-muted">Belum ada customer yang terdaftar.</p>
            </div>
        </div>
    @else
        <div class="card shadow-lg border-danger-subtle rounded-4">
            {{-- Menghapus p-0 agar ada padding di dalam card body --}}
            <div class="card-body">
                <div class="table-responsive">
                    {{-- Menambahkan table-striped dan table-hover untuk visual yang lebih baik --}}
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-danger">
                            <tr>
                                <th scope="col" class="py-3 px-4">#</th>
                                <th scope="col" class="py-3 px-4">Nama Customer</th>
                                <th scope="col" class="py-3 px-4">Email</th>
                                <th scope="col" class="py-3 px-4">No. WhatsApp</th>
                                <th scope="col" class="py-3 px-4 text-center">Total Booking</th>
                                <th scope="col" class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $index => $customer)
                                <tr>
                                    <td class="px-4 fw-bold">{{ $loop->iteration }}</td>
                                    <td class="px-4">{{ $customer->name }}</td>
                                    <td class="px-4">{{ $customer->email }}</td>
                                    <td class="px-4">
                                        @if ($customer->bookings->isNotEmpty())
                                            @php
                                                // Logika PHP asli tidak diubah
                                                $whatsappNumber = $customer->bookings->first()->customer_whatsapp;
                                            @endphp
                                            {{ $whatsappNumber }}
                                        @else
                                            <span class="text-muted fst-italic">Belum ada booking</span>
                                        @endif
                                    </td>
                                    <td class="px-4 text-center">
                                        {{-- Menggunakan badge Bootstrap standar --}}
                                        <span class="badge rounded-pill bg-danger">{{ $customer->bookings->count() }}</span>
                                    </td>
                                    <td class="px-4 text-center">
                                        @if ($customer->bookings->isNotEmpty())
                                            {{-- Menggunakan tombol outline merah --}}
                                            <a href="{{ route('customers.bookings', ['email' => $customer->email, 'whatsapp' => $whatsappNumber ?? 'N/A']) }}" class="btn btn-sm btn-outline-danger fw-bold">
                                                <i class="fas fa-history me-1"></i> Lihat Booking
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                                <i class="fas fa-times-circle me-1"></i> Tidak ada Booking
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
             {{-- Menampilkan Paginasi di dalam Card Footer --}}
             @php
             // Pastikan variabel $customers adalah instance Paginator
             if ($customers instanceof \Illuminate\Pagination\LengthAwarePaginator) {
             @endphp
                 @if ($customers->hasPages())
                 <div class="card-footer bg-light border-0">
                     {{ $customers->links() }}
                 </div>
                 @endif
             @php
             }
             @endphp
        </div>
    @endif
</div>

{{-- Memastikan Bootstrap JS dimuat jika diperlukan (misalnya untuk tooltip atau dropdown di masa depan) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection