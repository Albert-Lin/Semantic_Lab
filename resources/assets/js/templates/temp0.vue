<template>
    <div class="temp0Container">
        <div class="row">
            <div class=" col-lg-offset-0 col-lg-6 col-md-offset-0 col-md-6
                col-sm-offset-0 col-sm-12 col-xs-offset-0 col-xs-12 ">
                <component :is="prop.block0.grid" :prop="prop.block0.prop" class="block0"></component>
                <component :is="prop.block1.grid" :prop="prop.block1.prop" class="block1"></component>
            </div>
            <div class=" col-lg-offset-0 col-lg-6 col-md-offset-0 col-md-6
                col-sm-offset-0 col-sm-12 col-xs-offset-0 col-xs-12 ">
                <component :is="prop.block2.grid" :prop="prop.block2.prop" class="block2"></component>
            </div>
        </div>
    </div>
</template>


<script>

    import gridLib from '../grids/GridsLib.js';

	export default{
		components: gridLib,
		props: ['prop'],
		data(){ return{}; },
		computed: {},
		watch: {},
		methods: {},
		mounted(){}
	}
</script>


<style>
    .temp0Container,
    .temp0Container > .row{
        width: 100%;
        height: 100%;
        padding: 5px;
        border: 0;
        margin: 0;
    }

    .temp0Container > .row > div > .block0,
    .temp0Container > .row > div > .block1{
        width: 100%;
        height: 50%;
        padding: 5px;
        border: 0;
        margin: 0;
    }

    .temp0Container > .row > div > .block2{
        width: 100%;
        height: 100%;
        padding: 5px;
        border: 0;
        margin: 0;
    }

</style>