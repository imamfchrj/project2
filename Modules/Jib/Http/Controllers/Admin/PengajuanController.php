<?php

namespace Modules\Jib\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Jib\Http\Controllers\JibController;
//use Modules\Jib\Http\Requests\Admin\PengajuanRequest;

use Modules\Jib\Repositories\Admin\Interfaces\PengajuanRepositoryInterface;

use App\Authorizable;

class PengajuanController extends JibController
{
    use Authorizable;

    private  $pengajuanRepository;

    public function __construct(PengajuanRepositoryInterface $pengajuanRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'pengajuan';

        $this->pengajuanRepository = $pengajuanRepository;

        $this->data['statuses'] = $this->pengajuanRepository->getStatuses();
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
                'created_at' => 'desc',
            ],
            'filter' => $params,
        ];

        $this->data['pengajuan'] = $this->pengajuanRepository->findAll($options);
//        dd($this->data['pengajuan']);
        $this->data['filter'] = $params;
        return view('jib::admin.pengajuan.index',$this->data);
    }

    public function trashed(Request $request)
    {
        $params = $request->all();

        $options = [
            'per_page' => $this->perPage,
            'order' => [
                'created_at' => 'desc',
            ],
            'filter' => $params,
        ];

        $this->data['viewTrash'] = true;
        $this->data['pengajuan'] = $this->pengajuanRepository->findAllInTrash($options);
        $this->data['filter'] = $params;
        return view('jib::admin.pengajuan.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('jib::create');
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
//        return view('jib::show');
        $this->data['pengajuan'] = $this->pengajuanRepository->findById($id);

        return view('jib::admin.pengajuan.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('jib::edit');
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
    public function destroy(Request $request,$id)
    {
        $permanentDelete = (bool)$request->get('_permanent_delete');

        if ($this->pengajuanRepository->delete($id, $permanentDelete)) {
            if ($permanentDelete) {
                return redirect('admin/jib/pengajuan/trashed')->with('success', __('jib::pengajuan.success_delete_message'));
            }

            return redirect('admin/jib/pengajuan')->with('success', __('jib::pengajuan.success_delete_message'));
        }

        return redirect('admin/jib/pengajuan')->with('error', __('jib::pengajuan.fail_delete_message'));
    }

    public function restore($id)
    {
        if ($this->pengajuanRepository->restore($id)) {
            return redirect('admin/jib/pengajuan/trashed')->with('success', __('jib::pengajuan.success_restore_message'));
        }

        return redirect('admin/jib/pengajuan/trashed')->with('error', __('jib::pengajuan.fail_restore_message'));
    }
}
