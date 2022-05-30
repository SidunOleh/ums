<?php

namespace Components;

class Request
{
	/**
     * Makes response
     *      
     * @param array $data
     * 
     * @return string response
     */
	public static function make($data=[])
	{
		$response = [
			'status' => true,
			'error'  => null,
		];

		if (! empty($data)) {
			$response = array_merge($response, $data);
		}

		return json_encode($response);
	}

	/**
     * Makes error response
     *      
     * @param int $code status code
     * @param string $message
     * @param array $data
     * 
     * @return string response
     */
	public static function makeError($code, $message, $data=[])
	{
		$response = [
			'status' => false,
			'error'  => [
				'code'    => $code,
				'message' => $message, 
			],
		];

		if (! empty($data)) {
			$response['error']['data'] = $data;
		}

		return json_encode($response);
	}
}
