@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzLlQ36k2UaYJtU378F7xXvP+sN4fFw/U6/A2uB4aU+M+F1U+A9P7y+W+W+Z+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="container py-4">

    <h1 class="mb-4 text-primary fw-bold border-bottom pb-2">Daftar Semua Customer</h1>

    @if ($customers->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            <i class="fas fa-users-slash fa-2x mb-2"></i>
            <p class="mb-0">Belum ada customer yang terdaftar dengan role 'customer'.</p>
        </div>
    @else
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="py-3 px-4">#</th>
                                <th scope="col" class="py-3 px-4">Nama Customer</th>
                                <th scope="col" class="py-3 px-4">Email</th>
                                <th scope="col" class="py-3 px-4">No. WhatsApp Terakhir</th>
                                <th scope="col" class="py-3 px-4 text-center">Total Booking</th>
                                <th scope="col" class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $index => $customer)
                                <tr>
                                    <td class="px-4 align-middle">{{ $index + 1 }}</td>
                                    <td class="px-4 align-middle fw-bold">{{ $customer->name }}</td>
                                    <td class="px-4 align-middle">{{ $customer->email }}</td>
                                    <td class="px-4 align-middle">
                                        @if ($customer->bookings->isNotEmpty())
                                            @php
                                                // Ambil nomor WhatsApp dari booking terakhir (first() karena di eager load)
                                                // Ini adalah cara yang benar untuk mengakses data dari relasi.
                                                $whatsappNumber = $customer->bookings->first()->customer_whatsapp;
                                            @endphp
                                            {{ $whatsappNumber }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-4 align-middle text-center">
                                        <span class="badge bg-primary rounded-pill py-2 px-3">{{ $customer->bookings->count() }}</span>
                                    </td>
                                    <td class="px-4 align-middle text-center">
                                        @if ($customer->bookings->isNotEmpty())
                                            <!-- INI ADALAH SOLUSI UNTUK MISSING PARAMETER -->
                                            <!-- Kita passing 'whatsappNumber' yang sudah dipastikan ada ke route -->
                                            <a href="{{ route('customers.bookings', ['email' => $customer->email, 'whatsapp' => $whatsappNumber ?? 'N/A']) }}" class="btn btn-sm btn-outline-info fw-bold">
                                                <i class="fas fa-search me-1"></i> Lihat Semua Booking
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary" disabled>Tidak ada Booking</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
