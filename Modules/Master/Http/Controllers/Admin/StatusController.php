<?php

namespace Modules\Master\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Master\Http\Controllers\MasterController;
use Modules\Master\Http\Requests\Admin\StatusRequest;

use Modules\Master\Repositories\Admin\Interfaces\StatusRepositoryInterface;

use App\Authorizable;

class StatusController extends MasterController
{
    use Authorizable;

    private  $statusRepository;

    public function __construct(StatusRepositoryInterface $statusRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'status';

        $this->statusRepository = $statusRepository;
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
        $this->data['statuss'] = $this->statusRepository->findAll($options);
        $this->data['filter'] = $params;
        return view('master::admin.status.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::admin.status.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(StatusRequest $request)
    {
        $params = $request->validated();

        if ($this->statusRepository->create($params)) {
            return redirect('admin/master/status')
                ->with('success', 'Status has been created');
        }
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
        $this->data['status'] = $this->statusRepository->findById($id);
        return view('master::admin.status.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(StatusRequest $request, $id)
    {
        $params = $request->validated();
        $status = $this->statusRepository->findById($id);

        if ($this->statusRepository->update($id, $params)) {
            return redirect('admin/master/status')
                ->with('success', 'Status has been Updated');
        }

        return redirect('admin/master/status/'. $id .'/edit')
            ->with('error', 'Could not update the Status');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        if ($this->statusRepository->delete($id)) {
            return redirect('admin/master/status')
                ->with('success', 'Status has been deleted.');
        }

        return redirect('admin/master/status')->with('error', 'Could not delete the Status.');
    }
}
