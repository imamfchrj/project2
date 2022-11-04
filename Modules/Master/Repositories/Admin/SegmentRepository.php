<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 02/11/2022
 * Time: 20:03
 */

namespace Modules\Master\Repositories\Admin;

use DB;
use Modules\Master\Entities\Msegment;
use Modules\Master\Repositories\Admin\Interfaces\SegmentRepositoryInterface;

class SegmentRepository implements SegmentRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $segment = new Msegment();

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $segment = $segment->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $segment = $segment->where(function ($query) use ($options) {
                $query->where('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if ($perPage) {
            return $segment->paginate($perPage);
        }

        return $segment->get();
    }

    public function create($params = [])
    {
        // Insert Segment
        $segment = new Msegment();
        $segment->name = $params['name'];
        return $segment->save();
    }

    public function findById($id)
    {
        return Msegment::findOrFail($id);
    }

    public function update($id, $params = [])
    {
        $segment = Msegment::findOrFail($id);
        $segment->name = $params['name'];
        return $segment->save();
    }

    public function delete($id)
    {
        $segment = Msegment::findOrFail($id);
        return $segment->forceDelete();
    }
}