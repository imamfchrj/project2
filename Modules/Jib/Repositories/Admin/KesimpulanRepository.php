<?php

namespace Modules\Jib\Repositories\Admin;

use Facades\Str;
use DB;

use Modules\Jib\Repositories\Admin\Interfaces\KesimpulanRepositoryInterface;
use Modules\Jib\Entities\Mkesimpulan;

class KesimpulanRepository implements KesimpulanRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $kesimpulan = (new Mkesimpulan());

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $kesimpulan = $kesimpulan->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $kesimpulan = $kesimpulan->where(function ($query) use ($options) {
                $query->where('id', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if ($perPage) {
            return $kesimpulan->paginate($perPage);
        }

        return $kesimpulan->get();
    }

    public function findById($id)
    {
        return Mkesimpulan::findOrFail($id);
    }

}
