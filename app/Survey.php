<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
	use SoftDeletes;

    protected $table = 'survey';

    protected $primaryKey = 'id';

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany('Columbia\SurveyField');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }
}
