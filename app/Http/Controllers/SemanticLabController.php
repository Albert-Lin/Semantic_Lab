<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/2
 * Time: 下午 04:13
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\UserInfo;
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
		return View($renderView)
			->with('title', 'Semantic Lab')
			->with('domainURI', \Config::get('app.domainName'));
	}

	public function login(Request $request){
		// 01. validate raw data
		$this->validate($request, [
			'account' => 'required',
			'pass' => 'required'
		]);

		// get raw data
		$account = $request->get('account');
		$password = $request->get('pass');

		// initialize model
		$userInfoTb = new UserInfo();

		// select DB data
		$hashPass = "";
		$message = "fail: no current username or password is wrong. ";
		$queryResult = $userInfoTb->select('hashPassword')->where([ ['name', $account], ['password', $password] ])->get();
		$result = json_decode($queryResult);
		$numOfResult = count($result);
		if($numOfResult === 1){
			$hashPass = $result[0]->hashPassword;

			// check hashing value
			if(\Hash::check($password, $hashPass)){
				$message = "success";
				// set session
				$request->session()->put('account', $account);
			}
			else{
				$message .= "(code:Sl01)";
			}
		}
		else if($numOfResult === 0){
			$message .= "(code:Sl02)";
		}
		else{
			$message .= "(code:Sl03)";
		}

		return $message;

	}

	public function logout(Request $request){
		$request->session()->forget('account');
		return redirect()->route('root');
	}
}