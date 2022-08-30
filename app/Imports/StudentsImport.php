<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class StudentsImport implements ToModel
{
    use Importable;
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
