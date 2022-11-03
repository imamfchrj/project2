<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 23/10/2022
 * Time: 16:59
 */

namespace Modules\Jib\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

class MomRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'pengajuan_id' => '',
            'dasar_mom' => '',
            'ruang_lingkup' => '',
            'tanggal_mom' => '',
            'spesifikasi' => '',
            'venue' => '',
            'kegiatan' => '',
            'meeting_called' => '',
            'lokasi' => '',
            'meeting_type' => '',
            'top' => '',
            'facilitator' => '',
            'aki' => '',
            'attende' => '',
            'catatan' => '',
            'kelengkapan' => '',
            'anggaran' => '',
            'file_mom' => ''
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