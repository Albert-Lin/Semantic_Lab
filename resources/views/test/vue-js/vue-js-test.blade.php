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
		<script src=" https://unpkg.com/vue"></script>
	</head>
	<body>

		SIMPLE EXAPMLE:
		<div id="simple">
			@{{ message }}
		</div>
		<br>
		<br>

		TWO-WAY BINDING:
		<div id="twb" >
			<div>@{{ twb_value }}</div>
			<input type="text" v-model="twb_value" />
			<input type="hidden" v-model="twb_value" />
		</div>
		<br>
		<br>

		SIMPLE TEMPLATE:
		<div id="simpleTempCont">
			<simpleTemp></simpleTemp>
		</div>

		<template id="simple_temp">
			<div> THIS IS CONTENT OF SIMPLE TEMPLATE </div>
		</template>

		
		
	</body>
</html>

<script type="text/javascript">
		var simple = new Vue({
			el: '#simple',
			data: {
				message: "MESSAGE"
			}
		});

		var TW_binding = new Vue({
			el: '#twb',
			data: {
				twb_value: 'default value'
			}
		});
//
//		var simpleTempComp = Vue.component('simpleTemp', {
//			template: '#simple_temp'
//		});
//		var simpleTempCont = new Vue({
//			el: '#simpleTempCont'
//		});
//
//		var vue1 = new Vue({
//			el: '#id1',
//			data: {
//				message: "VUE 1:"
//			}
//		});
//
//		var vue2 = new Vue({
//			el: '#id2',
//			data: {
//				two_way_binding: ''
//			}
//		});

</script>


