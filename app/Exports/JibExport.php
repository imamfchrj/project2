<?php

namespace App\Exports;

use Modules\Jib\Entities\Pengajuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JibExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pengajuan::all();
    }

    /**
     * @return Header Table
     */
    public function headings(): array
    {
        return [
            'ID',
            'INITIATOR_ID',
            'USER_ID',
            'NAMA_POSISI',
            'KODE_SUB_UNIT',
            'NAMA_SUB_UNIT',
            'CC',
            'SINGKATAN_UNIT',
            'TAHUN',
            'BULAN_ID',
            'BULAN',
            'NUMBER',
            'JIB_NUMBER',
            'KEGIATAN',
            'NO_DRP',
            'RRA',
            'JENIS_ID',
            'KATEGORI_ID',
            'SEGMENT_ID',
            'CUSTOMER_ID',
            'PERIODE_UP',
            'PERIODE_END',
            'NILAI_CAPEX',
            'TOTAL_REALISASI',
            'EST_REVENUE',
            'IRR',
            'NPV',
            'PBP',
            'BCR',
            'COST',
            'PROFIT_MARGIN',
            'NET_CF',
            'SUKU_BUNGA',
            'DETAIL',
            'FILE_JIB',
            'FILE_JIB_ASLI',
            'PEMERIKSA_ID',
            'STATUS_ID',
            'CREATED_BY',
            'UPDATED_BY',
            'CREATED_AT',
            'UPDATED_AT',
            'DELETED_AT'
        ];
    }
}