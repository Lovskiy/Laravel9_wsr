<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $guarded = false;

    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'status',
        'login',
        'photo_file',
        'password',
        'role_id',
        'user_token',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = false;

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function workShift()
    {
        return $this->belongsTo(WorkShift::class, 'user_id' , 'id');
    }


}
