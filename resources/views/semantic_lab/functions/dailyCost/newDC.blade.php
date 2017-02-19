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


            .box0{
                padding: 0;
                border: 0;
                margin: 0;
            }


            .iconCardBox{
                border: 0;
                padding: 10px;
                margin: 0;
                /*background-color: #3C4858;*/
                background-color: #ffffff;
            }

            .icIconBlock{
                width: 80px;
                height: 80px;
                border: 0;
                border-radius: 5px;
                padding: 15px;
                margin-left: 15px;
                margin-right: 15px;
                background-color: #f0564e;
                position: absolute;
                z-index: 50;
                box-shadow: 0 0 15px 0 rgba(255, 100, 100, 0.6);
            }

            .icIcon{
                width: 50px;
                height: 50px;
                border: 0;
                padding: 10px;
                margin: 0;
                color: #ffffff;
                font-size: 30px;
            }

            .icContentBlock{
                padding: 0;
                border: 0;
                margin: 0;
            }

            .icContent{
                border: 0;
                border-radius: 5px;
                padding: 10px;
                margin: 0;
                margin-top: 20px;
                background-color: #ffffff;
                position: absolute;
                z-index: 49;
                box-shadow: 0 0 10px 1px rgba(100, 100, 100, 0.6);
            }
            .icTitle{
                min-height: 65px;
                text-align: right;
            }
            hr{
                border-color: #bbbbbb;
                margin-top: 10px;
                margin-bottom: 10px;
            }





            .layoutBox2{
                border: 0;
                padding: 10px;
                margin: 0;
                background-color: #ffffff;
            }
            .lb2Title{
                width: calc(100% - 40px);
                min-height: 60px;
                padding: 15px;
                border: 0;
                border-radius: 5px;
                margin-left: 20px;
                background-color: #ff4444;
                box-shadow: 0 0 25px 0 rgba(255, 100, 100, 0.6);
                position: absolute;
                z-index: 50;
                line-height: 30px;
                overflow-y: hidden;
                font-size: 25px;
                font-weight: 400;
            }
            .lb2BodyBlock{
                padding: 0;
                border: 0;
                margin: 0;
            }
            .lb2Body{
                min-height: 150px;
                border: 0;
                border-radius: 5px;
                padding: 55px 20px 20px 20px;
                margin: 20px 0 0 0;
                background-color: #ffffff;
                position: absolute;
                z-index: 49;
                box-shadow: 0 0 10px 1px rgba(100, 100, 100, 0.6);
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

        <div class="row h100">

            <div class="col-md-2">
                <div class="iconCardBox h100">
                    <div class="icIconBlock">
                        <div class="icIcon glyphicon glyphicon-leaf"></div>
                    </div>
                    <div class="icContentBlock row">
                        <div class="icContent col-md-11">
                            <div class="row box0">
                                <div class="icTitle col-md-12">
                                    TITLE
                                </div>
                            </div>
                            <div class="row box0">
                                <div class="icBody col-md-12">
                                    <hr>
                                    BODY
                                </div>
                            </div>
                            <div class="row box0">
                                <div class="icFooter col-md-12">
                                    <hr>
                                    FOOTER
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="iconCardBox h100">
                    <div class="icIconBlock">
                        <div class="icIcon glyphicon glyphicon-leaf"></div>
                    </div>
                    <div class="icContentBlock row">
                        <div class="icContent col-md-11">
                            <div class="row box0">
                                <div class="icTitle col-md-12">
                                    TITLE
                                </div>
                            </div>
                            <div class="row box0">
                                <div class="icBody col-md-12">
                                    <hr>
                                    BODY
                                </div>
                            </div>
                            <div class="row box0">
                                <div class="icFooter col-md-12">
                                    <hr>
                                    FOOTER
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row h100">
            <div class="col-md-12">

                <div class="layoutBox2 row h100">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="lb2Title">
                            TITLE
                        </div>
                        <div class="lb2BodyBlock row">
                            <div class="lb2Body col-md-12">
                                THIS IS CONTENT
                            </div>
                        </div>
                    </div>
                </div>

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
