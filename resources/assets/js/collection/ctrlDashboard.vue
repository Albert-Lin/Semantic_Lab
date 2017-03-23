<template>
    <div class="ctrlDashBoardContainer">
        <div class="row">
            <div class="col-lg-offset-0 col-lg-3 col-md-offset-0 col-md-3
                    col-sm-offset-0 col-sm-12 col-xs-offset-0 col-xs-12">
                <pie v-for="ele in prop.components" :prop="ele.prop"></pie>
                <pie v-for="ele in prop.components" :prop="ele.prop"></pie>
            </div>
        </div>
        <div>
            <div v-for="(data, index) in theData"><input type="text" :id="'ctrlDB_input_'+index" v-on:keyup="updateData(index)" :value="data" /></div>
        </div>
    </div>
</template>



<script>
    import pie from '../components/pie.vue';
    export default{
    	props: ['prop'],
    	components: {
    		pie: pie,
        },
        data(){ return {}; },
        computed: {
        	theData(){
        		let result = this.prop.components[0].prop.data;
        		return result;
            }
        },
        watch: {},
        methods: {
        	updateData(index){
        		let inputDom = document.getElementById('ctrlDB_input_'+index);
				let newValue = undefined;
				inputDom.value = inputDom.value.replace(/[^=0-9]*/gi,"");
                if(inputDom.value !== ''){
					newValue = parseInt(inputDom.value);
					this.prop.components[0].prop.data[index] = newValue;
					this.prop.components[0].prop = JSON.parse(JSON.stringify(this.prop.components[0].prop));
					inputDom.value = newValue;
                }
            }
        },
        mounted(){}
    }
</script>


<style>

</style>