<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Shortcode_Generator
 */
class Powerform_Shortcode_Generator {

	/**
	 * Powerform_Shortcode_Generator constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'media_buttons', array( $this, 'attach_button' ) );
		add_action( 'admin_footer', array( $this, 'enqueue_js_scripts' ) );
		if ( function_exists( 'hustle_activated' ) ) {
			add_action( 'admin_footer', array( $this, 'enqueue_preview_scripts_for_hustle' ) );
		}
	}

	/**
	 * Check if current page is Hustle wizard page
	 *
	 * @since 1.0.5
	 *
	 * @return bool
	 */
	public function is_hustle_wizard() {
		$screen = get_current_screen();

		// If no screen id, abort
		if( !isset( $screen->id ) ) return false;

		// Hustle wizard pages
		$pages = array(
			'hustle_page_hustle_popup',
			'hustle_page_hustle_slidein',
			'hustle_page_hustle_embedded',
			'hustle_page_hustle_sshare'
		);

		// Check if current page is hustle wizard page
		if( in_array( $screen->id, $pages, true ) ) return true;

		return false;
	}

	/**
	 * Attach button
	 *
	 * @since 1.0
	 */
	public function attach_button() {
		global $pagenow;

		// If page different than Post or Page, abort
		if ( 'post.php' !== $pagenow && 'post-new.php' !== $pagenow && ! $this->is_hustle_wizard() ) {
			return;
		}

		// Button markup
		printf(
			'<button type="button" id="%s" class="button" data-editor="content" data-a11y-dialog-show="powerform-popup">%s<span>%s</span></button>',
			'powerform-generate-shortcode',
			'<i class="powerform-scgen-icon" aria-hidden="true"></i>',
			esc_html__( 'Formular hinzufügen', Powerform::DOMAIN )
		);
	}

	/**
	 * @since 1.0
	 * @param $content
	 *
	 * @return mixed
	 */
	public function enqueue_js_scripts( $content ) {

		global $pagenow;

		$sanitize_version = str_replace( '.', '-', POWERFORM_SUI_VERSION );
		$sui_body_class   = "sui-$sanitize_version";

		// If page different than Post or Page, abort
		if ( 'post.php' !== $pagenow && 'post-new.php' !== $pagenow && ! $this->is_hustle_wizard() ) {
			return $content;
		}

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-widget' );
		wp_enqueue_script( 'jquery-ui-mouse' );
		wp_enqueue_script( 'jquery-ui-tabs' );

		// Get shortcode generator styles
		wp_enqueue_style(
			'powerform-shortcode-generator-styles',
			powerform_plugin_url() . 'assets/css/powerform-scgen.min.css',
			array(),
			POWERFORM_VERSION
		);

		// Get SUI JS
		wp_enqueue_script(
			'shared-ui',
			powerform_plugin_url() . 'assets/js/shared-ui.min.js',
			array( 'jquery' ),
			$sui_body_class,
			true
		);

		// Get shortcode generator scripts
		wp_enqueue_script(
			'powerform-shortcode-generator',
			powerform_plugin_url() . 'build/admin/scgen.min.js',
			array( 'jquery' ),
			POWERFORM_VERSION,
			false
		);

		wp_localize_script( 'powerform-shortcode-generator', 'powerformScgenData', array(
				'suiVersion' => $sui_body_class,
		) );

		$this->print_markup();
		?>
		<script type="text/javascript">
			jQuery(document).ready(function () {
				jQuery("#powerform-generate-shortcode").on( 'click', function(e) {
					e.preventDefault();
				});
			});
		</script>
		<?php
	}

