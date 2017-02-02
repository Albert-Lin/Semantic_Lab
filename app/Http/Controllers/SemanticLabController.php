<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/2
 * Time: 下午 04:13
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SemanticLabController extends Controller
{
	public function index(Request $request){
		// 00. check session
		$renderView = '';
		$user = $request->session()->get('account');

		// 01. general view for non-sign in
		if(!isset($user) || $user === "null"){
			$renderView = 'semantic_lab/general';
		}

		// 02. personal view for sign in account
		else{
			$renderView = 'semantic_lab/personal';
		}

		// 03. render view
		return View($renderView)->with('title', 'Semantic Lab');
	}
}