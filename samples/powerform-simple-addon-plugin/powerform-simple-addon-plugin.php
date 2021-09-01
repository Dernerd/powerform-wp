<?php
/**
 * Plugin Name: Powerform Simple Addon
 * Version: 1.0
 * Description: Simple Addon powerform.
 * Author: WMS N@W
 * Author URI: https://n3rds.work
 * Text Domain: external_powerform
 * Domain Path: /languages/
 */

//Direct Load
define( 'POWERFORM_ADDON_SIMPLE_VERSION', '1.0' );

function powerform_addon_simple_url() {
	return trailingslashit( plugin_dir_url( __FILE__ ) );
}

function powerform_addon_simple_assets_url() {
	return trailingslashit( powerform_addon_simple_url() . 'assets' );
}

add_action( 'powerform_addons_loaded', 'load_powerform_addon_simple' );
function load_powerform_addon_simple() {
	require_once dirname( __FILE__ ) . '/powerform-addon-simple.php';
	if ( class_exists( 'Powerform_Addon_Loader' ) ) {
		Powerform_Addon_Loader::get_instance()->register( 'Powerform_Addon_Simple' );
	}
}


