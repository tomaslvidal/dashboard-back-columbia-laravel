<?php

namespace Columbia\Http\Controllers\API;

use Columbia\User;

use Columbia\Survey;

use Columbia\SurveyField;

use Columbia\SurveyOption;

use Columbia\SurveyMade;

use Columbia\SurveyMadeField;

use Columbia\SurveyMadeOption;

use Illuminate\Http\Request;

use Columbia\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;

use Columbia\Mail\SurveyMade as EmailSurvey;

use Columbia\Http\Resources\SurveyMade as CollectionSurveyMade;

class SurveyMadeController extends Controller
{
    public function index()
    {
        return new CollectionSurveyMade(SurveyMade::with('survey', 'user', 'surveyMadeFields.surveyField', 'surveyMadeFields.surveyMadeOptions', 'surveyMadeFields.surveyMadeOptions.surveyOption')->get());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $survey = new SurveyMade();

        $survey->survey_id= $request->id;

        $survey->user_id=auth()->guard('api')->user()->id;

        $survey->save();

        foreach($request->toArray() as $key => $value) {
            if($key!='id') {
                $survey_field = new SurveyMadeField();

                $survey_field->survey_made_id = intval($survey->id);

                $survey_field->survey_field_id = intval($key);

                $survey_field->save();

                if(is_array($value)){
                    for ($i=0; $i < count($value); $i++) { 
                        $survey_option = new SurveyMadeOption();

                        $survey_option->survey_made_field_id = $survey_field->id;

                        $survey_option->survey_option_id = $value[$i];

                        $survey_option->save();
                    }
                }
                else{
                    $survey_field_type = SurveyField::find(intval($key));

                    if(!is_null($survey_field_type)){
                        if($survey_field_type->type === "2"){
                            $survey_option = new SurveyMadeOption();

                            $survey_option->survey_made_field_id = $survey_field->id;

                            $survey_option->survey_option_id = $value;

                            $survey_option->save();

                            continue;
                        }
                    }

                    $survey_option = new SurveyMadeOption();

                    $survey_option->survey_made_field_id = $survey_field->id;

                    $survey_option->free_response = $value;

                    $survey_option->save();
                }
            }
        }

        $survey_made = SurveyMade::with('survey', 'user', 'surveyMadeFields.surveyField', 'surveyMadeFields.surveyMadeOptions', 'surveyMadeFields.surveyMadeOptions.surveyOption')->find($survey->id);

        Mail::to('proventas@columbiaviajes.com.ar')
            ->send(new EmailSurvey($survey_made));

        return response()->json([
            'success' => true,
            'id' => $survey->id,
            'created_at' => $survey->created_at->toDateTimeString(),
            'message' => 'Register success.',
        ]);
    }

    public function show($id)
    {
        $survey = SurveyMade::with('survey', 'user', 'surveyMadeFields.surveyField', 'surveyMadeFields.surveyMadeOptions', 'surveyMadeFields.surveyMadeOptions.surveyOption')->find($id);

        return new CollectionSurveyMade($survey);
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