<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/2/2
 * Time: 下午 04:44
 */
?>

@extends('semantic_lab.templates.blank_layout')

@section('title', $title)


@section('logoText')
    Semantic Lab
@endsection


@section('infoBlock')
    <div class="row">
        <div class="col-md-4 col-sm-4"><div class="glyphicon glyphicon-duplicate"> </div> Data</div>
        <div class="col-md-4 col-sm-4"><div class="glyphicon glyphicon-stats"> </div> Learning & Analysis</div>
        <div class="col-md-4 col-sm-4"><div><img id="swIcon" src="https://www.w3.org/Icons/SW/sw-cube-v.svg" style="height: 24px;"/>  Semantic</div></div>
    </div>

    <style>
        #loginBlock::before{
            content: '';
            width: 0;
            height: 50px;
            position: relative;
            display: inline-block;
        }
        #loginBlock{
            display: none;
        }
    </style>
    <script type="text/javascript">
        var status = '1';
        $('#swIcon').click(function(){
        	var text = $('#logoText').html();
        	if(status === '1'){
        		$('#loginBlock').css('display', 'block');
				status = '0';
				console.log(status);

        		$('body').keydown(function(event){
        			if(event.keyCode === 13){
        				var account = $('#account').val();
        				var pass = $('#pass').val();

        				// ajax for validate the info of input
                        // redirect if the info is correct

						// before using ajax to post data, we need to set CSRF value in post header:
						$.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							}
						});

                        $.ajax({
                        	url: $('#domainURI').val()+'login',
                            type: 'POST',
                            data: {
								account: account,
								pass: pass,
							},
                            success: function(xhrResponseText){
                        		if(xhrResponseText === 'success'){
                        		    window.location = $('#domainURI').val();
                                }
                                else {
                                    $('#xhrError').html(xhrResponseText);
								}
                            },
                            error: function(xhrError){
                            	if(xhrError.status === 422){
									$('#xhrError').html('fail: validation error. (code:sl04)');
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
    </script>
    <div id="loginBlock" class="row">
        <form class="form-inline" col-md-12 col-sm-12 col-xs-12>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="account" type="text" class="form-control" placeholder="Username">
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="pass" type="password" class="form-control" placeholder="Password">
            </div>
            <div id="xhrError"></div>
        </form>
    </div>
    <input id="domainURI" type="hidden" value="{{ $domainURI }}"/>
@endsection
