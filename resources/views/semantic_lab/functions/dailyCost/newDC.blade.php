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
    {{--@if(isset($data['funName']) &&  $data['funName'] === 'dailyCost/newDC')--}}

        <style>
            #scForm{
                height: 100%;
            }
            #scFormBlock{
                height: 80%;
                margin-top: 5%;
                background-color: #2a88bd;
            }

            #boxA{
                height: 100px;
                width: inherit;
                background-color: #00bb66;
            }

            #boxB{
                height: 100px;
                width: inherit;
                background-color: #ff4444;
            }

        </style>
        <div id="scForm" class="row">
            <div id="scFormBlock" class="col-md-offset-3 col-md-6">

            </div>
        </div>

        <div class="row h100">
            <div class="col-md-3">
                <div id="boxA" class="rectangle">A</div>
            </div>
            <div class="col-md-offset-3 col-md-3">
                <div id="boxB" class="rectangle">B</div>
            </div>
        </div>
        <script>
            $(function(){
				$('.rectangle').on('mousedown', function(){
					console.log($(this).html());
				});
				$('.rectangle').on('mouseup', function(){
					console.log($(this).html());
				});
            });
        </script>


    {{--@endif--}}
@endsection
