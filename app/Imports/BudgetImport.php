<?php

namespace App\Imports;

use Modules\Master\Entities\Mbudgetrkap;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Master\Repositories\Admin\BudgetRepository;

class BudgetImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $budget = Mbudgetrkap::find($row[0]);
            if($row[21]!= null){
                $budget->nilai_realisasi = $row[21];
                $budget->save();
            }
        }
    }
}