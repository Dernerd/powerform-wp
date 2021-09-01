<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Template_Contact_Form
 *
 * @since 1.0
 */
class Powerform_Template_Registration extends Powerform_Template {

	/**
	 * Template defaults
	 *
	 * @since 1.0
	 * @return array
	 */
	public function defaults() {
		return array(
			'id'          => 'registration',
			'name'        => __( 'Benutzer Registration', Powerform::DOMAIN ),
			'description' => __( "Ein einfaches Kontaktformular, mit dem Deine Benutzer Dich kontaktieren können", Powerform::DOMAIN ),
			'icon'        => 'profile-male',
			'priortiy'    => 5,
		);
	}

	/**
	 * Template fields
	 *
	 * @since 1.0
	 * @return array
	 */
	public function fields() {
		return array(
			array(
				'wrapper_id' => 'wrapper-1511347711918-1669',
				'fields'     => array(
					array(
						'element_id'        => 'text-1',
						'type'              => 'text',
						'cols'              => '12',
						'required'          => 'true',
						'field_label'       => __( 'Nutzername', Powerform::DOMAIN ),
						'placeholder'       => 'Gib den Benutzernamen ein',
					),
				),
			),
			array(
				'wrapper_id' => 'wrapper-1511789211918-1741',
				'fields'     => array(
					array(
						'element_id'        => 'email-1',
						'type'              => 'email',
						'cols'              => '12',
						'required'          => 'true',
						'required_message'  => __( 'Dieses Feld wird benötigt. Bitte gib eine E-Mail-Adresse ein.', Powerform::DOMAIN ),
						'field_label'       => __( 'Email', Powerform::DOMAIN ),
						'placeholder'       => __( 'Z.B. john@doe.com', Powerform::DOMAIN ),
						'validation'        => 'true',
						'validation_message'=> __( 'Dies ist keine gültige E-Mail.', Powerform::DOMAIN ),
					),
				),
			),
			array(
				'wrapper_id' => 'wrapper-1511347712118-1739',
				'fields'     => array(
					array(
						'element_id'                   => 'password-1',
						'type'                         => 'password',
						'cols'                         => '12',
						'required'                     => 'true',
						'required_message'             => __( 'Dein Passwort wird benötigt.', Powerform::DOMAIN ),
						'field_label'                  => __( 'Passwort', Powerform::DOMAIN ),
						'placeholder'                  => __( 'Gib Dein Passwort ein', Powerform::DOMAIN ),
						'description'                  => '',
						'confirm-password-label'       => __( 'Passwort bestätigen', Powerform::DOMAIN ),
						'confirm-password-placeholder' => __( 'Bestätige neues Passwort', Powerform::DOMAIN ),
						'strength'                     => 'none',
						'strength_validation_message'  => __( 'Dein Passwort erfüllt nicht die Mindestanforderungen an die Stärke. Wir empfehlen die Verwendung von 8 oder mehr Zeichen mit einer Mischung aus Buchstaben, Zahlen und Symbolen.', Powerform::DOMAIN ),
						'validation'                   => 'true',
						'validation_message'           => __( 'Deine Passwörter stimmen nicht überein.', Powerform::DOMAIN ),
						'required_confirm_message'     => __( 'Du musst Dein gewähltes Passwort bestätigen.', Powerform::DOMAIN ),
					),
				),
			),
		);
	}

