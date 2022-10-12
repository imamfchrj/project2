<?php

namespace Modules\Jib\Repositories\Admin;

use Facades\Str;
use DB;

use Modules\Jib\Repositories\Admin\Interfaces\SegmentRepositoryInterface;
use Modules\Jib\Entities\Msegment;

class SegmentRepository implements SegmentRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $orderByFields = $options['order'] ?? [];

//        $pengajuan = (new Pengajuan())->with('user');
        $segment = (new Msegment());

        if ($orderByFields) {
            foreach ($orderByFields as $field => $sort) {
                $segment = $segment->orderBy($field, $sort);
            }
        }

        if (!empty($options['filter']['q'])) {
            $segment = $segment->where(function ($query) use ($options) {
                $query->where('id', 'LIKE', "%{$options['filter']['q']}%")
                    ->orWhere('name', 'LIKE', "%{$options['filter']['q']}%");
            });
        }

//        if (!empty($options['filter']['status'])) {
//            $segment = $segment->where('status_id', $options['filter']['status']);
//        }

        if ($perPage) {
            return $segment->paginate($perPage);
        }

        return $segment->get();
    }

//    public function findAllInTrash($options = [])
//    {
//        $perPage = $options['per_page'] ?? null;
//        $orderByFields = $options['order'] ?? [];
//
//        $pengajuan = (new Pengajuan())->onlyTrashed()->with('msegments','mcustomers','mcategories','mstatuses','users','minitiators');
//
//        if ($orderByFields) {
//            foreach ($orderByFields as $field => $sort) {
//                $pengajuan = $pengajuan->orderBy($field, $sort);
//            }
//        }
//
//        if (!empty($options['filter']['q'])) {
//            $pengajuan = $pengajuan->with('minitiators')->where(function ($query) use ($options) {
//                $query->where('segment_id', 'LIKE', "%{$options['filter']['q']}%")
//                    ->orWhere('nama_sub_unit', 'LIKE', "%{$options['filter']['q']}%")
//                    ->orWhere('customer_id', 'LIKE', "%{$options['filter']['q']}%");
//            });
//        }
//
//        if (!empty($options['filter']['status'])) {
//            $pengajuan = $pengajuan->where('status_id', $options['filter']['status']);
//        }
//
//        if ($perPage) {
//            return $pengajuan->paginate($perPage);
//        }
//
//        return $pengajuan->get();
//    }
//
    public function findById($id)
    {
        return Msegment::findOrFail($id);
    }

    public function findByUserId()
    {
        $user_id = auth()->user()->id;
        return Msegment::where('user_id', $user_id)->firstorfail();
    }
//
//    public function create($params = [])
//    {
//        $params['user_id'] = auth()->user()->id;
//        $params['post_type'] = Post::POST;
//        $params['slug'] = Str::slug($params['title']);
//        $params['code'] = $this->generateCode();
//        $params = array_merge($params, $this->buildMetaParams($params));
//
//        return DB::transaction(function () use ($params) {
//            if ($post = Post::create($params)) {
//                $this->setFeaturedImage($post, $params);
//                $this->syncCategories($post, $params);
//                $this->syncTags($post, $params);
//
//                return $post;
//            }
//        });
//    }
//
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
//    public function delete($id, $permanentDelete = false)
//    {
//        $pengajuan  = Pengajuan::withTrashed()->findOrFail($id);
//        $this->checkUserCanDeletePost($pengajuan);
//
//        return DB::transaction(function () use ($pengajuan, $permanentDelete) {
//            if ($permanentDelete) {
//
//                return $pengajuan->forceDelete();
//            }
//
//            return $pengajuan->delete();
//        });
//    }

//    private function checkUserCanDeletePost($pengajuan)
//    {
//        $currentUser = auth()->user();
//        $canDeletePengajuan = $currentUser->hasRole('Superadmin') || ($pengajuan->user_id == $currentUser->id);
//
//        if ($canDeletePengajuan) {
//            return;
//        }
//
//        abort(403, __('jib::pengajuan.fail_delete_message'));
//    }

//    public function restore($id)
//    {
//        $pengajuan  = Pengajuan::withTrashed()->findOrFail($id);
//        if ($pengajuan->trashed()) {
//            return $pengajuan->restore();
//        }
//
//        return false;
//    }
//
//    public function getStatuses()
//    {
//        return Pengajuan::STATUSES;
//    }

}
