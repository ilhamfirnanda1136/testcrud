<?php

namespace App\Exports;

use App\Models\dinasdalam;
use App\Models\Transaksi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Auth;
class dinasdalamExport implements FromCollection, WithHeadings, WithEvents
{
    protected $dinasdalam;

    public function __construct(Collection $dinasdalam)
    {
        $this->dinasdalam = $dinasdalam;
    }

    public function collection()
    {
        return $this->dinasdalam->map(function($transaksi) {
               return [
                    $transaksi->tanggal_pembelian,
                    $transaksi->tanggal_jatuh_tempo,
                    $transaksi->supplier->nama_supplier,
                    "Rp. ".number_format($transaksi->sub_total,0,'','.'),
                    "Rp. ".number_format($transaksi->down_payment,0,'','.'),
                    "Rp. ".number_format($transaksi->sisa_hutang,0,'','.'),
                    $transaksi->keterangan,
               ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal Pembelian',
            'Tanggal Jatuh Tempo',
            'Supplier',
            'Sub Total',
            'Down Payment',
            'Sisa Hutang',
            'Keterangan'
            // Tambahkan nama field lainnya jika diperlukan
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // $rows = count($this->dinasdalam) + 1;
                // $cok = $this->dinasdalam;
                // $header = 2;
                // foreach($this->dinasdalam as $transaksi) {
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