<?php

class LoginController extends BaseController {

	public function login()
	{
		extract(Input::all());
		if(!Auth::attempt(['email' => $email, 'password' => $password]))
		{
			return Response::json(['response' => 'false', 'message' => 'Falha na autenticação'], 401);
		}
		$token = base64_encode($email.':'.$password);
		Session::set('token', $token);
		return Response::json(['response' => 'true', 'token' => $token], 200);
	}

	public function logout()
	{
		Auth::logout();
		Session::set('token', null);
		return Response::json(['response' => 'true'], 200);
	}

	public function isLogged()
	{
		if(Auth::check())
		{
			return Response::json(['response' => 'true', 'token' => Session::get('token')], 200);
		}
		return Response::json(['response' => 'false'], 401);
	}

}
