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

		SIMPLE EXAMPLE
		{{-- In Laravel, using data from Vue object,
			not only "{{  }}" also need "@" infront of "{{  }}" --}}
		<div id="simple"> @{{ message }} </div>
		<br><hr><br>

		SIMPLE "FOR" EXAMPLE
		<div id="forExample">
			<div v-for="ele in array"> @{{ ele }} </div>
		</div>
		<br><hr><br>

		TWO-WAY BINDING:
		<div id="twb" >
			<div>@{{ twb_value }}</div>
			<input type="text" v-model="twb_value" />
			<input type="hidden" v-model="twb_value" />
		</div>
		<br><hr><br>

		SIMPLE TEMPLATE:
		<div id="simpleTempCont">
			<simple_temp></simple_temp>
		</div>
		<template id="simple_temp_dom">
			<div> THIS IS CONTENT OF SIMPLE TEMPLATE </div>
		</template>
		<br><hr><br>

		DATA-BINDING TEMPLATE
		<div id="bindingTempCont">
			{{-- For passing data into template:
			 01. add conponent props name as tag's (compoent) property
			 	if data is dynamic, add "v-bind:" before props name
			 	else, just using props name for static value.

			 02. the name of tag's property, should all using lowercase,
			 	if the prop of component with uppercase, please change into lowercase
			 	and add "-" front of letter, e.g., props: ['propName'] match to
			 	<component_name prop-name="value/variable"></component_name>
			--}}
			<binding_temp v-bind:single-data="mesg" prop-name2="mesg"></binding_temp>
		</div>
		<template id="binding_temp_dom">
			<div>
				<div> @{{ singleData }}</div>
				<div> @{{ propName2 }} </div>
			</div>
		</template>
		<br><hr><br>

		DATA-BINDING TEMPLATE (FOR)
		<div id="bindingTempForCont">
			<binding_temp_for v-for="element in array" v-bind:data="element"></binding_temp_for>
		</div>
		<template id="binding_temp_for_temp">
			<div>@{{ data.name }}</div>
		</template>
		<br><hr><br>

		DATA-BINDING TEMPLATE (TWB)
		<div id="bindingTempTWBCont">
			<binding_temp_twb v-model="element"></binding_temp_twb>
			<div> @{{ element }} </div>
		</div>
		<template id="binding_temp_twb_dom">
			<input type="text" v-model="inputText" />
		</template>
		<br><hr><br>

	</body>
</html>

<script type="text/javascript">
		var simple = new Vue({
			el: '#simple',
			data: {
				message: "MESSAGE"
			}
		});

		var forExample = new Vue({
			el: '#forExample',
			data: {
				array: ['ele 0', 'ele 1', 'ele 2']
			}
		});

		var TW_binding = new Vue({
			el: '#twb',
			data: {
				twb_value: 'default value'
			}
		});

//		All the tag name compile into HTML script will be translated to lowercase,
//			as result, the name of component should be lowercase
		var simpleTemp = Vue.component('simple_temp', {
			template: '#simple_temp_dom'
		});
		var simpleTempCont = new Vue({
			el: '#simpleTempCont'
		});

		var dataBindingTemp = Vue.component('binding_temp', {
			template: '#binding_temp_dom',
			props: ['singleData', 'propName2']
		});
		var dataBindingTempCont = new Vue({
			el: '#bindingTempCont',
			data: {
				mesg: 'the data not from template'
			}
		});

		var databindingTempFor = Vue.component('binding_temp_for', {
			template: '#binding_temp_for_temp',
			props: ['data']
		});
		var dataBindingTempForCont = new Vue({
			el: '#bindingTempForCont',
			data: {
				array: [
					{name: "name0"},
					{name: "name1"},
					{name: "name2"}
				]
			}
		});

		var dataBindingTempTWB = Vue.component('binding_temp_twb', {
			template: '#binding_temp_twb_dom',
			props: ['inputText']
		});
		var dataBindingTempTWBCont = new Vue({
			el: '#bindingTempTWBCont',
			data: {
				element: 'input default'
			}
		});


</script>


