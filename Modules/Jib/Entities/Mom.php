<?php

namespace Modules\Jib\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mom extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_id',
        'dasar_mom',
        'ruang_lingkup',
        'tanggal_mom',
        'spesifikasi',
        'venue',
        'kegiatan',
        'meeting_called',
        'lokasi',
        'meeting_type',
        'top',
        'facilitator',
        'aki',
        'attende',
        'catatan',
        'kelengkapan',
        'anggaran',
        'created_by',
        'updated_by'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'jib_mom';
    protected $primaryKey = 'id';


    protected static function newFactory()
    {
        return \Modules\Jib\Database\factories\MomFactory::new();
    }
}
