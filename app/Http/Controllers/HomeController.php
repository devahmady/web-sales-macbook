<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    public function index()
    {
        $items = Barang::with('category')->get();

        // Menghitung total harga hanya untuk item dengan status 'Lunas'
        $lunas = $items->filter(function ($item) {
            return $item->status == 'Lunas';
        })->sum('harga');

        $proses = $items->filter(function ($item) {
            return $item->status == 'Proses';
        })->sum('harga');

        $total = DB::table('barangs')->count();
        return view('admin.home.index', compact( 'lunas', 'proses','total'));
    }
}
