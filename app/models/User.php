<?php
// TODO adicionar error handling

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $fillable = ['fullname', 'username', 'email', 'password', 'zip', 'city', 'state' ];
	protected $hidden = ['password', 'remember_token'];

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
	}

	public function list_users($cities, $orderBy, $limit = 10, $page = 1)
	{

		$paginator = $this;

		if(!is_null($cities)){

			$cities = explode(',',$cities);
			$paginator = $paginator->wherein('city', $cities);
		}

		if(!is_null($orderBy)){

			$orderBy = explode('|', $orderBy);
			$paginator = $paginator->orderBy($orderBy[0], $orderBy[1]);
		} else {

			$paginator = $paginator->orderBy('updated_at', 'desc');
		}

		$paginator = $paginator->paginate($limit);

		$users = $paginator->getItems();

		foreach ($users as $index => $user) {

			$user['gravatar'] = $this->get_gravatar($user['email']);
			$users[$index] = $user;
		}

		$response = [
			'users'   => $users,
			'pagination' => [
				'total'        => $paginator->getTotal(),
				'per_page'     => $paginator->getPerPage(),
				'current_page' => $paginator->getCurrentPage(),
				'last_page'    => $paginator->getLastPage(),
				'from'         => $paginator->getFrom(),
				'to'           => $paginator->getTo()
			]
		];

		return $response;
	}

	function get_gravatar($email) {

		return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?s=200";
	}

	public function get_user($id)
	{
		return $this->find($id);
	}

	public function save_user($input)
	{
		return $this->create($input);
	}

	public function update_user($id, $input)
	{
		$user = $this->find($id);

		$user->fill($input);

		$user->save();

		return $user;
	}

	public function delete_user($id)
	{
		$user = $this->find($id);

		$user->delete();

		return $user;
	}

}