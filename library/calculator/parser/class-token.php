<?php

/**
 * Class Powerform_Calculator_Token
 *
 */
class Powerform_Calculator_Parser_Token {

	const TYPE_WORD   = 1;
	const TYPE_CHAR   = 2;
	const TYPE_NUMBER = 3;

	/**
	 * @var int
	 */
	public $type;

	/**
	 * @var string|int|float
	 */
	public $value;

	/**
	 * @var int
	 */
	public $position;

	public function __construct( $type, $value, $position ) {
		$this->type     = $type;
		$this->value    = $value;
		$this->position = $position;
	}
}
