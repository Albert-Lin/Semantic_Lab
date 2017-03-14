/**
 * Created by AlbertLin on 2017/3/14.
 */

Vue.component('pie', require('../components/vue/pie.vue'));

var svgPie = new Vue({

	el: '#pieChart',
	data: {
		component: 'pie',
		prop: [1, 2, 5]
	}

});