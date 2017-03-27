<!--<template>-->
	<div>
		This message is from extends.vue
	</div>
<!--</template>-->


<script>
	import based from './based.vue';

	export default based.extend({
		props: [],
		data(){ return { data0: '123', data3: '789'}; },
		components: {},
		computed: {},
		watch: {},
		methods: {
			method0: function(){
				console.log('123');
			},
			method3: function(){
				console.log('789');
			},
		},
		mounted(){
			console.log('mesg from extends.');
			console.log(this);
			this.method3();
		}
	});

</script>