<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Calculation
 *
 * @since 1.7
 */
class Powerform_Calculation extends Powerform_Field {

	/**
	 * @var string
	 */
	public $name = '';

	/**
	 * @var string
	 */
	public $slug = 'calculation';

	/**
	 * @var string
	 */
	public $type = 'calculation';

	/**
	 * @var int
	 */
	public $position = 11;

	/**
	 * @var array
	 */
	public $options = array();

	/**
	 * @var string
	 */
	public $category = 'standard';

	/**
	 * @var bool
	 */
	public $is_input = false;

	/**
	 * @var bool
	 */
	public $has_counter = false;

	/**
	 * @var string
	 */
	public $icon = 'sui-icon-calculator';

	public $is_calculable = true;

	/**
	 * Powerform_Text constructor.
	 *
	 * @since 1.7
	 */
	public function __construct() {
		parent::__construct();

		$this->name = __( 'Berechnungen', Powerform::DOMAIN );
	}

	/**
	 * Field defaults
	 *
	 * @since 1.7
	 * @return array
	 */
	public function defaults() {
		return array(
			'field_label' => __( 'Berechnungen', Powerform::DOMAIN ),
			'placeholder' => __( 'Z.B. Berechneter Wert', Powerform::DOMAIN ),
		);
	}

	/**
	 * Field front-end markup
	 *
	 * @since 1.7
	 *
	 * @param $field
	 * @param $settings
	 *
	 * @return mixed
	 */
	public function markup( $field, $settings = array() ) {

		$this->field         = $field;
		$this->form_settings = $settings;

		$this->init_autofill( $settings );

		$html        = '';
		$wrapper     = array();
		$id          = self::get_property( 'element_id', $field );
		$name        = $id;
		$id          = $id . '-field';
		$required    = self::get_property( 'required', $field, false );
		$placeholder = $this->sanitize_value( self::get_property( 'placeholder', $field ) );
		$value       = esc_html( self::get_post_data( $name, self::get_property( 'default_value', $field ) ) );
		$label       = esc_html( self::get_property( 'field_label', $field, '' ) );
		$description = esc_html( self::get_property( 'description', $field, '' ) );
		$design      = $this->get_form_style( $settings );
		$formula     = self::get_property( 'formula', $field, '', 'str' );
		$is_hidden   = self::get_property( 'hidden', $field, false, 'bool' );
		$suffix      = self::get_property( 'suffix', $field );
		$prefix      = self::get_property( 'prefix', $field );
		$precision   = $this->get_calculable_precision( array(), $field );

		$number_attr = array(
			'type'            => 'number',
			'name'            => $name,
			'value'           => $value,
			'placeholder'     => $placeholder,
			'id'              => $id,
			'class'           => 'powerform-calculation',
			'data-formula'    => $formula,
			'data-required'   => $required,
			'data-precision'  => $precision,
			'data-is-hidden'  => $is_hidden,
			'disabled'        => 'disabled', // mark as disabled so this value won't send to backend later
		);

		if ( empty( $prefix ) && empty( $suffix ) ) {
			$number_attr['class'] .= ' powerform-input';
		}

		if ( ! empty( $prefix ) || ! empty( $suffix ) ) {
			$wrapper = array(
				'<div class="powerform-input powerform-input-with-prefix">',
				sprintf( '<span class="powerform-suffix">%s</span></div>', $suffix ),
				'',
				$prefix,
			);
		}

		$html .= '<div class="powerform-field">';

			$html .= self::create_input(
				$number_attr,
				$label,
				$description,
				$required,
				$design,
				$wrapper
			);

		$html .= '</div>';

		return apply_filters( 'powerform_field_calculation_markup', $html, $id, $required, $placeholder, $value );
	}

	/**
	 * Return field inline validation rules
	 *
	 * @since 1.7
	 * @return string
	 */
	public function get_validation_rules() {
		return '';
	}

	/**
	 * Return field inline validation errors
	 *
	 * @since 1.7
	 * @return string
	 */
	public function get_validation_messages() {
		return '';
	}

