<?php

namespace Columbia\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function index(){
		$auth = new Auth();

		$auth->loginUsingId(auth()->guard('api')->user()['id']);

		return json_encode(auth()->guard('api')->user());
    }
}
