<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/2
 * Time: 下午 04:13
 */

namespace App\Http\Controllers;

use App\Http\Controllers\RootController;
use App\Model\UserInfo;
use Illuminate\Http\Request;

class SemanticLabController extends RootController
{
    /**
     * "POST" function for user login
     * @param Request $request
     * @return string
     */
    public function login(Request $request){
        // 01. validate raw data
        $this->validate($request, [
            'mail' => 'required',
            'pass' => 'required'
        ]);

        // 02. get raw data
        $mail = $request->get('mail');
        $password = $request->get('pass');

        // 03. initialize model
        $userInfoTb = new UserInfo();

        // 04. select DB data
        $hashPass = "";
        $message['title'] = "Error";
        $message['content'] = "No current username or password is wrong ";

        $queryResult = $userInfoTb->select('name', 'hashPassword')->where([ ['email', $mail], ['password', $password] ])->get();
        $result = json_decode($queryResult);
        $numOfResult = count($result);
        if($numOfResult === 1){
            $account = $result[0]->name;
            $hashPass = $result[0]->hashPassword;

            // 05. check hashing value
            if(\Hash::check($password, $hashPass)){
                $message['title'] = "Redirect";
                $message['content'] = \Config::get('app.domainName');
                // 06. set session
                $request->session()->put('account', $account);

                // 07. set cookie
                $info = \App\Utility\Cookie::settingInfo($request, 'mail', $mail);
                if($info !== null) {
                    return response(json_encode($message))->cookie($info['name'], $info['value'], $info['time'], $info['path']);
                }
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

    /**
     * Logout function
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request){
        $request->session()->forget('account');
        return redirect()->route('root');
    }

    /**
     * "POST" function for new user register
     * @param Request $request
     * @return string
     */
    public function register(Request $request){
        $message['title'] = '';
        $message['body'] = '';
        $userInfoTb = new UserInfo();

        // 01. validate
        $this->validate($request, [
            'userName' => 'required',
            'pass' => 'required',
            'mail' => 'required',
        ]);
        $userName = $request->get('userName');
        $pass = $request->get('pass');
        $mail = $request->get('mail');

        // 02. check unique data
        $uniqueData['name'] = $userName;
        $uniqueData['email'] = $mail;
        $checkResult = $userInfoTb->unique($uniqueData);
        if($checkResult === \App\Model\RootModel::$success){

            // 03. insert data
            $values = new \stdClass();
            $values->name = $userName;
            $values->URI = \Config::get('app.domainName')."resource/".str_replace(" ", "_", $userName);
            $values->password = $pass;
            $values->hashPassword = \Hash::make($values->password);
            $values->email = $mail;
            $insertResult = $userInfoTb->insertAll($values);

            // 04. send email or redirect
            if($insertResult === \App\Model\RootModel::$success){
                $message['title'] = 'Redirect';
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

    /**
     * "POST" function for input auto complete
     * @param Request $request
     * @param $searchData
     * @return string
     */
    public function autoInputSearch(Request $request, $searchData){
        $result = '';
        $value = $request->get('input');
        if(isset($value) && $value !== null) {
            $name = $request->get('cookieName');
            if ($searchData === 'cookie') {
                $cookie = \App\Utility\Cookie::getValues($request, $name);
                $result = \App\Utility\Utility::arrayRegexSearch($value, $cookie);
            }
        }
        else{
            $result = 'none';
        }

        return json_encode($result);
    }



}