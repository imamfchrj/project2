<?php

namespace Modules\Master\Repositories\Admin;

use Facades\Str;
use DB;

use Modules\Master\Entities\Mbudgetrkap;
use Modules\Master\Repositories\Admin\Interfaces\BudgetRepositoryInterface;
use App\Imports\BudgetImport;
use Maatwebsite\Excel\Facades\Excel;

class BudgetRepository implements BudgetRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $anggaran = new Mbudgetrkap();

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
        $anggaran = new Mbudgetrkap();
        // $anggaran->name = $params['name'];
        return $anggaran->save($params);
    }

    public function findById($id)
    {
        return Mbudgetrkap::findOrFail($id);
    }

    public function update($id, $params = [])
    {
        $anggaran = Mbudgetrkap::findOrFail($id);
        $anggaran->name = $params['name'];
        return $anggaran->save();
    }

    public function delete($id)
    {
        $anggaran = Mbudgetrkap::findOrFail($id);
        return $anggaran->forceDelete();
    }

    public function BudgetImport($param = [])
    {
        # code.
        $file = $param['file_upload_rkap'];
        
        // Excel::import(new BudgetImport, $file);

        return Excel::import(new BudgetImport, $file);;
    }
}
