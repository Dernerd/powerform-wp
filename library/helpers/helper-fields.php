<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Return custom form
 *
 * @since 1.0
 * @return mixed
 */
function powerform_form( $id, $is_preview = false, $hidden = true ) {
	$view = new Powerform_CForm_Front();

	return $view->render_shortcode(
		array(
			'id'         => $id,
			'is_preview' => $is_preview,
		)
	);
}

/**
 * Return custom form
 *
 * @since 1.0
 * @return mixed
 */
function powerform_poll( $id, $is_preview = false, $hidden = true ) {
	$view = new Powerform_Poll_Front();

	return $view->render_shortcode(
		array(
			'id'         => $id,
			'is_preview' => $is_preview,
		)
	);
}

/**
 * Return custom form
 *
 * @since 1.0
 * @return mixed
 */
function powerform_quiz( $id, $is_preview = false, $hidden = true ) {
	$view = new Powerform_QForm_Front();

	return $view->render_shortcode(
		array(
			'id'         => $id,
			'is_preview' => $is_preview,
		)
	);
}

/**
 * Return custom form
 *
 * @since 1.0
 * @return mixed
 */
function powerform_form_preview( $id, $ajax = false, $data = false ) {
	$view = new Powerform_CForm_Front();
	$data = powerform_stripslashes_deep( $data );

	return $view->render_shortcode(
		array(
			'id'           => $id,
			'is_preview'   => $ajax,
			'preview_data' => $data,
		)
	);
}

/**
 * Return custom form
 *
 * @since 1.0
 * @return mixed
 */
function powerform_poll_preview( $id, $ajax = false, $data = false ) {
	$view = new Powerform_Poll_Front();
	$data = powerform_stripslashes_deep( $data );

	return $view->render_shortcode(
		array(
			'id'           => $id,
			'is_preview'   => $ajax,
			'preview_data' => $data,
		)
	);
}

/**
 * Return custom form
 *
 * @since 1.0
 * @return mixed
 */
function powerform_quiz_preview( $id, $ajax = false, $data = false ) {
	$view = new Powerform_QForm_Front();
	$data = powerform_stripslashes_deep( $data );

	return $view->render_shortcode(
		array(
			'id'           => $id,
			'is_preview'   => $ajax,
			'preview_data' => $data,
		)
	);
}

/**
 * Return stripslashed string or array
 *
 * @since 1.0
 * @return mixed
 */
function powerform_stripslashes_deep( $val ) {
	$val = is_array( $val ) ? array_map( 'stripslashes_deep', $val ) : stripslashes( $val );

	return $val;
}

/**
 * Sanitize field
 *
 * @since 1.0.2
 *
 * @param $field
 *
 * @return array|string
 */
function powerform_sanitize_field( $field ) {
	// If array map all fields
	if ( is_array( $field ) ) {
		return array_map( 'powerform_sanitize_field', $field );
	}

	return sanitize_text_field( $field );
}

/**
 * Sanitize text area
 *
 * @param $field
 *
 * @return string
 */
function powerform_sanitize_textarea( $field ) {

	return sanitize_textarea_field( $field );
}

/**
 * Return the array of fields objects
 *
 * @since 1.0
 * @return mixed
 */
function powerform_get_fields() {
	$powerform = Powerform_Core::get_instance();

	return $powerform->fields;
}

/**
 * Return the array of PRO fields for promotion PRO version
 *
 * @return array
 */
function powerform_get_pro_fields() {
	$powerform = Powerform_Core::get_instance();

	return $powerform->pro_fields;
}

/**
 * Return field objects as array
 *
 * @since 1.0
 * @return mixed
 */
function powerform_fields_to_array() {
	$fields       = array();
	$fields_array = powerform_get_fields();

	if ( ! empty( $fields_array ) ) {
		foreach ( $fields_array as $key => $field ) {
			$fields[ $field->type ] = $field;
		}
	}

	return apply_filters( 'powerform_fields_to_array', $fields, $fields_array );
}

/**
 * Return specific field by ID
 *
 * @since 1.0
 *
 * @param $id
 *
 * @return bool|Powerform_Field
 */
function powerform_get_field( $id ) {
	$fields = powerform_fields_to_array();

	return isset( $fields[ $id ] ) && ! empty( $fields[ $id ] ) ? $fields[ $id ] : false;
}

/**
 * Return all existing custom fields
 *
 * @since      1.0
 * @deprecated 1.5.4
 * @return mixed
 */
function powerform_get_existing_cfields() {
	_deprecated_function( 'powerform_get_existing_cfields', '1.5.4' );

	return array();
}

/**
 * Convert array to array compatible with field values
 *
 * @since 1.0
 *
 * @param      $array
 * @param bool $replace_value
 *
 * @return array
 */
function powerform_to_field_array( $array, $replace_value = false ) {
	$field_array = array();

	if ( ! empty( $array ) ) {
		foreach ( $array as $key => $value ) {
			// Use value instead of key
			if ( $replace_value ) {
				$field_array[] = array(
					'value' => $value,
					'label' => $value,
				);
			} else {
				$field_array[] = array(
					'value' => $key,
					'label' => $value,
				);
			}
		}
	}

	return $field_array;
}

/**
 * Return max upload limit from server
 *
 * @since 1.6
 * @return int Mb
 */
function powerform_get_max_upload() {
	$max_upload = wp_max_upload_size();

	return (int) ( $max_upload / 1000000 ); // convert to mb;
}

/**
 * Return users list
 *
 * @since 1.6
 * @return array
 */
function powerform_list_users() {
	$users_list = array();
	$users      = get_users(
		array(
			'role__in' => array( 'administrator', 'editor', 'author' ),
			'fields'   => array( 'ID', 'display_name' ),
		)
	);
	foreach ( $users as $user ) {
		$users_list[] = array(
			'value' => $user->ID,
			'label' => ucfirst( $user->display_name ),
		);
	}

	return apply_filters( 'powerform_postdata_users_list', $users_list );
}

/**
 * Return post type list
 *
 * @since 1.7
 * @return array
 */
function powerform_post_type_list() {
	$post_type_list = array();
	$post_types     = get_post_types( array(), 'objects' );

	unset( $post_types['attachment'] );
	unset( $post_types['revision'] );
	unset( $post_types['nav_menu_item'] );
	unset( $post_types['custom_css'] );
	unset( $post_types['customize_changeset'] );
	unset( $post_types['oembed_cache'] );
	unset( $post_types['user_request'] );
	unset( $post_types['wp_block'] );
	unset( $post_types['powerform_forms'] );
	unset( $post_types['powerform_polls'] );
	unset( $post_types['powerform_quizzes'] );

	foreach ( $post_types as $post ) {
		$post_type_list[] = array(
			'value' => $post->name,
			'label' => ucfirst( $post->label ),
		);
	}

	return apply_filters( 'powerform_postdata_post_type_list', $post_type_list );
}

/**
 * Return post type Categories
 *
 * @since 1.7
 *
 * @param $type
 *
 * @return array
 */
function powerform_post_categories( $type = '' ) {
	$categories = array();
	$category   = array();
	$post_types = powerform_post_type_list();

	foreach ( $post_types as $post ) {
		$post_type  = $post['value'];
		$categories = get_object_taxonomies( $post_type, 'objects' );

		if ( ! empty( $categories ) ) {
			foreach ( $categories as $cat ) {
				if ( 'post_format' !== $cat->name ) {
					$category[ $post_type ][] = array(
						'value'    => $cat->name,
						'label'    => ucfirst( $cat->label ),
						'singular' => $cat->labels->singular_name,
					);
				}
			}
		}
		$categories = $category;
	}
	if ( ! empty( $type ) ) {
		$category_list = isset( $categories[ $type ] ) ? $categories[ $type ] : array();
	} else {
		$category_list = $categories;
	}
	return apply_filters( 'powerform_postdata_post_categories', $category_list );
}

/**
 * Return vars
 *
 * @since 1.0
 * @since 1.5 add `user_id`
 * @return mixed
 */
function powerform_get_vars() {
	$vars_list = array(
		'user_ip'      => esc_html__( 'User IP Address', Powerform::DOMAIN ),
		'date_mdy'     => esc_html__( 'Date (mm/dd/yyyy)', Powerform::DOMAIN ),
		'date_dmy'     => esc_html__( 'Date (dd/mm/yyyy)', Powerform::DOMAIN ),
		'embed_id'     => esc_html__( 'Embed Post/Page ID', Powerform::DOMAIN ),
		'embed_title'  => esc_html__( 'Embed Post/Page Title', Powerform::DOMAIN ),
		'embed_url'    => esc_html__( 'Embed URL', Powerform::DOMAIN ),
		'user_agent'   => esc_html__( 'HTTP User Agent', Powerform::DOMAIN ),
		'refer_url'    => esc_html__( 'HTTP Refer URL', Powerform::DOMAIN ),
		'user_id'      => esc_html__( 'User ID', Powerform::DOMAIN ),
		'user_name'    => esc_html__( 'User Display Name', Powerform::DOMAIN ),
		'user_email'   => esc_html__( 'User Email', Powerform::DOMAIN ),
		'user_login'   => esc_html__( 'User Login', Powerform::DOMAIN ),
		'custom_value' => esc_html__( 'Custom Value', Powerform::DOMAIN ),
		'query'        => esc_html__( 'Query Parameter', Powerform::DOMAIN ),
	);

	/**
	 * Filter powerform var list
	 *
	 * @see   powerform_replace_variables()
	 *
	 * @since 1.0
	 *
	 * @param array $vars_list
	 */
	return apply_filters( 'powerform_vars_list', $vars_list );
}

/**
 * Return Stripe vars
 *
 * @since 1.7
 * @return mixed
 */
