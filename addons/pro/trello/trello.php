<?php

/**
 * Addon Name: Trello
 * Version: 1.0
 * Plugin URI:  https://n3rds.work/
 * Description: Integrate Powerform Custom Forms with Trello to get notified in real time.
 * Author: WPMU DEV
 * Author URI: http://premium.psource.org
 */

define( 'POWERFORM_ADDON_TRELLO_VERSION', '1.1' );

function powerform_addon_trello_url() {
	return trailingslashit( powerform_plugin_url() . 'addons/pro/trello' );
}

function powerform_addon_trello_dir() {
	return trailingslashit( dirname( __FILE__ ) );
}

function powerform_addon_trello_assets_url() {
	return trailingslashit( powerform_addon_trello_url() . 'assets' );
}

require_once dirname( __FILE__ ) . '/class-powerform-addon-trello.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-trello-form-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-trello-form-hooks.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-trello-poll-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-trello-poll-hooks.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-trello-quiz-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-trello-quiz-hooks.php';

//Direct Load
Powerform_Addon_Loader::get_instance()->register( 'Powerform_Addon_Trello' );
