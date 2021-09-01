<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Custom_Form_Admin
 *
 * @property Powerform_Custom_Form module
 * @since 1.0
 */
class Powerform_Custom_Form_Admin extends Powerform_Admin_Module {

	/**
	 * Init module admin
	 *
	 * @since 1.0
	 */
	public function init() {
		$this->module       = Powerform_Custom_Form::get_instance();
		$this->page         = 'powerform-cform';
		$this->page_edit    = 'powerform-cform-wizard';
		$this->page_entries = 'powerform-cform-view';
	}

	/**
	 * Include required files
	 *
	 * @since 1.0
	 */
	public function includes() {
		include_once dirname( __FILE__ ) . '/admin-page-new.php';
		include_once dirname( __FILE__ ) . '/admin-page-view.php';
		include_once dirname( __FILE__ ) . '/admin-page-entries.php';
		include_once dirname( __FILE__ ) . '/admin-renderer-entries.php';
	}

	/**
	 * Add module pages to Admin
	 *
	 * @since 1.0
	 */
	public function add_menu_pages() {
		new Powerform_CForm_Page( $this->page, 'custom-form/list', __( 'Formulare', Powerform::DOMAIN ), __( 'Formulare', Powerform::DOMAIN ), 'powerform' );
		new Powerform_CForm_New_Page( $this->page_edit, 'custom-form/wizard', __( 'Formular bearbeiten', Powerform::DOMAIN ), __( 'Neues benutzerdefiniertes Formular', Powerform::DOMAIN ), 'powerform' );
		new Powerform_CForm_View_Page( $this->page_entries, 'custom-form/entries', __( 'Einsendungen:', Powerform::DOMAIN ), __( 'Benutzerdefiniertes Formular anzeigen', Powerform::DOMAIN ), 'powerform' );
	}

	/**
	 * Remove necessary pages from menu
	 *
	 * @since 1.0
	 */
	public function hide_menu_pages() {
		remove_submenu_page( 'powerform', $this->page_edit );
		remove_submenu_page( 'powerform', $this->page_entries );
	}

