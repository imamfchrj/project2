<?php

namespace Modules\Jib\Repositories\Admin;

use Facades\Str;
use DB;

use Modules\Jib\Repositories\Admin\Interfaces\AnggaranRepositoryInterface;
use Modules\Jib\Entities\Manggaran;

class AnggaranRepository implements AnggaranRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $anggaran = (new Manggaran());

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $anggaran = $anggaran->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $anggaran = $anggaran->where(function ($query) use ($options) {
                $query->where('id', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if ($perPage) {
            return $anggaran->paginate($perPage);
        }

        return $anggaran->get();
    }

    public function findById($id)
    {
        return Manggaran::findOrFail($id);
    }

}
