<?php
/**
 * Conditionally load assets class
 *
 * @since 1.11
 */
class Powerform_Assets_Enqueue_Poll extends Powerform_Assets_Enqueue {
	/**
	 * Load scripts and styles on front-end
	 *
	 * @since 1.11
	 */
	public function load_assets() {
		$this->enqueue_styles();
		$this->enqueue_scripts();
	}

	/**
	 * Enqueue form styles
	 *
	 * @since 1.11
	 */
	public function enqueue_styles() {

		$form_settings = $this->get_settings();
		$form_design = 'default';

		if ( isset( $form_settings['powerform-poll-design'] ) ) {

			if ( '' !== $form_settings['powerform-poll-design'] ) {
				$form_design = $form_settings['powerform-poll-design'];
			}
		}

		$results_behav     = isset( $form_settings['results-behav'] ) ? $form_settings['results-behav'] : 'not_show';
		$results_style     = isset( $form_settings['results-style'] ) ? $form_settings['results-style'] : 'bar';

		$has_custom_answer = $this->has_custom_answer(); // Check if any of the answers has "custom input" enabled.
		$has_chart_enabled = false; // Check if "Results Display" has "link on poll" or "show after voted" options enabled.
		$has_chart_pie     = ( 'pie' === $results_style ) ? true : false; // Check if "Pie Chart" has been selected.
		$has_chart_bar     = ( 'bar' === $results_style ) ? true : false; // Check if "Bar Chart" has been selected.

		if ( 'not_show' !== $results_behav ) {
			$has_chart_enabled = true;
		}

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

		// Powerform UI - Load correct stylesheet.
		if ( 'none' !== $form_design ) {

			if ( $has_custom_answer || $has_chart_enabled ) {

				wp_enqueue_style(
					'powerform-polls-' . $form_design . '-full',
					powerform_plugin_url() . 'assets/powerform-ui/css/src/poll/powerform-poll-' . $form_design . '.full.min.css',
					array(),
					POWERFORM_VERSION
				);
			} else {

				wp_enqueue_style(
					'powerform-polls-' . $form_design . '-base',
					powerform_plugin_url() . 'assets/powerform-ui/css/src/poll/powerform-poll-' . $form_design . '.base.min.css',
					array(),
					POWERFORM_VERSION
				);
			}
		}

		// Powerform UI - Pie chart.
		if ( $has_chart_enabled && $has_chart_pie ) {

			wp_enqueue_style(
				'powerform-chart-pie',
				powerform_plugin_url() . 'assets/powerform-ui/css/src/chart/powerform-chart.pie.min.css',
				array(),
				POWERFORM_VERSION
			);
		}

		// Powerform UI - Bar chart.
		if ( $has_chart_enabled && $has_chart_bar ) {

			wp_enqueue_style(
				'powerform-chart-bar',
				powerform_plugin_url() . 'assets/powerform-ui/css/src/chart/powerform-chart.bar.min.css',
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

		// LOAD: ChartJS
		wp_enqueue_script(
			'chartjs',
			powerform_plugin_url() . 'assets/js/front/Chart.min.js',
			array( 'jquery' ),
			'2.8.0',
			false
		);

		// LOAD: Datalabels plugin for ChartJS
		wp_enqueue_script(
			'chartjs-plugin-datalabels',
			powerform_plugin_url() . 'assets/js/front/chartjs-plugin-datalabels.min.js',
			array( 'jquery' ),
			'0.6.0',
			false
		);

		// LOAD: Powerform UI JS
		wp_enqueue_script(
			'powerform-ui',
			powerform_plugin_url() . 'assets/powerform-ui/js/powerform-poll.min.js',
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

	/**
	 * Check if poll has custom answer
	 *
	 * @since 1.11
	 *
	 * @return bool
	 */
	public function has_custom_answer() {

		$has_custom = false;

		$fields = $this->get_fields();

		foreach ( $fields as $field ) {
			if ( isset( $field['use_extra'] ) ) {
				$has_custom = true;
			}
		}

		return $has_custom;
	}
}
