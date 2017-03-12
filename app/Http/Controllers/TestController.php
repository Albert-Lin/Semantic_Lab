<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Model\UserInfo;
use Illuminate\Support\Facades\Hash;
use Facebook\Facebook;
use App\Utility\Cookie;
use App\semsol\arc2\TripleStore;
use App\semsol\Triple;
use League\Flysystem\Exception;

/**
 * Description of TestController
 *
 * @author Albert Lin
 */
class TestController extends Controller{


	// SIMPLE:
	//=====================================================================================
	/**
	 * This is a most simple action of controller,
	 *  we do something here,
	 *  usually, the code in here mostly similar as pseudo code,
	 *  and also, we might going to pass data by using View()->with('key', 'value');
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		// pass data to the mapping view:

		// return data to view:
		$data = [];
		$data['title'] = 'Semantic Lab';
		$data['bodyMessage'] = 'Well done! This is the most simple action in controller.';

		Return response()
				->view('test/index', $data);
	}
	/**
	 * At pass, while passing request from url,
	 * 	we always using ?key=value,
	 * 	but now, because of route strategy,
	 * 	we can pass request inner url path,
	 * @param $category
	 * @param $page
	 */
	public function beautyURL($category, $page){
		echo "We get get category & page variables from Url path, and both of them are: <br>";
		echo "Category: ".$category."<br>";
		echo "Page: ".$page."<br>";
	}


	// VIEW:
	//=====================================================================================
	/**
	 * VIEW & TEMPLATE:
	 * @param $tempNum
	 * @return \Illuminate\Http\Response
	 */
	public function viewTemp($tempNum){
		if($tempNum < 3) {
			Return response()
				->view('test/view/temp', ['title' => 'Template ' . $tempNum]);
		}
	}


	// MODEL
	//=====================================================================================
	/**
	 * Show the note of create migrate file and Model by using php artisan command
	 * @return \Illuminate\Http\Response
	 */
	public function modelNote(){
	    return response()
				->view('test/model/note', [ 'title' => 'Note for create model complete process']);
    }
	/**
	 * query builder && Hash function
	 * @param $action
	 */
    public function queryBuilder($action){
		if($action === 'insert'){
			$values = new \stdClass();
			$values->name = "Albert Lin";
			$values->password = "z/ m06";
			$values->hashPassword = Hash::make($values->password); // check: function hashing below
			$values->email = "albert.lin.solventosoft.com.tw";

			$userInfoTable = new UserInfo();
			$response = $userInfoTable->insertAll($values);
			echo $response;
		}
		else if($action === 'select'){
			$userInfoTable = new UserInfo();
			$allColumns = $userInfoTable->selectAll([]);
			foreach($allColumns as $key => $value){
				echo $key."  ".$value."<br>";
			}
			echo "<br><br><br>";

			echo $userInfoTable->toLines($allColumns);
			echo "<br><br><br>";

			echo $userInfoTable->toTable($allColumns);
			echo "<br><br><br>";
		}
		else if($action === 'update'){

		}
		else if($action === 'delete'){

		}
	}
	/**
	 * Testing unique function of RootMadel
	 */
	public function unique(){
		$model = new \App\Model\ItemInfo();
		$uniqueData['URI'] = 'http://semanticlab.com/Headphones';
		$checkResult = $model->unique($uniqueData);
		var_dump($checkResult);
	}


