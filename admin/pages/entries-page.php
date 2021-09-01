<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Entries_Page
 *
 * @since 1.0.5
 */
class Powerform_Entries_Page extends Powerform_Admin_Page {

	/**
	 * Available Modules
	 *
	 * @since 1.0.5
	 * @var array
	 */
	private $modules = array();

	/**
	 * Merged default parameter with $_REQUEST
	 *
	 * @since 1.0.5
	 * @var array
	 */
	private $screen_params = array();

	/**
	 * HTML representative of entries page
	 *
	 * @since 1.0.5
	 * @var string
	 */
	private $entries_page = '';

	/**
	 * Current Form Model of requested entries
	 *
	 * @since 1.0.5
	 * @var null|Powerform_Base_Form_Model
	 */
	private $form_model = null;

	/**
	 * Populating Modules that available on Plugin
	 *
	 * @since 1.0.5
	 */
	public function populate_modules() {
		$modules[] = array(
			'name'  => __( 'Formulare', Powerform::DOMAIN ),
			'model' => Powerform_Custom_Form_Model::model(),
		);
		$modules[] = array(
			'name'  => __( 'Umfragen', Powerform::DOMAIN ),
			'model' => Powerform_Poll_Form_Model::model(),
		);
		$modules[] = array(
			'name'  => __( 'Tests', Powerform::DOMAIN ),
			'model' => Powerform_Quiz_Form_Model::model(),
		);

		$this->modules = apply_filters( 'powerform_entries_page_modules', $modules );
	}

	/**
	 * Populating Current Page Parameters
	 *
	 * @since 1.0.5
	 */
	public function populate_screen_params() {
		$screen_params = array(
			'form_type' => 'powerform_forms',
			'form_id'   => 0,
		);

		$this->screen_params = array_merge( $screen_params, $_REQUEST );//phpcs:ignore -- data without nonce verification
	}

	/**
	 * Executed Action before render the page
	 *
	 * @since 1.0.5
	 */
	public function before_render() {
		$this->populate_screen_params();
		$this->populate_modules();
		$this->prepare_entries_page();
		$this->enqueue_entries_scripts();
	}

	/**
	 * Get Form types based on available modules
	 *
	 * @since 1.0.5
	 *
	 * @return mixed
	 */
	public function get_form_types() {
		$form_types = array();
		foreach ( $this->modules as $module ) {
			/** @var Powerform_Base_Form_Model $model */
			$model = $module['model'];
			$name  = $module['name'];

			$form_types[ $model->get_post_type() ] = $name;
		}

		return apply_filters( 'powerform_entries_page_modules', $form_types );
	}

	/**
	 * Prepare Entries Page
	 *
	 * @since 1.0.5
	 */
	private function prepare_entries_page() {
		$this->form_model = $this->get_form_model();
		// Form not found
		if ( ! $this->form_model instanceof Powerform_Base_Form_Model ) {
			// if form_id available remove it from request, and redirect
			if ( $this->get_current_form_id() ) {
				$url = remove_query_arg( 'form_id' );
				if ( wp_safe_redirect( $url ) ) {
					exit;
				}
			}
		} else {
			switch ( $this->get_current_form_type() ) {
				case Powerform_Custom_Form_Model::model()->get_post_type():
					$entries_renderer = new Powerform_CForm_Renderer_Entries( 'custom-form/entries' );
					break;
				case Powerform_Poll_Form_Model::model()->get_post_type():
					$entries_renderer = new Powerform_Poll_Renderer_Entries( 'poll/entries' );
					break;
				case Powerform_Quiz_Form_Model::model()->get_post_type():
					$entries_renderer = new Powerform_Quizz_Renderer_Entries( 'quiz/entries' );
					break;
				default:
					$entries_renderer = null;
					break;
			}

			if ( $entries_renderer instanceof Powerform_Admin_Page ) {
				ob_start();
				// render the entries page
				$entries_renderer->render();
				$this->entries_page = ob_get_clean();
			}
		}
	}

	/**
	 * Get Form Model if current requested form_id available and matched form_type
	 *
	 * @since 1.0.5
	 *
	 * @return bool|Powerform_Base_Form_Model|null
	 */
	private function get_form_model() {
		if ( $this->get_current_form_id() ) {
			$form_model = powerform_get_model_from_id( $this->get_current_form_id() );
			if ( ! $form_model instanceof Powerform_Base_Form_Model ) {
				return null;
			}
			if ( $form_model->get_post_type() !== $this->get_current_form_type() ) {
				return null;
			}

			return $form_model;
		}

		return null;
	}

	/**
	 * Return rendered entries page
	 *
	 * @since 1.0.5
	 *
	 * @return string
	 */
	public function render_entries() {
		return $this->entries_page;
	}

