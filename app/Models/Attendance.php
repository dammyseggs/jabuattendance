<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'lecture_id',
        'student_id',
        'attend',
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
