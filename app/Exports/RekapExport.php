<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class RekapExport implements FromQuery, WithColumnFormatting, WithMapping, WithHeadings,ShouldAutoSize,WithStyles
{
    use Exportable;

    public function styles(Worksheet $sheet)
    {
        $highestColumn = $sheet->getHighestColumn();
        $highestRow = $sheet->getHighestRow();

        //BORDER
        $sheet->getStyle("A1:$highestColumn" . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // HEADER
        $sheet->getStyle("A1:" . $highestColumn . "1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // WRAP TEXT
        $sheet->getStyle("A1:$highestColumn" . $highestRow)->getAlignment()->setWrapText(true);

        // ALIGNMENT TEXT
        $sheet->getStyle("A1:$highestColumn" . $highestRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

        //BOLD FIRST ROW
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Total Cuti',
            'Total Izin Masuk',
            'Total Izin Telat',
            'Total Izin Pulang Cepat',
            'Total Hadir',
            'Total Alfa',
            'Total Libur',
            'Total Telat',
            'Total Pulang Cepat',
            'Total Lembur',
            'Persentase Kehadiran',
            'Kategori Lembur',
            'Upah Lembur',
        ];
    }

    // public function map($model): array
    // {
    //     $tanggal_mulai = request()->input('mulai');
    //     $tanggal_akhir = request()->input('akhir');
    //     $cuti = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Cuti')->count();
    //     $izin_masuk = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Izin Masuk')->count();
    //     $izin_telat = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Izin Telat')->count();
    //     $izin_pulang_cepat = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Izin Pulang Cepat')->count();
    //     $masuk = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Masuk')->count();
    //     $total_hadir = $masuk + $izin_telat + $izin_pulang_cepat;
    //     $libur = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Libur')->count();
    //     $mulai = new \DateTime($tanggal_mulai);
    //     $akhir = new \DateTime($tanggal_akhir);
    //     $interval = $mulai->diff($akhir);
    //     $total_alfa = $interval->days + 1 - $masuk - $cuti - $izin_masuk - $libur;
    //     $total_telat = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->sum('telat');
    //     $jam   = floor($total_telat / (60 * 60));
    //     $menit = $total_telat - ( $jam * (60 * 60) );
    //     $menit2 = floor($menit / 60);
    //     $jumlah_telat = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('telat', '>', 0)->count();
    //     $total_pulang_cepat = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->sum('pulang_cepat');
    //     $jam_cepat   = floor($total_pulang_cepat / (60 * 60));
    //     $menit_cepat = $total_pulang_cepat - ( $jam_cepat * (60 * 60) );
    //     $menit_cepat2 = floor($menit_cepat / 60);
    //     $jumlah_pulang_cepat = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('pulang_cepat', '>', 0)->count();
    //     $total_lembur = $model->Lembur->where('status', 'Approved')->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->sum('total_lembur');
    //     $jam_lembur   = floor($total_lembur / (60 * 60));
    //     $menit_lembur = $total_lembur - ( $jam_lembur * (60 * 60) );
    //     $menit_lembur2 = floor($menit_lembur / 60);
    //     $timestamp_mulai = strtotime($tanggal_mulai);
    //     $timestamp_akhir = strtotime($tanggal_akhir);
    //     $selisih_timestamp = $timestamp_akhir - $timestamp_mulai;
    //     $jumlah_hari = (floor($selisih_timestamp / (60 * 60 * 24)))+1;
    //     $persentase_kehadiran = (($total_hadir + $libur) / $jumlah_hari) * 100;
    //     return [
    //         $model->name,
    //         $cuti . ' x',
    //         $izin_masuk . ' x',
    //         $izin_telat . ' x',
    //         $izin_pulang_cepat . ' x',
    //         $total_hadir . ' x',
    //         $total_alfa . ' x',
    //         $libur . ' x',
    //         $jam . " Jam " . $menit2 . " Menit\n" . $jumlah_telat . " x",
    //         $jam_cepat . " Jam " . $menit_cepat2 . " Menit\n" . $jumlah_pulang_cepat . " x",
    //         $jam_lembur." Jam ".$menit_lembur2." Menit",
    //         $persentase_kehadiran . ' %',

    //     ];


    // }

    public function map($model): array
{
    $tanggal_mulai = request()->input('mulai');
    $tanggal_akhir = request()->input('akhir');

    // Data lembur
    $lembur_entries = $model->Lembur->where('status', 'Approved')
                                    ->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir]);

    // Kalkulasi kategori lembur
    $kategori_lembur = $this->deteksiKategoriLembur($lembur_entries);

    // Kalkulasi lainnya (tetap seperti yang sudah ada)
    $cuti = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Cuti')->count();
    $izin_masuk = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Izin Masuk')->count();
    $izin_telat = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Izin Telat')->count();
    $izin_pulang_cepat = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Izin Pulang Cepat')->count();
    $masuk = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Masuk')->count();
    $total_hadir = $masuk + $izin_telat + $izin_pulang_cepat;
    $libur = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Libur')->count();
    $mulai = new \DateTime($tanggal_mulai);
    $akhir = new \DateTime($tanggal_akhir);
    $interval = $mulai->diff($akhir);
    $total_alfa = $interval->days + 1 - $masuk - $cuti - $izin_masuk - $libur;
    $total_telat = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->sum('telat');
    $jam   = floor($total_telat / (60 * 60));
    $menit = $total_telat - ( $jam * (60 * 60) );
    $menit2 = floor($menit / 60);
    $jumlah_telat = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('telat', '>', 0)->count();
    $total_pulang_cepat = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->sum('pulang_cepat');
    $jam_cepat   = floor($total_pulang_cepat / (60 * 60));
    $menit_cepat = $total_pulang_cepat - ( $jam_cepat * (60 * 60) );
    $menit_cepat2 = floor($menit_cepat / 60);
    $jumlah_pulang_cepat = $model->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('pulang_cepat', '>', 0)->count();
    $total_lembur = $lembur_entries->sum('total_lembur');
    $jam_lembur   = floor($total_lembur / (60 * 60));
    $menit_lembur = $total_lembur - ( $jam_lembur * (60 * 60) );
    $menit_lembur2 = floor($menit_lembur / 60);
    $timestamp_mulai = strtotime($tanggal_mulai);
    $timestamp_akhir = strtotime($tanggal_akhir);
    $selisih_timestamp = $timestamp_akhir - $timestamp_mulai;
    $jumlah_hari = (floor($selisih_timestamp / (60 * 60 * 24)))+1;
    $persentase_kehadiran = (($total_hadir + $libur) / $jumlah_hari) * 100;

// // Periksa apakah ada lembur yang disetujui dalam rentang tanggal
// $upah_lembur = 0;
// $lemburItems = $model->Lembur->where('status', 'Approved')->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir]);

// if ($lemburItems->count() > 0) {
//     foreach ($lemburItems as $lembur) {
//         $waktu_mulai = new \DateTime($lembur->jam_mulai);
//         $waktu_akhir = new \DateTime($lembur->jam_selesai);

//         if ($waktu_mulai >= new \DateTime('18:30') && $waktu_akhir <= new \DateTime('21:30')) {
//             // Lembur 1
//             $upah_lembur += 40000;
//         } elseif ($waktu_mulai >= new \DateTime('21:30') && $waktu_akhir <= new \DateTime('06:00')) {
//             // Lembur 2
//             $upah_lembur += 50000;
//         } elseif ($waktu_mulai >= new \DateTime('18:30') && $waktu_akhir <= new \DateTime('06:00')) {
//             // Lembur 1 & 2
//             $upah_lembur += 100000;
//         } elseif ($waktu_mulai >= new \DateTime('08:00') && $waktu_akhir <= new \DateTime('12:00') && $lembur->is_weekend) {
//             // Lembur 1 Weekend
//             $upah_lembur += 100000;
//         } elseif ($waktu_mulai >= new \DateTime('13:00') && $waktu_akhir <= new \DateTime('17:00') && $lembur->is_weekend) {
//             // Lembur 2 Weekend
//             $upah_lembur += 60000;
//         } elseif ($waktu_mulai >= new \DateTime('08:00') && $waktu_akhir <= new \DateTime('23:59') && $lembur->is_weekend) {
//             // Lembur 1 & 2 Weekend
//             $upah_lembur += 160000;
//         }
//     }
// }

// Perhitungan kategori lembur
$kategori_lembur = 'Tidak ada lembur';
    $upah_lembur = 0;

    $lemburItems = $model->Lembur->where('status', 'Approved')->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir]);

    if ($lemburItems->count() > 0) {
        foreach ($lemburItems as $lembur) {
            $waktu_mulai = new \DateTime($lembur->jam_mulai);
            $waktu_akhir = new \DateTime($lembur->jam_selesai);
            $interval = $waktu_mulai->diff($waktu_akhir);
            $jam_lembur = $interval->h + ($interval->i / 60); // Total jam lembur dalam jam desimal

            if ($jam_lembur < 1) {
                // Jika lembur kurang dari 1 jam, tetap dihitung dengan upah minimal
                $kategori_lembur = 'Lembur Singkat';
                $upah_lembur += 20000; // Contoh upah minimal untuk lembur singkat
            } elseif ($waktu_mulai >= new \DateTime('17:30') && $waktu_akhir <= new \DateTime('21:30')) {
                $kategori_lembur = 'Lembur 1';
                $upah_lembur += 40000;
            } elseif ($waktu_mulai >= new \DateTime('21:30') && $waktu_akhir <= new \DateTime('06:00')) {
                $kategori_lembur = 'Lembur 2';
                $upah_lembur += 50000;
            } elseif ($waktu_mulai >= new \DateTime('18:30') && $waktu_akhir <= new \DateTime('06:00')) {
                $kategori_lembur = 'Lembur 1 & 2';
                $upah_lembur += 90000;
            } elseif ($waktu_mulai >= new \DateTime('08:00') && $waktu_akhir <= new \DateTime('12:00') && $lembur->is_weekend) {
                $kategori_lembur = 'Lembur 1 Weekend';
                $upah_lembur += 100000;
            } elseif ($waktu_mulai >= new \DateTime('13:00') && $waktu_akhir <= new \DateTime('17:00') && $lembur->is_weekend) {
                $kategori_lembur = 'Lembur 2 Weekend';
                $upah_lembur += 60000;
            } elseif ($waktu_mulai >= new \DateTime('08:00') && $waktu_akhir <= new \DateTime('23:59') && $lembur->is_weekend) {
                $kategori_lembur = 'Lembur 1 & 2 Weekend';
                $upah_lembur += 160000;
            }
        }
    }


