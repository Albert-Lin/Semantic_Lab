/**
 * Created by AlbertLin on 2017/3/17.
 */

let componentsPath = './';
let pie;
let includeC0;
let includeC1;
let includeC2;
let comp0;
let comp1;
let comp2;

(function(){
	for(let i = 0; i < window.currentVue.components.length; i++){
		switch(window.currentVue.components[i]){
			case 'pie':
				pie = require(componentsPath+'pie.vue');
				break;
			case 'includeC0':
				includeC0 = require(componentsPath+'component0.vue');
				break;
			case 'includeC1':
				includeC1 = require(componentsPath+'component1.vue');
				break;
			case 'includeC2':
				includeC2 = require(componentsPath+'component2.vue');
				break;
			case 'comp0':
				comp0 = require(componentsPath+'comp0.vue');
				break;
			case 'comp1':
				comp1 = require(componentsPath+'comp1.vue');
				break;
			case 'comp2':
				comp2 = require(componentsPath+'comp2.vue');
				break;
		}
	}
})();

export default{
	pie: pie,
	includeC0: includeC0,
	includeC1: includeC1,
	includeC2: includeC2,
	comp0: comp0,
	comp1: comp1,
	comp2: comp2,
};