	/**
	 * Pass module defaults to JS
	 *
	 * @since 1.0
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function add_js_defaults( $data ) {
		$model = null;
		if ( $this->is_admin_wizard() ) {
			$data['application'] = 'builder';

			if ( empty( $id ) ) {
				$id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : null;
			}

			if ( ! is_null( $id ) ) {
				$data['formNonce'] = wp_create_nonce( 'powerform_save_builder_fields' );
				$model             = Powerform_Custom_Form_Model::model()->load( $id );
			}

			$wrappers = array();
			if ( is_object( $model ) ) {
				$wrappers = $model->get_fields_grouped();
			}

			// Load stored record
			$settings = apply_filters( 'powerform_form_settings', $this->get_form_settings( $model ), $model, $data, $this );

			if ( isset( $model->settings['form-type'] ) && 'registration' === $model->settings['form-type'] ) {
				$notifications = $this->get_registration_form_notifications( $model );
			} else {
				$notifications = $this->get_form_notifications( $model );
			}

			$form_id     = isset( $model->id ) ? $model->id : 0;
			$form_name   = isset( $model->name ) ? $model->name : '';
			$form_status = isset( $model->status ) ? $model->status : 'draft';

			$notifications = apply_filters( 'powerform_form_notifications', $notifications, $model, $data, $this );
			$data['currentForm'] = array(
				'wrappers'      => $wrappers,
				'settings'      => array_merge(
					array(
						'pagination-header' => 'nav',
						'paginationData'    => array(
							'pagination-header-design' => 'show',
							'pagination-header'        => 'nav',
						),
					),
					$settings,
					array(
						'form_id'     => $form_id,
						'form_name'   => $form_name,
						'form_status' => $form_status,
					)
				),
				'notifications' => $notifications,
			);
		}

		$data['modules']['custom_form'] = array(
			'templates'     => $this->module->get_templates(),
			'new_form_url'  => menu_page_url( $this->page_edit, false ),
			'form_list_url' => menu_page_url( $this->page, false ),
			'preview_nonce' => wp_create_nonce( 'powerform_popup_preview_cforms' ),
		);

		return apply_filters( 'powerform_form_admin_data', $data, $model, $this );
	}

	/**
	 * Localize module
	 *
	 * @since 1.0
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function add_l10n_strings( $data ) {
		$data['custom_form'] = array(
			'popup_label' => __( 'Wähle Formulartyp', Powerform::DOMAIN ),
		);

		$data['builder'] = array(
			"save" => __( "Speichern", Powerform::DOMAIN ),
		);

		$data['product'] = array(
			"add_variations" => __( "Füge einige Variationen Deines Produkts hinzu.", Powerform::DOMAIN ),
			"use_list"       => __( "In Liste anzeigen?", Powerform::DOMAIN ),
			"add_variation"  => __( "Variation hinzufügen", Powerform::DOMAIN ),
			"image"          => __( "Bild", Powerform::DOMAIN ),
			"name"           => __( "Name", Powerform::DOMAIN ),
			"price"          => __( "Preis", Powerform::DOMAIN ),
		);

		$data['appearance'] = array(
			"customize_typography"        => __( "Passe Typografie an", Powerform::DOMAIN ),
			"custom_font_family"          => __( "Gib den Namen der benutzerdefinierten Schriftfamilie ein", Powerform::DOMAIN ),
			"custom_font_placeholder"     => __( "Z.B. 'Arial', sans-serif", Powerform::DOMAIN ),
			"custom_font_description"     => __( "Gib den Namen der Schriftfamilie wie in CSS ein", Powerform::DOMAIN ),
			"font_family"                 => __( "Schriftfamilie", Powerform::DOMAIN ),
			"font_size"                   => __( "Schriftgröße", Powerform::DOMAIN ),
			"font_weight"                 => __( "Schriftgewicht", Powerform::DOMAIN ),
			"select_font"                 => __( "Schriftart auswählen", Powerform::DOMAIN ),
			"custom_font"                 => __( "Benutzerdefinierte Schriftart", Powerform::DOMAIN ),
			"minutes"                     => __( "Minute(n)", Powerform::DOMAIN ),
			"hours"                       => __( "Stunde(n)", Powerform::DOMAIN ),
			"days"                        => __( "Tag(e)", Powerform::DOMAIN ),
			"weeks"                       => __( "Woche(n)", Powerform::DOMAIN ),
			"months"                      => __( "Monate(n)", Powerform::DOMAIN ),
			"years"                       => __( "Jahr(e)", Powerform::DOMAIN ),
		);

		$data['tab_appearance'] = array(
			"basic_selectors"                => __( "Grundlegende Selektoren", Powerform::DOMAIN ),
			"advanced_selectors"             => __( "Erweiterte Selektoren", Powerform::DOMAIN ),
			"pagination_selectors"           => __( "Paginierungsselektoren", Powerform::DOMAIN ),
		);

		return $data;
	}

	/**
	 * Return template
	 *
	 * @since 1.0
	 * @return Powerform_Template|false
	 */
	private function get_template() {
		if ( isset( $_GET['template'] ) )  {
			$id = trim( sanitize_text_field( $_GET['template'] ) );
		} else {
			$id = 'blank';
		}

		foreach ( $this->module->templates as $key => $template ) {
			if ( $template->options['id'] === $id ) {
				return $template;
			}
		}

		return false;
	}

