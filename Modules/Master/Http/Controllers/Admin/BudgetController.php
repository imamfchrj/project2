<?php

namespace Modules\Master\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Master\Http\Controllers\MasterController;
use Modules\Master\Http\Requests\Admin\BudgetRequest;

use Modules\Master\Repositories\Admin\Interfaces\BudgetRepositoryInterface;

use App\Authorizable;
use App\Exports\BudgetExport;
use Datatables;
use Modules\Master\Entities\Mbudgetrkap;
use Maatwebsite\Excel\Facades\Excel;


class BudgetController extends MasterController
{
    use Authorizable;

    private  $anggaranRepository;

    public function __construct(BudgetRepositoryInterface $anggaranRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'budget';

        $this->anggaranRepository = $anggaranRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            return datatables()->of(Mbudgetrkap::all())
                ->addColumn('action', 'companies.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('master::admin.budget.index', $this->data);
    }

    public function download()
    {
        # code...
        ob_end_clean(); 
        ob_start(); 
        
        return Excel::download(new BudgetExport, 'Budget-JIB-Online_'.date('Y-m-d H-i-s').'.xlsx');
    }

    public function upload()
    {
        # code...
        return view('master::admin.budget._form-upload', $this->data);
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
    public function store(BudgetRequest $request)
    {
        $params = $request->validated();

        if ($this->anggaranRepository->create($params)) {
            return redirect('admin/master/budget')
                ->with('success', 'Budget has been created');
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
    public function update(BudgetRequest $request, $id)
    {
        $params = $request->validated();
        $anggaran = $this->anggaranRepository->findById($id);

        if ($this->anggaranRepository->update($id, $params)) {
            return redirect('admin/master/budget')
                ->with('success', 'Anggaran has been Updated');
        }

        return redirect('admin/master/budget/' . $id . '/edit')
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
            return redirect('admin/master/budget')
                ->with('success', 'Anggaran has been deleted.');
        }

        return redirect('admin/master/budget')->with('error', 'Could not delete the Anggaran.');
    }
}
