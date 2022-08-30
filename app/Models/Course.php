<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'coursename',
        'coursecode',
        'courselevel',
        'description',
        'department_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $with = ['department'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function lectures(){
        return $this->hasMany(Lecture::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
