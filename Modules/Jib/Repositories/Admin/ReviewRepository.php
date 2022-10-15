<?php

namespace Modules\Jib\Repositories\Admin;

use Facades\Str;
use DB;

use Modules\Jib\Repositories\Admin\Interfaces\ReviewRepositoryInterface;
use Modules\Jib\Entities\Review;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function findById($id)
    {
        return Review::findOrFail($id);
    }

    public function findByPengajuanId($id)
    {
        return Review::where('pengajuan_id', $id)->get();
    }
}