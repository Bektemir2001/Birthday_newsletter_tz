<?php

namespace App\Services;
use App\Models\Mailing;
use Exception;

class MailService
{
    public function send(array $data): array
    {
        try {
            $customer_ids = explode(',', $data['customer_ids']);
            $query = Mailing::query();
            $query->create([
                'name' => $data['name'],
                'msg' => $data['msg'],
                'customer_ids' => json_encode($customer_ids)
            ]);
            return ['message' => 'success', 'status' => 200];
        }
        catch (Exception $exception)
        {
            return ['message' => $exception->getMessage(), 'status' => 500];
        }

    }
}
