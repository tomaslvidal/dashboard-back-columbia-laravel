<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $table = 'destinations';

    protected $primaryKey = 'id';

    // protected $timestamps = false;

    protected $guarded = [];
}
