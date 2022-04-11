<?php

namespace App\Exports;

use App\Models\PengecekanKendaraan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PengecekanDateExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PengecekanKendaraan::all();
    }
}
