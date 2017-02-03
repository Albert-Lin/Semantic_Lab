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
		Route::get('/{action}', 'TestController@queryBuilder');
	});

	// ROUTE:
	Route::group(['prefix'=>'route'], function(){
		Route::get( '/', 'TestController@getRouteList');
		Route::get( '/view', 'TestController@getRouteListInView');
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
	});

	// EXECUTE EXTERNAL FILE:
	Route::group(['prefix'=>'exe'], function(){
		Route::get('/{type}', 'TestController@exe');
	});

	// CSS:
	Route::group(['prefix'=>'css'], function(){
		Route::get('/side_bar_trans', 'TestController@sideBarTrans');
		Route::get('/left_tabs', 'TestController@leftTabs');
		Route::get('/grid', 'TestController@grid');
		Route::get('/bs_side_bar_trans', 'TestController@bsSideBarTrans');
	});

	// FACEBOOK:
	Route::group(['prefix'=>'facebook'], function(){
		Route::get('/', 'TestController@facebook');
		Route::get('/login', 'TestController@fbLogin');
	});

	// TEST:
	Route::get('/test/regex/{regex}', 'TestController@regex');

});


// FOR SEMANTIC LAB
Route::group(['prefix' => ''], function(){
	Route::get( '/', 'SemanticLabController@index')->name('root');
	Route::post('/login', 'SemanticLabController@login');
	Route::get('/logout', 'SemanticLabController@logout');
});