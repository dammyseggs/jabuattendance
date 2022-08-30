<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'college_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $with = ['college'];


    
    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function students(){
        return $this->hasMany(Student::class);
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }

    public function lectures(){
        return $this->hasMany(Lecture::class);
    }
}
