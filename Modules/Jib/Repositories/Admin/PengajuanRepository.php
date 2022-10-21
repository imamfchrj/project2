<?php

namespace Modules\Jib\Repositories\Admin;

use Facades\Str;
use DB;

use Modules\Jib\Repositories\Admin\Interfaces\PengajuanRepositoryInterface;
use Modules\Jib\Entities\Pengajuan;
use Modules\Jib\Entities\Review;
use Modules\Jib\Repositories\Admin\Interfaces\PemeriksaRepositoryInterface;
use Modules\Jib\Entities\Reviewer;

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

        $pengajuan = $pengajuan->join('jib_reviewer', 'jib_reviewer.pengajuan_id', '=', 'jib_pengajuan.id')
            ->where('jib_reviewer.last_status', 'OPEN')
            ->where('jib_reviewer.nik', auth()->user()->nik_gsd)
            ->orderBy('jib_pengajuan.id', 'ASC');

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
        return Pengajuan::with('msegments', 'mcustomers', 'mcategories', 'mstatuses', 'users', 'minitiators')
            ->findOrFail($id);
    }

    public function create($params = [])
    {
//        $params['user_id'] = auth()->user()->id;
//        $params['post_type'] = Pengajuan::POST;
//        $params['initiator_id'] = $params['initiator_id'];
////        $params['slug'] = Str::slug($params['title']);
////        $params['code'] = $this->generateCode();
////        $params = array_merge($params, $this->buildMetaParams($params));
//
//        return DB::transaction(function () use ($params) {
//            if ($post = Pengajuan::create($params)) {
////                $this->setFeaturedImage($post, $params);
////                $this->syncCategories($post, $params);
////                $this->syncTags($post, $params);
//
//                return $post;
//            }
//        });

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
                $pengajuan->status_id = 1;
                $pengajuan->user_id = auth()->user()->id;
                $pengajuan->created_by = auth()->user()->id;
                $pengajuan->updated_by = auth()->user()->name;
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
                $pengajuan->status_id = 1;
                $pengajuan->user_id = auth()->user()->id;
                $pengajuan->created_by = auth()->user()->id;
                $pengajuan->updated_by = auth()->user()->name;
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
                }else {
                    if ($params['nilai_capex_4'] <= 3000000000) {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(1);
                    } else if ($params['nilai_capex_4'] > 3000000000 && $params['nilai_capex_4'] <= 5000000000) {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(2);
                    } else {
                        $pemeriksa = $this->pemeriksaRepository->findByRules(3);
                    }
                }

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
                        'nik' => $pem->nik,
                        'nama' => $pem->nama,
                        'urutan' => $pem->urutan,
                        'last_status' => $last_status,
                    ];
                }
                return DB::table('jib_reviewer')->insert($reviewer);
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
            $pengajuan->status_id = 1;
            $pengajuan->user_id = auth()->user()->id;
            $pengajuan->created_by = auth()->user()->id;
            $pengajuan->updated_by = auth()->user()->name;
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
                        'nik' => $pem->nik,
                        'nama' => $pem->nama,
                        'urutan' => $pem->urutan,
                        'last_status' => $last_status,
                    ];
                }
                return DB::table('jib_reviewer')->insert($reviewer);
            }
        }
    }

//    /**
//     * Generate order code
//     *
//     * @return string
//     */
//    public static function generateCode()
//    {
//        $postCode = Str::random(12);
//
//        if (self::isCodeExists($postCode)) {
//            return generateOrderCode();
//        }
//
//        return $postCode;
//    }
//
//    /**
//     * Check if the generated order code is exists
//     *
//     * @param string $orderCode order code
//     *
//     * @return void
//     */
//    private static function isCodeExists($postCode)
//    {
//        return Post::where('code', '=', $postCode)->exists();
//    }
//
//    public function update(Post $post, $params = [])
//    {
//        $params = array_merge($params, $this->buildMetaParams($params));
//
//        return DB::transaction(function () use ($post, $params) {
//            $this->setFeaturedImage($post, $params);
//            $this->syncCategories($post, $params);
//            $this->syncTags($post, $params);
//
//            return $post->update($params);
//        });
//    }
//
//    private function setFeaturedImage($post, $params)
//    {
//        if (isset($params['image'])) {
//            $post->clearMediaCollection('images');
//
//            $post->addMediaFromRequest('image')->toMediaCollection('images');
//            $post->featured_image = $post->getFirstMedia('images')->getUrl();
//            $post->featured_image_caption = $post->getFirstMedia('images')->name;
//
//            $post->save();
//        }
//    }
//
//    private function syncCategories($post, $params)
//    {
//        $categoryIds = (isset($params['categories'])) ? $params['categories'] : [];
//        $post->categories()->sync($categoryIds);
//    }
//
//    private function syncTags($post, $params)
//    {
//        if (isset($params['tags'])) {
//            $tagIds = [];
//
//            foreach ($params['tags'] as $tag) {
//                if (!Str::isUuid($tag)) {
//                    $newTag = Tag::firstOrCreate(['name' => $tag, 'slug' => Str::slug($tag)]);
//                    $tagIds[] = $newTag->id;
//                } else {
//                    $tagIds[] = $tag;
//                }
//            }
//
//            $post->tags()->sync($tagIds);
//        }
//    }
//
//    private function buildMetaParams($params)
//    {
//        $metaParams = [];
//        foreach (Post::META_FIELDS as $metaField => $metaFieldAttr) {
//            if (!empty($params[$metaField])) {
//                $metaParams[$metaField] = $params[$metaField];
//            }
//        }
//
//        $params['metas'] = $metaParams;
//
//        return $params;
//    }
//
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
//
//    public function getMetaFields()
//    {
//        return Post::META_FIELDS;
//    }
}
