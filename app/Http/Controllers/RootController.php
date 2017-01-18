<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Description of RootController
 *
 * @author Albert Lin
 */
class RootController extends Controller{

	public function index(Request $request){
		// 00. Check if sign in ( redirect for flase )
		// 01. Show the Root index page
		return View( 'root/index' )
						->with('title', 'Semantic Lab')
						->with('message', 'Welcome to Semantic Lab');
	}

	public function SignUp(){
		
	}

	public function SignIn(){
		
	}

	public function SignOut(){
		
	}
}
