<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_CForm_New_Page
 *
 * @since 1.0
 */
class Powerform_CForm_New_Page extends Powerform_Admin_Page {

	/**
	 * Get wizard title
	 *
	 * @since 1.0
	 * @return mixed
	 */
	public function getWizardTitle() {
		if ( isset( $_REQUEST['id'] ) ) { // WPCS: CSRF OK
			return __( "Edit Form", Powerform::DOMAIN );
		} else {
			return __( "New Form", Powerform::DOMAIN );
		}
	}

	/**
	 * Add page screen hooks
	 *
	 * @since 1.0
	 * @param $hook
	 */
	public function enqueue_scripts( $hook ) {
		// Load jquery ui
		powerform_admin_jquery_ui();

		// Load shared-ui scripts
		powerform_sui_scripts();

		// Load admin fonts
		powerform_admin_enqueue_fonts( POWERFORM_VERSION );

		// Load admin styles
		powerform_admin_enqueue_styles( POWERFORM_VERSION );

		$powerform_data = new Powerform_Admin_Data();
		$powerform_l10n = new Powerform_Admin_L10n();

		// Load admin scripts
		powerform_admin_enqueue_scripts_forms(
			POWERFORM_VERSION,
			$powerform_data->get_options_data(),
			$powerform_l10n->get_l10n_strings()
		);

		// Load front scripts for preview_form
		powerform_print_forms_admin_styles( POWERFORM_VERSION );
		powerform_print_front_scripts( POWERFORM_VERSION );

		// for preview
		$style_src     = powerform_plugin_url() . 'assets/css/intlTelInput.min.css';
		$style_version = "4.0.3";

		$script_src     = powerform_plugin_url() . 'assets/js/library/intlTelInput.min.js';
		$script_version = POWERFORM_VERSION;
		wp_enqueue_style( 'intlTelInput-powerform-css', $style_src, array(), $style_version ); // intlTelInput
		wp_enqueue_script( 'powerform-intlTelInput', $script_src, array( 'jquery' ), $script_version, false ); // intlTelInput

		wp_enqueue_script( 'powerform-field-moment',
			powerform_plugin_url() . 'assets/js/library/moment.min.js',
			array( 'jquery' ),
			'2.22.2',
			true );

        wp_enqueue_script( 'powerform-field-datepicker-range',
			powerform_plugin_url() . 'assets/js/library/daterangepicker.min.js',
			array('powerform-field-moment'),
			'3.0.3',
			true );
	}

	/**
	 * Render page header
	 *
	 * @since 1.0
	 */
	protected function render_header() { ?>
		<?php
		if ( $this->template_exists( $this->folder . '/header' ) ) {
			$this->template( $this->folder . '/header' );
		} else {
			?>
			<h1 class="sui-header-title"><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<?php } ?>
		<?php
	}
}
