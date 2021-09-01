<?php

/**
 * The parsers has one important method: parse()
 * It takes an array of tokens as input and
 * returns an array of nodes as output.
 * These nodes are the syntax tree of the term.
 *
 */
class Powerform_Calculator_Parser {

	/**
	 * The symbol container with all possible symbols
	 *
	 * @var Powerform_Calculator_Symbol_Loader
	 */
	protected $symbol_loader;

	/**
	 * Parser constructor.
	 *
	 * @param Powerform_Calculator_Symbol_Loader $symbol_loader
	 */
	public function __construct( $symbol_loader ) {
		$this->symbol_loader = $symbol_loader;
	}

	/**
	 * Parses an array with tokens. Returns an array of nodes.
	 * These nodes define a syntax tree.
	 *
	 * @param Powerform_Calculator_Parser_Token[] $tokens
	 *
	 * @return Powerform_Calculator_Parser_Node_Container
	 * @throws Powerform_Calculator_Exception
	 */
	public function parse( $tokens ) {
		$symbol_nodes = $this->detect_symbols( $tokens );

		$nodes = $this->create_tree_by_brackets( $symbol_nodes );

		$nodes = $this->transform_tree_by_functions( $nodes );

		$this->check_grammar( $nodes );

		// Wrap the nodes in an array node.
		$root_node = new Powerform_Calculator_Parser_Node_Container( $nodes );

		return $root_node;
	}

	/**
	 * Creates a flat array of symbol nodes from tokens.
	 *
	 * @param Powerform_Calculator_Parser_Token[] $tokens
	 *
	 * @return Powerform_Calculator_Parser_Node_Symbol[]
	 * @throws Powerform_Calculator_Exception
	 */
	protected function detect_symbols( $tokens ) {
		$symbol_nodes = array();

		$expecting_opening_bracket = false; // True if we expect an opening bracket (after a function name)
		$open_bracket_counter      = 0;

		foreach ( $tokens as $token ) {
			$type = $token->type;

			if ( Powerform_Calculator_Parser_Token::TYPE_WORD === $type ) {
				$identifier = $token->value;
				$symbol     = $this->symbol_loader->find( $identifier );

				if ( null === $symbol ) {
					throw new Powerform_Calculator_Exception( 'Error: Detected unknown or invalid string identifier: ' . $identifier . '.' );
				}
			} elseif ( Powerform_Calculator_Parser_Token::TYPE_NUMBER === $type ) {
				// Notice: Numbers do not have an identifier
				$symbol_numbers = $this->symbol_loader->find_sub_types( 'Powerform_Calculator_Symbol_Number' );
				if ( empty( $symbol_numbers ) || ! is_array( $symbol_numbers ) ) {
					throw new Powerform_Calculator_Exception( 'Error: Unavailable number symbol processor.' );// @codeCoverageIgnore
				}

				$symbol = $symbol_numbers[0];
			} else { // Type Token::TYPE_CHARACTER:
				$identifier = $token->value;
				$symbol     = $this->symbol_loader->find( $identifier );

				if ( null === $symbol ) {
					throw new Powerform_Calculator_Exception( 'Error: Detected unknown or invalid string identifier: ' . $identifier . '.' );
				}

				if ( $symbol instanceof Powerform_Calculator_Symbol_Opening_Bracket ) {
					$open_bracket_counter ++;
				}
				if ( $symbol instanceof Powerform_Calculator_Symbol_Closing_Bracket ) {
					$open_bracket_counter --;

					// Make sure there are not too many closing brackets
					if ( $open_bracket_counter < 0 ) {
						throw new Powerform_Calculator_Exception( 'Error: Found closing bracket that does not have an opening bracket.' );
					}
				}
			}

			// Make sure a function is not followed by a symbol that is not of type opening bracket
			if ( $expecting_opening_bracket ) {
				if ( ! $symbol instanceof Powerform_Calculator_Symbol_Opening_Bracket ) {
					throw new Powerform_Calculator_Exception( 'Error: Expected opening bracket (after a function) but got something else.' );
				}

				$expecting_opening_bracket = false;
			} else {
				if ( $symbol instanceof Powerform_Calculator_Symbol_Function_Abstract ) {
					$expecting_opening_bracket = true;
				}
			}

			$symbol_node = new Powerform_Calculator_Parser_Node_Symbol( $token, $symbol );

			$symbol_nodes[] = $symbol_node;
		}

		// Make sure the term does not end with the name of a function but without an opening bracket
		if ( $expecting_opening_bracket ) {
			throw new Powerform_Calculator_Exception( 'Error: Expected opening bracket (after a function) but reached the end of the term' );
		}

		// Make sure there are not too many opening brackets
		if ( $open_bracket_counter > 0 ) {
			throw new Powerform_Calculator_Exception( 'Error: There is at least one opening bracket that does not have a closing bracket' );
		}

		return $symbol_nodes;
	}

