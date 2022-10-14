<?php

namespace Modules\Jib\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mpemeriksa extends Model
{
    use HasFactory;

    protected $fillable = [
        'rules',
        'nik',
        'nama',
        'urutan',
        'initiator_id',
        'objid_posisi',
        'nama_posisil',
        'is_active',
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
        return \Modules\Jib\Database\factories\MpemeriksaFactory::new();
    }
}
