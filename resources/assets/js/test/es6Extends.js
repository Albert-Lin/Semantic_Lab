/**
 * Created by Albert Lin on 2017/3/28.
 */

require('../require.js');


let root = new Vue({

	el: '#root',
	components: {
		extend: require('../components/extends.vue'),
	},
	data: {
		data: {
			component: 'extend',
		}
	}

});