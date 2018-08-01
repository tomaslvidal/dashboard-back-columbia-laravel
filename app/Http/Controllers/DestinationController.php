<?php

namespace Columbia\Http\Controllers;

use Columbia\Destination;
use Illuminate\Http\Request;

//

//use Columbia\Htt\Resources\DestinationCollection;

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
        $destination = Destination::create($request->all());
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

        $destination->update($request->all());
    }

    public function destroy($id)
    {
        $destination = Destination::find($id);

        $destination->delete();
    }
}
