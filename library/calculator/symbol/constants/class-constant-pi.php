<?php

/**
 * PHP M_PI constant
 * Value: 3.14...
 *
 * @see http://php.net/manual/en/math.constants.php
 */
class Powerform_Calculator_Symbol_Constant_Pi extends Powerform_Calculator_Symbol_Constant_Abstract {

	/**
	 * @inheritdoc
	 */
	protected $identifiers = array( 'pi' );

	/**
	 * @inheritdoc
	 */
	protected $value = M_PI;

}
