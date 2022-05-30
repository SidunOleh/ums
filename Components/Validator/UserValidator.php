<?php

namespace Components\Validator;

class UserValidator extends Validator
{
	public function __construct()
	{
		$this->rules = [
			'first_name' => '[a-zA-Z]{3,}',
			'last_name'  => '[a-zA-Z]{3,}',
			'role'       => 'user|admin',
			'status'     => '0|1',
		];

		$this->messages = [
			'first_name' => 'Invalid First Name(latin letters, at least 3)',
			'last_name'  => 'Invalid Last Name(latin letters, at least 3)',
			'role'       => 'Valid values: User or Admin',
			'status'     => 'Invalid status',
		];
	}
}
