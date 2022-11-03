<?php

namespace Modules\Jib\Repositories\Admin;

use DB;
use Modules\Jib\Entities\Pengajuan;
use Modules\Jib\Entities\Review;
use Modules\Jib\Entities\Reviewer;
use Modules\Jib\Repositories\Admin\Interfaces\PemeriksaRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\PengajuanRepositoryInterface;

//use Modules\Blog\Entities\Tag;

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
//                    ->orWhere('name', 'LIKE', "%{$options['filter']['q']}%")
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
            'jib_pengajuan.segment_id',
            'jib_pengajuan.customer_id',
            'jib_pengajuan.kegiatan',
            'jib_pengajuan.no_drp',
            'jib_pengajuan.kategori_id',
            'jib_pengajuan.nilai_capex',
            'jib_pengajuan.pemeriksa_id',
            'jib_pengajuan.status_id',
            'jib_pengajuan.user_id',
            'jib_reviewer.pengajuan_id'
        )
            ->join('jib_reviewer', 'jib_reviewer.pengajuan_id', '=', 'jib_pengajuan.id','left') // di tambahkan left option, karena draft tidak insert dulu ke reviewer
//            ->where('jib_pengajuan.user_id', auth()->user()->id)
//            ->orwhere('jib_pengajuan.status_id', 7)
//            ->where('jib_reviewer.last_status', 'OPEN')
//            ->where('jib_reviewer.nik', auth()->user()->nik_gsd)
            ->orWhere(
                function ($query) {
                    // if (auth()->user()->roles[0]->id == 1 || auth()->user()->roles[0]->name == "Approver") { //Role Approver
                        $query->where('jib_reviewer.last_status', 'OPEN')
                            ->where('jib_reviewer.nik', auth()->user()->nik_gsd);
                    // }
                }
            )
            ->orwhere(
                function ($query) {
                    // if (auth()->user()->roles[0]->id == 1 || auth()->user()->roles[0]->name == "Initiator") { //Role Initiator
                        $query->where('jib_pengajuan.status_id', 7)
                            ->Where('jib_pengajuan.user_id', auth()->user()->id);
                    // }
                }
            )->orwhere(
            function ($query) {
                $query->where('jib_pengajuan.status_id', 8)
                    ->Where('jib_pengajuan.user_id', auth()->user()->id);
            }
        )
            ->orderBy('jib_pengajuan.id', 'ASC')
            ->groupby(
                'jib_pengajuan.id',
                'jib_pengajuan.initiator_id',
                'jib_pengajuan.nama_sub_unit',
                'jib_pengajuan.segment_id',
                'jib_pengajuan.customer_id',
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

        // BISNIS CAPEX / OPEX
        if ($params['kategori_id'] == 1) {
            // Format Number Bisnis
            $last_pegnajuan = Pengajuan::where('tahun', $tahun)->where('kategori_id', 1)
                ->orderBy('id', 'DESC')
                ->first();
            if (empty($last_pegnajuan)) {
                $new_number = sprintf("%05d", 00001);
            } else {
                $last_number = $last_pegnajuan->number;
                $new_numbers = $last_number + 1;
                $new_number = sprintf("%05d", $new_numbers);
            }
            $no_jib = $new_number . '/JIB/B/' . $bulan . '/' . $tahun;

            // BISNIS CAPEX
            if ($params['jenis_id'] == 1) {
                // Insert Pengajuan
                $pengajuan = new Pengajuan();
                $pengajuan->initiator_id = $params['initiator_id'];
                $pengajuan->jenis_id = $params['jenis_id'];
                $pengajuan->kategori_id = $params['kategori_id'];
                $pengajuan->nama_posisi = $params['nama_posisi'];
                $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
                $pengajuan->tahun = $tahun;
                $pengajuan->number = $new_number;
                $pengajuan->jib_number = $no_jib;
                $pengajuan->kegiatan = $params['kegiatan_1'];
                $pengajuan->segment_id = $params['segment_id_1'];
                $pengajuan->customer_id = $params['customer_id_1'];
                $pengajuan->periode_up = date('Y-m-d H:i:s');
                $pengajuan->no_drp = $params['no_drp_1'];
                $pengajuan->nilai_capex = $params['nilai_capex_1'];
                $pengajuan->est_revenue = $params['est_revenue'];
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
                // Insert Pengajuan
                $pengajuan = new Pengajuan();
                $pengajuan->initiator_id = $params['initiator_id'];
                $pengajuan->jenis_id = $params['jenis_id'];
                $pengajuan->kategori_id = $params['kategori_id'];
                $pengajuan->nama_posisi = $params['nama_posisi'];
                $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
                $pengajuan->tahun = $tahun;
                $pengajuan->number = $new_number;
                $pengajuan->jib_number = $no_jib;
                $pengajuan->kegiatan = $params['kegiatan_4'];
                $pengajuan->segment_id = $params['segment_id_4'];
                $pengajuan->customer_id = $params['customer_id_4'];
                $pengajuan->periode_up = date('Y-m-d H:i:s');
                $pengajuan->no_drp = $params['no_drp_4'];
                $pengajuan->nilai_capex = $params['nilai_capex_4'];
                $pengajuan->est_revenue = $params['est_revenue_4'];
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
                // Insert M_Reviewer
                if ($params['jenis_id'] == 1) {
                    if ($params['nilai_capex_1'] <= 3000000000) {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(1);
                    } else if ($params['nilai_capex_1'] > 3000000000 && $params['nilai_capex_1'] <= 5000000000) {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(2);
                    } else {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(3);
                    }
                } else {
                    if ($params['nilai_capex_4'] <= 3000000000) {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(1);
                    } else if ($params['nilai_capex_4'] > 3000000000 && $params['nilai_capex_4'] <= 5000000000) {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(2);
                    } else {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(3);
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

                    return DB::table('jib_reviewer')->insert($reviewer);
                } else {
                    return true;
                }
            }
            // SUPPORT CAPEX/OPEX
        } else {
            // FORMAT NUMBER SUPPORT
            $last_pegnajuan = Pengajuan::where('tahun', $tahun)->where('kategori_id', 2)
                ->orderBy('id', 'DESC')
                ->first();
            if (empty($last_pegnajuan)) {
                $new_number = sprintf("%05d", 00001);
            } else {
                $last_number = $last_pegnajuan->number;
                $new_numbers = $last_number + 1;
                $new_number = sprintf("%05d", $new_numbers);
            }
            $no_jib = $new_number . '/JIB/S/' . $bulan . '/' . $tahun;

            // Insert Pengajuan
            $pengajuan = new Pengajuan();
            $pengajuan->initiator_id = $params['initiator_id'];
            $pengajuan->jenis_id = $params['jenis_id'];
            $pengajuan->kategori_id = $params['kategori_id'];
            $pengajuan->nama_posisi = $params['nama_posisi'];
            $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
            $pengajuan->tahun = $tahun;
            $pengajuan->number = $new_number;
            $pengajuan->jib_number = $no_jib;
            $pengajuan->kegiatan = $params['kegiatan_2'];
            $pengajuan->segment_id = $params['segment_id_2'];
            $pengajuan->customer_id = $params['customer_id_2'];
            $pengajuan->periode_up = date('Y-m-d H:i:s');
            $pengajuan->no_drp = $params['no_drp_2'];
            $pengajuan->nilai_capex = $params['nilai_capex_2'];
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
                // Insert Reviewer
                if ($params['nilai_capex_2'] <= 3000000000) {
                    $pemeriksa = $this->pemeriksaRepository->findByRules(1);
                } elseif ($params['nilai_capex_2'] > 3000000000 && $params['nilai_capex_2'] <= 5000000000) {
                    $pemeriksa = $this->pemeriksaRepository->findByRules(2);
                } else {
                    $pemeriksa = $this->pemeriksaRepository->findByRules(3);
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
                    return DB::table('jib_reviewer')->insert($reviewer);
                } else {
                    return true;
                }
            }
        }
    }

    //Revisi Pengajuan
    public function update($params = [])
    {
        // dd($params);
        // $id = $this->get('id');
        // BISNIS CAPEX / OPEX
        if ($params['kategori_id'] == 1) {
            // BISNIS CAPEX
            if ($params['jenis_id'] == 1) {
                // Update Pengajuan
                $pengajuan = Pengajuan::findOrFail($params['id']);
                $pengajuan->initiator_id = $params['initiator_id'];
                $pengajuan->jenis_id = $params['jenis_id'];
                $pengajuan->kategori_id = $params['kategori_id'];
                $pengajuan->nama_posisi = $params['nama_posisi'];
                $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
                $pengajuan->kegiatan = $params['kegiatan_1'];
                $pengajuan->segment_id = $params['segment_id_1'];
                $pengajuan->customer_id = $params['customer_id_1'];
                $pengajuan->periode_up = date('Y-m-d H:i:s');
                $pengajuan->no_drp = $params['no_drp_1'];
                $pengajuan->nilai_capex = $params['nilai_capex_1'];
                $pengajuan->est_revenue = $params['est_revenue'];
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
                $pengajuan->initiator_id = $params['initiator_id'];
                $pengajuan->jenis_id = $params['jenis_id'];
                $pengajuan->kategori_id = $params['kategori_id'];
                $pengajuan->nama_posisi = $params['nama_posisi'];
                $pengajuan->nama_sub_unit = $params['nama_sub_unit'];
                $pengajuan->kegiatan = $params['kegiatan_4'];
                $pengajuan->segment_id = $params['segment_id_4'];
                $pengajuan->customer_id = $params['customer_id_4'];
                $pengajuan->periode_up = date('Y-m-d H:i:s');
                $pengajuan->no_drp = $params['no_drp_4'];
                $pengajuan->nilai_capex = $params['nilai_capex_4'];
                $pengajuan->est_revenue = $params['est_revenue_4'];
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
                // Insert M_Reviewer
                if ($params['jenis_id'] == 1) {
                    if ($params['nilai_capex_1'] <= 3000000000) {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(1);
                    } else if ($params['nilai_capex_1'] > 3000000000 && $params['nilai_capex_1'] <= 5000000000) {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(2);
                    } else {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(3);
                    }
                } else {
                    if ($params['nilai_capex_4'] <= 3000000000) {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(1);
                    } else if ($params['nilai_capex_4'] > 3000000000 && $params['nilai_capex_4'] <= 5000000000) {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(2);
                    } else {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(3);
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

                    return DB::table('jib_reviewer')->insert($reviewer);
                } else {
                    return true;
                }
            }
            // SUPPORT CAPEX/OPEX
        } else {

            // Insert Pengajuan
            $pengajuan = Pengajuan::findOrFail($params['id']);
            $pengajuan->initiator_id = $params['initiator_id'];
            $pengajuan->jenis_id = $params['jenis_id'];
            $pengajuan->kategori_id = $params['kategori_id'];
            $pengajuan->nama_posisi = $params['nama_posisi'];
            $pengajuan->nama_sub_unit = $params['nama_sub_unit'];

            $pengajuan->kegiatan = $params['kegiatan_2'];
            $pengajuan->segment_id = $params['segment_id_2'];
            $pengajuan->customer_id = $params['customer_id_2'];
            $pengajuan->periode_up = date('Y-m-d H:i:s');
            $pengajuan->no_drp = $params['no_drp_2'];
            $pengajuan->nilai_capex = $params['nilai_capex_2'];
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
                // Insert Reviewer
                if ($params['nilai_capex_2'] <= 3000000000) {
                    $pemeriksa = $this->pemeriksaRepository->findByRules(1);
                } elseif ($params['nilai_capex_2'] > 3000000000 && $params['nilai_capex_2'] <= 5000000000) {
                    $pemeriksa = $this->pemeriksaRepository->findByRules(2);
                } else {
                    $pemeriksa = $this->pemeriksaRepository->findByRules(3);
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
                    return DB::table('jib_reviewer')->insert($reviewer);
                } else {
                    return true;
                }
            }
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
        return Pengajuan::whereIn('status_id', array(1, 2))->get()->count();
    }

    public function count_approval()
    {
        return Pengajuan::whereIn('status_id', array(3, 4, 5))->get()->count();
    }

    public function count_closed()
    {
        return Pengajuan::whereIn('status_id', array(6))->get()->count();
    }

    public function count_draft()
    {
        return Pengajuan::whereIn('status_id', array(7))->get()->count();
    }

    public function count_initiator()
    {
        return Pengajuan::whereIn('status_id', array(8))->get()->count();
    }

    public function count_rejected()
    {
        return Pengajuan::whereIn('status_id', array(9))->get()->count();
    }

    // Workspace
    public function action_update($params = [])
    {
        $pengajuan_id = $params['pengajuan_id'];
        $status_btn = $params['status_btn'];

        $pengajuan = Pengajuan::where('id', $pengajuan_id)->firstorfail();
        $reviewer = Reviewer::where('pengajuan_id', $pengajuan_id)->where('last_status', 'OPEN')->firstorfail();
        $urutan = $reviewer->urutan; // 1
        $reviewer_count = Reviewer::where('pengajuan_id', $pengajuan_id)->count(); //3
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
            if ($pengajuan->status_id == 1) {
                $pengajuan->status_id = 2;
                $pengajuan->pemeriksa_id = $reviewer_next->pemeriksa_id;
            } elseif ($pengajuan->status_id == 2) {
                $pengajuan->status_id = 3;
                $pengajuan->pemeriksa_id = $reviewer_next->pemeriksa_id;
            } elseif ($pengajuan->status_id == 3) {
                if ($reviewer_count == 3) {
                    $pengajuan->status_id = 6;
                    $pengajuan->pemeriksa_id = null;
                } else {
                    $pengajuan->status_id = 4;
                    $pengajuan->pemeriksa_id = $reviewer_next->pemeriksa_id;
                }
            } elseif ($pengajuan->status_id == 4) {
                if ($reviewer_count == 4) {
                    $pengajuan->status_id = 6;
                    $pengajuan->pemeriksa_id = null;
                } else {
                    $pengajuan->status_id = 5;
                    $pengajuan->pemeriksa_id = $reviewer_next->pemeriksa_id;
                }
            } else {
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
            if ($pengajuan->status_id == 1) {
                $pengajuan->status_id = 8;
                $pengajuan->pemeriksa_id = null;
            } elseif ($pengajuan->status_id == 2) {
                $pengajuan->status_id = 1;
                $pengajuan->pemeriksa_id = $reviewer_before->pemeriksa_id;
            } elseif ($pengajuan->status_id == 3) {
                $pengajuan->status_id = 2;
                $pengajuan->pemeriksa_id = $reviewer_before->pemeriksa_id;
            } elseif ($pengajuan->status_id == 4) {
                $pengajuan->status_id = 3;
                $pengajuan->pemeriksa_id = $reviewer_before->pemeriksa_id;
            } else {
                $pengajuan->status_id = 4;
                $pengajuan->pemeriksa_id = $reviewer_before->pemeriksa_id;
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
            return $pengajuan->save();
        }
    }
}
