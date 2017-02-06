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

    protected $renderView = '';
	protected $data = [];
	protected $nav = [];

	public function index(Request $request){
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
		}

		// 03. render view
        return View($this->renderView)
            ->with('data', $this->data);
	}

	public function login(Request $request){
		// 01. validate raw data
		$this->validate($request, [
			'account' => 'required',
			'pass' => 'required'
		]);

		// 02. get raw data
		$account = $request->get('account');
		$password = $request->get('pass');

		// 03. initialize model
		$userInfoTb = new UserInfo();

		// 04. select DB data
		$hashPass = "";
		$message['title'] = "Error";
		$message['content'] = "No current username or password is wrong ";
		$queryResult = $userInfoTb->select('hashPassword')->where([ ['name', $account], ['password', $password] ])->get();
		$result = json_decode($queryResult);
		$numOfResult = count($result);
		if($numOfResult === 1){
			$hashPass = $result[0]->hashPassword;

			// 05. check hashing value
			if(\Hash::check($password, $hashPass)){
                $message['title'] = "Redirect";
                $message['content'] = \Config::get('app.domainName');
				// 06. set session
				$request->session()->put('account', $account);
			}
			else{
                $message['content'] .= "(code:sl01).";
			}
		}
		else if($numOfResult === 0){
            $message['content'] .= "(code:sl02)";
		}
		else{
            $message['content'] .= "(code:sl03)";
		}

		return json_encode($message);

	}

	public function logout(Request $request){
		$request->session()->forget('account');
		return redirect()->route('root');
	}

	public function register(Request $request){
        $message['title'] = '';
        $message['body'] = '';
        $userInfoTb = new UserInfo();

	    // 01. validate
        $this->validate($request, [
            'username' => 'required',
            'pass' => 'required',
            'mail' => 'required',
        ]);
        $username = $request->get('username');
        $pass = $request->get('pass');
        $mail = $request->get('mail');

        // 02. check unique data
        $uniqueData['email'] = $mail;
        $checkResult = $userInfoTb->unique($uniqueData);
        if($checkResult === true){

            // 03. insert data
            $values = new \stdClass();
            $values->name = $username;
            $values->password = $pass;
            $values->hashPassword = \Hash::make($values->password);
            $values->email = $mail;
            $insertResult = $userInfoTb->insertAll($values);

            // 04. send email or redirect
            if($insertResult === $userInfoTb->success){
                $message['title'] = 'Redirect';
//                $message['content'] =  'Please read the registered email for completed register.';
                $message['content'] =  \Config::get('app.domainName');
            }
        }
        else{
            $message['title'] = 'Error';
            $message['content'] =  $checkResult.' had been registered, please try new one.';
        }

        // 05. return
        return json_encode($message);
    }

	protected function setFuns(){}

	protected function nonLogin(){
        $this->renderView = 'semantic_lab/general';
        $this->data['title'] = 'Semantic Lab';
        $this->data['domainURI'] = \Config::get('app.domainName');
    }

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
}