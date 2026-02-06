@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- HEADER: Judul & Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark border-bottom pb-2 mb-0">
            <i class="fas fa-clipboard-list me-2 text-danger"></i>Buat Service Advisor
        </h1>
        <a href="{{ route('advisor.index') }}" class="btn btn-light shadow-sm px-4 border">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    <form action="{{ route('advisor.store') }}" method="POST">
                        @csrf

                        {{-- Section 1: Pilih Customer --}}
                        <div class="mb-4">
                            <label for="booking_id" class="form-label fw-bold text-secondary text-uppercase small">
                                Pilih Booking Customer
                            </label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0 text-danger"><i class="fas fa-search"></i></span>
                                <select name="booking_id" id="booking_id" class="form-select border-start-0 ps-0 @error('booking_id') is-invalid @enderror" onchange="updateService()" style="cursor: pointer;">
                                    <option value="">-- Pilih Berdasarkan Plat Nomor / Nama --</option>
                                    @foreach($bookings as $b)
                                        <option value="{{ $b->id }}"
                                                data-service="{{ $b->service->name }}"
                                                data-price="{{ $b->service->price }}">
                                            {{ $b->plate_number }} - {{ $b->customer_name }} ({{ $b->service->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('booking_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Section 2: Info Read-only (Muncul otomatis via JS) --}}
                        <div class="alert alert-light border border-danger-subtle d-flex align-items-center mb-4 shadow-sm" role="alert">
                            <div class="me-3">
                                <i class="fas fa-wrench fa-2x text-danger opacity-75"></i>
                            </div>
                            <div class="row w-100">
                                <div class="col-md-6">
                                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Jenis Service</small>
                                    <input type="text" id="service_name" class="form-control-plaintext fw-bold p-0 text-dark" value="-" readonly>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Estimasi Jasa Awal</small>
                                    <div class="fw-bold text-danger">Rp <span id="display_price">0</span></div>
                                    <input type="hidden" name="estimation_cost" id="estimation_cost" value="0">
                                </div>
                            </div>
                        </div>

                        {{-- Section 3: Input Spareparts --}}
                        <div class="mb-4">
                            <label for="spareparts" class="form-label fw-bold text-secondary text-uppercase small">
                                Daftar Spareparts & Harga
                            </label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0 text-danger"><i class="fas fa-tools"></i></span>
                                <textarea name="spareparts" id="spareparts" rows="3" 
                                    class="form-control border-start-0 ps-0 @error('spareparts') is-invalid @enderror" 
                                    placeholder="Contoh: Oli Mesin|50000, Kampas Rem|75000">{{ old('spareparts') }}</textarea>
                            </div>
                            <div class="form-text text-muted small mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Format: <strong>Nama Barang|Harga</strong>. Gunakan koma (,) untuk memisahkan antar barang.
                            </div>
                        </div>

                        {{-- Section 4: Keluhan & Catatan --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="customer_complaint" class="form-label fw-bold text-secondary text-uppercase small">
                                    Keluhan Konsumen
                                </label>
                                <textarea name="customer_complaint" id="customer_complaint" rows="3" 
                                    class="form-control shadow-sm"
                                    placeholder="Masukkan keluhan konsumen...">{{ old('customer_complaint') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="advisor_notes" class="form-label fw-bold text-secondary text-uppercase small">
                                    Catatan Mekanik / Advisor
                                </label>
                                <textarea name="advisor_notes" id="advisor_notes" rows="3" 
                                    class="form-control shadow-sm"
                                    placeholder="Catatan tambahan teknisi...">{{ old('advisor_notes') }}</textarea>
                            </div>
                        </div>

                        {{-- FOOTER: Tombol Aksi (Dipisah Simpan & Cetak) --}}
                        <hr class="my-4 opacity-25">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <button type="submit" name="action" value="save" class="btn btn-outline-dark btn-lg w-100 fw-bold shadow-sm rounded-3">
                                    <i class="fas fa-save me-2"></i>Simpan Saja
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" name="action" value="print" class="btn btn-danger btn-lg w-100 fw-bold shadow-sm rounded-3">
                                    <i class="fas fa-print me-2"></i>Simpan & Cetak PDF
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateService() {
    let select = document.getElementById('booking_id');
    let selected = select.options[select.selectedIndex];
    
    if (!selected.value) {
        document.getElementById('service_name').value = "-";
        document.getElementById('estimation_cost').value = "0";
        document.getElementById('display_price').innerText = "0";
        return;
    }

    let service = selected.getAttribute('data-service') || '';
    let price = selected.getAttribute('data-price') || 0;
    
    document.getElementById('service_name').value = service;
    document.getElementById('estimation_cost').value = price;
    document.getElementById('display_price').innerText = new Intl.NumberFormat('id-ID').format(price);
}
</script>
@endsection