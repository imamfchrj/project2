<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 02/11/2022
 * Time: 20:03
 */

namespace Modules\Master\Repositories\Admin;

use DB;
use Modules\Master\Entities\Mpemeriksa;
use Modules\Master\Repositories\Admin\Interfaces\PemeriksaRepositoryInterface;

class PemeriksaRepository implements PemeriksaRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $pemeriksa = new Mpemeriksa();

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $pemeriksa = $pemeriksa->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $pemeriksa = $pemeriksa->where(function ($query) use ($options) {
                $query->where('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if ($perPage) {
            return $pemeriksa->paginate($perPage);
        }

        return $pemeriksa->get();
    }

    public function create($params = [])
    {
        // Insert Pemeriksa
        $pemeriksa = new Mpemeriksa();
        $pemeriksa->name = $params['name'];
        return $pemeriksa->save();
    }

    public function findById($id)
    {
        return Mpemeriksa::findOrFail($id);
    }

    public function update($id, $params = [])
    {
        $pemeriksa = Mpemeriksa::findOrFail($id);
        $pemeriksa->name = $params['name'];
        return $pemeriksa->save();
    }

    public function delete($id)
    {
        $pemeriksa = Mpemeriksa::findOrFail($id);
        return $pemeriksa->forceDelete();
    }
}