<?php

namespace Modules\Master\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Master\Http\Controllers\MasterController;
use Modules\Master\Http\Requests\Admin\KategoriRequest;

use Modules\Master\Repositories\Admin\Interfaces\KategoriRepositoryInterface;

use App\Authorizable;

class KategoriController extends MasterController
{
    use Authorizable;

    private  $kategoriRepository;

    public function __construct(KategoriRepositoryInterface $kategoriRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'kategori';

        $this->kategoriRepository = $kategoriRepository;
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
        $this->data['kategoris'] = $this->kategoriRepository->findAll($options);
        $this->data['filter'] = $params;
        return view('master::admin.kategori.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::admin.kategori.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(KategoriRequest $request)
    {
        $params = $request->validated();

        if ($this->kategoriRepository->create($params)) {
            return redirect('admin/master/kategori')
                ->with('success', 'Kategori has been created');
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
        $this->data['kategori'] = $this->kategoriRepository->findById($id);
        return view('master::admin.kategori.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(KategoriRequest $request, $id)
    {
        $params = $request->validated();
        $kategori = $this->kategoriRepository->findById($id);

        if ($this->kategoriRepository->update($id, $params)) {
            return redirect('admin/master/kategori')
                ->with('success', 'Kategori has been Updated');
        }

        return redirect('admin/master/kategori/'. $id .'/edit')
            ->with('error', 'Could not update the Kategori');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        if ($this->kategoriRepository->delete($id)) {
            return redirect('admin/master/kategori')
                ->with('success', 'Kategori has been deleted.');
        }

        return redirect('admin/master/kategori')->with('error', 'Could not delete the Kategori.');
    }
}
