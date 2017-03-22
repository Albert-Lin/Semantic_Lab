/**
 * Created by AlbertLin on 2017/3/22.
 */

let collectionsPath = './';
let blank;

(function(){
	for(let i = 0; i < window.currentVue.collections.length; i++){
		switch(window.currentVue.collections[i]) {
			case 'blank':
				blank = require(collectionsPath + 'blank.vue');
				break;
		}
	}
})();

export default{
	blank: blank,
}