function powerform_get_payment_vars() {
	$vars_list = array(
		'payment_mode'     => esc_html__( 'Payment Mode', Powerform::DOMAIN ),
		'payment_status'   => esc_html__( 'Payment Status', Powerform::DOMAIN ),
		'payment_amount'   => esc_html__( 'Payment Amount', Powerform::DOMAIN ),
		'payment_currency' => esc_html__( 'Payment Currency', Powerform::DOMAIN ),
		'transaction_id'   => esc_html__( 'Transaction ID', Powerform::DOMAIN ),
	);

	/**
	 * Filter powerform Stripe var list
	 *
	 * @since 1.7
	 *
	 * @param array $vars_list
	 */
	return apply_filters( 'powerform_stripe_vars_list', $vars_list );
}

/**
 * Return required icon
 *
 * @since 1.0
 * @return string
 */
function powerform_get_required_icon() {
	return '<span class="powerform-required">*</span>';
}

/**
 * Return week days
 *
 * @since 1.0
 * @return array
 */
function powerform_week_days() {
	return apply_filters(
		'powerform_week_days',
		array(
			'sunday'    => __( 'Sunday', Powerform::DOMAIN ),
			'monday'    => __( 'Monday', Powerform::DOMAIN ),
			'tuesday'   => __( 'Tuesday', Powerform::DOMAIN ),
			'wednesday' => __( 'Wednesday', Powerform::DOMAIN ),
			'thursday'  => __( 'Thursday', Powerform::DOMAIN ),
			'friday'    => __( 'Friday', Powerform::DOMAIN ),
			'saturday'  => __( 'Saturday', Powerform::DOMAIN ),
		)
	);
}

/**
 * Return name prefixes
 *
 * @since 1.0
 * @return array
 */
function powerform_get_name_prefixes() {
	return apply_filters(
		'powerform_name_prefixes',
		array(
			'Mr'   => __( 'Mr.', Powerform::DOMAIN ),
			'Mrs'  => __( 'Mrs.', Powerform::DOMAIN ),
			'Ms'   => __( 'Ms.', Powerform::DOMAIN ),
			'Miss' => __( 'Miss', Powerform::DOMAIN ),
			'Dr'   => __( 'Dr.', Powerform::DOMAIN ),
			'Prof' => __( 'Prof.', Powerform::DOMAIN ),
		)
	);
}

/**
 * Return field id by string
 *
 * @since 1.0
 *
 * @param $string
 *
 * @return mixed
 */
function powerform_clear_field_id( $string ) {
	$string = str_replace( '{', '', $string );
	$string = str_replace( '}', '', $string );

	return $string;
}

/**
 * Return filtered editor content with form data
 *
 * @since 1.0
 * @return mixed
 */
function powerform_replace_form_data( $content, $data, Powerform_Custom_Form_Model $custom_form = null, Powerform_Form_Entry_Model $entry = null ) {
	$matches     = array();
	$fields      = powerform_fields_to_array();
	$field_types = array_keys( $fields );

	$content = powerform_replace_form_payment_data( $content, $custom_form, $entry );

	$randomed_field_pattern  = 'field-\d+-\d+';
	$increment_field_pattern = sprintf( '(%s)-\d+', implode( '|', $field_types ) );
	$pattern                 = '/\{((' . $randomed_field_pattern . ')|(' . $increment_field_pattern . '))(\-[A-Za-z-_]+)?\}/';
	// Find all field ID's
	if ( preg_match_all( $pattern, $content, $matches ) ) {
		if ( ! isset( $matches[0] ) || ! is_array( $matches[0] ) ) {
			return $content;
		}
		foreach ( $matches[0] as $match ) {
			$element_id = powerform_clear_field_id( $match );

			// Check if field exist, if not we replace the ID with empty string
			if ( isset( $data[ $element_id ] ) && ! empty( $data[ $element_id ] ) ) {
				$value = $data[ $element_id ];
			} elseif ( ( strpos( $element_id, 'postdata' ) !== false
						|| strpos( $element_id, 'upload' ) !== false
						|| strpos( $element_id, 'calculation' ) !== false
						|| strpos( $element_id, 'html' ) !== false
						|| strpos( $element_id, 'section' ) !== false )
					&& $custom_form && $entry ) {
				$value = powerform_get_field_from_form_entry( $element_id, $custom_form, $data, $entry );
			} else {
				// element with suffixes, etc
				// use submitted `data` since its possible to disable DB storage,
				// causing Powerform_Form_Entry_Model = nothing
				// and cant be used as reference

				// DATE
				if ( false !== stripos( $element_id, 'date' ) ) {
					$day_element_id    = $element_id . '-day';
					$month_element_id  = $element_id . '-month';
					$year_element_id   = $element_id . '-year';
					$format_element_id = $element_id . '-format';

					if ( isset( $data[ $day_element_id ] ) && isset( $data[ $month_element_id ] ) && isset( $data[ $year_element_id ] ) ) {
						$meta_value = array(
							'day'    => $data[ $day_element_id ],
							'month'  => $data[ $month_element_id ],
							'year'   => $data[ $year_element_id ],
							'format' => $data[ $format_element_id ],
						);
						$value      = Powerform_Form_Entry_Model::meta_value_to_string( 'date', $meta_value, true );
					} else {
						$value = '';
					}
				} else {
					$value = '';
				}
			}

			// If array, convert it to string
			if ( is_array( $value ) ) {
				$value = implode( ', ', $value );
			}

			$content = str_replace( $match, $value, $content );
		}
	}

	return apply_filters( 'powerform_replace_form_data', $content, $data, $fields );
}

/**
 * Format custom form data variables to html formatted
 *
 * @since 1.0.3
 *
 * @param string                       $content
 * @param Powerform_Custom_Form_Model $custom_form
 * @param array                        $data - submitted `_POST` data
 * @param Powerform_Form_Entry_Model  $entry
 * @param array                        $excluded
 *
 * @return mixed
 */
function powerform_replace_custom_form_data( $content, Powerform_Custom_Form_Model $custom_form, $data, Powerform_Form_Entry_Model $entry, $excluded = array() ) {
	$custom_form_datas = array(
		'{all_fields}'           => 'powerform_get_formatted_form_entry',
		'{all_non_empty_fields}' => 'powerform_get_formatted_form_non_empty_entry',
		'{form_name}'            => 'powerform_get_formatted_form_name',
		'{submission_id}'        => 'powerform_get_submission_id',
		'{submission_url}'       => 'powerform_get_submission_url',
		'{account_approval_link}'=> 'powerform_get_account_approval_link',
		'{username}'             => 'powerform_get_formatted_username',
		'{line_break}'           => 'powerform_get_formatted_line_break',
	);

	foreach ( $custom_form_datas as $custom_form_data => $function ) {
		if ( in_array( $custom_form_data, $excluded, true ) ) {
			continue;
		}
		if ( strpos( $content, $custom_form_data ) !== false ) {
			if ( is_callable( $function ) ) {
				$replacer = call_user_func( $function, $custom_form, $data, $entry );
				$content  = str_replace( $custom_form_data, $replacer, $content );
			}
		}
	}

	return apply_filters( 'powerform_replace_custom_form_data', $content, $custom_form, $data, $entry, $excluded, $custom_form_datas );
}

/**
 * Get Html Formatted of form entry
 *
 * @since 1.0.3
 *
 * @param Powerform_Custom_Form_Model $custom_form
 * @param                              $data
 * @param Powerform_Form_Entry_Model  $entry
 *
 * @return string
 */
function powerform_get_formatted_form_entry( Powerform_Custom_Form_Model $custom_form, $data, Powerform_Form_Entry_Model $entry ) {
	$ignored_field_types   = Powerform_Form_Entry_Model::ignored_fields();
	$pseudo_submitted_data = Powerform_CForm_Front_Action::get_instance()->build_pseudo_submitted_data( $custom_form, $data );
	$form_fields           = $custom_form->get_fields();

	/**
	 * Filter form fields before displaying
	 *
	 * @since 1.11
	 *
	 * @param array $form_fields
	 * @param Powerform_Custom_Form_Model $custom_form
	 *
	 * @return array
	 */
	$form_fields = apply_filters( 'powerform_custom_form_before_form_fields', $form_fields, $custom_form, $data );
	if ( is_null( $form_fields ) ) {
		$form_fields = array();
	}
	$html = '<br/><ol>';

	foreach ( $form_fields as $form_field ) {
		$field_array    = $form_field->to_formatted_array();
		$field_forms    = powerform_fields_to_array();
		$field_type     = $field_array['type'];
		$form_field_obj = $field_forms[ $field_type ];
		if ( 'section' === $field_type && ! $form_field_obj->is_hidden( $field_array, $data, $pseudo_submitted_data ) ) {
			$value = $form_field->__get( 'section_title' );
			if ( ! empty( $value ) ) {
				$html .= '</ol>';
				$html .= '<h4><b>' . $value . '</b></h4>';
				$html .= '<ol>';
			}
		} elseif ( 'html' === $field_type && ! $form_field_obj->is_hidden( $field_array, $data, $pseudo_submitted_data ) ) {
			$label   = $form_field->__get( 'field_label' );
			$value   = $form_field->__get( 'variations' );
			$content = powerform_replace_form_data( $value, $data, $custom_form, $entry );
			$content = powerform_replace_variables( $content, $custom_form->id, $data['current_url'] );
			$content = powerform_replace_custom_form_data( $content, $custom_form, $data, $entry, array() );
			$html   .= '</ol>';
			if ( ! empty( $label ) ) {
				$html .= '<h4><b>' . $label . '</b></h4>';
			}
			$html   .= $content;
			$html   .= '<ol>';

		} else {
			if ( in_array( $field_type, $ignored_field_types, true ) || $form_field_obj->is_hidden( $field_array, $data, $pseudo_submitted_data ) ) {
				continue;
			}
			$value = render_entry( $entry, $form_field->slug );
			/**
			 * Filter value of a field that is not saved in DB
			 */
			$value = apply_filters( 'powerform_custom_form_after_render_value', $value, $custom_form, $form_field->slug, $data );
			$html  .= '<li>';
			$label = $form_field->get_label_for_entry();

			if ( ! empty( $label ) ) {
				$html .= '<b>' . $label . '</b><br/>';
			}
			if ( ! empty( $value ) ) {
				$html .= $value . '<br/>';
			}
			$html .= '</li>';
		}
	}
	$html .= '</ol><br/>';

	return apply_filters( 'powerform_get_formatted_form_entry', $html, $custom_form, $data, $entry, $ignored_field_types );
}

