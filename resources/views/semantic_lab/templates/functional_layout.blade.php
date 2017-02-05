<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/2/4
 * Time: 下午 10:30
 */
?>

@extends('semantic_lab.templates.htmlBlade')

@section('body')

    @include('semantic_lab.templates.nav.simple_nav')

    <style>
        #main{
            height: calc(100% - 60px);
            border: 0;
            margin: 0;
            padding: 0;
        }
        #mainBody, #funBlock, #contentBlock{
            height: 100%;
            border: 0;
            margin: 0;
            padding: 0;
        }
        #funBlock{
            width: 100%;
            position: absolute;
            z-index: 3;
        }
            #funBody{
                height: 100%;
                padding: 0;
                background-color: #4a3155;
                opacity: 1;
                color: #ffffff;
            }
        #contentBlock{
            width: 100%;
            float: right;
        }
            #contentBody{
                height: 100%;
                background-color: #ffffff;
                font-size: 18px;
                transition: 1s;
                position: absolute;
                z-index: 4;
            }
    </style>
    <div id="main" class="row">
        <div id="mainBody" class="col-md-12 col-sm-12 col-xs-12">
            <div id="funBlock" class="row">
                <div id="funBody" class="col-md-2">
                    <div class="list-group">
                        @yield('list-group-item')
                    </div>
                </div>
            </div>
            <div id="contentBlock" class="row">
                <div id="contentBody" class="col-md-12">
                    @yield('contentBody')
                </div>
            </div>
        </div>
    </div>

    <script>
        var contentBodyStatus = '0';

        $('#funBtn').click(function(){
            if(contentBodyStatus === '0'){
                $('#contentBody').removeClass('col-md-12');
                $('#contentBody').addClass('col-md-offset-2');
                $('#contentBody').addClass('col-md-10');

                contentBodyStatus = '1';
            }
            else{
                $('#contentBody').removeClass('col-md-offset-2');
                $('#contentBody').removeClass('col-md-10');
                $('#contentBody').addClass('col-md-12');

                contentBodyStatus = '0';
            }
        });

        $('#fun03').click(function(){
            console.log("INNNNNNN");
        });
    </script>

@endsection
