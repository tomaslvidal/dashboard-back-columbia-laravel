<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
	use SoftDeletes;

    protected $table = 'surveys';

    protected $primaryKey = 'id';

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function surveyFields()
    {
        return $this->hasMany('Columbia\SurveyField');
    }

    public function surveysMade()
    {
        return $this->hasMany('Columbia\SurveyMade');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }
}