/**
 * Get Html Formatted of form entry
 *
 * @since 1.0.3
 *
 * @param Powerform_Custom_Form_Model $custom_form
 * @param                              $data
 * @param Powerform_Form_Entry_Model  $entry
 *
 * @return string
 */
function powerform_get_formatted_form_non_empty_entry( Powerform_Custom_Form_Model $custom_form, $data, Powerform_Form_Entry_Model $entry ) {
	$ignored_field_types   = Powerform_Form_Entry_Model::ignored_fields();
	$pseudo_submitted_data = Powerform_CForm_Front_Action::get_instance()->build_pseudo_submitted_data( $custom_form, $data );

	/**
	 * Filter form fields before displaying
	 */
	$form_fields = apply_filters( 'powerform_custom_form_before_form_fields', $custom_form->get_fields(), $custom_form, $data );
	if ( is_null( $form_fields ) ) {
		$form_fields = array();
	}
	$html = '<br/><ol>';

	foreach ( $form_fields as $form_field ) {
		$field_array    = $form_field->to_formatted_array();
		$field_forms    = powerform_fields_to_array();
		$field_type     = $field_array['type'];
		$form_field_obj = $field_forms[ $field_type ];
		if ( 'section' === $field_type && ! $form_field_obj->is_hidden( $field_array, $data, $pseudo_submitted_data ) ) {
			$value = $form_field->__get( 'section_title' );
			if ( ! empty( $value ) ) {
				$html .= '</ol>';
				$html .= '<h4><b>' . $value . '</b></h4>';
				$html .= '<ol>';
			}
		} elseif ( 'html' === $field_type && ! $form_field_obj->is_hidden( $field_array, $data, $pseudo_submitted_data ) ) {
			$label   = $form_field->__get( 'field_label' );
			$value   = $form_field->__get( 'variations' );
			$content = powerform_replace_form_data( $value, $data, $custom_form, $entry );
			$content = powerform_replace_variables( $content, $custom_form->id, $data['current_url'] );
			$content = powerform_replace_custom_form_data( $content, $custom_form, $data, $entry, array() );
			$html   .= '</ol>';
			if ( ! empty( $label ) ) {
				$html .= '<h4><b>' . $label . '</b></h4>';
			}
			$html   .= $content;
			$html   .= '<ol>';

		} else {
			if ( in_array( $field_type, $ignored_field_types, true ) || $form_field_obj->is_hidden( $field_array, $data, $pseudo_submitted_data ) ) {
				continue;
			}

			$value = render_entry( $entry, $form_field->slug );
			/**
			 * Filter value of a field that is not saved in DB
			 */
			$value = apply_filters( 'powerform_custom_form_after_render_value', $value, $custom_form, $form_field->slug, $data );

			if ( ! empty( $value ) ) {
				$html .= '<li>';
				$label = $form_field->get_label_for_entry();

				if ( ! empty( $label ) ) {
					$html .= '<b>' . $label . '</b><br/>';
				}
				$html .= $value . '<br/>';
				$html .= '</li>';
			}
		}
	}
	$html .= '</ol><br/>';

	return apply_filters( 'powerform_get_formatted_form_non_empty_entry', $html, $custom_form, $data, $entry, $ignored_field_types );
}

/**
 * Get field from registered entries
 *
 * @since 1.0.5
 *
 * @param                               $element_id
 * @param Powerform_Custom_Form_Model  $custom_form
 * @param                               $data
 * @param Powerform_Form_Entry_Model   $entry
 *
 * @return string
 */
function powerform_get_field_from_form_entry( $element_id, Powerform_Custom_Form_Model $custom_form, $data, Powerform_Form_Entry_Model $entry ) {
	$form_fields = $custom_form->get_fields();
	if ( is_null( $form_fields ) ) {
		$form_fields = array();
	}
	foreach ( $form_fields as $form_field ) {
		/** @var  Powerform_Form_Field_Model $form_field */
		if ( $form_field->slug !== $element_id ) {
			continue;
		}
		$field_type = $form_field->__get( 'type' );
		if ( 'section' === $field_type ) {
			$value = $form_field->__get( 'section_title' );
		} elseif ( 'html' === $field_type ) {
			$variations = $form_field->__get( 'variations' );
			$value      = powerform_replace_variables( $variations, $custom_form->id, $data['current_url'] );
		} else {
			$value = render_entry( $entry, $form_field->slug );
		}

		return $value;
	}
}

/**
 * Get Html Formatted of form name
 *
 * @since 1.0.3
 *
 * @param Powerform_Custom_Form_Model $custom_form
 * @param                              $data
 * @param Powerform_Form_Entry_Model  $entry
 *
 * @return string
 */
function powerform_get_formatted_form_name( Powerform_Custom_Form_Model $custom_form, $data, Powerform_Form_Entry_Model $entry ) {
	return esc_html( powerform_get_form_name( $custom_form->id, 'custom_form' ) );
}

/**
 * Get Submission ID
 *
 * @since 1.1
 *
 * @param Powerform_Custom_Form_Model $custom_form
 * @param                              $data
 * @param Powerform_Form_Entry_Model  $entry
 *
 * @return string
 */
function powerform_get_submission_id( Powerform_Custom_Form_Model $custom_form, $data, Powerform_Form_Entry_Model $entry ) {
	return esc_html( $entry->entry_id );
}

/**
 * Get referer url
 *
 * @since ?
 *
 * @param string $embed_url
 * @return string
 */
function powerform_get_referer_url( $embed_url = '' ) {
	$referer_url = "";
	if ( isset( $_REQUEST['extra'] ) && is_array( $_REQUEST['extra'] ) && isset( $_REQUEST['extra']['referer_url'] ) ) {
		$referer_url = sanitize_text_field( $_REQUEST['extra']['referer_url'] );
	} elseif ( isset( $_REQUEST['referer_url'] ) ) {
		$referer_url = sanitize_text_field( $_REQUEST['referer_url'] );
	} elseif ( isset ( $_SERVER['HTTP_REFERER'] ) ) {
		$referer_url = $_SERVER['HTTP_REFERER'];
	}

	if ( $referer_url == "" ) {
		$referer_url = $embed_url;
	}

	return $referer_url;
}

/*
 * Get Submission URL
 *
 * @since 1.11
 *
 * @param Powerform_Custom_Form_Model $custom_form
 * @param                              $data
 * @param Powerform_Form_Entry_Model  $entry
 *
 * @return string
 */
function powerform_get_submission_url( Powerform_Custom_Form_Model $custom_form, $data, Powerform_Form_Entry_Model $entry ) {
	return '<a href="'.esc_url( admin_url( 'admin.php?page=powerform-entries&form_type=powerform_forms&form_id='. $entry->form_id .'&entry_id='. $entry->entry_id ) ) .'">'. __( 'here', Powerform::DOMAIN ) .'</a>';// WPCS: XSS ok.
}

/**
 * Get account approval link
 *
 * @since 1.11
 *
 * @param Powerform_Custom_Form_Model $custom_form
 * @param                              $data
 * @param Powerform_Form_Entry_Model  $entry
 *
 * @return string
 */
function powerform_get_account_approval_link( Powerform_Custom_Form_Model $custom_form, $data, Powerform_Form_Entry_Model $entry ) {
	$key = $entry->get_meta( 'activation_key', '' );
	if ( ! empty( $key ) ) {
		$key = esc_url( add_query_arg( array( 'page' => 'powerform_activation', 'key' => $key ), home_url( '/' ) ) );
		$key = '<a href="'. $key .'" target="_blank">'. $key .'</a>';
	}

	return '<p>'. $key .'</p>';
}

/**
 * Get username from registration form
 *
 * @since 1.11
 *
 * @param Powerform_Custom_Form_Model $custom_form
 * @param                              $data
 * @param Powerform_Form_Entry_Model  $entry
 *
 * @return string
 */
function powerform_get_formatted_username ( Powerform_Custom_Form_Model $custom_form, $data, Powerform_Form_Entry_Model $entry ) {
	$username = '';
	if ( isset( $custom_form->settings['registration-username-field'] ) && ! empty( $custom_form->settings['registration-username-field'] ) ) {
		$username = $custom_form->settings['registration-username-field'];
		if ( isset( $data[$username] ) && ! empty( $data[$username] ) ) {
			$username = '<b>'. $data[$username] .'</b>';
		}
	}

	return $username;
}

/**
 * Get line break
 *
 * @since 1.11
 *
 * @return string
 */
function powerform_get_formatted_line_break () {
	return '&nbsp;<br/>';
}

/**
 * Return filtered editor content with replaced variables
 *
 * @since 1.0
 * @since 1.0.6 add `{form_id}` handle
 *
 * @param $content
 * @param $id
 * @param $data_current_url
 * @param $post_id
 *
 * @return string
 */
