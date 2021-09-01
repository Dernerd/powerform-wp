<?php
/**
 * Plugin Name: Powerform
 * Version: 1.2.1
 * Plugin URI:  https://n3rds.work/piestingtal_source/powerform-plugin/
 * Description: Erfasse Benutzerinformationen (so detailliert wie Sie möchten), beteilige Benutzer an interaktiven Umfragen, die Echtzeitergebnisse und Grafiken, Quizfragen im Facebook-Stil und Wissenstests ohne falsche Antwort anzeigen.
 * Author: WMS N@W
 * Author URI: https://n3rds.work
 * Text Domain: powerform
 * Domain Path: /languages/
 */
/*
Copyright 2009-2021 WMS N@W (https://n3rds.work)
Author – DerN3rd 

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 – GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/

require 'library/external/psource-plugin-update/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://n3rds.work//wp-update-server/?action=get_metadata&slug=powerform-wp', 
	__FILE__, 
	'powerform-wp' 
);


if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! defined( 'POWERFORM_VERSION' ) ) {
	define( 'POWERFORM_VERSION', '1.2.1' );
}

if ( ! defined( 'POWERFORM_SUI_VERSION' ) ) {
	define( 'POWERFORM_SUI_VERSION', '2.6.0' );
}

if ( ! defined( 'POWERFORM_STRIPE_LIB_VERSION' ) ) {
	define( 'POWERFORM_STRIPE_LIB_VERSION', '7.21.1' );
}

if ( ! defined( 'POWERFORM_STRIPE_LIB_DATE' ) ) {
	define( 'POWERFORM_STRIPE_LIB_DATE', '2019-12-03' );
}

if ( ! defined( 'POWERFORM_STRIPE_PARTNER_ID' ) ) {
	define( 'POWERFORM_STRIPE_PARTNER_ID', 'pp_partner_GeDaq2odDgGkDJ' );
}

if ( ! defined( 'POWERFORM_PAYPAL_LIB_VERSION' ) ) {
	define( 'POWERFORM_PAYPAL_LIB_VERSION', '1.14.0' );
}

if ( ! defined( 'POWERFORM_PRO' ) ) {
	define( 'POWERFORM_PRO', true );
}

if ( ! defined( 'POWERFORM_PLUGIN_BASENAME' ) ) {
	define( 'POWERFORM_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

}

/*if ( ! defined( 'POWERFORM_PRO_URL' ) ) {
	define( 'POWERFORM_PRO_URL', 'https://n3rds.work/project/powerform-pro/' );
}*/

// Include API
require_once plugin_dir_path( __FILE__ ) . 'library/class-api.php';

// Register activation hook
register_activation_hook( __FILE__, array( 'Powerform', 'activation_hook' ) );
// Register deactivation hook
register_deactivation_hook( __FILE__, array( 'Powerform', 'deactivation_hook' ) );

/**
 * Class Powerform
 *
 * Main class. Initialize plugin
 *
 * @since 1.0
 */