	/**
	 * Expects a flat array of symbol nodes and (if possible) transforms
	 * it to a tree of nodes. Cares for brackets.
	 * Attention: Expects valid brackets!
	 * Check the brackets before you call this method.
	 *
	 * @param Powerform_Calculator_Parser_Node_Symbol[] $symbol_nodes
	 *
	 * @return Powerform_Calculator_Parser_Node_Abstract[]
	 * @throws Powerform_Calculator_Exception
	 */
	protected function create_tree_by_brackets( $symbol_nodes ) {
		$tree                 = array();
		$nodes_in_brackets    = array(); // AbstractSymbol nodes inside level-0-brackets
		$open_bracket_counter = 0;

		foreach ( $symbol_nodes as $index => $symbol_node ) {
			if ( ! $symbol_node instanceof Powerform_Calculator_Parser_Node_Symbol ) {
				throw new Powerform_Calculator_Exception( 'Error: Expected symbol node, but got "' . gettype( $symbol_node ) . '"' );// @codeCoverageIgnore
			}

			if ( $symbol_node->get_symbol() instanceof Powerform_Calculator_Symbol_Opening_Bracket ) {
				$open_bracket_counter ++;

				if ( $open_bracket_counter > 1 ) {
					$nodes_in_brackets[] = $symbol_node;
				}
			} elseif ( $symbol_node->get_symbol() instanceof Powerform_Calculator_Symbol_Closing_Bracket ) {
				$open_bracket_counter --;

				// Found a closing bracket on level 0
				if ( 0 === $open_bracket_counter ) {
					$sub_tree = $this->create_tree_by_brackets( $nodes_in_brackets );

					// Subtree can be empty for example if the term looks like this: "()" or "functioname()"
					// But this is okay, we need to allow this so we can call functions without a parameter
					$tree[]            = new Powerform_Calculator_Parser_Node_Container( $sub_tree );
					$nodes_in_brackets = array();
				} else {
					$nodes_in_brackets[] = $symbol_node;
				}
			} else {
				if ( 0 === $open_bracket_counter ) {
					$tree[] = $symbol_node;
				} else {
					$nodes_in_brackets[] = $symbol_node;
				}
			}
		}

		return $tree;
	}

