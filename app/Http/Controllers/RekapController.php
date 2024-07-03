<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Barang;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BarangImport;
use App\Exports\BarangExport;
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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            Excel::import(new BarangImport, $request->file('file'));
            return redirect()->route('rekap.index')->with('success', 'Data Barang berhasil diimpor!');
        } catch (\Exception $e) {
            return redirect()->route('rekap.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new BarangExport, 'barang.xlsx');
    }
}
