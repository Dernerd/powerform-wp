<?php

/**
 * Always positive (abs)
 * Always round up (ceil)
 * Arguments already in unix timestamp
 *
 * @see http://php.net/manual/en/function.abs.php
 * @see http://php.net/manual/en/function.ceil.php
 */
class Powerform_Calculator_Symbol_Function_Minutes_Between extends Powerform_Calculator_Symbol_Function_Abstract {

	/**
	 * @inheritdoc
	 */
	protected $identifiers = array( 'minutesBetween' );

	/**
	 * @inheritdoc
	 * @throws Powerform_Calculator_Exception
	 */
	public function execute( $arguments ) {
		if ( count( $arguments ) !== 2 ) {
			throw new Powerform_Calculator_Exception( 'Error: Expected two argument, got ' . count( $arguments ) );
		}

		$between = $arguments[0] - $arguments[1];
		$between = abs( $between );

		$minutes_between = $between / MINUTE_IN_SECONDS;

		return ceil( $minutes_between );

	}

}
