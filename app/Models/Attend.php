<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attend extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'attend',
        'student_id',
        'lecture_id',
        'attenddate_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $with = ['student', 'lecture', 'attenddate'];


    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function lecture(){
        return $this->belongsTo(Lecture::class);
    }

    public function attenddate(){
        return $this->belongsTo(Attenddate::class);
    }
}
