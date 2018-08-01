<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $primaryKey = 'id';

    // protected $timestamps = false;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany('Columbia\User')->using('Columbia\UserVoucher')->withPivot('created_at');
    }
}
