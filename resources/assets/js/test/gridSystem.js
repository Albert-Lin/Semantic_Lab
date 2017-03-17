/**
 * Created by AlbertLin on 2017/3/16.
 */

require('../require.js');

Vue.component('gridSystem', require('../grids/gridSystem.vue'));

let gridS = new Vue({

	el: '#gridSystem',
	data: {
		info: [
			{
				component: 'gridSystem',
				prop: {
					componentData: ctrlData,
					classArray: {
						lg: [0, 3],
						md: [0, 4],
						sm: [3, 3],
						xs: [12]
					}
				}
			}
		]
	},
	computed: {},
	watch: {},
	methods: {},
	mounted: function(){}


});