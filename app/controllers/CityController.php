<?php

class CityController extends \BaseController {


	public function listCities()
	{
		$cities = DB::table('users')->select('city')->distinct()->orderBy('city', 'asc')->get();

		$response = [];

		$response['success'] = isset($cities);

		$response['description'] = 'The list of users\' cities';

		$response['data'] = $cities;

		return Response::json($response, 200);
	}

}
