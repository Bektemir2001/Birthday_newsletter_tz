<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailingRequest;
use App\Models\Mailing;
use App\Services\MailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MailingController extends Controller
{
    protected MailService $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
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
        $result = $this->mailService->send($data);
        return response(['message' => $result['message']])->setStatusCode($result['status']);
    }

    public function stop(Mailing $mailing): RedirectResponse
    {
        $mailing->update(['status' => 2]);
        return back()->with(['notification' => "$mailing->name is stopped"]);
    }

    public function show(Mailing $mailing): View
    {
        return view('admin.mails.show', compact('mailing'));
    }

    public function chart(): Response
    {
        $result = $this->mailService->chart();
        return response(['data' => $result]);
    }

    public function pie(): Response
    {
        $result = $this->mailService->pie();
        return response(['data' => $result]);
    }

}
