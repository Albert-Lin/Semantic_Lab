<template>
    <div class="blankCollectionContainer">
        <component v-if="prop !== undefined" v-for="ele in prop.components" :is="ele.component" :prop="ele.prop"></component>
    </div>
</template>



<script>
	import componentsLib from '../components/ComponentsLib.js';

    export default{
    	components: componentsLib,
        props: ['prop'],
        data(){ return {}; },
        computed: {},
        watch: {},
        methods: {},
        mounted(){}
    }
</script>



<style>

</style>