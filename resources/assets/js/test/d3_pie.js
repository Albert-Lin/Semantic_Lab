/**
 * Created by AlbertLin on 2017/3/14.
 */

require('../bootstrap');

Vue.component('pie', require('../components/vue/pie.vue'));

const svgPie = new Vue({

	el: '#pieChart',
	data: {
		info:[
			{
				component: 'pie',
				prop: [1, 1, 1]
			}
		]
	}

});