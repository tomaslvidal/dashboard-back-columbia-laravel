<?php

namespace Columbia\Http\Controllers;

use Columbia\User;

use Illuminate\Http\Request;

use Columbia\Http\Resources\UserCollection;

use Columbia\Http\Requests\StoreUserAPI;

use Columbia\Http\Requests\AddVoucherAPI;

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

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();
    }

    public function add_voucher($id, AddVoucherAPI $request)
    {
        $user = User::find($id);

        $user->vouchers()->attach($request->voucher_id);
    }
}