// Masukkan hasil ke dalam array untuk ditampilkan di Excel
return [
    $model->name,
    $cuti . ' x',
    $izin_masuk . ' x',
    $izin_telat . ' x',
    $izin_pulang_cepat . ' x',
    $total_hadir . ' x',
    $total_alfa . ' x',
    $libur . ' x',
    $jam . " Jam " . $menit2 . " Menit\n" . $jumlah_telat . " x",
    $jam_cepat . " Jam " . $menit_cepat2 . " Menit\n" . $jumlah_pulang_cepat . " x",
    $jam_lembur." Jam ".$menit_lembur2." Menit",
    $persentase_kehadiran . ' %',
    $kategori_lembur,  // Tambahkan kategori lembur
    'Rp ' . number_format($upah_lembur, 0, ',', '.'), // Tambahkan upah lembur
    $model->Lembur->first()->keterangan_lembur ?? '', // Tambahkan keterangan lembur
];
}


//     return [
//         $model->name,
//         $cuti . ' x',
//         $izin_masuk . ' x',
//         $izin_telat . ' x',
//         $izin_pulang_cepat . ' x',
//         $total_hadir . ' x',
//         $total_alfa . ' x',
//         $libur . ' x',
//         $jam . " Jam " . $menit2 . " Menit\n" . $jumlah_telat . " x",
//         $jam_cepat . " Jam " . $menit_cepat2 . " Menit\n" . $jumlah_pulang_cepat . " x",
//         $kategori_lembur . "\n" . $jam_lembur." Jam ".$menit_lembur2." Menit",
//         $persentase_kehadiran . ' %',
//     ];
// }

private function deteksiKategoriLembur($lembur_entries)
{
    $kategori = [];
    foreach ($lembur_entries as $lembur) {
        $mulai = new \DateTime($lembur->waktu_mulai);
        $akhir = new \DateTime($lembur->waktu_selesai);
        $is_weekend = in_array($mulai->format('N'), [6, 7]);

        // Lembur 1
        if ($mulai <= new \DateTime('18:30') && $akhir <= new \DateTime('21:30')) {
            $kategori[] = $is_weekend ? 'Lembur 1 Weekend' : 'Lembur 1';
        }
        // Lembur 2
        elseif ($mulai >= new \DateTime('21:30') && $akhir <= new \DateTime('06:00')) {
            $kategori[] = $is_weekend ? 'Lembur 2 Weekend' : 'Lembur 2';
        }
        // Lembur 1 & 2
        elseif ($mulai <= new \DateTime('18:30') && $akhir >= new \DateTime('06:00')) {
            $kategori[] = $is_weekend ? 'Lembur 1&2 Weekend' : 'Lembur 1&2';
        }
        // Lembur 1 Weekend
        elseif ($is_weekend && $mulai >= new \DateTime('08:00') && $akhir <= new \DateTime('12:00')) {
            $kategori[] = 'Lembur 1 Weekend';
        }
        // Lembur 2 Weekend
        elseif ($is_weekend && $mulai >= new \DateTime('13:00') && $akhir <= new \DateTime('17:00')) {
            $kategori[] = 'Lembur 2 Weekend';
        }
        // Lembur 1&2 Weekend
        elseif ($is_weekend && $mulai >= new \DateTime('08:00') && $akhir >= new \DateTime('23:59')) {
            $kategori[] = 'Lembur 1&2 Weekend';
        }
    }

    return implode(', ', $kategori);
}


    public function columnFormats(): array
    {
        return [

        ];
    }

    public function query()
    {
        return User::orderBy('name', 'ASC');
    }
}
