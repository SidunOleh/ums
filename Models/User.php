<?php

namespace Models;

use Components\DB;

class User
{
	/**
	 * Gets all users
	 * 
     * @return array users
     */
	public static function getAll()
	{
		$result = DB::query("SELECT * FROM `users` ORDER BY `id` ASC");

		if (! $result) {
			return [];
		}

		$users = $result->fetch_all(MYSQLI_ASSOC);

		return $users;
	}

	/**
     * Gets user
     * 
     * @param $id user's id
     * 
     * @return array|null user
     */
	public static function get($id)
	{
		$result = DB::query("SELECT * FROM `users` WHERE `id`='$id'");

		if (! $result) {
			return null;
		}

		if (! $user = $result->fetch_assoc()) {
			return null;
		}

		return $user;
	}

	/**
	 * Creates a new user
	 * 
	 * @param array $user user's data
	 * 
     * @return int|null id of created user
     */
	public static function create($user)
	{
		$result = DB::query("
			INSERT INTO 
				`users`(`first_name`, `last_name`, `role`, `status`)
			VALUES
				('$user[first_name]', '$user[last_name]', '$user[role]', '$user[status]')");
		
		if (! $result) {
			return null;
		}

		return DB::insertId();
	}

	/**
	 * Updates user
	 * 
	 * @param array $user user's data
	 * @param int $id user's id
	 * 
     * @return bool|null
     */
	public static function update($user, $id)
	{
		$exist = DB::query("SELECT `id` FROM `users` WHERE `id`='$id'");

		if (! $exist->fetch_assoc()) {
			return null;
		}

		$result = DB::query("UPDATE `users` 
			SET 
				`first_name`='$user[first_name]', `last_name`='$user[last_name]',
				`role`='$user[role]', `status`='$user[status]'
			WHERE 
				`id`='$id'");

		if (! $result) {
			return null;
		}

		return true;
	}

	/**
	 * Deletes users
	 * 
	 * @param int $ids user's ids
	 * 
     * @return bool|null
     */
	public static function delete($ids)
	{
		$ids = implode(',', $ids);

		DB::query("DELETE FROM `users` WHERE `id` IN ($ids)");

		if (DB::affected() === 0) {
			return null;
		}

		return true;
	}

	/**
	 * Changes user's status
	 * 
	 * @param int $ids user's ids
	 * 
     * @return bool|null
     */
	public static function changeStatus($ids, $status)
	{
		$ids = implode(',', $ids);

		$result = DB::query("UPDATE `users` SET `status`=$status WHERE `id` IN ($ids)");

		if (! $result) {
			return null;
		}

		return true;
	}
}