	// ROUTE:
	//=====================================================================================
	/**
	 * Get all the route in routes/api.php && routes/web.php.
	 * Dont't forget to import(use) class for Route:
	 * ==> => Illuminate\Support\Facades\Route <= <==
	 */
	public function getRouteList(){

		$routeCollection = Route::getRoutes();

		foreach ($routeCollection as $value) {
			echo $value->getPath()."<br>";
		}
	}
	/**
	 * get route list and show in VIEW with Bootstrape
	 * @return \Illuminate\Http\Response
	 */
	public function getRouteListInView(){

		$routeCollection = Route::getRoutes();
		$routeList = [];
		$index = 0;
		foreach ($routeCollection as $value) {
			$routeList[$index] = $value->getPath();
			$index++;
		}

		return response()
				->view('test/route/routeList',
					['routeList' => $routeList,'title' => 'Route List']);

	}
	/**
	 * get route list also group by prefix
	 */
	public function getRouteGroupByPrefix(){
		$prefixList = [];
		$routeCollection = Route::getRoutes();
		foreach ($routeCollection as $key => $value) {
			$uri = $value->getUri();
			$prefix = $value->getPrefix();

			if(!isset($prefixList[$prefix])){
				$prefixList[$prefix] = [];
				$prefixList[$prefix][] = $uri;
			}
			else{
				$prefixList[$prefix][] = $uri;
			}
		}

		var_dump($prefixList);
	}
	/**
	 * get group routes with better VIEW
	 * @return \Illuminate\Http\Response
	 */
	public function routeGroupView(){
	    $prefixList = [];
	    $routeCotroller = Route::getRoutes();
	    foreach($routeCotroller as $route){
	        $uri = $route->getUri();
	        $prefix = $route->getPrefix();

	        if(!isset($prefixList[$prefix])){
                $prefixList[$prefix] = [];
            }

            $prefixList[$prefix][] = $uri;
        }

        return response()
                ->view('test/route/routeBlock', ['data' => $prefixList]);
    }

	// REQUEST:
	//=====================================================================================
	/**
	 * Test the request methods
	 * @param Request $request
	 */
	public function request(Request $request){
		var_dump($request);
	}
	/**
	 * In this function we show how to get the requests data.
	 * 	Don't forget to import(use) class of Request:
	 * 	 ==> => Illuminate\Http\Request; <= <==
	 * @param Request $request
	 * @param $type
	 */
	public function getReguest(Request $request, $type){
		if($type == 0){
			$requests = $request->all();
			echo  var_dump($request);
		}
		else if($type == 1){
			$requests = $request->all();
			foreach($requests as $key => $value){
				echo $key." : ".$value." <br>";
			}
		}
		else if($type == 2){
			$requests = $request->all();
			echo $requests['password'];
		}
	}
	/**
	 * This function show how to access variables in URL path
	 * @param Request $request
	 * @param $category
	 * @param $page
	 */
	public function getUrlRequest(Request $request, $category, $page){
		echo "We get get category & page variables from \"Request\", and both of them are: <br>";
		echo "Category: ".$request->category."<br>";
		echo "Page: ".$request->page."<br>";
	}


	// SESSION: in Laravel session is part of Request
	//=====================================================================================
	/**
	 * This function show how to set session
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function setSession(Request $request){
		// set the session by instance of Request
		$request->session()->put( 'instancePassword', 'I-love4451');

		// set the session by using global helper
		session([ 'globalPassword' => 'G-love4451' ]);

		// let's view the result
		return response()
				->view('test/session', ['title' => 'Session']);
	}
	/**
	 * This function show how to get the session
	 * @param Request $request
	 * @param $type
	 */
	public function getSession(Request $request, $type){
		if($type == 0){
			var_dump($request);
		}
		else if($type == 1){
			$sessions = $request->session()->all();
			var_dump($sessions);
		}
		else if($type == 2){
			$sessions = $request->session()->all();
			$iSession = $sessions['instancePassword'];
			$gSession = $sessions['globalPassword'];

			echo "Instance Session: ".$iSession."<br>";
			echo "Global Session: ".$gSession."<br>";
		}
		else if($type == 3){
			$iSession = $request->session()->get( 'instancePassword' );
			$gSession = $request->session()->get( 'globalPassword' );

			echo "Instance Session: ".$iSession."<br>";
			echo "Global Session: ".$gSession."<br>";
		}
	}
	/**
	 * This controller show the methods to remove/delete the session
	 * @param Request $request
	 * @param $type
	 */
	public function deleteSession(Request $request, $type){
		if($type == 0){
			$sessions = $request->session()->all();
			var_dump($sessions);

			$request->session()->forget( 'instancePassword' );
			var_dump($sessions);
		}
		else if($type == 1){
			$sessions = $request->session()->all();
			var_dump($sessions);

			$request->session()->flash();
			var_dump($request->session()->all());
		}
	}


