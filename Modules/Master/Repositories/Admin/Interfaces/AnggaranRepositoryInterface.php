<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 04/11/2022
 * Time: 23:40
 */

namespace Modules\Master\Repositories\Admin\Interfaces;


interface AnggaranRepositoryInterface
{
    public function findAll($options = []);
    public function create($params = []);
    public function findById($id);
    public function update($id, $params = []);
    public function delete($id);
}