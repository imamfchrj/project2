<?php

namespace Modules\Jib\Repositories\Admin;

use Modules\Jib\Entities\Persetujuan;
use Modules\Jib\Repositories\Admin\Interfaces\PersetujuanRepositoryInterface;

class PersetujuanRepository implements PersetujuanRepositoryInterface
{

    public function create($params = [])
    {
        // Insert Persetujuan
        $persetujuan = new Persetujuan();
        $persetujuan->pengajuan_id = $params['pengajuan_id'];
        $persetujuan->no_drp = $params['no_drp'];
        $persetujuan->kegiatan = $params['kegiatan'];
        $persetujuan->akun = $params['akun'];
        $persetujuan->customer_id = $params['customer_id'];
        $persetujuan->lokasi = $params['lokasi'];
        $persetujuan->analisa_risk = $params['analisa_risk'];
        $persetujuan->score_risk = $params['score_risk'];
        $persetujuan->rencana_mitigasi = $params['rencana_mitigasi'];
        $persetujuan->risk_mitigasi = $params['risk_mitigasi'];
        $persetujuan->score_mitigasi = $params['score_mitigasi'];
        $persetujuan->sow = $params['sow'];
        $persetujuan->kesimpulan = $params['kesimpulan'];
        $persetujuan->delivery_time = $params['delivery_time'];
        $persetujuan->catatan = $params['catatan'];
        $persetujuan->created_by = auth()->user()->id;
        $persetujuan->updated_by = auth()->user()->name;

        // BISNIS CAPEX
        if (!empty($params['irr'])) {
            $persetujuan->irr = $params['irr'];
        }
        if (!empty($params['est_revenue'])) {
            $persetujuan->est_revenue = $params['est_revenue'];
        }
        if (!empty($params['npv'])) {
            $persetujuan->npv = $params['npv'];
        }
        if (!empty($params['playback_period'])) {
            $persetujuan->playback_period = $params['playback_period'];
        }
        if (!empty($params['waktu_kerja'])) {
            $persetujuan->waktu_kerja = $params['waktu_kerja'];
        }
        if (!empty($params['wacc'])) {
            $persetujuan->wacc = $params['wacc'];
        }
        if (!empty($params['konstribusi_fee'])) {
            $persetujuan->konstribusi_fee = $params['konstribusi_fee'];
        }
        if (!empty($params['skema'])) {
            $persetujuan->skema = $params['skema'];
        }
        if (!empty($params['nilai_capex'])) {
            $persetujuan->nilai_capex = $params['nilai_capex'];
        }
        if (!empty($params['tot_invest'])) {
            $persetujuan->tot_invest = $params['tot_invest'];
        }

        // BISNIS OPEX
        if (!empty($params['top'])) {
            $persetujuan->top = $params['top'];
        }
        if (!empty($params['beban'])) {
            $persetujuan->beban = $params['beban'];
        }
        if (!empty($params['net_cf'])) {
            $persetujuan->net_cf = $params['net_cf'];
        }
        if (!empty($params['suku_bunga'])) {
            $persetujuan->suku_bunga = $params['suku_bunga'];
        }

        // SUPPORT CAPEX/OPEX
        if (!empty($params['bcr'])) {
            $persetujuan->bcr = $params['bcr'];
        }
        return $persetujuan->save();

    }

    public function findAllbyPengId($id)
    {
        return Persetujuan::where('pengajuan_id', $id)->get();
        // $persetujuan = Persetujuan::where('pengajuan_id', $id)->get();
        // $file_approval = $persetujuan->getMedia('file_approval');

        // return compact(['persetujuan', 'file_approval']);
    }

    public function findById($id)
    {
        return Persetujuan::findOrFail($id);
    }

    public function findbyPengId($id)
    {
        return Persetujuan::where('pengajuan_id', $id)->first();
    }

    public function update($id, $params = [])
    {
        $persetujuan = Persetujuan::findOrFail($id);
        $persetujuan->pengajuan_id = $params['pengajuan_id'];
        $persetujuan->no_drp = $params['no_drp'];
        $persetujuan->kegiatan = $params['kegiatan'];
        $persetujuan->akun = $params['akun'];
        $persetujuan->customer_id = $params['customer_id'];
        $persetujuan->lokasi = $params['lokasi'];
        if (!empty($params['analisa_risk'])) {
            $persetujuan->analisa_risk = $params['analisa_risk'];
        }
        if (!empty($params['score_risk'])) {
            $persetujuan->score_risk = $params['score_risk'];
        }
        $persetujuan->rencana_mitigasi = $params['rencana_mitigasi'];
        $persetujuan->risk_mitigasi = $params['risk_mitigasi'];
        $persetujuan->score_mitigasi = $params['score_mitigasi'];
        $persetujuan->sow = $params['sow'];
        $persetujuan->kesimpulan = $params['kesimpulan'];
        $persetujuan->delivery_time = $params['delivery_time'];
        $persetujuan->catatan = $params['catatan'];
        $persetujuan->created_by = auth()->user()->id;
        $persetujuan->updated_by = auth()->user()->name;

        // BISNIS CAPEX
        if (!empty($params['irr'])) {
            $persetujuan->irr = $params['irr'];
        }
        if (!empty($params['est_revenue'])) {
            $persetujuan->est_revenue = $params['est_revenue'];
        }
        if (!empty($params['npv'])) {
            $persetujuan->npv = $params['npv'];
        }
        if (!empty($params['playback_period'])) {
            $persetujuan->playback_period = $params['playback_period'];
        }
        if (!empty($params['waktu_kerja'])) {
            $persetujuan->waktu_kerja = $params['waktu_kerja'];
        }
        if (!empty($params['wacc'])) {
            $persetujuan->wacc = $params['wacc'];
        }
        if (!empty($params['konstribusi_fee'])) {
            $persetujuan->konstribusi_fee = $params['konstribusi_fee'];
        }
        if (!empty($params['skema'])) {
            $persetujuan->skema = $params['skema'];
        }
        if (!empty($params['nilai_capex'])) {
            $persetujuan->nilai_capex = $params['nilai_capex'];
        }
        if (!empty($params['tot_invest'])) {
            $persetujuan->tot_invest = $params['tot_invest'];
        }

        // BISNIS OPEX
        if (!empty($params['top'])) {
            $persetujuan->top = $params['top'];
        }
        if (!empty($params['beban'])) {
            $persetujuan->beban = $params['beban'];
        }
        if (!empty($params['net_cf'])) {
            $persetujuan->net_cf = $params['net_cf'];
        }
        if (!empty($params['suku_bunga'])) {
            $persetujuan->suku_bunga = $params['suku_bunga'];
        }

        // SUPPORT CAPEX/OPEX
        if (!empty($params['bcr'])) {
            $persetujuan->bcr = $params['bcr'];
        }

        //Upload File
        if (isset($params['file_approval'])) {
            $persetujuan->addMediaFromRequest('file_approval')->toMediaCollection('file_approval');
            //$pengajuan->file_jib = $pengajuan->getFirstMedia('file_jib')->getUrl();
        }

        return $persetujuan->save();
    }

}
