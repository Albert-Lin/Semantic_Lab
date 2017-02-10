<?php

namespace App\Model;

// use Illuminate\Database\Eloquent\Model;
use App\Model\RootModel;

class UserInfo extends RootModel
{
    // set the table for model:
	protected  $table = 'user_infos';

	// set timestamp, default false in RootModel





	// SELECT `id`, `name`, `email` with some arguments
	public function selectNameEmail($arguments){
		$result = $this->select('id', 'name', 'email')
			->where($arguments)
			->get();

		return $result;
	}


	// INSERT INTO * except `id`
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
