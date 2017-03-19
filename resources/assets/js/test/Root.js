/**
 * Created by AlbertLin on 2017/3/17.
 */

require('../require.js');

import templateLib from '../templates/TemplatesLib.js';

window.ROOT = new Vue({
	el: '#root',
	components: templateLib,
	data: {
		info: templates,
		currentTemplate: templates[0],
	},
	computed: {},
	watch: {},
	methods: {
		changeTemp: function(temp){
			for(let i = 0; i < this.info.length; i++){
				if(this.info[i].template === temp){
					this.currentTemplate = this.info[i];
				}
			}
		}
	},
	mounted: function(){}
});