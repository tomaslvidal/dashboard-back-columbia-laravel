<?php

namespace Columbia\Http\Controllers;

use Columbia\User;

use Columbia\Voucher;

use Illuminate\Http\Request;

use Columbia\Http\Resources\UserCollection;

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

    public function store(Request $request)
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

    public function update($id, Request $request)
    {
        $user = User::find($id);

        $user->update($request->all());
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();
    }

    public function add_voucher($id, Request $request)
    {
        $user = User::find($id);

        $user->vouchers()->attach($request->voucher_id);
    }
}
