<?php

namespace App\Services;
use App\Jobs\SendMailJob;
use App\Repositories\MailingRepository;
use Carbon\Carbon;
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


    public function chart()
    {
        try {
            $startOfPeriod = Carbon::now()->subDays(6)->startOfDay();
            $endOfPeriod = Carbon::now()->endOfDay();
            $data = $this->mailingRepository->chartData($startOfPeriod, $endOfPeriod);
            $dates = [];
            $counts = [];
            while ($startOfPeriod <= $endOfPeriod) {
                $dateString = $startOfPeriod->toDateString();
                $record = $data->firstWhere('date', $dateString);
                $count = $record ? $record->count : 0;
                $dates[] = $dateString;
                $counts[] = $count;
                $startOfPeriod->addDay();
            }
            return ['dates' => $dates, 'counts' => $counts];
        }
        catch (Exception $exception)
        {
            dd($exception->getMessage());
        }

    }

    public function pie()
    {
        $data = $this->mailingRepository->pieData();
        return $data->toArray();
    }
}
