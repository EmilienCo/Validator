<?php

/**
 * Validates a boolean value.
 * 
 * Can be: true / false / 1 / 0 / "1" / "0" / ""
 */

class Validation_Boolean extends Validation_Abstract
{
	protected static $_boolean_values	=	[true, false, '1', '0', 1, 0, '', 'true', 'false'];

	public function check($value)
	{
		if( ! in_array($value, self::$_boolean_values, true))
			throw new Exception(Lib::i18n()->error_validation_boolean);
	}
}