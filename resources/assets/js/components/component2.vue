<template>
	<div class="component">
		{{ prop.prop2 }} _ {{ prop.prop3 }}
	</div>
</template>


<script>
	export default{
		props: ['prop'],
		data: function(){
			return {};
		},
		computed: {

		},
		watch: {

		},
		methods: {

		},
		mounted: function(){

		}
	}
</script>


<style>
	.component{
		background-color: #aaaaaa;
	}
</style>