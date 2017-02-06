<?php

/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/6
 * Time: 上午 09:23
 */

namespace App\Http\Controllers\DailyCost;

use App\Http\Controllers\SemanticLabController;
use App\Model\UserInfo;
use Illuminate\Http\Request;

class DailyCostController extends SemanticLabController
{
	public function dailyCostRoute(Request $request, $funName = null){
		// 00. check session
		$user = $request->session()->get('account');

		if(!isset($user)){
			// 01. general view for non-sign in
			$this->nonLogin();
		}
		else{
			// 02. personal view for sign in account
			$this->renderView = 'semantic_lab/personal';
			$this->setSimpleNav($user);
			$funs = [];

			// 03. set side bar functions for DailyCost
			$this->setFuns();

			// 04. route for different function
			if(isset($funName)) {
				switch ($funName) {
					case ('newDC'):
						$this->newDC();
						break;
					case ('vRForm'):
						$this->vRForm();
						break;
					case ('vRGraphic'):
						$this->vRGraphic();
						break;
					case ('currencyInfo'):
						$this->currencyInfo();
						break;
					case ('itemInfo'):
						$this->itemInfo();
						break;
				}
			}

			// 05. render view
			return View($this->renderView)
				->with('data', $this->data);
		}

	}

	protected function setFuns(){
		// All these setting should been set by automatically which select from DB:
		// general functions for all user:
		$funs[] = ['funName'=>'New Daily Cost', 'id'=>'newDC'];
		$funs[] = ['funName'=>'View Record (Form)', 'id'=>'vRForm'];
		$funs[] = ['funName'=>'View Record (Graphic)', 'id'=>'vRGraphic'];

		// specific functions which should add by permission of user:
		// also should get from db
		$funs[] = ['funName'=>'Currency Info', 'id'=>'currencyInfo'];
		$funs[] = ['funName'=>'Item Info', 'id'=>'itemInfo'];
		$this->data['funs'] = $funs;
	}

	private function newDC(){
		$this->renderView = 'semantic_lab/functions/dailyCost/newDC';
		$this->data['funName'] = 'dailyCost/newDC';
	}

	private function vRForm(){
		$this->renderView = 'semantic_lab/personal';
		$this->data['funName'] = 'dailyCost/vRForm';
	}

	private function vRGraphic(){
		$this->renderView = 'semantic_lab/personal';
		$this->data['funName'] = 'dailyCost/vRGraphic';
	}

	private function currencyInfo(){
		$this->renderView = 'semantic_lab/personal';
		$this->data['funName'] = 'dailyCost/currencyInfo';
	}

	private function itemInfo(){
		$this->renderView = 'semantic_lab/personal';
		$this->data['funName'] = 'dailyCost/itemInfo';
	}
}