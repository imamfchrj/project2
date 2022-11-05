<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 05/11/2022
 * Time: 09:39
 */

namespace Modules\Master\Repositories\Admin\Interfaces;


interface PemeriksaRepositoryInterface
{
    public function findAll($options = []);
    public function create($params = []);
    public function findById($id);
    public function update($id, $params = []);
    public function delete($id);
}