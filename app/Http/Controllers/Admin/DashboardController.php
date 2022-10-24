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
        $jib = DB::table('jib_pengajuan')->get();
        $rev = DB::table('jib_pengajuan')->sum('est_revenue');
        $nilai_capex = DB::table('jib_pengajuan')->sum('est_revenue');
        $doc_submit = DB::table('jib_pengajuan')->where('status_id', '1')->count();
        $doc_review = DB::table('jib_pengajuan')->where('status_id', '1')->orWhere('status_id', '2')->count();
        $doc_approval = DB::table('jib_pengajuan')->where('status_id', '3')->orWhere('status_id', '4')->orWhere('status_id', '5')->count();
        $doc_closed = DB::table('jib_pengajuan')->where('status_id', '6')->count();
        $doc_total = DB::table('jib_pengajuan')->count('status_id');
        $doc_avg = DB::table('jib_pengajuan')->avg('status_id');
        // dd($doc_review);

        // $allocations = DB::table('jib_pengajuan as jb')
        //         ->join('m_kategori as m', 'm.id', '=', 'jb.kategori_id')
        //         ->select('m.*', 'jb.*', DB::raw('count(m.id) as total'))
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
        // dd($support, $bisnis);

        Str::macro('rupiah', function ($value) {
            return 'Rp. ' . number_format($value, 0, '.', ',');
        });

        $this->data['jib'] = $jib;
        $this->data['rev'] = $rev;
        $this->data['nilai_capex'] = $nilai_capex;
        $this->data['doc_submit'] = $doc_submit;
        $this->data['doc_review'] = $doc_review;
        $this->data['doc_approval'] = $doc_approval;
        $this->data['doc_closed'] = $doc_closed;
        $this->data['doc_total'] = $doc_total;
        $this->data['doc_avg'] = $doc_avg;


        $this->data['currentAdminMenu'] = 'dashboard';
        return view('admin.dashboard.index', $this->data);
    }
}
