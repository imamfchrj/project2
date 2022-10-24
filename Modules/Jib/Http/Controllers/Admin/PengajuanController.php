<?php

namespace Modules\Jib\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

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

use App\Authorizable;

class PengajuanController extends JibController
{
    use Authorizable;

    private  $pengajuanRepository,
             $initiatorRepository,
             $segmentRepository,
             $customerRepository,
             $kategoriRepository,
             $reviewRepository,
             $pemeriksaRepository,
             $jenisRepository;

    public function __construct(PengajuanRepositoryInterface $pengajuanRepository,
                                InitiatorRepositoryInterface $initiatorRepository,
                                SegmentRepositoryInterface $segmentRepository,
                                CustomerRepositoryInterface $customerRepository,
                                KategoriRepositoryInterface $kategoriRepository,
                                ReviewRepositoryInterface $reviewRepository,
                                PemeriksaRepositoryInterface $pemeriksaRepository,
                                JenisRepositoryInterface $jenisRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'pengajuan';

        $this->pengajuanRepository = $pengajuanRepository;
        $this->initiatorRepository = $initiatorRepository;
        $this->segmentRepository = $segmentRepository;
        $this->customerRepository = $customerRepository;
        $this->kategoriRepository = $kategoriRepository;
        $this->jenisRepository = $jenisRepository;
        $this->pemeriksaRepository = $pemeriksaRepository;
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
        $this->data['pengajuan'] = $this->pengajuanRepository->findAll($options);
        $this->data['filter'] = $params;
        $this->data['segments'] = $this->segmentRepository->findAll()->pluck('name', 'id');
        $this->data['customers'] = $this->customerRepository->findAll()->pluck('name', 'id');
        $this->data['count_review'] = $this->pengajuanRepository->count_review();
        $this->data['count_approval'] = $this->pengajuanRepository->count_approval();
        $this->data['count_closed'] = $this->pengajuanRepository->count_closed();
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

    public function store_draft(PengajuanRequest $request)
    {
        $params = $request->validated();

        if ($pengajuan = $this->pengajuanRepository->create($params)) {

            return redirect('admin/jib/pengajuan')
                ->with('success', __('blog::pegnajuan.success_create_draf_message'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // $this->data['pengajuan'] = $this->pengajuanRepository->findById($id);
        // $this->data['notes'] = $this->reviewRepository->findByPengajuanId($id);

        $pengajuan = $this->pengajuanRepository->findById($id);
        $notes=$this->reviewRepository->findByPengajuanId($id);

        // if ($this->data['pengajuan']['pengajuan']->kategori_id == 1) {
        //     // return view('jib::admin.pengajuan.show_bisnis', $this->data);
        //     return view('jib::admin.pengajuan.show_bisnis', compact(['pengajuan','notes']));
        // } else {
        //     return view('jib::admin.pengajuan.show_support', $this->data);
        // }

        // dd($pengajuan);
        // $file_jib = $pengajuan['file_jib'];
        $this->data['pengajuan']=$pengajuan['pengajuan'];
        $this->data['notes'] = $this->reviewRepository->findByPengajuanId($id);
        $this->data['file_jib'] = $pengajuan['file_jib'];

        if ($this->data['pengajuan']->kategori_id == 1) {
            // BISNIS CAPEX
            if ($this->data['pengajuan']->jenis_id == 1) {
                return view('jib::admin.pengajuan.show_bisnis', $this->data);
            // BISNIS OPEX
            }else {
                return view('jib::admin.pengajuan.show_bisnis_opex', $this->data);
            }
        } else {
            return view('jib::admin.pengajuan.show_support', $this->data);
        }

    }

   public function download($uid)
   {
       # code...
        $filedownload = Media::where('uuid',$uid)->first();
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
