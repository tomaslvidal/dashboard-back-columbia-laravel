<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyField extends Model
{
	use SoftDeletes;

    protected $table = 'survey_fields';

    protected $primaryKey = 'id';

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function survey()
    {
        return $this->belongsTo('Columbia\Survey');
    }

    public function options()
    {
        return $this->hasMany('Columbia\SurveyOption');
    }

    // public function setNameAttribute($value)
    // {
    //     $this->attributes['name'] = ucfirst($value);
    // }
}