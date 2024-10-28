<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Auth;
class keluarExport implements FromCollection, WithHeadings, WithEvents
{
    protected $transaksis;

    public function __construct(Collection $transaksis)
    {
        $this->transaksis = $transaksis;
    }

    public function collection()
    {
        return $this->transaksis->map(function($transaksi) {
               return [
                    $transaksi->barang->nama_barang,
                    $transaksi->barang->kode_barcode,
                    number_format($transaksi->qty,0,'','.'),
                    \Carbon\Carbon::parse($transaksi->created_at)->format('d M Y'),
                    $transaksi->customer == '' ? 'Umum' : $transaksi->customer,
               ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Kode Barcode',
            'Stok Keluar',
            'Tanggal Stok Keluar',
            'Nama Customer'
            // Tambahkan nama field lainnya jika diperlukan
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // $rows = count($this->transaksis) + 1;
                // $cok = $this->transaksis;
                // $header = 2;
                // foreach($this->transaksis as $transaksi) {
                //     $rows = count($transaksi->transaksi_detail) + 1;
                //     $header++;
                //     // $event->sheet->getDelegate()->mergeCells("A$header:A$rows");
                // }
                // $event->sheet->getDelegate()->mergeCells("B2:B$rows");
                // Merge kolom lain jika diperlukan
            },
        ];
    }
}