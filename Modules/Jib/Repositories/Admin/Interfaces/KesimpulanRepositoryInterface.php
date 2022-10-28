<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 27/10/2022
 * Time: 10:14
 */

namespace Modules\Jib\Repositories\Admin\Interfaces;


interface KesimpulanRepositoryInterface
{
    public function findAll($options = []);
    public function findById($id);
}