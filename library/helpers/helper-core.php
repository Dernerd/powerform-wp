<?php
/**
 * Return needed cap for admin pages
 *
 * @since 1.0
 * @return string
 */
function powerform_get_admin_cap() {
	$cap = 'manage_options';

	if ( is_multisite() && is_network_admin() ) {
		$cap = 'manage_network';
	}

	if ( current_user_can( 'manage_powerform' ) ) {
		$cap = 'manage_powerform';
	}

	return apply_filters( 'powerform_admin_cap', $cap );
}

/**
 * Checks if user is allowed to perform the ajax actions
 *
 * @since 1.0
 * @return bool
 */
function powerform_is_user_allowed() {
	return current_user_can(
		powerform_get_admin_cap()
	);
}

/**
 * Check if array value exists
 *
 * @since 1.0
 *
 * @param array  $array
 * @param string $key - the string key
 *
 * @return bool
 */
function powerform_array_value_exists( $array, $key ) {
	return ( isset( $array[ $key ] ) && ! empty( $array[ $key ] ) );
}

/**
 * Check if array value exists
 *
 * @since 1.14.7
 *
 * @param array  $properties All properties.
 * @param string $key Key.
 */
function powerform_echo_font_weight( $properties, $key ) {
	$styles = array( 'italic', 'oblique' );
	$weight = str_replace( 'None', 'inherit', $properties[ $key ] );
	$weight = str_replace( 'regular', 'normal', $weight );
	// if 400italic.
	$style = str_replace( (int) $weight, '', $weight );
	if ( in_array( $style, $styles, true ) ) {
		// if just italic.
		$weight = intval( $weight ) ? intval( $weight ) : 'normal';
		echo 'font-weight: ' . esc_attr( $weight ) . ';';
		echo 'font-style: ' . esc_attr( $style ) . ';';
	} else {
		echo 'font-weight: ' . esc_attr( $weight ) . ';';
	}
}

/**
 * Convert object to array
 *
 * @since 1.0
 *
 * @param $object
 *
 * @return array
 */
function powerform_object_to_array( $object ) {
	$array = array();

	if ( empty( $object ) ) {
		return $array;
	}

	foreach ( $object as $key => $value ) {
		$array[ $key ] = $value;
	}

	return $array;
}

/**
 * Return AJAX url
 *
 * @since 1.0
 * @return mixed
 */
function powerform_ajax_url() {
	return admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' );
}

/**
 * Checks if the AJAX call is valid
 *
 * @since 1.0
 *
 * @param $action
 */
function powerform_validate_ajax( $action ) {
	if ( ! powerform_is_user_allowed() || ! check_ajax_referer( $action ) ) {
		wp_send_json_error( __( 'Invalid request, you are not allowed to do that action.', Powerform::DOMAIN ) );
	}
}

/**
 * Enqueue admin fonts
 *
 * @since 1.0
 * @since 1.5.1 implement $version
 *
 * @param $version
 */
function powerform_admin_enqueue_fonts( $version ) {
	wp_enqueue_style(
		'powerform-roboto',
		'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i',
		array(),
		'1.0'
	); // cache as long as you can
	wp_enqueue_style(
		'powerform-opensans',
		'https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i',
		array(),
		'1.0'
	); // cache as long as you can
	wp_enqueue_style(
		'powerform-source',
		'https://fonts.googleapis.com/css?family=Source+Code+Pro',
		array(),
		'1.0'
	); // cache as long as you can

	// if plugin internal font need to enqueued, please use $version as its subject to cache
}

/**
 * Enqueue admin styles
 *
 * @since 1.0
 * @since 1.1 Remove powerform-admin css after migrate to shared-ui
 *
 * @param $version
 */
function powerform_admin_enqueue_styles( $version ) {
	wp_enqueue_style( 'select2-powerform-css', powerform_plugin_url() . 'assets/css/select2.min.css', array(), '4.0.3', false ); // Select2
	wp_enqueue_style( 'shared-ui', powerform_plugin_url() . 'assets/css/shared-ui.min.css', array(), $version, false );
}

/**
 * Enqueue jQuery UI scripts on admin
 *
 * @since 1.13 Loaded locally
 * @since 1.0
 */
function powerform_admin_jquery_ui() {
	wp_enqueue_script( 'jquery-ui-powerform', powerform_plugin_url() . 'assets/js/library/jquery-ui.min.js', array( 'jquery' ), '1.12.1', false );
}

/**
 * Load admin scripts
 *
 * @since 1.0
 */
function powerform_admin_jquery_ui_init() {
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-widget' );
	wp_enqueue_script( 'jquery-ui-mouse' );
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-draggable' );
	wp_enqueue_script( 'jquery-ui-droppable' );
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_script( 'jquery-ui-resize' );
	wp_enqueue_style( 'wp-color-picker' );
}

/**
 * Enqueue SUI scripts on admin
 *
 * @since 1.1
 */
function powerform_sui_scripts() {

	$chartjs_version = '2.7.2';

	$sanitize_version = str_replace( '.', '-', POWERFORM_SUI_VERSION );
	$sui_body_class   = "sui-$sanitize_version";

	wp_enqueue_script( 'shared-ui', powerform_plugin_url() . 'assets/js/shared-ui.min.js', array( 'jquery' ), $sui_body_class, true );

}

/**
 * Enqueue admin scripts
 *
 * @since 1.0
 *
 * @param       $version
 * @param array $data
 * @param array $l10n
 */
