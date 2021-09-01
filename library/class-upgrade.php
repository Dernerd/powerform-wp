<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Upgrade
 *
 * Handle any installation upgrade or install tasks
 */
class Powerform_Upgrade {

	/**
	 * Initialise data before plugin is fully loaded
	 *
	 * @since 1.0
	 */
	public static function init() {
		/**
		 * Initialize the plugin data
		 */
		$old_version = get_option( 'powerform_version', false );
		if ( $old_version ) {
			$version_changed = version_compare( $old_version, POWERFORM_VERSION, 'lt' );

			if ( $version_changed ) {
				update_option( 'powerform_version_upgraded', true );
			}
		} else {
			$version_changed = true;
		}
		if ( $version_changed ) {
			// Update tables if required
			Powerform_Database_Tables::install_database_tables();

			add_action( 'admin_init', array( __CLASS__, 'flush_rewrite' ) );

			// Update version
			update_option( 'powerform_version', POWERFORM_VERSION );
		}

		// cleanup ip address on views
		self::cleanup_views_ip_address();
	}

	public static function flush_rewrite() {
		// Flush rewrite rules
		flush_rewrite_rules();
	}

	/**
	 * Clean up up address on views
	 *
	 * @since 1.5.4
	 * @return bool
	 */
	public static function cleanup_views_ip_address() {
		if ( defined( 'POWERFORM_VIEWS_ENABLE_TRACK_IP' ) && POWERFORM_VIEWS_ENABLE_TRACK_IP ) {
			return false;
		}
		$views = new Powerform_Form_Views_Model();
		$views->maybe_cleanup_ip_address();

		return true;
	}
}
