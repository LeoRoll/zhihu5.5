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

Route::get('/', function () {
    return view('welcome');
});
Route::get('user',function(){
//    $user = \App\User::find(4);
    $user = \App\User::with('posts')->paginate(2);
    return new \App\Http\Resources\UserCollection($user);
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\Controllers'], function ($api) {
        $api->group(['middleware' => 'jwt.auth'], function ($api) {
            $api->get('posts', 'PostController@index');
            $api->get('posts/{id}', 'PostController@show');
            $api->get('user/me','AuthController@getAuthenticatedUser');
        });

        $api->post('user/login','AuthController@store');
//        $api->post('user/register','AuthController@register');

    });
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
