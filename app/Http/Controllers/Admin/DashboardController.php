<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Modules\Jib\Entities\Minitiator;
use Modules\Jib\Entities\Pengajuan;
use Modules\Jib\Entities\Mbudgetrkap;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        // CEK USER DAN INITIATOR
        $initiator = (new Minitiator())->where('is_pgs', null)->where('user_id', auth()->user()->id)->firstorfail();
//        dd($initiator);

        $params = $request->all();
        $options = [
            'per_page' => 10,
            'order' => [
                'id' => 'desc',
            ],
            'filter' => $params,
        ];

        // GET FILTER BULAN DAN TAHUN PENGAJUAN
        $f_bulan = Pengajuan::groupBy('bulan', 'bulan_id')->orderby('bulan_id', 'ASC')->pluck('bulan', 'bulan_id');
        $f_tahun = Pengajuan::groupBy('tahun')->orderby('tahun', 'ASC')->pluck('tahun', 'tahun');

        $this->data['bulans'] = $f_bulan;
        $this->data['tahuns'] = $f_tahun;
        // END GET FILTER BULAN DAN TAHUN

        $budget_capex = (new Mbudgetrkap());
        $total_realisasi = (new Pengajuan())->where('jenis_id', 1); // CAPEX
        $nilai_capex = (new Pengajuan())->where('jenis_id', 1); // CAPEX
        $rev = (new Pengajuan())->where('jenis_id', 1); // CAPEX

        $doc_draft = (new Pengajuan())->where('status_id', 7)->where('jenis_id', 1);
        $doc_review = (new Pengajuan())->whereIn('status_id', array(1, 2, 3, 4))->where('jenis_id', 1);
        $doc_approval = (new Pengajuan())->where('status_id', 5)->where('jenis_id', 1);
        $doc_return = (new Pengajuan())->where('status_id', 8)->where('jenis_id', 1);
        $doc_rejected = (new Pengajuan())->where('status_id', 9)->where('jenis_id', 1);
        $doc_closed = (new Pengajuan())->where('status_id', 6)->where('jenis_id', 1);
        $doc_total = (new Pengajuan())->where('jenis_id', 1);

        $bisnis = Pengajuan::where('kategori_id', '1')->where('jenis_id', 1);
        $support = Pengajuan::where('kategori_id', '2')->where('jenis_id', 1);

        $pengajuan_by_unit = Pengajuan::select(DB::raw('kode_sub_unit, cc, singkatan_unit, count(kode_sub_unit) as jumlah'))
            ->where('jenis_id', 1)->groupby('kode_sub_unit', 'cc', 'singkatan_unit');

        $jib = Pengajuan::where('jib_pengajuan.jenis_id', 1);

        // IRR
        $data = Pengajuan::select('id', 'singkatan_unit', 'irr', DB::raw('count(*) as total'))
            ->whereJenis_id('1')
            ->where('kategori_id', 1)
            ->groupBy('id', 'singkatan_unit', 'irr');

        $data_unit = Pengajuan::select('id', 'singkatan_unit', DB::raw('count(*) as total'))
            ->whereJenis_id('1')
            ->where('kategori_id', 1)
            ->groupBy('id', 'singkatan_unit');

        //JIKA YANG LOGIN INITIATOR
        if (auth()->user()->roles[0]->id == 2) {
            $budget_capex = $budget_capex->where('cc', $initiator->cc);
            $total_realisasi = $total_realisasi->where('kode_sub_unit', $initiator->kode_sub_unit); // CAPEX
            $nilai_capex = $nilai_capex->where('kode_sub_unit', $initiator->kode_sub_unit); // CAPEX
            $rev = $rev->where('kode_sub_unit', $initiator->kode_sub_unit); // CAPEX

            $doc_draft = $doc_draft->where('kode_sub_unit', $initiator->kode_sub_unit);
            $doc_review = $doc_review->where('kode_sub_unit', $initiator->kode_sub_unit);
            $doc_approval = $doc_approval->where('kode_sub_unit', $initiator->kode_sub_unit);
            $doc_return = $doc_return->where('kode_sub_unit', $initiator->kode_sub_unit);
            $doc_rejected = $doc_rejected->where('kode_sub_unit', $initiator->kode_sub_unit);
            $doc_closed = $doc_closed->where('kode_sub_unit', $initiator->kode_sub_unit);
            $doc_total = $doc_total->where('kode_sub_unit', $initiator->kode_sub_unit);

            $bisnis = $bisnis->where('kode_sub_unit', $initiator->kode_sub_unit);
            $support = $support->where('kode_sub_unit', $initiator->kode_sub_unit);

            $pengajuan_by_unit = $pengajuan_by_unit->where('kode_sub_unit', $initiator->kode_sub_unit);

            $jib = $jib->where('kode_sub_unit', $initiator->kode_sub_unit);

            // IRR
            $data = $data->where('kode_sub_unit', $initiator->kode_sub_unit);

            $data_unit = $data_unit->where('kode_sub_unit', $initiator->kode_sub_unit);
        }

        if (!empty($options['filter']['bulan'])) {
            $budget_capex = $budget_capex->where('periode', $options['filter']['bulan']);
            $total_realisasi = $total_realisasi->where('bulan_id', $options['filter']['bulan']);
            $nilai_capex = $nilai_capex->where('bulan_id', $options['filter']['bulan']);
            $rev = $rev->where('bulan_id', $options['filter']['bulan']);

            $doc_draft = $doc_draft->where('bulan_id', $options['filter']['bulan']);
            $doc_review = $doc_review->where('bulan_id', $options['filter']['bulan']);
            $doc_approval = $doc_approval->where('bulan_id', $options['filter']['bulan']);
            $doc_return = $doc_return->where('bulan_id', $options['filter']['bulan']);
            $doc_rejected = $doc_rejected->where('bulan_id', $options['filter']['bulan']);
            $doc_closed = $doc_closed->where('bulan_id', $options['filter']['bulan']);
            $doc_total = $doc_total->where('bulan_id', $options['filter']['bulan']);

            $bisnis = $bisnis->where('bulan_id', $options['filter']['bulan']);
            $support = $support->where('bulan_id', $options['filter']['bulan']);

            $pengajuan_by_unit = $pengajuan_by_unit->where('bulan_id', $options['filter']['bulan']);

            $jib = $jib->where('bulan_id', $options['filter']['bulan']);

            $data = $data->whereBulan_id($options['filter']['bulan']);
        }

        if (!empty($options['filter']['tahun'])) {
            $budget_capex = $budget_capex->where('tahun', $options['filter']['tahun']);
            $total_realisasi = $total_realisasi->where('tahun', $options['filter']['tahun']);
            $nilai_capex = $nilai_capex->where('tahun', $options['filter']['tahun']);
            $rev = $rev->where('tahun', $options['filter']['tahun']);

            $doc_draft = $doc_draft->where('tahun', $options['filter']['tahun']);
            $doc_review = $doc_review->where('tahun', $options['filter']['tahun']);
            $doc_approval = $doc_approval->where('tahun', $options['filter']['tahun']);
            $doc_return = $doc_return->where('tahun', $options['filter']['tahun']);
            $doc_rejected = $doc_rejected->where('tahun', $options['filter']['tahun']);
            $doc_closed = $doc_closed->where('tahun', $options['filter']['tahun']);
            $doc_total = $doc_total->where('tahun', $options['filter']['tahun']);

            $bisnis = $bisnis->where('tahun', $options['filter']['tahun']);
            $support = $support->where('tahun', $options['filter']['tahun']);

            $pengajuan_by_unit = $pengajuan_by_unit->where('tahun', $options['filter']['tahun']);

            $jib = $jib->where('tahun', $options['filter']['tahun']);

            $data = $data->whereTahun($options['filter']['tahun']);
        }

        $budget_capex = $budget_capex->sum('nilai_program');
        $total_realisasi = $total_realisasi->sum('total_realisasi');
        $available_capex = $budget_capex - $total_realisasi;
        $persen_realisasi = $total_realisasi / $budget_capex * 100;
        $nilai_capex = $nilai_capex->sum('nilai_capex');
        $rev = $rev->sum('est_revenue');

        $doc_draft = $doc_draft->count();
        $doc_review = $doc_review->count();
        $doc_approval = $doc_approval->count();
        $doc_return = $doc_return->count();
        $doc_rejected = $doc_rejected->count();
        $doc_closed = $doc_closed->count();
        $doc_total = $doc_total->count('status_id');

        $bisnis = $bisnis->count();
        $support = $support->count();

        if (!empty($options['per_page'])) {
            $jib = $jib->paginate($options['per_page']);
        } else {
            $jib = $jib->get();
        }

        $pengajuan_by_unit = $pengajuan_by_unit->get();

        $this->data['budget_capex'] = $budget_capex;
        $this->data['total_realisasi'] = $total_realisasi;
        $this->data['available_capex'] = $available_capex;
        $this->data['persen_realisasi'] = $persen_realisasi;
        $this->data['nilai_capex'] = $nilai_capex;
        $this->data['rev'] = $rev;

        $this->data['doc_draft'] = $doc_draft;
        $this->data['doc_review'] = $doc_review;
        $this->data['doc_approval'] = $doc_approval;
        $this->data['doc_return'] = $doc_return;
        $this->data['doc_closed'] = $doc_closed;
        $this->data['doc_rejected'] = $doc_rejected;
        $this->data['doc_total'] = $doc_total;

        $averageTime = Pengajuan::select(\DB::raw("DATEDIFF(updated_at, created_at)AS day_diff"))->where('status_id', '6')->get()->avg('day_diff');
        $this->data['averageTime'] = $averageTime;

        $this->data['bisnis'] = json_encode($bisnis);
        $this->data['support'] = json_encode($support);

        $this->data['jib'] = $jib;

        $this->data['pengajuan_by_unit'] = $pengajuan_by_unit;

        //Number Format
        Str::macro('rupiah', function ($value) {
            return 'Rp. ' . number_format($value, 0, '.', ',');
        });

        Str::macro('num', function ($number) {
            if ($number < 1000000) {
                // Anything less than a million
                $format = 'Rp. ' . number_format($number);
            } else if ($number < 1000000000) {
                // Anything less than a billion
                $format = 'Rp. ' . number_format($number / 1000000, 2) . 'JT';
            } else {
                // At least a billion
                $format = 'Rp. ' . number_format($number / 1000000000, 2) . 'M';
            }
            echo $format;
        });

        $item_result = [];

        foreach ($data_unit->pluck('singkatan_unit') as $item) {
            $kurang_dari = 0;
            $sama_dengan = 0;
            $lebih_dari = 0;

            foreach ($data->get() as $item_unit) {
                if ($item_unit->irr < 11 && $item_unit->singkatan_unit == $item) {
                    $kurang_dari++;
                } elseif ($item_unit->irr >= 11 && $item_unit->irr <= 15 && $item_unit->singkatan_unit == $item) {
                    $sama_dengan++;
                } elseif ($item_unit->irr > 15 && $item_unit->singkatan_unit == $item) {
                    $lebih_dari++;
                }
            }

            $item_result[$item] = array($kurang_dari, $sama_dengan, $lebih_dari);
        }

        $this->data['currentAdminMenu'] = 'dashboard';
        $this->data['irr'] = $item_result;
        return view('admin.dashboard.index', $this->data);
    }
}
