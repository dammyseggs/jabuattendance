<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'course_id',
        'acadsession_id',
        'department_id',
        'addinfo',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $with = ['course', 'acadsession', 'students'];



    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function acadsession()
    {
        return $this->belongsTo(Acadsession::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function students(){
        return $this->belongsToMany(Student::class);
    }

    public function attenddates(){
        return $this->hasMany(Attenddate::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function attends(){
        return $this->hasMany(Attend::class);
    }
}
