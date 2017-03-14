<template>
    <svg  style="width: 400px; height: 400px;">
        <g class="pie" style="transform: translate(100px, 100px)">
            <path v-for="path in paths" :d="path"></path>
        </g>
    </svg>
</template>

<script>
    export default{
        props:['prop'],
        data(){
            return {};
        },
        computed: {
            paths(){
                var result = [];
                var total = 0;
                var last = 0;
                for(var i = 0; i < this.prop.length; i++){
                    total += this.prop[i];
                }
                for(var i = 0; i < this.prop.length; i++){
                    var svgInfo = getSVGPath(last/total, (last+this.prop[i])/total);
                    result.push(svgInfo);
                    last += this.prop[i];
                }
                return result;
            }
        },
        watch: {

        },
        methods:{

        },
        mounted(){

        }


    }


</script>

<style>
</style>