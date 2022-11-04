<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 02/11/2022
 * Time: 20:03
 */

namespace Modules\Master\Repositories\Admin;

use DB;
use Modules\Jib\Entities\Mcustomer;
use Modules\Master\Http\Requests\Admin\CustomerRequest;
use Modules\Master\Repositories\Admin\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{

    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $customer = new Mcustomer();

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $customer = $customer->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $customer = $customer->with('minitiators')->where(function ($query) use ($options) {
                $query->where('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if ($perPage) {
            return $customer->paginate($perPage);
        }

        return $customer->get();
    }

    public function create($params = [])
    {
        // Insert Customer
        $customer = new Mcustomer();
        $customer->name = $params['name'];
        return $customer->save();
    }

    public function findById($id)
    {
        return Mcustomer::findOrFail($id);
    }

    public function update($id, $params = [])
    {
        $customer = Mcustomer::findOrFail($id);
        $customer->name = $params['name'];
        return $customer->save();
    }

    public function delete($id)
    {
        $customer = Mcustomer::findOrFail($id);
        return $customer->forceDelete();
    }
}