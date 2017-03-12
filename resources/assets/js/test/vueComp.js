/**
 * Created by Albert Lin on 2017/3/11.
 */

require('../bootstrap');

Vue.component('includeC0', require('./../components/vue/component0.vue'));
Vue.component('includeC1', require('./../components/vue/component1.vue'));
Vue.component('includeC2', require('./../components/vue/component2.vue'));


const includeComCont = new Vue({
	el: '#includeComCont',
	data: {
		info: [
			{
				component: 'includeC0',
				prop: {
					prop0: 'I am in component 0 !!'
				}
			},
			{
				component: 'includeC1',
				prop: {
					prop1: ['comp2_A', 'comp2_B', 'comp2_C']
				}
			},
			{
				component: 'includeC2',
				prop: {
					prop2: 'Dirk',
					prop3: 'Nowitzki'
				}
			}
		]
	},
	mounted: function(){
		console.log("mounted started");
	}
});