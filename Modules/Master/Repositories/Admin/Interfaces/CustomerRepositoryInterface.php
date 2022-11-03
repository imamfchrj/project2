<?php

namespace Modules\Master\Repositories\Admin\Interfaces;

use Modules\Master\Entities\Customer;

interface CustomerRepositoryInterface
{
    public function findAll($options = []);
//    public function findAllInTrash($options = []);
//    public function findById($id);
//    public function findByPersetujuanId($id);
//    public function create($params = []);
////    public function update(Pengajuan $pengajuan, $params = []);
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
