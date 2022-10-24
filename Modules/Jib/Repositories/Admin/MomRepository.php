<?php

namespace Modules\Jib\Repositories\Admin;

use Facades\Str;
use DB;

use Modules\Jib\Repositories\Admin\Interfaces\MomRepositoryInterface;
use Modules\Jib\Entities\Mom;

class MomRepository implements MomRepositoryInterface
{

    public function create($params = [])
    {
        // Insert Mom
        $mom = new Mom();
        $mom->pengajuan_id = $params['pengajuan_id'];
        $mom->dasar_mom = $params['dasar_mom'];
        $mom->ruang_lingkup = $params['ruang_lingkup'];
        $mom->tanggal_mom = $params['tanggal_mom'];
        $mom->spesifikasi = $params['spesifikasi'];
        $mom->venue = $params['venue'];
        $mom->kegiatan = $params['kegiatan'];
        $mom->meeting_called = $params['meeting_called'];
        $mom->lokasi = $params['lokasi'];
        $mom->meeting_type = $params['meeting_type'];
        $mom->top = $params['top'];
        $mom->facilitator = $params['facilitator'];
        $mom->aki = $params['aki'];
        $mom->attende = $params['attende'];
        $mom->catatan = $params['catatan'];
        $mom->kelengkapan = $params['kelengkapan'];
        $mom->anggaran = $params['anggaran'];
        $mom->created_by = auth()->user()->id;
        $mom->updated_by = auth()->user()->name;
        return $mom->save();
    }

    public function findAllbyPengId($id)
    {
        return Mom::where('pengajuan_id',$id)->get();
    }

}
