<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Core
 */
class Powerform_Modules {

	/**
	 * Store modules objects
	 *
	 * @var array
	 */
	public $modules = array();

	/**
	 * Powerform_Modules constructor.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		$this->includes();
		$this->load_modules();
	}

	/**
	 * Includes
	 *
	 * @since 1.0
	 */
	private function includes() {
		/* @noinspection PhpIncludeInspection */
		include_once powerform_plugin_dir() . 'library/abstracts/abstract-class-module.php';
	}

	/**
	 * Load modules
	 *
	 * @since 1.0
	 */
	private function load_modules() {
		/**
		 * Filters modules list
		 */
		$modules = apply_filters( 'powerform_modules', array(
			'custom_forms' => array(
				'class'	  => 'Custom_Form',
				'slug'  => 'custom-forms',
				'label'	  => __( 'Benutzerdefinierte Formulare', Powerform::DOMAIN )
			),
			'polls' => array(
				'class'	  => 'Polls',
				'slug'  => 'polls',
				'label'	  => __( 'Umfragen', Powerform::DOMAIN )
			),
			'quizzes' => array(
				'class'	  => 'Quizzes',
				'slug'  => 'quizzes',
				'label'	  => __( 'Tests', Powerform::DOMAIN )
			),
		) );

		array_walk( $modules, array( $this, 'load_module' ) );
	}

	/**
	 * Load module
	 *
	 * @since 1.0
	 * @param $data
	 * @param $id
	 */
	public function load_module( $data, $id ) {
		$module_class = 'Powerform_' . $data[ 'class' ];
		$module_slug = $data[ 'slug' ];
		$module_label = $data[ 'label' ];
		
		// Include module
		$path = powerform_plugin_dir() . 'library/modules/' . $module_slug . '/loader.php';
		if ( file_exists( $path ) ) {
			include_once $path;
		}

		if ( class_exists( $module_class ) ) {
			$module_object = new $module_class( $id, $module_label );

			$this->modules[ $id ] = $module_object;
		}
	}

	/**
	 * Retrieve modules objects
	 *
	 * @since 1.0
	 * @return array
	 */
	public function get_modules() {
		return $this->modules;
	}
}