function powerform_replace_variables( $content, $id = false, $data_current_url = false, $post_id = null ) {
	$content_before_replacement = $content;

	// If we have no variables, skip
	if ( strpos( $content, '{' ) !== false ) {
		// Handle User IP Address variable
		$user_ip = powerform_user_ip();
		$content = str_replace( '{user_ip}', $user_ip, $content );

		// Handle Date (mm/dd/yyyy) variable
		$date_mdy = date_i18n( 'm/d/Y', powerform_local_timestamp(), true );
		$content  = str_replace( '{date_mdy}', $date_mdy, $content );

		// Handle Date (dd/mm/yyyy) variable
		$date_dmy = date_i18n( 'd/m/Y', powerform_local_timestamp(), true );
		$content  = str_replace( '{date_dmy}', $date_dmy, $content );

		// Handle Embed Post/Page ID variable
		$embed_post_id = powerform_get_post_data( 'ID', $post_id );
		$content       = str_replace( '{embed_id}', $embed_post_id, $content );

		// Handle Embed Post/Page Title variable
		$embed_title = powerform_get_post_data( 'post_title', $post_id );
		$content     = str_replace( '{embed_title}', $embed_title, $content );

		// Handle Embed URL variable
		$embed_url = $data_current_url ? $data_current_url : powerform_get_current_url();
		$content   = str_replace( '{embed_url}', $embed_url, $content );

		// Handle HTTP User Agent variable
		// some browser not sending HTTP_USER_AGENT or some servers probably stripped this value
		$user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
		$content    = str_replace( '{user_agent}', $user_agent, $content );

		// Handle site url variable
		$site_url = site_url();
		$content  = str_replace( '{site_url}', $site_url, $content );

		// Handle HTTP Refer URL variable
		$refer_url = powerform_get_referer_url( $embed_url );
		$content   = str_replace( '{refer_url}', $refer_url, $content );
		$content   = str_replace( '{http_refer}', $refer_url, $content );

		// Handle User ID variable
		$user_id = powerform_get_user_data( 'ID' );
		$content = str_replace( '{user_id}', $user_id, $content );

		// Handle User Display Name variable
		$user_name = powerform_get_user_data( 'display_name' );
		$content   = str_replace( '{user_name}', $user_name, $content );

		// Handle User Email variable
		$user_email = powerform_get_user_data( 'user_email' );
		$content    = str_replace( '{user_email}', $user_email, $content );

		// Handle User Login variable
		$user_login = powerform_get_user_data( 'user_login' );
		$content    = str_replace( '{user_login}', $user_login, $content );

		// Handle Submissions number
		$submissions_number = Powerform_Form_Entry_Model::count_entries( $id );
		$content            = str_replace( '{submissions_number}', $submissions_number, $content );

		// Handle form_name data
		if ( strpos( $content, '{form_name}' ) !== false ) {
			$form_name = ( false !== $id ) ? esc_html( powerform_get_form_name( $id, 'custom_form' ) ) : '';
			$content   = str_replace( '{form_name}', $form_name, $content );
		}

		// Handle site title variable
		$site_title = get_bloginfo( 'name' );
		$content  = str_replace( '{site_title}', $site_title, $content );

		// handle form_id
		if ( $id ) {
			$content = str_replace( '{form_id}', $id, $content );
		}
	}

	return apply_filters( 'powerform_replace_variables', $content, $content_before_replacement );
}

/**
 * Render entry
 * TODO: refactor this
 *
 * @since 1.0
 *
 * @param object $item        - the entry
 * @param string $column_name - the column name
 *
 * @param null   $field       @since 1.0.5, optional Powerform_Form_Field_Model
 * @param string $type
 *
 * @return string
 */
function render_entry( $item, $column_name, $field = null, $type = '' ) {
	$data = $item->get_meta( $column_name, '' );

	$is_calculation = false;
	if ( stripos( $column_name, 'calculation' ) !== false ) {
		$is_calculation = true;
	}

	if ( $is_calculation && $data ) {
		return Powerform_Form_Entry_Model::meta_value_to_string( 'calculation', $data, true );
	}

	if ( $data || '0' === $data ) {
		$currency_symbol = powerform_get_currency_symbol();
		if ( is_array( $data ) ) {
			if ( 'non_empty' === $type ) {
				$data = array_filter( $data );
			}
			if ( stripos( $column_name, 'time' ) !== false && 1 === count( $data ) && isset( $data['ampm'] ) ) {
				$data = array();
			}
			$output       = '';
			$product_cost = 0;
			$is_product   = false;
			$countries    = powerform_get_countries_list();

			if ( ! empty( $data ) ) {
				foreach ( $data as $key => $value ) {
					if ( is_array( $value ) ) {
						if ( 'file' === $key && isset( $value['file_url'] ) ) {
							$file_urls = is_array( $value['file_url'] ) ? $value['file_url'] : array( $value['file_url'] );
							foreach ( $file_urls as $file_url ) {
								$file_name = basename( $file_url );
								$file_name = "<a href='" . esc_url( $file_url ) . "' target='_blank' rel='noreferrer' title='" . __( 'View File', Powerform::DOMAIN ) . "'>$file_name</a><br>";
								$output    .= $file_name;
							}
						}

					} else {
						if ( ! is_int( $key ) ) {
							if ( 'postdata' === $key ) {
								// possible empty when postdata not required
								if ( ! empty( $value ) ) {
									$url    = get_edit_post_link( $value );
									$title  = get_the_title( $value );
									$name   = ! empty( $title ) ? $title : '(no title)';
									$output .= "<a href='" . $url . "' target='_blank' rel='noreferrer' title='" . __( 'Edit Post', Powerform::DOMAIN ) . "'>$name</a> ,";
								}
							} else {
								if ( is_string( $key ) ) {
									if ( 'product-id' === $key || 'product-quantity' === $key ) {
										if ( 0 === $product_cost ) {
											$product_cost = $value;
										} else {
											$product_cost = $product_cost * $value;
										}
										$is_product = true;
									} else {
										if ( 'country' === $key ) {
											if ( isset( $countries[ $value ] ) ) {
												$output .= sprintf( __( '<strong>Country: </strong> %s', Powerform::DOMAIN ), $countries[ $value ] ) . "<br/> ";
											} else {
												$output .= sprintf( __( '<strong>Country: </strong> %s', Powerform::DOMAIN ), $value ) . "<br/> ";
											}
										} else {
											if ( in_array( $key, Powerform_Form_Entry_Model::field_suffix(), true ) ) {
												$key = Powerform_Form_Entry_Model::translate_suffix( $key );
											} else {
												$key = strtolower( $key );
												$key = ucfirst( str_replace( array( '-', '_' ), ' ', $key ) );
											}
											$value  = esc_html( $value );
											$output .= sprintf( __( '<strong>%1$s : </strong> %2$s', Powerform::DOMAIN ), $key, $value ) . "<br/> ";
										}
										//Todo..remove duplicate code
										if ( false !== stripos( $key, 'name-' ) ) {
											$value = esc_html($value);
											/* translators: ... */
											$output .= sprintf(__('<strong>%1$s : </strong> %2$s', Powerform::DOMAIN), $key, $value) . '<br/> ';
										}
									}
								}
							}
						}
					}
				}
			}
			if ( $is_product ) {
				/* translators: ... */
				$output = sprintf( __( '<strong>Total</strong> %s', Powerform::DOMAIN ), $currency_symbol . '' . $product_cost );
			} else {
				if ( ! empty( $output ) ) {

				    if (
				        isset( $column_name ) &&
				        (
                            false !== strpos( $column_name, 'name' ) ||
                            false !== strpos( $column_name, 'address' ) ||
                            false !== strpos( $column_name, 'upload' ) ||
                            false !== strpos( $column_name, 'date' ) ||
                            false !== strpos( $column_name, 'time' ) ||
                            false !== strpos( $column_name, 'postdata' )
                        )
				    ) {
					    $output = trim( $output );
				    } else {
					    $output = substr( trim( $output ), 0, - 1 );
				    }

				} else {
					$output = implode( ', ', $data );
				}
			}

			return $output;
		} else {
			return $data;
		}
	}

	return '';
}

/**
 * Return countries list
 *
 * @since 1.0
 * @return array
 */
