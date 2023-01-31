<?php

namespace App\Exports;

use Modules\Master\Entities\Mbudgetrkap;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BudgetExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Mbudgetrkap::all();
    }

    /**
     * @return Header Table
     */
    public function headings(): array
    {
        return [
            'ID',
            'TAHUN',
            'PERIODE',
            'BA',
            'BA_NAME',
            'CC',
            'CC_NAME',
            'PROGRAM',
            'CUSTOMER',
            'PORTOFOLIO',
            'LOKASI_PROJECT',
            'KELOMPOK_ASET',
            'NILAI_PROGRAM',
            'KATEGORI_CAPEX_ID',
            'KATEGORI_CAPEX_NAME',
            'KLASIFIKASI_CAPEX_ID',
            'KLASIFIKASI_CAPEX_NAME',
            'PRIORITAS',
            'NAMA_DRP',
            'REFF',
            'NO_DRP',
            'NILAI_REALISASI',
        ];
    }
}
