<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Admin
 *
 * @since 1.0
 */
class Powerform_Admin {

	/**
	 * @var array
	 */
	public $pages = array();

	/**
	 * Powerform_Admin constructor.
	 */
	public function __construct() {
		$this->includes();

		// Init admin pages
		add_action( 'admin_menu', array( $this, 'add_dashboard_page' ) );
		add_action( 'admin_notices', array( $this, 'show_stripe_updated_notice' ) );
		add_action( 'admin_notices', array( $this, 'show_rating_notice' ) );
		add_action( 'admin_notices', array( $this, 'show_cf7_importer_notice' ) );

		// Add plugin action links
		add_filter( 'plugin_action_links_' . POWERFORM_PLUGIN_BASENAME, array( $this, 'add_plugin_action_links' ) );
		if ( powerform_is_networkwide() ) {
			add_filter( 'network_admin_plugin_action_links_' . POWERFORM_PLUGIN_BASENAME, array(
				$this,
				'add_plugin_action_links'
			) );
		}
		// Add links next to plugin details
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 3 );

		// Init Admin AJAX class
		new Powerform_Admin_AJAX();

		/**
		 * Triggered when Admin is loaded
		 */
		do_action( 'powerform_admin_loaded' );
	}

	/**
	 * Include required files
	 *
	 * @since 1.0
	 */
	private function includes() {
		// Admin pages
		include_once powerform_plugin_dir() . 'admin/pages/dashboard-page.php';
		include_once powerform_plugin_dir() . 'admin/pages/entries-page.php';
		include_once powerform_plugin_dir() . 'admin/pages/integrations-page.php';
		include_once powerform_plugin_dir() . 'admin/pages/settings-page.php';
		include_once powerform_plugin_dir() . 'admin/pages/upgrade-page.php';

		// Admin AJAX
		include_once powerform_plugin_dir() . 'admin/classes/class-admin-ajax.php';

		// Admin Data
		include_once powerform_plugin_dir() . 'admin/classes/class-admin-data.php';

		// Admin l10n
		include_once powerform_plugin_dir() . 'admin/classes/class-admin-l10n.php';

		if ( powerform_is_import_plugin_enabled( 'cf7' ) ) {
			//CF7 Import
			include_once powerform_plugin_dir() . 'admin/classes/thirdparty-importers/class-importer-cf7.php';
		}

		if ( powerform_is_import_plugin_enabled( 'ninjaforms' ) ) {
			//Ninjaforms Import
			include_once powerform_plugin_dir() . 'admin/classes/thirdparty-importers/class-importer-ninja.php';
		}

		if ( powerform_is_import_plugin_enabled( 'gravityforms' ) ) {
			//Gravityforms CF7 Import
			include_once powerform_plugin_dir() . 'admin/classes/thirdparty-importers/class-importer-gravity.php';
		}

	}

	/**
	 * Initialize Dashboard page
	 *
	 * @since 1.0
	 */
	public function add_dashboard_page() {
		$title = __( 'Powerform', Powerform::DOMAIN );
		if ( POWERFORM_PRO ) {
			$title = __( 'Powerform', Powerform::DOMAIN );
		}

		$this->pages['powerform']           = new Powerform_Dashboard_Page( 'powerform', 'dashboard', $title, $title, false, false );
		$this->pages['powerform-dashboard'] = new Powerform_Dashboard_Page( 'powerform', 'dashboard', __( 'Powerform Dashboard', Powerform::DOMAIN ), __( 'Dashboard', Powerform::DOMAIN ), 'powerform' );
	}

	/**
	 * Add Integrations page
	 *
	 * @since 1.1
	 */
	public function add_integrations_page() {
		add_action( 'admin_menu', array( $this, 'init_integrations_page' ) );
	}

	/**
	 * Initialize Integrations page
	 *
	 * @since 1.1
	 */
	public function init_integrations_page() {
		$this->pages['powerform-integrations'] = new Powerform_Integrations_Page(
			'powerform-integrations',
			'integrations',
			__( 'Integrationen', Powerform::DOMAIN ),
			__( 'Integrationen', Powerform::DOMAIN ),
			'powerform'
		);

		//TODO: remove this after converted to JS
		$addons = Powerform_Addon_Loader::get_instance()->get_addons()->to_array();
		foreach ( $addons as $slug => $addon_array ) {
			$addon_class = powerform_get_addon( $slug );

			if ( $addon_class && is_callable( array( $addon_class, 'admin_hook_html_version' ) ) ) {
				call_user_func( array( $addon_class, 'admin_hook_html_version' ) );
			}
		}

	}

	/**
	 * Add Settings page
	 *
	 * @since 1.0
	 */
	public function add_settings_page() {
		add_action( 'admin_menu', array( $this, 'init_settings_page' ) );
	}

	/**
	 * Initialize Settings page
	 *
	 * @since 1.0
	 */
	public function init_settings_page() {
		$this->pages['powerform-settings'] = new Powerform_Settings_Page( 'powerform-settings', 'settings', __( 'Globale Einstellungen', Powerform::DOMAIN ), __( 'Einstellungen', Powerform::DOMAIN ), 'powerform' );
	}

	/**
	 * Add Entries page
	 *
	 * @since 1.0.5
	 */
	public function add_entries_page() {
		add_action( 'admin_menu', array( $this, 'init_entries_page' ) );
	}

	/**
	 * Initialize Entries page
	 *
	 * @since 1.0.5
	 */
	public function init_entries_page() {
		$this->pages['powerform-entries'] = new Powerform_Entries_Page(
			'powerform-entries',
			'entries',
			__( 'Powerform-Einsendungen', Powerform::DOMAIN ),
			__( 'Einsendungen', Powerform::DOMAIN ),
			'powerform'
		);
	}

	/**
	 * Add Powerform page
	 *
	 * @since 1.0
	 */
	public function add_upgrade_page() {
		add_action( 'admin_menu', array( $this, 'init_upgrade_page' ) );
	}

	/**
	 * Initialize Settings page
	 *
	 * @since 1.0
	 */
	public function init_upgrade_page() {
		$this->pages['powerform-upgrade'] = new Powerform_Upgrade_Page( 'powerform-upgrade', 'upgrade', __( 'Upgrade auf Powerform Pro', Powerform::DOMAIN ), __( 'Powerform', Powerform::DOMAIN ), 'powerform' );
	}

	/**
	 * Check if we have any Stripe form
	 *
	 * @since 1.9
	 *
	 * @return bool
	 */
	public function has_stripe_forms() {
		$forms = Powerform_Custom_Form_Model::model()->get_models_by_field( 'stripe-1' );

		if ( count( $forms ) > 0 ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if we have any old Stripe form
	 *
	 * @since 1.9
	 *
	 * @return bool
	 */
	public function has_old_stripe_forms() {
		$forms = Powerform_Custom_Form_Model::model()->get_models_by_field_and_version( 'stripe-1', '1.9-alpha.1' );

		if ( count( $forms ) > 0 ) {
			return true;
		}

		return false;
	}


	/**
	 * Show CF7 importer notice
	 *
	 * @since 1.11
	 */
	public function show_cf7_importer_notice() {
		$notice_dismissed = get_option( 'powerform_cf7_notice_dismissed', false );

		if ( $notice_dismissed ) {
			return;
		}

		if ( ! powerform_is_import_plugin_enabled( 'cf7' ) ) {
			return;
		}

		?>
        <div class="powerform-notice-cf7 powerform-notice notice notice-info"
             data-prop="powerform_cf7_notice_dismissed"
             data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_dismiss_notification' ) ); ?>">
            <p style="color: #1A2432; font-size: 14px; font-weight: bold;"><?php echo esc_html__( 'Powerform - Importiere Deine Contact Form 7-Formulare automatisch', Powerform::DOMAIN ); ?></p>

            <p style="color: #72777C; line-height: 22px;"><?php echo esc_html__( 'Wir haben festgestellt, dass das Contact Form 7 auf Deiner Webseite aktiv ist. Mit unserem integrierten Contact Form 7-Importer kannst Du Deine vorhandenen Formulare und die entsprechenden Plugin-Einstellungen von Contact Form 7 in Powerform importieren. Der Importeur unterstützt auch die am häufigsten verwendeten Add-Ons.', Powerform::DOMAIN ); ?></p>

            <p>
                <a href="<?php echo esc_url( menu_page_url( 'powerform-settings', false ) . '&section=import' ); ?>"
                   class="button button-primary"><?php esc_html_e( 'Importiere Contact Form 7 Formulare', Powerform::DOMAIN ); ?></a>
                <a href="#" class="dismiss-notice"
                   style="margin-left: 10px; text-decoration: none; color: #555; font-weight: 500;"><?php esc_html_e( 'Verwerfen', Powerform::DOMAIN ); ?></a>
            </p>

        </div>

        <script type="text/javascript">
            jQuery('.powerform-notice-cf7 .button-primary').on('click', function (e) {
                e.preventDefault();

                var $self = jQuery(this);
                var $notice = jQuery(e.currentTarget).closest('.powerform-notice');
                var ajaxUrl = '<?php echo powerform_ajax_url(); ?>';

                jQuery.post(
                    ajaxUrl,
                    {
                        action: 'powerform_dismiss_notification',
                        prop: $notice.data('prop'),
                        _ajax_nonce: $notice.data('nonce')
                    }
                ).always(function () {
                    location.href = $self.attr('href');
                });
            });

            jQuery('.powerform-notice-cf7 .dismiss-notice').on('click', function (e) {
                e.preventDefault();

                var $notice = jQuery(e.currentTarget).closest('.powerform-notice');
                var ajaxUrl = '<?php echo powerform_ajax_url(); ?>';

                jQuery.post(
                    ajaxUrl,
                    {
                        action: 'powerform_dismiss_notification',
                        prop: $notice.data('prop'),
                        _ajax_nonce: $notice.data('nonce')
                    }
                ).always(function () {
                    $notice.hide();
                });
            });
        </script>
		<?php
	}

	/**
	 * Show Stripe admin notice
	 *
	 * @since 1.9
	 */
	public function show_stripe_updated_notice() {
		$notice_dismissed = get_option( 'powerform_stripe_notice_dismissed', false );

		if ( $notice_dismissed ) {
			return;
		}

		if ( ! $this->has_old_stripe_forms() ) {
			return;
		}
		?>

		<div class="powerform-notice notice notice-warning" data-prop="powerform_stripe_notice_dismissed" data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_dismiss_notification' ) ); ?>">

			<p style="color: #72777C; line-height: 22px;"><?php echo sprintf( __( 'Um das Stipefeld von Powerform <a href="%s" target="_blank">SCA Compliant</a> zu machen, haben wir das Stripe Checkout-Modul durch Stripe Elements ersetzt, das ein Inline-Feld zum Sammeln der Kredit- oder Debitkartendaten Deines Kunden hinzufügt. Deine vorhandenen Formulare mit Stripefeld werden automatisch aktualisiert. Wir empfehlen jedoch, sie zu überprüfen, um sicherzustellen, dass alles ordnungsgemäß funktioniert.', Powerform::DOMAIN ), 'https://stripe.com/gb/guides/strong-customer-authentication' ); ?></p>

			<p>
				<a href="<?php echo esc_url( menu_page_url( 'powerform', false ) . '&show_stripe_dialog=true' ); ?>" class="button button-primary"><?php esc_html_e( 'Mehr erfahren', Powerform::DOMAIN ); ?></a>
				<a href="#" class="dismiss-notice" style="margin-left: 10px; text-decoration: none; color: #555; font-weight: 500;"><?php esc_html_e( 'Verwerfen', Powerform::DOMAIN ); ?></a>
			</p>

		</div>

		<script type="text/javascript">
			jQuery( '.powerform-notice .dismiss-notice' ).on( 'click', function( e ) {
				e.preventDefault();

				var $notice = jQuery( e.currentTarget ).closest( '.powerform-notice' );
				var ajaxUrl = '<?php echo powerform_ajax_url();// phpcs:ignore ?>';

				jQuery.post(
					ajaxUrl,
					{
						action: 'powerform_dismiss_notification',
						prop: $notice.data('prop'),
						_ajax_nonce: $notice.data('nonce')
					}
				).always( function() {
					$notice.hide();
				});
			});
		</script>
		<?php
	}

	/**
	 * Show rating admin notice
	 *
	 * @since 1.10
	 */
	public function show_rating_notice() {

		if ( POWERFORM_PRO ) {
			return;
		}

		$notice_success   = get_option( 'powerform_rating_success', false );
		$notice_dismissed = get_option( 'powerform_rating_dismissed', false );

		if ( $notice_dismissed || $notice_success ) {
			return;
		}
		$published_modules     = powerform_total_forms( 'publish' );
		$publish_later         = get_option( 'powerform_publish_rating_later', false );
		$publish_later_dismiss = get_option( 'powerform_publish_rating_later_dismiss', false );

		if ( ( ( 5 < $published_modules && 10 >= $published_modules ) && ! $publish_later ) || ( 10 < $published_modules && ! $publish_later_dismiss ) ) {

			$milestone = ( 10 >= $published_modules ) ? 5 : 10;
			?>

			<div id="powerform-free-publish-notice" class="powerform-rating-notice notice notice-info fui-wordpress-notice" data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_dismiss_notification' ) ); ?>">

				<p style="color: #72777C; line-height: 22px;"><?php printf( __( 'Genial! Du hast mehr als %d Module mit Powerform veröffentlicht. Hoffe es gefällt euch bisher. Wir haben unzählige Stunden damit verbracht, dieses kostenlose Plugin für Dich zu entwickeln, und wir würden uns sehr freuen, wenn Du uns eine Bewertung geben könntest, um uns zu helfen, das Wort zu verbreiten und unsere Motivation zu steigern.', Powerform::DOMAIN ), $milestone ); ?></p>

				<p>
					<a type="button" href="#" target="_blank" class="button button-primary button-large" data-prop="powerform_rating_success"><?php esc_html_e( 'Bewerte uns', Powerform::DOMAIN ); ?></a>

					<button type="button" class="button button-large" style="margin-left: 11px;" data-prop="<?php echo 10 > $published_modules ?  'powerform_publish_rating_later' : 'powerform_publish_rating_later_dismiss'; ?>"><?php esc_html_e( 'Vielleicht später', Powerform::DOMAIN ); ?></button>

					<a href="#" class="dismiss" style="margin-left: 11px; color: #555; line-height: 16px; font-weight: 500; text-decoration: none;" data-prop="powerform_rating_dismissed"><?php esc_html_e( 'Nein, Danke', Powerform::DOMAIN ); ?></a>
				</p>

            </div>

		<?php } else {

			$install_date = get_site_option( 'powerform_free_install_date', false );
			$days_later_dismiss = get_option( 'powerform_days_rating_later_dismiss', false );

			if ( $install_date && current_time( 'timestamp' ) > strtotime( '+7 days', $install_date ) && ! $publish_later && ! $publish_later_dismiss && ! $days_later_dismiss ) { ?>

                <div id="powerform-free-usage-notice"
                     class="powerform-rating-notice notice notice-info fui-wordpress-notice"
                     data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_dismiss_notification' ) ); ?>">

					<p style="color: #72777C; line-height: 22px;"><?php esc_html_e( 'Ausgezeichnet! Du verwendest Powerform jetzt schon eine Weile. Hoffe es gefällt euch bisher. Wir haben unzählige Stunden damit verbracht, dieses kostenlose Plugin für Dich zu entwickeln, und wir würden uns sehr freuen, wenn Du uns eine Bewertung geben könntest, um uns zu helfen, das Wort zu verbreiten und unsere Motivation zu steigern.', Powerform::DOMAIN ); ?></p>

                    <p>
                        <a type="button" href="#" target="_blank" class="button button-primary button-large"
                           data-prop="powerform_rating_success"><?php esc_html_e( 'Bewerte uns', Powerform::DOMAIN ); ?></a>

                        <a href="#" class="dismiss"
                           style="margin-left: 11px; color: #555; line-height: 16px; font-weight: 500; text-decoration: none;"
                           data-prop="powerform_days_rating_later_dismiss"><?php esc_html_e( 'Vielleicht später', Powerform::DOMAIN ); ?></a>
                    </p>

                </div>

				<?php
			}
		}

		?>

        <script type="text/javascript">
            jQuery('.powerform-rating-notice a, .powerform-rating-notice button').on('click', function (e) {
                e.preventDefault();

                var $notice = jQuery(e.currentTarget).closest('.powerform-rating-notice'),
                    prop = jQuery(this).data('prop'),
                    ajaxUrl = '<?php echo powerform_ajax_url(); ?>';

                if ('powerform_rating_success' === prop) {
                    window.open('https://g.page/N3rdsWork/review?gm', '_blank');
                }

                jQuery.post(
                    ajaxUrl,
                    {
                        action: 'powerform_dismiss_notification',
                        prop: prop,
                        _ajax_nonce: $notice.data('nonce')
                    }
                ).always(function () {
                    $notice.hide();
                });
            });
        </script>

	<?php }

	/**
	 * Show action links on the plugin screen.
	 *
	 * @since 1.13
	 *
	 * @param array $links Plugin Action links.
	 *
	 * @return mixed
	 */
	public function add_plugin_action_links( $links ) {
		// Settings link.
		if ( powerform_get_admin_cap() ) {
			$action_links['dashboard'] = '<a href="' . admin_url( 'admin.php?page=powerform-settings' ) . '" aria-label="' . esc_attr( __( 'Gehe zu Powerform-Einstellungen', Powerform::DOMAIN ) ) . '">' . esc_html__( 'Einstellungen', Powerform::DOMAIN ) . '</a>';
		}
		// Documentation link.
		$action_links['docs'] = '<a href="' . powerform_get_link( 'docs', 'powerform_pluginlist_docs' ) . '" aria-label="' . esc_attr( __( 'Docs', Powerform::DOMAIN ) ) . '" target="_blank">' . esc_html__( 'Docs', Powerform::DOMAIN ) . '</a>';

		// PSOURCE membership status.
		//$membership = powerform_membership_status();

		// Upgrade or Renew links.
		/*if ( ! POWERFORM_PRO || 'upgrade' === $membership ) {
			$action_links['upgrade'] = '<a href="' . powerform_get_link( 'plugin', 'powerform_pluginlist_upgrade' ) . '" aria-label="' . esc_attr( __( 'Upgrade to Powerform Pro', Powerform::DOMAIN ) ) . '" style="color: #8D00B1;" target="_blank">' . esc_html__( 'Upgrade', Powerform::DOMAIN ) . '</a>';
		} elseif ( 'expired' === $membership || 'free' === $membership ) {
			$action_links['renew'] = '<a href="' . powerform_get_link( 'plugin', 'powerform_pluginlist_renew' ) . '" aria-label="' . esc_attr( __( 'Renew Your Membership', Powerform::DOMAIN ) ) . '" style="color: #8D00B1;" target="_blank">' . esc_html__( 'Renew Membership', Powerform::DOMAIN ) . '</a>';
		}*/

		return array_merge( $action_links, $links );
	}

	/**
	 * Show row meta on the plugin screen.
	 *
	 * @since 1.13
	 *
	 * @param mixed $links Plugin Row Meta.
	 * @param mixed $file Plugin Base file.
	 * @param array $plugin_data Plugin data.
	 *
	 * @return array
	 */
	public function plugin_row_meta( $links, $file, $plugin_data ) {
		if ( POWERFORM_PLUGIN_BASENAME === $file ) {
			// Show network meta links only when activated network wide.
			if ( is_network_admin() && ! powerform_is_networkwide() ) {
				return $links;
			}

			// Change AuthorURI link.
			if ( isset( $links[1] ) ){
				$author_uri = POWERFORM_PRO ? 'https://n3rds.work/' : 'https://g.page/N3rdsWork/review?gm';
				$author_uri = sprintf(
					'<a href="%s" target="_blank">%s</a>',
					$author_uri,
					__( 'WMS N@W' )
				);
				$links[1] = sprintf( __( 'Von %s' ), $author_uri );
			}

			if ( ! POWERFORM_PRO ) {
				// Change AuthorURI link.
				if( isset( $links[2] ) && false === strpos( $links[2], 'target="_blank"' ) ) {
					if ( ! isset( $plugin_data['slug'] ) && $plugin_data['Name'] ) {
						$links[2] = sprintf(
							'<a href="%s" class="thickbox open-plugin-details-modal" aria-label="%s" data-title="%s">%s</a>',
							esc_url(
								network_admin_url(
									'plugin-install.php?tab=plugin-information&plugin=powerform' .
									'&TB_iframe=true&width=600&height=550'
								)
							),
							/* translators: %s: Plugin name. */
							esc_attr( sprintf( __( 'Weitere Informationen zu %s' ), $plugin_data['Name'] ) ),
							esc_attr( $plugin_data['Name'] ),
							__( 'Details anzeigen' )
						);
					} else {
						$links[2] = str_replace( 'href=', 'target="_blank" href=', $links[2] );
					}
				}
				$row_meta['rate']    = '<a href="' . esc_url( powerform_get_link( 'rate' ) ) . '" aria-label="' . esc_attr__( 'Bewerte WMS N@W', Powerform::DOMAIN ) . '" target="_blank">' . esc_html__( 'Bewerte WMS N@W', Powerform::DOMAIN ) . '</a>';
				$row_meta['support'] = '<a href="' . esc_url( powerform_get_link( 'support' ) ) . '" aria-label="' . esc_attr__( 'Support', Powerform::DOMAIN ) . '" target="_blank">' . esc_html__( 'Support', Powerform::DOMAIN ) . '</a>';
			} else {
				// Change 'Visit plugins' link to 'View details'.
				if ( isset( $links[2] ) && false !== strpos( $links[2], 'project/powerform' ) ) {
					$links[2] = sprintf(
						'<a href="%s" target="_blank">%s</a>',
						esc_url( powerform_get_link( 'pro_link', '', 'project/powerform-pro/' ) ),
						__( 'Details anzeigen' )
					);
				}
				//$row_meta['support'] = '<a href="' . esc_url( powerform_get_link( 'support' ) ) . '" aria-label="' . esc_attr__( 'Premium Support', Powerform::DOMAIN ) . '" target="_blank">' . esc_html__( 'Premium Support', Powerform::DOMAIN ) . '</a>';
			}
			//$row_meta['roadmap'] = '<a href="' . esc_url( powerform_get_link( 'roadmap' ) ) . '" aria-label="' . esc_attr__( 'Roadmap', Powerform::DOMAIN ) . '" target="_blank">' . esc_html__( 'Roadmap', Powerform::DOMAIN ) . '</a>';

			return array_merge( $links, $row_meta );
		}

		return $links;
	}
}
