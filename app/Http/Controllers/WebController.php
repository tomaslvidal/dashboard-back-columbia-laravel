<?php

namespace Columbia\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
	public function index(){
		return view('home');
    }
}
