<?php

namespace Modules\Jib\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persetujuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_id',
        'no_drp',
        'akun',
        'kegiatan',
        'customer_id',
        'lokasi',
        'waktu_kerja',
        'konstribusi_fee',
        'skema',
        'nilai_capex',
        'tot_invest',
        'sow',
        'delivery_time',
        'est_revenue',
        'irr',
        'npv',
        'playback_period',
        'wacc',
        'analisa_risk',
        'score_risk',
        'risk_mitigasi',
        'score_mitigasi',
        'top',
        'beban',
        'profit_margin',
        'net_cf',
        'suku_bunga',
        'bcr',
        'kesimpulan',
        'catatan',
        'created_by',
        'updated_by'
        ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'jib_persetujuan';
    protected $primaryKey = 'id';


    protected static function newFactory()
    {
        return \Modules\Jib\Database\factories\PersetujuanFactory::new();
    }

    public function mcustomers()
    {
        return $this->belongsTo('Modules\Jib\Entities\Mcustomer', 'customer_id', 'id');
    }
}
