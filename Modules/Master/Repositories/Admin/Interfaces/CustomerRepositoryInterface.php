<?php

namespace Modules\Master\Repositories\Admin\Interfaces;

use Modules\Master\Entities\Mcustomer;

interface CustomerRepositoryInterface
{
    public function findAll($options = []);
    public function create($params = []);
    public function findById($id);
    public function update($id, $params = []);
//    public function findAllInTrash($options = []);
//    public function findByPersetujuanId($id);


//    public function delete($id, $permanentDelete = false);
//    public function restore($id);
//    public function getStatuses();
////    public function getMetaFields();
//    public function count_review();
//    public function count_approval();
//    public function count_closed();
//    public function count_draft();
//    public function count_initiator();
//    public function count_rejected();
//
//    //workspace
//    public function findAllWorkspace($options = []);
//    public function action_update($params = []);
}
