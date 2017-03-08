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
			<binding_temp_twb v-bind:input-text="element"></binding_temp_twb>
			<div> @{{ element }} </div>
		</div>
		<template id="binding_temp_twb_dom">
			<input type="text" v-model="inputText" />
		</template>
		<br><hr><br>

		COMPUTED EXAMPLE:
		<div id="computeExample">
			<div>original price: @{{ origPrice }} </div>
			<div>discount: @{{ discount }} </div>
			<div>new price: @{{ newPrice }}</div>
		</div>
		<br><hr><br>

		COMPUTED ACCESSOR AND MUTATOR:
		<div id="computedGS">
			<div> @{{ firstName }}</div>
			<div> @{{ lastName }}</div>
			<div> @{{ fullName }}</div>
		</div>
		<br><hr><br>

		METHOD EXAMPLE:
		<div id="methodExample">
			<div v-for="score in scores">score: @{{ score }}</div>
			<div>total score: @{{ totalScore() }}</div>
		</div>
		<br><hr><br>

		WATCH EXAMPLE:
		<div id="watchExample">
			<input type="text" v-model="input" />
			<div v-for="ele in output"> @{{ ele }}</div>
		</div>
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

		var computeExample = new Vue({
			el: '#computeExample',
			data: {
				// pure data:
				origPrice: 10,
				discount: 0.7
			},
			computed: {
				// the result after calculate pure data or some other data
				newPrice: function(){
					var newPrice = this.origPrice * this.discount;
					return newPrice;
				}
			}
		});

		var computedGetSet = new Vue({
			el: '#computedGS',
			data: {
				firstName: 'Albert',
				lastName: 'Lin'
			},
			computed: {
				// there is no way to change value of property in computed object directly,
				// change the value of property in data object is only way to update object property,
				// therefore, we should using mutator function of property in computed object to update property in data object
				fullName: {
					get: function(){
						return this.firstName+" "+this.lastName;
					},
					set: function(newFullName){
						var words = newFullName.split(' ');
						if(words.length === 2){
							this.firstName = words[0];
							this.lastName = words[1];
						}
						else{
							console.error("full name should be two words");
						}
					}
				}
			}
		});

		var methodExample = new Vue({
			el: '#methodExample',
			data: {
				scores: [10, 20, 30, 40, 50]
			},
			methods: {
				totalScore: function(){
					var totalScore = 0;
					for(var i = 0; i < this.scores.length; i++){
						totalScore += this.scores[i];
					}
					return totalScore;
				}
			}
		});

		var watchExample = new Vue({
			el: '#watchExample',
			data: {
				input: '',
				output: [],
				dataArray: ['dirk', 'dirk41', 'irk']
			},
			watch: {
				// all the props in watch object should match to the prop in data object,
				// the prop of watch object is a listener function for value of data object prop changed.
				input: function(regexPattern){
					this.output = [];
					this.regexSearch();
				}
			},
			methods: {
				regexSearch: function(){
					if(this.input.length > 0){
						var pattern = new RegExp(this.input);
						for(var i = 0; i < this.dataArray.length; i++){
							if( pattern.test(this.dataArray[i]) ){
								this.output.push(this.dataArray[i]);
							}
						}
					}
				}
			}
		});

</script>


