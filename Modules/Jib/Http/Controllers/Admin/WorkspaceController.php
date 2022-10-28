<?php

namespace Modules\Jib\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Jib\Http\Requests\Admin\PersetujuanRequest;
use Modules\Jib\Http\Requests\Admin\MomRequest;

use Modules\Jib\Http\Controllers\JibController;

use Modules\Jib\Repositories\Admin\Interfaces\PengajuanRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\SegmentRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\CustomerRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\ReviewRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\PersetujuanRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\MomRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\KesimpulanRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\RisikoRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\AnggaranRepositoryInterface;

use App\Authorizable;

class WorkspaceController extends JibController
{
    use Authorizable;

    private  $pengajuanRepository,
        $segmentRepository,
        $customerRepository,
        $reviewRepository,
        $persetujuanRepository,
        $momRepository,
        $kesimpulanRepository,
        $risikoRepository,
        $anggaranRepository;

    public function __construct(PengajuanRepositoryInterface $pengajuanRepository,
                                SegmentRepositoryInterface $segmentRepository,
                                CustomerRepositoryInterface $customerRepository,
                                ReviewRepositoryInterface $reviewRepository,
                                PersetujuanRepositoryInterface $persetujuanRepository,
                                MomRepositoryInterface $momRepository,
                                KesimpulanRepositoryInterface $kesimpulanRepository,
                                RisikoRepositoryInterface $risikoRepository,
                                AnggaranRepositoryInterface $anggaranRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'workspace';

        $this->pengajuanRepository = $pengajuanRepository;
        $this->segmentRepository = $segmentRepository;
        $this->customerRepository = $customerRepository;
        $this->reviewRepository = $reviewRepository;
        $this->persetujuanRepository = $persetujuanRepository;
        $this->momRepository = $momRepository;
        $this->kesimpulanRepository = $kesimpulanRepository;
        $this->risikoRepository = $risikoRepository;
        $this->anggaranRepository = $anggaranRepository;

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
        $pengajuan = $this->pengajuanRepository->findById($id);
        $this->data['pengajuan'] = $pengajuan['pengajuan'];
        $this->data['file_jib'] = $pengajuan['file_jib'];
        $this->data['persetujuan'] = $this->persetujuanRepository->findAllbyPengId($id);
        $this->data['persetujuan_id'] = $this->persetujuanRepository->findbyPengId($id);
        $this->data['mom'] = $this->momRepository->findAllbyPengId($id);
        $this->data['mom_id'] = $this->momRepository->findbyPengId($id);

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
        $pengajuan = $this->pengajuanRepository->findById($id);
        $this->data['pengajuan'] = $pengajuan['pengajuan'];
        $this->data['file_jib'] = $pengajuan['file_jib'];
        $this->data['kesimpulan'] = $this->kesimpulanRepository->findAll()->pluck('name', 'id');
        $this->data['kesimpulan_id'] = null;
        $this->data['risiko'] = $this->risikoRepository->findAll()->pluck('name', 'id');
        $this->data['risiko_id'] = null;

        // BISNIS CAPEX
        if ($this->data['pengajuan']->kategori_id == 1 && $this->data['pengajuan']->jenis_id == 1) {
            return view('jib::admin.workspace.createform_bisnis_capex', $this->data);
        // BISNIS OPEX
        } elseif ($this->data['pengajuan']->kategori_id == 1 && $this->data['pengajuan']->jenis_id == 2) {
            return view('jib::admin.workspace.createform_bisnis_opex', $this->data);
        // SUPPORT CAPEX/OPEX
        } else {
            return view('jib::admin.workspace.createform_support', $this->data);
        }
    }