	/**
	 * Template settings
	 *
	 * @since 1.0
	 * @return array
	 */
	public function settings() {
		global $wp_rewrite;

		$login_url = is_null( $wp_rewrite ) ? site_url( 'wp-login.php', 'login' ) : wp_login_url();
		$pages     = $this->get_pages();

		return array(
			"form-type"                        => "registration",
			"submission-behaviour"             => "behaviour-thankyou",
			"thankyou-message"                 => sprintf( __( 'Kontoregistrierung erfolgreich. Klicke <a href="%s">hier</a>, um Dich bei Deinem Konto anzumelden.', Powerform::DOMAIN ), $login_url ),
			"email-thankyou-message"           => __( 'Kontoregistrierung erfolgreich. Bitte überprüfe Deinen E-Mail-Posteingang, um Dein neues Konto zu aktivieren.', Powerform::DOMAIN ),
			"manual-thankyou-message"          => __( 'Kontoregistrierung erfolgreich. Ein Webseiten-Administrator muss Dein Konto genehmigen, bevor Du Dich anmelden kannst. Du erhältst eine E-Mail, wenn Dein Konto aktiviert wird.', Powerform::DOMAIN ),
			'submitData'                       => array(
				"custom-submit-text"          => __( "Registrieren", Powerform::DOMAIN ),
				"custom-invalid-form-message" => __( "Fehler: Dein Formular ist ungültig, bitte behebe die Fehler!", Powerform::DOMAIN ),
			),
			'enable-ajax'                      => 'true',
			'validation-inline'                => true,
			'fields-style'                     => 'open',
			"form-expire"                      => 'no_expire',
			'use-admin-email'                  => 'true',
			// Main container
			'form-padding-top'                 => '0',
			'form-padding-right'               => '0',
			'form-padding-bottom'              => '0',
			'form-padding-left'                => '0',
			'form-border-width'                => '0',
			'form-border-style'                => 'none',
			'form-border-radius'               => '0',
			// Typography - Label
			'cform-label-font-family'          => 'Roboto',
			'cform-label-custom-family'        => '',
			'cform-label-font-size'            => '12',
			'cform-label-font-weight'          => 'bold',
			// Typography - Section Title
			'cform-title-font-family'          => 'Roboto',
			'cform-title-custom-family'        => '',
			'cform-title-font-size'            => '45',
			'cform-title-font-weight'          => 'normal',
			'cform-title-text-align'           => 'left',
			// Typography - Section Subtitle
			'cform-subtitle-font-family'       => 'Roboto',
			'cform-subtitle-custom-font'       => '',
			'cform-subtitle-font-size'         => '18',
			'cform-subtitle-font-weight'       => 'normal',
			'cform-subtitle-text-align'        => 'left',
			// Typography - Input & Textarea
			'cform-input-font-family'          => 'Roboto',
			'cform-input-custom-font'          => '',
			'cform-input-font-size'            => '16',
			'cform-input-font-weight'          => 'normal',
			// Typography - Radio & Checkbox
			'cform-radio-font-family'          => 'Roboto',
			'cform-radio-custom-font'          => '',
			'cform-radio-font-size'            => '14',
			'cform-radio-font-weight'          => 'normal',
			// Typography - Select
			'cform-select-font-family'         => 'Roboto',
			'cform-select-custom-family'       => '',
			'cform-select-font-size'           => '16',
			'cform-select-font-weight'         => 'normal',
			// Typography - Multi Select
			'cform-multiselect-font-family'    => 'Roboto',
			'cform-multiselect-custom-font'    => '',
			'cform-multiselect-font-size'      => '16',
			'cform-multiselect-font-weight'    => 'normal',
			// Typography - Dropdown
			'cform-dropdown-font-family'       => 'Roboto',
			'cform-dropdown-custom-font'       => '',
			'cform-dropdown-font-size'         => '16',
			'cform-dropdown-font-weight'       => 'normal',
			// Typography - Calendar
			'cform-calendar-font-family'       => 'Roboto',
			'cform-calendar-custom-font'       => '',
			'cform-calendar-font-size'         => '13',
			'cform-calendar-font-weight'       => 'normal',
			// Typography - Buttons
			'cform-button-font-family'         => 'Roboto',
			'cform-button-custom-font'         => '',
			'cform-button-font-size'           => '14',
			'cform-button-font-weight'         => '500',
			// Typography - Timeline
			'cform-timeline-font-family'       => 'Roboto',
			'cform-timeline-custom-font'       => '',
			'cform-timeline-font-size'         => '12',
			'cform-timeline-font-weight'       => 'normal',
			// Typography - Pagination
			'cform-pagination-font-family'     => '',
			'cform-pagination-custom-font'     => '',
			'cform-pagination-font-size'       => '16',
			'cform-pagination-font-weight'     => 'normal',
			'payment_require_ssl'              => 'true,',
			'submission-file'                  => 'delete',
			'options'                          => array(),
			// Site Registration
			'site-registration'                => 'enable',
			'site-registration-name-field'     => 'text-1',
			'site-registration-title-field'    => 'text-1',
			'site-registration-role-field'     => 'administrator',
			// Activation Method
			'activation-method'                => 'default',
			'activation-email'                 => 'default',
			// Default Meta Keys
			'registration-username-field'      => 'text-1',
			'registration-email-field'         => 'email-1',
			'registration-password-field'      => 'password-1',
			'registration-role-field'          => 'subscriber',
			//Redirected page for Email-activation method
			'confirmation-page'                => ! empty( $pages ) ? $pages[0]->ID : '',
			// Additional settings
			'automatic-login'                  => false,
			'hide-registration-form'           => true,
			'hidden-registration-form-message' => '',
			'autoclose'                        => false,
		);
	}

	/**
	 * Return published pages
	 *
	 * @since 1.11
	 *
	 * @return mixed
	 */
	private function get_pages() {
		global $wpdb;

		$sql = "SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = 'page' AND post_status = 'publish' ORDER BY post_title ASC";
		$pages = $wpdb->get_results( $sql );

		return $pages;
	}
}
