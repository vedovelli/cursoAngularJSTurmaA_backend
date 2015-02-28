<?php

Route::post('login', ['uses' => 'LoginController@login']);

Route::get('logout', ['uses' => 'LoginController@logout']);

Route::get('logged-in', ['uses' => 'LoginController@isLogged']);

Route::group(['prefix' => 'api', 'before' => 'auth.basic'], function()
{
	/**
  * User
  */
  Route::resource('user', 'UserController');

  Route::get('cities', ['uses' => 'CityController@listCities']);

  Route::get('gravatar/{email}', ['uses' => 'UserController@gravatar']);

	Route::group(['prefix' => 'product'], function()
	{
		Route::get('', ['uses' => 'ProductController@products']);

		Route::get('{id}', ['uses' => 'ProductController@get']);

		Route::post('', ['uses' => 'ProductController@create']);

		Route::put('{id}', ['uses' => 'ProductController@update']);

		Route::delete('{id}', ['uses' => 'ProductController@remove']);
	});
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