<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mbudgetrkap extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'periode',
        'ba',
        'ba_name',
        'cc',
        'cc_name',
        'program',
        'customer',
        'portofolio',
        'lokasi_project',
        'kelompok_aset',
        'nilai_program',
        'kategori_capex_id',
        'kategori_capex_name',
        'klasifikasi_capex_id',
        'klasifikasi_capex_name',
        'prioritas',
        'nama_drp',
        'reff',
        'no_drp',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'm_budget_rkap';
    protected $primaryKey = 'id';
}
