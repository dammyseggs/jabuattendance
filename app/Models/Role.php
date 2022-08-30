<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['name'];

    /**

     * Get the user that owns the role.

     */
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
