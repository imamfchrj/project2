<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 01/02/2023
 * Time: 13:11
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginHis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'user_ip'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'user_login_his';
    protected $primaryKey = 'id';

    protected static function newFactory()
    {
//        return \Modules\Jib\Database\factories\ManggaranFactory::new();
    }
}