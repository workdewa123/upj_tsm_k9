<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Nota Service</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 10mm;
            background: #fff;
            -webkit-print-color-adjust: exact;
        }
        
        .fw-bold { font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .bg-gray { background-color: #e0e0e0 !important; }
        .w-100 { width: 100%; }
        
        /* Layout Table */
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000;
        }
        
        .main-table td, .main-table th {
            border: 1px solid #000;
            padding: 3px 5px;
            vertical-align: top;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 5px;
            border-bottom: 2px solid #000;
            margin-bottom: 5px;
        }

        .dotted { border-bottom: 1px dotted #000; display: inline-block; width: 100%; height: 12px; }
        .box { display: inline-block; width: 10px; height: 10px; border: 1px solid #000; margin-right: 3px; }

        .row-info { display: flex; margin-bottom: 2px; }
        .label { width: 80px; flex-shrink: 0; }
        .val { flex-grow: 1; border-bottom: 1px dotted #000; min-height: 14px; font-weight: bold; }

        @media print {
            .no-print { display: none; }
            body { padding: 0.5cm; }
        }
    </style>
</head>
<body>

    @php
        // 1. Ambil Harga Jasa
        $servicePrice = $advisor->booking->service->price ?? 0;
        
        // 2. Ambil List Sparepart
        $parts = $advisor->spareparts ?? [];
        $max_parts = 5; // Baris untuk layout
        
        // 3. Hitung Total Sparepart
        $sparepartTotal = 0;
        foreach($parts as $p) {
            $sparepartTotal += $p['price'];
        }

        // 4. Hitung Grand Total (Jasa + Sparepart)
        $grandTotal = $servicePrice + $sparepartTotal;
    @endphp

    <div class="header-container">
        <img src="https://i.pinimg.com/1200x/c4/d9/29/c4d9293cb99e358ecc8585081223b22e.jpg" height="50">
        <div class="text-center" style="flex-grow: 1;">
            <h2 style="margin:0; font-size:16px; font-weight:900;">AHASS 00126 - CV. SINAR BARU</h2>
            <div style="font-size:10px;">Jl. Stadion No. 132 Pamekasan Telp. (0324) 321119</div>
            <div style="font-size:10px; font-weight:bold;">BOOKING SERVICE : 087701704, 08780330487</div>
        </div>
        <img src="https://astramotorpurwokerto.wordpress.com/wp-content/uploads/2020/08/ahass-logo2-1.png" height="40">
    </div>

    <h3 class="text-center" style="margin: 5px 0; text-decoration: underline;">FORM SERVICE ADVISOR</h3>

    <table class="main-table">
        <tr>
            <td style="width: 33%;">
                <div class="fw-bold text-decoration-underline mb-1">Data Motor</div>
                <div class="row-info"><span class="label">No. Urut</span>: <span class="val"></span></div>
                <div class="row-info"><span class="label">Tgl Servis</span>: <span class="val">{{ date('d-m-Y', strtotime($advisor->booking->booking_date)) }}</span></div>
                <div class="row-info"><span class="label">No. Mesin</span>: <span class="val"></span></div>
                <div class="row-info"><span class="label">No. Rangka</span>: <span class="val"></span></div>
                <div class="row-info"><span class="label">No. Polisi</span>: <span class="val">{{ $advisor->booking->plate_number }}</span></div>
                <div class="row-info"><span class="label">Type</span>: <span class="val">{{ $advisor->booking->vehicle_type }}</span></div>
                <div class="row-info"><span class="label">Tahun</span>: <span class="val"></span></div>
                <div class="row-info"><span class="label">KM</span>: <span class="val"></span></div>
                <div class="row-info"><span class="label">Email</span>: <span class="val" style="font-size:9px;">{{ $advisor->booking->user->email ?? '-' }}</span></div>
            </td>
            <td style="width: 33%;">
                <div class="fw-bold text-decoration-underline mb-1">Data Pembawa</div>
                <div class="row-info"><span class="label" style="width:50px;">Nama</span>: <span class="val"></span></div>
                <div class="row-info"><span class="label" style="width:50px;">Alamat</span>: <span class="val"></span></div>
                <div class="row-info"><span class="label" style="width:50px;">No. HP</span>: <span class="val"></span></div>
                <hr style="margin: 5px 0; border:0; border-top:1px solid #000;">
                <div class="fw-bold text-decoration-underline mb-1">Data Pemilik</div>
                <div class="row-info"><span class="label" style="width:50px;">Nama</span>: <span class="val">{{ $advisor->booking->customer_name }}</span></div>
                <div class="row-info"><span class="label" style="width:50px;">Alamat</span>: <span class="val"></span></div>
                <div class="row-info"><span class="label" style="width:50px;">No. HP</span>: <span class="val">{{ $advisor->booking->customer_whatsapp }}</span></div>
            </td>
            <td style="width: 33%;">
                <div style="margin-bottom: 5px;">
                    Dari Dealer Sendiri: <span class="box"></span> Ya <span class="box"></span> Tidak
                </div>
                <div class="row-info"><span class="label" style="width:100px;">Hub. Pembawa</span>: <span class="val"></span></div>
                <div class="fw-bold mt-2">Alasan ke AHASS:</div>
                <div>a. Inisiatif Sendiri</div>
                <div>b. SMS Reminder</div>
                <div>c. Telp Reminder</div>
                <div>d. Sticker Reminder</div>
                <div class="row-info"><span style="width:15px;">e.</span> Lainnya: <span class="val"></span></div>
            </td>
        </tr>

        <tr>
            <td colspan="2" style="padding: 0; border: none;">
                <table class="w-100" style="border-collapse: collapse;">
                    <tr>
                        <td style="width: 35%; text-align: center; border-right: 1px solid #000; border-bottom: 1px solid #000;">
                            <div class="bg-gray fw-bold" style="border-bottom: 1px solid #000; margin: -3px -5px 5px -5px; padding: 3px;">Kondisi Awal SMH</div>
                            <img src="{{ asset('images/gbr_1.png') }}" style="height: 80px; margin-bottom: 10px;">
                            <div class="text-left fw-bold">Catatan Lain:</div>
                            <div style="height: 60px;"></div>
                        </td>
                        <td style="width: 65%; padding: 0; border-bottom: 1px solid #000;">
                            <table class="w-100" style="border-collapse: collapse; border: none;">
                                <tr class="bg-gray">
                                    <th style="border:1px solid #000; border-top:none; border-left:none;">Pekerjaan</th>
                                    <th style="border:1px solid #000; border-top:none; border-right:none; width: 80px;">Estimasi</th>
                                </tr>
                                
                                <tr>
                                    <td style="border-left:none;">1. {{ $advisor->booking->service->name }}</td>
                                    <td class="text-right" style="border-right:none;">{{ number_format($servicePrice, 0, ',', '.') }}</td>
                                </tr>
                                @for($i=2; $i<=5; $i++)
                                <tr>
                                    <td style="border-left:none;">{{ $i }}. <span class="dotted"></span></td>
                                    <td style="border-right:none;">Rp</td>
                                </tr>
                                @endfor

                                <tr class="bg-gray">
                                    <th style="border:1px solid #000; border-left:none;">Suku Cadang</th>
                                    <th style="border:1px solid #000; border-right:none;">Harga</th>
                                </tr>

                                @foreach($parts as $idx => $part)
                                <tr>
                                    <td style="border-left:none;">{{ $idx+1 }}. {{ $part['name'] }}</td>
                                    <td class="text-right" style="border-right:none;">{{ number_format($part['price'], 0, ',', '.') }}</td>
                                </tr>
                                @endforeach

                                @for($j = count($parts)+1; $j <= $max_parts; $j++)
                                <tr>
                                    <td style="border-left:none;">{{ $j }}. <span class="dotted"></span></td>
                                    <td style="border-right:none;">Rp</td>
                                </tr>
                                @endfor

                                <tr>
                                    <td class="fw-bold text-right" style="border-left:none;">Total Harga</td>
                                    <td class="fw-bold text-right bg-gray" style="border-right:none;">
                                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-top: none; padding: 0;">
                            <div class="bg-gray fw-bold" style="padding: 2px 5px; border-bottom: 1px solid #000;">Keluhan Konsumen</div>
                            <div style="height: 40px; padding: 5px; border-bottom: 1px solid #000;">
                                {{ $advisor->customer_complaint ?? $advisor->booking->complaint ?? '-' }}
                            </div>
                            <div class="bg-gray fw-bold" style="padding: 2px 5px; border-bottom: 1px solid #000;">Analisa Service Advisor</div>
                            <div style="height: 40px; padding: 5px;">
                                {{ $advisor->advisor_notes ?? '-' }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width: 33%; padding: 0;">
                <!-- <div class="bg-gray fw-bold text-center" style="padding: 3px; border-bottom: 1px solid #000;">Saran Ganti Sparepart</div> 
                <table class="w-100" style="font-size: 9px; border: none;">
                    <tr class="bg-gray text-center">
                        <td style="border-left:none;">KM</td>
                        <td>Part</td>
                        <td style="border-right:none;">Cek</td>
                    </tr>
                    <tr><td class="text-center" style="border-left:none;">8.000</td><td>Busi</td><td class="text-center" style="border-right:none;"><span class="box"></span></td></tr>
                    <tr><td class="text-center" style="border-left:none;">8.000</td><td>Oli Gear</td><td class="text-center" style="border-right:none;"><span class="box"></span></td></tr>
                    <tr><td class="text-center" style="border-left:none;">24.000</td><td>V-Belt</td><td class="text-center" style="border-right:none;"><span class="box"></span></td></tr>
                    <tr><td class="text-center" style="border-left:none;">12.000</td><td>Air Radiator</td><td class="text-center" style="border-right:none;"><span class="box"></span></td></tr>
                    <tr><td class="text-center" style="border-left:none;">16.000</td><td>Filter Udara</td><td class="text-center" style="border-right:none;"><span class="box"></span></td></tr>
                    <tr><td class="text-center" style="border-left:none;">24.000</td><td>Kampas Rem</td><td class="text-center" style="border-right:none;"><span class="box"></span></td></tr>
                    <tr><td class="text-center" style="border-left:none;">-</td><td>Ban Luar</td><td class="text-center" style="border-right:none;"><span class="box"></span></td></tr>
                    <tr><td class="text-center" style="border-left:none;">-</td><td>Aki</td><td class="text-center" style="border-right:none;"><span class="box"></span></td></tr>
                    <tr class="bg-gray fw-bold text-center"><td colspan="3" style="border-left:none; border-right:none;">Paket Pembersihan</td></tr>
                    <tr><td class="text-center" style="border-left:none;">8.000</td><td>Injektor</td><td class="text-center" style="border-right:none;"><span class="box"></span></td></tr>
                    <tr><td class="text-center" style="border-left:none;">8.000</td><td>Ruang Bakar</td><td class="text-center" style="border-right:none;"><span class="box"></span></td></tr>
                    <tr><td class="text-center" style="border-left:none;">8.000</td><td>CVT</td><td class="text-center" style="border-right:none;"><span class="box"></span></td></tr>
                    <tr><td colspan="3" style="height: 55px; border-left:none; border-right:none; border-bottom:none;"></td></tr>
                </table>-->
            </td>
        </tr>
    </table>

    <div style="font-size: 9px; margin-top: 5px;">
        *Apabila ada tambahan PEKERJAAN/PART diluar daftar diatas: 
        <span class="box"></span> Konfirmasi <span class="dotted" style="width:50px;"></span> 
        <span class="box"></span> Langsung Kerja. 
        (Part bekas dibawa pulang: <span class="box"></span> Ya <span class="box"></span> Tidak)
    </div>

    <table class="main-table" style="margin-top: 5px; text-align: center;">
        <tr class="bg-gray">
            <td style="width: 35%;">Pekerjaan + Biaya + Waktu</td>
            <td style="width: 35%;">Pekerjaan + Biaya + Waktu</td>
            <td style="width: 15%;">Tambahan</td>
            <td style="width: 15%;">Final Check</td>
            <td style="width: 35%;">Penyerahan</td>
        </tr>
        <tr style="height: 60px;">
            <td style="vertical-align: bottom;">
                <div style="display:flex; justify-content:space-between; border-right">
                    <div style="width:45%; border-top:1px solid #000;">Konsumen TTD</div>
                </div>
            </td>
            <td style="vertical-align: bottom;">
                <div style="display:flex; justify-content:space-between; border-left">
                    <div style="width:45%; border-top:1px solid #000;">Service Advisor Ttd</div>
                </div>
            </td>
            <td style="vertical-align: bottom;"><div style="border-top:1px solid #000;">Konsumen</div></td>
            <td style="vertical-align: bottom;"><div style="border-top:1px solid #000;">Paraf Final Ins</div></td>
            <td style="vertical-align: bottom;">
                <div style="border-top:1px solid #000; width: 60%; margin: 0 auto;">Konsumen</div>
            </td>
        </tr>
    </table>

    <table class="main-table" style="margin-top: 5px; border-top: none;">
        <tr>
            <td style="width: 60%; border-top:none;">
                <strong>Saran Mekanik:</strong>
                <div style="height: 30px;"></div>
                Nama Mekanik: <span class="dotted" style="width: 150px;"></span>
            </td>
            <td style="width: 40%; border-top:none;">
                <strong>Estimasi Waktu:</strong>
                <div class="row-info"><span class="label">Pendaftaran</span>: <span class="val"></span></div>
                <div class="row-info"><span class="label">Dikerjakan</span>: <span class="val"></span></div>
                <div class="row-info"><span class="label">Selesai</span>: <span class="val"></span></div>
            </td>
        </tr>
    </table>
    
    <div style="font-size: 8px; margin-top: 5px;">
        <strong>Garansi:</strong> 
        <br>- 500KM/1 Minggu (Servis Reguler) 
        <br>- 1000KM/1 Bulan (Bongkar Mesin). 
        <br>Syarat & Ketentuan berlaku, garansi tidak berlaku jika motor mengalami kecelakaan, modifikasi, atau kerusakan akibat pemakaian yang tidak sesuai standar pabrikan.
    </div>

    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>