<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
	use SoftDeletes;
	
    protected $table = 'destinations';

    protected $primaryKey = 'id';

    protected $dates = ['deleted_at'];

    // protected $timestamps = false;

    protected $guarded = [];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucfirst($value);
    }

    public function setSubtitleAttribute($value)
    {
        $this->attributes['subtitle'] = ucfirst($value);
    }
}
