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
//                    ->orWhere('nama_sub_unit', 'LIKE', "%{$options['filter']['q']}%")
//                    ->orWhere('jenis_id', 'LIKE', "%{$options['filter']['q']}%")
//                    ->orWhere('customer_id', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

//        if (!empty($options['filter']['status'])) {
//            $customer = $customer->where('status_id', $options['filter']['status']);
//        }
//
//        if (!empty($options['filter']['segment'])) {
//            $customer = $customer->where('segment_id', $options['filter']['segment']);
//        }
//
//        if (!empty($options['filter']['customer'])) {
//            $customer = $customer->where('customer_id', $options['filter']['customer']);
//        }
//        if (!empty($options['filter']['jenis'])) {
//            $customer = $customer->where('jenis_id', $options['filter']['jenis']);
//        }
        if ($perPage) {
            return $customer->paginate($perPage);
        }

        return $customer->get();
    }
}