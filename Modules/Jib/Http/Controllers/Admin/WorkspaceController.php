<?php

namespace Modules\Jib\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Jib\Http\Controllers\JibController;

use Modules\Jib\Repositories\Admin\Interfaces\PengajuanRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\SegmentRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\CustomerRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\ReviewRepositoryInterface;

use App\Authorizable;

class WorkspaceController extends JibController
{
    use Authorizable;

    private  $pengajuanRepository,
        $segmentRepository,
        $customerRepository,
        $reviewRepository;

    public function __construct(PengajuanRepositoryInterface $pengajuanRepository,
                                SegmentRepositoryInterface $segmentRepository,
                                CustomerRepositoryInterface $customerRepository,
                                ReviewRepositoryInterface $reviewRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'workspace';

        $this->pengajuanRepository = $pengajuanRepository;
        $this->segmentRepository = $segmentRepository;
        $this->customerRepository = $customerRepository;
        $this->reviewRepository = $reviewRepository;

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
                'id' => 'asc',
            ],
            'filter' => $params,
        ];
        $this->data['pengajuan'] = $this->pengajuanRepository->findAllWorkspace($options);
        $this->data['filter'] = $params;
        $this->data['segments'] = $this->segmentRepository->findAll()->pluck('name', 'id');
        $this->data['customers'] = $this->customerRepository->findAll()->pluck('name', 'id');
        return view('jib::admin.workspace.index',$this->data);
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
        return view('jib::show');
    }

    public function editworkspace($id)
    {
        $this->data['pengajuan'] = $this->pengajuanRepository->findById($id);
        $this->data['notes'] = $this->reviewRepository->findByPengajuanId($id);

        // BISNIS CAPEX
        if ($this->data['pengajuan']->kategori_id == 1 && $this->data['pengajuan']->jenis_id == 1) {
            return view('jib::admin.workspace.edit_bisnis', $this->data);
        // BISNIS OPEX
        } elseif ($this->data['pengajuan']->kategori_id == 1 && $this->data['pengajuan']->jenis_id == 2) {
            return view('jib::admin.workspace.edit_bisnis_opex', $this->data);
        // SUPPORT CAPEX/OPEX
        } else {
            return view('jib::admin.workspace.edit_support', $this->data);
        }
    }

    public function createform($id)
    {
        $this->data['pengajuan'] = $this->pengajuanRepository->findById($id);
        $this->data['notes'] = $this->reviewRepository->findByPengajuanId($id);

        // BISNIS CAPEX
        if ($this->data['pengajuan']->kategori_id == 1 && $this->data['pengajuan']->jenis_id == 1) {
            return view('jib::admin.workspace.edit_bisnis', $this->data);
            // BISNIS OPEX
        } elseif ($this->data['pengajuan']->kategori_id == 1 && $this->data['pengajuan']->jenis_id == 2) {
            return view('jib::admin.workspace.edit_bisnis_opex', $this->data);
            // SUPPORT CAPEX/OPEX
        } else {
            return view('jib::admin.workspace.edit_support', $this->data);
        }
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
