<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $jib = DB::table('jib_pengajuan as jb')
                ->select('jb.*', 'm.name as nama_status', 'mk.name as nama_kategori')
                ->join('m_status as m', 'm.id', '=', 'jb.status_id')
                ->join('m_kategori as mk', 'm.id', '=', 'jb.kategori_id')
                // ->where('jb.nama_sub_unit', auth()->user()->id)
                ->get();
        // dd($jib);

        if(auth()->user()->roles[0]->id == 1 || auth()->user()->roles[0]->name == "Approver"){
            $doc_draft = DB::table('jib_pengajuan')->where('status_id', '7')->count();
            // dd($doc_draft);
            $doc_review = DB::table('jib_pengajuan')->where('status_id', '1')->orWhere('status_id', '2')->count();
            $doc_approval = DB::table('jib_pengajuan')->where('status_id', '3')->orWhere('status_id', '4')->orWhere('status_id', '5')->count();
            $doc_return = DB::table('jib_pengajuan')->where('status_id', '8')->count();
            $doc_rejected = DB::table('jib_pengajuan')->where('status_id', '9')->count();
            $doc_closed = DB::table('jib_pengajuan')->where('status_id', '6')->count();
            $doc_total = DB::table('jib_pengajuan')->count('status_id');
            $bisnis = DB::table('jib_pengajuan')->orWhere('kategori_id', '1')->count();
            $support = DB::table('jib_pengajuan')->orWhere('kategori_id', '2')->count();

        }else{
            $doc_draft = DB::table('jib_pengajuan')->where('status_id', '7')->orWhere('nama_sub_unit', auth()->user()->nama_sub_unit)->count();
            $doc_review = DB::table('jib_pengajuan')->where('status_id', '1')->orWhere('status_id', '2')->orWhere('nama_sub_unit', auth()->user()->nama_sub_unit)->count();
            $doc_approval = DB::table('jib_pengajuan')->where('status_id', '3')->orWhere('status_id', '4')->orWhere('status_id', '5')->orWhere('nama_sub_unit', auth()->user()->nama_sub_unit)->count();
            $doc_return = DB::table('jib_pengajuan')->where('status_id', '8')->orWhere('nama_sub_unit', auth()->user()->nama_sub_unit)->count();
            $doc_rejected = DB::table('jib_pengajuan')->where('status_id', '9')->orWhere('nama_sub_unit', auth()->user()->nama_sub_unit)->count();
            $doc_closed = DB::table('jib_pengajuan')->where('status_id', '6')->orWhere('nama_sub_unit', auth()->user()->nama_sub_unit)->count();
            $doc_total = DB::table('jib_pengajuan')->orWhere('nama_sub_unit', auth()->user()->nama_sub_unit)->count('status_id');

            $bisnis = DB::table('jib_pengajuan')->where('kategori_id', '1')->orWhere('nama_sub_unit', auth()->user()->nama_sub_unit)->count();
            $support = DB::table('jib_pengajuan')->where('kategori_id', '2')->orWhere('nama_sub_unit', auth()->user()->nama_sub_unit)->count();
        }

        $rev = DB::table('jib_pengajuan')->sum('est_revenue');
        $nilai_capex = DB::table('jib_pengajuan')->sum('nilai_capex');
        $budget_capex = DB::table('m_budget')->sum('capex_plan');
        $total_realisasi = DB::table('m_budget')->sum('realisasi_capex');
        $available_capex = DB::table('m_budget')->sum('saldo_rkap');
        $persen_realisasi = DB::table('m_budget')->sum('persen_realisasi_capex');



         //Count AVG Completion JIB
         $averageTime = DB::table('jib_pengajuan')->select(\DB::raw("DATEDIFF(updated_at, created_at)AS day_diff"))->where('status_id', '6')->get()->avg('day_diff');


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
                $format = 'Rp. '.number_format($number / 1000000, 2) . 'JT';
            } else {
                // At least a billion
                $format = 'Rp. '.number_format($number / 1000000000, 2) . 'M';
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
        $this->data['bisnis'] = json_encode($bisnis);
        $this->data['support'] = json_encode($support);
        // dd($doc_return);
        $this->data['doc_draft'] = $doc_draft;
        $this->data['doc_review'] = $doc_review;
        $this->data['doc_approval'] = $doc_approval;
        $this->data['doc_return'] = $doc_return;
        $this->data['doc_closed'] = $doc_closed;
        $this->data['doc_rejected'] = $doc_rejected;
        $this->data['doc_total'] = $doc_total;
        $this->data['averageTime'] = $averageTime;

        $this->data['currentAdminMenu'] = 'dashboard';
        return view('admin.dashboard.index', $this->data);
    }
}
