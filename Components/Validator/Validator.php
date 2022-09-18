<?php

namespace Components\Validator;

abstract class Validator
{
	/**
     * @var array validation rules
     */
	protected $rules;
	
	/**
     * @var array error messages
     */
	protected $messages;
	
	/**
     * @var array validated data
     */
	protected $validated;

	/**
	 * Сreates an instance of the validator
	 * 
	 * @param $validator name of validator
	 * 
     * @return instance of the validator
     */
	public static function get($validator)
	{
		$validator = 'Components\Validator\\' . 
			ucfirst(mb_strtolower($validator)) . 'Validator';

		return new $validator();
	}

	/**
	 * Validates the received data 
	 * 
	 * @param $data received data
	 * 
     * @return array errors
     */
	public function validate($data)
	{
		$errors = [];

		foreach ($this->rules as $field => $pattern) {
			if (! isset($data[$field]) or ! preg_match("~".$pattern."~", $data[$field])) {
				$errors[$field] = $this->messages[$field];
			} else {
				$this->validated[$field] = $data[$field];
			}
		}

		return $errors;
	}

	/**
	 * Return validated data
	 * 
     * @return array validated data
     */
	public function validated()
	{
		return $this->validated;
	}
}
