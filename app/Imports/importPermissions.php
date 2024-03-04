<?php

namespace App\Imports;

use App\Models\Permission;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportPermissions implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Permission([
            'name' => $row[1],
            'guard_name' => $row[2],
        ]);
    }
}
