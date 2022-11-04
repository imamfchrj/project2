<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 04/11/2022
 * Time: 23:41
 */

namespace Modules\Master\Repositories\Admin;

use DB;
use Modules\Master\Entities\Manggaran;
use Modules\Master\Repositories\Admin\Interfaces\AnggaranRepositoryInterface;

class AnggaranRepository implements AnggaranRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $anggaran = new Manggaran();

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $anggaran = $anggaran->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $anggaran = $anggaran->where(function ($query) use ($options) {
                $query->where('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if ($perPage) {
            return $anggaran->paginate($perPage);
        }

        return $anggaran->get();
    }

    public function create($params = [])
    {
        // Insert Customer
        $anggaran = new Manggaran();
        $anggaran->name = $params['name'];
        return $anggaran->save();
    }

    public function findById($id)
    {
        return Manggaran::findOrFail($id);
    }

    public function update($id, $params = [])
    {
        $anggaran = Manggaran::findOrFail($id);
        $anggaran->name = $params['name'];
        return $anggaran->save();
    }

    public function delete($id)
    {
        $anggaran = Manggaran::findOrFail($id);
        return $anggaran->forceDelete();
    }
}