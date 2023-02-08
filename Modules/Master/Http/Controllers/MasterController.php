<?php

namespace Modules\Master\Http\Controllers;

//use Illuminate\Contracts\Support\Renderable;
//use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;

use App\Models\Notifications;

class MasterController extends Controller
{
    protected $data = [];
    protected $perPage = 20;

    public function __construct()
    {
        $this->data['currentAdminMenu'] = '';
        $notif = Notifications::where('is_read', 0)->get();
        $this->data['notifications'] = $notif;

        $count_notif_unread = Notifications::where('is_read', 0)->count();
        $this->data['count_notif_unread'] = $count_notif_unread;
    }
}
