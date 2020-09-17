<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_expiry' => 'datetime',
    ];

    public function path()
    {
        return "/users/{$this->id}";
    }

    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_token = rand(100000, 999999);
        $this->two_factor_expiry = now()->addMinutes(10);
        $this->save();
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_token = null;
        $this->two_factor_expiry = null;
        $this->save();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
