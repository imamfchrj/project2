<?php

namespace App\Exports;

use Modules\Jib\Entities\Pengajuan;
use Maatwebsite\Excel\Concerns\FromCollection;

class JibExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pengajuan::all();
    }
}
