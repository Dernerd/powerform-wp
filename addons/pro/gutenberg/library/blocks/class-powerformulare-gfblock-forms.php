<?php

/**
 * Class Powerform_GFBlock_Forms
 *
 * @since 1.0 Gutenber Addon
 */
class Powerform_GFBlock_Forms extends Powerform_GFBlock_Abstract {

	/**
	 * @var self|null
	 */
	private static $_instance = null;

	/**
	 * Block identifier
	 *
	 * @since 1.0 Gutenber Addon
	 *
	 * @var string
	 */
	protected $_slug = 'forms';

	/**
	 * Get Instance
	 *
	 * @since 1.0 Gutenberg Addon
	 * @return self|null
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Powerform_GFBlock_Forms constructor.
	 *
	 * @since 1.0 Gutenberg Addon
	 */
	public function __construct() {
		// Initialize block
		$this->init();
	}

	/**
	 * Render block markup on front-end
	 *
	 * @since 1.0 Gutenberg Addon
	 * @param array $properties Block properties
	 *
	 * @return string
	 */
	public function render_block( $properties = array() ) {
		return '';
	}

	/**
	 * Preview form markup in block
	 *
	 * @since 1.0 Gutenberg Addon
	 * @param array $properties Block properties
	 *
	 * @return string
	 */
	public function preview_block( $properties = array() ) {
		if ( isset( $properties['module_id'] ) ) {
			$html = powerform_form( $properties['module_id'], true, false );

			return $html;
		}

		return false;
	}

	/**
	 * Enqueue assets ( scritps / styles )
	 * Should be overriden in block class
	 *
	 * @since 1.0 Gutenberg Addon
	 */
	public function load_assets() {
		// Scripts
		wp_enqueue_script(
			'powerform-block-forms',
			powerform_gutenberg()->get_plugin_url() . '/js/forms-block.min.js',
			array( 'wp-blocks', 'wp-i18n', 'wp-element' ),
			filemtime( powerform_gutenberg()->get_plugin_dir() . 'js/forms-block.min.js' ),
			false
		);

		// Localize scripts
		wp_localize_script(
			'powerform-block-forms',
			'frmnt_form_data',
			array(
				'forms'     => $this->get_forms(),
				'admin_url' => admin_url( 'admin.php' ),
				'l10n'      => $this->localize(),
			)
		);

		powerform_print_forms_admin_styles( POWERFORM_VERSION );
		powerform_print_front_scripts( POWERFORM_VERSION );

		wp_enqueue_script(
			'select2-powerform',
			powerform_plugin_url() . 'assets/js/library/select2.full.min.js',
			array( 'jquery' ),
			POWERFORM_VERSION,
			false
		);

		wp_enqueue_script(
			'powerform-jquery-validate',
			powerform_plugin_url() . 'assets/js/library/jquery.validate.min.js',
			array( 'jquery' ),
			POWERFORM_VERSION,
			false
		);

		wp_enqueue_script(
			'powerform-front-scripts',
			powerform_plugin_url() . 'build/front/front.multi.min.js',
			array( 'jquery', 'select2-powerform', 'powerform-jquery-validate' ),
			POWERFORM_VERSION,
			false
		);

		wp_enqueue_script( 'jquery-ui-datepicker' );
		$style_src     = powerform_plugin_url() . 'assets/css/intlTelInput.min.css';
		$style_version = '4.0.3';

		$script_src     = powerform_plugin_url() . 'assets/js/library/intlTelInput.min.js';
		$script_version = POWERFORM_VERSION;
		wp_enqueue_style( 'intlTelInput-powerform-css', $style_src, array(), $style_version ); // intlTelInput
		wp_enqueue_script( 'powerform-intlTelInput', $script_src, array( 'jquery' ), $script_version, false ); // intlTelInput

		wp_localize_script( 'powerform-front-scripts', 'PowerformFront', powerform_localize_data() );
	}

	/**
	 * Return forms IDs and Names
	 *
	 * @since 1.0 Gutenberg Addon
	 * @return array
	 */
	public function get_forms() {
		$forms     = Powerform_API::get_forms( null, 1, 100, Powerform_Custom_Form_Model::STATUS_PUBLISH );
		$form_list = array(
			array(
				'value' => '',
				'label' => esc_html__( 'Select a form', Powerform::DOMAIN ),
			),
		);

		if ( is_array( $forms ) ) {
			foreach ( $forms as $form ) {
				$form_name = $form->name;

				if ( isset( $form->settings['form-type'] ) && 'leads' === $form->settings['form-type'] ) {
					continue;
				}

				if ( isset( $form->settings['formName'] ) && ! empty( $form->settings['formName'] ) ) {
					$form_name = $form->settings['formName'];
				}

				$form_list[] = array(
					'value' => $form->id,
					'label' => $form_name,
				);
			}
		}

		return $form_list;
	}

	public function localize() {
		return array(
			'choose_form'      => esc_html__( 'Choose Form', Powerform::DOMAIN ),
			'customize_form'   => esc_html__( 'Customize form', Powerform::DOMAIN ),
			'rendering'        => esc_html__( 'Rendering...', Powerform::DOMAIN ),
			'form'             => esc_html__( 'Form', Powerform::DOMAIN ),
			'form_description' => esc_html__( 'Embed and display your custom Powerform forms in this block', Powerform::DOMAIN ),
		);
	}
}

new Powerform_GFBlock_Forms();
