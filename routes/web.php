<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ROOT PAGE
//Route::get( '/', 'RootController@index');


// FOR TEST CONTROLLER:
Route::group(['prefix'=>'test'], function(){

	// NORMAL:
	Route::get( '/', 'TestController@index');
	Route::get( '/beauty-url/{category}/{page}', 'TestController@beautyURL');

	// VIEW && TEMPLATE:
	Route::group(['prefix'=>'view'], function(){
		Route::get('/temp/{tempNum}', 'TestController@viewTemp');
	});

	// Model
	Route::group(['prefix'=>'model'], function(){
		Route::get('/note', 'TestController@modelNote');
		Route::get('/builder/{action}', 'TestController@queryBuilder');
		Route::get('/unique', 'TestController@unique');
	});

	// ROUTE:
	Route::group(['prefix'=>'route'], function(){
		Route::get( '/', 'TestController@getRouteList');
		Route::get( '/view', 'TestController@getRouteListInView');
        Route::get('/prefixGroup', 'TestController@getRouteGroupByPrefix');
        Route::get('/routeBlock', 'TestController@routeGroupView');
	});

	// REQUEST:
	Route::group(['prefix'=>'request'], function(){
		Route::get( '/', 'TestController@request');
		Route::get( '/get-request/{type}', 'TestController@getReguest' );
		Route::get( '/url-request/{category}/{page}', 'TestController@getUrlRequest');
	});

	// SESSION:
	Route::group(['prefix'=>'session'], function(){
		Route::get('/set-session', 'TestController@setSession');
		Route::get('/get-session/{type}', 'TestController@getSession');
		Route::get('/delete-session/{type}', 'TestController@deleteSession');
	});

	// COOKIE:
    Route::group(['prefix'=>'cookie'], function(){

        Route::get('/', 'TestController@viewCookie')->name('dumpCookie');

        Route::get('/setCookie/{method}', 'TestController@setCookie');

		Route::get('/setCookieWithTime', 'TestController@setCookieWithTime');

		route::get('/origGetCookie', 'TestController@origGetCookie');

        Route::get('/getCookie/{method}', 'TestController@getCookie');
    });

	// SECURITY:
	Route::group(['prefix'=>'security'], function(){
		Route::get('/hashing/{data}', 'TestController@hashing');
		Route::get('/hashing/db/{username}', 'TestController@dbHashCheck');
		Route::get('/valiData', 'TestController@valiData');
		Route::post('/valiProcess', 'TestController@valiProcess');
	});

	// API:
	Route::group(['prefix'=>'call-api'], function(){
		Route::get('/', 'TestController@callAPI');
	});

	// Processing P5:
	Route::group(['prefix'=>'p5'], function(){
		Route::get('/', 'TestController@p5');
		Route::get('/linked', 'TestController@p5Linked');
	});

	// D3:
	Route::group(['prefix'=>'d3'], function(){
		Route::get('/', 'TestController@d3');
		Route::get('/svg', 'TestController@d3Svg');
		Route::get('/svg/json', 'TestController@d3SvgJson');
		Route::get('/svg/path', 'TestController@path');
		Route::group(['prefix'=>'4_x'], function(){
			Route::get('shape', 'TestController@shape');
		});
	});

	// NEO4J:
	Route::group(['prefix'=>'neo4j'], function(){
		Route::get('/', 'TestController@neo4j');
		Route::get('/d3', 'TestController@vis');
		Route::get('/mvc', 'TestController@visMVC');
	});

	// GOOGLE MAP:
	Route::group(['prefix'=>'google_map'], function(){
		Route::get('/', 'TestController@gmap');
		Route::get('/class', 'TestController@googleMap');
		Route::get('/car', 'TestController@googleCarMap');
        Route::get('/phoneRecord', 'TestController@phoneRecordMap');
        Route::get('/phoneRecordMVC', 'TestController@phoneRecordMVCMap');
	});

	// EXECUTE EXTERNAL FILE:
	Route::group(['prefix'=>'exe'], function(){
		Route::get('/{type}', 'TestController@exe');
	});

	// CSS:
	Route::group(['prefix'=>'css'], function(){
		Route::get('/side_bar_trans', 'TestController@sideBarTrans');
		Route::get('/bs_side_bar_trans', 'TestController@bsSideBarTrans');
		Route::get('/left_tabs', 'TestController@leftTabs');
        Route::get('/grid', 'TestController@grid');
        Route::get('/verNavTransLayout', 'TestController@verNavTransLayout');
	});

	// FACEBOOK:
	Route::group(['prefix'=>'facebook'], function(){
		Route::get('/', 'TestController@facebook');
		Route::get('/login', 'TestController@fbLogin');
	});

	// UTILITY:
	Route::group(['prefix' => 'utility'], function(){
		Route::get('/regexSearch/{searchWord}', 'TestController@autoCompleteSearch');
	});

	// RDF/TRIPLE STORE:
	Route::group(['prefix' => 'triplestore'], function(){
		Route::get('/', 'TestController@tripleStore');
		Route::get('/dbpedia', 'TestController@dbpedia');
		Route::get('/qb', 'TestController@arc2QueryBuilder');
		Route::get('/qbList', 'TestController@qbList');
	});
	
	// VUE JS:
	Route::group(['prefix' => 'vue'],	function(){
		Route::get('vue-test',	'TestController@vueTest');
		Route::get('vue-ctrl/{char?}', 'TestController@vueCtrl');
		Route::get('vue-dash', 'TestController@vueDashboard');
		Route::get('vue-sf', 'TestController@vueSingleFile');
		Route::group(['prefix' => 'axios'], function(){
			Route::get('root', 'TestController@axiosRoot');
			Route::post('post', 'TestController@axiosPost');
		});
		Route::get('vue-gs', 'TestController@gridSystem');
		Route::get('vue-tg', 'TestController@templateGenerator');
		Route::get('vue-ss', 'TestController@simpleStructure');
		Route::post('vue-ss', 'TestController@simpleStructure');
		Route::get('vue-sb', 'TestController@sideBar');
	});

});


// FOR SEMANTIC LAB
Route::group(['prefix' => ''], function(){
	Route::get( '/', 'SemanticLabController@viewRoute')->name('root');
	Route::post('/login', 'SemanticLabController@login');
	Route::post('/login/autoSearch/{searchData}', 'SemanticLabController@autoInputSearch');
    Route::get('/logout', 'SemanticLabController@logout');
    Route::post('/register', 'SemanticLabController@register');

	Route::group(['prefix' => 'dailyCost'], function(){
		Route::get('/{funName?}', 'DailyCost\DailyCostController@viewRoute');
		Route::post('/{function?}/insert', 'DailyCost\DailyCostController@insert');
	});

    Route::group(['prefix'=>'sparql'], function(){
		Route::post('/select', 'SparqlController@select');
    });

});