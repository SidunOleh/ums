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

		if ($users === false) {
			return Request::makeError(500, 'Internal Server Error');
		}

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

		if ($user === false) {
			return Request::makeError(500, 'Internal Server Error');
		}

		if (count($user) == 0) {
			return Request::makeError(100, 'Not fount user');
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
		$user = $_POST['user'] ?? [];
		
		$validator = Validator::get('user');

		if ($errors = $validator->validate($user)) {
			return Request::makeError(400, 'Invalid inputs', $errors);
		}

		$validated = $validator->validated();

		if (! $id = User::create($validated)) {
			return Request::makeError(500, 'Internal Server Error');
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
		$user = $_POST['user'] ?? [];

		$validator = Validator::get('user');

		if ($errors = $validator->validate($user)) {
			return Request::makeError(400, 'Invalid inputs', $errors);
		}

		$validated = $validator->validated();

		if (! User::update($validated, $id)) {
			return Request::makeError(500, 'Internal Server Error');
		}

		return Request::make();
	}

	/**
     * Deletes user
     * 
     * @param int $id user's id
     * 
     * @return string response
     */
	public function delete($id)
	{
		if (! User::delete($id)) {
			return Request::makeError(500, 'Internal Server Error');
		}

		return Request::make();
	}

	/**
     * Deletes group of users
     * 
     * @return string response
     */
	public function deleteGroup()
	{
		$ids = $_POST['users_ids'] ?? [];

		if (count($ids) == 0) {
			return Request::makeError(400, 'Invalid inputs');
		}

		if (! User::deleteGroup($ids)) {
			return Request::makeError(500, 'Internal Server Error');
		}

		return Request::make();
	}

	/**
     * Changes status to active to group of users
     * 
     * @return string response
     */
	public function activateGroup()
	{
		$ids = $_POST['users_ids'] ?? [];

		if (count($ids) == 0) {
			return Request::makeError(400, 'Invalid inputs');
		}

		if (! User::activateGroup($ids)) {
			return Request::makeError(500, 'Internal Server Error');
		}

		return Request::make();
	}
	
	/**
     * Changes status to inactive to group of users
     * 
     * @return string response
     */
	public function deactivateGroup()
	{
		$ids = $_POST['users_ids'] ?? [];

		if (count($ids) == 0) {
			return Request::makeError(400, 'Invalid inputs');
		}

		if (! User::deactivateGroup($ids)) {
			return Request::makeError(500, 'Internal Server Error');
		}

		return Request::make();
	}
}
