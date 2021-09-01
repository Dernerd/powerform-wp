<?php

/**
 * Addon Name: Aweber
 * Version: 1.0
 * Plugin URI:  https://n3rds.work/
 * Description: Integrate Powerform Custom Forms with Aweber to get notified in real time.
 * Author: WPMU DEV
 * Author URI: http://premium.psource.org
 */

define( 'POWERFORM_ADDON_AWEBER_VERSION', '1.0' );

function powerform_addon_aweber_url() {
	return trailingslashit( powerform_plugin_url() . 'addons/pro/aweber' );
}

function powerform_addon_aweber_dir() {
	return trailingslashit( dirname( __FILE__ ) );
}

function powerform_addon_aweber_assets_url() {
	return trailingslashit( powerform_addon_aweber_url() . 'assets' );
}

require_once dirname( __FILE__ ) . '/class-powerform-addon-aweber.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-aweber-form-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-aweber-form-hooks.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-aweber-quiz-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-aweber-quiz-hooks.php';
//Direct Load
Powerform_Addon_Loader::get_instance()->register( 'Powerform_Addon_Aweber' );
