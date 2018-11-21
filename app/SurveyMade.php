<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

class SurveyMade extends Model
{
	protected $table = 'survey_mades';

	protected $primaryKey = 'id';

	protected $guarded = [];

    public function survey()
    {
        return $this->belongsTo('Columbia\Survey');
    }

    public function user()
    {
        return $this->belongsTo('Columbia\User');
    }

    public function surveyMadeAnswers()
    {
        return $this->hasMany('Columbia\SurveyMadeAnswer');
    }
}
