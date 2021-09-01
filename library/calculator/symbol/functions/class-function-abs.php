<?php

/**
 * PHP abs() function. Expects one parameter.
 * Example: "abs(2)" => 2, "abs(-2)" => 2, "abs(0)" => 0
 *
 * @see http://php.net/manual/en/ref.math.php
 */
class Powerform_Calculator_Symbol_Function_Abs extends Powerform_Calculator_Symbol_Function_Abstract {

	/**
	 * @inheritdoc
	 */
	protected $identifiers = array( 'abs' );

	/**
	 * @inheritdoc
	 * @throws Powerform_Calculator_Exception
	 */
	public function execute( $arguments ) {
		if ( count( $arguments ) !== 1 ) {
			throw new Powerform_Calculator_Exception( 'Error: Expected one argument, got ' . count( $arguments ) );
		}

		$number = $arguments[0];

		return abs( $number );
	}

}
