<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 02/11/2022
 * Time: 20:03
 */

namespace Modules\Master\Repositories\Admin;

use DB;
use Modules\Master\Entities\Mkategori;
use Modules\Master\Repositories\Admin\Interfaces\KategoriRepositoryInterface;

class KategoriRepository implements KategoriRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $kategori = new Mkategori();

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $kategori = $kategori->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $kategori = $kategori->where(function ($query) use ($options) {
                $query->where('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if ($perPage) {
            return $kategori->paginate($perPage);
        }

        return $kategori->get();
    }

    public function create($params = [])
    {
        // Insert Kategori
        $kategori = new Mkategori();
        $kategori->name = $params['name'];
        return $kategori->save();
    }

    public function findById($id)
    {
        return Mkategori::findOrFail($id);
    }

    public function update($id, $params = [])
    {
        $kategori = Mkategori::findOrFail($id);
        $kategori->name = $params['name'];
        return $kategori->save();
    }

    public function delete($id)
    {
        $kategori = Mkategori::findOrFail($id);
        return $kategori->forceDelete();
    }
}