	/**
	 * Return Form Settins
	 *
	 * @since 1.1
	 *
	 * @param Powerform_Custom_Form_Model $form
	 *
	 * @return mixed
	 */
	public function get_form_settings( $form ) {

		if ( ! isset( $form ) ) {
			$form = new stdClass();
		}

		// If not using the new "submission-behaviour" setting, set it according to the previous settings
		if ( ! isset( $form->settings['submission-behaviour'] ) ) {
			$redirect = ( isset( $form->settings['redirect'] ) && filter_var( $form->settings['redirect'], FILTER_VALIDATE_BOOLEAN ) );
			$thankyou = ( isset( $form->settings['thankyou'] ) && filter_var( $form->settings['thankyou'], FILTER_VALIDATE_BOOLEAN ) );

			if ( ! $redirect && ! $thankyou ) {
				$form->settings['submission-behaviour'] = 'behaviour-thankyou';
			} elseif ( $thankyou ) {
				$form->settings['submission-behaviour'] = 'behaviour-thankyou';
			} elseif ( $redirect ) {
				$form->settings['submission-behaviour'] = 'behaviour-redirect';
			}
		}

		if ( $this->has_stripe_or_paypal( $form ) && $this->is_ajax_submit( $form ) ) {
			if ( isset( $form->settings['submission-behaviour'] ) && "behaviour-thankyou" === $form->settings['submission-behaviour'] ) {
				$form->settings['submission-behaviour'] = 'behaviour-hide';
			}
		}

		return $form->settings;
	}

	/**
	 * Return Form notifications
	 *
	 * @since 1.1
	 *
	 * @param Powerform_Custom_Form_Model|null $form
	 *
	 * @return mixed
	 */
	public function get_form_notifications( $form ) {
		if ( ! isset( $form ) || ! isset( $form->notifications ) ) {
			return array(
				array(
					'slug'             => 'notification-1234-4567',
					'label'            => 'Admin Email',
					'email-recipients' => 'default',
					'recipients'       => get_option( 'admin_email' ),
					'email-subject'    => __( "Neuer Formulareintrag #{submission_id} für {form_name}", Powerform::DOMAIN ),
					'email-editor'     => __( "Du hast ein neues Webseiten-Formular eingereicht: <br/> {all_fields} <br/>---<br/> Diese Nachricht wurde gesendet von {site_url}.", Powerform::DOMAIN ),
					'email-attachment' => "true",
				)
			);
		}

		return $form->notifications;
	}

