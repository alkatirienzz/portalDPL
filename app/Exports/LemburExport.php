<?php

namespace App\Exports;

use App\Models\Lembur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LemburExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data_lembur;
    public function __construct($data_lembur)
    {
        $this->data_lembur = $data_lembur;
    }

    public function collection()
    {
        return collect($this->data_lembur);
    }

    public function headings(): array
    {
        return [
            'No.',
            'Nama Pegawai',
            'Tanggal',
            'Jam Masuk',
            'Lokasi Masuk',
            'Foto Masuk',
            'Jam Pulang',
            'Lokasi Pulang',
            'Foto Pulang',
            'Total Lembur',
            'Notes',
            'User Approval',
            'Status',
            'Kategori Lembur', // Heading tambahan untuk kategori lembur
        ];
    }
}