	/**
	 * Replaces [a SymbolNode that has a symbol of type AbstractFunction,
	 * followed by a node of type ContainerNode] by a FunctionNode.
	 * Expects the $nodes not including any function nodes (yet).
	 *
	 * @param Powerform_Calculator_Parser_Node_Abstract[] $nodes
	 *
	 * @return Powerform_Calculator_Parser_Node_Abstract[]
	 * @throws Powerform_Calculator_Exception
	 */
	protected function transform_tree_by_functions( $nodes ) {
		$transformed_nodes = array();

		$function_symbol_node = null;

		foreach ( $nodes as $node ) {
			if ( $node instanceof Powerform_Calculator_Parser_Node_Container ) {
				/** @var Powerform_Calculator_Parser_Node_Container $node */
				$transformed_child_nodes = $this->transform_tree_by_functions( $node->get_child_nodes() );

				if ( null !== $function_symbol_node ) {
					$function_node        = new Powerform_Calculator_Parser_Node_Function( $transformed_child_nodes, $function_symbol_node );
					$transformed_nodes[]  = $function_node;
					$function_symbol_node = null;
				} else {

					// not a function
					$node->set_child_nodes( $transformed_child_nodes );
					$transformed_nodes[] = $node;
				}
			} elseif ( $node instanceof Powerform_Calculator_Parser_Node_Symbol ) {
				/** @var Powerform_Calculator_Parser_Node_Symbol $node */
				$symbol = $node->get_symbol();
				if ( $symbol instanceof Powerform_Calculator_Symbol_Function_Abstract ) {
					$function_symbol_node = $node;
				} else {
					$transformed_nodes[] = $node;
				}
			} else {
				throw new Powerform_Calculator_Exception( 'Error: Expected array node or symbol node, got "' . gettype( $node ) . '"' );
			}
		}

		return $transformed_nodes;
	}

	/**
	 * Ensures the tree follows the grammar rules for terms
	 *
	 * @param array $nodes
	 *
	 * @return void
	 * @throws Powerform_Calculator_Exception
	 */
	protected function check_grammar( $nodes ) {
		// TODO Make sure that separators are only in the child nodes of the array node of a function node
		// (If this happens the calculator will throw an exception)

		foreach ( $nodes as $index => $node ) {
			if ( $node instanceof Powerform_Calculator_Parser_Node_Symbol ) {
				/** @var $node Powerform_Calculator_Parser_Node_Symbol */

				$symbol = $node->get_symbol();

				if ( $symbol instanceof Powerform_Calculator_Symbol_Operator_Abstract ) {
					/** @var $symbol Powerform_Calculator_Symbol_Operator_Abstract */

					$pos_of_right_operand = $index + 1;

					// Make sure the operator is positioned left of a (potential) operand (=prefix notation).
					// Example term: "-1"
					if ( $pos_of_right_operand >= count( $nodes ) ) {
						throw new Powerform_Calculator_Exception( 'Error: Found operator that does not stand before an operand.' );
					}

					$pos_of_left_operand = $index - 1;

					$left_operand = null;

					// Operator is unary if positioned at the beginning of a term
					if ( $pos_of_left_operand >= 0 ) {
						$left_operand = $nodes[ $pos_of_left_operand ];

						if ( $left_operand instanceof Powerform_Calculator_Parser_Node_Symbol ) {
							/** @var $left_operand Powerform_Calculator_Parser_Node_Symbol */
							if ( $left_operand->get_symbol() instanceof Powerform_Calculator_Symbol_Operator_Abstract  // example 1`+-`5 : + = operator, - = unary
								|| $left_operand->get_symbol() instanceof Powerform_Calculator_Symbol_Separator // example func(1`,-`5) ,= separator, - = unary
							) {
								// Operator is unary if positioned right to another operator
								$left_operand = null;
							}
						}
					}

					// If null, the operator is unary
					if ( null === $left_operand ) {
						if ( ! $symbol->get_operates_unary() ) {
							throw new Powerform_Calculator_Exception( 'Error: Found operator in unary notation that is not unary.' );
						}

						// Remember that this node represents a unary operator
						$node->set_is_unary_operator( true );
					} else {
						if ( ! $symbol->get_operates_binary() ) {
							throw new Powerform_Calculator_Exception( 'Error: Found operator in binary notation that is not binary.' );
						}
					}
				}
			} else {
				/** @var $node Powerform_Calculator_Parser_Node_Container */
				$this->check_grammar( $node->get_child_nodes() );
			}
		}
	}

}
