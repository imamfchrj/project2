<?php

namespace Modules\Master\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Master\Http\Controllers\MasterController;
use Modules\Master\Http\Requests\Admin\SegmentRequest;

use Modules\Master\Repositories\Admin\Interfaces\SegmentRepositoryInterface;

use App\Authorizable;

class SegmentController extends MasterController
{
    use Authorizable;

    private  $segmentRepository;

    public function __construct(SegmentRepositoryInterface $segmentRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'segment';

        $this->segmentRepository = $segmentRepository;
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
        $this->data['segments'] = $this->segmentRepository->findAll($options);
        $this->data['filter'] = $params;
        return view('master::admin.segment.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::admin.segment.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(SegmentRequest $request)
    {
        $params = $request->validated();

        if ($this->segmentRepository->create($params)) {
            return redirect('admin/master/segment')
                ->with('success', 'Segment has been created');
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
        $this->data['segment'] = $this->segmentRepository->findById($id);
        return view('master::admin.segment.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(SegmentRequest $request, $id)
    {
        $params = $request->validated();
        $segment = $this->segmentRepository->findById($id);

        if ($this->segmentRepository->update($id, $params)) {
            return redirect('admin/master/segment')
                ->with('success', 'Segment has been Updated');
        }

        return redirect('admin/master/segment/'. $id .'/edit')
            ->with('error', 'Could not update the Segment');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        if ($this->segmentRepository->delete($id)) {
            return redirect('admin/master/segment')
                ->with('success', 'Segment has been deleted.');
        }

        return redirect('admin/master/segment')->with('error', 'Could not delete the Segment.');
    }
}
