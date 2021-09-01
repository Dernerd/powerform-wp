<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Quizz_New_NoWrong
 *
 * @since 1.0
 */
class Powerform_Quizz_New_NoWrong extends Powerform_Admin_Page {

	/**
	 * Return wizard title
	 *
	 * @since 1.0
	 */
	public function getWizardTitle() {
		if ( isset( $_REQUEST['id'] ) ) { // WPCS: CSRF OK
			return __( "Quiz bearbeiten", Powerform::DOMAIN );
		} else {
			return __( "Neues Quiz", Powerform::DOMAIN );
		}
	}


	/**
	 * Add page screen hooks
	 *
	 * @since 1.6.2
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
		powerform_admin_enqueue_scripts_personality(
			POWERFORM_VERSION,
			$powerform_data->get_options_data(),
			$powerform_l10n->get_l10n_strings()
		);

		// Load front scripts for preview_form
		powerform_print_front_styles( POWERFORM_VERSION );
		powerform_print_front_scripts( POWERFORM_VERSION );
	}

	/**
	 * Render page header
	 *
	 * @since 1.6.2
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