function powerform_get_countries_list() {
	$countries = array(
		'AF' => esc_html__( 'Afghanistan', Powerform::DOMAIN ),
		'AL' => esc_html__( 'Albania', Powerform::DOMAIN ),
		'DZ' => esc_html__( 'Algeria', Powerform::DOMAIN ),
		'AS' => esc_html__( 'American Samoa', Powerform::DOMAIN ),
		'AD' => esc_html__( 'Andorra', Powerform::DOMAIN ),
		'AO' => esc_html__( 'Angola', Powerform::DOMAIN ),
		'AI' => esc_html__( 'Anguilla', Powerform::DOMAIN ),
		'AQ' => esc_html__( 'Antarctica', Powerform::DOMAIN ),
		'AG' => esc_html__( 'Antigua and Barbuda', Powerform::DOMAIN ),
		'AR' => esc_html__( 'Argentina', Powerform::DOMAIN ),
		'AM' => esc_html__( 'Armenia', Powerform::DOMAIN ),
		'AU' => esc_html__( 'Australia', Powerform::DOMAIN ),
		'AW' => esc_html__( 'Aruba', Powerform::DOMAIN ),
		'AT' => esc_html__( 'Austria', Powerform::DOMAIN ),
		'AZ' => esc_html__( 'Azerbaijan', Powerform::DOMAIN ),
		'BS' => esc_html__( 'Bahamas', Powerform::DOMAIN ),
		'BH' => esc_html__( 'Bahrain', Powerform::DOMAIN ),
		'BD' => esc_html__( 'Bangladesh', Powerform::DOMAIN ),
		'BB' => esc_html__( 'Barbados', Powerform::DOMAIN ),
		'BY' => esc_html__( 'Belarus', Powerform::DOMAIN ),
		'BE' => esc_html__( 'Belgium', Powerform::DOMAIN ),
		'BZ' => esc_html__( 'Belize', Powerform::DOMAIN ),
		'BJ' => esc_html__( 'Benin', Powerform::DOMAIN ),
		'BM' => esc_html__( 'Bermuda', Powerform::DOMAIN ),
		'BT' => esc_html__( 'Bhutan', Powerform::DOMAIN ),
		'BO' => esc_html__( 'Bolivia', Powerform::DOMAIN ),
		'BA' => esc_html__( 'Bosnia and Herzegovina', Powerform::DOMAIN ),
		'BW' => esc_html__( 'Botswana', Powerform::DOMAIN ),
		'BV' => esc_html__( 'Bouvet Island', Powerform::DOMAIN ),
		'BR' => esc_html__( 'Brazil', Powerform::DOMAIN ),
		'IO' => esc_html__( 'British Indian Ocean Territory', Powerform::DOMAIN ),
		'BN' => esc_html__( 'Brunei', Powerform::DOMAIN ),
		'BG' => esc_html__( 'Bulgaria', Powerform::DOMAIN ),
		'BF' => esc_html__( 'Burkina Faso', Powerform::DOMAIN ),
		'BI' => esc_html__( 'Burundi', Powerform::DOMAIN ),
		'KH' => esc_html__( 'Cambodia', Powerform::DOMAIN ),
		'CM' => esc_html__( 'Cameroon', Powerform::DOMAIN ),
		'CA' => esc_html__( 'Canada', Powerform::DOMAIN ),
		'CV' => esc_html__( 'Cape Verde', Powerform::DOMAIN ),
		'KY' => esc_html__( 'Cayman Islands', Powerform::DOMAIN ),
		'CF' => esc_html__( 'Central African Republic', Powerform::DOMAIN ),
		'TD' => esc_html__( 'Chad', Powerform::DOMAIN ),
		'CL' => esc_html__( 'Chile', Powerform::DOMAIN ),
		'CN' => esc_html__( 'China, People\'s Republic of', Powerform::DOMAIN ),
		'CX' => esc_html__( 'Christmas Island', Powerform::DOMAIN ),
		'CC' => esc_html__( 'Cocos Islands', Powerform::DOMAIN ),
		'CO' => esc_html__( 'Colombia', Powerform::DOMAIN ),
		'KM' => esc_html__( 'Comoros', Powerform::DOMAIN ),
		'CD' => esc_html__( 'Congo, Democratic Republic of the', Powerform::DOMAIN ),
		'CG' => esc_html__( 'Congo, Republic of the', Powerform::DOMAIN ),
		'CK' => esc_html__( 'Cook Islands', Powerform::DOMAIN ),
		'CR' => esc_html__( 'Costa Rica', Powerform::DOMAIN ),
		'CI' => esc_html__( "Côte d'Ivoire", Powerform::DOMAIN ),
		'HR' => esc_html__( 'Croatia', Powerform::DOMAIN ),
		'CU' => esc_html__( 'Cuba', Powerform::DOMAIN ),
		'CW' => esc_html__( 'Curaçao', Powerform::DOMAIN ),
		'CY' => esc_html__( 'Cyprus', Powerform::DOMAIN ),
		'CZ' => esc_html__( 'Czech Republic', Powerform::DOMAIN ),
		'DK' => esc_html__( 'Denmark', Powerform::DOMAIN ),
		'DJ' => esc_html__( 'Djibouti', Powerform::DOMAIN ),
		'DM' => esc_html__( 'Dominica', Powerform::DOMAIN ),
		'DO' => esc_html__( 'Dominican Republic', Powerform::DOMAIN ),
		'TL' => esc_html__( 'East Timor', Powerform::DOMAIN ),
		'EC' => esc_html__( 'Ecuador', Powerform::DOMAIN ),
		'EG' => esc_html__( 'Egypt', Powerform::DOMAIN ),
		'SV' => esc_html__( 'El Salvador', Powerform::DOMAIN ),
		'GQ' => esc_html__( 'Equatorial Guinea', Powerform::DOMAIN ),
		'ER' => esc_html__( 'Eritrea', Powerform::DOMAIN ),
		'EE' => esc_html__( 'Estonia', Powerform::DOMAIN ),
		'ET' => esc_html__( 'Ethiopia', Powerform::DOMAIN ),
		'FK' => esc_html__( 'Falkland Islands', Powerform::DOMAIN ),
		'FO' => esc_html__( 'Faroe Islands', Powerform::DOMAIN ),
		'FJ' => esc_html__( 'Fiji', Powerform::DOMAIN ),
		'FI' => esc_html__( 'Finland', Powerform::DOMAIN ),
		'FR' => esc_html__( 'France', Powerform::DOMAIN ),
		'FX' => esc_html__( 'France, Metropolitan', Powerform::DOMAIN ),
		'GF' => esc_html__( 'French Guiana', Powerform::DOMAIN ),
		'PF' => esc_html__( 'French Polynesia', Powerform::DOMAIN ),
		'TF' => esc_html__( 'French South Territories', Powerform::DOMAIN ),
		'GA' => esc_html__( 'Gabon', Powerform::DOMAIN ),
		'GM' => esc_html__( 'Gambia', Powerform::DOMAIN ),
		'GE' => esc_html__( 'Georgia', Powerform::DOMAIN ),
		'DE' => esc_html__( 'Germany', Powerform::DOMAIN ),
		'GH' => esc_html__( 'Ghana', Powerform::DOMAIN ),
		'GI' => esc_html__( 'Gibraltar', Powerform::DOMAIN ),
		'GR' => esc_html__( 'Greece', Powerform::DOMAIN ),
		'GL' => esc_html__( 'Greenland', Powerform::DOMAIN ),
		'GD' => esc_html__( 'Grenada', Powerform::DOMAIN ),
		'GP' => esc_html__( 'Guadeloupe', Powerform::DOMAIN ),
		'GU' => esc_html__( 'Guam', Powerform::DOMAIN ),
		'GT' => esc_html__( 'Guatemala', Powerform::DOMAIN ),
		'GN' => esc_html__( 'Guinea', Powerform::DOMAIN ),
		'GW' => esc_html__( 'Guinea-Bissau', Powerform::DOMAIN ),
		'GY' => esc_html__( 'Guyana', Powerform::DOMAIN ),
		'HT' => esc_html__( 'Haiti', Powerform::DOMAIN ),
		'HM' => esc_html__( 'Heard Island And Mcdonald Island', Powerform::DOMAIN ),
		'HN' => esc_html__( 'Honduras', Powerform::DOMAIN ),
		'HK' => esc_html__( 'Hong Kong', Powerform::DOMAIN ),
		'HU' => esc_html__( 'Hungary', Powerform::DOMAIN ),
		'IS' => esc_html__( 'Iceland', Powerform::DOMAIN ),
		'IN' => esc_html__( 'India', Powerform::DOMAIN ),
		'ID' => esc_html__( 'Indonesia', Powerform::DOMAIN ),
		'IR' => esc_html__( 'Iran', Powerform::DOMAIN ),
		'IQ' => esc_html__( 'Iraq', Powerform::DOMAIN ),
		'IE' => esc_html__( 'Ireland', Powerform::DOMAIN ),
		'IL' => esc_html__( 'Israel', Powerform::DOMAIN ),
		'IT' => esc_html__( 'Italy', Powerform::DOMAIN ),
		'JM' => esc_html__( 'Jamaica', Powerform::DOMAIN ),
		'JP' => esc_html__( 'Japan', Powerform::DOMAIN ),
		'JT' => esc_html__( 'Johnston Island', Powerform::DOMAIN ),
		'JO' => esc_html__( 'Jordan', Powerform::DOMAIN ),
		'KZ' => esc_html__( 'Kazakhstan', Powerform::DOMAIN ),
		'KE' => esc_html__( 'Kenya', Powerform::DOMAIN ),
		'KI' => esc_html__( 'Kiribati', Powerform::DOMAIN ),
		'KP' => esc_html__( 'Korea, Democratic People\'s Republic of', Powerform::DOMAIN ),
		'KR' => esc_html__( 'Korea, Republic of', Powerform::DOMAIN ),
		'XK' => esc_html__( 'Kosovo', Powerform::DOMAIN ),
		'KW' => esc_html__( 'Kuwait', Powerform::DOMAIN ),
		'KG' => esc_html__( 'Kyrgyzstan', Powerform::DOMAIN ),
		'LA' => esc_html__( 'Lao People\'s Democratic Republic', Powerform::DOMAIN ),
		'LV' => esc_html__( 'Latvia', Powerform::DOMAIN ),
		'LB' => esc_html__( 'Lebanon', Powerform::DOMAIN ),
		'LS' => esc_html__( 'Lesotho', Powerform::DOMAIN ),
		'LR' => esc_html__( 'Liberia', Powerform::DOMAIN ),
		'LY' => esc_html__( 'Libya', Powerform::DOMAIN ),
		'LI' => esc_html__( 'Liechtenstein', Powerform::DOMAIN ),
		'LT' => esc_html__( 'Lithuania', Powerform::DOMAIN ),
		'LU' => esc_html__( 'Luxembourg', Powerform::DOMAIN ),
		'MO' => esc_html__( 'Macau', Powerform::DOMAIN ),
		'MK' => esc_html__( 'North Macedonia', Powerform::DOMAIN ),
		'MG' => esc_html__( 'Madagascar', Powerform::DOMAIN ),
		'MW' => esc_html__( 'Malawi', Powerform::DOMAIN ),
		'MY' => esc_html__( 'Malaysia', Powerform::DOMAIN ),
		'MV' => esc_html__( 'Maldives', Powerform::DOMAIN ),
		'ML' => esc_html__( 'Mali', Powerform::DOMAIN ),
		'MT' => esc_html__( 'Malta', Powerform::DOMAIN ),
		'MH' => esc_html__( 'Marshall Islands', Powerform::DOMAIN ),
		'MQ' => esc_html__( 'Martinique', Powerform::DOMAIN ),
		'MR' => esc_html__( 'Mauritania', Powerform::DOMAIN ),
		'MU' => esc_html__( 'Mauritius', Powerform::DOMAIN ),
		'YT' => esc_html__( 'Mayotte', Powerform::DOMAIN ),
		'MX' => esc_html__( 'Mexico', Powerform::DOMAIN ),
		'FM' => esc_html__( 'Micronesia', Powerform::DOMAIN ),
		'MD' => esc_html__( 'Moldova', Powerform::DOMAIN ),
		'MC' => esc_html__( 'Monaco', Powerform::DOMAIN ),
		'MN' => esc_html__( 'Mongolia', Powerform::DOMAIN ),
		'MS' => esc_html__( 'Montserrat', Powerform::DOMAIN ),
		'ME' => esc_html__( 'Montenegro', Powerform::DOMAIN ),
		'MA' => esc_html__( 'Morocco', Powerform::DOMAIN ),
		'MZ' => esc_html__( 'Mozambique', Powerform::DOMAIN ),
		'MM' => esc_html__( 'Myanmar', Powerform::DOMAIN ),
		'NA' => esc_html__( 'Namibia', Powerform::DOMAIN ),
		'NR' => esc_html__( 'Nauru', Powerform::DOMAIN ),
		'NP' => esc_html__( 'Nepal', Powerform::DOMAIN ),
		'NL' => esc_html__( 'Netherlands', Powerform::DOMAIN ),
		'AN' => esc_html__( 'Netherlands Antilles', Powerform::DOMAIN ),
		'NC' => esc_html__( 'New Caledonia', Powerform::DOMAIN ),
		'NZ' => esc_html__( 'New Zealand', Powerform::DOMAIN ),
		'NI' => esc_html__( 'Nicaragua', Powerform::DOMAIN ),
		'NE' => esc_html__( 'Niger', Powerform::DOMAIN ),
		'NG' => esc_html__( 'Nigeria', Powerform::DOMAIN ),
		'NU' => esc_html__( 'Niue', Powerform::DOMAIN ),
		'NF' => esc_html__( 'Norfolk Island', Powerform::DOMAIN ),
		'MP' => esc_html__( 'Northern Mariana Islands', Powerform::DOMAIN ),
		'NO' => esc_html__( 'Norway', Powerform::DOMAIN ),
		'OM' => esc_html__( 'Oman', Powerform::DOMAIN ),
		'PK' => esc_html__( 'Pakistan', Powerform::DOMAIN ),
		'PW' => esc_html__( 'Palau', Powerform::DOMAIN ),
		'PS' => esc_html__( 'Palestine, State of', Powerform::DOMAIN ),
		'PA' => esc_html__( 'Panama', Powerform::DOMAIN ),
		'PG' => esc_html__( 'Papua New Guinea', Powerform::DOMAIN ),
		'PY' => esc_html__( 'Paraguay', Powerform::DOMAIN ),
		'PE' => esc_html__( 'Peru', Powerform::DOMAIN ),
		'PH' => esc_html__( 'Philippines', Powerform::DOMAIN ),
		'PN' => esc_html__( 'Pitcairn Islands', Powerform::DOMAIN ),
		'PL' => esc_html__( 'Poland', Powerform::DOMAIN ),
		'PT' => esc_html__( 'Portugal', Powerform::DOMAIN ),
		'PR' => esc_html__( 'Puerto Rico', Powerform::DOMAIN ),
		'QA' => esc_html__( 'Qatar', Powerform::DOMAIN ),
		'RE' => esc_html__( 'Reunion Island', Powerform::DOMAIN ),
		'RO' => esc_html__( 'Romania', Powerform::DOMAIN ),
		'RU' => esc_html__( 'Russia', Powerform::DOMAIN ),
		'RW' => esc_html__( 'Rwanda', Powerform::DOMAIN ),
		'KN' => esc_html__( 'Saint Kitts and Nevis', Powerform::DOMAIN ),
		'LC' => esc_html__( 'Saint Lucia', Powerform::DOMAIN ),
		'VC' => esc_html__( 'Saint Vincent and the Grenadines', Powerform::DOMAIN ),
		'WS' => esc_html__( 'Samoa', Powerform::DOMAIN ),
		'SH' => esc_html__( 'Saint Helena', Powerform::DOMAIN ),
		'PM' => esc_html__( 'Saint Pierre & Miquelon', Powerform::DOMAIN ),
		'SM' => esc_html__( 'San Marino', Powerform::DOMAIN ),
		'ST' => esc_html__( 'Sao Tome and Principe', Powerform::DOMAIN ),
		'SA' => esc_html__( 'Saudi Arabia', Powerform::DOMAIN ),
		'SN' => esc_html__( 'Senegal', Powerform::DOMAIN ),
		'RS' => esc_html__( 'Serbia', Powerform::DOMAIN ),
		'SC' => esc_html__( 'Seychelles', Powerform::DOMAIN ),
		'SL' => esc_html__( 'Sierra Leone', Powerform::DOMAIN ),
		'SG' => esc_html__( 'Singapore', Powerform::DOMAIN ),
		'MF' => esc_html__( 'Sint Maarten', Powerform::DOMAIN ),
		'SK' => esc_html__( 'Slovakia', Powerform::DOMAIN ),
		'SI' => esc_html__( 'Slovenia', Powerform::DOMAIN ),
		'SB' => esc_html__( 'Solomon Islands', Powerform::DOMAIN ),
		'SO' => esc_html__( 'Somalia', Powerform::DOMAIN ),
		'ZA' => esc_html__( 'South Africa', Powerform::DOMAIN ),
		'GS' => esc_html__( 'South Georgia and South Sandwich', Powerform::DOMAIN ),
		'ES' => esc_html__( 'Spain', Powerform::DOMAIN ),
		'LK' => esc_html__( 'Sri Lanka', Powerform::DOMAIN ),
		'XX' => esc_html__( 'Stateless Persons', Powerform::DOMAIN ),
		'SD' => esc_html__( 'Sudan', Powerform::DOMAIN ),
		'SS' => esc_html__( 'Sudan, South', Powerform::DOMAIN ),
		'SR' => esc_html__( 'Suriname', Powerform::DOMAIN ),
		'SJ' => esc_html__( 'Svalbard and Jan Mayen', Powerform::DOMAIN ),
		'SZ' => esc_html__( 'Swaziland', Powerform::DOMAIN ),
		'SE' => esc_html__( 'Sweden', Powerform::DOMAIN ),
		'CH' => esc_html__( 'Switzerland', Powerform::DOMAIN ),
		'SY' => esc_html__( 'Syria', Powerform::DOMAIN ),
		'TW' => esc_html__( 'Taiwan, Republic of China', Powerform::DOMAIN ),
		'TJ' => esc_html__( 'Tajikistan', Powerform::DOMAIN ),
		'TZ' => esc_html__( 'Tanzania', Powerform::DOMAIN ),
		'TH' => esc_html__( 'Thailand', Powerform::DOMAIN ),
		'TG' => esc_html__( 'Togo', Powerform::DOMAIN ),
		'TK' => esc_html__( 'Tokelau', Powerform::DOMAIN ),
		'TO' => esc_html__( 'Tonga', Powerform::DOMAIN ),
		'TT' => esc_html__( 'Trinidad and Tobago', Powerform::DOMAIN ),
		'TN' => esc_html__( 'Tunisia', Powerform::DOMAIN ),
		'TR' => esc_html__( 'Turkey', Powerform::DOMAIN ),
		'TM' => esc_html__( 'Turkmenistan', Powerform::DOMAIN ),
		'TC' => esc_html__( 'Turks And Caicos Islands', Powerform::DOMAIN ),
		'TV' => esc_html__( 'Tuvalu', Powerform::DOMAIN ),
		'UG' => esc_html__( 'Uganda', Powerform::DOMAIN ),
		'UA' => esc_html__( 'Ukraine', Powerform::DOMAIN ),
		'AE' => esc_html__( 'United Arab Emirates', Powerform::DOMAIN ),
		'GB' => esc_html__( 'United Kingdom', Powerform::DOMAIN ),
		'UM' => esc_html__( 'US Minor Outlying Islands', Powerform::DOMAIN ),
		'US' => esc_html__( 'United States of America (USA)', Powerform::DOMAIN ),
		'UY' => esc_html__( 'Uruguay', Powerform::DOMAIN ),
		'UZ' => esc_html__( 'Uzbekistan', Powerform::DOMAIN ),
		'VU' => esc_html__( 'Vanuatu', Powerform::DOMAIN ),
		'VA' => esc_html__( 'Vatican City', Powerform::DOMAIN ),
		'VE' => esc_html__( 'Venezuela', Powerform::DOMAIN ),
		'VN' => esc_html__( 'Vietnam', Powerform::DOMAIN ),
		'VG' => esc_html__( 'Virgin Islands, British', Powerform::DOMAIN ),
		'VI' => esc_html__( 'Virgin Islands, U.S.', Powerform::DOMAIN ),
		'WF' => esc_html__( 'Wallis And Futuna Islands', Powerform::DOMAIN ),
		'EH' => esc_html__( 'Western Sahara', Powerform::DOMAIN ),
		'YE' => esc_html__( 'Yemen Arab Rep.', Powerform::DOMAIN ),
		'YD' => esc_html__( 'Yemen Democratic', Powerform::DOMAIN ),
		'ZM' => esc_html__( 'Zambia', Powerform::DOMAIN ),
		'ZW' => esc_html__( 'Zimbabwe', Powerform::DOMAIN ),
	);

	asort( $countries );
	
	return apply_filters( 'powerform_countries_list', $countries );
}

