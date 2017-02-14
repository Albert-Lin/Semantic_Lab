<?php

/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/12
 * Time: 上午 01:47
 */

namespace App\semsol\arc2;

use App\semsol\Triple;
use Psy\Exception\ErrorException;

class TripleStore
{
    private $TripleStore;

    private $prefixs = [
        'owl' => '<http://www.w3.org/2002/07/owl#>',
        'rdf' => '<http://www.w3.org/1999/02/22-rdf-syntax-ns#>',
        'rdfs' => '<http://www.w3.org/2000/01/rdf-schema#>',
        'xml' => '<http://www.w3.org/XML/1998/namespace>',
        'xsd' => '<http://www.w3.org/2001/XMLSchema#>',
        'foaf' => '<http://xmlns.com/foaf/0.1/>',
        'dbo' => '<http://dbpedia.org/ontology/>',
        'dbp' => '<http://dbpedia.org/property/>',
        'dbr' => '<http://dbpedia.org/resource/>',
        'smo' => '<http://semanticlab.com/ontology/>',
        'smp' => '<http://semanticlab.com/property/>',
        'smr' => '<http://semanticlab.com/resource/>',
    ];

    private $distinct = '';

    private $selects = [];

    private $triples = [];

    private $filters = [];

    private $errorMesg = 'ERROR: ';

    function __construct($storeResource = null){

        if(!isset($storeResource) || $storeResource === null){
            $this->localStoreConfig();
        }
        else if($storeResource === 'dbpedia'){
            $this->dbpediaConfig();
        }
    }

    // CONFIG:
    private function localStoreConfig(){
        $config = [
            /* db */
            'db_name' => \Config::get('app.tripleStore')['database'],
            'db_user' => \Config::get('app.tripleStore')['username'],
            'db_pwd' => \Config::get('app.tripleStore')['password'],
            /* store */
            'store_name' => 'rdf',
            /* stop after 100 errors */
            'max_errors' => 100,
        ];

        $this->TripleStore = \ARC2::getStore($config);
        if (!$this->TripleStore->isSetUp()) {
            $this->TripleStore->setUp();
        }
    }

    private function dbpediaConfig(){
        $config = array(
            "remote_store_endpoint" => "http://dbpedia.org/sparql",
        );

        $this->TripleStore = \ARC2::getRemoteStore($config);
    }


    // PREFIX:
    public function setPrefixs(array $prefixArray){
        foreach ($prefixArray as $prefix => $IRI){
            foreach($this->prefixs as $origPrefix => $origIRI){
                if($IRI === $origIRI && $prefix !== $origPrefix){
                    $this->prefixs[$prefix] = $IRI;
                    unset($this->prefixs[$origPrefix]);
                }
            }
        }
    }

    private function prefixToString(){
        $prefixString = '';
        foreach($this->prefixs as $prefix => $IRI){
            $prefixString .= 'PREFIX '.$prefix.': '.$IRI.' ';
        }
        return $prefixString;
    }

    // SELECT:
    public function select(array $keys, $distinct = false){

        $this->distinct = '';
        $this->selects = [];

        if($distinct !== false){
            $this->distinct = 'DISTINCT';
        }

        foreach($keys as $key => $value){
            if(preg_match('/^\?.*/', $value)){
                $this->selects[] = str_replace('?', '', $value);
            }
            else{
                $this->selects[] = $value;
            }
        }

        return $this;
    }

    public function getSelectKeys(){
        return $this->selects;
    }

    // WHERE:
    public function where(array $tripleArray){
        $this->triples = [];
        $this->triples = $tripleArray;
        return $this;
    }

    // FILTER:
    public function filter(array $filterArray){
        $this->filters = [];
        return $this;
    }

    // QUERY:
    public function get($sparql = null){
        $query = '';
        if($sparql !== null){
            $query .= $this->prefixToString().$sparql;
        }
        else{
            // PREFIX
            $query .= $this->prefixToString();

            // SELECT
            $query .= "SELECT ";
            if($this->distinct === true){
                $query .= "DISTINCT ";
            }
            foreach($this->selects as $key => $select){
                $query .= "?".$select." ";
            }

            // WHERE
            $query .= "WHERE { ";
            foreach($this->triples as $key => $triple){
                $query .= $triple;
            }
            foreach($this->filters as $key => $filter){
                $query .= $filter;
            }
            $query .= " }";
        }

		$result = $this->TripleStore->query($query);

        if($sparql !== null){
			if(preg_match('/\.*?.*/', $sparql)){
				$this->selects = $result['result']['variables'];
			}
		}

		if(isset($result['result']['rows']) && isset($result['result'])){
			return $result['result']['rows'];
		}
		else{
			return [];
		}

    }
    


}