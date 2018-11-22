<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

class SurveyMadeOption extends Model
{
	protected $table = 'survey_made_options';

	protected $primaryKey = 'id';

	protected $guarded = [];

	protected $hidden = ['survey_made_field_id', 'survey_option_id'];

    public function surveyField()
    {
        return $this->belongsTo('Columbia\SurveyField');
    }

    public function surveyOption()
    {
        return $this->belongsTo('Columbia\SurveyOption');
    }
}
