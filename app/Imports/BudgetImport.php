<?php

namespace App\Imports;

use Modules\Master\Entities\Mbudgetrkap;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class BudgetImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (isset($row['id'])) {
                // $budget = Mbudgetrkap::whereTahun($row['tahun'])
                //     ->where('periode', $row['periode'])
                //     ->where('prioritas', $row['prioritas'])
                //     ->where('no_drp', $row['no_drp'])
                //     ->first();
                $budget = Mbudgetrkap::findOrFail($row['id']);

                if ($budget) {
                    // $budget->tahun = $row['tahun'];
                    // $budget->periode = $row['periode'];
                    $budget->ba = $row['ba'];
                    $budget->ba_name = $row['ba_name'];
                    $budget->cc = $row['cc'];
                    $budget->cc_name = $row['cc_name'];
                    $budget->program = $row['program'];
                    $budget->customer = $row['customer'];
                    $budget->portofolio = $row['portofolio'];
                    $budget->lokasi_project = $row['lokasi_project'];
                    $budget->kelompok_aset = $row['kelompok_aset'];
                    $budget->nilai_program = $row['nilai_program'];
                    $budget->kategori_capex_id = $row['kategori_capex_id'];
                    $budget->kategori_capex_name = $row['kategori_capex_name'];
                    $budget->klasifikasi_capex_id = $row['klasifikasi_capex_id'];
                    $budget->klasifikasi_capex_name = $row['klasifikasi_capex_name'];
                    $budget->prioritas = $row['prioritas'];
                    $budget->nama_drp = $row['nama_drp'];
                    $budget->reff = $row['reff'];
                    // $budget->no_drp = $row['no_drp'];
                    $budget->save();
                }
            } else {
                $budget = new Mbudgetrkap();
                $budget->tahun = $row['tahun'];
                $budget->periode = $row['periode'];
                $budget->ba = $row['ba'];
                $budget->ba_name = $row['ba_name'];
                $budget->cc = $row['cc'];
                $budget->cc_name = $row['cc_name'];
                $budget->program = $row['program'];
                $budget->customer = $row['customer'];
                $budget->portofolio = $row['portofolio'];
                $budget->lokasi_project = $row['lokasi_project'];
                $budget->kelompok_aset = $row['kelompok_aset'];
                $budget->nilai_program = $row['nilai_program'];
                $budget->kategori_capex_id = $row['kategori_capex_id'];
                $budget->kategori_capex_name = $row['kategori_capex_name'];
                $budget->klasifikasi_capex_id = $row['klasifikasi_capex_id'];
                $budget->klasifikasi_capex_name = $row['klasifikasi_capex_name'];
                $budget->prioritas = $row['prioritas'];
                $budget->nama_drp = $row['nama_drp'];
                $budget->reff = $row['reff'];
                $budget->no_drp = $row['no_drp'];

                $budget->save();
            }
        }
    }
}
