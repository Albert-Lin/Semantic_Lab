<?php
/**
 * Created by PhpStorm.
 * User: AlbertLin
 * Date: 2017/3/10
 * Time: 上午 09:20
 */
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <script src=" https://unpkg.com/vue"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <style>
        svg{
            padding: 20px;
        }
    </style>

</head>
<body>

    <div id="chartContainer"></div>

    <template id="pie">
        <div>
            <svg :width="svgSize" :height="svgSize">
                <path v-for="ele in elements" :d="ele.d" :fill="ele.color" />
            </svg>
        </div>
    </template>


</body>
</html>

<script>
    var chartData;
    var chartContainer;
    var chartCompData = [];
    var charts = [];

    function Chart(index, params){
		this.vueOptional = {};

    	this.Chart = function(){
			this.setOptional();
        };

    	this.setOptional = function(){
    		if(params.name === 'pie'){
				this.vueOptional = new Pie(params).getOptional();
            }
        };

    	this.getVueComponent = function(){
    	    return Vue.component(params.name+'_'+index, this.vueOptional);
        };

    	this.Chart();
    }


    function Pie(params){
        this.total = 0;
        this.center = 0;
        this.currentDegree = 0;
        this.percent = 0;

		this.Pie = function(){
			this.center = params.r;
			for(var i = 0; i < params.elements.length; i++){
				this.total += params.elements[i];
            }
        };

		this.path = function(index, number){
			var percent = number/this.total;
			var degree = 360 * percent;
			var sx = this.center+params.r*Math.cos(this.currentDegree*Math.PI/180);
			var sy = this.center-params.r*Math.sin(this.currentDegree*Math.PI/180);
			var ex = this.center+params.r*Math.cos((this.currentDegree + degree)*Math.PI/180);
			var ey = this.center-params.r*Math.sin((this.currentDegree + degree)*Math.PI/180);
			var large = 0;
			if(degree > 180){
				large = 1;
            }
			this.currentDegree += degree;
			this.percent += percent;

            return {
				origNum: number,
                percent: percent,
                color: 'hsl('+(index*345/params.elements.length)+', 90%, 65%)',
                d: 'M'+this.center+' '+this.center+',L'+sx+' '+sy+',A'+params.r+' '+params.r+' 0 '+large+' 0 '+ex+' '+ey+',Z'
            };
        };

		this.data = function(){
            var elements = [];
            for(var i = 0; i < params.elements.length; i++){
            	elements.push(this.path(i, params.elements[i]));
            }
			return {
            	svgSize: params.r*2,
				elements: elements
            };
        };

		this.getOptional = function(){
			var data = this.data();
			return {
				template: '#pie',
				data: function(){
					return data;
                }
			};
        };

		this.Pie();
    }


	function Pie2(params){
		this.total = 0;
		this.center = 0;
		this.currentDegree = 0;
		this.percent = 0;

		this.Pie = function(){
			this.center = params.r;
			for(var i = 0; i < params.elements.length; i++){
				this.total += params.elements[i];
			}
		};

		this.path = function(index, number){
			var percent = number/this.total;
			var degree = 360 * percent;
			var sx = this.center+params.r*Math.cos(this.currentDegree*Math.PI/180);
			var sy = this.center-params.r*Math.sin(this.currentDegree*Math.PI/180);
			var ex = this.center+params.r*Math.cos((this.currentDegree + degree)*Math.PI/180);
			var ey = this.center-params.r*Math.sin((this.currentDegree + degree)*Math.PI/180);
			var large = 0;
			if(degree > 180){
				large = 1;
			}
			this.currentDegree += degree;
			this.percent += percent;

			return {
				origNum: number,
				percent: percent,
				color: 'hsl('+(index*345/params.elements.length)+', 90%, 65%)',
				d: 'M'+this.center+' '+this.center+',L'+sx+' '+sy+',A'+params.r+' '+params.r+' 0 '+large+' 0 '+ex+' '+ey+',Z'
			};
		};

		this.data = function(){
			var elements = [];
			for(var i = 0; i < params.elements.length; i++){
				elements.push(this.path(i, params.elements[i]));
			}
			return {
				svgSize: params.r*2,
				elements: elements
			};
		};

		this.getOptional = function(){
			var data = this.data();
			return {
				template: '#pie',
                props: ['paths'],
                data: function(){
					return {
						name: params.name,
                        r: params.r,
						elements: params.elements
                    };
                },
                watch:{
                	r : function(newR){

                    },
                    element: function(newElements){

                    }
                },
                methods:{
                	createChart: function(){

                    }
                }
			};
		};

		this.Pie();
	}


    $(function(){
    	chartData = {!! $chartData !!};
		chartCompData = chartData.components;
        for(var i = 0; i < chartCompData.length; i++){
        	charts.push(new Chart(i, chartCompData[i]).getVueComponent());
        	$('#chartContainer').append('<'+chartCompData[i].name+'_'+i+'></'+chartCompData[i].name+'>');
        }
		chartContainer = new Vue({
			el: '#chartContainer'
		});
    });

</script>


