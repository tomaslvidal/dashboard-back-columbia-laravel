<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserVoucher extends Pivot
{
	
    // protected $touches = ['users', 'vouchers'];

    public $timestamps = false;

    // protected $guarded = [];

}
