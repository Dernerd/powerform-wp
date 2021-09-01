<?php
/**
 * Addon Name: Mailchimp
 * Version: 1.0
 * Plugin URI:  https://n3rds.work/
 * Description: Integrate Powerform Custom Forms with Mailchimp email list easily
 * Author: WPMU DEV
 * Author URI: http://premium.psource.org
 */

define( 'POWERFORM_ADDON_MAILCHIMP_VERSION', '1.0' );

function powerform_addon_mailchimp_url() {
	return trailingslashit( powerform_plugin_url() . 'addons/pro/mailchimp' );
}

function powerform_addon_mailchimp_assets_url() {
	return trailingslashit( powerform_addon_mailchimp_url() . 'assets' );
}

require_once dirname( __FILE__ ) . '/class-powerform-addon-mailchimp.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-mailchimp-form-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-mailchimp-form-hooks.php';

require_once dirname( __FILE__ ) . '/class-powerform-addon-mailchimp-quiz-settings.php';
require_once dirname( __FILE__ ) . '/class-powerform-addon-mailchimp-quiz-hooks.php';

//Direct Load
Powerform_Addon_Loader::get_instance()->register( 'Powerform_Addon_Mailchimp' );
