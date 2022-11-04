<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 02/11/2022
 * Time: 20:03
 */

namespace Modules\Master\Repositories\Admin;

use DB;
use Modules\Master\Entities\Mstatus;
use Modules\Master\Repositories\Admin\Interfaces\StatusRepositoryInterface;

class StatusRepository implements StatusRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $status = new Mstatus();

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $status = $status->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $status = $status->where(function ($query) use ($options) {
                $query->where('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if ($perPage) {
            return $status->paginate($perPage);
        }

        return $status->get();
    }

    public function create($params = [])
    {
        // Insert Status
        $status = new Mstatus();
        $status->name = $params['name'];
        return $status->save();
    }

    public function findById($id)
    {
        return Mstatus::findOrFail($id);
    }

    public function update($id, $params = [])
    {
        $status = Mstatus::findOrFail($id);
        $status->name = $params['name'];
        return $status->save();
    }

    public function delete($id)
    {
        $status = Mstatus::findOrFail($id);
        return $status->forceDelete();
    }
}