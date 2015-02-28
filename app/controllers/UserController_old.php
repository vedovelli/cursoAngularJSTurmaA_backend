<?php

class UserController extends BaseController{

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function users()
	{
		return Response::json($this->user->users(), 200);
	}

	public function create()
	{
		return Response::json($this->user->createUser(), 201);
	}

	public function get($id)
	{
		$user = $this->user->get($id);
		if(is_null($user))
		{
			return Response::json(['response' => 'Usuário não encontrado'], 400);
		}
		return Response::json($user, 200);
	}

	public function update($id)
	{
		if(!$this->user->updateUser($id))
		{
			return Response::json(['response' => 'Usuário não encontrado'], 400);
		}
		return Response::json(['response' => 'Usuário atualizado com sucesso!'], 200);
	}

	public function remove($id)
	{
		if(!$this->user->removeUser($id))
		{
			return Response::json(['response' => 'Usuário não encontrado'], 400);
		}
		return Response::json(['response' => 'Usuário removido com sucesso!'], 200);
	}

}