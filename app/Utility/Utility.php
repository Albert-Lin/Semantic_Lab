<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/8
 * Time: 上午 09:07
 */

namespace App\Utility;


class Utility
{
	/**
	 * An function for iterator regex search (only for start with head /^/)
	 * @param $value
	 * @param $array
	 * @return array
	 */
	public static function arrayRegexSearch($value, $array){
		$result = [];
		if(is_array($array)){
			foreach($array as $key => $arrayValue){
				if(!is_array($arrayValue) && preg_match('/^'.$value.'.*/', $arrayValue, $match)) {
					$result[] = $arrayValue;
				}
				else if(is_array($arrayValue)){
					$subResults = self::arrayRegexSearch($value, $arrayValue);
					foreach($subResults as $key => $subVlaue){
						$result[] = $subVlaue;
					}
				}
			}
		}
		else if(preg_match('/^'.$value.'.*/', $array, $match)){
			$result[] = $array;
		}

		return $result;
	}

	public static function regexsSearch($regexs, $value, $andOr = 'and'){
		$result = true;
		if(is_array($regexs)){
			foreach($regexs as $key => $regex){
				if(isset($value) && preg_match($regex, $value)){
					if($andOr === 'or'){
						$result = true;
						break;
					}
				}
				else{
					if($andOr === 'and'){
						$result = false;
						break;
					}
					else if($andOr === 'or'){
						$result = false;
					}
				}
			}
		}
		else{
			if(!isset($value) || !preg_match($regexs, $value)){
				$result = false;
			}
		}

		return $result;
	}

}