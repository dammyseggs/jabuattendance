<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Markattendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'student_id',
        'attenddate_id',
        'lecture_id',
        'attend',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    //protected $with = ['students'];

    /**

     * Get the user that owns the role.

     */
    public function students()
    {
        return $this->belongsTo(Student::class);
    }

    public function attenddate()
    {
        return $this->belongsTo(Attenddate::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