/**
 * Return sorted available fields
 *
 * @since 1.6
 *
 * @param     $sort_attr
 * @param int $sort_flag
 *
 * @return array
 */
function powerform_get_fields_sorted( $sort_attr, $sort_flag = SORT_ASC ) {
	$fields       = array();
	$fields_array = powerform_get_fields();

	if ( ! empty( $fields_array ) ) {
		foreach ( $fields_array as $key => $field ) {
			$field_key = '';
			if ( isset( $field->$sort_attr ) ) {
				$field_key = $field->$sort_attr;
			}

			if ( ! empty( $field_key ) ) {
				if ( isset( $fields[ $field_key ] ) ) {
					if ( is_int( $field_key ) ) {
						$field_key = max( array_keys( $fields ) );
						$field_key ++;// increase where there is dupe
					}
				}
				$fields[ $field_key ] = $field;
			} else {
				$fields[] = $field;
			}
		}
	}

	if ( SORT_ASC === $sort_flag ) {
		ksort( $fields );
	} else {
		krsort( $fields );
	}

	$fields = array_values( $fields );

	return apply_filters( 'powerform_fields_sorted', $fields, $fields_array, $sort_attr, $sort_flag );
}

/**
 * Retrieves the list of common file extensions and their types.
 *
 * extending @see get_allowed_mime_types without filter
 *
 * @since 1.6
 */
