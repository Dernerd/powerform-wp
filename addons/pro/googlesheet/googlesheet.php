<?php

/**
 * Addon Name: Google Sheets
 * Version: 1.1
 * Plugin URI:  https://n3rds.work/
 * Description: Integrate Powerform Custom Forms and Polls with Google Sheets to get notified in real time.
 * Author: WPMU DEV
 * Author URI: http://premium.psource.org
 */

define( 'POWERFORM_ADDON_GOOGLESHEET_VERSION', '1.1' );

function powerform_addon_googlesheet_url() {
	return trailingslashit( powerform_plugin_url() . 'addons/pro/googlesheet' );
}

function powerform_addon_googlesheet_dir() {
	return trailingslashit( dirname( __FILE__ ) );
}

function powerform_addon_googlesheet_assets_url() {
	return trailingslashit( powerform_addon_googlesheet_url() . 'assets' );
}

function powerform_addon_googlesheet_google_api_client_autoload( $class_name ) {
	$class_path = explode( '_', $class_name );
	if ( 'Google' !== $class_path[0] ) {
		return;
	}
	// Drop 'Google', and maximum class file path depth in this project is 3.
	$google_api_client_path = dirname( __FILE__ ) . '/lib/Google';
	$class_path             = array_slice( $class_path, 1, 2 );
	$file_path              = $google_api_client_path . '/' . implode( '/', $class_path ) . '.php';

	if ( file_exists( $file_path ) ) {
		/** @noinspection PhpIncludeInspection */
		require_once $file_path;
	}
}

// only enable autoload when needed to avoid further conflicts
//spl_autoload_register( 'powerform_addon_googlesheet_google_api_client_autoload' );

require_once dirname( __FILE__ ) . '/class-powerform-addon-googlesheet.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-googlesheet-form-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-googlesheet-form-hooks.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-googlesheet-poll-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-googlesheet-poll-hooks.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-googlesheet-quiz-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-googlesheet-quiz-hooks.php';

require_once dirname( __FILE__ ) . '/lib/class-powerform-addon-wp-googlesheet-client-logger.php';
//Direct Load
Powerform_Addon_Loader::get_instance()->register( 'Powerform_Addon_Googlesheet' );
