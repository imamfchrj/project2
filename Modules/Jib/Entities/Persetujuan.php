<?php

namespace Modules\Jib\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;

class Persetujuan extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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
        'rencana_mitigasi',
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

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('file_approval');
    }

    protected static function newFactory()
    {
        return \Modules\Jib\Database\factories\PersetujuanFactory::new();
    }

    public function mcustomers()
    {
        return $this->belongsTo('Modules\Jib\Entities\Mcustomer', 'customer_id', 'id');
    }
}
