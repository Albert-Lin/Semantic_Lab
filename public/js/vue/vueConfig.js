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
	this.templates = [];
	this.RootVue = function (rootName) {
		// window.vueConfigs[rootName] = {
		// 	templates: [],
		// 	grids: ['gridSystem'],
		// 	collections: [],
		// 	components: [],
		// };
		// this.vueConfig = window.vueConfigs[rootName];
		window.templates[rootName] = [];
		this.templates = window.templates[rootName];
		window.current = rootName;

		return this;
	};
	// this.setTemplate = function(tempConfig){
	// 	let template = new Template(tempConfig).config;
	// 	this.templates.push(template);
	//
	// 	return this;
	// };
	// this.setVueConfig = function(tempsArray, gridsArray, compsArray){
	// 	this.vueConfig.templates = tempsArray;
	// 	this.vueConfig.grids = gridsArray;
	// 	if(typeof compsArray !== 'undefined'){
	// 		this.vueConfig.components = compsArray;
	// 	}
	//
	// 	return this;
	// };
	// this.setCollections = function(components){
	// 	for(let i = 0; i < components.length; i++){
	// 		if(this.vueConfig.collections.indexOf(components[i].collection) === -1){
	// 			this.vueConfig.collections.push(components[i].collection);
	// 		}
	// 	}
	//
	// 	return this;
	// };
	// this.setComponents = function(components){
	// 	for(let i = 0; i < components.length; i++){
	// 		if(this.vueConfig.components.indexOf(components[i].component) === -1){
	// 			this.vueConfig.components.push(components[i].component);
	// 		}
	// 	}
	//
	// 	return this;
	// };

	this.setTemplate = function (config) {
		let result = {
			template: undefined,
			prop: {}
		};

		if(config.template !== undefined){
			result.template = config.template;
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


	this.RootVue(rootName);
}

// function $C(componentData, collectionName){
// 	if(typeof collectionName === 'undefined'){
// 		collectionName = 'blank';
// 	}
// 	componentData.collection = collectionName;
// 	return componentData;
// }

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