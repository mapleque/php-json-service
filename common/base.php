<?php

/**
 * 处理请求输入输出
 */
 class Base
 {
 	public static function getRequestJson($assoc = null)
	{
		$post = $_POST['data'];
		$json = json_decode($post, $assoc);
		if (json_last_error() !== JSON_ERROR_NONE) {
			self::dieWithError(ERROR_INVALIDE_REQUEST);
		}
		return $json;
	}

	public static function dieWithError($err, $errmsg = null)
	{
		$json = json_encode(array_merge([ 'status' => $err ], ($errmsg) ? [ 'err' => $errmsg ] : []));
		die($json);
	}

	public static function diewWithResponse($obj = null)
	{
		$json = json_encode(array_merge([ 'status' => ERROR_SUCCESS ], ($obj !== null) ? [ 'data' => $obj ] : []));
		echo $json;
		die();
	}
 }
