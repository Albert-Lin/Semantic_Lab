<template>
	<div class="gridContainer">
		<div v-for="row in rowArray" class="row">
			<div v-for="col in row.cols" class="col" :class="classArray"> <component :is="col.collection" :prop="col.prop"></component> </div>
		</div>
	</div>
</template>



<script>
	import collectionsLib from '../collection/collectionsLib.js';

	require('../plugIn/Dom.js');

	export default{
		components: collectionsLib,
		props: ['prop'],
		data(){ return {}; },
		computed:{
			rowArray(){
				let result = [];
				let numRow;
				let numComponent;
				let index = 0;
				if( this.prop.lg.length === 1 ){
					numComponent = Math.ceil(12/this.prop.lg[0]);
				}
				else if( this.prop.lg.length === 2 ){
					numComponent = Math.ceil(12/this.prop.lg[1]);
				}
				else{
					numComponent = Math.ceil(12/12);
				}
				numRow = Math.ceil(this.prop.collections.length/numComponent);
				for(let i = 0; i < numRow; i++){
					let cols = [];
					for(let j = 0; j < numComponent; j++){
						if(index < this.prop.collections.length){
							cols.push(this.prop.collections[index]);
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

				for(let key in this.prop){
					if(key !== 'block' && key !== 'collections'){
						result.push('col-'+key+'-offset-'+this.prop[key][0]);
						result.push('col-'+key+'-'+this.prop[key][1]);
					}
				}

				return result;
			}
		},
		watch: {},
		methods: {},
		mounted(){
			let rows = Ψ('.'+this.prop.block+' > .row');
			for(let i = 0; i < this.rowArray.length; i++){
				let maxHeight = 0;
				for(let j = 0; j < this.rowArray[i].cols.length; j++){
//					if(Array.isArray(Ψ('.col', rows[i])) === true && Ψ('.col', rows[i]).length > 0){
						let height = Ψ('.col', rows[i])[j].offsetHeight;
						if(height > maxHeight){
							maxHeight = height;
						}
//					}
				}
				for(let j = 0; j < this.rowArray[i].cols.length; j++){
//					if(Array.isArray(Ψ('.col', rows[i])) === true && Ψ('.col', rows[i]).length > 0){
						if(Ψ('.col', rows[i])[j].style !== undefined){
							Ψ('.col', rows[i])[j].style.height = maxHeight;
						}
//					}
				}
			}
		}
	}

</script>



<style>
	.gridContainer > .row{
		width: 100%;
		/*height: 100%; !* Think about it *!*/
		padding: 0;
		border: 0;
		margin: 0;
	}
	.gridContainer > .row > .col{
		padding: 5px;
		border: 1px;
		border-style: solid;
		/*margin: 0;*/
		background-color: #ff4444;
	}

</style>