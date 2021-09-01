<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Return the array of modules objects
 *
 * @since 1.0
 * @return mixed
 */

function powerform_get_modules() {
	$powerform = Powerform_Core::get_instance();

	return $powerform->modules;
}

/**
 * Return specific module by ID
 *
 * @since 1.0
 * @param $id
 *
 * @return bool
 */
function powerform_get_module( $id ) {
	$modules = powerform_get_modules();

	return isset( $modules[ $id ] ) && ! empty( $modules[ $id ] ) ? $modules[ $id ] : false;
}
