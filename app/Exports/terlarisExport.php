<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Auth;
class terlarisExport implements FromCollection, WithHeadings, WithEvents
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
                    $transaksi->total_quantity,
                    $transaksi->barang->satuan->nama_satuan,
                    $transaksi->barang->kategori->nama_kategori,
                    "Rp. ".number_format($transaksi->barang->harga_jual,0,'','.'),
                    "Rp. ".number_format($transaksi->barang->harga_beli,0,'','.'),
                    number_format($transaksi->barang->stok,0,'','.'),
               ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Jumlah Pembelian',
            'Satuan',
            'Kategori',
            'Harga Jual',
            'Harga Beli',
            'Stok'
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