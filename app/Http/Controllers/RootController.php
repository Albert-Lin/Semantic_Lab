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

	/**
	 * We set name of view path (usually directory name) as controller ID,
	 *  there will be '' if there is no such path for current controller.
	 * @var string
	 */
	public $controllerId = '';

    /**
     * VIEW name for render
     * @var string
     */
    protected $renderView = 'semantic_lab/personal';

    /**
     * data for passing to VIEW
     * @var array
     */
    protected $data = [];

    /**
     * Nav data for passing to VIEW which also save in $data
     * @var array
     */
    protected $nav = [];


    // VIEW:
	//=====================================================================================
	/**
	 * Render different VIEW for different main function
	 * @param Request $request
	 * @param null $funName
	 * @return \Illuminate\Http\Response
	 */
	public function viewRoute(Request $request, $funName = null){
		// 00. check session
		$user = $request->session()->get('account');

		if(!isset($user)){
			// 01. general view for non-sign in
			$this->nonLoginData();
		}
		else{
			// 02. personal view for sign in account
			$this->setSimpleNav($user);
			$funs = [];

			// 03. set side bar functions for DailyCost
			$this->setSubFun();

			// 04. route for different function
			if($funName !== null){
				$this->setView_Data($funName);
			}
		}

		// 05. render view
		return response()
				->view($this->renderView, ['data' => $this->data]);
	}

	/**
	 * Function for setting "simple-nav" of view
	 * @param $user
	 */
	protected function setSimpleNav($user){
		$navLeftFuns = [];
		$navLeftFuns[] = ['funName'=>'Daily cost', 'URL'=>\Config::get('app.domainName').'dailyCost'];
		$navLeftFuns[] = ['funName'=>'Data', 'URL'=>\Config::get('app.domainName').''];
		$navLeftFuns[] = ['funName'=>'Learning', 'URL'=>\Config::get('app.domainName').''];
		$navLeftFuns[] = ['funName'=>'Analysis', 'URL'=>\Config::get('app.domainName').''];
		$navLeftFuns[] = ['funName'=>'Semantic', 'URL'=>\Config::get('app.domainName').''];
		$navLeftFuns[] = ['funName'=>'Test', 'URL'=>\Config::get('app.domainName').'test/route/view'];
		$this->nav['navLogoText'] = 'Semantic Lab';
		$this->nav['userName'] = $user;
		$this->nav['logoutURI'] = \Config::get('app.domainName').'logout';
		$this->nav['navLeftFuns'] = $navLeftFuns;
		$this->data['title'] = 'Semantic Lab';
		$this->data['nav'] = $this->nav;
		$this->data['domainURI'] = \Config::get('app.domainName');
	}

	/**
	 * Function for setting side bar sub-functions
	 */
	protected function setSubFun(){}

	/**
	 * set the render view and passing data for different functions.
	 * @param $funId : the id of function which set in controller.
	 */
	protected function setView_Data($funId){
		$this->renderView = 'semantic_lab/functions/'.$this->controllerId.'/'.$funId;
		$this->data['funName'] = $this->controllerId.'/'.$funId;
	}


	// ACCESS DATABASE:
	//=====================================================================================
    /**
     * Insert data (usually from AJAX POST) into RDB (MODEL) for different function
     * @param Request $request
     */
    public function insert(Request $request){}

	/**
	 * @param $result : query result from model function
	 * @param $function
	 * @param null $existResult
	 * @return array
	 */
	protected function insertResult($result, $function, $existResult = null){
		$message = [];
		if($result === \App\Model\RootModel::$success){
			$message['title'] = 'Success';
			$message['content'] = 'new record has been save into RMDB';
		}
		else if($result === 'Exist'){
			$message['title'] = 'Exist';
			$message['content'] = 'fail to add new data,<br>'.
				'the column(s) ('.$existResult.') of data had been exist<br>'.
				'(code:ctr_dailyCost_'.$function.'_insert_01).';
		}
		else if($result === \App\Model\RootModel::$error){
			$message['title'] = 'Error';
			$message['content'] = 'fail to add new data,<br>'.
				'please try again <br>'.
				'(code:ctr_dailyCost_'.$function.'_insert_01).';
		}

		return $message;
	}

    /**
     * Delete data (usually from AJAX POST) in RDB (MODEL) for different function
     * @param Request $request
     */
    public function delete(Request $request){}

    /**
     * Update data (usually from AJAX POST) in RDB (MODEL) for different function
     * @param Request $request
     */
    public function update(Request $request){}

    /**
     * Select data from RDB (MODEL) for different function
     * @param Request $request
     */
    public function select(Request $request){}

    // UTILITY:
	//=====================================================================================
    /**
     * check user session record
     * @param Request $request
     * @return mixed
     */
    protected function getUserSession(Request $request){
        return $request->session()->get('account');
    }

    /**
     * set data while user isn't login
     */
    protected function nonLoginData(){
        $this->renderView = 'semantic_lab/general';
        $this->data['title'] = 'Semantic Lab';
        $this->data['domainURI'] = \Config::get('app.domainName');
    }

    /**
     * set return data while current page should be redirect
     * @return array
     */
    protected function redirectMessage(){
        $message = [];
        $message['title'] = 'Redirect';
        $message['content'] = \Config::get('app.domainName');
        return $message;
    }

	/**
	 * Simple function to echo query result into text lines
	 * @param $result
	 * @return string
	 */
	public function toLines($result){
		$result = json_decode($result);
		$lines = "";
		for($i = 0; $i < count($result); $i++){
			$columns = $result[$i];
			foreach($columns as $key => $value) {
				$lines .= "[ " . $key . " ]: " . $value."<br>";
			}
		}

		return $lines;
	}

	/**
	 * Simple function to echo query result into table
	 * @param $result
	 * @return string
	 */
	public function toTable($result){
		$result = json_decode($result);
		$tHead = "<thead> <tr> <td>No.</td>";
		$tBody = "<tbody>";

		for($i = 0; $i < count($result); $i++){
			$columns = $result[$i];
			$tBody .= "<tr> <td>".$i."</td>";
			foreach($columns as $key => $value){
				if($i === 0){
					$tHead .= "<td>".$key."</td>";
				}
				$tBody .= "<td>".$value."</td>";
			}
			$tBody .= "</tr>";
			$tHead .= "</tr></thead>";
		}
		$tBody .= "</tbody>";

		return '<table class"table">'.$tHead.$tBody.'</table>';
	}

}
