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
					location = "/test/get-session/0";
				});

				$("#type1").click(function(){
					location = "/test/get-session/1";
				});

				$("#type2").click(function(){
					location = "/test/get-session/2";
				});

				$("#type3").click(function(){
					location = "/test/get-session/3";
				});
			});
		</script>
	</head>
	<body>
		Request : <br>
		<input type="button" id="type0" value="Get Request"> <br><br>

		$request->session()->all() : <br>
		<input type="button" id="type1" value="Get Session"> <br><br>

		$sessions = $request->session()->all();<br>
		$sessions[ 'key' ] : <br>
		<input type="button" id="type2" value="Get Session"> <br><br>

		$request->session()->get( 'key' ) : <br>
		<input type="button" id="type3" value="Get Session"> <br><br>
	</body>
</html>

