<?php

namespace Modules\Master\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PemeriksaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'rules' => '',
            'keterangan' => '',
            'petugas' => '',
            'nik' => '',
            'nama' => '',
            'urutan' => '',
            'initiator_id' => '',
            'objid_posisi' => '',
            'nama_posisi' => '',
            'is_active' => '',
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
