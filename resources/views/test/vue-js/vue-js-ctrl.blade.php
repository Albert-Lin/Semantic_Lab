<?php
/**
 * Created by PhpStorm.
 * User: Albert Lin
 * Date: 2017/3/9
 * Time: 上午 12:30
 */
?>

<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<script src=" https://unpkg.com/vue"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<style>
		img{
			max-width: 300px;
			max-height: 300px;
		}
	</style>
</head>
<body>

	<{{ $tag }}></{{ $tag }}>

	<div id="container">
		<temp></temp>
	</div>

	{{--COMPONENT:--}}
	<template id="temp">
		<div>
			<div>@{{ name }}</div>
			<action></action>
		</div>
	</template>

	<template id="one_legged_fadeaway">
		<div>
			@{{ actionName }}<br>
			<img v-for="img in actionProps.imgs" :src="img" />
		</div>
	</template>

	<template id="three_point_shooter">
		<div>
			<input type="text" v-model="input" />
			<div v-for="ele in output"> @{{ ele }}</div>
		</div>
	</template>

</body>
</html>
<script>

	var ctrlData;
	var container;
	var temp;
	var action;


	function newTemp(params){
		return Vue.component('temp', {
			template: '#temp',
			data: function(){
				return params;
			}
		});
	}

	function Action(params){

		this.vueOptional = {};
		this.params = params;

		/**
		 * Constructor
		 * @constructor
		*/
		this.Action = function(){
			this.optInit();
			this.setOptional();
		};

		/**
		 * Vue.component optional initialize:
		 * 	bind the template
		 */
		this.optInit = function(){
			this.vueOptional.template = '#'+this.params.actionName;
		};

		/**
		 * set Vue.component optional:
		 * 	set "data", "watch" and "methods" three properties
		 */
		this.setOptional = function(){
			if(params.actionName === "one_legged_fadeaway"){
				new OLF().setOptional(this.vueOptional, this.params);
			}
			else if(params.actionName === "three_point_shooter"){
				new ThreePTS().setOptional(this.vueOptional, this.params);
			}
		};

		/**
		 * get Vue.component
		 */
		this.getComponent = function(){
			return Vue.component('action', this.vueOptional);
		};

		/**
		 * execute constructor function
		 */
		this.Action();

	}

	function OLF(){
		this.setOptional = function(vueOpt, params){
			vueOpt.data = function(){
				return params;
			};
		};
	}

	function ThreePTS(){
		this.setOptional = function(vueOpt, params){
			params.input = '';
			params.output = [];
			vueOpt.data = function(){
				return params;
			};

			vueOpt.watch = {
				input: function(regexPattern){
					this.output = [];
					this.regexSearch();
				}
			};
			vueOpt.methods = {
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
			};
		};
	}


	$(function(){
		ctrlData = {!! $data !!};

		action = new Action(ctrlData.action).getComponent();
		temp = newTemp({ name: ctrlData.name });
		container = new Vue({
			el: '#container'
		});
	});

</script>

