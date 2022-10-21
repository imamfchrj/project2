<?php

namespace Modules\Jib\Repositories\Admin\Interfaces;

use Modules\Jib\Entities\Mjenis;

interface JenisRepositoryInterface
{
    public function findAll($options = []);
//    public function findAllInTrash($options = []);
    public function findById($id);
    public function findByUserId();
//    public function create($params = []);
//    public function update(Mjenis $jenis, $params = []);
//    public function delete($id, $permanentDelete = false);
//    public function restore($id);
//    public function getStatuses();
//    public function getMetaFields();
}
