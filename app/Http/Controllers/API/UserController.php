<?php

namespace Columbia\Http\Controllers\API;

use Columbia\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use Columbia\Http\Requests\StoreUserAPI;

use Columbia\Http\Requests\AddVoucherAPI;

use Columbia\Http\Controllers\Controller;

use Columbia\Http\Controllers\Auth\ForgotPasswordController;

class UserController extends Controller
{
    public function index()
    {
        return User::with('vouchers')->get();
    }

    public function create()
    {
        //
    }

    public function store(StoreUserAPI $request)
    {
        $user = new User($request->except(['vouchers', 'password']));

        $user->password = bcrypt($request->password);

        $user->save();

        $change_password = new ForgotPasswordController();

        $change_password->sendEmail($request);

        if(isset($request->vouchers)){
            for ($i=0; $i < count($request->vouchers); $i++) { 
                if(isset($request->vouchers[$i]['id'])){
                    $user->vouchers()->attach($request->vouchers[$i]['id']);
                }
            }
        }

        return response()->json([
            'success' => true,
            'id' => $user->id,
            'created_at' => $user->created_at->toDateTimeString(),
            'message' => 'Register success.',
        ]);
    }

    public function show($id)
    {
        $user = User::with('vouchers')->find($id);

        return $user;
    }

    public function edit($id)
    {
        //
    }

    public function update($id, StoreUserAPI $request)
    {
        $user = User::find($id);

        $user->password = bcrypt($request->password);

        $user->update($request->except(['vouchers', 'password']));

        if(isset($request->vouchers)){
            $user->vouchers()->detach();

            for ($i=0; $i < count($request->vouchers); $i++) { 
                if(isset($request->vouchers[$i]['id'])){
                    $user->vouchers()->attach($request->vouchers[$i]['id']);
                }
            }
        }
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
