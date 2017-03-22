/**
 * Created by AlbertLin on 2017/3/17.
 */

require('../require.js');


(function(callback){
	axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
	axios({
		url: 'http://semanticlab.com/test/vue/vue-ss',
		method: 'post',
	})
		.then(function(response){
			let serviceData = response.data;
			rootVue('root')
				.setTemplate({
					template: 'blank',
					block0: {
						collections: [
							$C(serviceData[0]), $C(serviceData[1]),
							$C(serviceData[2]), $C(serviceData[3]),
							$C(serviceData[4]), $C(serviceData[5]),
						]
					},
				})
				.setTemplate({
					template: 'temp0',
					block0: {
						componentData: [$C(serviceData[4]), $C(serviceData[5])],
						lg: [0, 4],
						md: [0, 6],
					},
					block1: {
						collections: [$C(serviceData[2]), $C(serviceData[3])],
						lg: [3, 3],
						md: [0, 6],
					},
					block2: {
						collections: [$C(serviceData[0]), $C(serviceData[1])],
						lg: [2, 4],
						md: [0, 6],
					},
				});
				// .setVueConfig(['blank', 'temp0'], ['gridSystem'])
				// .setCollections(serviceData)
				// .setComponents(serviceData);
			setROOT('root');
		})
		.catch(function(error){
			console.error('AXIOS: '+error.response);
		});
})(setROOT);


function setROOT(rootName){
	window.currentTemplate = templates[rootName][0];
	window.ROOT = new Vue({
		el: '#root',
		components: require('../templates/TemplatesLib.js').default,
		data: {
			info: templates[rootName],
			currentTemplate: templates[rootName][0],
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