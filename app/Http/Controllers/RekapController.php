<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Barang;
use PDF;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $items = Barang::all();
        $totalHargaLunas = $items->where('status', 'Lunas')->sum('harga'); // Filter hanya yang Lunas
        $tanggalMasukAwalFormatted = null;
        $tanggalMasukAkhirFormatted = null;
        $status = null;

        return view('admin.rekap.index', compact('items', 'totalHargaLunas', 'tanggalMasukAwalFormatted', 'tanggalMasukAkhirFormatted', 'status'));
    }

    public function cari(Request $request)
    {
        $tanggalMasukAwal = $request->input('tanggal_masuk_awal');
        $tanggalMasukAkhir = $request->input('tanggal_masuk_akhir');
        $status = $request->input('status');

        $items = Barang::query();

        if ($tanggalMasukAwal && $tanggalMasukAkhir) {
            $items->whereDate('tanggal_masuk', '>=', $tanggalMasukAwal)
                ->whereDate('tanggal_masuk', '<=', $tanggalMasukAkhir);
        }

        if ($status) {
            $items->where('status', $status);
        }

        $items = $items->with('category')->get();
        $totalHargaLunas = $items->where('status', 'Lunas')->sum('harga');
        $tanggalMasukAwalFormatted = $tanggalMasukAwal ? Carbon::parse($tanggalMasukAwal)->format('d F Y') : null;
        $tanggalMasukAkhirFormatted = $tanggalMasukAkhir ? Carbon::parse($tanggalMasukAkhir)->format('d F Y') : null;

        return view('admin.rekap.index', compact('items', 'tanggalMasukAwalFormatted', 'tanggalMasukAkhirFormatted', 'status', 'totalHargaLunas'));
    }

    public function printPDF(Request $request)
    {
        $tanggalMasukAwal = $request->input('tanggal_masuk_awal');
        $tanggalMasukAkhir = $request->input('tanggal_masuk_akhir');
        $status = $request->input('status');
    
        $items = Barang::query();
    
        if ($tanggalMasukAwal && $tanggalMasukAkhir) {
            $items->whereDate('tanggal_masuk', '>=', $tanggalMasukAwal)
                ->whereDate('tanggal_masuk', '<=', $tanggalMasukAkhir);
        }
    
        if ($status) {
            $items->where('status', $status);
        }
    
        $items = $items->with('category')->get();
        $totalHargaLunas = $items->where('status', 'Lunas')->sum('harga');
        $tanggalMasukAwalFormatted = $tanggalMasukAwal ? Carbon::parse($tanggalMasukAwal)->format('d F Y') : null;
        $tanggalMasukAkhirFormatted = $tanggalMasukAkhir ? Carbon::parse($tanggalMasukAkhir)->format('d F Y') : null;
    
        // Load view menggunakan mPDF
        $mpdf = new \Mpdf\Mpdf();
        $html = view('admin.rekap.print', compact('items', 'tanggalMasukAwalFormatted', 'tanggalMasukAkhirFormatted', 'status', 'totalHargaLunas'))->render();
        $mpdf->WriteHTML($html);
    
        // Menentukan cara output (tampilkan di browser atau simpan sebagai file)
        $mpdf->Output('rekap_barang.pdf', 'I'); // 'I' untuk menampilkan di browser, 'F' untuk menyimpan sebagai file
    
        // Jika Anda ingin menyimpan sebagai file:
        $mpdf->Output(storage_path('app/rekap_barang.pdf'), 'F');
    }
    
}
