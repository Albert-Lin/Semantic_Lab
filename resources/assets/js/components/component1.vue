<template>
	<div>
		<div class="elements" v-for="ele in prop.prop1">{{ ele }}</div>
		<div class="endLine"> +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+- </div>
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


<style scoped>

	.elements{
		color: #f0ad4e;
	}
	.endLine{
		color: #666666;
	}

</style>