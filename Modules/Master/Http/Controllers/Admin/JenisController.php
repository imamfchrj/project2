<?php

namespace Modules\Master\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Master\Http\Controllers\MasterController;
use Modules\Master\Http\Requests\Admin\JenisRequest;

use Modules\Master\Repositories\Admin\Interfaces\JenisRepositoryInterface;

use App\Authorizable;

class JenisController extends MasterController
{
    use Authorizable;

    private  $jenisRepository;

    public function __construct(JenisRepositoryInterface $jenisRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'jenis';

        $this->jenisRepository = $jenisRepository;
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
        $this->data['jeniss'] = $this->jenisRepository->findAll($options);
        $this->data['filter'] = $params;
        return view('master::admin.jenis.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::admin.jenis.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(JenisRequest $request)
    {
        $params = $request->validated();

        if ($this->jenisRepository->create($params)) {
            return redirect('admin/master/jenis')
                ->with('success', 'Jenis has been created');
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
        $this->data['jenis'] = $this->jenisRepository->findById($id);
        return view('master::admin.jenis.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(JenisRequest $request, $id)
    {
        $params = $request->validated();
        $jenis = $this->jenisRepository->findById($id);

        if ($this->jenisRepository->update($id, $params)) {
            return redirect('admin/master/jenis')
                ->with('success', 'Jenis has been Updated');
        }

        return redirect('admin/master/jenis/'. $id .'/edit')
            ->with('error', 'Could not update the Jenis');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        if ($this->jenisRepository->delete($id)) {
            return redirect('admin/master/jenis')
                ->with('success', 'Jenis has been deleted.');
        }

        return redirect('admin/master/jenis')->with('error', 'Could not delete the Jenis.');
    }
}
