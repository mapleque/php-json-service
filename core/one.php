<?php

/**
 * 举个例子
 */
class One
{
	public static function getOne($key)
	{
		$sql = 'SELECT key, value
				FROM one
				WHERE key = ? LIMIT 1';
		return DB::select($sql, [ $key ])[0];
	}

	public static function setOne($key, $value)
	{
		$sql = 'INSERT INTO one (key, value) VALUES (?, ?)
				ON DUPLICATE KEY UPDATE value = ?';
		$bind = [ $key, $value, $value ];
		return DB::insert($sql, $bind) >= 0;
	}

	public static function delOne($key)
	{
		$sql = 'DELETE FROM one
				WHERE $key = ?';
		return DB::delete($sql,[ $key ]) >= 0;
	}

	public static function getOneCount()
	{
		$sql = 'SELECT count(key) as c
				FROM one';
		return DB::select($sql)[0]['c'];
	}

	public static function getOneList($start, $num)
	{
		$sql = 'SELECT key, value
				FROM one
				LIMIT ? OFFSET ?';
		$bind = [ $num, $start ];
		return DB::select($sql, $bind);
	}
}
