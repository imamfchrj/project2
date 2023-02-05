<?php

namespace App\Imports;

use Modules\Jib\Entities\Pengajuan;
use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Jib\Repositories\Admin\PengajuanRepository;

class JibImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $budget = Pengajuan::whereId($row['id'])
                ->whereTahun($row['tahun'])
                ->where('bulan_id',$row['bulan_id'])
                ->where('jib_number', $row['jib_number'])
                ->first();

            if($row['total_realisasi'] != null){
                $budget->total_realisasi = $row['total_realisasi'];
                $budget->save();
            }
        }
    }
}