<?php

/**
 * PHP floor() function aka round fractions down.
 * Expects one parameter.
 *
 * @see http://php.net/manual/en/ref.math.php
 */
class Powerform_Calculator_Symbol_Function_Floor extends Powerform_Calculator_Symbol_Function_Abstract {

	/**
	 * @inheritdoc
	 */
	protected $identifiers = array( 'floor' );

	/**
	 * @inheritdoc
	 * @throws Powerform_Calculator_Exception
	 */
	public function execute( $arguments ) {
		if ( 1 !== count( $arguments ) ) {
			throw new Powerform_Calculator_Exception( 'Error: Expected one argument, got ' . count( $arguments ) );
		}

		$number = $arguments[0];

		return floor( $number );
	}

}
