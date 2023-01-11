<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Msegment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'm_segment';
    protected $primaryKey = 'id';

    protected static function newFactory()
    {
        return \Modules\Master\Database\factories\MsegmentFactory::new();
    }
}
