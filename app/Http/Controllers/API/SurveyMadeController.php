<?php

namespace Columbia\Http\Controllers\API;

use Columbia\Survey;

use Columbia\SurveyMade;

use Columbia\SurveyField;

use Columbia\SurveyOption;

use Illuminate\Http\Request;

use Columbia\Http\Controllers\Controller;

class SurveyMadeController extends Controller
{
    public function index()
    {
        return SurveyMade::with('survey', 'user', 'surveyMadeFields.surveyField', 'surveyMadeFields.surveyMadeOptions', 'surveyMadeFields.surveyMadeOptions.surveyOption')->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        $survey = SurveyMade::with('survey', 'user', 'surveyMadeFields.surveyField', 'surveyMadeFields.surveyMadeOptions', 'surveyMadeFields.surveyMadeOptions.surveyOption')->find($id);

        return $survey;
    }

    public function edit($id)
    {
        //
    }

    public function update($id, Request $request)
    {

    }

    public function destroy($id, Request $request)
    {
        if($request->forceDelete!="true"){
            $survey = SurveyMade::find($id);

            $survey->timestamps = false;

            $survey->delete();            
        }
        else{
            $survey = SurveyMade::withTrashed()->find($id);

            $survey->forceDelete();
        }
    }

    public function restoring($id)
    {
        $survey = SurveyMade::withTrashed()->find($id);

        $survey->timestamps = false;

        $survey->restore();
    }
}