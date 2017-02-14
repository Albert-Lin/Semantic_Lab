<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/1/20
 * Time: 上午 11:17
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RootModel extends Model
{
	/**
	 * set timestamp to false
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Success status for model return and controller checking
	 * @var string
	 */
    public static $success = 'Success';

	/**
	 * Error status for model return and controller checking
	 * @var string
	 */
    public static $error = 'Error';

	/**
	 * Insert all data into specific table, it used to be override.
	 * @param $values
	 */
	public function insertAll($values){
	}

	/**
	 * SELECT * with some arguments, it used to be override
	 * @param $arguments
	 * @return \stdClass
	 */
	public function selectAll($arguments){
		$result = $this::where($arguments)->get();

		return $result;
	}

	/**
	 * Check the input data exist or not
	 * @param $dataArray : key-value array
	 * @return string
	 */
	public function unique($dataArray){
	    $result = self::$success;
	    $index = 0;
	    foreach($dataArray as $key => $value){
            $queryResult = $this->select('id')->where([ [$key, $value] ])->get();
	        if(count($queryResult) !== 0){
	            if($index === 0) {
					$result = $key;
				}
				else{
					$result .= ", ".$key;
				}
				$index++;
            }
        }

        return $result;
    }



    // none test:
    public function autoComplete($data){
	    $result = [];
        $key = $data['key'];
        $value = $data['value'].'%';
	    $queryJsonResult = $this->select($key)->where([ [$key, 'LIKE', $value] ])->get();
        $queryResult = json_decode($queryJsonResult);
	    foreach($queryResult as $index => $object){
            $result[] = $object->$key;
        }

	    return $result;
    }
}