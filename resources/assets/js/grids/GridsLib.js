/**
 * Created by AlbertLin on 2017/3/17.
 */

let gridsPath = './';
let gridSystem;

(function(){
	for(let i = 0; i < currentVueConfig.grids.length; i++){
		switch(currentVueConfig.grids[i]){
			case 'gridSystem':
				gridSystem = require(gridsPath+'gridSystem.vue');
				break;
		}
	}
})();

export default {
	gridSystem: gridSystem,
};