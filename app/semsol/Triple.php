<?php

/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/12
 * Time: 下午 05:58
 */

namespace App\semsol;

class Triple
{
    public static function triple($subject, $predicate, $object){
        $subject = self::elementRegexCheck('subject', $subject);
        $predicate = self::elementRegexCheck('predicate', $predicate);
        $object = self::elementRegexCheck('object', $object);

        return $subject.' '.$predicate.' '.$object.' . ';
    }

    private static function elementRegexCheck($type, $element){

        if(preg_match('/.*http.*/', $element)){
            $element = self::URIRegex($element);
        }
        else if(preg_match('/.*:.*/', $element)){
            $element = self::prefixRegex($element);
        }
        else if(preg_match('/^\?.*/', $element)){

        }
        else{
            if($type === 'object'){
                $element = self::literalRegex($element);
            }
        }

        return $element;
    }

    private static function URIRegex($element){
        if( !preg_match('/^<.*>/', $element) ){
            if( preg_match('/^</', $element) ){
                $element = '<'.$element;
            }
            else if( preg_match('/.*>/', $element) ){
                $element = $element.'>';
            }
            else{
                $element = '<'.$element.'>';
            }
        }

        return $element;
    }

    private static function prefixRegex($element){
        if( preg_match('/^<.*>/', $element) ){
            $element = str_replace('<', '', $element);
            $element = str_replace('>', '', $element);
        }

        return $element;
    }

    private static function literalRegex($element){
        if(!preg_match('/\".*\"@.*/', $element)){
            $element = $element."@en";
        }

        return $element;
    }

}