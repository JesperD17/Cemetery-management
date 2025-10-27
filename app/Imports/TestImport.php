<?php

namespace App\Imports;

use App\Models\Test;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TestImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // dd($row);
        return new Test([
            'test' => $row["test"],
            'data' => $row["data"],
        ]);
    }

    public function headingRow()
    {
        return 1;
    }
}
