<template>
    <div>
        COMP 1 :<br>
        <div> {{ prop.name }} </div>
        <div> {{ prop.age }} </div>
        <div v-for="(year, index) in prop.mvp" :class="'comp1_'+index"> {{ year }} </div>
        <br><hr><br>
    </div>
</template>

<script>

    export default{
        props: ['prop'],
        data(){
            return {};
        },
        computed: {

        },
        watch: {
            'prop.name'(newName){
                console.log('prop.name of COMP 1 changed');
            },
            'prop.age'(newTeam){
                console.log('prop.age of COMP 1 changed');
            },
            'prop.mvp'(newMvp){
                for(var i = 0; i < newMvp.length; i++){
                    console.log(i+' '+newMvp[i]);
                }
            }
        },
        methods: {

        },
        mounted(){

        }
    }

</script>

<style>

</style>