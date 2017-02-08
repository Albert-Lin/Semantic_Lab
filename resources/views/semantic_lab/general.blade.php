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
            position: absolute;
            z-index: 1;
        }
        #mail{
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            margin-bottom: -1px;
        }
        #mailAutoCompleteBlock{
            width: 391px;
            position: absolute;
            display: none;
            z-index: 10;
        }
        #mailAutoComplete{
            padding: 0;
        }
        .auto-com{
            overflow:hidden;
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
            <div id="mailAutoCompleteBlock" class="form-group">
                <div id="mailAutoComplete"  class=" col-md-12">
                </div>
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
		var messageStatus = '1';

        function loging(){
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

        $(function() {
			$('#mail').on('keyup', function(event){
				if(event.keyCode === 13 && status === '0'){
					if(messageStatus === '1') {
						loging();
						messageStatus = '0';
					}
					else{
						messageStatus = '1';
						$('#messageModalBtn').click();
                    }
				}
				else if(event.keyCode !== 13 && status === '0'){
                    var mail = $('#mail').val();
                    ajaxCSRFHeader();
                    $.ajax({
                        url: $('#domainURI').val() + 'login/autoSearch/cookie',
                        type: 'POST',
                        data: {
                            input: mail,
                            cookieName: 'mail'
                        },
                        success: function (xhrResponseText) {
                            var message = $.parseJSON(xhrResponseText);
                            if (message.length > 0) {
                                var top5 = [];
                                for (var i = 0; i < message.length; i++) {
                                    top5[i] = '<a class="list-group-item col-md-12 auto-com">' + message[i] + '</a>';
                                    if (i === 4) {
                                        break;
                                    }
                                }
                                var Blockwidth = $('#loginBlock form div').css('width');

                                var mailAutoCompleteBlock = $('#mailAutoCompleteBlock');
                                mailAutoCompleteBlock.html(top5);
                                mailAutoCompleteBlock.css('width', Blockwidth);
                                mailAutoCompleteBlock.css('display', 'block');

                                $('.auto-com').click(function () {
                                    $('#mail').val($(this).html());
                                    mailAutoCompleteBlock.html('');
                                    mailAutoCompleteBlock.css('display', 'none');
                                });
                            }
                            else {
                                var mailAutoCompleteBlock = $('#mailAutoCompleteBlock');
                                mailAutoCompleteBlock.html('');
                                mailAutoCompleteBlock.css('display', 'none');
                            }
                        },
                        error: function (xhrError) {
                            console.log(xhrError);
                        }

                    });
				}
            });

            $('#mail').on('keydown', function(event){
                if(event.keyCode === 9 && status === '0') {
                    if ($('#mailAutoCompleteBlock').css('display') === 'block') {
                        $('#mailAutoCompleteBlock').html('');
                        $('#mailAutoCompleteBlock').css('display', 'none');
                    }
                }
            });

			$('body').on('keyup', function(event){
				if (!$('#mail').is(":focus")) {
					if(event.keyCode === 13 && status === '0') {
						if (messageStatus === '1') {
							loging();
							messageStatus = '0';
						}
						else {
							messageStatus = '1';
							$('#messageModalBtn').click();
						}
					}
                }
            });

			$('body').on('click', function(){
			    if($('#mailAutoCompleteBlock').css('display') === 'block'){
                    $('#mailAutoCompleteBlock').css('display', 'none');
                }
            });


        });

        $('#swIcon').click(function(){
            if(status === '1'){
                $('#loginBlock').css('display', 'block');
                status = '0';
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
