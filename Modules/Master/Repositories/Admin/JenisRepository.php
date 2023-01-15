<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 02/11/2022
 * Time: 20:03
 */

namespace Modules\Master\Repositories\Admin;

use DB;
use Modules\Master\Entities\Mjenis;
use Modules\Master\Repositories\Admin\Interfaces\JenisRepositoryInterface;

class JenisRepository implements JenisRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $jenis = new Mjenis();

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $jenis = $jenis->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $jenis = $jenis->where(function ($query) use ($options) {
                $query->where('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if ($perPage) {
            return $jenis->paginate($perPage);
        }

        return $jenis->get();
    }

    public function create($params = [])
    {
        // Insert Jenis
        $jenis = new Mjenis();
        $jenis->name = $params['name'];
        return $jenis->save();
    }

    public function findById($id)
    {
        return Mjenis::findOrFail($id);
    }

    public function update($id, $params = [])
    {
        $jenis = Mjenis::findOrFail($id);
        $jenis->name = $params['name'];
        return $jenis->save();
    }

    public function delete($id)
    {
        $jenis = Mjenis::findOrFail($id);
        return $jenis->forceDelete();
    }
}