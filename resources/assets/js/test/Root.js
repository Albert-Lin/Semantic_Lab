/**
 * Created by AlbertLin on 2017/3/17.
 */

require('../require');

import templateLib from '../templates/TemplatesLib.js';

window.ROOT = new Vue({
	el: '#root',
	components: templateLib,
	data: {
		info: templates,
	},
	computed: {},
	watch: {},
	methods: {},
	mounted: function(){}
});