<?php

/**
 * Addon Name: Zapier
 * Version: 1.0
 * Plugin URI:  https://n3rds.work/
 * Description: Integrate Powerform Custom Forms with Zapier to execute various action you like
 * Author: WPMU DEV
 * Author URI: http://premium.psource.org
 */

define( 'POWERFORM_ADDON_ZAPIER_VERSION', '1.2' );

function powerform_addon_zapier_url() {
	return trailingslashit( powerform_plugin_url() . 'addons/pro/zapier' );
}

function powerform_addon_zapier_assets_url() {
	return trailingslashit( powerform_addon_zapier_url() . 'assets' );
}

function powerform_addon_zapier_dir() {
	return trailingslashit( dirname( __FILE__ ) );
}

require_once dirname( __FILE__ ) . '/class-powerform-addon-zapier.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-zapier-form-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-zapier-form-hooks.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-zapier-poll-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-zapier-poll-hooks.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-zapier-quiz-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-zapier-quiz-hooks.php';

//Direct Load
Powerform_Addon_Loader::get_instance()->register( 'Powerform_Addon_Zapier' );
