<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 07/02/2023
 * Time: 20:29
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $fillable = [
        'deskripsi',
        'tipe',
        'nik',
        'nama',
        'is_read',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'jib_notification';
    protected $primaryKey = 'id';

    protected static function newFactory()
    {
//        return \Modules\Jib\Database\factories\ManggaranFactory::new();
    }
}