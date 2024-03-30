<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailingRequest;
use App\Models\Mailing;
use App\Services\MailService;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MailingController extends Controller
{
    protected MailService $SMSService;

    public function __construct(MailService $SMSService)
    {
        $this->SMSService = $SMSService;
    }

    public function index(): View
    {
        $query = Mailing::query();
        $mails = $query->orderBy('created_at', 'DESC')->get();
        return view('admin.mails.index', compact('mails'));
    }

    public function store(MailingRequest $request): Response
    {
        $data = $request->validated();
        $result = $this->SMSService->send($data);
        return response(['message' => $result['message']])->setStatusCode($result['status']);
    }

}
