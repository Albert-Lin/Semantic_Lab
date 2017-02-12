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

/**
 * Description of TestController
 *
 * @author Albert Lin
 */
class TestController extends Controller{

	/*
	 * This is a most simple action of controller,
	 * we do something here,
	 * usually, the code in here mostly similar as pseudo code,
	 *  and also, we might going to pass data by using View()->with('key', 'value');
	 */
	public function index(){
		// pass data to the mapping view:
		Return View( 'test/index')
					->with( 'title', 'Semantic Lab' )
					->with( 'bodyMessage', ' Well done! This is the most simple action in controller.');
	}

	/*
	 * At pass, while passing request from url,
	 * we always using ?key=value,
	 * but now, because of route strategy,
	 * we can pass request inner url path,
	 */
	public function beautyURL($category, $page){
		echo "We get get category & page variables from Url path, and both of them are: <br>";
		echo "Category: ".$category."<br>";
		echo "Page: ".$page."<br>";
	}


	/*
	 * VIEW & TEMPLATE:
	 */
	public function viewTemp($tempNum){
		if($tempNum < 3) {
			return View('test/view/temp')
				->with('title', 'Template ' . $tempNum);
		}
	}


	/*
	 * MODEL
	 */
	public function modelNote(){
	    return View('test/model/note')
            -> with('title', 'Note for create model complete process');
    }

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

	public function unique(){
		$model = new \App\Model\ItemInfo();
		$uniqueData['URI'] = 'http://semanticlab.com/Headphones';
		$checkResult = $model->unique($uniqueData);
		var_dump($checkResult);
	}

	/*
	 * ROUTE:
	 */
	/*
	 * Get all the route in routes/api.php && routes/web.php.
	 * Dont't forget to import(use) class for Route:
	 * Illuminate\Support\Facades\Route 
	 */
	public function getRouteList(){

		$routeCollection = Route::getRoutes();

		foreach ($routeCollection as $value) {
			echo $value->getPath()."<br>";
		}
	}

	public function getRouteListInView(){

		$routeCollection = Route::getRoutes();
		$routeList = [];
		$index = 0;
		foreach ($routeCollection as $value) {
//						echo $value->getPath()."<br>";
			$routeList[$index] = $value->getPath();
			$index++;
		}

		return View('test/route/routeList')
						->with('routeList', $routeList)
						->with('title', 'Route List');
	}


	/*
	 * REQUEST:
	 */
	/*
	 * Test the request methods
	 */
	public function request(){
		return View('test/request')
					->with('title', 'Request:');
	}

	/*
	 * In this controller we show how to get the requests data.
	 * Don't forget to import(use) class of Request:
	 * Illuminate\Http\Request;
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

	/*
	 * This controller show how to access variables in URL path
	 */
	public function getUrlRequest(Request $request, $category, $page){
		echo "We get get category & page variables from \"Request\", and both of them are: <br>";
		echo "Category: ".$request->category."<br>";
		echo "Page: ".$request->page."<br>";
	}

	/*
	 * SESSION:
	 */
	/*
	 * This controller show how to set session
	 */
	public function setSession(Request $request){
		// set the session by instance of Request
		$request->session()->put( 'instancePassword', 'I-love4451');

		// set the session by using global helper
		session([ 'globalPassword' => 'G-love4451' ]);

		// let's view the result
		return View( 'test/session' )
						->with( 'title', 'Session' );
	}

	/*
	 * This controller show how to get the session
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

	/*
	 * This controller show the methods to remove/delete the session
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


	/*
	 * COOKIE:
	 */
	/*
	 * We have not find better than native php cookie function
	 */

    public function viewCookie(){
        var_dump($_COOKIE);
    }

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

    public function setC(){
    	$data = [];
		$data['title'] = 'Semantic Lab';
		$data['domainURI'] = \Config::get('app.domainName');
    	return response()
			->view('semantic_lab/general', ['data'=>$data])
			->cookie('re', 'val', 36400, '/');
	}

	public function getC(Request $request){
		$value = $request->cookie('re');
		var_dump($value);
		var_dump($_COOKIE);
	}


	/*
	 * SECURITY
	 */
	/*
	 * Hashing function, don't forget adding using namespace as below for used:
	 * use Illuminate\Support\Facades\Hash;
	 */
	public function hashing($data){

		$hashValue = Hash::make($data);

		echo "original data: ".$data."<br>hashing value: ".$hashValue."<br>";

		$checkHash = Hash::check($data, $hashValue);
		if($checkHash === true){
			echo "check: ".$checkHash."<br>";
		}
	}

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
	/*
	 * Validation
	 * more Laravel validation rules:
	 * https://laravel.com/docs/5.3/validation#available-validation-rules
	 * The rule "unique:{db table name}" means the given variable must "exist" and unique in table
	 */
	public function valiData(){
		return View('test/security/validation/valiForm')
			->with('title', 'VALIDATION FORM')
			->with('domainName', \Config::get('app.domainName'));
	}

