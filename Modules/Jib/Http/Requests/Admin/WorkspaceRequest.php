<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 23/10/2022
 * Time: 16:59
 */

namespace Modules\Jib\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WorkspaceRequest extends FormRequest
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
            'status_btn' => '',
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