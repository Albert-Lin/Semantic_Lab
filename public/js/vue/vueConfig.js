/**
 * Created by AlbertLin on 2017/3/21.
 */

var config;
var vueConfig = {
	templates: [],
	grids: [],
	components: [],
};
var templates = [];

(function(){
	config = new function(){
		let vueConfig = window.vueConfig;
		let templates = window.templates;
		this.setTemplate = function(tempConfig){
			let template = new Template(tempConfig).config;
			templates.push(template);

			return this;
		};
		this.setVueConfig = function(tempsArray, gridsArray, compsArray){
			vueConfig.templates = tempsArray;
			vueConfig.grids = gridsArray;
			if(typeof compsArray !== 'undefined'){
				vueConfig.components = compsArray;
			}

			return this;
		};
		this.setComponents = function(components){
			for(let i = 0; i < components.length; i++){
				if(vueConfig.components.indexOf(components[i].component) === -1){
					vueConfig.components.push(components[i].component);
				}
			}

			return this;
		}
	};
})();