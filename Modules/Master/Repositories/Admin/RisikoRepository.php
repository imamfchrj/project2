<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 02/11/2022
 * Time: 20:03
 */

namespace Modules\Master\Repositories\Admin;

use DB;
use Modules\Master\Entities\Mrisiko;
use Modules\Master\Repositories\Admin\Interfaces\RisikoRepositoryInterface;

class RisikoRepository implements RisikoRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $risiko = new Mrisiko();

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $risiko = $risiko->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $risiko = $risiko->where(function ($query) use ($options) {
                $query->where('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if ($perPage) {
            return $risiko->paginate($perPage);
        }

        return $risiko->get();
    }

    public function create($params = [])
    {
        // Insert Risiko
        $risiko = new Mrisiko();
        $risiko->name = $params['name'];
        return $risiko->save();
    }

    public function findById($id)
    {
        return Mrisiko::findOrFail($id);
    }

    public function update($id, $params = [])
    {
        $risiko = Mrisiko::findOrFail($id);
        $risiko->name = $params['name'];
        return $risiko->save();
    }

    public function delete($id)
    {
        $risiko = Mrisiko::findOrFail($id);
        return $risiko->forceDelete();
    }
}