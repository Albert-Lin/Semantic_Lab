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

}