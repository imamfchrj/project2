<?php

namespace Modules\Master\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Master\Http\Controllers\MasterController;
use Modules\Master\Http\Requests\Admin\RisikoRequest;

use Modules\Master\Repositories\Admin\Interfaces\RisikoRepositoryInterface;

use App\Authorizable;

class RisikoController extends MasterController
{
    use Authorizable;

    private  $risikoRepository;

    public function __construct(RisikoRepositoryInterface $risikoRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'risiko';

        $this->risikoRepository = $risikoRepository;
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
        $this->data['risikos'] = $this->risikoRepository->findAll($options);
        $this->data['filter'] = $params;
        return view('master::admin.risiko.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::admin.risiko.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(RisikoRequest $request)
    {
        $params = $request->validated();

        if ($this->risikoRepository->create($params)) {
            return redirect('admin/master/risiko')
                ->with('success', 'Risiko has been created');
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
        $this->data['risiko'] = $this->risikoRepository->findById($id);
        return view('master::admin.risiko.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(RisikoRequest $request, $id)
    {
        $params = $request->validated();
        $risiko = $this->risikoRepository->findById($id);

        if ($this->risikoRepository->update($id, $params)) {
            return redirect('admin/master/risiko')
                ->with('success', 'Risiko has been Updated');
        }

        return redirect('admin/master/risiko/'. $id .'/edit')
            ->with('error', 'Could not update the Risiko');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        if ($this->risikoRepository->delete($id)) {
            return redirect('admin/master/risiko')
                ->with('success', 'Risiko has been deleted.');
        }

        return redirect('admin/master/risiko')->with('error', 'Could not delete the Risiko.');
    }
}