	/**
	 * @since 1.0
	 * @param $content
	 *
	 * @return mixed
	 */
	public function enqueue_preview_scripts_for_hustle( $content ) {

		// If page is not Hustle module settings page, abort
		if ( ! $this->is_hustle_wizard() ) {
			return $content;
		}

		/**
		 * Powerform UI
		 * These stylesheets currently works with "forms" only.
		 *
		 * @since 1.7.0
		 */
		wp_enqueue_style( 'powerform-scgen-global', powerform_plugin_url() . 'assets/powerform-ui/css/powerform-global.min.css', array(), POWERFORM_VERSION );
		wp_enqueue_style( 'powerform-scgen-icons', powerform_plugin_url() . 'assets/powerform-ui/css/powerform-icons.min.css', array(), POWERFORM_VERSION );
		wp_enqueue_style( 'powerform-scgen-forms', powerform_plugin_url() . 'assets/powerform-ui/css/powerform-forms.min.css', array(), POWERFORM_VERSION );

	}

	/**
	 * Print modal markup
	 *
	 * @since 1.0
	 */
	public function print_markup() {
		?>
		<div id="powerform-scgen-modal" class="sui-wrap" style="display: none;">

			<div
				id="powerform-popup"
				class="sui-dialog sui-dialog-alt sui-dialog-reduced"
				tabindex="-1"
				aria-hidden="true"
			>

				<div class="sui-dialog-overlay"></div>

				<div
					class="sui-dialog-content"
					role="dialog"
					aria-labelledby="scgenDialogTitle"
					aria-describedby="scgenDialogDescription"
				>

					<div class="sui-box" role="document">

						<div class="sui-box-header sui-block-content-center">

							<h3 id="scgenDialogTitle" class="sui-box-title"><?php esc_html_e( 'Powerform Shortcodes', Powerform::DOMAIN ); ?></h3>

							<p id="scgenDialogDescription" class="sui-description"><?php esc_html_e( 'Wähle eine Option aus dem Dropdown-Menü und generiere einen Shortcode, der in Deinen Beitrag oder Deine Seite eingefügt werden soll.', Powerform::DOMAIN ); ?></p>

							<div class="sui-actions-right">

								<button class="sui-dialog-close">
									<span class="sui-screen-reader-text"><?php esc_html_e( 'Schließe dieses Dialogfenster.', Powerform::DOMAIN ); ?></span>
								</button>

							</div>

						</div>

						<div class="sui-box-body sui-box-body-slim">

							<div class="sui-tabs sui-tabs-flushed">

								<div data-tabs>

									<div id="powerform-shortcode-type--forms" class="active"><?php esc_html_e( 'Formulare', Powerform::DOMAIN ); ?></div>
									<div id="powerform-shortcode-type--polls"><?php esc_html_e( 'Umfragen', Powerform::DOMAIN ); ?></div>
									<div id="powerform-shortcode-type--quizzes"><?php esc_html_e( 'Tests', Powerform::DOMAIN ); ?></div>

								</div>

								<div data-panes>

									<!-- Forms -->
									<div id="powerform-custom-forms" class="active">

										<div class="sui-form-field">

											<label for="powerform-select-forms" class="sui-label"><?php esc_html_e( 'Wähle eine Option', Powerform::DOMAIN ); ?></label>

											<?php echo $this->get_forms(); // WPCS: XSS ok. ?>

											<span class="sui-error-message" style="display: none;"><?php esc_html_e( 'Bitte wähle eine Option, bevor Du fortfährst.', Powerform::DOMAIN ); ?></span>

										</div>

										<div class="fui-simulate-footer">

											<button class="sui-button sui-button-blue psource-insert-cform">
												<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
												<span class="sui-loading-text"><?php esc_html_e( 'Shortcode generieren', Powerform::DOMAIN ); ?></span>
											</button>

										</div>

									</div>

									<!-- Polls -->
									<div id="powerform-polls">

										<div class="sui-form-field">

											<label for="powerform-select-forms" class="sui-label"><?php esc_html_e( 'Wähle eine Option', Powerform::DOMAIN ); ?></label>

											<?php echo $this->get_polls(); // WPCS: XSS ok. ?>

											<span class="sui-error-message" style="display: none;"><?php esc_html_e( 'Bitte wähle eine Option, bevor Du fortfährst.', Powerform::DOMAIN ); ?></span>

										</div>

										<div class="fui-simulate-footer">

											<button class="sui-button sui-button-blue psource-insert-poll">
												<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
												<span class="sui-loading-text"><?php esc_html_e( 'Shortcode generieren', Powerform::DOMAIN ); ?></span>
											</button>

										</div>

									</div>

									<!-- Quizzes -->
									<div id="powerform-quizzes">

										<div class="sui-form-field">

											<label for="powerform-select-forms" class="sui-label"><?php esc_html_e( 'Wähle eine Option', Powerform::DOMAIN ); ?></label>

											<?php echo $this->get_quizzes(); // WPCS: XSS ok. ?>

											<span class="sui-error-message" style="display: none;"><?php esc_html_e( 'Bitte wähle eine Option, bevor Du fortfährst.', Powerform::DOMAIN ); ?></span>

										</div>

										<div class="fui-simulate-footer">

											<button class="sui-button sui-button-blue psource-insert-quiz">
												<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
												<span class="sui-loading-text"><?php esc_html_e( 'Shortcode generieren', Powerform::DOMAIN ); ?></span>
											</button>

										</div>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>
		<?php
	}

