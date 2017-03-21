/**
 * Created by AlbertLin on 2017/3/17.
 */

require('../require.js');


(function(){
	axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
	axios({
		url: 'http://semanticlab.com/test/vue/vue-ss',
		method: 'post',
	})
		.then(function(response){
			let serviceData = response.data;
			window.config
				.setTemplate({
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

			setROOT();
		})
		.catch(function(error){
			console.log('Error: ');
			console.log(error.response);
		});
})();


function setROOT(){
	window.ROOT = new Vue({
		el: '#root',
		components: require('../templates/TemplatesLib.js').default,
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
}