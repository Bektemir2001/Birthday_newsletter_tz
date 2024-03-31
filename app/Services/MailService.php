<?php

namespace App\Services;
use App\Jobs\SendMailJob;
use App\Repositories\MailingRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class MailService
{
    protected MailingRepository $mailingRepository;

    public function __construct(MailingRepository $mailingRepository)
    {
        $this->mailingRepository = $mailingRepository;
    }

    public function send(array $data): array
    {
        try {
            $customer_ids = explode(',', $data['customer_ids']);
            DB::beginTransaction();
            $mailing = $this->mailingRepository->createMailing($data, $customer_ids);
            SendMailJob::dispatch($mailing);
            DB::commit();
            return ['message' => 'success', 'status' => 200];
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return ['message' => $exception->getMessage(), 'status' => 500];
        }

    }
}
