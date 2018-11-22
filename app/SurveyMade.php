<?php

namespace Columbia;

use Illuminate\Database\Eloquent\Model;

class SurveyMade extends Model
{
	protected $table = 'surveys_made';

	protected $primaryKey = 'id';

	protected $guarded = [];

    protected $hidden = ['survey_id', 'user_id'];

    public function survey()
    {
        return $this->belongsTo('Columbia\Survey')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('Columbia\User')->withTrashed();
    }

    public function surveyMadeFields()
    {
        return $this->hasMany('Columbia\SurveyMadeField');
    }
}
