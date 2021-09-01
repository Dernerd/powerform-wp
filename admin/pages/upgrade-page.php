<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Powerform_Dashboard_Page
 *
 * @since 1.0
 */
class Powerform_Upgrade_Page extends Powerform_Admin_Page {

	public function render() {
		$modules = powerform_get_modules();
		$this->template(
			'upgrade/upgrade-content',
			array(
				'modules' => $modules
			)
		);
	}

}
