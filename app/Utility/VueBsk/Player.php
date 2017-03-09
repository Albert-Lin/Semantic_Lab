<?php

/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/3/9
 * Time: 下午 05:24
 */
class Player{

	private $playerId;
	private $allData;

	function __construct($playerId){
		$this->playerId = $playerId;
		$this->allData = [];
	}

	public function setPersonInfo(){
		// these should get from model, however for testing, we just make it static:
		if($this->playerId === 'd41'){
			$this->allData['name'] = 'Dirk Nowitzki';
			$this->allData['img'] = 'http://nocoastbias.com/wp-content/uploads/2014/06/dirk.jpg';
			$this->allData['number'] = '41';
			$this->allData['team'] = 'Dallas Mavericks';
			$this->allData['position'] = 'PF';
		}
		else if($this->playerId === 't21'){
			$this->allData['name'] = 'Tim Duncan';
			$this->allData['img'] = 'https://i.dongtw.com/2015/04/hi-res-c7212b09d107dd6a1d58cabf5911e62e_crop_north.jpg';
			$this->allData['number'] = '21';
			$this->allData['team'] = 'San Antonio Spurs';
			$this->allData['position'] = 'PF';
		}
		else if($this->playerId === 'k24'){
			$this->allData['name'] = 'Kobe Bryant';
			$this->allData['img'] = 'http://www.bonavida.com.hk/wp-content/uploads/2014/02/101413-Kobe.jpg';
			$this->allData['number'] = '24';
			$this->allData['team'] = 'Los Angeles Lakers';
			$this->allData['position'] = 'SG';
		}
	}

	public function setPFInfo(){
		
	}

	public function setSGInfo(){

	}
}

?>

