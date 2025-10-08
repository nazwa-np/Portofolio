<?php

namespace App\Imports;

use App\Models\Pts;
use Maatwebsite\Excel\Concerns\ToModel;

class PtsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Pts([
            //
        ]);
    }
}
