<?php

namespace App\Services;

use App\Models\Customer;
use Exception;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;


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
                $spreadsheet = IOFactory::load($file->path());
                $contents = $this->readSpreadsheet($spreadsheet);
                $this->saveData($contents);
                return ['message' => 'success'];
            } else {
                throw new Exception('the file size should be no more than 2 MB');
            }
        } catch (Exception $exception) {
            return ['message' => $exception->getMessage()];
        }
    }

    public function readSpreadsheet($spreadsheet): array
    {
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $header = [];

        // Чтение заголовков
        for ($col = 'A'; $col <= $highestColumn; $col++) {
            $header[] = $sheet->getCell($col . '1')->getValue();
        }

        $requiredFields = ['фио', 'телефон', 'день рождения', 'почта'];
        $headerLowercase = array_map('mb_strtolower', $header);
        $requiredFieldsLowercase = array_map('mb_strtolower', $requiredFields);
        $foundFields = array_intersect($headerLowercase, $requiredFieldsLowercase);
        if (count($foundFields) < 3) {
            throw new Exception("Required fields are 'фио', 'телефон', 'день рождения', 'почта'");
        }

        // Получаем индексы полей ФИО, Телефон, День рождения, Почта
        $fieldIndexes = [];
        foreach ($requiredFieldsLowercase as $field) {
            $fieldIndexes[$field] = array_search($field, $headerLowercase);
        }

        $contents = [];
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = [];
            foreach ($fieldIndexes as $field => $index) {
                $cellAddress = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1) . $row;
                $cellValue = $sheet->getCell($cellAddress)->getValue(); // Получение значения ячейки
                $rowData[$field] = $cellValue !== null ? $cellValue : '';
            }
            $contents[] = $rowData;
        }

        return $contents;
    }




    public function saveData($contents): void
    {
        foreach ($contents as $row) {
            $customer = new Customer();
            $customer->full_name = $row['фио'];
            $customer->phone_number = $row['телефон'];
            $customer->email = $row['почта'];
            $customer->birthday = $row['день рождения'];
            $customer->save();
        }
    }
}
