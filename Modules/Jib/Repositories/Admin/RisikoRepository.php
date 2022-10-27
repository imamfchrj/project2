<?php

namespace Modules\Jib\Repositories\Admin;

use Facades\Str;
use DB;

use Modules\Jib\Repositories\Admin\Interfaces\RisikoRepositoryInterface;
use Modules\Jib\Entities\Mrisiko;

class RisikoRepository implements RisikoRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $risiko = (new Mrisiko());

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $risiko = $risiko->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $risiko = $risiko->where(function ($query) use ($options) {
                $query->where('id', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if ($perPage) {
            return $risiko->paginate($perPage);
        }

        return $risiko->get();
    }

    public function findById($id)
    {
        return Mrisiko::findOrFail($id);
    }

}
