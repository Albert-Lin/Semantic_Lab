<template>
    <div class="blankContainer">
        <component :is="prop.block0.grid" :prop="prop.block0.prop" class="block0"></component>
    </div>
</template>


<script>

    import gridsLib from '../grids/GridsLib.js';

    export default{
    	components: gridsLib,
    	props: ['prop'],
        data(){ return{}; },
        computed: {},
        watch: {},
        methods: {},
        mounted(){}
    }
</script>


<style>
    .blankContainer{
        width: 100%;
        height: 100%;
        padding: 5px;
        border: 0;
        margin: 0;
    }
</style>