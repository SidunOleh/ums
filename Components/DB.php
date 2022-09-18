<?php

namespace Components;

class DB {
	/**
     * @var mysqli
     */
	private static $db;

	/**
	 * Connects to MySQL
	 * 
     * @return void
     */
	private static function connect()
	{
		$params = require_once 'Config/db.php';

		$mysqli = new \mysqli($params['hostname'], $params['username'], 
			$params['password'], $params['database']);

		if ($mysqli->connect_errno) {
			die(Request::makeError(500, 'Internal Server Error'));
		}

		self::$db = $mysqli;
	}

	/**
	 * Sends query to MySQL
	 * 
	 * @param string query
	 * 
     * @return mysqli_result|bool result of query
     */
	public static function query($query)
	{
		if (self::$db === null) {
			self::connect();
		}

		return self::$db->query($query);
	}

	/**
	 * Returns mysqli
	 * 
     * @return mysqli
     */
	public static function get()
	{
		if (self::$db === null) {
			self::connect();
		}

		return self::$db;
	}

	/**
	 * Returns of the last inserted row id
	 * 
     * @return int|null
     */
	public static function insertId()
	{
		return self::$db ? self::$db->insert_id : null;
	}

	/**
	 * Returns number of affected rows in a previous query
	 * 
     * @return int|null
     */
	public static function affected()
	{
		return self::$db ? self::$db->affected_rows : null;
	}
}
