<?php

require_once __DIR__.'/bootstrap.php';

// Set up the environment
//--------------------------------------------------------->

$data	=	[
	'firstname'	=> 'Johnn',
	'email'		=> 'hello',
	'agreement'	=> '',
	'username'	=> 'bob',
	'age'		=> 'hej',
];

class User
{
	public static function isUsernameTaken($username)
	{
		if($username === 'bob')
			throw new Exception('This username is already taken');
	}
}


// Run the validation
//--------------------------------------------------------->

$validator	=	new Validator;

$validator->ruleuntilbreak(new Validation_Required)

			->ruleuntilbreak(new Validation_LengthGreaterThan(3))

				->field('firstname')

				->field('lastname')

				->field('username')
				->rule('User::isUsernameTaken')

			->breakRule()

			->field('email')
			->rule(new Validation_Email)

			->field('dob')
			->rule(new Validation_Date)

			->field('agreement')
			->rule(function($value)
			{
				if($value !== 'I AGREE')
					throw new Exception('Please write “I AGREE” if you agree with the rules');
			})

			->field('age')
			->rule('ctype_digit')

		->breakRules()

		->ruleuntilbreak(new Validation_Required, Validator::OPERATOR_OR, 'Please indicate your phone number')

			->field('landline_number')
			->field('mobile_number')

		->breakRule();


if( ! $validator->run($data))
	print_r($validator->getErrors());
