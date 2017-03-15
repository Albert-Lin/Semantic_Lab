/**
 * Created by AlbertLin on 2017/3/15.
 */

(function(){
	d3.orig_D3_arc = d3.arc;
	d3.arc = function(config){
		var result;
		if(typeof config !== 'undefined'){
			config = d3.arcValid(config);
			var arc = d3.orig_D3_arc()
				.innerRadius(config.innerRadius)
				.outerRadius(config.outerRadius)
				.startAngle(config.startAngle)
				.endAngle(config.endAngle);
			result = arc();
		}
		else{
			result = d3.orig_D3_arc();
		}
		return result;
	};
	d3.arcValid = function(config){
		if(typeof config.innerRadius === 'undefined'){
			config.innerRadius = 0;
		}
		if(typeof config.outerRadius === 'undefined'){
			config.outerRadius = 0;
		}
		if(typeof config.startAngle === 'undefined'){
			config.startAngle = 0;
		}
		if(typeof config.endAngle === 'undefined'){
			config.endAngle = 0;
		}
		return config;
	}
})();