	/**
	 * Sanitize data
	 *
	 * @since 1.7
	 *
	 * @param array        $field
	 * @param array|string $data - the data to be sanitized
	 *
	 * @return array|string $data - the data after sanitization
	 */
	public function sanitize( $field, $data ) {
		// Sanitize
		$data = powerform_sanitize_field( $data );

		return apply_filters( 'powerform_field_calculation_sanitize', $data, $field );
	}

	/**
	 * @since 1.7
	 * @inheritdoc
	 */
	public function get_calculable_value( $submitted_data, $field_settings ) {
		$formula = self::get_property( 'formula', $field_settings, '', 'str' );

		/**
		 * Filter formula being used on calculable value of calculation field
		 *
		 * @since 1.7
		 *
		 * @param string $formula
		 * @param array  $submitted_data
		 * @param array  $field_settings
		 *
		 * @return string|int|float formula, or hardcoded value
		 */
		$formula = apply_filters( 'powerform_field_calculation_calculable_value', $formula, $submitted_data, $field_settings );

		if ( empty( $formula ) ) {
			return 0.0;
		}

		return $formula;
	}

	/**
	 *
	 * @since 1.7
	 * @inheritdoc
	 */
	public function get_calculable_precision( $submitted_data, $field_settings ) {
		$precision = self::get_property( 'precision', $field_settings, 2, 'num' );

		/**
		 * Filter precision being used on calculable value
		 *
		 * @since 1.7
		 *
		 * @param int|float $precision
		 * @param array     $submitted_data
		 * @param array     $field_settings
		 *
		 * @return int|float number precision casted into integer later
		 */
		$precision = apply_filters( 'powerform_field_calculation_calculable_precision', $precision, $submitted_data, $field_settings );

		$precision = (int) $precision;

		return $precision;
	}

	/**
	 * Get default error message
	 *
	 * @since 1.7
	 *
	 * @return string
	 */
	public static function default_error_message() {
		$message = __( 'Feld konnte nicht berechnet werden.', Powerform::DOMAIN );

		/**
		 * Filter default error message
		 *
		 * @since 1.7
		 *
		 * @param string $message
		 *
		 * @return string
		 */
		$message = apply_filters( 'powerform_field_calculation_default_error_message', $message );

		return $message;
	}

	/**
	 * Get converted formula
	 * replace variable with submitted data
	 * expand nested calculation
	 *
	 * @since 1.7
	 *
	 * @param array                        $submitted_data
	 * @param array                        $field_settings
	 *
	 * @param Powerform_Custom_Form_Model $custom_form
	 *
	 * @return string
	 */
	public function get_converted_formula( $submitted_data, $field_settings, $custom_form ) {
		$formula           = $this->get_calculable_value( $submitted_data, $field_settings );
		$converted_formula = powerform_calculator_maybe_replace_fields_on_formula( $formula, $submitted_data, $custom_form );

		/**
		 * Filter converted formula from calculation field
		 *
		 * @since 1.7
		 *
		 * @param string                       $converted_formula
		 * @param array                        $field_settings
		 * @param array                        $submitted_data
		 * @param Powerform_Custom_Form_Model $custom_form
		 */
		$converted_formula = apply_filters( 'powerform_field_calculation_converted_formula', $converted_formula, $field_settings, $submitted_data, $custom_form );

		return $converted_formula;
	}

	/**
	 * Get calculated value
	 *
	 * @since 1.7
	 *
	 * @param string $converted_formula
	 * @param array  $submitted_data
	 * @param array  $field_settings
	 *
	 * @return double
	 * @throws Powerform_Calculator_Exception
	 */
	public function get_calculated_value( $converted_formula, $submitted_data, $field_settings ) {
		$precision = $this->get_calculable_precision( $submitted_data, $field_settings );

		$calculator = new Powerform_Calculator( $converted_formula );
		$calculator->set_is_throwable( true );

		$result = $calculator->calculate();

		$result = floatval( $result );
		$result = round( $result, $precision );

		/**
		 * Filter Calculated value of calculation field
		 *
		 * @since 1.7
		 *
		 * @param double $result
		 * @param string $converted_formula
		 * @param array  $submitted_data
		 * @param array  $field_settings
		 */
		$result = apply_filters( 'powerform_field_calculation_calculated_value', $result, $converted_formula, $submitted_data, $field_settings );

		return $result;
	}
}
