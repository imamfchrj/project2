<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['currentAdminMenu'] = '';
        $data = Notifications::where('nik_penerima', auth()->user()->nik_gsd);
        if (request()->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)
                        ->format('Y-m-d H:i:s');
                    return $formatedDate;
                })
                ->make(true);
        }
        return view('admin.notification.index', $this->data);
    }

    public function markasread()
    {
        Notifications::where('nik_penerima', auth()->user()->nik_gsd)->where('is_read', 0)
            ->update(['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')]);
        return redirect()->back();
    }

    public function readbyid($id)
    {
        Notifications::where('nik_penerima', auth()->user()->nik_gsd)->where('is_read', 0)
            ->where('id', $id)
            ->update(['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')]);
        return redirect()->back();
    }
}
