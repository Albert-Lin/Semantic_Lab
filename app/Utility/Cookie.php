<?php

/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/8
 * Time: 上午 12:37
 */

namespace App\Utility;

class Cookie
{
    public static function getNameList(){
        $result = [];
        foreach($_COOKIE as $key => $value){
            $result[] = $key;
        }

        return $result;
    }

    public static function getValues($name){
        if(isset($_COOKIE[$name])){
            $result = json_decode($_COOKIE[$name], true);
            if($result === null){
                return $_COOKIE[$name];
            }
            else{
                return $result;
            }
        }
        else{
            return null;
        }
    }

    public static function getLatestValue($name){
        $cookie = self::getValues($name);
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

    public static function existCookie($name, $value){
        $cookie = self::getValues($name);
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

    public static function setCookie($name, $value, $seconds=null){
        $cookie = self::getValues($name);
        $exist = self::existCookie($name, $value);

        if($seconds === null){
            $seconds = 86400*30;
        }

        if($cookie !== null){
            if($exist === false) {
                if (is_array($cookie)) {
                    $cookie[] = $value;
                    setcookie($name, json_encode($cookie), time() + $seconds, '/');
                } else {
                    $array = [];
                    $array[] = $cookie;
                    $array[] = $value;
                    setcookie($name, json_encode($array), time() + $seconds, '/');
                }
            }
        }
        else{
            $array = [];
            $array[] = $value;
            setcookie($name, json_encode($array), time()+$seconds, '/');
        }
    }

    public static function deleteCookie($name){
        $cookie = self::getValues($name);
        if($cookie !== null){
            setcookie($name, '', time()-3600, '/');
        }
    }

    public static function deleteSpecialValue($name, $value){
        $cookie = self::getValues($name);
        if($cookie !== null){
            if(is_array($cookie)){
                if (($key = array_search($value, $cookie)) !== false) {
                    unset($cookie[$key]);
                }
                setcookie($name, json_encode($cookie), time()+(86400*30), '/');
            }
            else{
                setcookie($name, '', time()-3600, '/');
            }
        }
    }
}