function powerform_get_ext_types() {
	/**
	 * - image
	 * - audio
	 * - video
	 * - text
	 * - Doc
	 * - Archive
	 * - Interactive
	 */

	$powerform_types = array(
		'image'       => array(
			// Image formats
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif'          => 'image/gif',
			'png'          => 'image/png',
			'bmp'          => 'image/bmp',
			'tiff|tif'     => 'image/tiff',
			'ico'          => 'image/x-icon',
			'psd'          => 'application/octet-stream',
			'xcf'          => 'application/octet-stream',
		),
		'audio'       => array(
			// Audio formats
			'mp3|m4a|m4b' => 'audio/mpeg',
			'ra|ram'      => 'audio/x-realaudio',
			'wav'         => 'audio/wav',
			'ogg|oga'     => 'audio/ogg',
			'mid|midi'    => 'audio/midi',
			'wma'         => 'audio/x-ms-wma',
			'wax'         => 'audio/x-ms-wax',
			'mka'         => 'audio/x-matroska',
			'aac'         => 'audio/aac',
			'flac'        => 'audio/flac',
		),
		'video'       => array(
			'asf|asx'      => 'video/x-ms-asf',
			'wmv'          => 'video/x-ms-wmv',
			'wmx'          => 'video/x-ms-wmx',
			'wm'           => 'video/x-ms-wm',
			'avi'          => 'video/avi',
			'divx'         => 'video/divx',
			'flv'          => 'video/x-flv',
			'mov|qt'       => 'video/quicktime',
			'mpeg|mpg|mpe' => 'video/mpeg',
			'mp4|m4v'      => 'video/mp4',
			'ogv'          => 'video/ogg',
			'webm'         => 'video/webm',
			'mkv'          => 'video/x-matroska',
			'3gp|3gpp'     => 'video/3gpp', // Can also be audio
			'3g2|3gp2'     => 'video/3gpp2', // Can also be audio
		),
		'document'    => array(
			// MS Office formats
			'doc'                          => 'application/msword',
			'pot|pps|ppt'                  => 'application/vnd.ms-powerpoint',
			'wri'                          => 'application/vnd.ms-write',

			'mdb'                          => 'application/vnd.ms-access',
			'mpp'                          => 'application/vnd.ms-project',
			'docx'                         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'docm'                         => 'application/vnd.ms-word.document.macroEnabled.12',
			'dotx'                         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
			'dotm'                         => 'application/vnd.ms-word.template.macroEnabled.12',

			'onetoc|onetoc2|onetmp|onepkg' => 'application/onenote',

			// OpenOffice formats
			'odt'                          => 'application/vnd.oasis.opendocument.text',
			'odp'                          => 'application/vnd.oasis.opendocument.presentation',
			'odg'                          => 'application/vnd.oasis.opendocument.graphics',
			'odc'                          => 'application/vnd.oasis.opendocument.chart',
			'odb'                          => 'application/vnd.oasis.opendocument.database',
			'odf'                          => 'application/vnd.oasis.opendocument.formula',

			'pages'                        => 'application/vnd.apple.pages',

			'wp|wpd'                       => 'application/wordperfect',

			'pdf'                          => 'application/pdf',
			'oxps'                         => 'application/oxps',
			'xps'                          => 'application/vnd.ms-xpsdocument',

		),
		'archive'     => array(
			'tar'     => 'application/x-tar',
			'zip'     => 'application/zip',
			'gz|gzip' => 'application/x-gzip',
			'rar'     => 'application/rar',
			'7z'      => 'application/x-7z-compressed',
		),
		'text'        => array(
			// Text formats
			'txt|asc|c|cc|h|srt' => 'text/plain',
			'csv'                => 'text/csv',
			'tsv'                => 'text/tab-separated-values',
			'ics'                => 'text/calendar',
			'rtx'                => 'text/richtext',
			'css'                => 'text/css',
			'htm|html'           => 'text/html',

			'rtf'                => 'application/rtf',
			'js'                 => 'application/javascript',
			'vtt'                => 'text/vtt',
			'dfxp'               => 'application/ttaf+xml',
		),
		'spreadsheet' => array(
			'xla|xls|xlt|xlw' => 'application/vnd.ms-excel',
			'xlsx'            => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'xlsm'            => 'application/vnd.ms-excel.sheet.macroEnabled.12',
			'xlsb'            => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
			'xltx'            => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
			'xltm'            => 'application/vnd.ms-excel.template.macroEnabled.12',
			'xlam'            => 'application/vnd.ms-excel.addin.macroEnabled.12',
			'ods'             => 'application/vnd.oasis.opendocument.spreadsheet',
			'numbers'         => 'application/vnd.apple.numbers',
		),
		'interactive' => array(
			'swf'   => 'application/x-shockwave-flash',
			'class' => 'application/java',
			'exe'   => 'application/x-msdownload',
			'key'   => 'application/vnd.apple.keynote',
			'pptx'  => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'pptm'  => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
			'ppsx'  => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
			'ppsm'  => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
			'potx'  => 'application/vnd.openxmlformats-officedocument.presentationml.template',
			'potm'  => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
			'ppam'  => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
			'sldx'  => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
			'sldm'  => 'application/vnd.ms-powerpoint.slide.macroEnabled.12',
		),
	);

	foreach ( $powerform_types as $type => $powerform_type ) {
		$powerform_types[ $type ] = array_keys( $powerform_type );
	}

	/**
	 * Filter extensions types of files
	 *
	 * @since 1.6
	 *
	 * @param array $powerform_types
	 */
	$powerform_types = apply_filters( 'powerform_get_ext_types', $powerform_types );

	return $powerform_types;
}

/**
 * Format poll data variables to html formatted
 *
 * @since 1.6.1
 *
 * @param string                      $content
 * @param Powerform_Poll_Form_Model  $poll
 * @param array                       $data - submitted `_POST` data
 * @param Powerform_Form_Entry_Model $entry
 *
 * @return mixed
 */
function powerform_replace_poll_form_data( $content, Powerform_Poll_Form_Model $poll, $data, Powerform_Form_Entry_Model $entry ) {
	if ( stripos( $content, '{poll_name}' ) !== false ) {
		$poll_name = powerform_get_name_from_model( $poll );
		$content   = str_ireplace( '{poll_name}', $poll_name, $content );
	}

	if ( stripos( $content, '{poll_answer}' ) !== false ) {
		$answer_data   = isset( $data[ $poll->id ] ) ? $data[ $poll->id ] : '';
		$extra_field   = isset( $data[ $poll->id . '-extra' ] ) ? $data[ $poll->id . '-extra' ] : '';
		$fields_labels = $poll->pluck_fields_array( 'title', 'element_id', '1' );

		$answer_label = isset( $fields_labels[ $answer_data ] ) ? $fields_labels[ $answer_data ] : '';
		if ( ! empty( $extra_field ) ) {
			$answer_label .= ' ' . $extra_field;
		}
		$content = str_ireplace( '{poll_answer}', $answer_label, $content );
	}

	if ( stripos( $content, '{poll_result}' ) !== false ) {
		$poll_results = array();
		$fields_array = $poll->get_fields_as_array();
		$map_entries  = Powerform_Form_Entry_Model::map_polls_entries( $poll->id, $fields_array );
		$fields       = $poll->get_fields();
		if ( ! is_null( $fields ) ) {
			foreach ( $fields as $field ) {
				$label = addslashes( $field->title );

				$slug    = isset( $field->slug ) ? $field->slug : sanitize_title( $label );
				$entries = 0;
				if ( in_array( $slug, array_keys( $map_entries ), true ) ) {
					$entries = $map_entries[ $slug ];
				}
				$poll_results[] = array(
					'label' => $label,
					'value' => $entries,
				);
			}
		}

		$poll_results_html = '<ul>';
		foreach ( $poll_results as $poll_result ) {
			$poll_results_html .= '<li>';
			$poll_results_html .= '<strong>' . $poll_result['label'] . '</strong> : ' . $poll_result['value'];
			$poll_results_html .= '</li>';
		}
		$poll_results_html .= '</ul>';
		$content            = str_ireplace( '{poll_result}', $poll_results_html, $content );
	}

	return apply_filters( 'powerform_replace_poll_form_data', $content, $poll, $data, $entry );
}

/**
 * Return vars for poll
 *
 * @since 1.6.1
 * @return mixed
 */
function powerform_get_poll_vars() {
	$vars_list = array(
		'poll_name'   => esc_html__( 'Poll Name', Powerform::DOMAIN ),
		'poll_answer' => esc_html__( 'Poll Answer', Powerform::DOMAIN ),
		'poll_result' => esc_html__( 'Poll Result', Powerform::DOMAIN ),
	);

	/**
	 * Filter powerform Poll var list
	 *
	 * @see   powerform_replace_poll_form_data()
	 *
	 * @since 1.6.1
	 *
	 * @param array $vars_list
	 */
	return apply_filters( 'powerform_poll_vars_list', $vars_list );
}

/**
 * Format quiz data variables to html formatted
 *
 * @since 1.6.2
 *
 * @param string                      $content
 * @param Powerform_Quiz_Form_Model  $quiz
 * @param array                       $data - submitted `_POST` data
 * @param Powerform_Form_Entry_Model $entry
 *
 * @return mixed
 */
