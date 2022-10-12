<?php

namespace Modules\Jib\Repositories\Admin;

use Facades\Str;
use DB;

use Modules\Jib\Repositories\Admin\Interfaces\PengajuanRepositoryInterface;
use Modules\Jib\Entities\Pengajuan;
//use Modules\Blog\Entities\Tag;

class PengajuanRepository implements PengajuanRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

//        $pengajuan = (new Pengajuan())->with('user');
        $pengajuan = (new Pengajuan())->with('msegments','mcustomers','mcategories','mstatuses','users','minitiators');

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

    public function findAllInTrash($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

        $pengajuan = (new Pengajuan())->onlyTrashed()->with('msegments','mcustomers','mcategories','mstatuses','users','minitiators');

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
        return Pengajuan::with('msegments','mcustomers','mcategories','mstatuses','users','minitiators')->findOrFail($id);
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
        if ($params['kategori_id'] == 1) {
            $pengajaun = new Pengajuan();
            $pengajaun->initiator_id = $params['initiator_id'];
            $pengajaun->kategori_id = $params['kategori_id'];
            $pengajaun->nama_posisi = $params['nama_posisi'];
            $pengajaun->nama_sub_unit = $params['nama_sub_unit'];
            $pengajaun->kegiatan = $params['kegiatan_1'];
            $pengajaun->segment_id = $params['segment_id_1'];
            $pengajaun->customer_id = $params['customer_id_1'];
            $pengajaun->no_drp = $params['no_drp_1'];
            $pengajaun->nilai_capex = $params['nilai_capex_1'];
            $pengajaun->est_revenue = $params['est_revenue'];
            $pengajaun->irr = $params['irr'];
            $pengajaun->npv = $params['npv'];
            $pengajaun->pbp = $params['pbp'];
            $pengajaun->status_id = 1;
            $pengajaun->user_id = auth()->user()->id;
            return $pengajaun->save();
        } else{
            $pengajaun = new Pengajuan();
            $pengajaun->initiator_id = $params['initiator_id'];
            $pengajaun->kategori_id = $params['kategori_id'];
            $pengajaun->nama_posisi = $params['nama_posisi'];
            $pengajaun->nama_sub_unit = $params['nama_sub_unit'];
            $pengajaun->kegiatan = $params['kegiatan_2'];
            $pengajaun->segment_id = $params['segment_id_2'];
            $pengajaun->customer_id = $params['customer_id_2'];
            $pengajaun->no_drp = $params['no_drp_2'];
            $pengajaun->nilai_capex = $params['nilai_capex_2'];
            $pengajaun->bcr = $params['bcr'];
            $pengajaun->status_id = 1;
            $pengajaun->user_id = auth()->user()->id;
            return $pengajaun->save();
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
        $pengajuan  = Pengajuan::withTrashed()->findOrFail($id);
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
        $pengajuan  = Pengajuan::withTrashed()->findOrFail($id);
        if ($pengajuan->trashed()) {
            return $pengajuan->restore();
        }

        return false;
    }

    public function getStatuses()
    {
        return Pengajuan::STATUSES;
    }
//
//    public function getMetaFields()
//    {
//        return Post::META_FIELDS;
//    }
}
