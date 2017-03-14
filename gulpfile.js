const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir(function(mix){
	mix
		// .sass('app.scss')
//		.webpack('./resources/assets/js/app.js', './public/js/app.js')
// 		.webpack('./resources/assets/js/test/vueComp.js', './public/js/vue/test/vueComp.js')
// 		.webpack('./resources/assets/js/test/vueSf.js', './public/js/vue/test/vueSf.js')
		.webpack('./resources/assets/js/test/d3_pie.js', './public/js/vue/test/pie.js')
	;
});
