<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/13
 * Time: 上午 12:59
 */

namespace App\Http\Controllers;

use App\Http\Controllers\RootController;
use Illuminate\Http\Request;
use App\semsol\arc2\TripleStore;

class SparqlController extends RootController
{
	private $insertRegex = '/.*[iI][nN][sS][eE][rR][tT].*/';
	private $deleteRegex = '/.*[dD][eE][lL][eE][tT][eE].*/';
	private $updateRegex = '/.*[uU][pP][dD][aA][tT][eE].*/';
	private $selectRegex = '/.*[sS][eE][lL][eE][cC][tT].*/';

	public function insert(Request $request){

	}

    public function select(Request $request){
		// 01. validation
        $this->validate($request, [
            'resource' => 'required',
            'query' => 'required'
        ]);

        // 02. get POST data
        $resource = $request->get('resource');
        $query = $request->get('query');

        // 03. action validate by checking sparql with regex
        $regexMatch[] = $this->selectRegex;
		$regexDisMatch = [$this->insertRegex, $this->deleteRegex, $this->updateRegex];
		$matchCheck = \App\Utility\Utility::regexsSearch($regexMatch, $query, 'and');
		$disMatchCheck = \App\Utility\Utility::regexsSearch($regexDisMatch, $query, 'or');
		if($matchCheck === true && $disMatchCheck === false){

			// 04. set up TripleStore
			$tripleStore = '';
			$message = [];

			if($resource === 'DBpedia'){
				$tripleStore = new TripleStore('dbpedia');
			}
			else if($resource === 'WordNet'){

			}
			else{
				$tripleStore = new TripleStore();
			}

			// 05. query sparql
			$result = $tripleStore->get($query);

			// 06. set message for returning
			if(count($result) > 0){
				$message['title'] = 'Success';
				$message['content'] = $result;
				$message['key'] = $tripleStore->getSelectKeys();
			}
			else{
				$message['title'] = 'Error';
				$message['content'] = 'There is no result for query';
			}
		}
		else{
			$message['title'] = 'Error';
			$message['content'] = 'Illegal query action.';
		}


        return json_encode($message);
    }
}