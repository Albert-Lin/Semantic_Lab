/**
 * Created by Albert Lin on 2017/3/12.
 */

require('../bootstrap');

Vue.component('comp0', require('../components/vue/comp0.vue'));
Vue.component('comp1', require('../components/vue/comp1.vue'));
Vue.component('comp2', require('../components/vue/comp2.vue'));
Vue.component('component2', require('../components/vue/component2.vue'));

const singleFile = new Vue({
	el: '#singleFile',
	data: {
		info: passData,
		name: '',
		mvp: '',
		team: ''
	},
	watch:{
		name: function(newName){
			for(var i = 0; i < this.info.length; i++){
				this.info[i].prop.name = newName;
			}
		},
		mvp: function(newMvp){
			var newArray;
			this.info[1].prop.mvp[0] = newMvp;
			newArray = this.info[1].prop.mvp;
			this.info[1].prop.mvp = [];
			this.info[1].prop.mvp = newArray;

		},
		team: function(newTeam){
			for(var i = 0; i < this.info.length; i++){
				if(this.info[i].prop.team !== undefined){
					this.info[i].prop.team = newTeam;
				}
			}
		}
	},
	mounted: function(){
		// this.info = passData;
	}
});