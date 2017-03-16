<template>
	<div>
		<div v-for="row in rowArray" class="row">
			<div v-for="col in row.cols" class="col" :class="classArray"> <component :is="col.component" :prop="col.prop"></component> </div>
		</div>
	</div>
</template>



<script>
	import pie from '../components/vue/pie.vue';
	import includeC0 from '../components/vue/component0.vue';
	import includeC1 from '../components/vue/component1.vue';
	import includeC2 from '../components/vue/component2.vue';
	import comp0 from '../components/vue/comp0.vue';
	import comp1 from '../components/vue/comp1.vue';
	import comp2 from '../components/vue/comp2.vue';

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
		components:{
			'pie': pie,
			'includeC0': includeC0,
			'includeC1': includeC1,
			'includeC2': includeC2,
			'comp0': comp0,
			'comp1': comp1,
			'comp2': comp2
		},
		props: ['prop'],
		data(){
			return {};
		},
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
		watch: {

		},
		methods: {

		},
		mounted(){

		}

	}

</script>



<style>
	.col{
		padding: 10px;
		border: 0;
		margin: 0;
	}

</style>