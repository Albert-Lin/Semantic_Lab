/**
 * Created by AlbertLin on 2017/3/21.
 */


var vueConfigs = {};
var templates = {};
var currentVueConfig;
var rootVue = function(rootName){
	if(typeof rootName !== 'undefined'){
		return new RootVue(rootName);
	}
	else{
		console.error('window.rootVue missing parameter "rootName".');
	}
};

function RootVue(rootName) {
	this.vueConfig = {};
	this.templates = [];
	this.RootVue = function (rootName) {
		 window.vueConfigs[rootName] = {
		 	templates: [],
		 	grids: ['gridSystem'],
		 	collections: [],
		 	components: [],
		 };
		 this.vueConfig = window.vueConfigs[rootName];
		window.templates[rootName] = [];
		this.templates = window.templates[rootName];
		window.current = rootName;

		return this;
	};

	this.setTemplate = function (config) {
		let result = {
			template: undefined,
			prop: {}
		};

		if(config.template !== undefined){
			result.template = config.template;
			if(this.vueConfig.templates.indexOf(config.template) === -1){
				this.vueConfig.templates.push(config.template);
			}
		}
		else{
			console.error('setTemplate: missing property "template" in config');
		}

		for (let key in config) {
			if (key !== 'template') {
				result.prop[key] = {
					grid: 'gridSystem',
					prop: {
						collections: [],
						lg: [0, 12],
						md: [0, 12],
						sm: [0, 12],
						xs: [0, 12],
					}
				};

				if (config[key].grid !== undefined) {
					result.prop[key].grid = config[key].grid;
					if(this.vueConfig.grids.indexOf(config[key].grid) === -1){
						this.vueConfig.grids.push(config[key].grid);
					}
				}

				if (config[key].lg !== undefined) {
					result.prop[key].prop.lg = colCheck(config[key].lg);
				}
				if (config[key].md !== undefined) {
					result.prop[key].prop.md = colCheck(config[key].md);
				}
				if (config[key].sm !== undefined) {
					result.prop[key].prop.sm = colCheck(config[key].sm);
				}
				if (config[key].xs !== undefined) {
					result.prop[key].prop.xs = colCheck(config[key].xs);
				}

				result.prop[key].prop.collections = config[key].collections;
				result.prop[key].prop.block = key;
				this.setConfig(config[key].collections);
			}
		}

		this.templates.push(result);

		return this;
	};

	let colCheck = function (data) {
		if (Array.isArray(data) !== true) {
			return [0, data];
		}
		else{
			return data;
		}
	};

	this.setConfig = function(collections){
		for(let i = 0; i < collections.length; i++){
			if(this.vueConfig.collections.indexOf(collections[i].collection) === -1){
				this.vueConfig.collections.push(collections[i].collection);
			}

			for(let j = 0; j < collections[i].prop.components.length; j++){
				if(this.vueConfig.components.indexOf(collections[i].prop.components[j].component) === -1){
					this.vueConfig.components.push(collections[i].prop.components[j].component);
				}
			}
		}
	};

	this.RootVue(rootName);
}

function $C(componentArray, collectionName){
	if(typeof collectionName === 'undefined'){
		collectionName = 'blank';
	}

	if(Array.isArray(componentArray) !== true){
		let array = [];
		array.push(componentArray);
		componentArray = array;
	}

	return {
		collection: collectionName,
		prop: {
			components: componentArray,
		}
	};
}