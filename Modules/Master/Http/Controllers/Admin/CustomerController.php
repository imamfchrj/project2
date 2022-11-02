<?php

namespace Modules\Master\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Master\Http\Controllers\MasterController;

use Modules\Jib\Repositories\Admin\Interfaces\CustomerRepositoryInterface;

use App\Authorizable;

class CustomerController extends MasterController
{
    use Authorizable;

    private  $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'customer';

        $this->customerRepository = $customerRepository;

//        $this->data['statuses'] = $this->pengajuanRepository->getStatuses();
        $this->data['viewTrash'] = false;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $options = [
            'per_page' => $this->perPage,
            'order' => [
                'id' => 'asc',
            ],
            'filter' => $params,
        ];
        $this->data['customers'] = $this->customerRepository->findAll($options);
        $this->data['filter'] = $params;
//        $this->data['segments'] = $this->segmentRepository->findAll()->pluck('name', 'id');
//        $this->data['customers'] = $this->customerRepository->findAll()->pluck('name', 'id');
//        $this->data['count_review'] = $this->pengajuanRepository->count_review();
//        $this->data['count_approval'] = $this->pengajuanRepository->count_approval();
//        $this->data['count_closed'] = $this->pengajuanRepository->count_closed();
//        $this->data['count_draft'] = $this->pengajuanRepository->count_draft();
//        $this->data['count_initiator'] = $this->pengajuanRepository->count_initiator();
//        $this->data['count_rejected'] = $this->pengajuanRepository->count_rejected();
        return view('master::admin.customer.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('master::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('master::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
