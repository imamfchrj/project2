<?php

namespace Modules\Master\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Master\Http\Controllers\MasterController;
use Modules\Master\Http\Requests\Admin\PemeriksaRequest;

use Modules\Master\Repositories\Admin\Interfaces\PemeriksaRepositoryInterface;

use App\Authorizable;

class PemeriksaController extends MasterController
{
    use Authorizable;

    private  $pemeriksaRepository;

    public function __construct(PemeriksaRepositoryInterface $pemeriksaRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'pemeriksa';

        $this->pemeriksaRepository = $pemeriksaRepository;
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
        $this->data['pemeriksas'] = $this->pemeriksaRepository->findAll($options);
        $this->data['filter'] = $params;
        return view('master::admin.pemeriksa.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::admin.pemeriksa.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PemeriksaRequest $request)
    {
        $params = $request->validated();

        if ($this->pemeriksaRepository->create($params)) {
            return redirect('admin/master/pemeriksa')
                ->with('success', 'Pemeriksa has been created');
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
        $this->data['pemeriksa'] = $this->pemeriksaRepository->findById($id);
        return view('master::admin.pemeriksa.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(PemeriksaRequest $request, $id)
    {
        $params = $request->validated();
        $pemeriksa = $this->pemeriksaRepository->findById($id);

        if ($this->pemeriksaRepository->update($id, $params)) {
            return redirect('admin/master/pemeriksa')
                ->with('success', 'Pemeriksa has been Updated');
        }

        return redirect('admin/master/pemeriksa/'. $id .'/edit')
            ->with('error', 'Could not update the Pemeriksa');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        if ($this->pemeriksaRepository->delete($id)) {
            return redirect('admin/master/pemeriksa')
                ->with('success', 'Pemeriksa has been deleted.');
        }

        return redirect('admin/master/pemeriksa')->with('error', 'Could not delete the Pemeriksa.');
    }
}
