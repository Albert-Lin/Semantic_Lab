/**
 * Created by AlbertLin on 2017/3/22.
 */

let collectionsPath = './';
let blank;
let ctrl_bashBoard;

(function(){
	if(window.currentVue !== undefined){
		for(let i = 0; i < window.currentVue.collections.length; i++){
			switch(window.currentVue.collections[i]) {
				case 'blank':
					blank = require(collectionsPath + 'blank.vue');
					break;
				case 'ctrl_bashBoard':
					ctrl_bashBoard = require(collectionsPath + 'ctrlDashboard.vue');
					break;
			}
		}
	}
})();

export default{
	blank: blank,
	ctrl_bashBoard: ctrl_bashBoard,
}