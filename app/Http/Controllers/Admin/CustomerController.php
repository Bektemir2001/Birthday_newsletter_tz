<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UploadCustomerFileRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $customers = Customer::all();
        return view('admin.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customer.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $result = $this->customerService->store($data);
        return redirect()->route('customers.index')->with(['notification' => $result['message']]);
    }

    public function uploadCustomerFile(UploadCustomerFileRequest $request)
    {
        $data = $request->validated();
        $result = $this->customerService->storeWithFile($data['file']);

    }
}
