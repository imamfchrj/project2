<?php

namespace Modules\Jib\Repositories\Admin;

use App\Models\Notifications;
use App\Models\User;
use DB;
use Modules\Jib\Entities\Minitiator;
use Modules\Jib\Entities\Mpemeriksa;
use Modules\Jib\Entities\Pengajuan;
use Modules\Jib\Entities\Review;
use Modules\Jib\Entities\Reviewer;
use Modules\Jib\Repositories\Admin\Interfaces\PemeriksaRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\PengajuanRepositoryInterface;

//use Modules\Blog\Entities\Tag;
use App\Imports\JibImport;
use Maatwebsite\Excel\Facades\Excel;

class PengajuanRepository implements PengajuanRepositoryInterface
{
    private $pemeriksaRepository;

    public function __construct(PemeriksaRepositoryInterface $pemeriksaRepository)
    {
        $this->pemeriksaRepository = $pemeriksaRepository;
    }

    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        //        $pengajuan = (new Pengajuan())->with('user');
        $pengajuan = (new Pengajuan())
            ->with('msegments', 'mcustomers', 'mcategories', 'mstatuses', 'users', 'minitiators', 'mpemeriksa', 'mjenises');

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $pengajuan = $pengajuan->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $pengajuan = $pengajuan->with('minitiators')->where(function ($query) use ($options) {
                $query->where('segment_id', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('nama_sub_unit', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('jenis_id', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('jib_number', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('customer_id', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if (!empty($options['filter']['status'])) {
            $pengajuan = $pengajuan->where('status_id', $options['filter']['status']);
        }

        if (!empty($options['filter']['segment'])) {
            $pengajuan = $pengajuan->where('segment_id', $options['filter']['segment']);
        }

        if (!empty($options['filter']['customer'])) {
            $pengajuan = $pengajuan->where('customer_id', $options['filter']['customer']);
        }
        if (!empty($options['filter']['jenis'])) {
            $pengajuan = $pengajuan->where('jenis_id', $options['filter']['jenis']);
        }

        $pengajuan = $pengajuan->select(
            'jib_pengajuan.initiator_id',
            'jib_pengajuan.id',
            'jib_pengajuan.nama_sub_unit',
            'jib_pengajuan.jib_number',
            'jib_pengajuan.segment_id',
            'jib_pengajuan.customer_id',
            'jib_pengajuan.periode_up',
            DB::raw('DATEDIFF(NOW(),jib_pengajuan.periode_up) AS aging'),
            'jib_pengajuan.kegiatan',
            'jib_pengajuan.no_drp',
            'jib_pengajuan.kategori_id',
            'jib_pengajuan.nilai_capex',
            'jib_pengajuan.pemeriksa_id',
            'jib_pengajuan.status_id',
            'jib_pengajuan.user_id',
            'jib_reviewer.pengajuan_id'
        )
            ->join('jib_reviewer', 'jib_reviewer.pengajuan_id', '=', 'jib_pengajuan.id', 'left')// di tambahkan left option, karena draft tidak insert dulu ke reviewer
            ->orwhere(
                function ($query) {
                    if (auth()->user()->roles[0]->id != 1 && auth()->user()->roles[0]->id != 7) {
                        $query->Where('jib_pengajuan.user_id', auth()->user()->id);
                    }
                }
            )
            ->orderBy('jib_pengajuan.id', 'ASC')
            ->groupby(
                'jib_pengajuan.id',
                'jib_pengajuan.initiator_id',
                'jib_pengajuan.nama_sub_unit',
                'jib_pengajuan.jib_number',
                'jib_pengajuan.segment_id',
                'jib_pengajuan.customer_id',
                'jib_pengajuan.periode_up',
                'aging',
                'jib_pengajuan.kegiatan',
                'jib_pengajuan.no_drp',
                'jib_pengajuan.kategori_id',
                'jib_pengajuan.nilai_capex',
                'jib_pengajuan.pemeriksa_id',
                'jib_pengajuan.status_id',
                'jib_pengajuan.user_id',
                'jib_reviewer.pengajuan_id'
            );

        if ($perPage) {
            return $pengajuan->paginate($perPage);
        }

        return $pengajuan->get();
    }

    public function findAllWorkspace($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $pengajuan = (new Pengajuan())
            ->with('msegments', 'mcustomers', 'mcategories', 'mstatuses', 'users', 'minitiators', 'mpemeriksa');

        //        if ($orderByFields) {
        //            foreach ($orderByFields as $field => $sort) {
        //                $pengajuan = $pengajuan->orderBy($field, $sort);
        //            }
        //        }

        if (!empty($options['filter']['q'])) {
            $pengajuan = $pengajuan->with('minitiators')->where(function ($query) use ($options) {
                $query->where('segment_id', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('nama_sub_unit', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('jib_number', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('customer_id', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if (!empty($options['filter']['status'])) {
            $pengajuan = $pengajuan->where('status_id', $options['filter']['status']);
        }

        if (!empty($options['filter']['segment'])) {
            $pengajuan = $pengajuan->where('segment_id', $options['filter']['segment']);
        }

        if (!empty($options['filter']['customer'])) {
            $pengajuan = $pengajuan->where('customer_id', $options['filter']['customer']);
        }

        $pengajuan = $pengajuan->select(
            'jib_pengajuan.initiator_id',
            'jib_pengajuan.id',
            'jib_pengajuan.nama_sub_unit',
            'jib_pengajuan.jib_number',
            'jib_pengajuan.segment_id',
            'jib_pengajuan.customer_id',
            'jib_pengajuan.periode_up',
            'jib_pengajuan.kegiatan',
            'jib_pengajuan.no_drp',
            'jib_pengajuan.kategori_id',
            'jib_pengajuan.nilai_capex',
            'jib_pengajuan.pemeriksa_id',
            'jib_pengajuan.status_id',
            'jib_pengajuan.user_id',
            'jib_reviewer.pengajuan_id'
        )
            ->join('jib_reviewer', 'jib_reviewer.pengajuan_id', '=', 'jib_pengajuan.id', 'left')// di tambahkan left option, karena draft tidak insert dulu ke reviewer
            //            ->where('jib_pengajuan.user_id', auth()->user()->id)
            //            ->orwhere('jib_pengajuan.status_id', 7)
            //            ->where('jib_reviewer.last_status', 'OPEN')
            //            ->where('jib_reviewer.nik', auth()->user()->nik_gsd)
            // BERDASARKAN JIB REVIEWER YANG SEDANG OPEN
            ->orWhere(
                function ($query) {
                    // if (auth()->user()->roles[0]->id == 1 || auth()->user()->roles[0]->name == "Approver") { //Role Approver
                    $query->where('jib_reviewer.last_status', 'OPEN')
                        ->where('jib_reviewer.nik', auth()->user()->nik_gsd);
                    // }
                }
            )
            // ANDI STAFF BISCON
            ->orWhere(
                function ($query) {
                    $query->where('jib_reviewer.last_status', 'OPEN')
                        ->where('jib_reviewer.urutan', auth()->user()->group);
                }
            )
            // STATUS DRAFT BY PEMBUAT
            ->orwhere(
                function ($query) {
                    // if (auth()->user()->roles[0]->id == 1 || auth()->user()->roles[0]->name == "Initiator") { //Role Initiator
                    $query->where('jib_pengajuan.status_id', 7)
                        ->Where('jib_pengajuan.user_id', auth()->user()->id);
                    // }
                }
            )
            // INITIATOR RETURNED DARI REVIEWER 0
            ->orwhere(
                function ($query) {
                    $query->where('jib_pengajuan.status_id', 8)
                        ->Where('jib_pengajuan.user_id', auth()->user()->id);
                }
            )
            ->orderBy('jib_pengajuan.id', 'DESC')
            ->groupby(
                'jib_pengajuan.id',
                'jib_pengajuan.initiator_id',
                'jib_pengajuan.nama_sub_unit',
                'jib_pengajuan.jib_number',
                'jib_pengajuan.segment_id',
                'jib_pengajuan.customer_id',
                'jib_pengajuan.periode_up',
                'jib_pengajuan.kegiatan',
                'jib_pengajuan.no_drp',
                'jib_pengajuan.kategori_id',
                'jib_pengajuan.nilai_capex',
                'jib_pengajuan.pemeriksa_id',
                'jib_pengajuan.status_id',
                'jib_pengajuan.user_id',
                'jib_reviewer.pengajuan_id'
            );

        if ($perPage) {
            return $pengajuan->paginate($perPage);
        }

        return $pengajuan->get();
    }

    public function findAllInTrash($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $pengajuan = (new Pengajuan())->onlyTrashed()
            ->with('msegments', 'mcustomers', 'mcategories', 'mstatuses', 'users', 'minitiators');

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $pengajuan = $pengajuan->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $pengajuan = $pengajuan->with('minitiators')->where(function ($query) use ($options) {
                $query->where('segment_id', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('nama_sub_unit', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('customer_id', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

        if (!empty($options['filter']['status'])) {
            $pengajuan = $pengajuan->where('status_id', $options['filter']['status']);
        }

        if ($perPage) {
            return $pengajuan->paginate($perPage);
        }

        return $pengajuan->get();
    }

    //
    public function findById($id)
    {
        $pengajuan = Pengajuan::with('msegments', 'mcustomers', 'mcategories', 'mstatuses', 'users', 'minitiators')
            ->findOrFail($id);
        $file_jib = $pengajuan->getMedia('file_jib');
        // dd($pengajuan);
        return compact(['pengajuan', 'file_jib']);
        // return Pengajuan::with('msegments', 'mcustomers', 'mcategories', 'mstatuses', 'users', 'minitiators')
        //     ->findOrFail($id);
    }

    public function findByPersetujuanId($persetujuan_id)
    {
        $pengajuan = Pengajuan::with('msegments', 'mcustomers', 'mcategories', 'mstatuses', 'users', 'minitiators')
            ->where('id', $persetujuan_id)
            ->findOrFail($id);

        return $pengajuan;
    }

    public function create($params = [])
    {
        // Format Number JIB
        $tahun = date('Y');
        $array_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $bulan = $array_bulan[date('n')];

        $array_nama_bulan = array(1 => "JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER");
        $nama_bulan = $array_nama_bulan[date('n')];

        $cek_initiator = Minitiator::where('id', $params['nama_sub_unit'])
            ->first();

        // BISNIS CAPEX / OPEX
        if ($params['kategori_id'] == 1) {
            // BISNIS CAPEX
            if ($params['jenis_id'] == 1) {
                // Format Number CAPEX Bisnis
                $last_pegnajuan = Pengajuan::where('tahun', $tahun)->where('kategori_id', 1)->where('jenis_id', 1)
                    ->orderBy('id', 'DESC')
                    ->first();
                if (empty($last_pegnajuan)) {
                    $new_number = sprintf("%05d", 00001);
                } else {
                    $last_number = $last_pegnajuan->number;
                    $new_numbers = $last_number + 1;
                    $new_number = sprintf("%05d", $new_numbers);
                }

                $no_jib = $new_number . '/JIB/CAPEX/B/' . $bulan . '/' . $tahun;

                // Insert Pengajuan
                $pengajuan = new Pengajuan();
                if (empty($cek_initiator)) {
                    $cek_initiator = Minitiator::where('id', $params['initiator_id'])
                        ->first();
                    $pengajuan->initiator_id = $params['initiator_id'];
                    $pengajuan->nama_posisi = $params['nama_posisi'];
                    $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
                    $pengajuan->kode_sub_unit = $params['kode_sub_unit'];
                    $pengajuan->singkatan_unit = $params['singkatan_unit'];
                    $pengajuan->cc = $params['cc'];
                } else {
                    $pengajuan->initiator_id = $cek_initiator->id;
                    $pengajuan->nama_posisi = $cek_initiator->nama_posisi;
                    $pengajuan->nama_sub_unit = $cek_initiator->nama_sub_unit;
                    $pengajuan->kode_sub_unit = $cek_initiator->kode_sub_unit;
                    $pengajuan->singkatan_unit = $cek_initiator->singkatan_unit;
                    $pengajuan->cc = $cek_initiator->cc;
                }
                $pengajuan->bulan_id = date('m');
                $pengajuan->bulan = $nama_bulan;
                $pengajuan->jenis_id = $params['jenis_id'];
                $pengajuan->kategori_id = $params['kategori_id'];
                $pengajuan->tahun = $tahun;
                $pengajuan->number = $new_number;
                $pengajuan->jib_number = $no_jib;
                $pengajuan->kegiatan = $params['kegiatan_1'];
                $pengajuan->segment_id = $params['segment_id_1'];
                $pengajuan->customer_id = $params['customer_id_1'];
                $pengajuan->periode_up = date('Y-m-d H:i:s');
                $pengajuan->no_drp = $params['no_drp_1'];
                $nilai_capex_1 = str_replace(".", "", $params['nilai_capex_1']);
                $est_revenue = str_replace(".", "", $params['est_revenue']);
                $pengajuan->nilai_capex = $nilai_capex_1;
                $pengajuan->est_revenue = $est_revenue;
                $pengajuan->irr = $params['irr'];
                $pengajuan->npv = $params['npv'];
                $pengajuan->pbp = $params['pbp'];

                if ($params['draft_status'] === "true") {
                    $pengajuan->status_id = 7;
                } else {
                    $pengajuan->status_id = 1;
                }

                $pengajuan->user_id = auth()->user()->id;
                $pengajuan->created_by = auth()->user()->id;
                $pengajuan->updated_by = auth()->user()->name;

                //Upload File
                if (isset($params['file_jib_1'])) {
                    $pengajuan->addMediaFromRequest('file_jib_1')->toMediaCollection('file_jib');
                    //$pengajuan->file_jib = $pengajuan->getFirstMedia('file_jib')->getUrl();
                }

                $pengajuan->save();
                // BISNIS OPEX
            } else {
                // Format Number OPEX Bisnis
                $last_pegnajuan = Pengajuan::where('tahun', $tahun)->where('kategori_id', 1)->where('jenis_id', 2)
                    ->orderBy('id', 'DESC')
                    ->first();
                if (empty($last_pegnajuan)) {
                    $new_number = sprintf("%05d", 00001);
                } else {
                    $last_number = $last_pegnajuan->number;
                    $new_numbers = $last_number + 1;
                    $new_number = sprintf("%05d", $new_numbers);
                }
                $no_jib = $new_number . '/JIB/OPEX/B/' . $bulan . '/' . $tahun;
                // Insert Pengajuan
                $pengajuan = new Pengajuan();
                if (empty($cek_initiator)) {
                    $cek_initiator = Minitiator::where('id', $params['initiator_id'])
                        ->first();
                    $pengajuan->initiator_id = $params['initiator_id'];
                    $pengajuan->nama_posisi = $params['nama_posisi'];
                    $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
                    $pengajuan->kode_sub_unit = $params['kode_sub_unit'];
                    $pengajuan->singkatan_unit = $params['singkatan_unit'];
                    $pengajuan->cc = $params['cc'];
                } else {
                    $pengajuan->initiator_id = $cek_initiator->id;
                    $pengajuan->nama_posisi = $cek_initiator->nama_posisi;
                    $pengajuan->nama_sub_unit = $cek_initiator->nama_sub_unit;
                    $pengajuan->kode_sub_unit = $cek_initiator->kode_sub_unit;
                    $pengajuan->singkatan_unit = $cek_initiator->singkatan_unit;
                    $pengajuan->cc = $cek_initiator->cc;
                }
                $pengajuan->bulan_id = date('m');
                $pengajuan->bulan = $nama_bulan;
                $pengajuan->jenis_id = $params['jenis_id'];
                $pengajuan->kategori_id = $params['kategori_id'];
                $pengajuan->tahun = $tahun;
                $pengajuan->number = $new_number;
                $pengajuan->jib_number = $no_jib;
                $pengajuan->kegiatan = $params['kegiatan_4'];
                $pengajuan->segment_id = $params['segment_id_4'];
                $pengajuan->customer_id = $params['customer_id_4'];
                $pengajuan->periode_up = date('Y-m-d H:i:s');
                $pengajuan->no_drp = $params['no_drp_4'];
                $nilai_capex_4 = str_replace(".", "", $params['nilai_capex_4']);
                $est_revenue_4 = str_replace(".", "", $params['est_revenue_4']);
                $pengajuan->nilai_capex = $nilai_capex_4;
                $pengajuan->est_revenue = $est_revenue_4;
                $pengajuan->cost = $params['cost'];
                $pengajuan->profit_margin = $params['profit_margin'];
                $pengajuan->net_cf = $params['net_cf'];
                $pengajuan->suku_bunga = $params['suku_bunga'];

                if ($params['draft_status'] === "true") {
                    $pengajuan->status_id = 7;
                } else {
                    $pengajuan->status_id = 1;
                }

                $pengajuan->user_id = auth()->user()->id;
                $pengajuan->created_by = auth()->user()->id;
                $pengajuan->updated_by = auth()->user()->name;
                //Upload File

                if (isset($params['file_jib_1'])) {
                    $pengajuan->addMediaFromRequest('file_jib_1')->toMediaCollection('file_jib');
                    //$pengajuan->file_jib = $pengajuan->getFirstMedia('file_jib')->getUrl();
                }
                $pengajuan->save();
            }

            if ($pengajuan) {
                // Insert Review
                if (!empty($params['note'])) {
                    $review = new Review();
                    $review->pengajuan_id = $pengajuan->id;
                    $review->nik_gsd = auth()->user()->nik_gsd;
                    $review->nama_karyawan = auth()->user()->name;
                    $review->status = 'SUBMIT';
                    $review->notes = $params['note'];
                    $review->save();
                }
            }
            // SUPPORT CAPEX/OPEX
        } else {
            if ($params['jenis_id'] == 1) {
                // FORMAT NUMBER CAPEX SUPPORT
                $last_pegnajuan = Pengajuan::where('tahun', $tahun)->where('kategori_id', 2)->where('jenis_id', 1)
                    ->orderBy('id', 'DESC')
                    ->first();
                if (empty($last_pegnajuan)) {
                    $new_number = sprintf("%05d", 00001);
                } else {
                    $last_number = $last_pegnajuan->number;
                    $new_numbers = $last_number + 1;
                    $new_number = sprintf("%05d", $new_numbers);
                }
                $no_jib = $new_number . '/JIB/CAPEX/S/' . $bulan . '/' . $tahun;
            } else {
                // FORMAT NUMBER OPEX SUPPORT
                $last_pegnajuan = Pengajuan::where('tahun', $tahun)->where('kategori_id', 2)->where('jenis_id', 2)
                    ->orderBy('id', 'DESC')
                    ->first();
                if (empty($last_pegnajuan)) {
                    $new_number = sprintf("%05d", 00001);
                } else {
                    $last_number = $last_pegnajuan->number;
                    $new_numbers = $last_number + 1;
                    $new_number = sprintf("%05d", $new_numbers);
                }
                $no_jib = $new_number . '/JIB/OPEX/S/' . $bulan . '/' . $tahun;
            }


            // Insert Pengajuan
            $pengajuan = new Pengajuan();
            if (empty($cek_initiator)) {
                $cek_initiator = Minitiator::where('id', $params['initiator_id'])
                    ->first();
                $pengajuan->initiator_id = $params['initiator_id'];
                $pengajuan->nama_posisi = $params['nama_posisi'];
                $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
                $pengajuan->kode_sub_unit = $params['kode_sub_unit'];
                $pengajuan->singkatan_unit = $params['singkatan_unit'];
                $pengajuan->cc = $params['cc'];
            } else {
                $pengajuan->initiator_id = $cek_initiator->id;
                $pengajuan->nama_posisi = $cek_initiator->nama_posisi;
                $pengajuan->nama_sub_unit = $cek_initiator->nama_sub_unit;
                $pengajuan->kode_sub_unit = $cek_initiator->kode_sub_unit;
                $pengajuan->singkatan_unit = $cek_initiator->singkatan_unit;
                $pengajuan->cc = $cek_initiator->cc;
            }
            $pengajuan->bulan_id = date('m');
            $pengajuan->bulan = $nama_bulan;
            $pengajuan->jenis_id = $params['jenis_id'];
            $pengajuan->kategori_id = $params['kategori_id'];
            $pengajuan->tahun = $tahun;
            $pengajuan->number = $new_number;
            $pengajuan->jib_number = $no_jib;
            $pengajuan->kegiatan = $params['kegiatan_2'];
            $pengajuan->segment_id = $params['segment_id_2'];
            if ($params['segment_id_2'] != 6) {
                $pengajuan->customer_id = $params['customer_id_2'];
            }
            $pengajuan->periode_up = date('Y-m-d H:i:s');
            $pengajuan->no_drp = $params['no_drp_2'];
            $nilai_capex_2 = str_replace(".", "", $params['nilai_capex_2']);
            $pengajuan->nilai_capex = $nilai_capex_2;
            $pengajuan->bcr = $params['bcr'];

            if ($params['draft_status'] === "true") {
                $pengajuan->status_id = 7;
            } else {
                $pengajuan->status_id = 1;
            }

            $pengajuan->user_id = auth()->user()->id;
            $pengajuan->created_by = auth()->user()->id;
            $pengajuan->updated_by = auth()->user()->name;

            //Upload File
            if (isset($params['file_jib_2'])) {
                $pengajuan->addMediaFromRequest('file_jib_2')->toMediaCollection('file_jib');
                //$pengajuan->file_jib = $pengajuan->getFirstMedia('file_jib')->getUrl();
            }

            $pengajuan->save();

            // insert M review
            if ($pengajuan) {
                // Insert Review
                if (!empty($params['note'])) {
                    $review = new Review();
                    $review->pengajuan_id = $pengajuan->id;
                    $review->nik_gsd = auth()->user()->nik_gsd;
                    $review->nama_karyawan = auth()->user()->name;
                    $review->status = 'SUBMIT';
                    $review->notes = $params['note'];
                    $review->save();
                }
            }
        }

        // Insert M_Reviewer
        if ($params['kategori_id'] == 1 && $params['jenis_id'] == 1) { // BISNIS CAPEX
            $nilai_capex = str_replace(".", "", $params['nilai_capex_1']);
            $segment = $params['segment_id_1'];
            //            dd('aaa');
        } else if ($params['kategori_id'] == 1 && $params['jenis_id'] == 2) { // BISNIS OPEX
            $nilai_capex = str_replace(".", "", $params['nilai_capex_4']);
            $segment = $params['segment_id_4'];
            //            dd('bbb');
        } else { // SUPPORT CAPEX OPEX
            $nilai_capex = str_replace(".", "", $params['nilai_capex_2']);
            $segment = $params['segment_id_2'];
            //            dd('ccc');
        }

        // Insert M_Reviewer
        $cek_approver = Minitiator::where('objid_posisi', $cek_initiator->objid_posisi_appr)->first();
        // CEK KP / REG
        if ($cek_initiator->kantor == 'KANTOR PUSAT') { // KP - Pemilik CAPEX/OPEX
            //            dd('aaa');
            $objid_approver = $cek_approver->objid_posisi;
            // GET REVIEWER dan APPROVER BY RULES
            if ($nilai_capex <= 3000000000) {
                $pemeriksa = $this->pemeriksaRepository->findByRules(1);
                $get_pem_by_approver = Mpemeriksa::where('objid_posisi', $objid_approver)->where('rules', 1)->where('petugas', 'APPROVER')->first();
                //                dd('abbb');
            } else if ($nilai_capex > 3000000000 && $nilai_capex <= 5000000000) {
                $pemeriksa = $this->pemeriksaRepository->findByRules(2);
                $get_pem_by_approver = Mpemeriksa::where('objid_posisi', $objid_approver)->where('rules', 2)->where('petugas', 'APPROVER')->first();
                //                dd('accc');
            } else {
                $pemeriksa = $this->pemeriksaRepository->findByRules(3);
                $get_pem_by_approver = Mpemeriksa::where('objid_posisi', $objid_approver)->where('rules', 3)->where('petugas', 'APPROVER')->first();
                //                dd('addd');
            }
        } else { // REG - Pemilik CAPEX
            //            dd('bbb');
            // GET REVIEWER dan APPROVER BY RULES
            if ($nilai_capex <= 250000000) {
                $objid_approver = $cek_approver->objid_posisi;
                $pemeriksa = $this->pemeriksaRepository->findByRules(4);
                $get_pem_by_approver = Mpemeriksa::where('objid_posisi', $objid_approver)->where('rules', 4)->where('petugas', 'APPROVER')->first();
                //                dd('bccc');
            } else if ($nilai_capex > 250000000 && $nilai_capex <= 3000000000) {
                $pemeriksa = $this->pemeriksaRepository->findByRules(5);
                $get_pem_by_approver = Mpemeriksa::where('segment_id', $segment)->where('rules', 5)->where('petugas', 'APPROVER')->first();
                //                dd('bddd');
            } else if ($nilai_capex > 3000000000 && $nilai_capex <= 5000000000) {
                $pemeriksa = $this->pemeriksaRepository->findByRules(6);
                if ($params['kategori_id'] == 1) {
                    $get_pem_by_approver = Mpemeriksa::where('segment_id', 1)->where('rules', 6)->where('petugas', 'APPROVER')->first();
                    //                    dd('beee');
                } else {
                    $get_pem_by_approver = Mpemeriksa::where('segment_id', 2)->where('rules', 6)->where('petugas', 'APPROVER')->first();
                    //                    dd('bfff');
                }
            } else {
                $objid_approver = $cek_approver->objid_posisi;
                $pemeriksa = $this->pemeriksaRepository->findByRules(3);
                $get_pem_by_approver = Mpemeriksa::where('objid_posisi', $objid_approver)->where('rules', 3)->where('petugas', 'APPROVER')->first();
                //                dd('bggg');
            }
        }

        if ($params['draft_status'] === "false") {
            $reviewer = [];
            foreach ($pemeriksa as $pem) {
                if ($pem->urutan == 1) {
                    $last_status = "OPEN";
                    $pengajuan->pemeriksa_id = $pem->id;
                    $pengajuan->save();
                } else {
                    $last_status = "QUEUE";
                }
                $reviewer[] = [
                    'pengajuan_id' => $pengajuan->id,
                    'initiator_id' => $pem->initiator_id,
                    'pemeriksa_id' => $pem->id,
                    'nik' => $pem->nik,
                    'nama' => $pem->nama,
                    'urutan' => $pem->urutan,
                    'last_status' => $last_status,
                ];
            }
            $reviewer[] = [
                'pengajuan_id' => $pengajuan->id,
                'initiator_id' => $get_pem_by_approver->initiator_id,
                'pemeriksa_id' => $get_pem_by_approver->id,
                'nik' => $get_pem_by_approver->nik,
                'nama' => $get_pem_by_approver->nama,
                'urutan' => $get_pem_by_approver->urutan,
                'last_status' => "QUEUE",
            ];

            $notification = new Notifications();
            $notification->deskripsi = $no_jib;
            $notification->tipe = 'Submitted By';
            $notification->nik = auth()->user()->nik_gsd;
            $notification->nama = auth()->user()->name;
            $notification->is_read = 0;
            $notification->nik_penerima = '99518821';
            $notification->nama_penerima = 'ABDILLAH HAMMAM NUR FAHMI';
            $notification->save();

            return DB::table('jib_reviewer')->insert($reviewer);
        } else {
            return true;
        }
    }

    //Revisi Pengajuan
    public function update($params = [])
    {
        $array_nama_bulan = array(1 => "JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER");
        $nama_bulan = $array_nama_bulan[date('n')];

        $cek_initiator = Minitiator::where('id', $params['nama_sub_unit'])
            ->first();

        // BISNIS CAPEX / OPEX
        if ($params['kategori_id'] == 1) {
            // BISNIS CAPEX
            if ($params['jenis_id'] == 1) {
                // Update Pengajuan
                $pengajuan = Pengajuan::findOrFail($params['id']);
                if (empty($cek_initiator)) {
                    $cek_initiator = Minitiator::where('id', $params['initiator_id'])
                        ->first();
                    $pengajuan->initiator_id = $params['initiator_id'];
                    $pengajuan->nama_posisi = $params['nama_posisi'];
                    $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
                    $pengajuan->kode_sub_unit = $params['kode_sub_unit'];
                    $pengajuan->singkatan_unit = $params['singkatan_unit'];
                    $pengajuan->cc = $params['cc'];
                } else {
                    $pengajuan->initiator_id = $cek_initiator->id;
                    $pengajuan->nama_posisi = $cek_initiator->nama_posisi;
                    $pengajuan->nama_sub_unit = $cek_initiator->nama_sub_unit;
                    $pengajuan->kode_sub_unit = $cek_initiator->kode_sub_unit;
                    $pengajuan->singkatan_unit = $cek_initiator->singkatan_unit;
                    $pengajuan->cc = $cek_initiator->cc;
                }
                $pengajuan->bulan_id = date('m');
                $pengajuan->bulan = $nama_bulan;
                $pengajuan->jenis_id = $params['jenis_id'];
                $pengajuan->kategori_id = $params['kategori_id'];
                $pengajuan->kegiatan = $params['kegiatan_1'];
                $pengajuan->segment_id = $params['segment_id_1'];
                $pengajuan->customer_id = $params['customer_id_1'];
                $pengajuan->periode_up = date('Y-m-d H:i:s');
                $pengajuan->no_drp = $params['no_drp_1'];
                $nilai_capex_1 = str_replace(".", "", $params['nilai_capex_1']);
                $est_revenue = str_replace(".", "", $params['est_revenue']);
                $pengajuan->nilai_capex = $nilai_capex_1;
                $pengajuan->est_revenue = $est_revenue;
                $pengajuan->irr = $params['irr'];
                $pengajuan->npv = $params['npv'];
                $pengajuan->pbp = $params['pbp'];

                if ($params['draft_status'] == "true") {
                    $pengajuan->status_id = 7;
                } else {
                    $pengajuan->status_id = 1;
                }

                $pengajuan->user_id = auth()->user()->id;
                $pengajuan->created_by = auth()->user()->id;
                $pengajuan->updated_by = auth()->user()->name;
                //Upload File
                if (isset($params['file_jib_1'])) {
                    $pengajuan->addMediaFromRequest('file_jib_1')->toMediaCollection('file_jib');
                    //$pengajuan->file_jib = $pengajuan->getFirstMedia('file_jib')->getUrl();
                }
                $pengajuan->save();
                // BISNIS OPEX
            } else {
                // Insert Pengajuan
                $pengajuan = Pengajuan::findOrFail($params['id']);
                if (empty($cek_initiator)) {
                    $cek_initiator = Minitiator::where('id', $params['initiator_id'])
                        ->first();
                    $pengajuan->initiator_id = $params['initiator_id'];
                    $pengajuan->nama_posisi = $params['nama_posisi'];
                    $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
                    $pengajuan->kode_sub_unit = $params['kode_sub_unit'];
                    $pengajuan->singkatan_unit = $params['singkatan_unit'];
                    $pengajuan->cc = $params['cc'];
                } else {
                    $pengajuan->initiator_id = $cek_initiator->id;
                    $pengajuan->nama_posisi = $cek_initiator->nama_posisi;
                    $pengajuan->nama_sub_unit = $cek_initiator->nama_sub_unit;
                    $pengajuan->kode_sub_unit = $cek_initiator->kode_sub_unit;
                    $pengajuan->singkatan_unit = $cek_initiator->singkatan_unit;
                    $pengajuan->cc = $cek_initiator->cc;
                }
                $pengajuan->bulan_id = date('m');
                $pengajuan->bulan = $nama_bulan;
                $pengajuan->jenis_id = $params['jenis_id'];
                $pengajuan->kategori_id = $params['kategori_id'];
                $pengajuan->kegiatan = $params['kegiatan_4'];
                $pengajuan->segment_id = $params['segment_id_4'];
                $pengajuan->customer_id = $params['customer_id_4'];
                $pengajuan->periode_up = date('Y-m-d H:i:s');
                $pengajuan->no_drp = $params['no_drp_4'];
                $nilai_capex_4 = str_replace(".", "", $params['nilai_capex_4']);
                $est_revenue_4 = str_replace(".", "", $params['est_revenue_4']);
                $pengajuan->nilai_capex = $nilai_capex_4;
                $pengajuan->est_revenue = $est_revenue_4;
                $pengajuan->cost = $params['cost'];
                $pengajuan->profit_margin = $params['profit_margin'];
                $pengajuan->net_cf = $params['net_cf'];
                $pengajuan->suku_bunga = $params['suku_bunga'];

                if ($params['draft_status'] == "true") {
                    $pengajuan->status_id = 7;
                } else {
                    $pengajuan->status_id = 1;
                }

                $pengajuan->user_id = auth()->user()->id;
                $pengajuan->created_by = auth()->user()->id;
                $pengajuan->updated_by = auth()->user()->name;
                //Upload File
                if (isset($params['file_jib_1'])) {
                    $pengajuan->addMediaFromRequest('file_jib_1')->toMediaCollection('file_jib');
                }
                $pengajuan->save();
            }

            if ($pengajuan) {
                // Insert Review
                if (!empty($params['note'])) {
                    $review = new Review();
                    $review->pengajuan_id = $pengajuan->id;
                    $review->nik_gsd = auth()->user()->nik_gsd;
                    $review->nama_karyawan = auth()->user()->name;
                    $review->status = 'SUBMIT';
                    $review->notes = $params['note'];
                    $review->save();
                }
            }
            // SUPPORT CAPEX/OPEX
        } else {
            // Insert Pengajuan
            $pengajuan = Pengajuan::findOrFail($params['id']);
            if (empty($cek_initiator)) {
                $cek_initiator = Minitiator::where('id', $params['initiator_id'])
                    ->first();
                $pengajuan->initiator_id = $params['initiator_id'];
                $pengajuan->nama_posisi = $params['nama_posisi'];
                $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
                $pengajuan->kode_sub_unit = $params['kode_sub_unit'];
                $pengajuan->singkatan_unit = $params['singkatan_unit'];
                $pengajuan->cc = $params['cc'];
            } else {
                $pengajuan->initiator_id = $cek_initiator->id;
                $pengajuan->nama_posisi = $cek_initiator->nama_posisi;
                $pengajuan->nama_sub_unit = $cek_initiator->nama_sub_unit;
                $pengajuan->kode_sub_unit = $cek_initiator->kode_sub_unit;
                $pengajuan->singkatan_unit = $cek_initiator->singkatan_unit;
                $pengajuan->cc = $cek_initiator->cc;
            }
            $pengajuan->bulan_id = date('m');
            $pengajuan->bulan = $nama_bulan;
            $pengajuan->jenis_id = $params['jenis_id'];
            $pengajuan->kategori_id = $params['kategori_id'];
            $pengajuan->kegiatan = $params['kegiatan_2'];
            $pengajuan->segment_id = $params['segment_id_2'];
            if ($params['segment_id_2'] != 6) {
                $pengajuan->customer_id = $params['customer_id_2'];
            } else {
                $pengajuan->customer_id = null;
            }
            $pengajuan->periode_up = date('Y-m-d H:i:s');
            $pengajuan->no_drp = $params['no_drp_2'];
            $nilai_capex_2 = str_replace(".", "", $params['nilai_capex_2']);
            $pengajuan->nilai_capex = $nilai_capex_2;
            $pengajuan->bcr = $params['bcr'];

            if ($params['draft_status'] == "true") {
                $pengajuan->status_id = 7;
            } else {
                $pengajuan->status_id = 1;
            }

            $pengajuan->user_id = auth()->user()->id;
            $pengajuan->created_by = auth()->user()->id;
            $pengajuan->updated_by = auth()->user()->name;

            //Upload File
            if (isset($params['file_jib_2'])) {
                $pengajuan->addMediaFromRequest('file_jib_2')->toMediaCollection('file_jib');
            }
            $pengajuan->save();

            // insert M review
            if ($pengajuan) {
                // Insert Review
                if (!empty($params['note'])) {
                    $review = new Review();
                    $review->pengajuan_id = $pengajuan->id;
                    $review->nik_gsd = auth()->user()->nik_gsd;
                    $review->nama_karyawan = auth()->user()->name;
                    $review->status = 'SUBMIT';
                    $review->notes = $params['note'];
                    $review->save();
                }
            }
        }

        // Insert M_Reviewer
        if ($params['kategori_id'] == 1 && $params['jenis_id'] == 1) { // BISNIS CAPEX
            $nilai_capex = $params['nilai_capex_1'];
            $segment = $params['segment_id_1'];
        } else if ($params['kategori_id'] == 1 && $params['jenis_id'] == 2) { // BISNIS OPEX
            $nilai_capex = $params['nilai_capex_4'];
            $segment = $params['segment_id_4'];
        } else { // SUPPORT CAPEX OPEX
            $nilai_capex = $params['nilai_capex_2'];
            $segment = $params['segment_id_2'];
        }

        // Insert M_Reviewer
        $cek_approver = Minitiator::where('objid_posisi', $cek_initiator->objid_posisi_appr)->first();
        // CEK KP / REG
        if ($cek_initiator->kantor == 'KANTOR PUSAT') { // KP - Pemilik CAPEX/OPEX
            $objid_approver = $cek_approver->objid_posisi;
            // GET REVIEWER dan APPROVER BY RULES
            if ($nilai_capex <= 3000000000) {
                $pemeriksa = $this->pemeriksaRepository->findByRules(1);
                $get_pem_by_approver = Mpemeriksa::where('objid_posisi', $objid_approver)->where('rules', 1)->where('petugas', 'APPROVER')->first();
            } else if ($nilai_capex > 3000000000 && $nilai_capex <= 5000000000) {
                $pemeriksa = $this->pemeriksaRepository->findByRules(2);
                $get_pem_by_approver = Mpemeriksa::where('objid_posisi', $objid_approver)->where('rules', 2)->where('petugas', 'APPROVER')->first();
            } else {
                $pemeriksa = $this->pemeriksaRepository->findByRules(3);
                $get_pem_by_approver = Mpemeriksa::where('objid_posisi', $objid_approver)->where('rules', 3)->where('petugas', 'APPROVER')->first();
            }
        } else { // REG - Pemilik CAPEX
            // GET REVIEWER dan APPROVER BY RULES
            if ($nilai_capex <= 250000000) {
                $objid_approver = $cek_approver->objid_posisi;
                $pemeriksa = $this->pemeriksaRepository->findByRules(4);
                $get_pem_by_approver = Mpemeriksa::where('objid_posisi', $objid_approver)->where('rules', 4)->where('petugas', 'APPROVER')->first();
            } else if ($nilai_capex > 250000000 && $nilai_capex <= 3000000000) {
                $pemeriksa = $this->pemeriksaRepository->findByRules(5);
                $get_pem_by_approver = Mpemeriksa::where('segment_id', $segment)->where('rules', 5)->where('petugas', 'APPROVER')->first();
            } else if ($nilai_capex > 3000000000 && $nilai_capex <= 5000000000) {
                $pemeriksa = $this->pemeriksaRepository->findByRules(6);
                if ($params['kategori_id'] == 1) {
                    $get_pem_by_approver = Mpemeriksa::where('segment_id', 1)->where('rules', 6)->where('petugas', 'APPROVER')->first();
                } else {
                    $get_pem_by_approver = Mpemeriksa::where('segment_id', 2)->where('rules', 6)->where('petugas', 'APPROVER')->first();
                }
            } else {
                $objid_approver = $cek_approver->objid_posisi;
                $pemeriksa = $this->pemeriksaRepository->findByRules(3);
                $get_pem_by_approver = Mpemeriksa::where('objid_posisi', $objid_approver)->where('rules', 3)->where('petugas', 'APPROVER')->first();
            }
        }

        if ($params['draft_status'] == "false") {
            $reviewer = [];
            foreach ($pemeriksa as $pem) {
                if ($pem->urutan == 1) {
                    $last_status = "OPEN";
                    $pengajuan->pemeriksa_id = $pem->id;
                    $pengajuan->save();
                } else {
                    $last_status = "QUEUE";
                }
                $reviewer[] = [
                    'pengajuan_id' => $pengajuan->id,
                    'initiator_id' => $pem->initiator_id,
                    'pemeriksa_id' => $pem->id,
                    'nik' => $pem->nik,
                    'nama' => $pem->nama,
                    'urutan' => $pem->urutan,
                    'last_status' => $last_status,
                ];
            }
            $reviewer[] = [
                'pengajuan_id' => $pengajuan->id,
                'initiator_id' => $get_pem_by_approver->initiator_id,
                'pemeriksa_id' => $get_pem_by_approver->id,
                'nik' => $get_pem_by_approver->nik,
                'nama' => $get_pem_by_approver->nama,
                'urutan' => $get_pem_by_approver->urutan,
                'last_status' => "QUEUE",
            ];

            $notification = new Notifications();
            $notification->deskripsi = $pengajuan->jib_number;
            $notification->tipe = 'Submitted By';
            $notification->nik = auth()->user()->nik_gsd;
            $notification->nama = auth()->user()->name;
            $notification->is_read = 0;
            $notification->nik_penerima = '99518821';
            $notification->nama_penerima = 'ABDILLAH HAMMAM NUR FAHMI';
            $notification->save();

            return DB::table('jib_reviewer')->insert($reviewer);
        } else {
            return true;
        }
    }

    public function delete($id, $permanentDelete = false)
    {
        $pengajuan = Pengajuan::withTrashed()->findOrFail($id);
        //        dd($pengajuan);
        $this->checkUserCanDeletePost($pengajuan);

        return DB::transaction(function () use ($pengajuan, $permanentDelete) {
            if ($permanentDelete) {
                //                $pengajuan->tags()->sync([]);
                //                $pengajuan->categories()->sync([]);

                return $pengajuan->forceDelete();
            }

            return $pengajuan->delete();
        });
    }

    private function checkUserCanDeletePost($pengajuan)
    {
        $currentUser = auth()->user();
        //        dd($currentUser);
        $canDeletePengajuan = $currentUser->hasRole('Superadmin') || ($pengajuan->user_id == $currentUser->id);

        if ($canDeletePengajuan) {
            return;
        }

        abort(403, __('jib::pengajuan.fail_delete_message'));
    }

    public function restore($id)
    {
        $pengajuan = Pengajuan::withTrashed()->findOrFail($id);
        if ($pengajuan->trashed()) {
            return $pengajuan->restore();
        }

        return false;
    }

    public function getStatuses()
    {
        return Pengajuan::STATUSES;
    }

    public function count_review()
    {
        return Pengajuan::whereIn('status_id', array(1, 2))
            ->where(
                function ($query) {
                    if (auth()->user()->roles[0]->id != 1 && auth()->user()->roles[0]->id != 7) {
                        $query->Where('jib_pengajuan.user_id', auth()->user()->id);
                    }
                }
            )->get()->count();
    }

    public function count_approval()
    {
        return Pengajuan::whereIn('status_id', array(3, 4, 5))->where(
            function ($query) {
                if (auth()->user()->roles[0]->id != 1 && auth()->user()->roles[0]->id != 7) {
                    $query->Where('jib_pengajuan.user_id', auth()->user()->id);
                }
            }
        )->get()->count();
    }

    public function count_closed()
    {
        return Pengajuan::whereIn('status_id', array(6))->where(
            function ($query) {
                if (auth()->user()->roles[0]->id != 1 && auth()->user()->roles[0]->id != 7) {
                    $query->Where('jib_pengajuan.user_id', auth()->user()->id);
                }
            }
        )->get()->count();
    }

    public function count_draft()
    {
        return Pengajuan::whereIn('status_id', array(7))->where(
            function ($query) {
                if (auth()->user()->roles[0]->id != 1 && auth()->user()->roles[0]->id != 7) {
                    $query->Where('jib_pengajuan.user_id', auth()->user()->id);
                }
            }
        )->get()->count();
    }

    public function count_initiator()
    {
        return Pengajuan::whereIn('status_id', array(8))->where(
            function ($query) {
                if (auth()->user()->roles[0]->id != 1 && auth()->user()->roles[0]->id != 7) {
                    $query->Where('jib_pengajuan.user_id', auth()->user()->id);
                }
            }
        )->get()->count();
    }

    public function count_rejected()
    {
        return Pengajuan::whereIn('status_id', array(9))->where(
            function ($query) {
                if (auth()->user()->roles[0]->id != 1 && auth()->user()->roles[0]->id != 7) {
                    $query->Where('jib_pengajuan.user_id', auth()->user()->id);
                }
            }
        )->get()->count();
    }

    // Workspace
    public function action_update($params = [])
    {
        $pengajuan_id = $params['pengajuan_id'];
        $status_btn = $params['status_btn'];

        $pengajuan = Pengajuan::where('id', $pengajuan_id)->firstorfail();
        $reviewer = Reviewer::where('pengajuan_id', $pengajuan_id)->where('last_status', 'OPEN')->firstorfail();
        $urutan = $reviewer->urutan; // 1
        $reviewer_count = Reviewer::where('pengajuan_id', $pengajuan_id)->count();
        // Approve
        if ($status_btn == 1) {
            // Update REVIEWER
            $reviewer->last_status = 'APPROVE';
            $reviewer->save();
            if ($urutan < $reviewer_count) {
                $urutan_next = $urutan + 1;
                $reviewer_next = Reviewer::where('pengajuan_id', $pengajuan_id)->where('urutan', $urutan_next)->firstorfail();
                $reviewer_next->last_status = 'OPEN';
                $reviewer_next->save();
            }

            // UPDATE PENGAJUAN
            if ($pengajuan->status_id == 1) { // REVIEWER 1 STAFF BISCON
                $pengajuan->status_id = 2;
                $pengajuan->pemeriksa_id = $reviewer_next->pemeriksa_id;
            } elseif ($pengajuan->status_id == 2) { // REVEIWER 2 MGR BUSINESS & OPERATION CONTROL
                if ($reviewer_count == 3) {
                    $pengajuan->status_id = 5; // REG < 250 JT ke Approval
                    $pengajuan->pemeriksa_id = $reviewer_next->pemeriksa_id;
                } else {
                    $pengajuan->status_id = 3;
                    $pengajuan->pemeriksa_id = $reviewer_next->pemeriksa_id;
                }
            } elseif ($pengajuan->status_id == 3) { // REVIEWER 3 VP RISK MANAGEMENT&BUSINESS PERFORMANCE
                if ($reviewer_count == 4) {
                    $pengajuan->status_id = 5;
                    $pengajuan->pemeriksa_id = $reviewer_next->pemeriksa_id;
                } else {
                    $pengajuan->status_id = 4;
                    $pengajuan->pemeriksa_id = $reviewer_next->pemeriksa_id;
                }
            } elseif ($pengajuan->status_id == 4) {
                $pengajuan->status_id = 5;
                $pengajuan->pemeriksa_id = $reviewer_next->pemeriksa_id;
            } else { // APPROVAL
                $pengajuan->status_id = 6;
                $pengajuan->pemeriksa_id = null;
            }

            // Insert Review
            if (!empty($params['note'])) {
                $review = new Review();
                $review->pengajuan_id = $pengajuan->id;
                $review->reviewer_id = $reviewer->id;
                $review->nik_gsd = auth()->user()->nik_gsd;
                $review->nama_karyawan = auth()->user()->name;
                $review->status = 'APPROVED';
                $review->notes = $params['note'];
                $review->save();
            }

            // Insert Notification
            $notification = new Notifications();
            $notification->deskripsi = $pengajuan->jib_number;
            $notification->nik = auth()->user()->nik_gsd;
            $notification->nama = auth()->user()->name;
            $notification->is_read = 0;
            if ($pengajuan->status_id == 6) {
                $user_pembuat = User::where('id', $pengajuan->user_id)->firstorfail();
                $notification->tipe = 'Closed By';
                $notification->nik_penerima = $user_pembuat->nik_gsd;
                $notification->nama_penerima = $user_pembuat->name;
            } else {
                $notification->tipe = 'Approved By';
                $notification->nik_penerima = $reviewer_next->nik;
                $notification->nama_penerima = $reviewer_next->nama;
            }
            $notification->save();

            return $pengajuan->save();

        // Return
        } elseif ($status_btn == 2) {
            // Update REVIEWER
            $reviewer->last_status = 'QUEUE';
            $reviewer->save();
            $reviewer_before = "";

            if ($urutan != 1) {
                $urutan_before = $urutan - 1;
                $reviewer_before = Reviewer::where('pengajuan_id', $pengajuan_id)->where('urutan', $urutan_before)->firstorfail();
                $reviewer_before->last_status = 'OPEN';
                $reviewer_before->save();
            }

            // UPDATE PENGAJUAN
            if ($pengajuan->status_id == 1) { // REVIEWER 1 STAFF BISCON
                $pengajuan->status_id = 8; // Ke Initiator
                $pengajuan->pemeriksa_id = null;
            } elseif ($pengajuan->status_id == 2) { // REVEIWER 2 MGR BUSINESS & OPERATION CONTROL
                $pengajuan->status_id = 1; // Ke Reviewer 1
                $pengajuan->pemeriksa_id = $reviewer_before->pemeriksa_id;
            } elseif ($pengajuan->status_id == 3) { // REVIEWER 3 VP RISK MANAGEMENT&BUSINESS PERFORMANCE
                $pengajuan->status_id = 2; // Ke Reviewer 2
                $pengajuan->pemeriksa_id = $reviewer_before->pemeriksa_id;
            } elseif ($pengajuan->status_id == 4) { // // REVIEWER 4 DIR FRM
                $pengajuan->status_id = 3; // Ke Reviewer
                $pengajuan->pemeriksa_id = $reviewer_before->pemeriksa_id;
            } else {
                if ($reviewer_count == 3) {
                    $pengajuan->status_id = 2; // Ke Reviewer 2
                    $pengajuan->pemeriksa_id = $reviewer_before->pemeriksa_id;
                } elseif ($reviewer_count == 4) {
                    $pengajuan->status_id = 3; // Ke Reviewer 3
                    $pengajuan->pemeriksa_id = $reviewer_before->pemeriksa_id;
                } else {
                    $pengajuan->status_id = 4; // Ke Reviewer 4
                    $pengajuan->pemeriksa_id = $reviewer_before->pemeriksa_id;
                }
            }

            // Insert Review
            if (!empty($params['note'])) {
                $review = new Review();
                $review->pengajuan_id = $pengajuan->id;
                $review->reviewer_id = $reviewer->id;
                $review->nik_gsd = auth()->user()->nik_gsd;
                $review->nama_karyawan = auth()->user()->name;
                $review->status = 'RETURNED';
                $review->notes = $params['note'];
                $review->save();
            }


            // Insert Notification
            $notification = new Notifications();
            $notification->deskripsi = $pengajuan->jib_number;
            $notification->tipe = 'Returned By';
            $notification->nik = auth()->user()->nik_gsd;
            $notification->nama = auth()->user()->name;
            $notification->is_read = 0;
            if ($urutan != 1) {
                $notification->nik_penerima = $reviewer_before->nik;
                $notification->nama_penerima = $reviewer_before->nama;
            } else {
                $user_pembuat = User::where('id', $pengajuan->user_id)->firstorfail();
                $notification->nik_penerima = $user_pembuat->nik_gsd;
                $notification->nama_penerima = $user_pembuat->name;
            }
            $notification->save();

            return $pengajuan->save();
            // Reject
        } else {
            // Update REVIEWER
            $reviewer->last_status = 'REJECT';
            $reviewer->save();

            // UPDATE PENGAJUAN
            $pengajuan->status_id = 9;

            // Insert Review
            if (!empty($params['note'])) {
                $review = new Review();
                $review->pengajuan_id = $pengajuan->id;
                $review->reviewer_id = $reviewer->id;
                $review->nik_gsd = auth()->user()->nik_gsd;
                $review->nama_karyawan = auth()->user()->name;
                $review->status = 'REJECTED';
                $review->notes = $params['note'];
                $review->save();
            }

            // Insert Notification
            $user_pembuat = User::where('id', $pengajuan->user_id)->firstorfail();

            $notification = new Notifications();
            $notification->deskripsi = $pengajuan->jib_number;
            $notification->tipe = 'Rejected By';
            $notification->nik = auth()->user()->nik_gsd;
            $notification->nama = auth()->user()->name;
            $notification->is_read = 0;
            $notification->nik_penerima = $user_pembuat->nik_gsd;
            $notification->nama_penerima = $user_pembuat->name;
            $notification->save();
            return $pengajuan->save();
        }
    }

    public function jibImport($param = [])
    {
        # code.
        $file = $param['file_realisasi'];

        //Upload File
        // if (isset($file)) {
        //     $pengajuan->addMediaFromRequest('file_realisasi')->toMediaCollection('file_realisasi');
        //$pengajuan->file_jib = $pengajuan->getFirstMedia('file_jib')->getUrl();
        Excel::import(new JibImport, $file);
        // }

        return true;
    }
}
