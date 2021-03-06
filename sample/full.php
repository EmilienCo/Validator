<?php

/**
 * This sample file showcases most of the features of Validator.
 */

require_once __DIR__.'/../bootstrap.php';

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

\Validator\i18n::setLanguage('en'); // Not required as english is the default language

$validator	=	new Validator;

$validator
		->globalRule(new \Validation\Required())

			->globalRule(new \Validation\LengthGreaterThan(3))

				->field('firstname')
				->field('lastname')

				->field('username')
					->rule('User::isUsernameTaken')

			->endGlobalRule()

			->field('email')
				->rule(new \Validation\Email)

			->field('dob')
				->rule(new \Validation\Date)

			->field('agreement')
				->rule(function($value)
				{
					if($value !== 'I AGREE')
						throw new Exception('Please write “I AGREE” if you agree with the rules');
				})

			->field('age')
				->rule('ctype_digit')

		->endGlobalRule()

		->globalRule(new \Validation\Required, Validator::OPERATOR_OR, 'Please indicate your phone number')
			->field('landline_number')
			->field('mobile_number')
		->endGlobalRule()
						
		->field('fake')
			->error('This is a forced error message')

		->globalError('And this is a forced global error message');

if( ! $validator->run($data))
	print_r($validator->getErrors());