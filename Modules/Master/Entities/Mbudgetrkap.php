<?php

namespace Modules\Master\Entities;

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
}
