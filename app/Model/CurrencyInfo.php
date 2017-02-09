<?php

namespace App\Model;

//use App\Model\RootModel;

class CurrencyInfo extends RootModel
{
    protected $table = 'currency_info';

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
