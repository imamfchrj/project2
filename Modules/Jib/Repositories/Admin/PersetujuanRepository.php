<?php

namespace Modules\Jib\Repositories\Admin;

use Facades\Str;
use DB;

use Modules\Jib\Repositories\Admin\Interfaces\PersetujuanRepositoryInterface;
use Modules\Jib\Entities\Persetujuan;

class PersetujuanRepository implements PersetujuanRepositoryInterface
{

    public function create($params = [])
    {
        // Insert Persetujuan
        $persetujuan = new Persetujuan();
        $persetujuan->pengajuan_id = $params['pengajuan_id'];
        $persetujuan->no_drp = $params['no_drp'];
        $persetujuan->akun = $params['akun'];
        $persetujuan->est_revenue = $params['est_revenue'];
        $persetujuan->kegiatan = $params['kegiatan'];
        $persetujuan->irr = $params['irr'];
        $persetujuan->customer_id = $params['customer_id'];
        $persetujuan->npv = $params['npv'];
        $persetujuan->lokasi = $params['lokasi'];
        $persetujuan->playback_period = $params['playback_period'];
        $persetujuan->waktu_kerja = $params['waktu_kerja'];
        $persetujuan->wacc = $params['wacc'];
        $persetujuan->konstribusi_fee = $params['konstribusi_fee'];
        $persetujuan->analisa_risk = $params['analisa_risk'];
        $persetujuan->skema = $params['skema'];
        $persetujuan->score_risk = $params['score_risk'];
        $persetujuan->nilai_capex = $params['nilai_capex'];
        $persetujuan->risk_mitigasi = $params['risk_mitigasi'];
        $persetujuan->tot_invest = $params['tot_invest'];
        $persetujuan->score_mitigasi = $params['score_mitigasi'];
        $persetujuan->sow = $params['sow'];
        $persetujuan->kesimpulan = $params['kesimpulan'];
        $persetujuan->delivery_time = $params['delivery_time'];
        $persetujuan->catatan = $params['catatan'];
        $persetujuan->created_by = auth()->user()->id;
        $persetujuan->updated_by = auth()->user()->name;
        return $persetujuan->save();

    }

    public function findAllbyPengId($id)
    {
        return Persetujuan::where('pengajuan_id',$id)->get();
    }

}
