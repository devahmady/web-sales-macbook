<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class BarangExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    private $totalHarga = 0;

    public function collection()
    {
        $barangs = Barang::with('category')->get();

        // Calculate total harga
        $this->totalHarga = $barangs->sum('harga');

        return $barangs;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal Masuk',
            'Nama',
            'Tindakan',
            'Jenis Barang', // Nama kategori
            'Merek',
            'Type',
            'Tanggal Keluar',
            'Harga',
            'Status',
            'Created At',
            'Updated At',
        ];
    }

    public function map($barang): array
    {
        return [
            $barang->id,
            $barang->tanggal_masuk,
            $barang->nama,
            $barang->tindakan,
            $barang->category ? $barang->category->nama : '', // Ambil nama kategori
            $barang->merek,
            $barang->type,
            $barang->tanggal_keluar,
            $this->formatCurrency($barang->harga), // Format harga
            $barang->status,
            $barang->created_at,
            $barang->updated_at,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $highestRow = $event->sheet->getHighestRow();

                // Add a total row
                $event->sheet->appendRows([
                    ['', '', '', '', '', '', '', 'TOTAL', $this->formatCurrency($this->totalHarga)]
                ], $event);
            },
        ];
    }

    private function formatCurrency($amount)
    {
        return 'Rp. ' . number_format($amount, 0, ',', '.');
    }
}
