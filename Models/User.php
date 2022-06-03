<?php

namespace Models;

use Components\DB;

class User
{
	/**
	 * Gets all users
	 * 
     * @return array|bool users
     */
	public static function getAll()
	{
		$result = DB::query("SELECT * FROM `users` ORDER BY `id` ASC");

		if (! $result) {
			return false;
		}

		$users = $result->fetch_all(MYSQLI_ASSOC);

		return $users;
	}

	/**
     * Gets user
     * 
     * @param $id user's id
     * 
     * @return array|bool users
     */
	public static function get($id)
	{
		$result = DB::query("SELECT * FROM `users` WHERE `id`='$id'");

		if (! $result) {
			return false;
		}

		if (! $user = $result->fetch_assoc()) {
			return [];
		}

		return $user;
	}

	/**
	 * Creates a new user
	 * 
	 * @param array $user user's data
	 * 
     * @return int|bool id of created user
     */
	public static function create($user)
	{
		$result = DB::query("
			INSERT INTO 
				`users`(`first_name`, `last_name`, `role`, `status`)
			VALUES
				('$user[first_name]', '$user[last_name]', '$user[role]', '$user[status]')");
		
		if (! $result) {
			return false;
		}

		return DB::get()->insert_id;
	}

	/**
	 * Updates user
	 * 
	 * @param array $user user's data
	 * @param int $id user's id
	 * 
     * @return bool|int
     */
	public static function update($user, $id)
	{
		$exist = DB::query("SELECT `id` FROM `users` WHERE `id`='$id'");

		if (! $exist->fetch_assoc()) {
			return 0;
		}

		$result = DB::query("UPDATE `users` 
			SET 
				`first_name`='$user[first_name]', `last_name`='$user[last_name]',
				`role`='$user[role]', `status`='$user[status]'
			WHERE 
				`id`='$id'");

		if (! $result) {
			return false;
		}

		return true;
	}

	/**
	 * Deletes user
	 * 
	 * @param int $id user's id
	 * 
     * @return bool
     */
	public static function delete($id)
	{
		$result = DB::query("DELETE FROM `users` WHERE `id`='$id'");

		if (! $result) {
			return false;
		}
		
		return DB::get()->affected_rows;
	}

	/**
	 * Deletes group of users
	 * 
	 * @param int $ids user's ids
	 * 
     * @return bool
     */
	public static function deleteGroup($ids)
	{
		$ids = implode(',', $ids);

		$result = DB::query("DELETE FROM `users` WHERE `id` IN ($ids)");

		return $result;
	}

	/**
	 * Changes status to active group of users
	 * 
	 * @param int $userIds
	 * 
     * @return bool
     */
	public static function activateGroup($usersIds)
	{
		$usersIds = implode(',', $usersIds);

		$result = DB::query("UPDATE `users` SET `status`=1 WHERE `id` IN ($usersIds)");

		return $result;
	}

	/**
	 * Changes status to inactive group of users
	 * 
	 * @param int $userIds
	 * 
     * @return bool
     */
	public static function deactivateGroup($usersIds)
	{
		$usersIds = implode(',', $usersIds);

		$result = DB::query("UPDATE `users` SET `status`=0 WHERE `id` IN ($usersIds)");

		return $result;
	}
}
