<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<!doctype html>
<html>
	<head>
		<title>{{ $title }}</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$("#type0").click(function(){
					ajaxFun( '/test/get-request/0' );
				});

				$("#type1").click(function(){
					ajaxFun( '/test/get-request/1' );
				});

				$("#type2").click(function(){
					ajaxFun( '/test/get-request/2' );
				});
			});

			function ajaxFun(url){
				$.ajax({
					type: 'GET',
					url: url,
					data: {
						'email' : 'familywithloveg@gmail.com',
						'password' : 'love4451',
						'message' : 'Well done!'
					},
					success: function(XHR_response_text){
						$("#messageDiv").html(XHR_response_text);
					},
					error: function(XMLHttpRequest, textStatus, errorThrown){
						alert("Status: " + textStatus+"\r\nError: " + errorThrown);
					}
				});
			}

		</script>
	</head>
	<body>
		$request->all() : <input type="button" id="type0" value="Get Request"> <br>
		foreach $request : <input type="button" id="type1" value="Get Request"> <br>
		$requests['key'] : <input type="button" id="type2" value="Get Request"> <br>

		<div id="messageDiv"></div>
	</body>
</html>
