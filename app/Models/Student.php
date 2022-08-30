<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'matric_no',
        'name',
        'othername',
        'stdlevel',
        'department_id',
        'acadsession_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $with = ['department'];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function acadsession(){
        return $this->belongsTo(Acadsession::class);
    }

    public function lectures(){
        return $this->belongsToMany(Lecture::class);
    }

    public function attends(){
        return $this->hasMany(Attend::class);
    }

    public function markattendances(){
        return $this->hasMany(Markattendance::class);
    }
}
