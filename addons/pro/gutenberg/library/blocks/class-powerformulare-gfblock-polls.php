<?php

/**
 * Class Powerform_GFBlock_Forms
 *
 * @since 1.0 Gutenber Addon
 */
class Powerform_GFBlock_Polls extends Powerform_GFBlock_Abstract {

	/**
	 * @var self|null
	 */
	private static $_instance = null;

	/**
	 * Block identifier
	 *
	 * @since 1.0 Gutenber Addon
	 *
	 * @var string
	 */
	protected $_slug = 'polls';

	/**
	 * Get Instance
	 *
	 * @since 1.0 Gutenberg Addon
	 * @return self|null
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Powerform_GFBlock_Forms constructor.
	 *
	 * @since 1.0 Gutenberg Addon
	 */
	public function __construct() {
		// Initialize block
		$this->init();
	}

	/**
	 * Render block markup on front-end
	 *
	 * @since 1.0 Gutenberg Addon
	 * @param array $properties Block properties
	 *
	 * @return string
	 */
	public function render_block( $properties = array() ) {
		return '';
	}

	/**
	 * Preview form markup in block
	 *
	 * @since 1.0 Gutenberg Addon
	 * @param array $properties Block properties
	 *
	 * @return string
	 */
	public function preview_block( $properties = array() ) {
		if ( isset( $properties['module_id'] ) ) {
			return powerform_poll( $properties['module_id'], true, false );
		}

		return false;
	}

	/**
	 * Enqueue assets ( scritps / styles )
	 * Should be overriden in block class
	 *
	 * @since 1.0 Gutenberg Addon
	 */
	public function load_assets() {
		// Scripts
		wp_enqueue_script(
			'powerform-block-polls',
			powerform_gutenberg()->get_plugin_url() . '/js/polls-block.min.js',
			array( 'wp-blocks', 'wp-i18n', 'wp-element' ),
			filemtime( powerform_gutenberg()->get_plugin_dir() . 'js/polls-block.min.js' ),
			false
		);

		// Localize scripts
		wp_localize_script(
			'powerform-block-polls',
			'frmnt_poll_data',
			array(
				'forms'     => $this->get_forms(),
				'admin_url' => admin_url( 'admin.php' ),
				'l10n'      => $this->localize(),
			)
		);

		powerform_print_polls_admin_styles( POWERFORM_VERSION );
		powerform_print_front_scripts( POWERFORM_VERSION );
	}

	/**
	 * Return forms IDs and Names
	 *
	 * @since 1.0 Gutenberg Addon
	 * @return array
	 */
	public function get_forms() {
		$forms     = Powerform_API::get_polls( null, 1, 100, Powerform_Custom_Form_Model::STATUS_PUBLISH );
		$form_list = array(
			array(
				'value' => '',
				'label' => esc_html__( 'Select a poll', Powerform::DOMAIN ),
			),
		);

		if ( is_array( $forms ) ) {
			foreach ( $forms as $form ) {
				$poll_name = $form->name;

				if ( isset( $form->settings['formName'] ) && ! empty( $form->settings['formName'] ) ) {
					$poll_name = $form->settings['formName'];
				}

				$form_list[] = array(
					'value' => $form->id,
					'label' => $poll_name,
				);
			}
		}

		return $form_list;
	}

	public function localize() {
		return array(
			'choose_poll'      => esc_html__( 'Choose Poll', Powerform::DOMAIN ),
			'customize_poll'   => esc_html__( 'Customize poll', Powerform::DOMAIN ),
			'rendering'        => esc_html__( 'Rendering...', Powerform::DOMAIN ),
			'poll'             => esc_html__( 'Poll', Powerform::DOMAIN ),
			'poll_description' => esc_html__( 'Embed and display your Powerform polls in this block', Powerform::DOMAIN ),
		);
	}
}

new Powerform_GFBlock_Polls();
