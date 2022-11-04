<?php

namespace Modules\Master\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Master\Http\Controllers\MasterController;
use Modules\Master\Http\Requests\Admin\CustomerRequest;

use Modules\Master\Repositories\Admin\Interfaces\CustomerRepositoryInterface;

use App\Authorizable;

class CustomerController extends MasterController
{
    use Authorizable;

    private  $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        parent::__construct();
        $this->data['currentAdminMenu'] = 'customer';

        $this->customerRepository = $customerRepository;
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
        $this->data['customers'] = $this->customerRepository->findAll($options);
        $this->data['filter'] = $params;
        return view('master::admin.customer.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
//        return view('master::create');
        return view('master::admin.customer.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CustomerRequest $request)
    {
        $params = $request->validated();

        if ($this->customerRepository->create($params)) {
            return redirect('admin/master/customer')
                ->with('success', 'Customer has been created');
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
        $this->data['customer'] = $this->customerRepository->findById($id);
        return view('master::admin.customer.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CustomerRequest $request, $id)
    {
        $params = $request->validated();
        $customer = $this->customerRepository->findById($id);

        if ($this->customerRepository->update($id, $params)) {
            return redirect('admin/master/customer')
                ->with('success', 'Customer has been Updated');
        }

        return redirect('admin/master/customer/'. $id .'/edit')
            ->with('error', 'Could not update the Customer');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        if ($this->customerRepository->delete($id)) {
                return redirect('admin/master/customer')
                    ->with('success', 'Customer has been deleted.');
        }

        return redirect('admin/master/customer')->with('error', 'Could not delete the Customer.');
    }
}
