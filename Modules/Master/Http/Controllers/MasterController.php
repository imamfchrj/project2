<?php

namespace Modules\Master\Http\Controllers;

//use Illuminate\Contracts\Support\Renderable;
//use Illuminate\Http\Request;
//use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;

class MasterController extends Controller
{
    protected $data = [];
    protected $perPage = 20;

    public function __construct()
    {
        $this->data['currentAdminMenu'] = '';
    }
}
