<?php
/**
 * Conditionally load assets class
 *
 * @since 1.12
 */
class Powerform_Assets_Enqueue_Quiz extends Powerform_Assets_Enqueue {
	/**
	 * Load scripts and styles on front-end
	 *
	 * @since 1.12
	 */
	public function load_assets() {
		$this->enqueue_styles();
		$this->enqueue_scripts();
	}

	/**
	 * Enqueue form styles
	 *
	 * @since 1.12
	 */
	public function enqueue_styles() {

		$form_settings = $this->get_settings();
		$form_design   = isset( $form_settings['powerform-quiz-theme'] ) ? $form_settings['powerform-quiz-theme'] : '';

		// Powerform UI - Icons font.
		wp_enqueue_style(
			'powerform-icons',
			powerform_plugin_url() . 'assets/powerform-ui/css/powerform-icons.min.css',
			array(),
			POWERFORM_VERSION
		);

		// Powerform UI - Utilities.
		wp_enqueue_style(
			'powerform-utilities',
			powerform_plugin_url() . 'assets/powerform-ui/css/src/powerform-utilities.min.css',
			array(),
			POWERFORM_VERSION
		);

		if ( 'none' !== $form_design ) {

			wp_enqueue_style(
				'powerform-quiz-' . $form_design . '-base',
				powerform_plugin_url() . 'assets/powerform-ui/css/src/quiz/powerform-quiz-' . $form_design . '.base.min.css',
				array(),
				POWERFORM_VERSION
			);
		}

		if ( isset( $form_settings['hasLeads'] ) && $form_settings['hasLeads'] ) {
			wp_enqueue_style(
				'powerform-quiz-' . $form_design . '-leads',
				powerform_plugin_url() . 'assets/powerform-ui/css/src/quiz/powerform-quiz-' . $form_design . '.leads.min.css',
				array(),
				POWERFORM_VERSION
			);
		}
	}

	/**
	 * Enqueue form scripts
	 *
	 * @since 1.11
	 */
	public function enqueue_scripts() {
		// Load form base scripts.
		$this->load_base_scripts();
	}

	/**
	 * Load base from scripts
	 *
	 * @since 1.11
	 */
	public function load_base_scripts() {
		// LOAD: Powerform validation scripts
		wp_enqueue_script( 'powerform-jquery-validate', powerform_plugin_url() . 'assets/js/library/jquery.validate.min.js', array( 'jquery' ), POWERFORM_VERSION, false );


		// LOAD: Powerform UI JS
		wp_enqueue_script(
			'powerform-ui',
			powerform_plugin_url() . 'assets/powerform-ui/js/powerform-ui.min.js',
			array( 'jquery' ),
			POWERFORM_VERSION,
			false
		);

		// LOAD: Powerform front scripts
		wp_enqueue_script(
			'powerform-front-scripts',
			powerform_plugin_url() . 'build/front/front.multi.min.js',
			array( 'jquery', 'powerform-ui', 'powerform-jquery-validate' ),
			POWERFORM_VERSION,
			false
		);

		// Localize front script
		wp_localize_script( 'powerform-front-scripts', 'PowerformFront', powerform_localize_data() );
	}
}
