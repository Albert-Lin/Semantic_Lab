<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/2
 * Time: 下午 05:01
 */
?>

@extends('semantic_lab.templates.htmlBlade')


@section('css')
    @parent
@endsection


@section('js')
    @parent
@endsection


@section('body')
    <style>
        #container{
            width: 100%;
            height: 100%;
            border: 0;
            margin: 0;
            padding: 0;
            display: inline-block;
        }
        #container::before {
            content: '';
            width: 0;
            height: 25%;
            display: inline-block;
            position: relative;
            vertical-align: middle;
        }

        .row{
            margin: 0;
        }

        #logoText{
            text-align: center;
            color: #ff7766;
            font-size: 100px;
        }

        #infoBlock{
            text-align: center;
            color: #aaaaaa;
            /*color: #ffffff;*/
            font-size: 20px;
            font-weight: 600;
        }
        #infoBlock::before{
            content: '';
            width: 100%;
            height: 50px;
            display: inline-block;
        }
    </style>

    <div id="container">
        <div class="row">
            <div id="logoText" class="col-md-offset-2 col-md-8 col-sm-offset-1 col-md-10 col-xs-12">
                @section('logoText')
                @show
            </div>
        </div>

        <div class="row">
            <div id="infoBlock" class="col-md-offset-2 col-md-8 col-sm-offset-1 col-md-10 col-xs-12">
                @section('infoBlock')
                @show
            </div>
        </div>
    </div>
@endsection

