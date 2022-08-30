<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'staffid',
        'title',
        'name',
        'othername',
        'is_admin',
        'department_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $with = ['courses', 'lectures', 'department', 'roles'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    /********************************************************* */
        public function hasAnyRoles($roles){
            return $this->roles()->whereIn('name', $roles)->first() ? true : false;
        }

        public function hasRole($role){
            return $this->roles()->where('name', $role)->first() ? true : false;
        }
    /****************************************************************er */

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function courses(){
        return $this->belongsToMany(Course::class);
    }

    public function lectures(){
        return $this->belongsToMany(Lecture::class);
    }
}
