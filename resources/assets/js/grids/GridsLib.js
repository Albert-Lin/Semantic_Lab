/**
 * Created by AlbertLin on 2017/3/17.
 */

let gridsPath = './';
let gridSystem;

for(let i = 0; i < vueConfig.grids.length; i++){
	switch(vueConfig.grids[i]){
		case 'gridSystem':
			gridSystem = require(gridsPath+'gridSystem.vue');
			break;
	}
}

export default {
	gridSystem: gridSystem,
};