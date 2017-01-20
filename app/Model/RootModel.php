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
	protected $table = "";

	// set timestamp to false
	public $timestamps = false;


	/**
	 * SELECT * with some arguments
	 * @param $arguments
	 * @return \stdClass
	 */
	public function selectAll($arguments){
		$result = $this::where($arguments)->get();

		return $result;
	}

	/**
	 * Simple function to echo query result into text lines
	 * @param $result
	 * @return string
	 */
	public function toLines($result){
		$result = json_decode($result);
		$lines = "";
		for($i = 0; $i < count($result); $i++){
			$columns = $result[$i];
			foreach($columns as $key => $value) {
				$lines .= "[ " . $key . " ]: " . $value."<br>";
			}
		}

		return $lines;
	}

	/**
	 * Simple function to echo query result into table
	 * @param $result
	 * @return string
	 */
	public function toTable($result){
		$result = json_decode($result);
		$tHead = "<thead> <tr> <td>No.</td>";
		$tBody = "<tbody>";

		for($i = 0; $i < count($result); $i++){
			$columns = $result[$i];
			$tBody .= "<tr> <td>".$i."</td>";
			foreach($columns as $key => $value){
				if($i === 0){
					$tHead .= "<td>".$key."</td>";
				}
				$tBody .= "<td>".$value."</td>";
			}
			$tBody .= "</tr>";
			$tHead .= "</tr></thead>";
		}
		$tBody .= "</tbody>";

		return '<table class"table">'.$tHead.$tBody.'</table>';
	}
}