<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ServiceAdvisor;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use PDF; // from barryvdh/laravel-dompdf

class ServiceAdvisorController extends Controller
{

public function index()
    {
        // Mengambil data dengan relasi agar tidak N+1 Problem
        $advisors = ServiceAdvisor::with(['booking.user', 'booking.service'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
                    
        return view('advisor.index', compact('advisors'));
    }

    // --- 2. EDIT (Form Edit) ---
    public function edit($id)
    {
        $advisor = ServiceAdvisor::with('booking.service')->findOrFail($id);
        
        // Konversi spareparts JSON kembali ke string format "Nama|Harga, Nama|Harga"
        // Agar mudah diedit di text input form
        $sparepartString = '';
        if ($advisor->spareparts && is_array($advisor->spareparts)) {
            $partsArray = [];
            foreach ($advisor->spareparts as $part) {
                // Pastikan format array sesuai saat store
                $partsArray[] = $part['name'] . '|' . $part['price'];
            }
            $sparepartString = implode(', ', $partsArray);
        }

        return view('advisor.edit', compact('advisor', 'sparepartString'));
    }

    // --- 3. UPDATE (Proses Simpan Perubahan) ---
    public function update(Request $request, $id)
    {
        $request->validate([
            'spareparts' => 'nullable|string',
            'customer_complaint' => 'nullable|string',
            'advisor_notes' => 'nullable|string',
        ]);

        $advisor = ServiceAdvisor::findOrFail($id);
        
        // Ambil harga service asli dari booking/service terkait (tidak berubah)
        $servicePrice = $advisor->estimation_cost; 

        // --- Logika Parsing Spareparts (Sama seperti Store) ---
        $spareparts = [];
        $totalParts = 0;

        if ($request->spareparts) {
            $items = explode(',', $request->spareparts);

            foreach ($items as $item) {
                $item = trim($item);
                if ($item === '') continue;

                // Pecah berdasarkan "|"
                $parts = explode('|', $item);

                if (count($parts) === 2) {
                    [$name, $price] = array_map('trim', $parts);
                    $price = (int) $price;
                    
                    $spareparts[] = [
                        'name' => $name,
                        'price' => $price
                    ];
                    $totalParts += $price;
                }
            }
        }

        // Update Data
        $advisor->update([
            'spareparts'        => $spareparts, // Laravel akan auto-cast ke JSON jika di Model ada casts
            'estimation_parts'  => $totalParts,
            'total_estimation'  => $servicePrice + $totalParts, // Hitung ulang total
            'customer_complaint'=> $request->customer_complaint,
            'advisor_notes'     => $request->advisor_notes,
        ]);

        return redirect()->route('advisor.index')->with('success', 'Data Service Advisor berhasil diperbarui!');
    }
        
    public function create()
    {
    $bookings = \App\Models\Booking::with('service')->get();
    return view('advisor.create', compact('bookings'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'spareparts' => 'nullable|string',
            'customer_complaint' => 'nullable|string',
            'advisor_notes' => 'nullable|string',
        ]);

        $booking = \App\Models\Booking::with('service')->findOrFail($request->booking_id);

        $servicePrice = $booking->service->price;
        $spareparts = [];
        $totalParts = 0;

        if ($request->spareparts) {
        $items = explode(',', $request->spareparts);

        foreach ($items as $item) {
            $item = trim($item);
            if ($item === '') continue;

            // Pecah lagi berdasarkan "|"
            $parts = explode('|', $item);

            if (count($parts) === 2) {
                [$name, $price] = array_map('trim', $parts);

                $price = (int) $price;
                $spareparts[] = [
                    'name' => $name,
                    'price' => $price
                ];

                $totalParts += $price;
            }
        }
    }

        $advisor = \App\Models\ServiceAdvisor::create([
        'booking_id'        => $booking->id,
        'jobs'              => $booking->service->name,
        'estimation_cost'   => $servicePrice,
        'spareparts' => $spareparts,
        'estimation_parts'  => $totalParts,
        'total_estimation'  => $servicePrice + $totalParts,
        'customer_complaint'=> $request->customer_complaint,
        'advisor_notes'     => $request->advisor_notes,
    ]);

        return redirect()->route('advisor.index')
        ->with('success', 'Data Service Advisor berhasil disimpan. Silakan klik ikon Print pada tabel jika ingin mencetak.');
    }

    public function print($id)
    {
        $advisor = ServiceAdvisor::with('booking.service')->findOrFail($id);

        if (is_string($advisor->spareparts)) {
            $advisor->spareparts = json_decode($advisor->spareparts, true);
        }

        $pdf = FacadePdf::loadView('advisor.print', compact('advisor'))
                ->setPaper('A4', 'portrait');

        return $pdf->stream('service_advisor_'.$advisor->id.'.pdf');
    }

}
