<?php

namespace Modules\Jib\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Minitiator extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'objid_posisi',
        'nama_posisi',
        'kode_unit',
        'nama_unit',
        'kode_sub_unit',
        'nama_sub_unit',
        'kantor',
        'cc',
        'cc_desc',
        'is_active',
        'created_by',
        'updated_by',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'm_initiator';
    protected $primaryKey = 'id';
    
    protected static function newFactory()
    {
        return \Modules\Jib\Database\factories\MinitiatorFactory::new();
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d, M Y H:i:s');
    }
}
