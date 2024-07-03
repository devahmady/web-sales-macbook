<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class BarangImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Barang([
            'tanggal_masuk' => $this->transformDate($row['tanggal_masuk']),
            'nama' => $row['nama'],
            'tindakan' => $row['tindakan'],
            'category_id' => $this->getCategoryId($row['jenis_barang']),
            'merek' => $row['merek'],
            'type' => $row['type'],
            'tanggal_keluar' => $row['tanggal_keluar'] ? $this->transformDate($row['tanggal_keluar']) : null,
            'harga' => $this->transformCurrency($row['harga']),
        ]);
    }

    private function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return Carbon::createFromFormat($format, $value);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getCategoryId($jenisBarang)
    {
        $category = Category::firstOrCreate(['nama' => $jenisBarang]);
        return $category->id;
    }

    private function transformCurrency($value)
    {
        // Hapus karakter non-numerik kecuali titik dan minus
        $value = preg_replace('/[^\d.-]/', '', $value);

        // Konversi ke tipe float
        return floatval($value);
    }
}
