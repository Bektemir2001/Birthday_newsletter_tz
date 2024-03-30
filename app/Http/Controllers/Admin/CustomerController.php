<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UploadCustomerFileRequest;
use App\Models\Customer;
use App\Services\CustomerService;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(): View
    {
        $customers = Customer::all();
        return view('admin.customer.index', compact('customers'));
    }

    public function create(): View
    {
        return view('admin.customer.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $result = $this->customerService->store($data);
        return redirect()->route('customers.index')->with(['notification' => $result['message']]);
    }

    public function uploadCustomerFile(UploadCustomerFileRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $result = $this->customerService->storeWithFile($data['file']);
        return redirect()->route('customers.index')->with(['notification' => $result['message']]);

    }
}
