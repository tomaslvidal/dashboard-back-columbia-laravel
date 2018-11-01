<?php

namespace Columbia\Http\Controllers\API;

use Columbia\User;

use Illuminate\Http\Request;

use Columbia\Http\Resources\UserCollection;

use Columbia\Http\Requests\StoreUserAPI;

use Columbia\Http\Requests\AddVoucherAPI;

use Columbia\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return new UserCollection(User::all());
    }

    public function create()
    {
        //
    }

    public function store(StoreUserAPI $request)
    {
        $user = User::create($request->all());

        return response()->json([
            'success' => true,
            'id' => $user->id,
            'created_at' => $user->created_at->toDateTimeString(),
            'message' => 'Register success.',
        ]);
    }

    public function show($id)
    {
        $user = User::where('id', $id)->get();

        return new UserCollection($user);
    }

    public function edit($id)
    {
        //
    }

    public function update($id, StoreUserAPI $request)
    {
        $user = User::find($id);

        $user->update($request->all());
    }

    public function destroy($id, Request $request)
    {
        if($request->forceDelete!="true"){
            $user = User::find($id);

            $user->timestamps = false;

            $user->delete();            
        }
        else{
            $user = User::withTrashed()->find($id);

            $user->forceDelete();
        }
    }

    public function add_voucher($id, AddVoucherAPI $request)
    {
        $user = User::find($id);

        $user->vouchers()->attach($request->voucher_id);
    }

    public function restoring($id)
    {
        $user = User::withTrashed()->find($id);

        $user->timestamps = false;

        $user->restore();
    }
}
