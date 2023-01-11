<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mpemeriksa extends Model
{
    use HasFactory;

    protected $fillable = [
        'rules',
        'keterangan',
        'petugas',
        'nik',
        'nama',
        'urutan',
        'initiator_id',
        'objid_posisi',
        'nama_posisi',
        'is_active'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'm_pemeriksa';
    protected $primaryKey = 'id';

    protected static function newFactory()
    {
        return \Modules\Master\Database\factories\MpemeriksaFactory::new();
    }
}