	/**
	 * Get Registration Form notifications
	 *
	 * @since 1.11
	 *
	 * @param Powerform_Custom_Form_Model|null $form
	 * @param Powerform_Template|null          $template
	 *
	 * @return mixed
	 */
	public function get_registration_form_notifications( $form, $template = null ) {
		if ( ! isset( $form ) || ! isset( $form->notifications ) ) {
			$msg_footer = __( 'Diese Nachricht wurde gesendet von {site_url}', Powerform::DOMAIN );
			//For admin
			$message = __( "Registrierung neuer Benutzer auf Deiner Webseite {site_url}: <br/><br/> {all_fields} <br/><br/> Klicke {submission_url} um die Einsendung anzuzeigen.<br/>", Powerform::DOMAIN );
			$message .= "<br/>---<br/>";
			$message .= $msg_footer;

			$message_method_email = $message;

			$message_method_manual = __( "Registrierung neuer Benutzer auf Deiner Webseite {site_url}: <br/><br/> {all_fields} <br/><br/> Das Konto ist noch nicht aktiviert und bedarf Deiner Zustimmung. Um dieses Konto zu aktivieren, klicke auf den unten stehenden Link.", Powerform::DOMAIN );
			$message_method_manual .= "<br/>{account_approval_link} <br/><br/>";
			$message_method_manual .= __( "Klicke {submission_url} um die Einsendung im Dashboard Deiner Webseite anzuzeigen.<br/><br/>", Powerform::DOMAIN );
			$message_method_manual .= $msg_footer;

			$notifications[] = array(
				'slug'             => 'notification-1111-1111',
				'label'            => __( 'Admin Email', Powerform::DOMAIN ),
				'email-recipients' => 'default',
				'recipients'       => get_option( 'admin_email' ),
				'email-subject'    => __( 'Registrierung neuer Benutzer auf {site_url}', Powerform::DOMAIN ),
				'email-editor'     => $message,

				'email-subject-method-email'  => __( 'Registrierung neuer Benutzer auf {site_url}', Powerform::DOMAIN ),
				'email-editor-method-email'   => $message_method_email,
				'email-subject-method-manual' => __( 'Registrierung neuer Benutzer auf {site_url} benötigt Genehmigung.', Powerform::DOMAIN ),
				'email-editor-method-manual'  => $message_method_manual,
			);
			if ( ! is_null( $template )) {
				$email = $this->get_registration_form_customer_email_slug( $template );
			} else {
				$email = $this->get_registration_form_customer_email_slug( $form );
			}
			//For customer
			$message  = __( "Dein neues Konto auf unserer Webseite {site_title} ist einsatzbereit. Hier sind Deine Daten: <br/><br/> {all_fields} <br/><br/>", Powerform::DOMAIN );
			$message .= sprintf( __( 'Melde Dich <a href="%s">hier</a> in Deinem neuen Konto an.', Powerform::DOMAIN ), wp_login_url() );
			$message .= "<br/><br/>---<br/>";
			$message .= $msg_footer;

			$message_method_email = __( "Hallo {username} <br/><br/>", Powerform::DOMAIN );
			$message_method_email .= __( 'Vielen Dank, dass Du Dich auf unserer Webseite angemeldet hast. Du bist einen Schritt von der Aktivierung Deines Kontos entfernt. ', Powerform::DOMAIN );
			$message_method_email .= __( "Wir haben Dir eine weitere E-Mail mit einem Bestätigungslink gesendet. Bitte klicke auf diesen Link, um Dein Konto zu aktivieren.<br/><br/>", Powerform::DOMAIN );
			$message_method_email .= $msg_footer;

			$message_method_manual = __( "Dein neues Konto auf {site_title} wird überprüft.<br/>", Powerform::DOMAIN );
			$message_method_manual .= __( "Du erhältst eine weitere E-Mail, sobald der Seiten-Administrator Dein Konto genehmigt hat. Danach solltest Du Dich in Deinem Konto anmelden können.", Powerform::DOMAIN );
			$message_method_manual .= "<br/><br/>---<br/>";
			$message_method_manual .= $msg_footer;

			$notifications[] = array(
				'slug'             => 'notification-1111-1112',
				'label'            => __( 'Benutzerbestätigungs-E-Mail', Powerform::DOMAIN ),
				'email-recipients' => 'default',
				'recipients'       => $email,
				'email-subject'    => __( 'Dein neues Konto auf {site_title}', Powerform::DOMAIN ),
				'email-editor'     => $message,

				'email-subject-method-email'  => __( 'Aktiviere Dein Konto auf {site_url}', Powerform::DOMAIN ),
				'email-editor-method-email'   => $message_method_email,
				'email-subject-method-manual' => __( 'Dein neues Konto auf {site_title} wird überprüft.', Powerform::DOMAIN ),
				'email-editor-method-manual'  => $message_method_manual,
			);

			return $notifications;
		}

		return $form->notifications;
	}

	/**
	 * Get customer email as field slug
	 *
	 * @since 1.11
	 *
	 * @param Powerform_Custom_Form_Model|Powerform_Template $form
	 * @param string                                           $default
	 *
	 * @return string
	 */
	public function get_registration_form_customer_email_slug( $form, $default = '{email-1}' ) {
		if ( isset( $form->settings['registration-email-field'] ) && ! empty( $form->settings['registration-email-field'] ) ) {
			$email = $form->settings['registration-email-field'];
			if ( false === strpos( $email, '{' ) ) {
				$email = '{' . $email . '}';
			}

			return $email;
		}

		return $default;
	}

