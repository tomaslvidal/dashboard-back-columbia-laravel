<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

class SurveyField extends Model
{
    protected $table = 'survey_fields';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function survey()
    {
        return $this->belongsTo('Columbia\Survey');
    }

    public function surveyOptions()
    {
        return $this->hasMany('Columbia\SurveyOption');
    }
}