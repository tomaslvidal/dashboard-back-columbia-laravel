<?php

namespace Columbia\Http\Controllers;

use Columbia\Destination;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Columbia\Http\Requests\StoreDestinationAPI;

class DestinationController extends Controller
{
    public function index()
    {
        return Destination::all();
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
    }

    public function show($id)
    {
        $destination = Destination::where('id', $id)->get();

        return $destination;
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
                if(Storage::disk('local')->exists("destinations/".$destination['image'.$i])){
                    Storage::disk('local')->delete("destinations/".$destination['image'.$i]);
                }

                $storagePath = Storage::disk('local')->put('destinations', $request->file('image'.$i));

                $storageName = basename($storagePath);

                $destination['image'.$i] = $storageName;
            }
        }

        $destination->save();  
    }

    public function destroy($id)
    {
        $destination = Destination::find($id);

        // for ($i=1; $i <= 5; $i++){
        //     if(!empty($destination['image'.$i])) {
        //         if(Storage::disk('local')->exists("destinations/".$destination['image'.$i])){
        //             Storage::disk('local')->delete("destinations/".$destination['image'.$i]);
        //         }
        //     }
        // }
        
        $destination->timestamps = false;

        $destination->delete();
    }

    public function restoring($id)
    {
        $destination = Destination::withTrashed()->find($id);

        $destination->timestamps = false;

        $destination->restore();
    }
}