	// COOKIE: in Laravel cookie is SET by response
	//=====================================================================================
	/**
	 * show the native PHP cookie data information
	 */
    public function viewCookie(){
        var_dump($_COOKIE);
    }
	/**
	 * set cookie by using response
	 * @param Request $request
	 * @param $method
	 * @return mixed
	 */
    public function setCookie(Request $request, $method){
    	$info = '';
        if($method === 'single'){
            $info = Cookie::settingInfo($request, 'data', 'first');
        }
        else if($method === 'different'){
			$info = Cookie::settingInfo($request, 'data2', 'data2');
        }
        else if($method === 'array'){
			$info = Cookie::settingInfo($request, 'data', 'second');
        }
        else if($method === 'dSpecial'){
			$info = Cookie::specialDeletingInfo($request, 'data', 'second');
        }
        else if($method === 'delete'){
			$info = Cookie::deletingInfo($request, 'data2');
        }
        if($info !== null)
		    return response('')->cookie($info['name'], $info['value'], $info['time'], $info['path']);
    }
	/**
	 * set cookie with live time
	 * \Illuminate\Http\Response
	 */
	public function setCookieWithTime(){
		$data = [];
		$data['title'] = 'Semantic Lab';
		$data['domainURI'] = \Config::get('app.domainName');
		return response()
			->view('semantic_lab/general', ['data'=>$data])
			->cookie('re', 'val', 36400, '/');
	}
	/**
	 * get cookie by using original method (request)
	 * @param Request $request
	 */
	public function origGetCookie(Request $request){
		$value = $request->cookie('re');
		var_dump($value);
		var_dump($_COOKIE);
	}
	/**
	 * get cookie by using our method
	 *  ==> => App\Utility\Cookie <= <==
	 * @param Request $request
	 * @param $method
	 */
    public function getCookie(Request $request, $method){
        if($method === 'list'){
            $result = Cookie::getNameList();
            var_dump($result);
        }
        else if($method === 'value'){
            $result = Cookie::getValues($request, 'data');
            var_dump($result);
        }
        else if($method === 'latest'){
            $result = Cookie::getLatestValue($request, 'data');
            var_dump($result);
        }
    }


	// SECURITY
	//=====================================================================================
	/**
	 * HASH:
	 * This function show how to use hash function and check hash variable
	 *   ==> => Illuminate\Support\Facades\Hash <= <==
	 * @param $data
	 */
	public function hashing($data){

		$hashValue = Hash::make($data);

		echo "original data: ".$data."<br>hashing value: ".$hashValue."<br>";

		$checkHash = Hash::check($data, $hashValue);
		if($checkHash === true){
			echo "check: ".$checkHash."<br>";
		}
	}
	/**
	 * This function is an example of combine both HASH and MODEL
	 * @param $user
	 */
	public function dbHashCheck($user){
		$password = "z/ m06";
		$model = new UserInfo();
		$queryResult = $model->select('hashPassword')->where([ ['name', '=', $user] ])->get();
		$result = json_decode($queryResult);
		if(count($result) === 1){
			$hashPassword = $result[0]->hashPassword;
			if( Hash::check($password, $hashPassword) ){
				echo "Correct";
			}
			else{
				echo "password wrong";
			}
		}
		else{
			echo "account error";
		}
	}
	/**
	 * VALIDATION:
	 * more Laravel validation rules:
	 * https://laravel.com/docs/5.3/validation#available-validation-rules
	 * The rule "unique:{db table name}" means the given variable must "exist" and unique in table
	 * @return \Illuminate\Http\Response
	 */
	public function valiData(){
		return response()
				->view('test/security/validation/valiForm', [
					'title' => 'VALIDATION FORM',
					'domainName' => \Config::get('app.domainName')
				]);
	}
	/**
	 * This data show the validation method of Controller
	 * @param Request $request
	 */
	public function valiProcess(Request $request){
		$this->validate($request, [
			'username' => 'required|min:6|max:20',
			'password' => 'required|min:6|max:12',
			'email' => 'required|email|unique:user_infos'
		]);

		echo "= w =";
	}


