<?php

namespace Columbia\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SurveyMade extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function toArray($request)
    {
        if(!isset($this->data->toArray()['user'])){
            $surveys = array();

            foreach ($this->data->toArray() as $survey){
                $survey['user']['email'] = explode("&",$survey['user']['email'])[0];

                array_push($surveys, $survey);
            }  

            return collect($surveys);
        }
        else{
            $item = $this->data->toArray();
            
            $item['user']['email'] = explode("&",$item['user']['email'])[0];

            return collect($item);
        }
    }
}