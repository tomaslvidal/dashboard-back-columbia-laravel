<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    protected $table = 'user_voucher';

    protected $primaryKey = 'id';

    // protected $timestamps = false;

    protected $guarded = [];
}