	/**
	 * Print forms select
	 *
	 * @since 1.0
	 * @return string
	 */
	public function get_forms() {

		$html = '';

		$html .= '<select id="powerform-select-forms" name="forms" class="sui-select powerform-custom-form-list">';

			$html .= '<option value="">' . __( 'Wähle Benutzerdefiniertes Formular', Powerform::DOMAIN ) . '</option>';

			$modules = powerform_cform_modules( 999 );

			foreach( $modules as $module ) {

				$title = powerform_get_form_name( $module['id'], 'custom_form' );

				if ( mb_strlen( $title ) > 25 ) {
					$title = mb_substr( $title, 0, 25 ) . '...';
				}

				$html .= '<option value="' . $module['id'] . '">' . $title. ' - ID: ' . $module['id'] . '</option>';

			}
		$html .= '</select>';

		return $html;

	}

	/**
	 * Print polls select
	 *
	 * @since 1.0
	 * @return string
	 */
	public function get_polls() {

		$html = '';

		$html .= '<select id="powerform-select-polls" name="forms" class="sui-select powerform-insert-poll">';

			$html .= '<option value="">' . __( "Wähle Umfrage", Powerform::DOMAIN ) . '</option>';

			$modules = powerform_polls_modules( 999 );

			foreach( $modules as $module ) {

				$title = powerform_get_form_name( $module['id'], 'poll');

				if ( mb_strlen( $title ) > 25 ) {
					$title = mb_substr( $title, 0, 25 ) . '...';
				}

				$html .= '<option value="' . $module['id'] . '">' . $title . ' - ID: ' . $module['id'] . '</option>';

			}

		$html .= '</select>';

		return $html;
	}

	/**
	 * Print quizzes select
	 *
	 * @since 1.0
	 * @return string
	 */
	public function get_quizzes() {

		$html = '';

		$html .= '<select id="powerform-select-quizzes" name="forms" class="sui-select powerform-quiz-list">';

			$html .= '<option value="">' . __( "Wähle Quiz", Powerform::DOMAIN ) . '</option>';

			$modules = powerform_quizzes_modules( 999 );

			foreach( $modules as $module ) {

				$title = powerform_get_form_name( $module['id'], 'quiz');

				if ( mb_strlen( $title ) > 25 ) {
					$title = mb_substr( $title, 0, 25 ) . '...';
				}

				$html .= '<option value="' . $module['id'] . '">' . $title . ' - ID: ' . $module['id'] . '</option>';

			}

		$html .= '</select>';

		return $html;

	}
}
