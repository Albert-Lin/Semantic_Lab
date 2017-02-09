<?php

/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/6
 * Time: 上午 09:23
 */

namespace App\Http\Controllers\DailyCost;

use App\Http\Controllers\SemanticLabController;
use App\Model\CurrencyInfo;
use App\Model\ItemInfo;
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
		}

		// 05. render view
		return View($this->renderView)
			->with('data', $this->data);

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
		$this->renderView = 'semantic_lab/functions/dailyCost/currencyInfo';
		$this->data['funName'] = 'dailyCost/currencyInfo';
	}

	private function itemInfo(){
		$this->renderView = 'semantic_lab/functions/dailyCost/itemInfo';
		$this->data['funName'] = 'dailyCost/itemInfo';
	}

	public function currencyInfoAction(Request $request, $action = null){
		$message = [];
		$user = $this->getUserSession($request);

		if(!isset($user)){
			$message = $this->redirectMessage();
		}
		else{
			$currencyInfo = new CurrencyInfo();

			if($action === 'insert'){
				$this->validate($request, [
					'uri' => 'required|regex:/^http:\/\/.*/',
					'type' => 'required|regex:/^http:\/\/.*/',
					'label' => 'required|regex:/.*@.*/'
				]);

				$values = new \stdClass();
				$values->uri = $request->get('uri');
				$values->type = $request->get('type');
				$values->label = $request->get('label');
				$insertResult = $currencyInfo->insertAll($values);

				$message = $this->insertResult($insertResult, $currencyInfo->success);
			}
			else if($action === 'delete'){

			}
			else if($action === 'update'){

			}
			else if($action === 'select'){

			}
		}
		return json_encode($message);
	}

	public function itemInfoAction(Request $request, $action = null){
		$message = [];
		$message['title'] = '';
		$message['content'] = '';

		$user = $request->session()->get('account');
		if(!isset($user)){
			$message['title'] = 'Redirect';
			$message['content'] = \Config::get('app.domainName');
		}
		else{
			$itemInfo = new ItemInfo();
			if($action === 'insert'){
				$this->validate($request, [
					'uri'=>'required|regex:/^http:\/\/.*/',
					'type'=>'required|regex:/^http:\/\/.*/',
					'label'=>'required',
				]);

				$values = new \stdClass();
				$values->uri = $request->get('uri');
				$values->type = $request->get('type');
				$values->label = $request->get('label');
				$insertResult = $itemInfo->insertAll($values);
				if($insertResult === 'Success'){
					$message['title'] = 'Success';
					$message['content'] = 'new item has been save into RMDB';
				}
				else{
					$message['title'] = 'Error';
					$message['content'] = 'fail to add new item, please try again (code:di01).';
				}
			}
			else if($action === 'delete'){

			}
			else if($action === 'update'){

			}
			else if($action === 'select'){

			}
		}

		return json_encode($message);
	}

	private function insertResult($result, $success){
		$message = [];
		if($result === $success){
			$message['title'] = 'Success';
			$message['content'] = 'new record has been save into RMDB';
		}
		else{
			$message['title'] = 'Error';
			$message['content'] = 'fail to add new item, please try again (code:day_ins_01).';
		}

		return $message;
	}

}