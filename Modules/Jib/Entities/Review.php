<?php

namespace Modules\Jib\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_id',
        'reviewer_id',
        'status',
        'notes',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'jib_review';
    protected $primaryKey = 'id';
    
    protected static function newFactory()
    {
        return \Modules\Jib\Database\factories\ReviewFactory::new();
    }

}
