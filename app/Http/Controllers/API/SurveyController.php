<?php

namespace Columbia\Http\Controllers\API;

use Columbia\Survey;

use Columbia\SurveyField;

use Columbia\SurveyOption;

use Illuminate\Http\Request;

use Columbia\Http\Controllers\Controller;

use Columbia\Http\Requests\StoreSurveyAPI;
    
class SurveyController extends Controller
{
    public function index()
    {
        return Survey::with('surveyFields.surveyOptions')->get();
    }

    public function for_user(){
        return Survey::where('state', '=', '1')->whereDoesntHave('surveysMade', function ($query) {
            $query->where('user_id', '=', auth()->guard('api')->user()->id);
        })->with('surveyFields.surveyOptions')->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $survey = new Survey($request->except('survey_fields'));

        $survey->save();

        for ($i=0; $i < count($request->survey_fields); $i++) {
            $survey_field = new SurveyField(array_except($request->survey_fields[$i], ['survey_options']));

            $survey_field->survey_id = $survey->id;

            $survey_field->save();

            if(count($request->survey_fields[$i]['survey_options'])>0){
                for ($d=0; $d < count($request->survey_fields[$i]['survey_options']); $d++) {
                    $survey_option = new SurveyOption($request->survey_fields[$i]['survey_options'][$d]);

                    $survey_option->survey_field_id = $survey_field->id;

                    $survey_option->save();
                }
            }
        }

        return response()->json([
            'success' => true,
            'id' => $survey->id,
            'created_at' => $survey->created_at->toDateTimeString(),
            'message' => 'Register success.',
        ]);
    }

    public function show($id)
    {
        $survey = Survey::with('surveyFields.surveyOptions')->find($id);

        return $survey;
    }

    public function edit($id)
    {
        //
    }

    public function update($id, Request $request)
    {
        $survey = Survey::find($id);

        $survey->update($request->except('survey_fields'));

        if (count($request->survey_fields)>0) {
            $array_existing_fields = [];
            
            for ($f=0; $f < count($request->survey_fields); $f++) { 
                if (isset($request->survey_fields[$f]['id'])) {
                    array_push($array_existing_fields, $request->survey_fields[$f]['id']);
                }
            }

            $delete_fields = SurveyField::where('survey_id', '=', $survey->id)->whereNotIn('id', $array_existing_fields);

            $delete_fields->delete();

            for ($i=0; $i < count($request->survey_fields); $i++) {
                if (isset($request->survey_fields[$i]['id'])) {
                    $survey_field = SurveyField::find($request->survey_fields[$i]['id']);

                    $survey_field->update(array_except($request->survey_fields[$i], ['survey_options']));
                }
                else{
                    $survey_field = new SurveyField(array_except($request->survey_fields[$i], ['survey_options']));

                    $survey_field->survey_id = $survey->id;

                    $survey_field->save();
                }
                if (count($request->survey_fields[$i]['survey_options'])>0) {
                    $array_existing_options = [];
                    
                    for ($o=0; $o < count($request->survey_fields[$i]['survey_options']); $o++) { 
                        if (isset($request->survey_fields[$i]['survey_options'][$o]['id'])) {
                            array_push($array_existing_options, $request->survey_fields[$i]['survey_options'][$o]['id']);
                        }
                    }

                    $delete_options = SurveyOption::where('survey_field_id', '=', $survey_field->id)->whereNotIn('id', $array_existing_options);

                    $delete_options->delete();

                    for ($d=0; $d < count($request->survey_fields[$i]['survey_options']); $d++) {
                        if (isset($request->survey_fields[$i]['survey_options'][$d]['id'])) {
                            $survey_option = SurveyOption::find($request->survey_fields[$i]['survey_options'][$d]['id']);

                            $survey_option->update($request->survey_fields[$i]['survey_options'][$d]);
                        }
                        else{
                            $survey_option = new SurveyOption($request->survey_fields[$i]['survey_options'][$d]);

                            $survey_option->survey_field_id = $survey_field->id;

                            $survey_option->save();
                        }
                    }
                }
                else{
                    $survey_option = SurveyOption::where('survey_field_id', '=', $survey_field->id);

                    $survey_option->delete();
                }
            }
        }
        else{
            $survey_field = SurveyField::where('survey_id', '=', $survey->id);

            $survey_field->delete();
        }

        return response()->json([
            'success' => true,
            'id' => $survey->id,
            'created_at' => $survey->created_at->toDateTimeString(),
            'message' => 'Register success.',
        ]);
    }

    public function destroy($id, Request $request)
    {
        if($request->forceDelete!="true"){
            $survey = Survey::find($id);

            $survey->timestamps = false;

            $survey->delete();            
        }
        else{
            $survey = Survey::withTrashed()->find($id);

            $survey->forceDelete();
        }
    }

    public function restoring($id)
    {
        $survey = Survey::withTrashed()->find($id);

        $survey->timestamps = false;

        $survey->restore();
    }
}