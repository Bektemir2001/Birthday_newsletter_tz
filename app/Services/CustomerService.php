<?php

namespace App\Services;

use App\Models\Customer;
use Exception;
use Illuminate\Http\UploadedFile;

class CustomerService
{
    public function store(array $data): array
    {
        try {
            Customer::create($data);
            return ['message' => 'success'];
        }
        catch (Exception $exception)
        {
            return ['message' => $exception->getMessage()];
        }
    }

    public function storeWithFile(UploadedFile $file): array
    {
        try {
            if ($file->getSize() <= 2 * 1024 * 1024) {
                $contents = file_get_contents($file->path());
                $this->saveData($contents);
                return ['message' => 'success'];
            }
            else {
                throw new Exception('the file size should be no more than 2 MB');
            }
        }
        catch (Exception $exception)
        {
            return ['message' => $exception->getMessage()];
        }

    }

    public function saveData($contents): void
    {
        $parsedCsv = array_map('str_getcsv', explode("\n", $contents));
        if (count($parsedCsv[0]) == 3 &&
            $parsedCsv[0][0] == 'Телефон' &&
            $parsedCsv[0][1] == 'ФИО' &&
            $parsedCsv[0][2] == 'День рождения') {
            unset($parsedCsv[0]);
            foreach ($parsedCsv as $row) {
                if(count($row) != 3)
                {
                    continue;
                }
                $customer = new Customer();
                $customer->phone_number = $row[0];
                $customer->full_name = $row[1];
                $customer->birthday = $row[2];
                $customer->save();
            }

        }
        else {
            throw new Exception('incorrect format');
        }
    }
}
