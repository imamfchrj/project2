<?php

namespace Modules\Jib\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Jib\Entities\Pengajuan;

class PengajuanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'PUT') {
            $title = 'required|unique:jib_pengajuan,title,' . $this->get('id');
        } else {
            $title = 'required|unique:jib_pengajuan,title';
        }

//        $metaFieldsRules = [];
//        if (Post::META_FIELDS) {
//            foreach (Post::META_FIELDS as $metaField => $metaFieldAttr) {
//                $metaFieldsRules[$metaField] = $metaFieldAttr['validation_rules'];
//            }
//        }

        return array_merge([
            'initiator_id' => '',
            'jenis_id' => '',
            'kategori_id' => '',
            'nama_posisi' => '',
            'nama_sub_unit' => '',

            'kegiatan_1' => '',
            'segment_id_1' => '',
            'customer_id_1' => '',
            'no_drp_1' => '',
            'nilai_capex_1' => '',
            'est_revenue' => '',
            'irr' => '',
            'npv' => '',
            'pbp' => '',
            'file_jib_1' => '',

            'kegiatan_2' => '',
            'segment_id_2' => '',
            'customer_id_2' => '',
            'no_drp_2' => '',
            'nilai_capex_2' => '',
            'bcr' => '',
            'file_jib_2' => '',

            'kegiatan_4' => '',
            'segment_id_4' => '',
            'customer_id_4' => '',
            'no_drp_4' => '',
            'nilai_capex_4' => '',
            'est_revenue_4' => '',
            'cost' => '',
            'profit_margin' => '',
            'net_cf' => '',
            'suku_bunga' => '',
            'file_jib_4' => '',
//            'image' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
            'note' => '',
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
