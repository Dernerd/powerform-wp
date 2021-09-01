<?php

/**
 * Addon Name: HubSpot
 * Version: 1.0
 * Plugin URI:  https://n3rds.work/
 * Description: Integrate Powerform Custom Forms with HubSpot to get notified in real time.
 * Author: WPMU DEV
 * Author URI: http://premium.psource.org
 */

define( 'POWERFORM_ADDON_HUBSPOT_VERSION', '1.0' );

function powerform_addon_hubspot_url() {
	return trailingslashit( powerform_plugin_url() . 'addons/pro/hubspot' );
}

function powerform_addon_hubspot_dir() {
	return trailingslashit( dirname( __FILE__ ) );
}

function powerform_addon_hubspot_assets_url() {
	return trailingslashit( powerform_addon_hubspot_url() . 'assets' );
}

require_once dirname( __FILE__ ) . '/class-powerform-addon-hubspot.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-hubspot-form-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-hubspot-form-hooks.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-hubspot-quiz-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-hubspot-quiz-hooks.php';
//Direct Load
Powerform_Addon_Loader::get_instance()->register( 'Powerform_Addon_HubSpot' );
