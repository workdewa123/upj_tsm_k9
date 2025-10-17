@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Form Service Advisor</h3>
    <form action="{{ route('advisor.store') }}" method="POST">
        @csrf

        <div class="mb-3">
    <label>Booking</label>
    <select name="booking_id" id="booking_id" class="form-control" onchange="updateService()">
        <option value="">-- Pilih Booking --</option>
        @foreach($bookings as $b)
            <option value="{{ $b->id }}"
                    data-service="{{ $b->service->name }}"
                    data-price="{{ $b->service->price }}">
                {{ $b->plate_number }} - {{ $b->customer_name }} ({{ $b->service->name }})
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Jenis Service</label>
    <input type="text" id="service_name" class="form-control" readonly>
</div>

<div class="mb-3">
    <label>Estimasi Biaya Service</label>
    <input type="number" name="estimation_cost" id="estimation_cost" class="form-control" readonly>
</div>

        <div class="mb-3">
            <label>Suku Cadang</label>
            <textarea name="spareparts" class="form-control"></textarea>
            <small>Format: Nama|Harga, pisahkan dengan koma. <br> Contoh: Busi|24000, Oli|48000</small>
        </div>

        <div class="mb-3">
            <label>Keluhan Konsumen</label>
            <textarea name="customer_complaint" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Analisa Service Advisor</label>
            <textarea name="advisor_notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan & Cetak</button>
    </form>
</div>

<script>
function updateService() {
    let select = document.getElementById('booking_id');
    let selected = select.options[select.selectedIndex];
    let service = selected.getAttribute('data-service') || '';
    let price = selected.getAttribute('data-price') || 0;
    document.getElementById('service_name').value = service;
    document.getElementById('estimation_cost').value = price;
}
</script>

@endsection
