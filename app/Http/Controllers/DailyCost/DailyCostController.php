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
	public function viewRoute(Request $request, $funName = null){
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
			$this->setSubFun();

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

	protected function setSubFun(){
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

	public function insert(Request $request, $function = null){
		$message = [];
		$user = $this->getUserSession($request);

		if(!isset($user)){
			$message = $this->redirectMessage();
		}
		else{
			if($function === 'newDC'){

			}
			else if($function === 'currencyInfo' || $function === 'itemInfo'){

			    // 01. create Model object
				$model = new CurrencyInfo();
				if($function === 'itemInfo'){
					$model = new ItemInfo();
                }

                // 02. "POST" data validation
				$this->validate($request, [
					'uri' => 'required|regex:/^http:\/\/.*/',
					'type' => 'required|regex:/^http:\/\/.*/',
					'label' => 'required|regex:/.*@.*/'
				]);

				// 03. check unique data
				$uniqueData['URI'] = $request->get('uri');
				$checkResult = $model->unique($uniqueData);
				if($checkResult === $model::$success) {
					// 04. create insert data
					$values = new \stdClass();
					$values->uri = $request->get('uri');
					$values->type = $request->get('type');
					$values->label = $request->get('label');

					// 05. insert data
					$insertResult = $model->insertAll($values);

					$message = $this->insertResult($insertResult, $model::$success, $function);
				}
				else{
					$message = $this->insertResult('Exist', $model::$success, $function, $checkResult);
				}
			}
		}
		return json_encode($message);
	}

	private function insertResult($result, $success, $function, $existResult = null){
		$message = [];
		if($result === $success){
			$message['title'] = 'Success';
			$message['content'] = 'new record has been save into RMDB';
		}
		else if($result === 'Exist'){
			$message['title'] = 'Exist';
			$message['content'] = 'fail to add new data,<br>'.
				'the column(s) ('.$existResult.') of data had been exist<br>'.
				'(code:ctr_dailyCost_'.$function.'_insert_01).';
		}
		else{
			$message['title'] = 'Error';
			$message['content'] = 'fail to add new item,<br>'.
				'please try again <br>'.
				'(code:ctr_dailyCost_'.$function.'_insert_01).';
		}

		return $message;
	}

}