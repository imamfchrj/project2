<?php
/**
 * Created by PhpStorm.
 * User: IT TELPRO
 * Date: 23/10/2022
 * Time: 16:59
 */

namespace Modules\Jib\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PersetujuanRequest extends FormRequest
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
            'no_drp' => '',
            'akun' => '',
            'est_revenue' => '',
            'kegiatan' => '',
            'irr' => '',
            'customer_id' => '',
            'npv' => '',
            'lokasi' => '',
            'playback_period' => '',
            'waktu_kerja' => '',
            'wacc' => '',
            'konstribusi_fee' => '',
            'analisa_risk' => '',
            'skema' => '',
            'score_risk' => '',
            'nilai_capex' => '',
            'rencana_mitigasi' => '',
            'risk_mitigasi' => '',
            'tot_invest' => '',
            'score_mitigasi' => '',
            'sow' => '',
            'kesimpulan' => '',
            'delivery_time' => '',
            'catatan' => '',

            'top' => '',
            'beban' => '',
            'net_cf' => '',
            'suku_bunga' => '',

            'bcr' => ''
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