<?php

/**
 * PHP max() function. Expects at least one parameter.
 * Example: "max(1,2,3)" => 3, "max(1,-1)" => 1, "max(0,0)" => 0, "max(2)" => 2
 *
 * @see http://php.net/manual/en/ref.math.php
 */
class Powerform_Calculator_Symbol_Function_Max extends Powerform_Calculator_Symbol_Function_Abstract {

	/**
	 * @inheritdoc
	 */
	protected $identifiers = array( 'max' );

	/**
	 * @inheritdoc
	 * @throws Powerform_Calculator_Exception
	 */
	public function execute( $arguments ) {
		if ( count( $arguments ) < 1 ) {
			throw new Powerform_Calculator_Exception( 'Error: Expected one argument, got ' . count( $arguments ) );
		}

		$max = max( $arguments );

		return $max;
	}

}
