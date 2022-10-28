<?php

namespace Modules\Jib\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mrisiko extends Model
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

    protected $table = 'm_risiko';
    protected $primaryKey = 'id';

    protected static function newFactory()
    {
        return \Modules\Jib\Database\factories\MrisikoFactory::new();
    }
}
