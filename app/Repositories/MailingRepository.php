<?php

namespace App\Repositories;

use App\Models\CustomerMail;
use App\Models\Mailing;
use Illuminate\Database\Eloquent\Model;


class MailingRepository
{
    public function createMailing(array $data, array $user_ids): Model
    {
        $mailing = Mailing::create([
            'name' => $data['name'],
            'msg' => $data['msg'],
        ]);

        $this->createCustomerMail($mailing, $user_ids);
        return $mailing;
    }

    public function createCustomerMail(Model $mailing, array $user_ids): void
    {
        foreach ($user_ids as $user_id)
        {
            $query = CustomerMail::query();
            $query->create([
                'customer_id' => $user_id,
                'mail_id' => $mailing->id
            ]);
        }
    }

    public function chartData($startOfPeriod, $endOfPeriod)
    {
        return CustomerMail::whereBetween('created_at', [$startOfPeriod, $endOfPeriod])
            ->where('status', CustomerMail::SENT)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function pieData()
    {
        return CustomerMail::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();
    }
}
