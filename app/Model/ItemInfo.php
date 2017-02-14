<?php

namespace App\Model;

use App\Model\RootModel;

class ItemInfo extends RootModel
{
	/**
	 * set the table for model
	 * @var string
	 */
	protected  $table = 'item_info';

	/**
	 * set the connection for multiple database
	 * @var string
	 */
	protected $connection = 'mysql';

	/**
	 * INSERT INTO $table (`URI`, `rdf_type`, `rdfs_label`) VALUES ($values);
	 * @param $values
	 * @return string
	 */
	public function insertAll($values){
		$this->URI = $values->uri;
		$this->rdf_type = $values->type;
		$this->rdfs_label = $values->label;
		$result = $this->save();

		if($result === true){
			return self::$success;
		}
		else{
			return self::$error;
		}
	}
}
