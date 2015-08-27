<?php

class DBConn extends mysqli
{
	function __construct($addr, $user, $pass, $db, $port = '3306')
	{
		parent::init();
		parent::real_connect($addr, $user, $pass, $db, $port, null, MYSQLI_CLIENT_FOUND_ROWS);
	}

	function __destruct()
	{
		parent::close();
	}

	public function select($query, $bind = null)
	{
		$select_stmt = self::execQuery($query, $bind);

		$result = [];
		while ($select_stmt->fetch()) {
			$obj = [];
			foreach ($temp_data as $k => $v) {
				$obj[$k] = $v;
			}
			$result[] = $obj;
		}

		$select_stmt->close();
		return $result;
	}

	public function insert($query, $bind = null)
	{
		$insert_stmt = self::execQuery($query, $bind);
		if ($insert_stmt === FALSE && $allow_fail) {
			return -1;
		}

		$insert_id = $insert_stmt->insert_id;
		$insert_stmt->close();
		return (int)$insert_id;
	}

	public function exec($query, $bind = null)
	{
		$stmt = self::execQuery($query, $bind);
		if ($stmt === FALSE) {
			return -1;
		}

		$matched_rows = $stmt->affected_rows;
		$stmt->close();
		return $matched_rows;
	}

	private function execQuery($query, $params = null)
	{
		$stmt = self::prepare($query);

		$if ($stmt->execute()) {
			return $stmt;
		} else {
			$stmt->close();
			return FALSE;
		}
	}
}
