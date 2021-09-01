<?php

/**
 * Addon Name: FortressDB
 * Version: 1.0
 * Plugin URI:  https://n3rds.work/
 * Description: Integrate Powerform Custom Forms with FortressDB to get notified in real time.
 * Author: FortressDB
 * Author URI: https://fortressdb.com
 */

if ( class_exists( 'FortressDB' ) ) {
	return;
}

function powerform_addon_fortressdb_url() {
	return trailingslashit( powerform_plugin_url() . 'addons/pro/fortressdb' );
}

function powerform_addon_fortress_assets_url() {
	return trailingslashit( powerform_addon_fortressdb_url() . 'assets' );
}

function powerform_addon_fortress_dir() {
	return trailingslashit( dirname( __FILE__ ) );
}

require_once dirname( __FILE__ ) . '/class-fortressdb-powerform.php';
//require_once dirname( __FILE__ ) . '/class-fortressdb-powerform-form-settings.php';

try {
	Powerform_Addon_Loader::get_instance()->register( 'FortressDB_Powerform_Addon' );
} catch ( Exception $e ) {
	echo $e->getMessage();
}
