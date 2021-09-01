<?php

/**
 * Operator for mathematical multiplication.
 * Example: "2*3" => 6
 *
 * @see     https://en.wikipedia.org/wiki/Multiplication
 *
 */
class Powerform_Calculator_Symbol_Operator_Multiplication extends Powerform_Calculator_Symbol_Operator_Abstract {

	/**
	 * @inheritdoc
	 */
	protected $identifiers = array( '*' );

	/**
	 * @inheritdoc
	 */
	protected $precedence = 200;

	/**
	 * @inheritdoc
	 */
	public function operate( $left_number, $right_number ) {
		return $left_number * $right_number;
	}

}
