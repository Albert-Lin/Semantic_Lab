<template>
	<div v-for="row in rowArray" class="row">
		<div v-for="col in row.cols" :class="classArray"> <component :is="col.component" :prop="col.prop"></component> </div>
	</div>
</template>



<script>

	/*
		prop: {
			componentData: [
				{
					component: '',
					prop: {},
				},
				{},
				{},
				...
			],
			classArray: {
				lg: [offset, current],
				md: [offset, current], // required
				sm: [offset, current],
				xs: [offset, current]
			}
		},
		rowArray: [
			{
				cols: [ {}, {}, {}, ...]
			},
			{},
			...
		],
	    classArray: [ 'col-lg-offset-x', 'col-lg-x', ... ]
	 */
	export default{

		props: ['prop'],
		data(){
			return {};
		},
		computed:{
			rowArray(){
				var result = [];
				var numRow;
				var numComponent;
				var index = 0;
				if( this.prop.classArray.md.length === 1 ){
					numComponent = Math.floor(12/this.prop.classArray.md[0]);
				}
				else{
					numComponent = Math.floor(12/this.prop.classArray.md[1]);
				}
				numRow = Math.floor(this.prop.componentData.length/numComponent);

				for(var i = 0; i < numRow; i++){
					var cols = [];
					for(var j = 0; j < numComponent; j++){
						if(this.prop.componentData[index] !== undefined){
							cols.push(this.prop.componentData[index]);
							index++;
						}
						else{
							break;
						}
					}

					result.push({ cols: cols });
				}

				return result;
			},
			classArray(){
				var result = [];
				var classObject = this.prop.classArray;

				for(var key in classObject){
					if(classObject[key].length === 1){
						result.push('col-'+key+'-'+classObject[key][0]);
					}
					else{
						result.push('col-'+key+'-offset-'+classObject[key][0]);
						result.push('col-'+key+'-'+classObject[key][1]);
					}
				}

				return result;
			}
		},
		watch: {

		},
		methods: {

		},
		mounted(){

		}

	}

</script>



<style>

</style>