function powerform_admin_enqueue_scripts( $version, $data = array(), $l10n = array() ) {
	$language = get_option( 'powerform_captcha_language', 'en' );

	wp_enqueue_script( 'select2-powerform', powerform_plugin_url() . 'assets/js/library/select2.full.min.js', array( 'jquery' ), $version, false );
	wp_enqueue_script( 'ace-editor', powerform_plugin_url() . 'assets/js/library/ace/ace.js', array( 'jquery' ), $version, false );
	wp_enqueue_script( 'google-charts', 'https://www.gstatic.com/charts/loader.js', array( 'jquery' ), $version, false );

	if ( function_exists( 'wp_enqueue_editor' ) ) {
		wp_enqueue_editor();
	}
	if ( function_exists( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}

	wp_enqueue_script( 'powerform-admin-layout', powerform_plugin_url() . 'build/admin/layout.js', array( 'jquery' ), $version, false );
	wp_register_script(
		'powerform-admin',
		powerform_plugin_url() . 'build/main.js',
		array(
			'backbone',
			'underscore',
			'jquery',
			'wp-color-picker',
		),
		$version,
		true
	);
	wp_localize_script( 'powerform-admin', 'powerformData', $data );
	wp_localize_script( 'powerform-admin', 'powerforml10n', $l10n );
	wp_enqueue_script( 'powerform-admin' );
}

/**
 * Enqueue admin scripts
 *
 * @since 1.0
 *
 * @param $version
 */
function powerform_admin_enqueue_scripts_forms( $version, $data = array(), $l10n = array() ) {
	wp_enqueue_script( 'select2-powerform', powerform_plugin_url() . 'assets/js/library/select2.full.min.js', array( 'jquery' ), $version, false );
	wp_enqueue_script( 'ace-editor', powerform_plugin_url() . 'assets/js/library/ace/ace.js', array( 'jquery' ), $version, false );
	wp_enqueue_script( 'google-charts', 'https://www.gstatic.com/charts/loader.js', array( 'jquery' ), $version, false );

	if ( function_exists( 'wp_enqueue_editor' ) ) {
		wp_enqueue_editor();
	}
	if ( function_exists( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}

	wp_enqueue_script( 'powerform-admin-layout', powerform_plugin_url() . 'build/admin/layout.js', array( 'jquery' ), $version, false );
	wp_register_script(
		'powerform-admin',
		powerform_plugin_url() . 'assets/js/form-scripts.js',
		array(
			'jquery',
			'wp-color-picker',
			'react',
			'react-dom',
		),
		$version,
		true
	);
	powerform_enqueue_color_picker_alpha( $version );

	wp_localize_script( 'powerform-admin', 'powerformData', $data );
	wp_localize_script( 'powerform-admin', 'powerforml10n', $l10n );

	wp_enqueue_script( 'powerform-admin' );
}

/**
 * Enqueue color picker alpha scripts
 *
 * @since 1.14
 *
 * @param $version
 */
function powerform_enqueue_color_picker_alpha( $version ) {
	wp_enqueue_script( 'wp-color-picker-alpha', powerform_plugin_url() . 'assets/js/library/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), $version, true );

	wp_localize_script( 'wp-color-picker-alpha', 'wpColorPickerL10n', array(
		'clear'            => __( 'Clear', Powerform::DOMAIN ),
		'clearAriaLabel'   => __( 'Clear color', Powerform::DOMAIN ),
		'defaultString'    => __( 'Default', Powerform::DOMAIN ),
		'defaultAriaLabel' => __( 'Select default color', Powerform::DOMAIN ),
		'pick'             => __( 'Select Color', Powerform::DOMAIN ),
		'defaultLabel'     => __( 'Color value', Powerform::DOMAIN ),
	) );
}

/**
 * Enqueue admin scripts
 *
 * @since 1.0
 *
 * @param $version
 */
function powerform_admin_enqueue_scripts_polls( $version, $data = array(), $l10n = array() ) {
	wp_enqueue_script( 'select2-powerform', powerform_plugin_url() . 'assets/js/library/select2.full.min.js', array( 'jquery' ), $version, false );
	wp_enqueue_script( 'ace-editor', powerform_plugin_url() . 'assets/js/library/ace/ace.js', array( 'jquery' ), $version, false );
	wp_enqueue_script( 'google-charts', 'https://www.gstatic.com/charts/loader.js', array( 'jquery' ), $version, false );

	if ( function_exists( 'wp_enqueue_editor' ) ) {
		wp_enqueue_editor();
	}
	if ( function_exists( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}

	wp_enqueue_script( 'powerform-admin-layout', powerform_plugin_url() . 'build/admin/layout.js', array( 'jquery' ), $version, false );
	wp_register_script(
		'powerform-admin',
		powerform_plugin_url() . 'assets/js/poll-scripts.js',
		array(
			'jquery',
			'wp-color-picker',
			'react',
			'react-dom',
		),
		$version,
		true
	);

	powerform_enqueue_color_picker_alpha( $version );

	wp_localize_script( 'powerform-admin', 'powerformData', $data );
	wp_localize_script( 'powerform-admin', 'powerforml10n', $l10n );
	wp_enqueue_script( 'powerform-admin' );
}

/**
 * Enqueue admin scripts
 *
 * @since 1.6.2
 *
 * @param $version
 */
function powerform_admin_enqueue_scripts_knowledge( $version, $data = array(), $l10n = array() ) {
	wp_enqueue_script( 'select2-powerform', powerform_plugin_url() . 'assets/js/library/select2.full.min.js', array( 'jquery' ), $version, false );
	wp_enqueue_script( 'ace-editor', powerform_plugin_url() . 'assets/js/library/ace/ace.js', array( 'jquery' ), $version, false );
	wp_enqueue_script( 'google-charts', 'https://www.gstatic.com/charts/loader.js', array( 'jquery' ), $version, false );

	if ( function_exists( 'wp_enqueue_editor' ) ) {
		wp_enqueue_editor();
	}
	if ( function_exists( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}

	wp_enqueue_script( 'powerform-admin-layout', powerform_plugin_url() . 'build/admin/layout.js', array( 'jquery' ), $version, false );
	wp_register_script(
		'powerform-admin',
		powerform_plugin_url() . 'assets/js/knowledge-scripts.js',
		array(
			'jquery',
			'wp-color-picker',
			'react',
			'react-dom',
		),
		$version,
		true
	);

	wp_enqueue_script( 'powerform-jquery-ui-touch', powerform_plugin_url() . 'assets/js/library/jquery.ui.touch-punch.min.js', array( 'jquery' ), $version, true );

	powerform_enqueue_color_picker_alpha( $version );

	wp_localize_script( 'powerform-admin', 'powerformData', $data );
	wp_localize_script( 'powerform-admin', 'powerforml10n', $l10n );
	wp_enqueue_script( 'powerform-admin' );
}


/**
 * Enqueue admin scripts
 *
 * @since 1.6.2
 *
 * @param $version
 */
function powerform_admin_enqueue_scripts_personality( $version, $data = array(), $l10n = array() ) {
	wp_enqueue_script( 'select2-powerform', powerform_plugin_url() . 'assets/js/library/select2.full.min.js', array( 'jquery' ), $version, false );
	wp_enqueue_script( 'ace-editor', powerform_plugin_url() . 'assets/js/library/ace/ace.js', array( 'jquery' ), $version, false );
	wp_enqueue_script( 'google-charts', 'https://www.gstatic.com/charts/loader.js', array( 'jquery' ), $version, false );

	if ( function_exists( 'wp_enqueue_editor' ) ) {
		wp_enqueue_editor();
	}
	if ( function_exists( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}

	wp_enqueue_script( 'powerform-admin-layout', powerform_plugin_url() . 'build/admin/layout.js', array( 'jquery' ), $version, false );
	wp_register_script(
		'powerform-admin',
		powerform_plugin_url() . 'assets/js/personality-scripts.js',
		array(
			'jquery',
			'wp-color-picker',
			'react',
			'react-dom',
		),
		$version,
		true
	);

	powerform_enqueue_color_picker_alpha( $version );

	wp_enqueue_script( 'powerform-jquery-ui-touch', powerform_plugin_url() . 'assets/js/library/jquery.ui.touch-punch.min.js', array( 'jquery' ), $version, true );

	wp_localize_script( 'powerform-admin', 'powerformData', $data );
	wp_localize_script( 'powerform-admin', 'powerforml10n', $l10n );
	wp_enqueue_script( 'powerform-admin' );
}

/**
 * Enqueue custom form admin styles
 *
 * @since 1.11
 *
 * @param $version
 * @param $grid
 * @param $module_type
 * @param $module_design
 */
function powerform_print_forms_admin_styles( $version = '1.0' ) {
	wp_enqueue_style( 'powerform-ui-icons', powerform_plugin_url() . 'assets/powerform-ui/css/powerform-icons.min.css', array(), $version );
	wp_enqueue_style( 'powerform-ui', powerform_plugin_url() . 'assets/powerform-ui/css/src/powerform-ui.min.css', array(), $version );
	wp_enqueue_style( 'powerform-grid-open', powerform_plugin_url() . 'assets/powerform-ui/css/src/grid/powerform-grid.open.min.css', array(), $version );
	wp_enqueue_style( 'powerform-grid-enclosed', powerform_plugin_url() . 'assets/powerform-ui/css/src/grid/powerform-grid.enclosed.min.css', array(), $version );
}

/**
 * Enqueue poll admin styles
 *
 * @since 1.11
 *
 * @param $version
 * @param $grid
 * @param $module_type
 * @param $module_design
 */
function powerform_print_polls_admin_styles( $version = '1.0' ) {
	wp_enqueue_style( 'powerform-ui-icons', powerform_plugin_url() . 'assets/powerform-ui/css/powerform-icons.min.css', array(), $version );
	wp_enqueue_style( 'powerform-ui', powerform_plugin_url() . 'assets/powerform-ui/css/src/powerform-ui.min.css', array(), $version );
}

/**
 * Enqueue front-end styles
 *
 * only use core here, if the style dynamically loaded, then load on model
 *
 * @since 1.0
 *
 * @param $version
 * @param $grid
 * @param $module_type
 * @param $module_design
 */
function powerform_print_front_styles( $version = '1.0' ) {
	// Load old styles.
	// Remove on v1.12.0 quizzes migrate to Powerform UI.
	wp_enqueue_style( 'powerform-ui', powerform_plugin_url() . 'assets/powerform-ui/css/src/powerform-ui.min.css', array(), $version );
	wp_enqueue_style( 'powerform-grid-open', powerform_plugin_url() . 'assets/powerform-ui/css/src/grid/powerform-grid.open.min.css', array(), $version );
	wp_enqueue_style( 'powerform-grid-enclosed', powerform_plugin_url() . 'assets/powerform-ui/css/src/grid/powerform-grid.enclosed.min.css', array(), $version );
}

/**
 * Enqueue front-end script
 *
 * only use core here, if the style dynamically loaded, then load on model
 *
 * @since 1.0
 *
 * @param $version
 */
function powerform_print_front_scripts( $version = '1.0' ) {

	global $wp_locale;

	// LOAD: ChartJS
	wp_enqueue_script(
		'chartjs',
		powerform_plugin_url() . 'assets/js/front/Chart.min.js',
		array( 'jquery' ),
		'2.8.0',
		false
	);
	$save_global_color = "if (typeof window !== 'undefined' && typeof window.Color !== 'undefined') {window.notChartColor = window.Color;}";
	$restore_global_color = "if (typeof window !== 'undefined' && typeof window.notChartColor !== 'undefined') {window.Color = window.notChartColor;}";
	wp_add_inline_script( 'chartjs', $save_global_color, 'before' );
	wp_add_inline_script( 'powerform-chart', $save_global_color, 'before' );
	wp_add_inline_script( 'chartjs', $restore_global_color );
	wp_add_inline_script( 'powerform-chart', $restore_global_color );

	// LOAD: Datalabels plugin for ChartJS
	wp_enqueue_script(
		'chartjs-plugin-datalabels',
		powerform_plugin_url() . 'assets/js/front/chartjs-plugin-datalabels.min.js',
		array( 'jquery' ),
		'0.6.0',
		false
	);

	// LOAD: Powerform UI JS
	wp_enqueue_script(
		'powerform-ui',
		powerform_plugin_url() . 'assets/powerform-ui/js/powerform-ui.min.js',
		array( 'jquery' ),
		'1.7.1',
		false
	);

	// TODO : check if its always needed
	// wp_enqueue_script( 'select2-powerform', powerform_plugin_url() . 'assets/js/library/select2.full.min.js', array( 'jquery' ), $version, false );

	// TODO : check if its always needed
	wp_enqueue_script( 'powerform-jquery-validate', powerform_plugin_url() . 'assets/js/library/jquery.validate.min.js', array( 'jquery' ), POWERFORM_VERSION, false );


	wp_enqueue_script(
		'powerform-front-scripts',
		powerform_plugin_url() . 'build/front/front.multi.min.js',
		array( 'jquery', 'powerform-ui', 'powerform-jquery-validate' ),
		$version,
		false
	);

	wp_localize_script( 'powerform-front-scripts', 'PowerformFront', powerform_localize_data() );

	//localize Datepicker js
	$datepicker_date_format = str_replace(
		array(
			'd',
			'j',
			'l',
			'z', // Day.
			'F',
			'M',
			'n',
			'm', // Month.
			'Y',
			'y', // Year.
		),
		array(
			'dd',
			'd',
			'DD',
			'o',
			'MM',
			'M',
			'm',
			'mm',
			'yy',
			'y',
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
 * Return front-end localization data
 *
 * @since 1.0
 */
function powerform_localize_data() {
	return array(
		'ajaxUrl' => powerform_ajax_url(),
		'cform'   => array(
			'processing'                => __( 'Submitting form, please wait', Powerform::DOMAIN ),
			'error'                     => __( 'An error occurred processing the form. Please try again', Powerform::DOMAIN ),
			'upload_error'              => __( 'An upload error occurred processing the form. Please try again', Powerform::DOMAIN ),
			'pagination_prev'           => __( 'Previous', Powerform::DOMAIN ),
			'pagination_next'           => __( 'Next', Powerform::DOMAIN ),
			'pagination_go'             => __( 'Submit', Powerform::DOMAIN ),
			'gateway'                   => array(
				'processing' => __( 'Processing payment, please wait', Powerform::DOMAIN ),
				'paid'       => __( 'Success! Payment confirmed. Submitting form, please wait', Powerform::DOMAIN ),
				'error'      => __( 'Error! Something went wrong when verifying the payment', Powerform::DOMAIN ),
			),
			'captcha_error'             => __( 'Invalid CAPTCHA', Powerform::DOMAIN ),
			'no_file_chosen'            => __( 'No file chosen', Powerform::DOMAIN ),
			// This is the file "/build/js/utils.js" found into intlTelInput plugin. Renamed so it makes sense within the "js/library" directory context.
			'intlTelInput_utils_script' => powerform_plugin_url() . 'assets/js/library/intlTelInputUtils.js',
			'process_error'             => __( 'Please try again', Powerform::DOMAIN ),
		),
		'poll'    => array(
			'processing' => __( 'Submitting vote, please wait', Powerform::DOMAIN ),
			'error'      => __( 'An error occurred saving the vote. Please try again', Powerform::DOMAIN ),
		),
		'select2' => array(
			'load_more'       => __( 'Loading more results…', Powerform::DOMAIN ),
			'no_result_found' => __( 'No results found', Powerform::DOMAIN ),
			'searching'       => __( 'Searching…', Powerform::DOMAIN ),
			'loaded_error'    => __( 'The results could not be loaded.', Powerform::DOMAIN ),
		),
	);
}

/**
 * Return existing templates
 *
 * @since 1.0
 *
 * @param $path
 * @param $args
 *
 * @return mixed
 */

function powerform_template( $path, $args = array() ) {
	$file    = powerform_plugin_dir() . "admin/views/$path.php";
	$content = '';

	if ( is_file( $file ) ) {
		ob_start();

		if ( isset( $args['id'] ) ) {
			$args['template_class'] = $args['class'];
			$args['template_id']    = $args['id'];
			$title                  = $args['title'];
			$header_callback        = $args['header_callback'];
			$main_callback          = $args['main_callback'];
			$footer_callback        = $args['footer_callback'];
		}

		include $file;

		$content = ob_get_clean();
	}

	return $content;
}

/**
 * Return if template exist
 *
 * @since 1.0
 *
 * @param $path
 *
 * @return bool
 */
function powerform_template_exist( $path ) {
	$file = powerform_plugin_dir() . "admin/views/$path.php";

	return is_file( $file );
}

/**
 * Return if paypal settings are filled
 *
 * @since 1.0
 * @return bool
 */
function powerform_has_paypal_settings() {
	$config = get_option( 'powerform_paypal_configuration', array() );

	if ( empty( $config ) ) {
		return false;
	}

	return true;
}

/**
 * Return if captcha settings are filled
 *
 * @since 1.0
 * @return bool
 */
function powerform_has_captcha_settings() {
	$key    = get_option( 'powerform_captcha_key', false );
	$secret = get_option( 'powerform_captcha_secret', false );

	if ( empty( $key ) || empty( $secret ) ) {
		return false;
	}

	return true;
}

/**
 * Return if captcha v2 settings are filled
 *
 * @since 1.0
 * @return bool
 */
function powerform_has_v2_captcha_settings() {
	$key    = get_option( 'powerform_captcha_key', false );
	$secret = get_option( 'powerform_captcha_secret', false );

	if ( empty( $key ) || empty( $secret ) ) {
		return false;
	}

	return true;
}

/**
 * Return if captcha v2 invisible settings are filled
 *
 * @since 1.0
 * @return bool
 */
function powerform_has_v2_invisible_captcha_settings() {
	$key    = get_option( 'powerform_v2_invisible_captcha_key', false );
	$secret = get_option( 'powerform_v2_invisible_captcha_secret', false );

	if ( empty( $key ) || empty( $secret ) ) {
		return false;
	}

	return true;
}

/**
 * Return if captcha v3 settings are filled
 *
 * @since 1.0
 * @return bool
 */
function powerform_has_v3_captcha_settings() {
	$key    = get_option( 'powerform_v3_captcha_key', false );
	$secret = get_option( 'powerform_v3_captcha_secret', false );

	if ( empty( $key ) || empty( $secret ) ) {
		return false;
	}

	return true;
}

/**
 * Return if Stripe is is_connected
 *
 * @since 1.7
 * @return bool
 */
function powerform_has_stripe_connected() {
	if ( class_exists( 'Powerform_Gateway_Stripe' ) ) {
		try {
			$stripe = new Powerform_Gateway_Stripe();
			if ( $stripe->is_test_ready() && $stripe->is_live_ready() ) {
				return true;
			}
		} catch ( Powerform_Gateway_Exception $e ) {
			return false;
		}
	}

	return false;
}
/**
 * Return form ID
 *
 * @since 1.0
 * @return int
 */
function powerform_get_form_id_helper() {
	$screen = get_current_screen();
	$ids    = powerform_get_page_ids_helper();

	if ( ! in_array( $screen->id, $ids, true ) ) {
		return 0;
	}

	return isset( $_GET['form_id'] ) ? intval( $_GET['form_id'] ) : 0;
}

/**
 * Get Page IDs
 *
 * @since 1.2
 * @return array
 */
function powerform_get_page_ids_helper() {
	// Sanitize is requied when user uses space inside the translation.
	$name = sanitize_title( __( 'powerform', POWERFORM::DOMAIN ) );
	if ( POWERFORM_PRO ) {
        $title = sanitize_title( __( 'Powerform', Powerform::DOMAIN ) );
		return array(
			$title . '_page_powerform-quiz-view',
			$title . '_page_powerform-cform-view',
			$title . '_page_powerform-poll-view',
			$title . '_page_powerform-entries',
		);
	} else {
		// Free version
        $title = sanitize_title( __( 'Powerform', Powerform::DOMAIN ) );
		return array(
			$title . '_page_powerform-quiz-view',
			$title . '_page_powerform-cform-view',
			$title . '_page_powerform-poll-view',
			$title . '_page_powerform-entries',
		);
	}
}

/**
 * Return form type
 *
 * @since 1.0
 * @return int|null|string
 */
function powerform_get_form_type_helper() {
	$screen = get_current_screen();
	$ids    = powerform_get_page_ids_helper();
	if ( ! in_array( $screen->id, $ids, true ) ) {
		return 0;
	}

	$form_type = "";
	$page      = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : null;

	if ( is_null( $page ) ) {
		return null;
	}

	switch ( $page ) {
		case 'powerform-quiz-view':
			$form_type = 'quiz';
			break;
		case 'powerform-poll-view':
			$form_type = 'poll';
			break;
		case 'powerform-cform-view':
			$form_type = 'cform';
			break;
		case 'powerform-entries':
			if ( isset( $_GET['form_type'] ) && $_GET['form_type'] ) { // phpcs:ignore
				switch ( $_GET['form_type'] ) { // phpcs:ignore
					case 'powerform_forms':
						$form_type = 'cform';
						break;
					case 'powerform_polls':
						$form_type = 'poll';
						break;
					case 'powerform_quizzes':
						$form_type = 'quiz';
						break;
					default:
						break;
				}
			}
			break;
		default:
			break;
	}

	return $form_type;
}

/**
 * @since 1.0
 *
 * @param $info
 * @param $key
 *
 * @return mixed
 */
function powerform_get_exporter_info( $info, $key ) {
	$data = get_option( 'powerform_entries_export_schedule', array() );
	if ( 'email' === $info && ! empty( $data[ $key ][ $info ] ) && ! is_array( $data[ $key ][ $info ] ) ) {
		return array( $data[ $key ][ $info ] );
	}

	return isset( $data[ $key ][ $info ] ) ? $data[ $key ][ $info ] : null;
}

/**
 * Return current logged in username
 *
 * @since 1.0
 * @return string
 */
function powerform_get_current_username() {
	$current_user = wp_get_current_user();
	if ( ! ( $current_user instanceof WP_User ) || empty( $current_user->user_login ) ) {
		return '';
	}

	return $current_user->user_login;
}

/**
 * @since 1.0
 *
 * @param $form_id
 *
 * @return bool
 */
function delete_export_logs( $form_id ) {
	if ( ! $form_id ) {
		return false;
	}

	$data   = get_option( 'powerform_exporter_log', array() );
	$delete = false;

	if ( isset( $data[ $form_id ] ) ) {
		unset( $data[ $form_id ] );
		$delete = update_option( 'powerform_exporter_log', $data );
	}

	return $delete;
}

/**
 * @since 1.0
 *
 * @param $form_id
 *
 * @return array
 */
function powerform_get_export_logs( $form_id ) {
	if ( ! $form_id ) {
		return array();
	}

	$data = get_option( 'powerform_exporter_log', array() );
	$row  = isset( $data[ $form_id ] ) ? $data[ $form_id ] : array();

	foreach ( $row as &$item ) {
		$item['time'] = date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $item['time'] );// phpcs:ignore
	}

	return $row;
}

/**
 * Return current page url
 *
 * @since 1.0.3
 *
 * @return mixed
 */
function powerform_get_current_url() {
	global $wp;

	return add_query_arg( esc_attr( $_SERVER['QUERY_STRING'] ), '', trailingslashit( home_url( $wp->request ) ) );
}

/**
 * Detect whether current request comes from any page builder preveiw page
 *
 * @since 1.13
 *
 * @return bool
 */
function powerform_is_page_builder_preview() {
	static $decision;
	if ( isset( $decision ) ) {
		return $decision;
	}

	$decision = false;
	global $wp;

	//Check Pro theme by Themeco https://theme.co/
	if ( defined( 'X_TEMPLATE_PATH' ) && $wp->request === 'cornerstone-endpoint' ) {
		$decision = true;
		return $decision;
	}

	// Check DIVI theme page builder
	// Note : following lines of codes are perfect to detect DIVI builder.
	// But DIVI builder is not showing Powerform forms in preview mood.
	// So commenting out these code for now.
	/*
	if( defined( 'ET_CORE_VERSION' ) && isset( $_REQUEST['et_pb_preview'] ) && $_REQUEST['et_pb_preview'] ) {
		$decision = true;
		return $decision;
	}
	*/

	//Check Elementor plugin
	if ( defined( 'ELEMENTOR_VERSION' ) && isset( $_REQUEST['action'] ) && 'elementor_ajax' === $_REQUEST['action']  && isset( $_REQUEST['editor_post_id'] ) && intval( $_REQUEST['editor_post_id'] ) ) {
		$decision = true;
		return $decision;
	}

	return $decision;
}

/**
 * Return week day from number
 *
 * @since 1.0
 *
 * @param $day
 *
 * @return string
 */
function powerform_get_day_translated( $day ) {
	$days = array(
		'mon' => __( 'Monday', Powerform::DOMAIN ),
		'tue' => __( 'Tuesday', Powerform::DOMAIN ),
		'wed' => __( 'Wednesday', Powerform::DOMAIN ),
		'thu' => __( 'Thursday', Powerform::DOMAIN ),
		'fri' => __( 'Friday', Powerform::DOMAIN ),
		'sat' => __( 'Saturday', Powerform::DOMAIN ),
		'sun' => __( 'Sunday', Powerform::DOMAIN ),
	);

	return isset( $days[ $day ] ) ? $days[ $day ] : $day;
}

/**
 * Add log of powerform
 *
 * By default it will check `WP_DEBUG` and `POWERFORM_DEBUG`
 * then will check `filters`
 *
 * @since 1.1
 * @since 1.3 add POWERFORM_DEBUG as enabled flag
 */
function powerform_maybe_log() {
	$wp_debug_enabled = ( defined( 'WP_DEBUG' ) && WP_DEBUG );

	$enabled = ( defined( 'POWERFORM_DEBUG' ) && POWERFORM_DEBUG );

	$enabled = ( $wp_debug_enabled && $enabled );

	/**
	 * Filter log enable for powerform
	 *
	 * y default it will check `WP_DEBUG`, `POWERFORM_DEBUG` must be true
	 *
	 * @since 1.1
	 *
	 * @param bool $enabled current enable status
	 */
	$enabled = apply_filters( 'powerform_enable_log', $enabled );

	if ( $enabled ) {
		$args    = func_get_args();
		$message = wp_json_encode( $args );
		if ( false !== $message ) {
			error_log( '[Powerform] ' . $message );// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		}
	}
}

/**
 * Helper to cast variable to target type
 *
 * @since 1.6
 *
 * @param $var
 * @param $type
 *
 * @return mixed
 */
function powerform_var_type_cast( $var, $type ) {
	switch ( $type ) {
		case 'bool':
			if ( ! is_bool( $var ) ) {
				$var = filter_var( $var, FILTER_VALIDATE_BOOLEAN );
			}
			break;
		case 'str':
			if ( ! is_string( $var ) ) {
				if ( is_array( $var ) ) {
					$var = implode( ', ', $var );
				} else {
					// juggling
					$var = (string) $var;
				}
			}
			break;
		case 'num':
			if ( ! is_numeric( $var ) ) {
				// juggling
				$var = (int) $var;
			}
			$var = $var + 0;
			break;
		case 'array':
			if ( ! is_array( $var ) ) {
				// juggling
				$var = (array) $var;
			}
			break;
		default:
			break;
	}

	return $var;
}

/**
 * Get chart colors combination for Polls
 *
 * @since 1.5.3
 *
 * @param int $poll_id
 *
 * @return array
 */
function powerform_get_poll_chart_colors( $poll_id = null ) {

	$chart_colors = array(
		'rgba(54, 162, 235, 0.2)', // Blue
		'rgba(255, 99, 132, 0.2)', // Red
		'rgba(255, 206, 86, 0.2)', // Yellow
		'rgba(75, 192, 192, 0.2)', // Green
		'rgba(255, 159, 64, 0.2)', // Orange
		'rgba(153, 102, 255, 0.2)', // Purple
		'rgba(102, 137, 161, 0.2)', // Blue Alt
		'rgba(234, 86, 118, 0.2)', // Red Alt
		'rgba(216, 220, 106, 0.2)', // Yellow Alt
		'rgba(107, 193, 146, 0.2)', // Green Alt
		'rgba(235, 130, 88, 0.2)', // Orange Alt
		'rgba(153, 93, 129, 0.2)', // Purple Alt
		'rgba(0, 0, 0, 0.2)', // Black
		'rgba(136, 136, 136, 0.2)', // Black Alt
	);

	$chart_colors = apply_filters_deprecated( 'powerform_poll_chart_color', array( $chart_colors ), '1.5.3', 'powerform_poll_chart_colors' );

	/**
	 * Filter chart colors to be used for polls
	 *
	 * @since 1.5.3
	 *
	 * @param array $chart_colors
	 * @param int   $poll_id
	 */
	$chart_colors = apply_filters( 'powerform_poll_chart_colors', $chart_colors, $poll_id );

	return $chart_colors;
}

/**
 * Return reCAPTCHA languages
 *
 * @since 1.5.4
 * @return array
 */
function powerform_get_captcha_languages() {
	return apply_filters(
		'powerform_captcha_languages',
		array(
			'ar'     => esc_html__( 'Arabic', Powerform::DOMAIN ),
			'af'     => esc_html__( 'Afrikaans', Powerform::DOMAIN ),
			'am'     => esc_html__( 'Amharic', Powerform::DOMAIN ),
			'hy'     => esc_html__( 'Armenian', Powerform::DOMAIN ),
			'az'     => esc_html__( 'Azerbaijani', Powerform::DOMAIN ),
			'eu'     => esc_html__( 'Basque', Powerform::DOMAIN ),
			'bn'     => esc_html__( 'Bengali', Powerform::DOMAIN ),
			'bg'     => esc_html__( 'Bulgarian', Powerform::DOMAIN ),
			'ca'     => esc_html__( 'Catalan', Powerform::DOMAIN ),
			'zh-HK'  => esc_html__( 'Chinese (Hong Kong)', Powerform::DOMAIN ),
			'zh-CN'  => esc_html__( 'Chinese (Simplified)', Powerform::DOMAIN ),
			'zh-TW'  => esc_html__( 'Chinese (Traditional)', Powerform::DOMAIN ),
			'hr'     => esc_html__( 'Croatian', Powerform::DOMAIN ),
			'cs'     => esc_html__( 'Czech', Powerform::DOMAIN ),
			'da'     => esc_html__( 'Danish', Powerform::DOMAIN ),
			'nl'     => esc_html__( 'Dutch', Powerform::DOMAIN ),
			'en-GB'  => esc_html__( 'English (UK)', Powerform::DOMAIN ),
			'en'     => esc_html__( 'English (US)', Powerform::DOMAIN ),
			'et'     => esc_html__( 'Estonian', Powerform::DOMAIN ),
			'fil'    => esc_html__( 'Filipino', Powerform::DOMAIN ),
			'fi'     => esc_html__( 'Finnish', Powerform::DOMAIN ),
			'fr'     => esc_html__( 'French', Powerform::DOMAIN ),
			'fr-CA'  => esc_html__( 'French (Canadian)', Powerform::DOMAIN ),
			'gl'     => esc_html__( 'Galician', Powerform::DOMAIN ),
			'ka'     => esc_html__( 'Georgian', Powerform::DOMAIN ),
			'de'     => esc_html__( 'German', Powerform::DOMAIN ),
			'de-AT'  => esc_html__( 'German (Austria)', Powerform::DOMAIN ),
			'de-CH'  => esc_html__( 'German (Switzerland)', Powerform::DOMAIN ),
			'el'     => esc_html__( 'Greek', Powerform::DOMAIN ),
			'gu'     => esc_html__( 'Gujarati', Powerform::DOMAIN ),
			'iw'     => esc_html__( 'Hebrew', Powerform::DOMAIN ),
			'hi'     => esc_html__( 'Hindi', Powerform::DOMAIN ),
			'hu'     => esc_html__( 'Hungarain', Powerform::DOMAIN ),
			'is'     => esc_html__( 'Icelandic', Powerform::DOMAIN ),
			'id'     => esc_html__( 'Indonesian', Powerform::DOMAIN ),
			'it'     => esc_html__( 'Italian', Powerform::DOMAIN ),
			'ja'     => esc_html__( 'Japanese', Powerform::DOMAIN ),
			'kn'     => esc_html__( 'Kannada', Powerform::DOMAIN ),
			'ko'     => esc_html__( 'Korean', Powerform::DOMAIN ),
			'lo'     => esc_html__( 'Laothian', Powerform::DOMAIN ),
			'lv'     => esc_html__( 'Latvian', Powerform::DOMAIN ),
			'lt'     => esc_html__( 'Lithuanian', Powerform::DOMAIN ),
			'ms'     => esc_html__( 'Malay', Powerform::DOMAIN ),
			'ml'     => esc_html__( 'Malayalam', Powerform::DOMAIN ),
			'mr'     => esc_html__( 'Marathi', Powerform::DOMAIN ),
			'mn'     => esc_html__( 'Mongolian', Powerform::DOMAIN ),
			'no'     => esc_html__( 'Norwegian', Powerform::DOMAIN ),
			'fa'     => esc_html__( 'Persian', Powerform::DOMAIN ),
			'pl'     => esc_html__( 'Polish', Powerform::DOMAIN ),
			'pt'     => esc_html__( 'Portuguese', Powerform::DOMAIN ),
			'pt-BR'  => esc_html__( 'Portuguese (Brazil)', Powerform::DOMAIN ),
			'pt-PT'  => esc_html__( 'Portuguese (Portugal)', Powerform::DOMAIN ),
			'ro'     => esc_html__( 'Romanian', Powerform::DOMAIN ),
			'ru'     => esc_html__( 'Russian', Powerform::DOMAIN ),
			'rs'     => esc_html__( 'Serbian', Powerform::DOMAIN ),
			'si'     => esc_html__( 'Sinhalese', Powerform::DOMAIN ),
			'sk'     => esc_html__( 'Slovak', Powerform::DOMAIN ),
			'sl'     => esc_html__( 'Slovenian', Powerform::DOMAIN ),
			'es'     => esc_html__( 'Spanish', Powerform::DOMAIN ),
			'es-419' => esc_html__( 'Spanish (Latin America)', Powerform::DOMAIN ),
			'sw'     => esc_html__( 'Swahili', Powerform::DOMAIN ),
			'sv'     => esc_html__( 'Swedish', Powerform::DOMAIN ),
			'ta'     => esc_html__( 'Tamil', Powerform::DOMAIN ),
			'te'     => esc_html__( 'Telugu', Powerform::DOMAIN ),
			'th'     => esc_html__( 'Thai', Powerform::DOMAIN ),
			'tr'     => esc_html__( 'Turkish', Powerform::DOMAIN ),
			'uk'     => esc_html__( 'Ukrainian', Powerform::DOMAIN ),
			'ur'     => esc_html__( 'Urdu', Powerform::DOMAIN ),
			'vi'     => esc_html__( 'Vietnamese', Powerform::DOMAIN ),
			'zu'     => esc_html__( 'Zulu', Powerform::DOMAIN ),
		)
	);
}

/**
 * Flag whether doc link should shown or not
 *
 * @since 1.6
 * @return bool
 */
function powerform_is_show_documentation_link() {
	if ( Powerform::is_psource_member() ) {
		return ! apply_filters( 'psource_branding_hide_doc_link', false );
	}

	return true;
}

/**
 * Flag whether branding should shown or not
 *
 * @since 1.6
 * @return bool
 */
function powerform_is_show_branding() {
	if ( Powerform::is_psource_member() ) {
		return ! apply_filters( 'psource_branding_hide_branding', false );
	}

	return true;
}

/**
 * Get Dashboard settings
 *
 * @since 1.6.3
 *
 * @param string|null $widget
 * @param mixed       $default
 *
 * @return array|mixed
 */
function powerform_get_dashboard_settings( $widget = null, $default = array() ) {
	$settings           = array();
	$dashboard_settings = get_option( 'powerform_dashboard_settings', $default );

	if ( ! is_null( $widget ) ) {
		if ( isset( $dashboard_settings[ $widget ] ) ) {
			$settings = $dashboard_settings[ $widget ];
		} else {
			$settings = $default;
		}
	}

	/**
	 * Filter Dashboard settings
	 *
	 * @since 1.6.3
	 *
	 * @param mixed $settings
	 * @param string widget
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	$settings = apply_filters( 'powerform_dashboard_settings', $settings, $widget, $default );

	return $settings;

}

/**
 * Reset Powerform Settings
 *
 * @see   powerform_delete_custom_options()
 * @see   powerform_delete_addon_options()
 * @see   powerform_delete_custom_posts()
 * @since 1.6.3
 */
function powerform_reset_settings() {
	global $wpdb;

	/**
	 * Fires before Settings reset
	 *
	 * @since 1.6.3
	 */
	do_action( 'powerform_before_reset_settings' );

	/**
	 * @see powerform_delete_custom_options()
	 */

	delete_option( "powerform_pagination_listings" );
	delete_option( "powerform_pagination_entries" );
	delete_option( "powerform_captcha_key" );
	delete_option( "powerform_captcha_secret" );
	delete_option( "powerform_v2_invisible_captcha_key" );
	delete_option( "powerform_v2_invisible_captcha_secret" );
	delete_option( "powerform_v3_captcha_key" );
	delete_option( "powerform_v3_captcha_secret" );
	delete_option( "powerform_captcha_language" );
	delete_option( "powerform_captcha_theme" );
	delete_option( "powerform_welcome_dismissed" );
	delete_option( "powerform_version" );
	delete_option( "powerform_retain_votes_interval_number" );
	delete_option( "powerform_retain_votes_interval_unit" );
	delete_option( "powerform_retain_submissions_interval_number" );
	delete_option( "powerform_retain_submissions_interval_unit" );
	delete_option( "powerform_enable_erasure_request_erase_form_submissions" );
	delete_option( "powerform_form_privacy_settings" );
	delete_option( "powerform_poll_privacy_settings" );
	delete_option( "powerform_retain_ip_interval_number" );
	delete_option( "powerform_retain_ip_interval_unit" );
	delete_option( "powerform_retain_poll_submissions_interval_number" );
	delete_option( "powerform_retain_poll_submissions_interval_unit" );
	delete_option( "powerform_posts_map" );
	delete_option( "powerform_module_enable_load_ajax" );
	delete_option( "powerform_module_use_donotcachepage" );
	delete_option( "powerform_retain_quiz_submissions_interval_number" );
	delete_option( "powerform_retain_quiz_submissions_interval_unit" );
	delete_option( "powerform_dashboard_settings" );
	delete_option( "powerform_sender_email_address" );
	delete_option( "powerform_sender_name" );
	delete_option( "powerform_enable_accessibility" );
	delete_option( "powerform_entries_export_schedule" );
	delete_option( "powerform_paypal_api_mode" );
	delete_option( "powerform_paypal_secret" );
	delete_option( "powerform_currency" );
	delete_option( "powerform_exporter_log" );
	delete_option( "powerform_uninstall_clear_data" );
	delete_option( "powerform_stripe_configuration" );
	delete_option( "powerform_paypal_configuration" );

	/**
	 * @see powerform_delete_addon_options()
	 */
	delete_option( 'powerform_activated_addons' );
	$registered_addons = powerform_get_registered_addons();
	foreach ( $registered_addons as $addon_slug => $registered_addon ) {
		delete_option( "powerform_addon_{$addon_slug}_version" );
		delete_option( "powerform_addon_{$addon_slug}_settings" );
	}

	/**
	 * @see powerform_delete_custom_posts()
	 */
	//Now we delete the custom posts
	$entry_table      = Powerform_Database_Tables::get_table_name( Powerform_Database_Tables::FORM_ENTRY );
	$entry_meta_table = Powerform_Database_Tables::get_table_name( Powerform_Database_Tables::FORM_ENTRY_META );
	$forms_sql        = "SELECT GROUP_CONCAT(`ID`) FROM {$wpdb->posts} WHERE `post_type` = %s";
	$delete_forms_sql = "DELETE FROM {$wpdb->posts} WHERE `post_type` = %s";
	$form_types       = array(
		'powerform_forms',
		'powerform_polls',
		'powerform_quizzes',
	);
	foreach ( $form_types as $type ) {
		$ids = $wpdb->get_var( $wpdb->prepare( $forms_sql, $type ) ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		if ( $ids ) {
			$array_ids = explode( ',', $ids );
			foreach ( $array_ids as $array_id ) {
				wp_cache_delete( $array_id, 'powerform_total_entries' );
			}

			$delete_form_meta_sql = "DELETE FROM {$wpdb->postmeta} WHERE `post_id` in($ids)";
			$wpdb->query( $delete_form_meta_sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

			$entry_sql = "SELECT GROUP_CONCAT(`entry_id`) FROM {$entry_table} WHERE `form_id` IN ($ids)";
			$entries   = $wpdb->get_var( $entry_sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

			$delete_entry_meta_sql = "DELETE FROM {$entry_meta_table} WHERE `entry_id` in($entries)";
			$wpdb->query( $delete_entry_meta_sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

			$delete_entry_sql = "DELETE FROM {$entry_table} WHERE `form_id` in($ids)";
			$wpdb->query( $delete_entry_sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		}
		$wpdb->query( $wpdb->prepare( $delete_forms_sql, $type ) ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
	}

	/**
	 * Fires after Settings reset
	 *
	 * @since 1.6.3
	 */
	do_action( 'powerform_after_reset_settings' );
}

/**
 * Reset plugin to fresh install
 *
 * @since 1.6.3
 */
function powerform_reset_plugin() {
	global $wpdb;

	/**
	 * Fires before Plugin reset
	 *
	 * @since 1.6.3
	 */
	do_action( 'powerform_before_reset_plugin' );

	powerform_reset_settings();

	/**
	 * @see powerform_clear_module_views()
	 */
	$wpdb->query( "TRUNCATE {$wpdb->prefix}frmt_form_views" );

	/**
	 * @see powerform_clear_module_submissions()
	 */
	$max_entry_id_query = "SELECT MAX(`entry_id`) FROM {$wpdb->prefix}frmt_form_entry";
	$max_entry_id       = $wpdb->get_var( $max_entry_id_query ); // phpcs:ignore

	if ( $max_entry_id && is_numeric( $max_entry_id ) && $max_entry_id > 0 ) {
		for ( $i = 1; $i <= $max_entry_id; $i ++ ) {
			wp_cache_delete( $i, 'Powerform_Form_Entry_Model' );
		}
	}

	$wpdb->query( "TRUNCATE {$wpdb->prefix}frmt_form_entry" );
	$wpdb->query( "TRUNCATE {$wpdb->prefix}frmt_form_entry_meta" );

	wp_cache_delete( 'all_form_types', 'powerform_total_entries' );
	wp_cache_delete( 'custom-forms_form_type', 'powerform_total_entries' );
	wp_cache_delete( 'poll_form_type', 'powerform_total_entries' );
	wp_cache_delete( 'quizzes_form_type', 'powerform_total_entries' );

	/**
	 * Fires after Plugin reset
	 *
	 * @since 1.6.3
	 */
	do_action( 'powerform_after_reset_plugin' );
}

/**
 * Add Slash in string
 *
 * @since 1.8
 *
 * @param $value
 * @param string $char
 *
 * @return string
 */

function powerform_addcslashes( $value, $char = '"\\/' ) {

	return addcslashes( $value, $char );
}

/**
 * Return URL link.
 *
 * @since 1.13
 *
 * @param string $link_for Accepts: 'docs', 'plugin', 'rate', 'support', 'roadmap'.
 * @param string $campaign  Utm campaign tag to be used in link. Default: ''.
 * @param string $adv_path  Advanced path. Default: ''.
 *
 * @return string
 */
function powerform_get_link( $link_for, $campaign = '', $adv_path = '' ) {
	$domain   = 'https://n3rds.work';
	$wp_org   = 'https://wordpress.org';
	$utm_tags = "?utm_source=powerform&utm_medium=plugin&utm_campaign={$campaign}";

	switch ( $link_for ) {
		case 'docs':
			$link = "{$domain}/docs/wpmu-dev-plugins/powerform/{$utm_tags}";
			break;
		case 'plugin':
			$link = "{$domain}/project/powerform-pro/{$utm_tags}";
			break;
		case 'rate':
			$link = "{$wp_org}/support/plugin/powerform/reviews/#new-post";
			break;
		case 'support':
			$link = POWERFORM_PRO ? "{$domain}/get-support/" : "{$wp_org}/support/plugin/powerform/";
			break;
		case 'roadmap':
			$link = "{$domain}/roadmap/";
			break;
		case 'pro_link':
			$link = "{$domain}/$adv_path";
			break;
		default:
			$link = '';
			break;
	}

	return $link;
}

/**
 * Check if the plugin is active network wide.
 *
 * @since 1.13
 *
 * @return bool
 */
function powerform_membership_status() {
	static $status = null;

	// Get the status.
	if ( is_null( $status ) ) {
		// Dashboard is active.
		if ( class_exists( 'PSOURCE_Dashboard' ) ) {
			// Get membership type.
			$status = PSOURCE_Dashboard::$api->get_membership_type();
			// Get available projects.
			$projects = PSOURCE_Dashboard::$api->get_membership_projects();

			// Beehive single plan.
			if ( ( 'unit' === $status && ! in_array( 2097296, $projects, true ) ) || ( 'single' === $status && 2097296 !== $projects ) ) {
				$status = 'upgrade';
			} elseif ( 'free' === $status && PSOURCE_Dashboard::$api->has_key() ) {
				// Check if API key is available but status is free, then it's expired.
				$status = 'expired';
			}
		} else {
			$status = 'free';
		}
	}

	/**
	 * Filter to modify PSOURCE membership status.
	 *
	 * @since 1.13
	 *
	 * @param string $status Status.
	 *
	 */
	return apply_filters( 'powerform_psource_membership_status', $status );
}

/**
 * Check if the plugin is active network wide.
 *
 * @since 1.13
 *
 * @return bool
 */
function powerform_is_networkwide() {
	if ( is_multisite() ) {
		// Makes sure the plugin is defined before trying to use it.
		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		$active = is_plugin_active_for_network( plugin_basename( POWERFORM_PLUGIN_BASENAME ) );
	} else {
		$active = false;
	}

	return $active;
}
