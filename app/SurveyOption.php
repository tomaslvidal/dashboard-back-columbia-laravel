<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

class SurveyOption extends Model
{
    protected $table = 'survey_options';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function surveyField()
    {
        return $this->belongsTo('Columbia\SurveyField');
    }

    // public function setNameAttribute($value)
    // {
    //     $this->attributes['name'] = ucfirst($value);
    // }
}