<template>
	<div>
		<svg :style="{height: svgHeight+'px'}">
			<g :style="{transform: 'translate('+outR+'px, '+outR+'px)'}">
				<path v-for="(d, index) in dArray" :d="d" :style="{fill: hslArray[index]}"></path>
			</g>
		</svg>
	</div>
</template>

<script>
	require('../plugIn/d3_plugin.js');
    export default{
        props:['id', 'prop'],
        data(){
            return {
            	outR: 100,
            	inR: 50
            };
        },
        computed: {
        	svgHeight(){
        		return 2*this.outR;
        	},
            Σ(){
            	var result = 0;
            	for(var i = 0; i < this.prop.data.length; i++){
            		result += this.prop.data[i];
            	}
            	return result;
            },
            dArray(){
            	return this.getDArray();
            },
            hslArray(){
                return this.getHslArray();
            }
        },
        watch: {},
        methods:{
            propValid(){
            	if(this.prop.outR !== undefined){
            		this.outR = this.prop.outR;
            	}

            	if(this.prop.inR !== undefined){
            		this.inR = this.prop.inR;
            	}
            },
            getDArray(){
                var result = [];
                var startAngle = 0;
                for(var i = 0; i < this.prop.data.length; i++){
                    var endAngle = startAngle + this.prop.data[i];
                    result.push(d3.arc({
                    	innerRadius: this.inR,
                    	outerRadius: this.outR,
                    	startAngle: (startAngle/this.Σ)*2*Math.PI,
                    	endAngle: (endAngle/this.Σ)*2*Math.PI
                    }));
                    startAngle = endAngle;
                }
                return result;
            },
            getHslArray(){
            	var result = [];
				var unit = 360/this.Σ;
				var startUnit = 0;
                if(this.prop.color === undefined){
                    for(var i = 0; i < this.prop.data.length; i++){
                        var h = startUnit * unit;
                        result.push('hsl('+h+', 100%, 65%)');
                        startUnit += this.prop.data[i];
                    }
                }
                else{
                    result = this.prop.color;
                }
            	return result;
            },
        },
        mounted(){
        	this.propValid();
        }


    }


</script>

<style>
</style>