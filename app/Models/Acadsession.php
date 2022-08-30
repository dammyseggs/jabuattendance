<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acadsession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'current',
    ];

    public function students(){
        return $this->hasMany(Student::class);
    }

    public function lectures(){
        return $this->hasMany(Lecture::class);
    }
}
