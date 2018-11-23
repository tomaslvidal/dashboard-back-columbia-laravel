<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

class SurveyMadeField extends Model
{
    public $timestamps = false;
    
	protected $table = 'survey_made_fields';

	protected $primaryKey = 'id';

	protected $guarded = [];

	protected $hidden = ['survey_made_id', 'survey_field_id'];

    public function surveyMade()
    {
        return $this->belongsTo('Columbia\SurveyMade');
    }

    public function surveyField()
    {
        return $this->belongsTo('Columbia\SurveyField');
    }

    public function surveyMadeOptions()
    {
        return $this->hasMany('Columbia\SurveyMadeOption');
    }
}
