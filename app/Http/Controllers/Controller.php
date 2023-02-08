<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Notifications;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $data = [];
    protected $perPage = 10;

    public function __construct()
    {
        $this->data['currentAdminMenu'] = '';

        $notif = Notifications::where('is_read', 0)->get();
        $this->data['notifications'] = $notif;

//        $count_notif_unread = Notifications::where('is_read', 0)->count();
//        $this->data['count_notif_unread'] = $count_notif_unread;
    }
}