    public function editform($id)
    {
        $this->data['persetujuan'] = $this->persetujuanRepository->findById($id);
        $pengajuan_id = $this->data['persetujuan']->pengajuan_id;
        $pengajuan = $this->pengajuanRepository->findById($pengajuan_id);
        $this->data['pengajuan'] = $pengajuan['pengajuan'];
        $this->data['file_jib'] = $pengajuan['file_jib'];
        $this->data['kesimpulan'] = $this->kesimpulanRepository->findAll()->pluck('name', 'id');
        $this->data['kesimpulan_id'] = null;
        $this->data['risiko'] = $this->risikoRepository->findAll()->pluck('name', 'id');
        $this->data['risiko_id'] = null;

        // BISNIS CAPEX
        if ($this->data['pengajuan']->kategori_id == 1 && $this->data['pengajuan']->jenis_id == 1) {
            return view('jib::admin.workspace.createform_bisnis_capex', $this->data);
            // BISNIS OPEX
        } elseif ($this->data['pengajuan']->kategori_id == 1 && $this->data['pengajuan']->jenis_id == 2) {
            return view('jib::admin.workspace.createform_bisnis_opex', $this->data);
            // SUPPORT CAPEX/OPEX
        } else {
            return view('jib::admin.workspace.createform_support', $this->data);
        }
    }

    public function storeform(PersetujuanRequest $request)
    {
        $params = $request->validated();

        if ($persetujuan = $this->persetujuanRepository->create($params)) {
            return redirect('admin/jib/workspace/'.$params['pengajuan_id'].'/editworkspace')
                ->with('success', __('blog::pengajuan.success_create_message'));
        }

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function updateform(PersetujuanRequest $request, $id)
    {
        $params = $request->validated();
        $persetujuan = $this->persetujuanRepository->findById($id);

        if ($this->persetujuanRepository->update($id, $params)) {
            return redirect('admin/jib/workspace/'.$params['pengajuan_id'].'/editworkspace')
                ->with('success', __('jib::pengajuan.success_create_message'));
        }

        return redirect('admin/jib/workspace/'.$params['pengajuan_id'].'/editworkspace')
            ->with('error', __('jib::pengajuan.fail_update_message'));
    }

    public function createmom($id)
    {
        $pengajuan = $this->pengajuanRepository->findById($id);
        $this->data['pengajuan'] = $pengajuan['pengajuan'];
        $this->data['file_jib'] = $pengajuan['file_jib'];

        $this->data['anggaran'] = $this->anggaranRepository->findAll()->pluck('name', 'id');
        $this->data['anggaran_id'] = null;

        return view('jib::admin.workspace.createform_mom', $this->data);

    }

    public function editmom($id)
    {
        $this->data['mom'] = $this->momRepository->findById($id);
        $pengajuan_id = $this->data['mom']->pengajuan_id;
        $pengajuan = $this->pengajuanRepository->findById($pengajuan_id);
        $this->data['pengajuan'] = $pengajuan['pengajuan'];
        $this->data['file_jib'] = $pengajuan['file_jib'];
        $this->data['anggaran'] = $this->anggaranRepository->findAll()->pluck('name', 'id');
        $this->data['anggaran_id'] = null;

        return view('jib::admin.workspace.createform_mom', $this->data);
    }

    public function storemom(MomRequest $request)
    {
        $params = $request->validated();

        if ($mom = $this->momRepository->create($params)) {
            return redirect('admin/jib/workspace/'.$params['pengajuan_id'].'/editworkspace')
                ->with('success', __('blog::pegnajuan.success_create_message'));
        }

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function updatemom(MomRequest $request, $id)
    {
        $params = $request->validated();
        $mom = $this->momRepository->findById($id);

        if ($this->momRepository->update($id, $params)) {
            return redirect('admin/jib/workspace/'.$params['pengajuan_id'].'/editworkspace')
                ->with('success', __('jib::pengajuan.success_create_message'));
        }

        return redirect('admin/jib/workspace/'.$params['pengajuan_id'].'/editworkspace')
            ->with('error', __('jib::pengajuan.fail_update_message'));
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