	/**
	 * Render Form switcher / select based on current form_type
	 *
	 * @since 1.0.5
	 *
	 * @return string
	 */
	public function render_form_switcher( $form_type = 'powerform_forms', $form_id = 0 ) {
		$html = '<select name="form_id" data-allow-search="1" data-minimum-results-for-search="0" class="sui-select sui-select-sm sui-select-inline">';

		$empty_option = '';

		if ( $form_type === Powerform_Custom_Form_Model::model()->get_post_type() ) {
			$empty_option = __( 'Wähle Formular', Powerform::DOMAIN );
		} elseif ( $form_type === Powerform_Poll_Form_Model::model()->get_post_type() ) {
			$empty_option = __( 'Wähle Umfrage', Powerform::DOMAIN );
		} elseif ( $form_type === Powerform_Quiz_Form_Model::model()->get_post_type() ) {
			$empty_option = __( 'Wähle Test', Powerform::DOMAIN );
		}

		$html .= '<option value="" ' . selected( 0, $form_id, false ) . '>' . $empty_option . '</option>';

		$forms = $this->get_forms( $form_type );

		foreach ( $forms as $form ) {
			if ( isset( $form->settings['form-type'] ) && 'leads' === $form->settings['form-type'] ) {
				continue;
			}

			/**@var Powerform_Base_Form_Model $form */
			$title = ! empty( $form->settings['formName'] ) ? $form->settings['formName'] : $form->raw->post_title;
			$html .= '<option value="' . $form->id . '" ' . selected( $form->id, $form_id, false ) . '>' . $title . '</option>';
		}

		$html .= '</select>';

		return $html;
	}

	/**
	 * Get list of forms from
	 *
	 * @since 1.0.5
	 *
	 * @return mixed
	 */
	public function get_forms( $form_type = 'powerform_forms' ) {
		//$form_type = $this->get_current_form_type();
		switch ( $form_type ) {
			case 'powerform_forms':
				//TODO: lazy load this
				$forms = Powerform_Custom_Form_Model::model()->get_models( 99 );
				break;
			case 'powerform_polls':
				$forms = Powerform_Poll_Form_Model::model()->get_models( 99 );
				break;
			case 'powerform_quizzes':
				$forms = Powerform_Quiz_Form_Model::model()->get_models( 99 );
				break;
			default:
				$forms = array();
				break;
		}

		return apply_filters( 'powerform_entries_get_forms', $forms, $form_type );
	}

	/**
	 * Get current form type
	 *
	 * @since 1.0.5
	 *
	 * @return mixed
	 */
	public function get_current_form_type() {
		return $this->screen_params['form_type'];
	}

	/**
	 * Get current form id
	 *
	 * @since 1.0.5
	 *
	 * @return mixed
	 */
	public function get_current_form_id() {
		return $this->screen_params['form_id'];
	}

	/**
	 * Custom scripts that only used on submissions page
	 *
	 * @since 1.5.4
	 */
	public function enqueue_entries_scripts() {
		wp_enqueue_script(
			'powerform-entries-moment',
			powerform_plugin_url() . 'assets/js/library/moment.min.js',
			array( 'jquery' ),
			'2.22.2',
			true
		);
		wp_enqueue_script(
			'powerform-entries-datepicker-range',
			powerform_plugin_url() . 'assets/js/library/daterangepicker.min.js',
			array( 'powerform-entries-moment' ),
			'3.0.3',
			true
		);

		// use inline script to allow hooking into this
		$daterangepicker_ranges
			= sprintf(
				"
			var powerform_entries_datepicker_ranges = {
				'%s': [moment(), moment()],
		        '%s': [moment().subtract(1,'days'), moment().subtract(1,'days')],
		        '%s': [moment().subtract(6,'days'), moment()],
		        '%s': [moment().subtract(29,'days'), moment()],
		        '%s': [moment().startOf('month'), moment().endOf('month')],
		        '%s': [moment().subtract(1,'month').startOf('month'), moment().subtract(1,'month').endOf('month')]
			};",
				__( 'Heute', Powerform::DOMAIN ),
				__( 'Gestern', Powerform::DOMAIN ),
				__( 'Letzten 7 Tage', Powerform::DOMAIN ),
				__( 'Letzten 30 Tage', Powerform::DOMAIN ),
				__( 'Diesen Monat', Powerform::DOMAIN ),
				__( 'Letzten Monat', Powerform::DOMAIN )
			);

		/**
		 * Filter ranges to be used on submissions date range
		 *
		 * @since 1.5.4
		 *
		 * @param string $daterangepicker_ranges
		 */
		$daterangepicker_ranges = apply_filters( 'powerform_entries_datepicker_ranges', $daterangepicker_ranges );

		wp_add_inline_script( 'powerform-entries-datepicker-range', $daterangepicker_ranges );

		add_filter( 'powerform_l10n', array( $this, 'add_l10n' ) );

	}

	/**
	 * Hook into powerform_l10n
	 *
	 * Allow to modify `daterangepicker` locale
	 *
	 * @param $l10n
	 *
	 * @return mixed
	 */
	public function add_l10n( $l10n ) {
		$daterangepicker_lang = array(
			'daysOfWeek' => Powerform_Admin_L10n::get_short_days_names(),
			'monthNames' => Powerform_Admin_L10n::get_months_names(),
		);

		/**
		 * Filter daterangepicker locale to be used
		 *
		 * @since 1.5.4
		 *
		 * @param array $daterangepicker_lang
		 */
		$daterangepicker_lang    = apply_filters( 'powerform_l10n_daterangepicker', $daterangepicker_lang );
		$l10n['daterangepicker'] = $daterangepicker_lang;

		return $l10n;
	}

	/**
	 * Override scripts to be loaded
	 *
	 * @since 1.11
	 *
	 * @param $hook
	 */
	public function enqueue_scripts( $hook ) {
		parent::enqueue_scripts( $hook );

		powerform_print_forms_admin_styles( POWERFORM_VERSION );
		powerform_print_polls_admin_styles( POWERFORM_VERSION );
		powerform_print_front_styles( POWERFORM_VERSION );

		powerform_print_front_scripts( POWERFORM_VERSION );
	}
}
