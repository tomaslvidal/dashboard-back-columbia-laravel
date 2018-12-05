<?php

namespace Columbia;

use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Laravel\Passport\HasApiTokens;

// use Columbia\Events\UserDeleting;

// use Columbia\Events\UserRestored;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'last_name', 'email', 'telephone', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'deleted_at',
    ];

    protected $dispatchesEvents = [
        // 'deleting' => UserDeleting::class,
        // 'restored' => UserRestored::class
    ];

    public function vouchers()
    {
        return $this->belongsToMany('Columbia\Voucher')->using('Columbia\UserVoucher')->withPivot('created_at');
    }

    public function surveysMade()
    {
        return $this->hasMany('Columbia\SurveyMade');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }

    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }
}
