<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Template_Contact_Form
 *
 * @since 1.0
 */
class Powerform_Template_Login extends Powerform_Template {

	/**
	 * Template defaults
	 *
	 * @since 1.0
	 * @return array
	 */
	public function defaults() {
		return array(
			'id'          => 'login',
			'name'        => __( 'Anmeldung', Powerform::DOMAIN ),
			'description' => __( "Ein einfaches Kontaktformular, mit dem Deine Benutzer Dich kontaktieren können", Powerform::DOMAIN ),
			'icon'        => 'profile-male',
			'priortiy'    => 6,
		);
	}

	/**
	 * Get url for lost password
	 *
	 * @since 1.12
	 * @param string
	 *
	 * @return string
	 */
	private function get_lostpassword_url( $redirect ) {
		global $wp_rewrite;

		if ( is_null( $wp_rewrite ) ) {
			$args                = array();
			$args['redirect_to'] = urlencode( $redirect );

			$lostpassword_url = add_query_arg( $args, network_site_url( 'wp-login.php?action=lostpassword', 'login' ) );
		} else {
			$lostpassword_url = wp_lostpassword_url( $redirect );
		}

		return $lostpassword_url;
	}

	/**
	 * Template fields
	 *
	 * @since 1.0
	 * @return array
	 */
	public function fields() {
		$lostpassword_url = $this->get_lostpassword_url( get_permalink() );

		return array(
			array(
				'wrapper_id' => 'wrapper-1511347711918-1669',
				'fields'     => array(
					array(
						'element_id'        => 'text-1',
						'type'              => 'text',
						'cols'              => '12',
						'required'          => 'true',
						'field_label'       => __( 'Benutzername oder E-mail Adresse', Powerform::DOMAIN ),
						'placeholder'       => __( 'Gib den Benutzernamen oder die E-Mail-Adresse ein', Powerform::DOMAIN ),
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
						'required_message'             => __( 'Dein Passwort wird benötigt', Powerform::DOMAIN ),
						'field_label'                  => __( 'Passwort', Powerform::DOMAIN ),
						'placeholder'                  => __( 'Gib Dein Passwort ein', Powerform::DOMAIN ),
						'description'                  => sprintf( __( '<a href="%s" title="Passwort verloren" target="_blank">Passwort vergessen?</a>', Powerform::DOMAIN ), $lostpassword_url ),
						'confirm-password-label'       => __( 'Kennwort bestätigen', Powerform::DOMAIN ),
						'confirm-password-placeholder' => __( 'Bestätige neues Passwort', Powerform::DOMAIN ),
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
		return array(
			'form-type'                     => 'login',
			'submission-behaviour'          => 'behaviour-redirect',
			'thankyou-message'              => __( 'Vielen Dank für Deine Kontaktaufnahme. Wir werden uns in Kürze bei Dir melden.', Powerform::DOMAIN ),
			'redirect-url'                  => admin_url(),
			'submitData'                    => array(
				'custom-submit-text'          => __( 'Anmeldung', Powerform::DOMAIN ),
				'custom-invalid-form-message' => __( 'Fehler: Dein Formular ist ungültig, bitte behebe die Fehler!', Powerform::DOMAIN ),
			),
			'enable-ajax'                   => 'true',
			'validation-inline'             => true,
			'fields-style'                  => 'open',
			'form-expire'                   => 'no_expire',
			'use-admin-email'               => 'true',
			'admin-email-title'             => '',
			'admin-email-editor'            => '',
			'admin-email-recipients'        => array(),
			'user-email-title'              => '',
			'user-email-editor'             => '',

			// Main container
			'form-padding-top'              => '0',
			'form-padding-right'            => '0',
			'form-padding-bottom'           => '0',
			'form-padding-left'             => '0',
			'form-border-width'             => '0',
			'form-border-style'             => 'none',
			'form-border-radius'            => '0',
			// Typography - Label
			'cform-label-font-family'       => 'Roboto',
			'cform-label-custom-family'     => '',
			'cform-label-font-size'         => '12',
			'cform-label-font-weight'       => 'bold',
			// Typography - Section Title
			'cform-title-font-family'       => 'Roboto',
			'cform-title-custom-family'     => '',
			'cform-title-font-size'         => '45',
			'cform-title-font-weight'       => 'normal',
			'cform-title-text-align'        => 'left',
			// Typography - Section Subtitle
			'cform-subtitle-font-family'    => 'Roboto',
			'cform-subtitle-custom-font'    => '',
			'cform-subtitle-font-size'      => '18',
			'cform-subtitle-font-weight'    => 'normal',
			'cform-subtitle-text-align'     => 'left',
			// Typography - Input & Textarea
			'cform-input-font-family'       => 'Roboto',
			'cform-input-custom-font'       => '',
			'cform-input-font-size'         => '16',
			'cform-input-font-weight'       => 'normal',
			// Typography - Radio & Checkbox
			'cform-radio-font-family'       => 'Roboto',
			'cform-radio-custom-font'       => '',
			'cform-radio-font-size'         => '14',
			'cform-radio-font-weight'       => 'normal',
			// Typography - Select
			'cform-select-font-family'      => 'Roboto',
			'cform-select-custom-family'    => '',
			'cform-select-font-size'        => '16',
			'cform-select-font-weight'      => 'normal',
			// Typography - Multi Select
			'cform-multiselect-font-family' => 'Roboto',
			'cform-multiselect-custom-font' => '',
			'cform-multiselect-font-size'   => '16',
			'cform-multiselect-font-weight' => 'normal',
			// Typography - Dropdown
			'cform-dropdown-font-family'    => 'Roboto',
			'cform-dropdown-custom-font'    => '',
			'cform-dropdown-font-size'      => '16',
			'cform-dropdown-font-weight'    => 'normal',
			// Typography - Calendar
			'cform-calendar-font-family'    => 'Roboto',
			'cform-calendar-custom-font'    => '',
			'cform-calendar-font-size'      => '13',
			'cform-calendar-font-weight'    => 'normal',
			// Typography - Buttons
			'cform-button-font-family'      => 'Roboto',
			'cform-button-custom-font'      => '',
			'cform-button-font-size'        => '14',
			'cform-button-font-weight'      => '500',
			// Typography - Timeline
			'cform-timeline-font-family'    => 'Roboto',
			'cform-timeline-custom-font'    => '',
			'cform-timeline-font-size'      => '12',
			'cform-timeline-font-weight'    => 'normal',
			// Typography - Pagination
			'cform-pagination-font-family'  => '',
			'cform-pagination-custom-font'  => '',
			'cform-pagination-font-size'    => '16',
			'cform-pagination-font-weight'  => 'normal',
			'payment_require_ssl'           => 'true,',
			'submission-file'               => 'delete',
			// Default Form Fields
			'login-username-field'          => 'text-1',
			'login-password-field'          => 'password-1',
			'remember-me'                   => 'true',
			'remember-me-label'             => __( 'Behalte mich in Erinnerung', Powerform::DOMAIN ),
			'remember-me-cookie-number'     => '2',
			'remember-me-cookie-type'       => 'weeks',
			// Additional settings
			'hide-login-form'               => true,
			'hidden-login-form-message'     => ''
		);
	}
}
