<?php
$nonce = wp_create_nonce( 'powerform_save_import_custom_form_ninja' );
$forms = powerform_list_thirdparty_contact_forms( 'ninjaforms' );
?>

<div class="sui-box-body psource-popup-form">

	<div class="sui-notice sui-notice-error psource-ajax-error-placeholder sui-hidden"><p></p></div>

	<div class="sui-form-field">
		<select class="sui-form-dropdown" name="ninjaforms">
			<option value="all"><?php esc_html_e('All Forms', Powerform::DOMAIN); ?></option>
			<?php
			if ( ! empty( $forms ) ):
				foreach ($forms as $key => $value) {
					echo sprintf('<option value="%f">%s</option>', 
						absint( $value->get_id() ), 
						esc_html( $value->get_setting( 'title' ) ) 
					);
				}
			endif;
			?>
		</select>

		<span class="sui-description"><?php esc_html_e( 'Select the form.', Powerform::DOMAIN ); ?></span>

	</div>

</div>

<div class="sui-box-footer">

	<button class="sui-button powerform-popup-cancel" data-a11y-dialog-hide="powerform-popup">
		<span class="sui-loading-text"><?php esc_html_e( 'Cancel', Powerform::DOMAIN ); ?></span>
		<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
	</button>

	<div class="sui-actions-right">

		<button class="sui-button sui-button-primary psource-action-ajax-done" data-nonce="<?php echo esc_attr( $nonce ); ?>">
			<span class="sui-loading-text"><?php esc_html_e( 'Import', Powerform::DOMAIN ); ?></span>
			<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
		</button>

	</div>

</div>
