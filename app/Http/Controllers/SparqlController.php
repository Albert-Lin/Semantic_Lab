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
    public function select(Request $request){
        $this->validate($request, [
            'resource' => 'required',
            'query' => 'required'
        ]);

        $resource = $request->get('resource');
        $query = $request->get('query');
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

        $result = $tripleStore->get($query);

        if(count($result) > 0){
            $message['title'] = 'Success';
            $message['content'] = $result;
            $message['key'] = $tripleStore->getSelectKeys();
        }
        else{
            $message['title'] = 'Error';
            $message['content'] = 'There is no result for query';
        }

        return json_encode($message);
    }
}