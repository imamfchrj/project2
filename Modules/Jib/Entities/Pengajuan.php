<?php

namespace Modules\Jib\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Pengajuan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'initator_id',
        'user_id',
        'nama_posisi',
        'nama_sub_unit',
        'kegiatan',
        'no_drp',
        'rra',
        'kategori_id',
        'segment_id',
        'customer_id',
        'periode_up',
        'periode_end',
        'nilai_capex',
        'est_revenue',
        'irr',
        'npv',
        'pbp',
        'bcr',
        'detail',
        'file_jib',
        'file_jib_asli',
        'status_id',
        'created_by',
        'updated_by',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'jib_pengajuan';
    protected $primaryKey = 'id';

    protected static function newFactory()
    {
        return \Modules\Jib\Database\factories\PengajuanFactory::new();
    }

    // const filter status
    public const REVIEWER_1 = 1;
    public const REVIEWER_2 = 2;
    public const APPROVAL_1 = 3;
    public const APPROVAL_2 = 4;
    public const APPROVAL_3 = 5;
    public const SELESAI = 6;

    public const POST = 'post';
//    public const PAGE = 'page';

    public const STATUSES = [
        self::REVIEWER_1 => 'Reviewer 1',
        self::REVIEWER_2 => 'Reviewer 2',
        self::APPROVAL_1 => 'Approval 1',
        self::APPROVAL_2 => 'Approval 2',
        self::APPROVAL_3 => 'Approval 3',
        self::SELESAI => 'Selesai',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function minitiators()
    {
        return $this->belongsTo('Modules\Jib\Entities\Minitiator','initiator_id','id');
    }

    public function msegments()
    {
        return $this->belongsTo('Modules\Jib\Entities\Msegment', 'segment_id', 'id');
    }

    public function mcustomers()
    {
        return $this->belongsTo('Modules\Jib\Entities\Mcustomer', 'customer_id', 'id');
    }

    public function mcategories()
    {
        return $this->belongsTo('Modules\Jib\Entities\Mkategori', 'kategori_id', 'id');
    }

    public function mjenises()
    {
        return $this->belongsTo('Modules\Jib\Entities\Mjenis', 'jenis_id', 'id');
    }

    public function mstatuses()
    {
        return $this->belongsTo('Modules\Jib\Entities\Mstatus', 'status_id', 'id');
    }

    public function mpemeriksa()
    {
        return $this->belongsTo('Modules\Jib\Entities\Mpemeriksa', 'pemeriksa_id', 'id');
    }

    public function reviewer()
    {
        return $this->hasMany('Modules\Jib\Entities\Reviewer', 'id', 'pengajuan_id');
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d, M Y H:i:s');
    }
}
