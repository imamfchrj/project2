<?php

namespace Modules\Master\Repositories\Admin\Interfaces;


interface CustomerRepositoryInterface
{
    public function findAll($options = []);
    public function create($params = []);
    public function findById($id);
    public function update($id, $params = []);
    public function delete($id);
}
