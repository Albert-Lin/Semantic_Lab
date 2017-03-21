<template>
    <div>
        COMP 2 :<br>
        <div> {{ prop.name }} </div>
        <div> {{ prop.team }} </div>
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
                console.log('prop.name of COMP 2 changed');
            },
            'prop.team'(newTeam){
                console.log('prop.team of COMP 2 changed');
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