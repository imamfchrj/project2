<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 02/11/2022
 * Time: 20:03
 */

namespace Modules\Master\Repositories\Admin;

use DB;
use Modules\Master\Entities\Mkesimpulan;
use Modules\Master\Repositories\Admin\Interfaces\KesimpulanRepositoryInterface;

class KesimpulanRepository implements KesimpulanRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $kesimpulan = new Mkesimpulan();

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $kesimpulan = $kesimpulan->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $kesimpulan = $kesimpulan->where(function ($query) use ($options) {
                $query->where('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if ($perPage) {
            return $kesimpulan->paginate($perPage);
        }

        return $kesimpulan->get();
    }

    public function create($params = [])
    {
        // Insert Kesimpulan
        $kesimpulan = new Mkesimpulan();
        $kesimpulan->name = $params['name'];
        return $kesimpulan->save();
    }

    public function findById($id)
    {
        return Mkesimpulan::findOrFail($id);
    }

    public function update($id, $params = [])
    {
        $kesimpulan = Mkesimpulan::findOrFail($id);
        $kesimpulan->name = $params['name'];
        return $kesimpulan->save();
    }

    public function delete($id)
    {
        $kesimpulan = Mkesimpulan::findOrFail($id);
        return $kesimpulan->forceDelete();
    }
}