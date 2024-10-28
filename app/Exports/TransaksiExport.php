<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Auth;
class TransaksiExport implements FromCollection, WithHeadings, WithEvents
{
    protected $transaksis;

    public function __construct(Collection $transaksis)
    {
        $this->transaksis = $transaksis;
    }

    public function collection()
    {
        return $this->transaksis->map(function($transaksi) {
            $a = $transaksi->transaksi_detail->map(function($detail) use($transaksi) {
               return [
                    $transaksi->invoice,
                    $transaksi->tanggal_transaksi,
                    $transaksi->type_transaksi == 1 ? 'Cash' : 'Piutang',
                    $transaksi->tanggal_jatuh_tempo,
                    Auth::user()->name,
                    $transaksi->customer_id == 0 ? 'Umum' : $transaksi->customer->nama_customer,
                    $detail->barang->nama_barang,
                    $detail->barang->satuan->nama_satuan
               ];
            });
            return $a;
        });
    }

    public function headings(): array
    {
        return [
            'Nomor Invoice',
            'Tanggal Transaksi',
            'Jenis Transaksi',
            'Tanggal Jatuh Tempo',
            'Nama Kasir',
            'Nama Customer',
            'Nama Barang',
            'Satuan Barang'
            // Tambahkan nama field lainnya jika diperlukan
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $rows = count($this->transaksis) + 1;
                $cok = $this->transaksis;
                $header = 2;
                foreach($this->transaksis as $transaksi) {
                    $rows = count($transaksi->transaksi_detail) + 1;
                    $header++;
                    // $event->sheet->getDelegate()->mergeCells("A$header:A$rows");
                }
                // $event->sheet->getDelegate()->mergeCells("B2:B$rows");
                // Merge kolom lain jika diperlukan
            },
        ];
    }
}