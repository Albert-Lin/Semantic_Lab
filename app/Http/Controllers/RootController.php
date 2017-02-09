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
     * VIEW name for render
     * @var string
     */
    protected $renderView;

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

    /**
     * Render different VIEW for different main function
     * @param Request $request
     */
    public function viewRoute(Request $request){}

    /**
     * Insert data (usually from AJAX POST) into RDB (MODEL) for different function
     * @param Request $request
     */
    public function insert(Request $request){}

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
    protected function postRedirectMessage(){
        $message = [];
        $message['title'] = 'Redirect';
        $message['content'] = \Config::get('app.domainName');
        return $message;
    }

}
