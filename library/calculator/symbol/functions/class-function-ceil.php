<?php

/**
 * PHP ceil() function aka round fractions up.
 * Expects one parameter.
 *
 * @see http://php.net/manual/en/ref.math.php
 */
class Powerform_Calculator_Symbol_Function_Ceil extends Powerform_Calculator_Symbol_Function_Abstract {

	/**
	 * @inheritdoc
	 */
	protected $identifiers = array( 'ceil' );

	/**
	 * @inheritdoc
	 * @throws Powerform_Calculator_Exception
	 */
	public function execute( $arguments ) {
		if ( 1 !== count( $arguments ) ) {
			throw new Powerform_Calculator_Exception( 'Error: Expected one argument, got ' . count( $arguments ) );
		}

		$number = $arguments[0];

		return ceil( $number );
	}

}
