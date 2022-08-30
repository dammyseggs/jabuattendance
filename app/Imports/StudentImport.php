<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            "matric_no" => $row['Matric No'],
            "name" => $row['Surname'],
            "othername" => $row['Othername'],
            "stdlevel" => $row['Level'],
            "department_id" => $row['Department'],
            "acadsession_id" => $row['Session'],
        ]);
    }
}
