<?php

/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/8
 * Time: 上午 12:37
 */

namespace App\Utility;

use Illuminate\Http\Request;

class Cookie
{
    public static function getNameList(){
        $result = [];
        foreach($_COOKIE as $key => $value){
            $result[] = $key;
        }

        return $result;
    }

    public static function getValues(Request $request, $name){
    	$cookie = $request->cookie($name);
        if(isset($cookie) && $cookie !== null){
            $result = json_decode($cookie, true);
            if($result === null){
                return $cookie;
            }
            else{
                return $result;
            }
        }
        else{
            return null;
        }
    }

    public static function getLatestValue(Request $request, $name){
        $cookie = self::getValues($request, $name);
        if($cookie !== null){
            if(is_array($cookie)){
                $length = count($cookie);
                return $cookie[$length-1];
            }
            else{
                return  $cookie;
            }
        }
        else{
            return null;
        }
    }

    public static function existCookie(Request $request, $name, $value){
        $cookie = self::getValues($request, $name);
        if($cookie !== null){
            if(is_array($cookie)){
                if(($key = array_search($value, $cookie)) !== false){
                    return true;
                }
                else{
                    return false;
                }
            }
            else if($cookie === $value){
                return true;
            }
            else{
                return false;
            }
        }
    }

    public static function settingInfo(Request $request, $name, $value){
        $cookie = self::getValues($request, $name);
        $exist = self::existCookie($request, $name, $value);

        if($cookie !== null){
            if($exist === false) {
                if (is_array($cookie)) {
                    $cookie[] = $value;

					return self::returnInfo($name, json_encode($cookie));

                } else {
                    $array = [];
                    $array[] = $cookie;
                    $array[] = $value;

					return self::returnInfo($name, json_encode($array));
                }
            }
        }
        else{
            $array = [];
            $array[] = $value;

			return self::returnInfo($name, json_encode($array));
        }
    }

    public static function deletingInfo(Request $request, $name){
		return self::returnInfo($name, '', -3600);
    }

    public static function specialDeletingInfo(Request $request, $name, $value){
        $cookie = self::getValues($request, $name);
        if($cookie !== null){
            if(is_array($cookie)){
                if (($key = array_search($value, $cookie)) !== false) {
                    unset($cookie[$key]);
                }
				return self::returnInfo($name, json_encode($cookie));
            }
            else{
				return self::returnInfo($name, '', -3600);
            }
        }
        else{
			return self::returnInfo($name, '', -3600);return self::returnInfo($name, '', -3600);
		}
    }

    private static function returnInfo($name, $value='', $minutes=(1440*30), $path='/'){
		$info = [];
		$info['name'] = $name;
		$info['value'] = $value;
		$info['time'] = $minutes;
		$info['path'] = $path;

		return $info;
	}

}