<?php

Route::post('login', ['uses' => 'LoginController@login']);

Route::get('logout', ['uses' => 'LoginController@logout']);

Route::get('logged-in', ['uses' => 'LoginController@isLogged']);

Route::group(['prefix' => 'api'], function()
{
	/**
  * User
  */
  Route::resource('user', 'UserController');

  Route::resource('product', 'ProductController');

  Route::get('cities', ['uses' => 'CityController@listCities']);

  Route::get('gravatar/{email}', ['uses' => 'UserController@gravatar']);

  Route::post('upload', ['uses' => 'UploadController@receive']);

});

Route::get('docs', function()
{
	return View::make('api.docs.index');
});

App::missing(function()
{
    return Redirect::to('docs');
});

/**
* CSRF
*/
App::before(function($request)
{
  header("Access-Control-Allow-Origin: *"); // todas as origens estão autorizadas
  header('Access-Control-Allow-Credentials: true');
  if (Request::getMethod() == "OPTIONS") {
    $headers = [
	     'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
       'Access-Control-Allow-Headers'=> 'X-Requested-With, Content-Type, X-Auth-Token, Origin, Authorization'
    ];
    return Response::make('You are connected to the API', 200, $headers);
  }
});