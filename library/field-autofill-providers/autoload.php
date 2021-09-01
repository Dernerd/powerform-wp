<?php
/**
 * Autoloaded available autofill by Powerform
 */

$powerform_autofills = array(
	array(
		'required_files' => array(
			powerform_plugin_dir() . 'library/field-autofill-providers/class-wp-post.php',
		),
		'class_name'     => 'Powerform_WP_Post_Autofill_Provider',
	),

	array(
		'required_files' => array(
			powerform_plugin_dir() . 'library/field-autofill-providers/class-wp-user.php',
		),
		'class_name'     => 'Powerform_WP_User_Autofill_Provider',
	),
);

foreach ( $powerform_autofills as $powerform_autofill ) {
	$required_files    = $powerform_autofill['required_files'];
	$files_is_complete = true;

	foreach ( $required_files as $required_file ) {
		if ( ! file_exists( $required_file ) ) {
			$files_is_complete = false;
			break;
		}
	}
	if ( ! $files_is_complete ) {
		continue;
	}

	// only include file if all required files exist
	foreach ( $required_files as $required_file ) {
		/** @noinspection PhpIncludeInspection */
		require_once $required_file;
	}

	Powerform_Autofill_Loader::get_instance()->register( $powerform_autofill['class_name'] );

}