	// API
	//=====================================================================================
	/**
	 * This is a function to call API with curl method
	 */
	public function callAPI(){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "http://semantic_lab/api/new-api");
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$jsonResult = curl_exec($curl);
		$result = json_decode($jsonResult, true);
		if($result['code'] == 0)
			echo $result['data']['token'];
		else
			echo "ERROR FOR ACCESS TOKEN";
	}
	/**
	 * This is an API function for return a token,
	 * also the route forthis function is set in /route/api.php
	 * @return \stdClass $jsonData
	 */
	public function newAPI(){
		$data['code'] = 0;
		$data['data']['token'] = "QWdfsdfSDFSDdsfsdSdfsdfSDFSdfsFsdfsdFs";
		$jsonData = json_encode($data);

		return $jsonData;
	}


	// Processing P5:
	//=====================================================================================
	/**
	 * function to enter P5 project:
	 * @return \Illuminate\Http\Response
	 */
	public function p5(){
		return response()->view('test/p5/index', ['title' => 'P5']);
	}
	/**
	 * This function will show linked Data VIEW created with P5
	 * @return $this
	 */
	public function p5Linked(){
		return response()->view('test/p5/linked', ['title' => 'P5']);
	}


	// D3:
	//=====================================================================================
	/**
	 * D3 example form web
	 * @return \Illuminate\Http\Response
	 */
	public function d3(){
		return response()->view('test/d3/index', ['title' => 'D3']);
	}
	/**
	 *  D3 SVG example form web
	 * @return \Illuminate\Http\Response
	 */
	public function d3Svg(){
		return response()->view('test/d3/svg', ['title' => 'D3 SVG']);
	}
	/**
	 * D3 SVG example with accessing JSON data
	 * @return \Illuminate\Http\Response
	 */
	public function d3SvgJson(){
		return response()->view('test/d3/svgJson', ['title' => 'D3 SVG JSON']);
	}
	/**
	 * * D3 SVG path example
	 * @return $this
	 */
	public function path(){
			return View('test/d3/svg_path')
						->with('title', 'SVG PATH');
	}


	// NEO4J:
	//=====================================================================================
	/**
	 * simple Neo4J project
	 * @return \Illuminate\Http\Response
	 */
	public function  neo4j(){
		return response()->view('test/neo4j/index', ['title' => 'NEO4j JS']);
	}
	/**
	 * Neo4J project with visualization (using d3)
	 * @return \Illuminate\Http\Response
	 */
	public function vis(){
		return response()->view('test/neo4j/visualization', ['title' => 'Visualization']);
	}
	/**
	 * Neo4J project which JS design based on MVC framework
	 * @return \Illuminate\Http\Response
	 */
	public function visMVC(){
		return response()->view('test/neo4j/vis_mvc', ['title' => 'VIS MVC']);
	}


	// GOOGLE MAP:
	//=====================================================================================
	/**
	 * Simple Googe map
	 * @return \Illuminate\Http\Response
	 */
	public function gmap(){
		return response()->view('test/google/map/index', ['title' => 'Google Map']);
	}
	/**
	 * The project show phone record on Google map
	 * @return \Illuminate\Http\Response
	 */
	public function googleMap(){
		return response()->view('test/google/map/index_class', ['title' => 'Google Map']);
	}
	/**
	 * The project show car record on Google map
	 * @return \Illuminate\Http\Response
	 */
	public function googleCarMap(){
		return response()->view('test/google/map/car/car', ['title' => 'Google Car Map']);
	}
    /**
     * The online project about Phone Record
     * @return \Illuminate\Http\Response
     */
    public function phoneRecordMap(){
        return response()
            ->view('test/google/map/phoneRecord/index');
    }
    /**
     * The online project about Phone Record which try to using MVC framework
     * @return \Illuminate\Http\Response
     */
    public function phoneRecordMVCMap(){
        return response()
            ->view('test/google/map/phoneRecord/mvc');
    }


	// EXCUTE EXTERNAL FILE :
	//=====================================================================================
	/**
	 * This is a function to excute external file.
	 * @param $type
	 */
	public function exe($type){
		if($type == "exec"){
			// $command : the commad String, it is same as the content in .bat file (but with file directory)
			// $output: the messages showing in cmd (something from System.out.println() )
			$command = "java -jar D:/2.Personal/4.Work/SolventoSOFT/Test_Project/Semantic_Lab/public/external/phpExternal.jar";
			exec($command, $output);
			var_dump($output);

			// using "json_decode()" convert json output to array from "exec()"
			$result = json_decode($output[0], true);
			foreach($result as $key => $value){
				if(is_array($value)){
					echo $key." : <br>";
					foreach($value as $key2 => $value2){
						echo $key2." : ".$value2."<br>";
					}
				}
				else{
					echo $key." : ".$value."<br>";
				}
			}
		}
		else if($type = "system"){
			// while using original PHP function "system()" the messages those showing in cmd will all echo out in page
			// $command : the commad String, it is same as the content in .bat file
			// $returnValue: the value return from external file, but actually i have no idea what is this.
			// $lastLine: the last line of message which showing in cmd
			$command = "java -jar ./external/phpExternal.jar";
			$lastLine = system($command, $returnValue);
			var_dump($lastLine);
		}
	}


	// CSS :
	//=====================================================================================
	/**
	 * a side bar layout with setting transition
	 * @return \Illuminate\Http\Response
	 */
	public function sideBarTrans(){
		return response()->view('test/css/side_bar_trans', ['title' => 'CSS TRANSITION']);
	}
	/**
	 * a side bar layout with setting transition AND Bootstrap
	 * @return \Illuminate\Http\Response
	 */
	public function bsSideBarTrans(){
		return response()->view('test/css/bs_side_bar_trans', ['title' => 'BS Side Bar Trans']);
	}
	/**
	 * a vertical nav(tab, phill) as side bar
	 * @return \Illuminate\Http\Response
	 */
	public function leftTabs(){
		return response()->view('test/css/left_tabs', ['title' => 'CSS LEFT TABS']);
	}
	/**
	 * Bootstrap grid system:
	 * @return \Illuminate\Http\Response
	 */
	public function grid(){
		return response()->view('test/css/grid', ['title' => 'CSS GRID']);
	}

	public function verNavTransLayout(){
	    return response()->view('tamplate/verticalNav-transLayout');
    }


	// FACEBOOK V2.8 :
	//=====================================================================================
	/**
	 * This function show how to create a Facebook object and generate a login link
	 */
    public function facebook(){
        $fb = new Facebook([
            'app_id' => '368249613535369',
            'app_secret' => 'c0bec84f53f0b4550712cec2d43e482c',
            'default_graph_version' => 'v2.8',
        ]);

        // login link:
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['user_friends','user_posts']; // optional
        $loginUrl = $helper->getLoginUrl('http://semanticlab.com/test/facebook/login', $permissions);

		header('Location: '.$loginUrl);
		exit();
    }
	/**
	 * This function is a Facebook login page
	 */
    public function fbLogin(){

		$fb = new Facebook([
			'app_id' => '368249613535369',
			'app_secret' => 'c0bec84f53f0b4550712cec2d43e482c',
			'default_graph_version' => 'v2.8',
			'persistent_data_handler'=>'session'
		]);

		$helper = $fb->getRedirectLoginHelper();

		try {
			$accessToken = $helper->getAccessToken();
		} catch(\Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		if (! isset($accessToken)) {
			if ($helper->getError()) {
				header('HTTP/1.0 401 Unauthorized');
				echo "Error: " . $helper->getError() . "\n";
				echo "Error Code: " . $helper->getErrorCode() . "\n";
				echo "Error Reason: " . $helper->getErrorReason() . "\n";
				echo "Error Description: " . $helper->getErrorDescription() . "\n";
			} else {
				header('HTTP/1.0 400 Bad Request');
				echo 'Bad request';
			}
			exit;
		}

		// Logged in

		// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();

		// Get the access token metadata from /debug_token
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);

		// Validation (these will throw FacebookSDKException's when they fail)
		$tokenMetadata->validateAppId('368249613535369'); // Replace {app-id} with your app id
		// If you know the user ID this access token belongs to, you can validate it here
		//$tokenMetadata->validateUserId('123');
		$tokenMetadata->validateExpiration();

		if (! $accessToken->isLongLived()) {
			// Exchanges a short-lived access token for a long-lived one
			try {
				$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
			} catch (\Facebook\Exceptions\FacebookSDKException $e) {
				echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
				exit;
			}

			echo '<h3>Long-lived</h3>';
			var_dump($accessToken->getValue());
		}

		// set the session by using global helper
		session([ 'fb_access_token' => (string) $accessToken ]);

		$friendList = $this->friendsRecursive($fb, $accessToken, null);
		$index = 1;
		foreach($friendList as $key => $friend){
			echo $index." ".$friend['id']." ".$friend['name']."<br>";
			$index++;
		}

		$this->createPost($accessToken);

    }
	/**
	 * This function select all friends information by using API:
	 *  ==> => taggable_friends <= <==
	 *  however the friend id we get is only used for tagging friend,
	 *  it's not truly id of personal
	 * @param $fb
	 * @param $accessToken
	 * @param null $after
	 * @return array
	 */
    private function friendsRecursive($fb, $accessToken, $after = null){
        $allFriends = [];
        $response = "";
        $fb->setDefaultAccessToken($accessToken);
        try {
            if($after === null){
                $response = $fb->get('/me/taggable_friends');
            }
            else{
                $response = $fb->get('/me/taggable_friends?after='.$after);
            }
            $friends = $response->getGraphEdge()->asArray();
            foreach($friends as $key => $friend){
                $allFriends[] = $friend;
            }

            if(isset($response->getGraphEdge()->getMetaData()['paging']['next'])){
                $newAfter = $response->getGraphEdge()->getMetaData()['paging']['cursors']['after'];
                $nextFriendList = $this->friendsRecursive($fb, $accessToken, $newAfter);
                foreach($nextFriendList as $nextKey => $nextFriend){
                    $allFriends[] = $nextFriend;
                }
            }

        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        return $allFriends;
    }
	/**
	 * This function is for creating a Facebook post, how ever it doesn't work.
	 * @param $accessToken
	 */
    private function createPost($accessToken){

		$fb = new Facebook([
			'app_id' => '368249613535369',
			'app_secret' => 'c0bec84f53f0b4550712cec2d43e482c',
			'default_graph_version' => 'v2.8',
			'persistent_data_handler'=>'session'
		]);

		$privacy = new \stdClass();
		$privacy->value = "SELF";

		// $method, $endpoint, array $params = [], $accessToken = null, $eTag = null, $graphVersion = null

		$requests = [
			'postFeed' => $fb->request(
				'POST',
				'/me/feed',
				array(
					'message' => 'FROM ALBERT APP',
					"tags"=>"AaKb-TZSiAQ6xgES8qyB0vVdm29IXmxh-T-lsGN1YvMTLy6iBXV8AuvIWS4mMlggdCh5hqLGJQxiStbp0ad4SKdbvY7IK-fMHi1gdOHokYUsmg,AaLBwo1JCnJmEFTbmsSmto-wRdW7QP5OzsKdHwEDArgJuEIwD9-5teJXE-sO3grJvNu8zq4GC2CL1YYH-q9iBD5URvoD0Ctiy8Ry5z5zE3UdOQ",
					"privacy"=>$privacy
				)),
		];
		$batchRequest = new \Facebook\FacebookBatchRequest($fb->getApp(), $requests, $accessToken);
	}


	// UTILITY :
	//=====================================================================================
	/**
	 * This function is a regex search which usually used as auto-complete search
	 * @param $searchWord
	 */
	public function autoCompleteSearch($searchWord){
		$array = [];
		$array[] = '*albert';
		$array[] = 'a*lbert';
		$array[] = 'al*bert';
		$array[] = 'alb*ert';
		$array[] = 'albe*rt';
		$array[] = 'alber*t';
		$array[] = 'albert*';
		$subArray = [];
		$subArray[] = 'albert lin';
		$subArray[] = 'albert lin success';
		$subArray[] = 'albert *lin';
		$array[] = $subArray;

		$searchResult = \App\Utility\Utility::arrayRegexSearch($searchWord, $array);
		var_dump($searchResult);
	}


	// RDF/TRIPLE STORE :
	//=====================================================================================
	/**
	 * Create a TripleStore object, if table(s) doesn't exist before,
	 * 	it will auto create all tables that ARC2 needs.
	 */
	public function tripleStore(){
	    $tripleStore = new TripleStore();
    }
	/**
	 * Query DBpedia, the sparql is a string
	 */
    public function dbpedia(){
	    $query = 'SELECT DISTINCT ?p ?o '.
        'WHERE{ '.
        '  dbr:Dirk_Nowitzki ?p ?o.'.
        '}';

	    $tripleStore = new TripleStore('dbpedia');
		$result = $tripleStore->get($query);

	    var_dump($result);
    }
	/**
	 * Query DBpedia, the sparql is create by query builder functions of TripleStore
	 */
    public function arc2QueryBuilder(){
        $tripleStore = new TripleStore('dbpedia');
        $result = $tripleStore->select(["?s", "?p", "?o"], true)->where([
            Triple::triple('?s', 'rdfs:label', '"Dirk Nowitzki"'),
            Triple::triple('?s', '?p', '?o'),
        ])
        ->get();

        var_dump($result);
    }
	/**
	 * Query DBpedia by query builder and show result in lines
	 */
    public function qbList(){
        $tripleStore = new TripleStore('dbpedia');
        $selectKey = ['?s', '?p', '?o'];
        $tripleQuery = [
            Triple::triple('?s', 'rdfs:label', '"Dirk Nowitzki"@en'),
            Triple::triple('?s', '?p', '?o')
        ];
        $result = $tripleStore
                    ->select($selectKey, true)
                    ->where($tripleQuery)
                    ->get();
        $keys = $tripleStore->getSelectKeys();

        foreach($result as $index => $tripleInfo){
            $RDF = '';
            foreach($keys as $kIndex => $key){
                $RDF .= $tripleInfo[$key].' ';
            }
            $RDF .= '<br>';

            echo $RDF;
        }
    }


	// VUE JS :
	//=====================================================================================
	public function vueTest(){
		return response()->view('test/vue-js/vue-js-test', ['title'=>'VUE JS !!']);
	}

	public function vueCtrl($char = null){

		$object = [];
		$object['name'] = 'Dirk';
		$object['characterName'] = 'PF';
		$object['action'] = [];

		if(isset($char)){
			if($char === 'o'){
				$object['action']['actionName'] = 'one_legged_fadeaway';
				$object['action']['actionProps'] = [];
				$object['action']['actionProps']['imgs'] = [];
				$object['action']['actionProps']['imgs'][0] = 'http://basketballsocietyonline.com/wp-content/uploads/2014/12/usatsi_7896714.jpg';
				$object['action']['actionProps']['imgs'][1] = 'https://d13csqd2kn0ewr.cloudfront.net/uploads/image/file/65723/cropped_REU_2014922.jpg?ts=1408459960';
				$object['action']['actionProps']['imgs'][2] = 'http://i.imgur.com/33dycpC.jpg';
				$object['action']['actionProps']['imgs'][3] = 'http://pic.pimg.tw/rvd1129/1380683559-4273256996.jpg?v=1380683560';
			}
			else if($char === '3'){
				$object['action']['actionName'] = 'three_point_shooter';
				$object['action']['dataArray'] = ['Ray Allen', 'Reggie Miller', 'Jason Terry', 'Jason Kidd', 'Dirk Nowitzki', 'Steve Nash'];
			}
		}

		return response()->view('test/vue-js/vue-js-ctrl', ['data' => json_encode($object), 'tag' => 'span']);
	}

	public function vueDashboard(){

		$chartData = [];
		$chartData['components'] = [];

		// pie:
		$chartData['components'][0]['name'] = 'pie';
		$chartData['components'][0]['r'] = 100;
		$chartData['components'][0]['elements'] = [10, 20, 30, 40, 50];

		$chartData['components'][1]['name'] = 'pie';
		$chartData['components'][1]['r'] = 100;
		$chartData['components'][1]['elements'] = [10, 20, 150];

		//

		return response()->View('test/vue-js/vue-js-dashboard', [
			'title'=>'Dashboard',
			'chartData' => json_encode($chartData)]);
	}

	public function vueSingleFile(){
		$data = [];
		$data[0] = [];
		$data[0]['component'] = '';
		$data[0]['props'] = [];
		$data[0]['props']['rdf:type'] = 'dbo:Athlete';
		$data[0]['props']['rdfs_label'] = 'Dirk Nowitzki (en)';
		$data[0]['props']['dbp_team'] = 'dbr:Dallas_Mavericks';
		$data[0]['props']['dbo_position'] = 'dbr:Dallas_Mavericks';

		$data[1]['component'] = '';
		$data[1]['props'] = [];
		$data[1]['props']['rdf:type'] = 'dbo:Scientist';
		$data[1]['props']['rdfs_label'] = 'Albert Einstein (en)';
		$data[1]['props']['dbp_awards'] = ['dbr:Nobel_Prize_in_Physics', 'dbr:Royal_Society', 'dbr:Time_100:_The_Most_Important_People_of_the_Century'];

		$data[2]['component'] = '';
		$data[2]['props'] = [];
		$data[2]['props']['rdf:type'] = 'dbo:BasketballTeam';
		$data[2]['props']['rdfs_label'] = 'Dallas Mavericks (en)';
		$data[2]['props']['foaf_homepage'] = 'http://www.mavs.com/';

		return response()->View('test/vue-js/vue-js-sf', ['data'=>json_encode($data)]);
	}


}
