<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Custom
 * @since 1.0
 */
class Powerform_Custom extends Powerform_Field {

	/**
	* @var string
	*/
	public $name = '';

	/**
	* @var string
	*/
	public $slug = 'custom';

	/**
	 * @var string
	 */
	public $type = 'custom';

	/**
	 * @var array
	 */
	public $options = array();

	/**
	* @var string
	*/
	//public $category = 'posts';
	//Disable for now until we know what to do with this

	/**
	 * Powerform_Custom constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		parent::__construct();

		$this->name = __( 'Benutzerdefinierte Feld', Powerform::DOMAIN );
	}

	/**
	 * @param array $settings
	 *
	 * @return array
	 */
	public function load_settings( $settings = array() ) {
		return array(
			array(
				'id'         => 'required',
				'type'       => 'Toggle',
				'name'       => 'required',
				'className'  => 'required-field',
				'hide_label' => true,
				'values'     => array(
					array(
						'value'      => 'true',
						'label'      => __( 'Erforderlich', Powerform::DOMAIN ),
						'labelSmall' => 'true',
					),
				),
			),

			array(
				'id'         => 'separator-1',
				'type'       => 'Separator',
				'hide_label' => true,
			),

			array(
				'id'         => 'field-label',
				'type'       => 'Text',
				'name'       => 'field_label',
				'hide_label' => false,
				'label'      => __( 'Feldbezeichnung', Powerform::DOMAIN ),
				'className'  => 'text-field',
			),

			array(
				'id'           => 'field-type',
				'type'         => 'Select',
				'name'         => 'field_type',
				'className'    => 'select-field',
				'label_hidden' => false,
				'label'        => __( 'Feldtyp', Powerform::DOMAIN ),
				'values'       => array(
					array(
						'value' => 'text',
						'label' => __( 'Einzeiliger Text', Powerform::DOMAIN ),
					),
					array(
						'value' => 'textarea',
						'label' => __( 'Mehrzeiliger Text', Powerform::DOMAIN ),
					),
					array(
						'value' => 'dropdown',
						'label' => __( 'Dropdown', Powerform::DOMAIN ),
					),
					array(
						'value' => 'multiselect',
						'label' => __( 'Mehrfachauswahl', Powerform::DOMAIN ),
					),
					array(
						'value' => 'number',
						'label' => __( 'Nummer', Powerform::DOMAIN ),
					),
					array(
						'value' => 'checkbox',
						'label' => __( 'Kontrollkästchen', Powerform::DOMAIN ),
					),
					array(
						'value' => 'radio',
						'label' => __( 'Auswahl Schaltflächen', Powerform::DOMAIN ),
					),
					array(
						'value' => 'hidden',
						'label' => __( 'Versteckt', Powerform::DOMAIN ),
					),
				),
			),

			array(
				'id'             => 'custom-field-name',
				'type'           => 'RadioContainer',
				'name'           => 'custom_field_name',
				'className'      => 'custom-field-name-field',
				'containerClass' => 'psource-is_gray',
				'label'          => __( 'Benutzerdefinierter Feldname', Powerform::DOMAIN ),
				'values'         => array(
					array(
						'value' => 'existing',
						'label' => __( 'Vorhandenes Feld', Powerform::DOMAIN ),
					),
					array(
						'value' => 'new',
						'label' => __( 'Neues Feld', Powerform::DOMAIN ),
					),
				),
				'fields'         => array(
					array(
						'id'        => 'existing-field',
						'type'      => 'Select',
						'name'      => 'existing_field',
						'className' => 'existing-field',
						'label'     => __( 'Wähle vorhandenes Feld', Powerform::DOMAIN ),
						'tab'       => 'existing',
						'values'    => array(),
					),
				),
			),
		);
	}

	/**
	 * Field defaults
	 *
	 * @since 1.0
	 * @return array
	 */
	public function defaults() {
		return array(
			'value_type'  => 'select',
			'field_label' => '',
		);
	}

	/**
	 * Field front-end markup
	 *
	 * @since 1.0
	 * @param $field
	 * @param $settings
	 *
	 * @return mixed
	 */
	public function markup( $field, $settings = array() ) {
		$required      = self::get_property( 'required', $field, false );
		$id            = self::get_property( 'element_id', $field );
		$name          = $id;
		$field_type    = self::get_property( 'field_type', $field );
		$placeholder   = esc_html( self::get_property( 'placeholder', $field ) );
		$description   = esc_html( self::get_property( 'description', $field ) );
		$label         = esc_html( self::get_property( 'field_label', $field ) );
		$id            = $id . '-field';
		$html          = '';
		$default_value = esc_html( self::get_property( 'default_value', $field ) );
		$post_value    = self::get_post_data( $name, false );

		switch ( $field_type ) {
			case 'text':
				$html .= sprintf(
					'<input class="powerform-name--field powerform-input" type="text" data-required="%s" name="%s" placeholder="%s" id="%s" %s/>',
					$required,
					$name,
					$placeholder,
					$id,
					( $post_value ? 'value= "' . $post_value . '"' : '' )
				);
				break;
			case 'textarea':
				$field_markup = array(
					'type'        => 'textarea',
					'class'       => 'powerform-textarea',
					'name'        => $name,
					'id'          => $id,
					'placeholder' => $placeholder,
					'required'    => $required,
				);
				$html        .= self::create_textarea( $field_markup, $label, $description );
				break;
			case 'dropdown':
				break;
			case 'multiselect':
				break;
			case 'number':
				$html .= sprintf(
					'<input class="powerform-number--field powerform-input" type="number" data-required="%s" name="%s" placeholder="%s" value="%s" id="%s" />',
					$required,
					$name,
					$placeholder,
					( $post_value ? $post_value : $default_value ),
					$id
				);
				break;
			case 'checkbox':
				break;
			case 'radio':
				break;
			case 'hidden':
				$html .= sprintf( '<input class="powerform-hidden--field" type="hidden" id="%s" name="%s" value="%s" />', $id, $name, $default_value );
				break;
			default:
				break;
		}

		return apply_filters( 'powerform_field_custom_markup', $html, $id, $required, $field_type, $placeholder );
	}

	/**
	 * Field back-end validation
	 *
	 * @since 1.0
	 * @param array        $field
	 * @param array|string $data
	 * @param array        $post_data
	 */
	public function validate( $field, $data, $post_data = array() ) {
		if ( $this->is_required( $field ) ) {
			$id   = self::get_property( 'element_id', $field );
			$name = self::get_property( 'custom_field_name', $field, __( 'field name', Powerform::DOMAIN ) );
			if ( empty( $data ) ) {
				/* translators: ... */
				$this->validation_message[ $id ] = sprintf( __( 'Dieses Feld wird benötigt. Bitte gib die %s ein.', Powerform::DOMAIN ), $name );
			}
		}
	}

	/**
	 * Sanitize data
	 *
	 * @since 1.0.2
	 *
	 * @param array $field
	 * @param array|string $data - the data to be sanitized
	 *
	 * @return array|string $data - the data after sanitization
	 */
	public function sanitize( $field, $data ) {
		return $data;
	}
}
