<?php

/**
 * Addon Name: Activecampaign
 * Version: 1.0
 * Plugin URI:  https://n3rds.work/
 * Description: Integrate Powerform Custom Forms with Activecampaign to get notified in real time.
 * Author: WPMU DEV
 * Author URI: http://premium.psource.org
 */

define( 'POWERFORM_ADDON_ACTIVECAMPAIGN_VERSION', '1.0' );

function powerform_addon_activecampaign_url() {
	return trailingslashit( powerform_plugin_url() . 'addons/pro/activecampaign' );
}

function powerform_addon_activecampaign_dir() {
	return trailingslashit( dirname( __FILE__ ) );
}

function powerform_addon_activecampaign_assets_url() {
	return trailingslashit( powerform_addon_activecampaign_url() . 'assets' );
}

require_once dirname( __FILE__ ) . '/class-powerform-addon-activecampaign.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-activecampaign-form-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-activecampaign-form-hooks.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-activecampaign-quiz-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-activecampaign-quiz-hooks.php';
//Direct Load
Powerform_Addon_Loader::get_instance()->register( 'Powerform_Addon_Activecampaign' );