	/*
	 * Check if form has stripe or paypal field
	 *
	 * @since 1.9.3
	 * @return bool
	 */
	public function has_stripe_or_paypal( $form ) {
		$fields = isset( $form->fields ) ? $form->fields : array();

		foreach ( $fields as $field ) {
			$field = $field->to_formatted_array();
			if ( isset( $field['type'] ) && ( 'stripe' === $field['type'] || 'paypal' === $field['type'] ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if submit is handled with AJAX
	 *
	 * @since 1.9.3
	 *
	 * @return bool
	 */
	public function is_ajax_submit( $form ) {
		$form_settings  = $form->settings;

		if ( ! isset( $form_settings['enable-ajax'] ) || empty( $form_settings['enable-ajax'] ) ) {
			return false;
		}

		return filter_var( $form_settings['enable-ajax'], FILTER_VALIDATE_BOOLEAN );
	}

	/**
	 * Form default data
	 *
	 * @param $name
	 * @param array $settings
	 *
	 * @return array
	 */
	public function get_default_settings( $name, $settings = array() ) {
		return array_merge(
			array(
				'formName'             => $name,
				'pagination-header'    => 'nav',
				'version'              => POWERFORM_VERSION,
				'form-border-style'    => 'solid',
				'form-padding'         => '',
				'form-border'          => '',
				'fields-style'         => 'open',
				'validation'           => 'on_submit',
				'form-style'           => 'default',
				'enable-ajax'          => 'true',
				'autoclose'            => 'true',
				'submission-indicator' => 'show',
				'indicator-label'      => __( 'Einreichen...', Powerform::DOMAIN ),
				'paginationData'       => array(
					'pagination-header-design' => 'show',
					'pagination-header'        => 'nav',
				),
			),
			$settings
		);
	}

	/**
	 * Create quiz module
	 *
	 * @since 1.14
	 *
	 * @return no return
	 */
	public function create_module() {
		$model = null;

		if ( $this->is_admin_wizard() ) {
			$data['application'] = 'builder';

			if ( ! self::is_edit() ) {
				$settings      = array();

				// Create new model
				$model = new Powerform_Custom_Form_Model();

				// Save nonce
				$data['formNonce'] = wp_create_nonce( 'powerform_save_builder_fields' );

				// Load settings from template
				$template = $this->get_template();

				$name = '';
				if ( isset( $_GET['name'] ) ) { // WPCS: CSRF ok.
					$name = sanitize_text_field( $_GET['name'] );
				}

				if ( isset( $model->notifications ) ) {
					unset( $model->notifications );
				}

				// Setup notifications
				if ( isset( $template->settings['form-type'] ) && in_array( $template->settings['form-type'], array(
						'registration',
						'login'
					) ) ) {
					$notifications = 'registration' === $template->settings['form-type']
						? $this->get_registration_form_notifications( $model, $template )
						: array();
				} else {
					$notifications = $this->get_form_notifications( $model );
				}

				// If template, load from file
				if ( $template ) {
					$settings = $this->get_default_settings( $name, $template->settings );

					// Setup template fields
					foreach ( $template->fields as $row ) {
						foreach ( $row['fields'] as $f ) {
							$field          = new Powerform_Form_Field_Model();
							$field->form_id = $row['wrapper_id'];
							$field->slug    = $f['element_id'];
							unset( $f['element_id'] );
							$field->import( $f );
							$model->add_field( $field );
						}
					}
				} else {
					$settings = $this->get_default_settings( $name, array() );
				}

				$model->name          = $name;
				$model->notifications = $notifications;

				// form name & version
				$settings['formName'] = $name;
				$settings['version']  = POWERFORM_VERSION;

				// settings
				$model->settings = $settings;

				// status
				$model->status = Powerform_Custom_Form_Model::STATUS_DRAFT;

				// Save data
				$id = $model->save();

				$wizard_url = admin_url( 'admin.php?page=powerform-cform-wizard&id=' . $id );

				wp_safe_redirect( $wizard_url );
			}
		}
	}
}
