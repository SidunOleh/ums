<?php

namespace Controllers;

use Models\User;
use Components\Validator\Validator;
use Components\Request;

class UserController
{
	/**
     * Gets all users
     * 
     * @return void|string response
     */
	public function viewAll()
	{
		$users = User::getAll();

		require_once 'Views/index.php';
	}

	/**
     * Gets user
     * 
     * @return string response
     */
	public function view($id)
	{
		$user = User::get($id);


		if ($user === null) {
			return Request::makeError(100, 'Not Found User');
		}

		return Request::make(['user'=>$user]);
	}

	/**
     * Creates a new user
     * 
     * @return string response     
     */
	public function create()
	{
		$user = (array) ($_POST['user'] ?? []);

		$validator = Validator::get('user');

		if ($errors = $validator->validate($user)) {
			return Request::makeError(400, 'Invalid Inputs', $errors);
		}

		$validated = $validator->validated();

		if (! $id = User::create($validated)) {
			return Request::makeError(100, 'Not Found User');
		}

		return Request::make(['id'=>$id]);
	}

	/**
     * Updates user
     * 
     * @param int $id user's id
     * 
     * @return string response
     */
	public function update($id)
	{
		$user = (array) ($_POST['user'] ?? []);

		$validator = Validator::get('user');

		if ($errors = $validator->validate($user)) {
			return Request::makeError(400, 'Invalid Inputs', $errors);
		}

		$validated = $validator->validated();

		$updated = User::update($validated, $id);

		if ($updated === null) {
			return Request::makeError(100, 'Not Found User');
		}

		return Request::make();
	}

	/**
     * Deletes users
     * 
     * @return string response
     */
	public function delete()
	{
		$ids = (array) ($_POST['users_ids'] ?? []);

		if (count($ids) === 0) {
			return Request::makeError(400, 'Invalid Inputs');
		}

		if (User::delete($ids) === null) {
			return Request::makeError(100, 'Not Found User');
		}

		return Request::make();
	}

	/**
     * Changes user's status
     * 
     * @return string response
     */
	public function changeStatus($status)
	{
		$ids = (array) ($_POST['users_ids'] ?? []);

		if (count($ids) === 0) {
			return Request::makeError(400, 'Invalid Inputs');
		}

		if (User::changeStatus($ids, $status) === null) {
			return Request::makeError(100, 'Not Found User');
		}

		return Request::make();
	}
}
