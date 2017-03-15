/**
 * Created by AlbertLin on 2017/3/14.
 */

require('../bootstrap');

Vue.component('pie', require('../components/vue/pie.vue'));

var svgPie = new Vue({

	el: '#pieChart',
	data: {
		id: 'pieChart',
		info:[
			{
				component: 'pie',
				prop: {
					data: [1, 2, 3, 4, 5, 6]
				}
			}
		]
	},
	mounted: function(){
		for(var i = 0; i < this.info.length; i++){
			this.info[i].idClass = this.id+'_'+this.info[i].component+'_'+i;
		}
	}

});