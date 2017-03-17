<template>
	<div class="gridContainer">
		<div v-for="row in rowArray" class="row">
			<div v-for="col in row.cols" class="col" :class="classArray"> <component :is="col.component" :prop="col.prop"></component> </div>
		</div>
	</div>
</template>



<script>
	import componentsLib from '../components/ComponentsLib.js';

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
				lg: [offset, current], // required
				md: [offset, current],
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
		components: componentsLib,
		props: ['prop'],
		data(){ return {}; },
		computed:{
			rowArray(){
				let result = [];
				let numRow;
				let numComponent;
				let index = 0;
				if( this.prop.classArray.lg.length === 1 ){
					numComponent = Math.ceil(12/this.prop.classArray.lg[0]);
				}
				else if( this.prop.classArray.lg.length === 2 ){
					numComponent = Math.ceil(12/this.prop.classArray.lg[1]);
				}
				else{
					numComponent = Math.ceil(12/12);
				}
				numRow = Math.ceil(this.prop.componentData.length/numComponent);

				for(let i = 0; i < numRow; i++){
					let cols = [];
					for(let j = 0; j < numComponent; j++){
						if(index < this.prop.componentData.length){
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
				let result = [];
				let classObject = this.prop.classArray;

				for(let key in classObject){
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
		watch: {},
		methods: {},
		mounted(){}
	}

</script>



<style>
	.gridContainer > .row{
		width: 100%;
		height: 100%; /* Think about it */
		padding: 0;
		border: 0;
	}
	.gridContainer > .row > .col{
		padding: 5px;
		border: 0;
		margin: 0;
	}

</style>