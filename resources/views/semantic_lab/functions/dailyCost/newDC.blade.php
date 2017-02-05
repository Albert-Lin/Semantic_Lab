<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/5
 * Time: 下午 09:46
 */
?>

@extends('semantic_lab.personal')

@section('contentBody')
    @if(isset($data['funName']) &&  $data['funName'] === 'dailyCost/newDC')

        <style>
            #scForm{
                height: 100%;
            }
            #scFormBlock{
                height: 80%;
                margin-top: 5%;
                background-color: #2a88bd;
            }
        </style>
        <div id="scForm" class="row">
            <div id="scFormBlock" class="col-md-offset-3 col-md-6">

            </div>
        </div>

    @endif
@endsection
