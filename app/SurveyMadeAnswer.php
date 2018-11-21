<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

class SurveyMadeAnswer extends Model
{
	protected $table = 'survey_made_answers';

	protected $primaryKey = 'id';

	protected $guarded = [];

	protected $hidden = ['survey_made_id', 'survey_field_id', 'survey_option_id'];

    public function surveyMade()
    {
        return $this->belongsTo('Columbia\SurveyMade');
    }

    public function surveyField()
    {
        return $this->belongsTo('Columbia\SurveyField');
    }

    public function surveyOption()
    {
        return $this->belongsTo('Columbia\SurveyOption');
    }
}
