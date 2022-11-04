<?php

namespace Modules\Master\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Master\Http\Controllers\MasterController;
use Modules\Master\Http\Requests\Admin\KesimpulanRequest;

use Modules\Master\Repositories\Admin\Interfaces\KesimpulanRepositoryInterface;

use App\Authorizable;

class KesimpulanController extends MasterController
{
    use Authorizable;

    private  $kesimpulanRepository;

    public function __construct(KesimpulanRepositoryInterface $kesimpulanRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'kesimpulan';

        $this->kesimpulanRepository = $kesimpulanRepository;
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
        $this->data['kesimpulans'] = $this->kesimpulanRepository->findAll($options);
        $this->data['filter'] = $params;
        return view('master::admin.kesimpulan.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::admin.kesimpulan.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(KesimpulanRequest $request)
    {
        $params = $request->validated();

        if ($this->kesimpulanRepository->create($params)) {
            return redirect('admin/master/kesimpulan')
                ->with('success', 'Kesimpulan has been created');
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
        $this->data['kesimpulan'] = $this->kesimpulanRepository->findById($id);
        return view('master::admin.kesimpulan.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(KesimpulanRequest $request, $id)
    {
        $params = $request->validated();
        $kesimpulan = $this->kesimpulanRepository->findById($id);

        if ($this->kesimpulanRepository->update($id, $params)) {
            return redirect('admin/master/kesimpulan')
                ->with('success', 'Kesimpulan has been Updated');
        }

        return redirect('admin/master/kesimpulan/'. $id .'/edit')
            ->with('error', 'Could not update the Kesimpulan');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        if ($this->kesimpulanRepository->delete($id)) {
            return redirect('admin/master/kesimpulan')
                ->with('success', 'Kesimpulan has been deleted.');
        }

        return redirect('admin/master/kesimpulan')->with('error', 'Could not delete the Kesimpulan.');
    }
}
