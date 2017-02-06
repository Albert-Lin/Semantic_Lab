<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/2
 * Time: 下午 04:44
 */
?>

@extends('semantic_lab.templates.blank_layout')

@section('title', $data['title'])


@section('logoText')
    Semantic Lab
@endsection


@section('infoBlock')
    <div class="row">
        <div class="col-md-4 col-sm-4"><div class="glyphicon glyphicon-file"> </div> Data</div>
        <div class="col-md-4 col-sm-4"><div class="glyphicon glyphicon-stats"> </div> Learning & Analysis</div>
        <div class="col-md-4 col-sm-4"><div><img id="swIcon" src="https://www.w3.org/Icons/SW/sw-cube-v.svg" style="height: 24px;"/>  Semantic</div></div>
    </div>

    <style>
        #loginBlock::before{
            content: '';
            width: 0;
            height: 100px;
            position: relative;
            display: inline-block;
        }
        #loginBlock{
            display: none;
            margin-top: 50px;
        }
        #account{
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            margin-bottom: -1px;
        }
        #pass{
            border-top-right-radius: 0;
            border-top-left-radius: 0;
        }
        #registerBlock{
            padding: 10px;
        }
        #register, #fRegister{
            border-radius: 50px;
            border-color: #5bc0de;
            color: #5bc0de;
            font-size: 18px;
        }
        #register:hover, #fRegister:hover{
            background-color: #5bc0de;
            color: #ffffff;
        }

    </style>
    <div id="loginBlock" class="row">
        <form class="form col-md-offset-4 col-md-4 col-sm-12 col-xs-12">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="mail" type="text" class="form-control input-lg" placeholder="E-mail">
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="pass" type="password" class="form-control input-lg" placeholder="Password">
            </div>
            <div id="registerBlock">
                <div id="register" class="btn btn-md col-md-offset-3 col-md-6"> Register </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        var status = '1';
        $('#swIcon').click(function(){
            if(status === '1'){
                $('#loginBlock').css('display', 'block');
                status = '0';

                $('body').keydown(function(event){
                    if(event.keyCode === 13 && status === '0'){
                        var mail = $('#mail').val();
                        var pass = $('#pass').val();

                        // ajax for validate the info of input
                        // redirect if the info is correct

                        // before using ajax to post data, we need to set CSRF value in post header:
                        ajaxCSRFHeader();

                        $.ajax({
                            url: $('#domainURI').val()+'login',
                            type: 'POST',
                            data: {
                                mail: mail,
                                pass: pass,
                            },
                            success: function(xhrResponseText){
                                var message = $.parseJSON(xhrResponseText);
                                if(message.title === 'Error'){
                                    messageBlock(message.title, message.content, '');
                                    $('#messageModalBtn').click();

                                }
                                else if(message.title === 'Redirect'){
                                    window.location = message.content;
                                }
                            },
                            error: function(xhrError){
                                if(xhrError.status === 422){
                                    messageBlock('Error', 'Validation error (code:sl04).', '');
                                    $('#messageModalBtn').click();
                                }
                            }
                        });
                    }
                });

            }
            else{
                $('#loginBlock').css('display', 'none');
                status = '1';
            }
        });

        $('#register').click(function(){
            $('#loginBlock').css('display', 'none');
            status = '1';

            $('#messageDialog').removeClass('modal-sm');
            $('#messageDialog').addClass('modal-md');
            var body = '' +
                '<form class="form-horizontal">' +
                    '<div class="form-group">' +
                        '<label class="col-md-3 control-label">e-mail:</label>' +
                        '<div class="col-md-9"><input id="fMail" type="text" class="form-control input-lg" placeholder="Username"></div>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label class="col-md-3 control-label">user name:</label>' +
                        '<div class="col-md-9"><input id="fUserName" type="text" class="form-control input-lg" placeholder="Username"></div>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label class="col-md-3 control-label">password:</label>' +
                        '<div class="col-md-9"><input id="fPass" type="password" class="form-control input-lg" placeholder="Username"></div>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<label class="col-md-3 control-label">re-password:</label>' +
                        '<div class="col-md-9"><input id="fRPass" type="password" class="form-control input-lg" placeholder="Username"></div>' +
                    '</div>' +
                    '<div class="form-group">' +
                        '<div id="fMessage" class="col-md-offset-3 col-md-9"></div>' +
                    '</div>' +
                '</form>';
            var footer = '<div id="fRegister" class="btn btn-md"> Register</div>';
            messageBlock('Register', body, footer);
            $('#messageModalBtn').click();

            $('input').click(function(){
                $('#fMessage').html('');
            });

            $('#fRegister').click(function(){
                var fPass = $('#fPass').val();
                var fRPass = $('#fRPass').val();
                if(fPass === fRPass){
                    ajaxCSRFHeader();
                    $.ajax({
                        url: $('#domainURI').val()+'register',
                        type: 'POST',
                        data: {
                            username: $('#fUserName').val(),
                            pass: fPass,
                            mail: $('#fMail').val()
                        },
                        success: function(xhrResponseText){
                            var message = $.parseJSON(xhrResponseText);
                            if(message.title === 'Error'){
                                $('#fMessage').html(message.title+': '+message.content+'.');
                            }
                            else if(message.title === 'Redirect'){
                                window.location = message.content;
                            }
                        },
                        error: function(xhrError){
                            if(xhrError.status === 422){
                                $('#fMessage').html('Validation error: missing data for register (code:sr04).');
                            }
                        }
                    });
                }
                else{
                    $('#fMessage').html('password & re-password are different, please retype again.');
                }
            });

        });

    </script>
@endsection
