<?php
/**
 * Conditionally load assets class
 *
 * @since 1.11
 */
class Powerform_Assets_Enqueue_Form extends Powerform_Assets_Enqueue {
	/**
	 * Load scripts and styles on front-end
	 *
	 * @since 1.11
	 */
	public function load_assets() {
		$this->enqueue_styles();
		$this->enqueue_scripts();
	}

	/**
	 * Enqueue form styles
	 *
	 * @since 1.11
	 */
	public function enqueue_styles() {

		$form_design   = $this->get_module_design();
		$form_settings = $this->get_settings();

		$has_phone_national      = $this->has_field_type_with_setting_value( 'phone', 'validation', 'standard' );
		$has_phone_international = $this->has_field_type_with_setting_value( 'phone', 'validation', 'international' );
		$has_phone_settings      = ( $has_phone_national || $has_phone_international );

		$has_address_country     = $this->has_field_type_with_setting_value( 'address', 'address_country', 'true' );

		$has_select_single       = $this->has_field_type_with_setting_value( 'select', 'value_type', 'single' );
		$has_select_multiple     = $this->has_field_type_with_setting_value( 'select', 'value_type', 'multiselect' );
		$has_select_search       = $this->has_field_type_with_setting_value( 'select', 'search_status', 'enable' );
		$has_select_settings     = ( $has_select_single && $has_select_search );

		$has_datepicker          = $this->has_field_type_with_setting_value( 'date', 'field_type', 'picker' );

		$has_timepicker          = $this->has_field_type( 'time' );

		$has_uploader            = $this->has_field_type( 'upload' );

		$has_post_feat_image     = $this->has_field_type_with_setting_value( 'postdata', 'post_image', true );
		$has_post_categories     = $this->has_field_type_with_setting_value( 'postdata', 'category', true );
		$has_post_tags           = $this->has_field_type_with_setting_value( 'postdata', 'post_tag', true );
		$has_multi_categories    = $this->has_field_type_with_setting_value( 'postdata', 'category_multiple', '1' );
		$has_multi_tags          = $this->has_field_type_with_setting_value( 'postdata', 'post_tag_multiple', '1' );

		$has_currency            = $this->has_field_type( 'currency' );
		$has_paypal              = $this->has_field_type( 'paypal' );
		$has_stripe              = $this->has_field_type( 'stripe' );

		$has_password            = $this->has_field_type( 'password' );

		$has_signature           = $this->has_field_type( 'signature' );

		// Powerform UI - Icons font.
		wp_enqueue_style(
			'powerform-icons',
			powerform_plugin_url() . 'assets/powerform-ui/css/powerform-icons.min.css',
			array(),
			POWERFORM_VERSION
		);

		// Powerform UI - Utilities.
		wp_enqueue_style(
			'powerform-utilities',
			powerform_plugin_url() . 'assets/powerform-ui/css/src/powerform-utilities.min.css',
			array(),
			POWERFORM_VERSION
		);

		// Powerform UI - Grid.
		if ( isset( $form_settings['fields-style'] ) && 'open' === $form_settings['fields-style'] ) {

			wp_enqueue_style(
				'powerform-grid-default',
				powerform_plugin_url() . 'assets/powerform-ui/css/src/grid/powerform-grid.open.min.css',
				array(),
				POWERFORM_VERSION
			);
		} else if ( isset( $form_settings['fields-style'] ) && 'enclosed' === $form_settings['fields-style'] ) {

			wp_enqueue_style(
				'powerform-grid-enclosed',
				powerform_plugin_url() . 'assets/powerform-ui/css/src/grid/powerform-grid.enclosed.min.css',
				array(),
				POWERFORM_VERSION
			);
		}

		// Powerform UI - Base stylesheet.
		if ( 'none' !== $form_design ) {

			wp_enqueue_style(
				'powerform-forms-' . $form_design . '-base',
				powerform_plugin_url() . 'assets/powerform-ui/css/src/form/powerform-form-' . $form_design . '.base.min.css',
				array(),
				POWERFORM_VERSION
			);

			// Powerform UI - Full stylesheet.
			if ( $has_phone_settings || $has_address_country || $has_select_multiple || $has_select_settings || $has_datepicker || $has_timepicker || $has_uploader || $has_post_feat_image || ( $has_post_categories && $has_multi_categories ) || ( $has_post_tags && $has_multi_tags ) || $has_currency || $has_paypal || $has_stripe || $has_signature ) {
				wp_enqueue_style(
					'powerform-forms-' . $form_design . '-full',
					powerform_plugin_url() . 'assets/powerform-ui/css/src/form/powerform-form-' . $form_design . '.full.min.css',
					array(),
					POWERFORM_VERSION
				);
			}

			// Powerform UI - Pagination stylesheet.
			if ( $this->has_field_type( 'page-break' ) ) {

				wp_enqueue_style(
					'powerform-forms-' . $form_design . '-pagination',
					powerform_plugin_url() . 'assets/powerform-ui/css/src/form/powerform-form-' . $form_design . '.pagination.min.css',
					array(),
					POWERFORM_VERSION
				);
			}
		}

		// Powerform UI - Select2 stylesheet.
		if ( $has_address_country || $has_select_settings ) {

			wp_enqueue_style(
				'powerform-select2',
				powerform_plugin_url() . 'assets/powerform-ui/css/src/form/select2.min.css',
				array(),
				POWERFORM_VERSION
			);
		}

		// Powerform UI - Authentication stylesheet.
		if ( $has_password ) {

			wp_enqueue_style(
				'powerform-authentication',
				powerform_plugin_url() . 'assets/powerform-ui/css/src/form/powerform-authentication.min.css',
				array(),
				POWERFORM_VERSION
			);
		}
	}

