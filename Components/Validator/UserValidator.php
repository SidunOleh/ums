<?php

namespace Components\Validator;

class UserValidator extends Validator
{
	public function __construct()
	{
		$this->rules = [
			'first_name' => '[0-9a-zA-Zа-яёА-ЯЁ]{3,}',
			'last_name'  => '[0-9a-zA-Zа-яёА-ЯЁ]{3,}',
			'role'       => 'user|admin',
			'status'     => '0|1',
		];

		$this->messages = [
			'first_name' => 'Invalid First Name(at least 3 letters)',
			'last_name'  => 'Invalid Last Name(at least 3 letters)',
			'role'       => 'Invalid role(choose User or Admin)',
			'status'     => 'Invalid status',
		];
	}
}
