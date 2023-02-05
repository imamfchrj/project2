<?php

namespace Modules\Jib\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Jib\Entities\Mcustomer;
use Modules\Jib\Http\Controllers\JibController;
use Modules\Jib\Http\Requests\Admin\PengajuanRequest;

use Modules\Jib\Repositories\Admin\Interfaces\PengajuanRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\InitiatorRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\SegmentRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\CustomerRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\KategoriRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\JenisRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\PemeriksaRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\ReviewRepositoryInterface;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;
use Modules\Jib\Repositories\Admin\Interfaces\PersetujuanRepositoryInterface;
use Modules\Jib\Repositories\Admin\Interfaces\MomRepositoryInterface;

use App\Authorizable;

use App\Exports\JibExport;
use App\Imports\JibImport;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Jib\Entities\Pengajuan;

class PengajuanController extends JibController
{
    use Authorizable;

    private $pengajuanRepository,
        $initiatorRepository,
        $segmentRepository,
        $customerRepository,
        $kategoriRepository,
        $reviewRepository,
        $pemeriksaRepository,
        $jenisRepository,
        $persetujuanRepository,
        $momRepository;

    public function __construct(
        PengajuanRepositoryInterface $pengajuanRepository,
        InitiatorRepositoryInterface $initiatorRepository,
        SegmentRepositoryInterface $segmentRepository,
        CustomerRepositoryInterface $customerRepository,
        KategoriRepositoryInterface $kategoriRepository,
        ReviewRepositoryInterface $reviewRepository,
        PemeriksaRepositoryInterface $pemeriksaRepository,
        JenisRepositoryInterface $jenisRepository,
        PersetujuanRepositoryInterface $persetujuanRepository,
        MomRepositoryInterface $momRepository
    ) {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'list pengajuan';

        $this->pengajuanRepository = $pengajuanRepository;
        $this->initiatorRepository = $initiatorRepository;
        $this->segmentRepository = $segmentRepository;
        $this->customerRepository = $customerRepository;
        $this->kategoriRepository = $kategoriRepository;
        $this->jenisRepository = $jenisRepository;
        $this->pemeriksaRepository = $pemeriksaRepository;
        $this->reviewRepository = $reviewRepository;
        $this->persetujuanRepository = $persetujuanRepository;
        $this->momRepository = $momRepository;

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
            'per_page' => 30,
            'order' => [
                'id' => 'desc',
            ],
            'filter' => $params,
        ];
        $this->data['pengajuan'] = $this->pengajuanRepository->findAll($options);
        $this->data['filter'] = $params;
        $this->data['segments'] = $this->segmentRepository->findAll()->pluck('name', 'id');
        $this->data['customers'] = $this->customerRepository->findAll()->pluck('name', 'id');
        $this->data['count_review'] = $this->pengajuanRepository->count_review();
        $this->data['count_approval'] = $this->pengajuanRepository->count_approval();
        $this->data['count_closed'] = $this->pengajuanRepository->count_closed();
        $this->data['count_draft'] = $this->pengajuanRepository->count_draft();
        $this->data['count_initiator'] = $this->pengajuanRepository->count_initiator();
        $this->data['count_rejected'] = $this->pengajuanRepository->count_rejected();
        return view('jib::admin.pengajuan.index', $this->data);
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
        $this->data['segments'] = $this->segmentRepository->findAll()->pluck('name', 'id');
        $this->data['customers'] = $this->customerRepository->findAll()->pluck('name', 'id');
        return view('jib::admin.pengajuan.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        //        $this->data['permissions'] = $this->permissionRepository->findAll();
        //        $this->data['roles'] = $this->roleRepository->findAll()->pluck('name', 'id');
        //        $this->data['roleId'] = null;
        $this->data['initiator'] = $this->initiatorRepository->findByUserId();
        $this->data['initiatorAll'] = $this->initiatorRepository->findAllByUserId()->pluck('nama_sub_unit', 'id');
        $this->data['segment'] = $this->segmentRepository->findAll()->pluck('name', 'id');
        $this->data['segment_id'] = null;
        $this->data['customer'] = $this->customerRepository->findAll()->pluck('name', 'id');
        $this->data['customer_id'] = null;
        $this->data['kategori'] = $this->kategoriRepository->findAll()->pluck('name', 'id');
        $this->data['kategori_id'] = null;
        $this->data['jenis'] = $this->jenisRepository->findAll()->pluck('name', 'id');
        $this->data['jenis_id'] = null;
        $this->data['pemeriksa'] = $this->pemeriksaRepository->findAll();
        return view('jib::admin.pengajuan.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PengajuanRequest $request)
    {
        $params = $request->validated();

        if ($pengajuan = $this->pengajuanRepository->create($params)) {
            //            $pemeriksa = $this->pemeriksaRepository->create();
            return redirect('admin/jib/pengajuan')
                ->with('success', __('blog::pegnajuan.success_create_message'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $pengajuan = $this->pengajuanRepository->findById($id);

        $this->data['pengajuan'] = $pengajuan['pengajuan'];
        $this->data['file_jib'] = $pengajuan['file_jib'];
        $this->data['notes'] = $this->reviewRepository->findByPengajuanId($id);

        $persetujuan = $this->persetujuanRepository->findAllbyPengId($id);
        $this->data['persetujuan'] = $persetujuan['persetujuan'];
        $this->data['file_approval'] = $persetujuan['file_approval'];

        $mom = $this->momRepository->findAllbyPengId($id);
        $this->data['mom'] = $mom['mom'];
        $this->data['file_mom'] = $mom['file_mom'];

        if ($this->data['pengajuan']->kategori_id == 1) {
            // BISNIS CAPEX
            if ($this->data['pengajuan']->jenis_id == 1) {
                return view('jib::admin.pengajuan.show_bisnis', $this->data);
                // BISNIS OPEX
            } else {
                return view('jib::admin.pengajuan.show_bisnis_opex', $this->data);
            }
        } else {
            return view('jib::admin.pengajuan.show_support', $this->data);
        }
    }

    public function download($uid)
    {
        # code...
        $filedownload = Media::where('uuid', $uid)->first();
        return response()->download($filedownload->getPath());
    }

    public function down(Media $mediaItem)
    {
        return $mediaItem;
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
    public function update(PengajuanRequest $request)
    {
        // dd($request);
        $params = $request->validated();
        // dd($params);
        if ($pengajuan = $this->pengajuanRepository->update($params)) {
            return redirect('admin/jib/pengajuan')
                ->with('success', __('blog::pegnajuan.success_update_message'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
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

    public function findcustomername($id)
    {
        $data_cust = Mcustomer::select('name', 'id')->where('segment_id', $id)->get();
        //        $data_cust = Mcustomer::all();
        return response()->json($data_cust);
    }

    public function jibexport()
    {
        // return Excel::download(new JibExport, 'JIB.xlsx');
        ob_end_clean();
        ob_start();

        return Excel::download(new JibExport, 'JIB-Online_' . date('Y-m-d H-i-s') . '.xlsx');
    }

    public function jibImport(PengajuanRequest $request)
    {
        # code...
        $this->data['currentAdminMenu'] = 'list pengajuan realisasi';

        $params = $request->all();
        $options = [
            'per_page' => 30,
            'order' => [
                'id' => 'desc',
            ],
            'filter' => $params,
        ];

        $pengajuan = $this->pengajuanRepository->findAll($options);

        $this->data['pengajuan'] = $pengajuan['pengajuan'];
        $this->data['filter'] = $params;

        $this->data['file_realisasi'] = $pengajuan['file_realisasi'];

        return view('jib::admin.pengajuan.import_form', $this->data);
    }

    public function realisasi_upload(Request $request)
    {
        $params = $request->validate([
            'file_realisasi' => 'required|mimes:xlsx',
         ]);

        if ($this->pengajuanRepository->jibImport($params)) {
            return redirect('admin/jib/realisasi')
                ->with('success', 'The file has been imported');
        }
        
    }
}