if ( ! class_exists( 'Powerform' ) ) {
	class Powerform {

		const DOMAIN = 'powerform';

		/**
		 * Plugin instance
		 *
		 * @var null
		 */
		private static $instance = null;

		/**
		 * @var Powerform_Core
		 */
		public $powerform;

		/**
		 * @var Powerform_Addon_Loader
		 */
		private $powerform_addon_loader;

		/**
		 * Return the plugin instance
		 *
		 * @since 1.0
		 * @return Powerform
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Powerform constructor.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'admin_init', array( $this, 'initialize_admin' ) );

			$this->includes();
			$this->include_vendors();

			if ( self::is_addons_feature_enabled() ) {
				$this->init_addons();
			}

			$this->init();
			$this->load_textdomain();
		}

		/**
		 * Called on plugin activation
		 *
		 * @since 1.3
		 */
		public static function activation_hook() {
			add_option( 'powerform_activation_hook', 'activated' );

			self::set_free_installation_timestamp();
		}

		/**
		 * Called on plugin deactivation
		 *
		 * @since 1.11
		 */
		public static function deactivation_hook() {
			wp_clear_scheduled_hook( 'powerform_general_data_protection_cleanup' );
		}

		/**
		 * Called on admin_init
		 *
		 * Flush rewrite rules are not called directly on activation hook, because CPT are not initialized yet
		 *
		 * @since 1.3
		 */
		public function initialize_admin() {
			if ( is_admin() && 'activated' === get_option( 'powerform_activation_hook' ) ) {
				delete_option( 'powerform_activation_hook' );
				flush_rewrite_rules();
			}
		}

		/**
		 * Return status of Addon feature
		 *
		 * If this function return false, then addon functionality will be disabled
		 *
		 * @since 1.1
		 *
		 * @return bool
		 */
		public static function is_addons_feature_enabled() {
			// force enable addon on entire planet
			$enabled = true;

			/**
			 * Filter the status of addons feature
			 *
			 * @since 1.1
			 *
			 * @param bool $enabled current status of addons feature
			 */
			$enabled = apply_filters( 'powerform_is_addons_feature_enabled', $enabled );

			return $enabled;
		}

		/**
		 * Return status of Import/export feature
		 *
		 * If this function return false, then Import/export functionality will be disabled
		 *
		 * @since 1.4
		 * @since 1.5 enabled by default
		 *
		 * @return bool
		 */
		public static function is_import_export_feature_enabled() {
			// enable import export feature for entire planet by default
			$enabled = true;

			/**
			 * Filter the status of Import/export feature
			 *
			 * @since 1.4
			 *
			 * @param bool $enabled current status of Import/export feature
			 */
			$enabled = apply_filters( 'powerform_is_import_export_feature_enabled', $enabled );

			return $enabled;
		}

		/**
		 * Return status of Import integrations feature
		 *
		 * If this function return false, then Import integrations functionality will be disabled
		 *
		 * @since 1.4
		 *
		 * @return bool
		 */
		public static function is_import_integrations_feature_enabled() {
			// default is disabled unless `POWERFORM_ENABLE_IMPORT_INTEGRATIONS` = true,
			// integrations data probably contains sensitive content
			// not 100% will worked if current addon not enabled / not setup properly
			$enabled = ( defined( 'POWERFORM_ENABLE_IMPORT_INTEGRATIONS' ) && POWERFORM_ENABLE_IMPORT_INTEGRATIONS );

			/**
			 * Filter the status of Import integrations feature
			 *
			 * @since 1.4
			 *
			 * @param bool $enabled current status of Import integrations feature
			 */
			$enabled = apply_filters( 'powerform_is_import_integrations_feature_enabled', $enabled );

			return $enabled;
		}

		/**
		 * Return status of Export integrations feature
		 *
		 * If this function return false, then Import integrations functionality will be disabled
		 *
		 * @since 1.4
		 *
		 * @return bool
		 */
		public static function is_export_integrations_feature_enabled() {
			// default is disabled unless `POWERFORM_ENABLE_EXPORT_INTEGRATIONS` = true,
			// integrations data probably contains sensitive content
			// not 100% will worked if current addon not enabled / not setup properly
			$enabled = ( defined( 'POWERFORM_ENABLE_EXPORT_INTEGRATIONS' ) && POWERFORM_ENABLE_EXPORT_INTEGRATIONS );

			/**
			 * Filter the status of Export integrations feature
			 *
			 * @since 1.4
			 *
			 * @param bool $enabled current status of export integrations feature
			 */
			$enabled = apply_filters( 'powerform_is_export_integrations_feature_enabled', $enabled );

			return $enabled;
		}

		/**
		 * Return status of Internal Page Cache support
		 *
		 * @since 1.6.1
		 * @return bool
		 */
		public static function is_internal_page_cache_support_enabled() {
			// default is enabled unless `POWERFORM_ENABLE_INTERNAL_PAGE_CACHE_SUPPORT` = false,
			$enabled = true;
			if ( defined( 'POWERFORM_ENABLE_INTERNAL_PAGE_CACHE_SUPPORT' ) && ! POWERFORM_ENABLE_INTERNAL_PAGE_CACHE_SUPPORT ) {
				$enabled = false;
			}
			/**
			 * Filter the status of Internal Page Cache support
			 *
			 * @since 1.6.1
			 *
			 * @param bool $enabled current status of internal page cache support
			 */
			$enabled = apply_filters( 'powerform_is_internal_page_cache_support_enabled', $enabled );

			return $enabled;
		}

		/**
		 * Initiate Addons Helper and Register internal Addons
		 *
		 * This function will also trigger action `powerform_addons_loaded`
		 *
		 * @since 1.1
		 */
		public function init_addons() {

			/**
			 * Triggered before load and registering internal addons
			 *
			 * Only triggered when addons feature is enabled @see Powerform::is_addons_feature_enabled()
			 * Keep in mind that @see Powerform_Addon_Loader not yet instantiated
			 *
			 * @since 1.1
			 */
			do_action( 'powerform_before_load_addons' );

			include_once powerform_plugin_dir() . 'library/helpers/helper-addon.php';
			$this->powerform_addon_loader = Powerform_Addon_Loader::get_instance();
			$this->load_powerform_addons();

			/**
			 * Triggered after internal addons of powerform loaded
			 *
			 * This action will be used by external addon to register
			 * Registering addon will use @see Powerform_Addon_Loader::register()
			 *
			 * @since 1.1
			 */
			do_action( 'powerform_addons_loaded' );
		}

		/**
		 * Load internal addons
		 *
		 * Load pre-packaged addons
		 *
		 * @since 1.1
		 */
		public function load_powerform_addons() {
			$addons_directory = powerform_addons_dir();
			if ( file_exists( $addons_directory . '/class-addon-autoload.php' ) ) {
				include_once $addons_directory . '/class-addon-autoload.php';
				$autoloader = new Powerform_Addon_Autoload();
				$autoloader->load();
			}
		}

		/**
		 * Load plugin files
		 *
		 * @since 1.0
		 */
		private function includes() {
			// Core files.
			/* @noinspection PhpIncludeInspection */
			include_once powerform_plugin_dir() . 'library/class-core.php';
			include_once powerform_plugin_dir() . 'library/class-addon-loader.php';
			include_once powerform_plugin_dir() . 'library/calculator/class-calculator.php';
		}

		/**
		 * Add option with plugin install date
		 *
		 * @since 1.10
		 */
		public static function set_free_installation_timestamp() {
			// We need the install date only on free version
			if ( POWERFORM_PRO ) {
				return;
			}

			$install_date = get_site_option( 'powerform_free_install_date' );

			if ( empty( $install_date ) ) {
				update_site_option( 'powerform_free_install_date', current_time( 'timestamp' ) );
			}
		}

		/**
		 * Init the plugin
		 *
		 * @since 1.0
		 */
		private function init() {
			// Initialize plugin core
			$this->powerform = Powerform_Core::get_instance();

			/**
			 * Triggered when plugin is loaded
			 */
			do_action( 'powerform_loaded' );
		}

		/**
		 * Include Vendors
		 *
		 * @since 1.0
		 */
		private function include_vendors() {
			/*if ( file_exists( powerform_plugin_dir() . 'library/lib/dash-notice/psource-dash-notification.php' ) ) {
				//load dashboard notice
				global $psource_notices;
				$psource_notices[] = array(
					'id'      => 1000000,
					'name'    => POWERFORM_PRO ? 'Powerform' : 'Powerform',
					'screens' => array(
						'toplevel_page_powerform',
						'toplevel_page_powerform-network',
						'powerform_page_powerform-cform',
						'powerform_page_powerform-cform-network',
						'powerform_page_powerform-poll',
						'powerform_page_powerform-poll-network',
						'powerform_page_powerform-quiz',
						'powerform_page_powerform-quiz-network',
						'powerform_page_powerform-settings',
						'powerform_page_powerform-settings-network',
						'powerform_page_powerform-cform-wizard',
						'powerform_page_powerform-cform-wizard-network',
						'powerform_page_powerform-cform-view',
						'powerform_page_powerform-cform-view-network',
						'powerform_page_powerform-poll-wizard',
						'powerform_page_powerform-poll-wizard-network',
						'powerform_page_powerform-poll-view',
						'powerform_page_powerform-poll-view-network',
						'powerform_page_powerform-nowrong-wizard',
						'powerform_page_powerform-nowrong-wizard-network',
						'powerform_page_powerform-knowledge-wizard',
						'powerform_page_powerform-knowledge-wizard-network',
						'powerform_page_powerform-quiz-view',
						'powerform_page_powerform-quiz-view-network',
					),
				);
				/** @noinspection PhpIncludeInspection */
				//include_once powerform_plugin_dir() . 'library/lib/dash-notice/psource-dash-notification.php';
			//}

			// un-change-able 5.6.0 requirement, based on lowest version needed on vendors list
			if ( version_compare( PHP_VERSION, '5.6.0', 'ge' ) ) {
				/**
				 * Vendors list
				 * - Stripe PHP - Min PHP req 5.6.0 (managed internally)
				 * - Paypal PHP - Min PHP req 5.6.0 (managed internally)
				 */
				/** @noinspection PhpIncludeInspection */
				include_once powerform_plugin_dir() . 'library/external/autoload_psr4.php';
			}

			/*if ( ! POWERFORM_PRO ) {

				if ( file_exists( powerform_plugin_dir() . 'library/lib/recommended-plugins/notice.php' ) ) {

					require_once powerform_plugin_dir() . 'library/lib/recommended-plugins/notice.php';

					do_action(
						'psource-recommended-plugins-register-notice',
						plugin_basename( __FILE__ ), // Plugin basename
						'Powerform', // Plugin Name
						array(
							'toplevel_page_powerform',
							'toplevel_page_powerform-network',
							'powerform_page_powerform-cform',
							'powerform_page_powerform-cform-network',
							'powerform_page_powerform-poll',
							'powerform_page_powerform-poll-network',
							'powerform_page_powerform-quiz',
							'powerform_page_powerform-quiz-network',
							'powerform_page_powerform-settings',
							'powerform_page_powerform-settings-network',
							'powerform_page_powerform-cform-wizard',
							'powerform_page_powerform-cform-wizard-network',
							'powerform_page_powerform-cform-view',
							'powerform_page_powerform-cform-view-network',
							'powerform_page_powerform-poll-wizard',
							'powerform_page_powerform-poll-wizard-network',
							'powerform_page_powerform-poll-view',
							'powerform_page_powerform-poll-view-network',
							'powerform_page_powerform-nowrong-wizard',
							'powerform_page_powerform-nowrong-wizard-network',
							'powerform_page_powerform-knowledge-wizard',
							'powerform_page_powerform-knowledge-wizard-network',
							'powerform_page_powerform-quiz-view',
							'powerform_page_powerform-quiz-view-network',
							'powerform_page_powerform-entries',
							'powerform_page_powerform-entries-network',
							'powerform_page_powerform-integrations',
							'powerform_page_powerform-integrations-network'
						),
						array( 'after', '.sui-wrap .sui-header' ) // selector
					);

				}

			}*/

		}

		/**
		 * Load language files
		 *
		 * @since 1.0
		 */
		private function load_textdomain() {
			load_plugin_textdomain( 'powerform', false, 'powerform/languages' );
		}

		/**
		 * Check if Dash plugin installed and full membership
		 *
		 * @since 1.6
		 * @return bool
		 */
		public static function is_psource_member() {
			if ( function_exists( 'is_psource_member' ) ) {
				return is_psource_member();
			}

			return false;
		}
	}
}

if ( ! function_exists( 'powerform' ) ) {
	function powerform() {
		return Powerform::get_instance();
	}

	/**
	 * Init the plugin and load the plugin instance
	 *
	 * @since 1.0
	 */
	add_action( 'plugins_loaded', 'powerform' );
}

if ( ! function_exists( 'powerform_plugin_url' ) ) {
	/**
	 * Return plugin URL
	 *
	 * @since 1.0
	 * @return string
	 */
	function powerform_plugin_url() {
		return trailingslashit( plugin_dir_url( __FILE__ ) );
	}
}

if ( ! function_exists( 'powerform_plugin_dir' ) ) {
	/**
	 * Return plugin path
	 *
	 * @since 1.0
	 * @return string
	 */
	function powerform_plugin_dir() {
		return trailingslashit( plugin_dir_path( __FILE__ ) );
	}
}

if ( ! function_exists( 'powerform_addons_dir' ) ) {
	/**
	 * Return plugin path
	 *
	 * @since 1.0.5
	 * @return string
	 */
	function powerform_addons_dir() {
		return trailingslashit( powerform_plugin_dir() . 'addons' );
	}
}
