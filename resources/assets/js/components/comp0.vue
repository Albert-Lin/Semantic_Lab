<template>
    <div>
        COMP 0 :<br>
        <div> {{ prop.name }} </div>
        <div> {{ prop.champ }} </div>
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
                console.log('prop.name of COMP 0 changed');
                for(var i = 0; i < this.prop.fun.length; i++){
                    this.prop.fun[i]();
                }
            },
            'prop.champ'(newChamp){
                console.log('prop.champ of COMP 0 changed');
            }
        },
        methods: {

        },
        mounted(){
//            console.log("=============");
//            console.log(passData);
//            console.log(singleFile);
//            console.log("=============");
        }
    }

</script>

<style>

</style>