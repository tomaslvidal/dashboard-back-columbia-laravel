<?php

namespace Columbia\Http\Controllers\API;

use Columbia\Survey;

use Illuminate\Http\Request;

use Columbia\Http\Controllers\Controller;

use Columbia\Http\Requests\StoreSurveyAPI;

class SurveyController extends Controller
{
    public function index()
    {
        return Survey::with('fields')->get();
    }

    public function create()
    {
        //
    }

    public function store(StoreSurveyAPI $request)
    {
        $survey = Survey::create($request->all());

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

    public function update($id, StoreSurveyAPI $request)
    {
        $survey = Survey::find($id);

        $survey->update($request->all());
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
