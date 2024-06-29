<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Category; // Tambahkan model Category
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $items = Barang::with('category')->get();
    $categories = Category::all();

    // Menghitung total harga hanya untuk item dengan status 'Lunas'
    $lunas = $items->filter(function ($item) {
        return $item->status == 'Lunas';
    })->sum('harga');

    $proses = $items->filter(function ($item) {
        return $item->status == 'Proses';
    })->sum('harga');

    return view('admin.barang.index', compact('items', 'categories', 'lunas','proses'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Barang::with('category')->get();
        $categories = Category::all();
        return view('admin.barang.create', compact('categories','items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tanggal_masuk' => 'required|date',
            'tindakan' => 'required',
            'merek' => 'required',
            'type' => 'required',
            'status' => 'required',
            'tanggal_keluar' => 'nullable|date',
            'harga' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $items = Barang::find($id);
        return view('admin.barang.show', compact('items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $items = Barang::find($id);
        $categories = Category::all();
        return view('admin.barang.edit_barang', compact('items', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'tanggal_masuk' => 'required|date',
            'tindakan' => 'required',
            'jenis_barang' => 'required',
            'merek' => 'required',
            'type' => 'required',
            'tanggal_keluar' => 'nullable|date',
            'harga' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $items = Barang::find($id);
        $items->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $items = Barang::find($id);
        $items->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
