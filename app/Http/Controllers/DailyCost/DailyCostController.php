<?php

/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/6
 * Time: 上午 09:23
 */

namespace App\Http\Controllers\DailyCost;

use App\Http\Controllers\RootController;
use App\Model\CurrencyInfo;
use App\Model\ItemInfo;
use Illuminate\Http\Request;

class DailyCostController extends RootController
{
	public $controllerId = 'dailyCost';

	protected $renderView = 'semantic_lab/functions/dailyCost/newDC';

	/**
	 * Function for setting side bar sub-functions
	 */
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

	/**
	 * Insert data from AJAX POST into RDB (MODEL) for different function
	 * @param Request $request
	 * @param null $function
	 * @return string
	 */
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

					$message = $this->insertResult($insertResult, $function);
				}
				else{
					$message = $this->insertResult('Exist', $function, $checkResult);
				}
			}
		}
		return json_encode($message);
	}


}