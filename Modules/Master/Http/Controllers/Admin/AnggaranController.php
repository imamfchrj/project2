<?php

namespace Modules\Master\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Master\Entities\Manggaran;
use Modules\Master\Http\Controllers\MasterController;
use Modules\Master\Http\Requests\Admin\AnggaranRequest;

use Modules\Master\Repositories\Admin\Interfaces\AnggaranRepositoryInterface;

use App\Authorizable;

class AnggaranController extends MasterController
{
    use Authorizable;

    private $anggaranRepository;

    public function __construct(AnggaranRepositoryInterface $anggaranRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'anggaran';

        $this->anggaranRepository = $anggaranRepository;
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
        $this->data['anggarans'] = $this->anggaranRepository->findAll($options);
        $this->data['filter'] = $params;
        return view('master::admin.anggaran.index', $this->data);
    }

    public function list_anggaran()
    {
        $query = Manggaran::orderBy('name', 'asc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('opsi', function ($data) {
                return '<span>Edit</span> | <span class="text-danger">Delete</span>';
            })
            ->rawColumns(['opsi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::admin.anggaran.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AnggaranRequest $request)
    {
        $params = $request->validated();

        if ($this->anggaranRepository->create($params)) {
            return redirect('admin/master/anggaran')
                ->with('success', 'Anggaran has been created');
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
        $this->data['anggaran'] = $this->anggaranRepository->findById($id);
        return view('master::admin.anggaran.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AnggaranRequest $request, $id)
    {
        $params = $request->validated();
        $anggaran = $this->anggaranRepository->findById($id);

        if ($this->anggaranRepository->update($id, $params)) {
            return redirect('admin/master/anggaran')
                ->with('success', 'Anggaran has been Updated');
        }

        return redirect('admin/master/anggaran/' . $id . '/edit')
            ->with('error', 'Could not update the Anggaran');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        if ($this->anggaranRepository->delete($id)) {
            return redirect('admin/master/anggaran')
                ->with('success', 'Anggaran has been deleted.');
        }

        return redirect('admin/master/anggaran')->with('error', 'Could not delete the Anggaran.');
    }
}
