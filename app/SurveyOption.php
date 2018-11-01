<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyOption extends Model
{
	use SoftDeletes;

    protected $table = 'survey_options';

    protected $primaryKey = 'id';

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function field()
    {
        return $this->belongsTo('Columbia\SurveyField');
    }

    // public function setNameAttribute($value)
    // {
    //     $this->attributes['name'] = ucfirst($value);
    // }
}