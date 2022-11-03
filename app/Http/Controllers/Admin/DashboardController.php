<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // $jib = DB::table('jib_pengajuan')->get();
        $jib = DB::table('jib_pengajuan as jb')
                ->select('jb.*', 'm.name as nama_status', 'mk.name as nama_kategori')
                ->join('m_status as m', 'm.id', '=', 'jb.status_id')
                ->join('m_kategori as mk', 'm.id', '=', 'jb.kategori_id')
                ->get();
        $rev = DB::table('jib_pengajuan')->sum('est_revenue');
        $nilai_capex = DB::table('jib_pengajuan')->sum('nilai_capex');
        $budget_capex = DB::table('m_budget')->sum('capex_plan');
        $total_realisasi = DB::table('m_budget')->sum('realisasi_capex');
        $available_capex = DB::table('m_budget')->sum('saldo_rkap');
        $persen_realisasi = DB::table('m_budget')->sum('persen_realisasi_capex');

        $doc_submit = DB::table('jib_pengajuan')->where('status_id', '1')->count();
        $doc_review = DB::table('jib_pengajuan')->where('status_id', '1')->orWhere('status_id', '2')->count();
        $doc_approval = DB::table('jib_pengajuan')->where('status_id', '3')->orWhere('status_id', '4')->orWhere('status_id', '5')->count();
        $doc_return = DB::table('jib_pengajuan')->where('status_id', '8')->count();
        $doc_closed = DB::table('jib_pengajuan')->where('status_id', '6')->count();
        $doc_total = DB::table('jib_pengajuan')->count('status_id');
        $doc_avg = DB::table('jib_pengajuan')->avg('status_id');

        // $allocations = DB::table('jib_pengajuan as jb')
        //         ->join('m_kategori as m', 'm.id', '=', 'jb.kategori_id')
                // ->select('m.*', 'jb.*', DB::raw('count(m.id) as total'))
        //         ->groupBy('m.id')
        //         ->get();
        // $labels=[];
        // $datas=[];
        // foreach($allocations as $allocation){
        //     $labels=$allocation->name;
        //     $datas=$allocation->total;
        // }
        // $this->data['labels'] = $labels;
        // $this->data['datas'] = $datas;

        $bisnis = DB::table('jib_pengajuan')->where('kategori_id', '1')->count();
        $support = DB::table('jib_pengajuan')->where('kategori_id', '2')->count();
        $this->data['bisnis'] = json_encode($bisnis);
        $this->data['support'] = json_encode($support);
        // dd($doc_return);

        //Number Format
        Str::macro('rupiah', function ($value) {
            return 'Rp. ' . number_format($value, 0, '.', ',');
        });

        Str::macro('num', function($number){
            if ($number < 1000000) {
                // Anything less than a million
                $format = 'Rp. '. number_format($number);
            } else if ($number < 1000000000) {
                // Anything less than a billion
                $format = 'Rp. '.number_format($number / 1000000, 2) . 'M';
            } else {
                // At least a billion
                $format = 'Rp. '.number_format($number / 1000000000, 2) . 'Bn';
            }
            echo $format;
        });



        $this->data['jib'] = $jib;
        $this->data['rev'] = $rev;
        $this->data['nilai_capex'] = $nilai_capex;
        $this->data['budget_capex'] = $budget_capex;
        $this->data['total_realisasi'] = $total_realisasi;
        $this->data['available_capex'] = $available_capex;
        $this->data['persen_realisasi'] = $persen_realisasi;

        $this->data['doc_submit'] = $doc_submit;
        $this->data['doc_review'] = $doc_review;
        $this->data['doc_approval'] = $doc_approval;
        $this->data['doc_return'] = $doc_return;
        $this->data['doc_closed'] = $doc_closed;
        $this->data['doc_total'] = $doc_total;
        $this->data['doc_avg'] = $doc_avg;

        $this->data['currentAdminMenu'] = 'dashboard';
        return view('admin.dashboard.index', $this->data);
    }
}
