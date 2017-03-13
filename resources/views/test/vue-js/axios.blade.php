<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/3/14
 * Time: 上午 12:42
 */
?>

<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ $title }}</title>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>

	<div>
		<input type="button" value="AXIOS POST" onclick="postAxios()" />
	</div>

</body>
</html>
<script>

	function postAxios(){

		axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
		axios({
			url: 'http://semanticlab.com/test/vue/axios/post',
			method: 'post',
			data: {
				param0: 'value0',
				param1: 'value1'
			}
		})
			.then(function(response){
				console.log('Response: ');
				console.log(response.data);
			})
			.catch(function(error){
				console.log('Error: ');
				console.log(error.response.status);
			});
	}

</script>
