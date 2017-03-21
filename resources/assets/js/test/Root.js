/**
 * Created by AlbertLin on 2017/3/17.
 */

require('../require.js');

// import templateLib from '../templates/TemplatesLib.js';

let rootConfig = {
	el: '#root',
	components: undefined,
	data: {
		info: templates,
	},
	computed: {
		currentTemplate: function(){
			return this.info[0];
		}
	},
	watch: {
		info: function(newInfo){
			rootConfig.components = require('../templates/TemplatesLib.js').default;
			rootConfig.data.ajax = 'true';
			window.ROOT = new Vue(rootConfig);
		}
	},
	methods: {
		init: function(){
			console.log(rootConfig.components);
			if(templates.length === 0){
				axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
				axios({
					url: 'http://semanticlab.com/test/vue/vue-ss',
					method: 'post',
				})
					.then(function(response){
						let serviceData = response.data;
						window.config.setTemplate({
							template: 'blank',
							block0: {
								componentData: [serviceData[0], serviceData[1], serviceData[2], serviceData[3], serviceData[4], serviceData[5]],
							},
						})
							.setTemplate({
								template: 'temp0',
								block0: {
									componentData: [serviceData[4], serviceData[5]],
									lg: [0, 4],
									md: [0, 6],
								},
								block1: {
									componentData: [serviceData[2], serviceData[3]],
									lg: [3, 3],
									md: [0, 6],
								},
								block2: {
									componentData: [serviceData[0], serviceData[1]],
									lg: [2, 4],
									md: [0, 6],
								},
							})
							.setVueConfig(['blank', 'temp0'], ['gridSystem'])
							.setComponents(serviceData);
						window.ROOT.info = templates;
					})
					.catch(function(error){
						console.log('Error: ');
						console.log(error.response);
					});
			}
		},
		changeTemp: function(temp){
			for(let i = 0; i < this.info.length; i++){
				if(this.info[i].template === temp){
					this.currentTemplate = this.info[i];
				}
			}
		}
	},
	mounted: function(){
		this.init();
	}
};

window.ROOT = new Vue(rootConfig);