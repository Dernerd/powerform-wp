<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_PageBreak
 *
 * @since 1.0
 */
class Powerform_Page_Break extends Powerform_Field {

	/**
	 * @var string
	 */
	public $name = '';

	/**
	 * @var string
	 */
	public $slug = 'page-break';

	/**
	 * @var string
	 */
	public $type = 'page-break';

	/**
	 * @var int
	 */
	public $position = 18;

	/**
	 * @var array
	 */
	public $options = array();

	/**
	 * @var string
	 */
	public $category = 'standard';

	/**
	 * @var string
	 */
	public $hide_advanced = 'true';

	/**
	 * @var string
	 */
	public $icon = 'sui-icon-pagination';

	/**
	 * Powerform_Pagination constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {

		parent::__construct();

		$this->name = __( 'Page Break', Powerform::DOMAIN );

	}

	/**
	 * Field defaults
	 *
	 * @since 1.0
	 * @return array
	 */
	public function defaults() {
		return apply_filters(
			'powerform_page_break_btn_label',
			array(
				'btn_left'  => __( '« Previous Step', Powerform::DOMAIN ),
				'btn_right' => __( 'Next Step »', Powerform::DOMAIN ),
			)
		);
	}

	/**
	 * Autofill Setting
	 *
	 * @since 1.0.5
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function autofill_settings( $settings = array() ) {
		//Unsupported Autofill
		$autofill_settings = array();

		return $autofill_settings;
	}
}
