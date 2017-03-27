<template>
	<div>
		This message is from based.vue
	</div>
</template>


<script>

	require('../require.js');

	export default Vue.extend({
		props: [],
		data(){ return { data1: 'xyz', data3: 'abc'}; },
		components: {},
		computed: {},
		watch: {},
		methods: {
			method1: function(){
				console.log('xyz');
			},
			method3: function(){
				console.log('abc');
			},
		},
		mounted(){
			console.log('mesg from based.');
		}
	})

</script>