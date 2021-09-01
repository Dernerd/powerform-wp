<?php
$nonce = wp_create_nonce( 'powerform_save_import_poll' );
?>

<div class="sui-box-body psource-popup-form">

	<div class="sui-notice sui-notice-error psource-ajax-error-placeholder sui-hidden"><p></p></div>

	<div class="sui-form-field">

		<textarea class="sui-form-control" rows="10" name="importable"></textarea>

		<span class="sui-description"><?php esc_html_e( 'Exportierte Umfrage oben einfügen.', Powerform::DOMAIN ); ?></span>

	</div>

</div>

<div class="sui-box-footer">

	<button class="sui-button powerform-popup-cancel" data-a11y-dialog-hide="powerform-popup">
		<span class="sui-loading-text"><?php esc_html_e( 'Abbrechen', Powerform::DOMAIN ); ?></span>
		<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
	</button>

	<div class="sui-actions-right">

		<button class="sui-button sui-button-primary psource-action-ajax-done" data-nonce="<?php echo esc_attr( $nonce ); ?>">
			<span class="sui-loading-text"><?php esc_html_e( 'Importieren', Powerform::DOMAIN ); ?></span>
			<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
		</button>

	</div>

</div>
