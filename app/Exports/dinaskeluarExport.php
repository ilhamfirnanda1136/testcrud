<?php

namespace App\Exports;

use App\Models\dinaskeluar;
use Maatwebsite\Excel\Concerns\FromCollection;

class dinaskeluarExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return dinaskeluar::all();
    }
}