	public function valiProcess(Request $request){
		$this->validate($request, [
			'username' => 'required|min:6|max:20',
			'password' => 'required|min:6|max:12',
			'email' => 'required|email|unique:user_infos'
		]);

		echo "= w =";
	}

	/*
	 * API:
	 */
	/*
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

	/*
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

	/*
	 * Processing P5.js
	 */
	public function p5(){
		return View('test/p5/index')
				->with('title', 'P5');
	}

	public function p5Linked(){
		return View('test/p5/linked')
				->with('title', 'P5');
	}

	/*
	 * D3:
	 */
	public function d3(){
		return View('test/d3/index')
				->with('title', 'D3');
	}

	public function d3Svg(){
		return View('test/d3/svg')
				->with('title', 'D3 SVG');
	}

	public function d3SvgJson(){
		return View('test/d3/svgJson')
				->with('title', 'D3 SVG JSON');
	}
	
	public function path(){
			return View('test/d3/svg_path')
						->with('title', 'SVG PATH');
	}

	/*
	 * NEO4J:
	 */
	public function  neo4j(){
		return View('test/neo4j/index')
				->with('title', 'NEO4j JS');
	}

	public function vis(){
		return View('test/neo4j/visualization')
				->with('title', 'Visualization');
	}
	
	public function visMVC(){
		return View('test/neo4j/vis_mvc')
				->with('title', 'VIS MVC');
	}


	/*
	 * GOOGLE MAP:
	 */
	public function gmap(){
		return View('test/google/map/index')
				->with('title', 'Google Map');
	}

	public function googleMap(){
		return View('test/google/map/index_class')
				->with('title', 'Google Map');
	}

	public function googleCarMap(){
		return View('test/google/map/car/car')
				->with('title', 'Google Car Map');
	}


	/*
	 * EXCUTE EXTERNAL FILE :
	 */
	/*
	 * This is a function to excute external file.
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


	/*
	 * CSS:
	 */
	public function sideBarTrans(){
		return View('test/css/side_bar_trans')
					->with('title', 'CSS TRANSITION');
	}
	
	public function leftTabs(){
			return View('test/css/left_tabs')
						->with('title', 'CSS LEFT TABS');
	}

	public function grid(){
		return View('test/css/grid')
			->with('title', 'CSS GRID');
	}

	public function bsSideBarTrans(){
        return View('test/css/bs_side_bar_trans')
            ->with('title', 'BS Side Bar Trans');
    }


    /*
     * FACEBOOK
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


	/*
	 * UTILITY:
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


	/*
	 * RDF/TRIPLE STORE
	 */
	public function tripleStore(){
	    $tripleStore = new TripleStore();
    }

    public function dbpedia(){
	    $query = 'SELECT DISTINCT dbr:Dirk_Nowitzki ?p ?o '.
        'WHERE{ '.
        '  ?s ?p ?o.'.
        '}';

	    $tripleStore = new TripleStore('dbpedia');
	    $result = $tripleStore->get($query);

	    var_dump($result['result']);
    }

    public function arc2QueryBuilder(){
        $tripleStore = new TripleStore('dbpedia');
        $result = $tripleStore->select(["?s", "?p", "?o"], true)->where([
            Triple::triple('?s', 'rdfs:label', '"Dirk Nowitzki"'),
            Triple::triple('?s', '?p', '?o'),
        ])
        ->get();

        var_dump($result);
    }

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


    /*
     * TEST
     */
    public function regex($regex){

        $languageDir = $this->getLanguageDir('en-US');
        $regex = str_replace('/', '\/', $regex);
        $result = $this->scanDirFiles($languageDir, $regex);
        foreach($result as $key => $file){
            echo $file."<br>";
        }

    }

    private function scanDirFiles($path, $regex){

        $fileList = [];
        $fileIndex = 0;
        if(is_dir($path)){
            $allDir = scandir($path);
            foreach($allDir as $key => $dir){
                $subDirPath = $path.'/'.$dir;
                $subDirPath = str_replace('\\', '/', $subDirPath);

                if($dir !== '.' && $dir !== '..') {
                    if (is_dir($subDirPath)) {
                        $allFile = $this->scanDirFiles($subDirPath, $regex);
                        foreach($allFile as $subKey => $file){
                            $fileList[$fileIndex] = $file;
                            $fileIndex++;
                        }
                    }
                    else if (is_file($subDirPath)) {
                        if (preg_match('/'.$regex.'/', $subDirPath)) {
                                $fileList[$fileIndex] = $subDirPath;
                                $fileIndex++;
                        }
                    }
                }
            }
        }

        return $fileList;

    }

    private function getLanguageDir($language){
        return 'D:\Desktop\yii\message\en'.'/'.$language;
    }



}
