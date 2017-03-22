/**
 * Created by AlbertLin on 2017/3/17.
 */

let gridsPath = './';
let gridSystem;

(function(){
	for(let i = 0; i < window.currentVue.grids.length; i++){
		switch(window.currentVue.grids[i]){
			case 'gridSystem':
				gridSystem = require(gridsPath+'gridSystem.vue');
				break;
		}
	}
})();

export default {
	gridSystem: gridSystem,
};