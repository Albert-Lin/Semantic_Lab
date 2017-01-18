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

// The index of root page
Route::get( '/', 'RootController@index');


// NORMAL:
Route::get( 'test', 'TestController@index');
Route::get( 'test/beauty-url/{category}/{page}', 'TestController@beautyURL');

// ROUTE:
Route::get( 'test/route', 'TestController@getRouteList');
Route::get( 'test/route/view', 'TestController@getRouteListInView');

// REQUEST:
Route::get( 'test/request', 'TestController@request');
Route::get( 'test/get-request/{type}', 'TestController@getReguest' );
Route::get( 'test/url-request/{category}/{page}', 'TestController@getUrlRequest');

// SESSION:
Route::get('test/set-session', 'TestController@setSession');
Route::get('test/get-session/{type}', 'TestController@getSession');
Route::get('test/delete-session/{type}', 'TestController@deleteSession');

// API:
Route::get('test/call-api', 'TestController@callAPI');

// Processing P5:
Route::get('test/p5', 'TestController@p5');
Route::get('test/p5/linked', 'TestController@p5Linked');

// D3:
Route::get('test/d3', 'TestController@d3');
Route::get('test/d3/svg', 'TestController@d3Svg');
Route::get('test/d3/svg/json', 'TestController@d3SvgJson');
Route::get('test/d3/svg/path', 'TestController@path');

// NEO4J:
Route::get('test/neo4j', 'TestController@neo4j');
Route::get('test/neo4j/d3', 'TestController@vis');
Route::get('test/neo4j/mvc', 'TestController@visMVC');

// GOOGLE MAP:
Route::get('test/google_map/', 'TestController@gmap');
Route::get('test/google_map/class', 'TestController@googleMap');

// Excute external file:
Route::get('test/exe/{type}', 'TestController@exe');

// CSS:
Route::get('test/css/side_bar_trans', 'TestController@sideBarTrans');
Route::get('test/css/left_tabs', 'TestController@leftTabs');