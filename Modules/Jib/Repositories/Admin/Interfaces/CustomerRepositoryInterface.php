<?php

namespace Modules\Jib\Repositories\Admin\Interfaces;

use Modules\Jib\Entities\MCustomer;

interface CustomerRepositoryInterface
{
    public function findAll($options = []);
//    public function findAllInTrash($options = []);
    public function findById($id);
    public function findByUserId();
//    public function create($params = []);
//    public function update(MCustomer $customer, $params = []);
//    public function delete($id, $permanentDelete = false);
//    public function restore($id);
//    public function getStatuses();
//    public function getMetaFields();
}
