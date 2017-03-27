/**
 * Created by Albert Lin on 2017/3/26.
 */

require('../require.js');

(function(callback){
	callback();
})(sideBar);

function sideBar(){

	window.sidebar = new Vue({
		el: '#sideBarRoot',
		components:{
			animated_v_sidebar: require('../templates/animated_v_sidebar.vue'),
		},
		data: {
			prop: {
				main: {
					grid: 'gridSystem',
					prop:{
						collections: [],
						lg:[0, 12]
					}
				},
				funContent: {
					grid: 'gridSystem',
					prop:{
						collections: [],
						lg:[0, 12]
					}
				},
				funBar: {
					grid: 'gridSystem',
					prop:{
						collections: [],
						lg:[0, 12]
					}
				}
			},
		}
	});

}