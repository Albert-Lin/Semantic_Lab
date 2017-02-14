<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;
use App\Model\RootModel;

class UserInfo extends RootModel
{
	/**
	 * set the table for model
	 * @var string
	 */
	protected  $table = 'user_infos';
	
	/**
	 * set the connection for multiple database
	 * @var string
	 */
	protected $connection = 'mysql';

	// set timestamp, default false in RootModel
	// public $timestamps = false;

	/**
	 * SELECT `id`, `name`, `email` WHERE [$arguments] ;
	 * @param array $arguments
	 * @return mixed
	 */
	public function selectNameEmail(array $arguments){
		$result = $this->select('id', 'name', 'email')
			->where($arguments)
			->get();

		return $result;
	}


	/**
	 * INSERT INTO $table (`name`, `password`, `hashPassword`, `email`) VALUES ($values);
	 * @param $values
	 * @return string
	 */
	public function insertAll($values){
        $this->name = $values->name;
        $this->URI = $values->URI;
		$this->password = $values->password;
		$this->hashPassword = $values->hashPassword;
		$this->email = $values->email;
		$this->save();

		return self::$success;
	}

}
