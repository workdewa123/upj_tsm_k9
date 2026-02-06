@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="container py-4">
    {{-- HEADER: Judul & Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark border-bottom pb-2 mb-0">
            <i class="fas fa-user-circle me-2 text-danger"></i>Profil Pengguna
        </h1>
        <a href="{{ url()->previous() }}" class="btn btn-light shadow-sm px-4 border">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            
            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Card Utama (Mengikuti konsep Edit/Create) --}}
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- Input Nama --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold text-secondary text-uppercase small">Nama Lengkap</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0 text-danger"><i class="fas fa-user"></i></span>
                                <input id="name" type="text" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" 
                                    name="name" value="{{ old('name', $user->name) }}" required autofocus>
                            </div>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Email --}}
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-secondary text-uppercase small">Alamat Email</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0 text-danger"><i class="fas fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4 opacity-25">

                        {{-- Section Password --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="password" class="form-label fw-bold text-secondary text-uppercase small">Password Baru (Opsional)</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-end-0 text-danger"><i class="fas fa-lock"></i></span>
                                    <input id="password" type="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" 
                                        name="password" placeholder="Kosongkan jika tidak ganti">
                                </div>
                                <div class="form-text small text-muted">Minimal 6 karakter.</div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password_confirmation" class="form-label fw-bold text-secondary text-uppercase small">Konfirmasi Password</label>
                                <div class="input-group shadow-sm">
                                    <span class="input-group-text bg-white border-end-0 text-danger"><i class="fas fa-check-double"></i></span>
                                    <input id="password_confirmation" type="password" class="form-control border-start-0 ps-0" 
                                        name="password_confirmation" placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-grid mt-2">
                            <button type="submit" class="btn btn-danger btn-lg shadow fw-bold rounded-3 py-3">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection