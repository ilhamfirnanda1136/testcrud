<?php

namespace App\Exports;

use App\Models\Pendistribusian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PendistribusianExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Pendistribusian::with('sumberDana')  // Include the related sumberDana
            ->get()
            ->map(function($row, $index) {
                return [
                    'No' => $index + 1,
                    'Tanggal' => $row->tanggal,
                    'Uraian' => $row->uraian,
                    'Sumber Dana' => $row->sumberDana ? $row->sumberDana->sumber_dana : '-', 
                    'Nama UPZ' => $row->nama_upz,
                    'Jenis Program' => $row->jenis_program,
                    'Grand Program' => $row->grand_program,
                    'Nominal' => $row->nominal,
                    'Asnaf' => $row->asnaf,
                ];
            });
    }

    public function headings(): array
    {
        // Define column headings as per the image
        return [
            'No', 'Tanggal', 'Uraian','Sumber Dana', 'Nama UPZ', 'Jenis Program atau Kegiatan', 'Grand Program', 'Nominal', 'Asnaf'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'], 
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4CAF50'],
                ],
            ],
            'A' => ['font' => ['bold' => true]], 
        ];
    }
}
