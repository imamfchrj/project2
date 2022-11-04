<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mjenis extends Model
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

    protected $table = 'm_jenis';
    protected $primaryKey = 'id';

    protected static function newFactory()
    {
        return \Modules\Master\Database\factories\MjenisFactory::new();
    }
}
