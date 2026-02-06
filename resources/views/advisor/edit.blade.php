@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- HEADER: Judul & Tombol Aksi --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark border-bottom pb-2 mb-0">
            <i class="fas fa-edit me-2 text-danger"></i>Edit Service Advisor
        </h1>
        
        {{-- Group Tombol: Cetak & Kembali --}}
        <div>
            {{-- Tombol Print (Baru) --}}
            {{-- target="_blank" agar membuka tab baru saat print --}}
            <a href="{{ route('advisor.print', $advisor->id) }}" target="_blank" class="btn btn-dark shadow-sm px-4 me-2">
                <i class="fas fa-print me-2"></i>Cetak PDF
            </a>

            {{-- Tombol Kembali --}}
            <a href="{{ route('advisor.index') }}" class="btn btn-light shadow-sm px-4 border">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4">
                    
                    {{-- Section Info Read-Only (Untuk Konteks) --}}
                    <div class="alert alert-light border border-danger-subtle d-flex align-items-center mb-4" role="alert">
                        <div class="me-3">
                            <i class="fas fa-motorcycle fa-2x text-danger opacity-75"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">{{ $advisor->booking->customer_name }} - {{ $advisor->booking->plate_number }}</h6>
                            <p class="mb-0 small text-secondary">
                                Service: <strong>{{ $advisor->booking->service->name }}</strong> | 
                                Estimasi Jasa Awal: <strong>Rp {{ number_format($advisor->estimation_cost, 0, ',', '.') }}</strong>
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('advisor.update', $advisor->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Input Spareparts --}}
                        <div class="mb-4">
                            <label for="spareparts" class="form-label fw-bold text-secondary text-uppercase small">
                                Daftar Spareparts & Harga
                            </label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0 text-danger"><i class="fas fa-tools"></i></span>
                                <textarea name="spareparts" id="spareparts" rows="4" 
                                    class="form-control border-start-0 ps-0 @error('spareparts') is-invalid @enderror" 
                                    placeholder="Contoh: Oli Mesin|50000, Kampas Rem|75000">{{ old('spareparts', isset($sparepartString) ? $sparepartString : '') }}</textarea>
                            </div>
                            <div class="form-text text-muted small mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Format penulisan: <strong>Nama Barang|Harga</strong>. Pisahkan barang dengan koma (,).
                            </div>
                            @error('spareparts')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Keluhan Konsumen --}}
                            <div class="col-md-6 mb-4">
                                <label for="customer_complaint" class="form-label fw-bold text-secondary text-uppercase small">
                                    Keluhan Konsumen
                                </label>
                                <textarea name="customer_complaint" id="customer_complaint" rows="3" 
                                    class="form-control shadow-sm"
                                    placeholder="Masukkan keluhan konsumen...">{{ old('customer_complaint', $advisor->customer_complaint) }}</textarea>
                            </div>

                            {{-- Catatan Advisor --}}
                            <div class="col-md-6 mb-4">
                                <label for="advisor_notes" class="form-label fw-bold text-secondary text-uppercase small">
                                    Catatan Mekanik / Advisor
                                </label>
                                <textarea name="advisor_notes" id="advisor_notes" rows="3" 
                                    class="form-control shadow-sm"
                                    placeholder="Catatan tambahan untuk teknisi...">{{ old('advisor_notes', $advisor->advisor_notes) }}</textarea>
                            </div>
                        </div>

                        {{-- Tombol Aksi Form --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            <button type="reset" class="btn btn-light border shadow-sm px-4 fw-bold text-secondary">Reset</button>
                            <button type="submit" class="btn btn-danger shadow px-5 fw-bold">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection