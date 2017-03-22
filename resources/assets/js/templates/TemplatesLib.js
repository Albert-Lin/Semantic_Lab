/**
 * Created by AlbertLin on 2017/3/17.
 */

let templatesPath = './';
let blank;
let temp0;


(function(){
	switch(currentTemplate.template){
		case 'blank':
			blank = require(templatesPath+'blank.vue');
			break;
		case 'temp0':
			temp0 = require(templatesPath+'temp0.vue');
			break;
	}
})();

export default {
	blank: blank,
	temp0: temp0,
};