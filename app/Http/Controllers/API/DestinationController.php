<?php

namespace Columbia\Http\Controllers\API;

use Columbia\Destination;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Columbia\Http\Requests\StoreDestinationAPI;

use Columbia\Http\Controllers\Controller;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $columns_hidden = ['subtitle', 'image2', 'image3', 'image4', 'image5', 'updated_at', 'created_at', 'deleted_at'];

        if(isset($request->new_version)){
            array_push($columns_hidden, 'description');
        }

        return Destination::all()->makeHidden($columns_hidden);
    }

    public function create()
    {

    }

    public function store(StoreDestinationAPI $request)
    {
        $destination = new Destination($request->except('image1', 'image2', 'image3', 'image4', 'image5'));

        for ($i=1; $i <= 5; $i++){
            if(null !== $request->file('image'.$i)){
                $storagePath = Storage::disk('local')->put('destinations', $request->file('image'.$i));

                $storageName = basename($storagePath);

                $destination['image'.$i] = $storageName;

            }
        }
    
        $destination->save();

        return response()->json([
            'success' => true,
            'id' => $destination->id,
            'created_at' => $destination->created_at->toDateTimeString(),
            'message' => 'operation success.',
        ]);
    }

    public function show($id)
    {
        $destination = Destination::find($id);

        return $destination->makeHidden(['subtitle', 'updated_at', 'image2', 'image3', 'image4', 'image5', 'updated_at', 'created_at', 'deleted_at']);
    }

    public function edit($id)
    {

    }

    public function update($id, StoreDestinationAPI $request)
    {
        $destination = Destination::find($id);

        $destination->fill($request->except('image1', 'image2', 'image3', 'image4', 'image5'));

        for ($i=1; $i <= 5; $i++){
            if(null !== $request->file('image'.$i)){
                if($destination['image'.$i]!=""){
                    if(Storage::disk('local')->exists("destinations/".$destination['image'.$i])){
                        Storage::disk('local')->delete("destinations/".$destination['image'.$i]);
                    }
                }

                $storagePath = Storage::disk('local')->put('destinations', $request->file('image'.$i));

                $storageName = basename($storagePath);

                $destination['image'.$i] = $storageName;
            }
        }

        $destination->save();  
    }

    public function destroy($id, Request $request)
    {
        if($request->forceDelete!="true"){
            $destination = Destination::find($id);
            
            $destination->timestamps = false;

            $destination->delete();
        }
        else{
            $destination = Destination::withTrashed()->find($id);

            for ($i=1; $i <= 5; $i++){
                if(!empty($destination['image'.$i])) {
                    if(Storage::disk('local')->exists("destinations/".$destination['image'.$i])){
                        Storage::disk('local')->delete("destinations/".$destination['image'.$i]);
                    }
                }
            }

            $destination->forceDelete();
        }
    }

    public function delete_file($id, Request $request)
    {
        $destination = Destination::withTrashed()->find($id);

        if($request->key!=null){
            if(!empty($destination[$request->key])) {
                if(Storage::disk('local')->exists("destinations/".$destination[$request->key])){
                    Storage::disk('local')->delete("destinations/".$destination[$request->key]);

                    $destination[$request->key] = '';

                }
                else{
                    $destination[$request->key] = '';
                }

                $destination->save(); 
            }
        }
    }

    public function restoring($id)
    {
        $destination = Destination::withTrashed()->find($id);

        $destination->timestamps = false;

        $destination->restore();
    }

    public function download($file)
    {
        return Storage::download('destinations/'.$file);
    }
}
