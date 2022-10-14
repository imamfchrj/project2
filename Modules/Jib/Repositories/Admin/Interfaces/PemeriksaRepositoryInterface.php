<?php

namespace Modules\Jib\Repositories\Admin\Interfaces;

use Modules\Jib\Entities\Mpemeriksa;

interface PemeriksaRepositoryInterface
{
    public function findAll($options = []);
//    public function findAllInTrash($options = []);
//    public function findById($id);
//    public function findByUserId();
    public function findByRules($rule_id);
//    public function create($params = []);
//    public function update(Msegment $segment, $params = []);
//    public function delete($id, $permanentDelete = false);
//    public function restore($id);
//    public function getStatuses();
//    public function getMetaFields();
}
