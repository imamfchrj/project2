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
//        // Format Number JIB
//        $tahun = date('Y');
//        $array_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
//        $bulan = $array_bulan[date('n')];
//
//        // BISNIS CAPEX / OPEX
//        if ($params['kategori_id'] == 1) {
//            // Format Number Bisnis
//            $last_pegnajuan = Pengajuan::where('tahun', $tahun)->where('kategori_id', 1)
//                ->orderBy('id', 'DESC')
//                ->first();
//            if (empty($last_pegnajuan)) {
//                $new_number = sprintf("%05d", 00001);
//            } else {
//                $last_number = $last_pegnajuan->number;
//                $new_numbers = $last_number + 1;
//                $new_number = sprintf("%05d", $new_numbers);
//            }
//            $no_jib = $new_number . '/JIB/B/' . $bulan . '/' . $tahun;
//
//            // BISNIS CAPEX
//            if ($params['jenis_id'] == 1) {
//                // Insert Pengajuan
//                $pengajuan = new Pengajuan();
//                $pengajuan->initiator_id = $params['initiator_id'];
//                $pengajuan->jenis_id = $params['jenis_id'];
//                $pengajuan->kategori_id = $params['kategori_id'];
//                $pengajuan->nama_posisi = $params['nama_posisi'];
//                $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
//                $pengajuan->tahun = $tahun;
//                $pengajuan->number = $new_number;
//                $pengajuan->jib_number = $no_jib;
//                $pengajuan->kegiatan = $params['kegiatan_1'];
//                $pengajuan->segment_id = $params['segment_id_1'];
//                $pengajuan->customer_id = $params['customer_id_1'];
//                $pengajuan->periode_up = date('Y-m-d H:i:s');
//                $pengajuan->no_drp = $params['no_drp_1'];
//                $pengajuan->nilai_capex = $params['nilai_capex_1'];
//                $pengajuan->est_revenue = $params['est_revenue'];
//                $pengajuan->irr = $params['irr'];
//                $pengajuan->npv = $params['npv'];
//                $pengajuan->pbp = $params['pbp'];
//                $pengajuan->status_id = 1;
//                $pengajuan->user_id = auth()->user()->id;
//                $pengajuan->created_by = auth()->user()->id;
//                $pengajuan->updated_by = auth()->user()->name;
//                $pengajuan->save();
//                // BISNIS OPEX
//            } else {
//                // Insert Pengajuan
//                $pengajuan = new Pengajuan();
//                $pengajuan->initiator_id = $params['initiator_id'];
//                $pengajuan->jenis_id = $params['jenis_id'];
//                $pengajuan->kategori_id = $params['kategori_id'];
//                $pengajuan->nama_posisi = $params['nama_posisi'];
//                $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
//                $pengajuan->tahun = $tahun;
//                $pengajuan->number = $new_number;
//                $pengajuan->jib_number = $no_jib;
//                $pengajuan->kegiatan = $params['kegiatan_4'];
//                $pengajuan->segment_id = $params['segment_id_4'];
//                $pengajuan->customer_id = $params['customer_id_4'];
//                $pengajuan->periode_up = date('Y-m-d H:i:s');
//                $pengajuan->no_drp = $params['no_drp_4'];
//                $pengajuan->nilai_capex = $params['nilai_capex_4'];
//                $pengajuan->est_revenue = $params['est_revenue_4'];
//                $pengajuan->cost = $params['cost'];
//                $pengajuan->profit_margin = $params['profit_margin'];
//                $pengajuan->net_cf = $params['net_cf'];
//                $pengajuan->suku_bunga = $params['suku_bunga'];
//                $pengajuan->status_id = 1;
//                $pengajuan->user_id = auth()->user()->id;
//                $pengajuan->created_by = auth()->user()->id;
//                $pengajuan->updated_by = auth()->user()->name;
//                $pengajuan->save();
//            }
//
//            if ($pengajuan) {
//                // Insert Review
//                if (!empty($params['note'])) {
//                    $review = new Review();
//                    $review->pengajuan_id = $pengajuan->id;
//                    $review->nik_gsd = auth()->user()->nik_gsd;
//                    $review->nama_karyawan = auth()->user()->name;
//                    $review->status = 'SUBMIT';
//                    $review->notes = $params['note'];
//                    $review->save();
//                }
//                // Insert M_Reviewer
//                if ($params['jenis_id'] == 1) {
//                    if ($params['nilai_capex_1'] <= 3000000000) {
//                        $pemeriksa = $this->pemeriksaRepository->findByRules(1);
//                    } else if ($params['nilai_capex_1'] > 3000000000 && $params['nilai_capex_1'] <= 5000000000) {
//                        $pemeriksa = $this->pemeriksaRepository->findByRules(2);
//                    } else {
//                        $pemeriksa = $this->pemeriksaRepository->findByRules(3);
//                    }
//                }else {
//                    if ($params['nilai_capex_4'] <= 3000000000) {
//                        $pemeriksa = $this->pemeriksaRepository->findByRules(1);
//                    } else if ($params['nilai_capex_4'] > 3000000000 && $params['nilai_capex_4'] <= 5000000000) {
//                        $pemeriksa = $this->pemeriksaRepository->findByRules(2);
//                    } else {
//                        $pemeriksa = $this->pemeriksaRepository->findByRules(3);
//                    }
//                }
//
//                $reviewer = [];
//                foreach ($pemeriksa as $pem) {
//                    if ($pem->urutan == 1) {
//                        $last_status = "OPEN";
//                        $pengajuan->pemeriksa_id = $pem->id;
//                        $pengajuan->save();
//                    } else {
//                        $last_status = "QUEUE";
//                    }
//                    $reviewer[] = [
//                        'pengajuan_id' => $pengajuan->id,
//                        'initiator_id' => $pem->initiator_id,
//                        'nik' => $pem->nik,
//                        'nama' => $pem->nama,
//                        'urutan' => $pem->urutan,
//                        'last_status' => $last_status,
//                    ];
//                }
//                return DB::table('jib_reviewer')->insert($reviewer);
//            }
//            // SUPPORT CAPEX/OPEX
//        } else {
//            // FORMAT NUMBER SUPPORT
//            $last_pegnajuan = Pengajuan::where('tahun', $tahun)->where('kategori_id', 2)
//                ->orderBy('id', 'DESC')
//                ->first();
//            if (empty($last_pegnajuan)) {
//                $new_number = sprintf("%05d", 00001);
//            } else {
//                $last_number = $last_pegnajuan->number;
//                $new_numbers = $last_number + 1;
//                $new_number = sprintf("%05d", $new_numbers);
//            }
//            $no_jib = $new_number . '/JIB/S/' . $bulan . '/' . $tahun;
//
//            // Insert Pengajuan
//            $pengajuan = new Pengajuan();
//            $pengajuan->initiator_id = $params['initiator_id'];
//            $pengajuan->jenis_id = $params['jenis_id'];
//            $pengajuan->kategori_id = $params['kategori_id'];
//            $pengajuan->nama_posisi = $params['nama_posisi'];
//            $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
//            $pengajuan->tahun = $tahun;
//            $pengajuan->number = $new_number;
//            $pengajuan->jib_number = $no_jib;
//            $pengajuan->kegiatan = $params['kegiatan_2'];
//            $pengajuan->segment_id = $params['segment_id_2'];
//            $pengajuan->customer_id = $params['customer_id_2'];
//            $pengajuan->periode_up = date('Y-m-d H:i:s');
//            $pengajuan->no_drp = $params['no_drp_2'];
//            $pengajuan->nilai_capex = $params['nilai_capex_2'];
//            $pengajuan->bcr = $params['bcr'];
//            $pengajuan->status_id = 1;
//            $pengajuan->user_id = auth()->user()->id;
//            $pengajuan->created_by = auth()->user()->id;
//            $pengajuan->updated_by = auth()->user()->name;
//            $pengajuan->save();
//
//            // insert M review
//            if ($pengajuan) {
//                // Insert Review
//                if (!empty($params['note'])) {
//                    $review = new Review();
//                    $review->pengajuan_id = $pengajuan->id;
//                    $review->nik_gsd = auth()->user()->nik_gsd;
//                    $review->nama_karyawan = auth()->user()->name;
//                    $review->status = 'SUBMIT';
//                    $review->notes = $params['note'];
//                    $review->save();
//                }
//                // Insert Reviewer
//                if ($params['nilai_capex_2'] <= 3000000000) {
//                    $pemeriksa = $this->pemeriksaRepository->findByRules(1);
//                } elseif ($params['nilai_capex_2'] > 3000000000 && $params['nilai_capex_2'] <= 5000000000) {
//                    $pemeriksa = $this->pemeriksaRepository->findByRules(2);
//                } else {
//                    $pemeriksa = $this->pemeriksaRepository->findByRules(3);
//                }
//                $reviewer = [];
//                foreach ($pemeriksa as $pem) {
//                    if ($pem->urutan == 1) {
//                        $last_status = "OPEN";
//                        $pengajuan->pemeriksa_id = $pem->id;
//                        $pengajuan->save();
//                    } else {
//                        $last_status = "QUEUE";
//                    }
//                    $reviewer[] = [
//                        'pengajuan_id' => $pengajuan->id,
//                        'initiator_id' => $pem->initiator_id,
//                        'nik' => $pem->nik,
//                        'nama' => $pem->nama,
//                        'urutan' => $pem->urutan,
//                        'last_status' => $last_status,
//                    ];
//                }
//                return DB::table('jib_reviewer')->insert($reviewer);
//            }
//        }
    }

}
