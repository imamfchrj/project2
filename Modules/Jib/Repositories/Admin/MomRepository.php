<?php

namespace Modules\Jib\Repositories\Admin;

use Modules\Jib\Entities\Mom;
use Modules\Jib\Repositories\Admin\Interfaces\MomRepositoryInterface;

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
        // return Mom::where('pengajuan_id', $id)->get();

        // return Persetujuan::where('pengajuan_id', $id)->get();
        $mom = Mom::where('pengajuan_id', $id)->get();
        // dd($mom);
        if ($mom->count() != 0) {
            $file_mom = $mom->last()->getMedia('file_mom');
        } else {
            $file_mom = null;
        }

        return compact(['mom', 'file_mom']);
    }

    public function findbyPengId($id)
    {
        return Mom::where('pengajuan_id', $id)->first();
    }

    public function findById($id)
    {
        return Mom::findOrFail($id);
    }

    public function update($id, $params = [])
    {
        $mom = Mom::findOrFail($id);
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

        //Upload File
        if (isset($params['file_mom'])) {
            $mom->addMediaFromRequest('file_mom')->toMediaCollection('file_mom');
            //$pengajuan->file_jib = $pengajuan->getFirstMedia('file_jib')->getUrl();
        }

        return $mom->save();
    }

}