	/**
	 * Enqueue form scripts
	 *
	 * @since 1.11
	 */
	public function enqueue_scripts() {
		$has_select_single       = $this->has_field_type_with_setting_value( 'select', 'value_type', 'single' );
		$has_select_search       = $this->has_field_type_with_setting_value( 'select', 'search_status', 'enable' );
		$has_select_with_search  = ( $has_select_single && $has_select_search );
		$has_address_country     = $this->has_field_type_with_setting_value( 'address', 'address_country', 'true' );

		// Load form base scripts.
		$this->load_base_scripts();

		// FIELD: Phone.
		if ( $this->has_field_type( 'phone' ) ) {
			$this->load_phone_scripts();
		}

		// FIELD: Date picker.
		if ( $this->has_field_type( 'date' ) ) {
			$this->load_date_scripts();
		}

		if ( $has_address_country || $has_select_with_search ) {
			wp_enqueue_script(
				'powerform-select2',
				powerform_plugin_url() . 'assets/powerform-ui/js/select2.full.js',
				array( 'jquery' ),
				POWERFORM_VERSION,
				false
			);
		}

		// FIELD: calculation picker.
//		if ( $this->has_field_type( 'calculation' )
//		     || $this->has_field_type( 'currency' )
//		     || $this->has_field_type( 'number' ) ) {
//			$this->load_mask_scripts();
//		}

		// $this->get_module_design() returns the design
	}

	/**
	 * Load base from scripts
	 *
	 * @since 1.11
	 */
	public function load_base_scripts() {
		// LOAD: Powerform validation scripts
		wp_enqueue_script(
			'powerform-jquery-validate',
			powerform_plugin_url() . 'assets/js/library/jquery.validate.min.js',
			array( 'jquery' ),
			POWERFORM_VERSION,
			false
		);

		// LOAD: Powerform UI JS
		wp_enqueue_script(
			'powerform-form',
			powerform_plugin_url() . 'assets/powerform-ui/js/powerform-form.min.js',
			array( 'jquery' ),
			POWERFORM_VERSION,
			false
		);

		// LOAD: Powerform front scripts
		wp_enqueue_script(
			'powerform-front-scripts',
			powerform_plugin_url() . 'build/front/front.multi.min.js',
			array( 'jquery', 'powerform-form', 'powerform-jquery-validate' ),
			POWERFORM_VERSION,
			false
		);

		// Localize front script
		wp_localize_script( 'powerform-front-scripts', 'PowerformFront', powerform_localize_data() );
	}

	public function load_date_scripts() {
		global $wp_locale;

		wp_enqueue_script(
			'powerform-custom-form-moment',
			powerform_plugin_url() . 'assets/js/library/moment.min.js',
			array( 'jquery' ),
			'2.22.2',
			true
		);

		// load date picker scripts always
		wp_enqueue_script( 'jquery-ui-datepicker' );

		//localize Datepicker js
		$datepicker_date_format = str_replace(
			array(
				'd', 'j', 'l', 'z', // Day.
				'F', 'M', 'n', 'm', // Month.
				'Y', 'y'            // Year.
			),
			array(
				'dd', 'd', 'DD', 'o',
				'MM', 'M', 'm', 'mm',
				'yy', 'y'
			),
			get_option( 'date_format' )
		);

		$datepicker_data        = array(
			'monthNames'      => array_values( $wp_locale->month ),
			'monthNamesShort' => array_values( $wp_locale->month_abbrev ),
			'dayNames'        => array_values( $wp_locale->weekday ),
			'dayNamesShort'   => array_values( $wp_locale->weekday_abbrev ),
			'dayNamesMin'     => array_values( $wp_locale->weekday_initial ),
			'dateFormat'      => $datepicker_date_format,
			'firstDay'        => absint( get_option( 'start_of_week' ) ),
			'isRTL'           => $wp_locale->is_rtl(),
		);

		wp_localize_script( 'powerform-front-scripts', 'datepickerLang', $datepicker_data );
	}

	/**
	 * Load phone field scripts conditionally
	 *
	 * @since 1.11
	 */
	public function load_phone_scripts() {

		// Load int-tels.
		$style_src     = powerform_plugin_url() . 'assets/css/intlTelInput.min.css';
		$style_version = "4.0.3";

		$script_src     = powerform_plugin_url() . 'assets/js/library/intlTelInput.min.js';
		$script_version = POWERFORM_VERSION;

		wp_enqueue_style( 'intlTelInput-powerform-css', $style_src, array(), $style_version ); // intlTelInput
		wp_enqueue_script( 'powerform-intlTelInput', $script_src, array( 'jquery' ), $script_version, false ); // intlTelInput
	}

	/**
	 * Load calculation,currency and number field scripts mask
	 *
	 * @since 1.11
	 */
	public function load_mask_scripts() {
		$script_src     = powerform_plugin_url() . 'assets/js/library/jquery.mask.js';
		$script_version = POWERFORM_VERSION;

		wp_enqueue_script( 'powerform-mask', $script_src, array( 'jquery' ), $script_version, false ); // mask
	}
}
