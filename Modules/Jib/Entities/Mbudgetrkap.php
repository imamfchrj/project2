<?php

namespace Modules\Jib\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mbudgetrkap extends Model
{
    use HasFactory;

    protected $fillable = [
        'program'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'm_budget_rkap';
    protected $primaryKey = 'id';

    protected static function newFactory()
    {
        return \Modules\Jib\Database\factories\MbudgetrkapFactory::new();
    }
}
