<?php

namespace Columbia;

use Illuminate\Notifications\Notifiable;
// use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    // protected $timestamps = false;

    use Notifiable;

    protected $fillable = [
        'name', 'last_name', 'email', 'telephone', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'deleted_at',
    ];

    public function vouchers()
    {
        return $this->belongsToMany('Columbia\Voucher')->using('Columbia\UserVoucher')->withPivot('created_at');
    }
}