function powerform_replace_quiz_form_data( $content, Powerform_Quiz_Form_Model $quiz, $data, Powerform_Form_Entry_Model $entry ) {

	if ( stripos( $content, '{quiz_name}' ) !== false ) {
		$quiz_name = powerform_get_name_from_model( $quiz );
		$content   = str_ireplace( '{quiz_name}', $quiz_name, $content );
	}

	if ( stripos( $content, '{quiz_type}' ) !== false ) {
		$quiz_type = '';
		if ( 'knowledge' === $quiz->quiz_type ) {
			$quiz_type = 'Knowledge';
		} elseif ( 'nowrong' === $quiz->quiz_type ) {
			$quiz_type = 'Personality';
		}
		$content = str_ireplace( '{quiz_type}', $quiz_type, $content );
	}

	if ( stripos( $content, '{quiz_answer}' ) !== false ) {
		$answer_content = PHP_EOL . '<ul>' . PHP_EOL;
		$answers        = isset( $data['answers'] ) ? $data['answers'] : array();
		if ( is_array( $answers ) ) {
			foreach ( $answers as $question_id => $answer_id ) {
				$question = $quiz->getQuestion( $question_id );
				$answer   = $quiz->getAnswer( $question_id, $answer_id );

				$question_text = isset( $question['title'] ) ? $question['title'] : '';
				$answer_text   = isset( $answer['title'] ) ? $answer['title'] : '';

				$answer_content .= '<li>' . PHP_EOL;

				$answer_content .= '<ul>' . PHP_EOL;
				$answer_content .= '<li><b>' . esc_html__( 'Question : ', Powerform::DOMAIN ) . '</b>' . esc_html( $question_text ) . '</li>' . PHP_EOL;
				$answer_content .= '<li><b>' . esc_html__( 'Answer : ', Powerform::DOMAIN ) . '</b>' . esc_html( $answer_text ) . '</li>' . PHP_EOL;
				$answer_content .= '</ul>' . PHP_EOL;

				$answer_content .= '</li>' . PHP_EOL;
			}
		}
		$answer_content .= '</ul>';

		$content = str_ireplace( '{quiz_answer}', $answer_content, $content );

	}

	if ( stripos( $content, '{quiz_result}' ) !== false ) {
		$result_content = '';
		// we saved on $entry->meta_data['entry']['value'] => make sure its fulfilled before going further
		if ( ! empty( $entry->meta_data ) && isset( $entry->meta_data['entry'] ) && isset( $entry->meta_data['entry']['value'] ) ) {

			if ( 'knowledge' === $quiz->quiz_type ) {
				$answers              = $entry->meta_data['entry']['value'];
				$correct_answer_count = 0;
				$total_answer         = 0;
				foreach ( $answers as $answer ) {
					$is_correct = isset( $answer['isCorrect'] ) ? $answer['isCorrect'] : false;
					$is_correct = filter_var( $is_correct, FILTER_VALIDATE_BOOLEAN );
					if ( $is_correct ) {
						$correct_answer_count ++;
					}

					$total_answer ++;
				}

				$result_content  = PHP_EOL . '<ul>' . PHP_EOL;
				$result_content .= '<li>' .
								sprintf(/* translators: ... */
									esc_html__( '%1$sCorrect Answers%2$s : %3$d', Powerform::DOMAIN ),
									'<b>',
									'</b>',
									$correct_answer_count
								) .
								'</li>' . PHP_EOL;

				$result_content .= '<li>' .
								sprintf(/* translators: ... */
									esc_html__( '%1$sTotal Question Answered%2$s : %3$d', Powerform::DOMAIN ),
									'<b>',
									'</b>',
									$total_answer
								) .
								'</li>' . PHP_EOL;
				$result_content .= '</ul>';
			} elseif ( 'nowrong' === $quiz->quiz_type ) {
				$meta = $entry->meta_data['entry']['value'];

				// i know its complicated as eff, but this is how it saved since day 1
				// and migrating this might pita and affect performance
				if ( isset( $meta[0] ) && isset( $meta[0]['value'] ) && isset( $meta[0]['value']['result'] ) ) {
					$result         = $meta[0]['value']['result'];
					$result_content = isset( $result['title'] ) ? esc_html( (string) $result['title'] ) : '';
				}
			}
		}
		$content = str_ireplace( '{quiz_result}', $result_content, $content );
		$content = do_shortcode( $content );
	}

	return apply_filters( 'powerform_replace_quiz_form_data', $content, $quiz, $data, $entry );
}

/**
 * Return uniq key value
 *
 * @since 1.13
 *
 * @return string
 */
function powerform_unique_key() {
	return wp_rand( 1000, 9999 ) . '-' . wp_rand( 1000, 9999 );
}

/**
 * Return vars for quiz
 *
 * @since 1.6.2
 * @return array
 */
function powerform_get_quiz_vars() {
	$vars_list = array(
		'quiz_name'   => esc_html__( 'Quiz Name', Powerform::DOMAIN ),
		'quiz_answer' => esc_html__( 'Quiz Answer', Powerform::DOMAIN ),
		'quiz_result' => esc_html__( 'Quiz Result', Powerform::DOMAIN ),
	);

	/**
	 * Filter powerform Quiz var list
	 *
	 * @see   powerform_replace_quiz_form_data()
	 *
	 * @since 1.6.2
	 *
	 * @param array $vars_list
	 */
	return apply_filters( 'powerform_quiz_vars_list', $vars_list );
}

/**
 * Replace Stripe data
 *
 * @param $content
 * @param $custom_form
 * @param $entry
 *
 * @return mixed
 */
function powerform_replace_form_payment_data( $content, Powerform_Custom_Form_Model $custom_form = null, Powerform_Form_Entry_Model $entry = null ) {
	if ( empty( $custom_form ) ) {
		return $content;
	}
	$form_fields = $custom_form->get_fields();
	if ( ! empty( $form_fields ) ) {
		foreach ( $form_fields as $field ) {
			$field_type = $field->__get( 'type' );
			if ( 'stripe' === $field_type || 'paypal' === $field_type ) {
				$payment_slug = $field->slug;
			}
		}
	}
	if ( ! empty( $payment_slug ) && ! empty( $entry ) ) {
		$payment_meta = isset( $entry->meta_data[ $payment_slug ] ) ? $entry->meta_data[ $payment_slug ]['value'] : array();
		if ( ! empty( $payment_meta ) ) {
			if ( strpos( $content, '{payment_mode}' ) !== false ) {
				$content = str_replace( '{payment_mode}', $payment_meta['mode'], $content );
			}
			if ( strpos( $content, '{payment_status}' ) !== false ) {
				$content = str_replace( '{payment_status}', $payment_meta['status'], $content );
			}
			if ( strpos( $content, '{payment_amount}' ) !== false ) {
				$content = str_replace( '{payment_amount}', $payment_meta['amount'], $content );
			}
			if ( strpos( $content, '{payment_currency}' ) !== false ) {
				$content = str_replace( '{payment_currency}', $payment_meta['currency'], $content );
			}
			if ( strpos( $content, '{transaction_id}' ) !== false ) {
				$content = str_replace( '{transaction_id}', $payment_meta['transaction_id'], $content );
			}
		}
	}

	return apply_filters( 'powerform_replace_form_payment_data', $content, $custom_form, $entry );
}

/**
 * Get Default date format
 *
 * @param $format
 *
 * @return string
 */
function datepicker_default_format( $format ) {
	switch ( $format ) {
		case 'mm/dd/yy':
			$format = 'm/d/Y';
			break;
		case 'mm.dd.yy':
			$format = 'm.d.Y';
			break;
		case 'mm-dd-yy':
			$format = 'm-d-Y';
			break;
		case 'yy-mm-dd':
			$format = 'Y-m-d';
			break;
		case 'yy.mm.dd':
			$format = 'Y.m.d';
			break;
		case 'yy/mm/dd':
			$format = 'Y/m/d';
			break;
		case 'dd/mm/yy':
			$format = 'd/m/Y';
			break;
		case 'dd.mm.yy':
			$format = 'd.m.Y';
			break;
		case 'dd-mm-yy':
			$format = 'd-m-Y';
			break;
		default:
			$format = get_option( 'date_format' );
			break;
	}

	return $format;
}

/**
 * Get entry field value helper
 *
 * @since 1.14
 *
 * @param Powerform_Form_Entry_Model $entry
 * @param                             $mapper
 * @param string                      $sub_meta_key
 * @param bool                        $allow_html
 * @param int                         $truncate
 *
 * @return string
 */
function powerform_get_entry_field_value( $entry, $mapper, $sub_meta_key = '', $allow_html = false, $truncate = PHP_INT_MAX ) {
	/** @var Powerform_Form_Entry_Model $entry */
	if ( isset( $mapper['property'] ) ) {
		if ( property_exists( $entry, $mapper['property'] ) ) {
			$property = $mapper['property'];
			// casting property to string
			$value = (string) $entry->$property;
		} else {
			$value = '';
		}
	} else {
		$meta_value = $entry->get_meta( $mapper['meta_key'], '' );
		// meta_key based
		if ( ! isset( $mapper['sub_metas'] ) ) {
			$value = Powerform_Form_Entry_Model::meta_value_to_string( $mapper['type'], $meta_value, $allow_html, $truncate );
		} else {
			if ( empty( $sub_meta_key ) ) {
				$value = '';
			} else {
				if ( isset( $meta_value[ $sub_meta_key ] ) && ! empty( $meta_value[ $sub_meta_key ] ) ) {
					$value      = $meta_value[ $sub_meta_key ];
					$field_type = $mapper['type'] . '.' . $sub_meta_key;
					$value      = Powerform_Form_Entry_Model::meta_value_to_string( $field_type, $value, $allow_html, $truncate );
				} else {
					$value = '';
				}
			}
		}
	}

	return $value;
}

/**
 * Powerform upload path
 *
 * @return string|null
 */
function powerform_upload_root() {
	$dir = wp_upload_dir();

	if ( $dir['error'] ) {
		return null;
	}

	return trailingslashit( $dir['basedir'] ) . 'powerform_temp';
}

/**
 * Powerform upload url
 *
 * @return string|null
 */
function formninator_upload_url_root() {
	$dir = wp_upload_dir();

	if ( $dir['error'] ) {
		return null;
	}

	return $dir['baseurl'] . 'powerform_upload';
}
