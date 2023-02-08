<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 27/10/2022
 * Time: 10:14
 */

namespace Modules\Master\Repositories\Admin\Interfaces;


interface BudgetRepositoryInterface
{
    public function findAll($options = []);
    public function findById($id);

    public function create($params = []);
    public function update($id, $params = []);
    public function delete($id);
    public function BudgetImport($params = []);

}