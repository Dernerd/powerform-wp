<?php
$section    = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : 'dashboard';
$plugin_url = powerform_plugin_url();
$nonce      = wp_create_nonce( 'powerform_save_payments_settings' );
?>

<div class="sui-box" data-nav="payments" style="<?php echo esc_attr( 'payments' !== $section ? 'display: none;' : '' ); ?>">

	<div class="sui-box-header">
		<h2 class="sui-box-title"><?php esc_html_e( 'Zahlungen', Powerform::DOMAIN ); ?></h2>
	</div>

	<form class="powerform-settings-save" action="">

		<div class="sui-box-body">

			<?php if ( class_exists( 'Powerform_Gateway_Stripe' ) ) : ?>
				<div id="sui-box-stripe" class="sui-box-settings-row">
					<?php $this->template( 'settings/payments/section-stripe' ); ?>
				</div>
			<?php endif; ?>

			<div id="sui-box-paypal" class="sui-box-settings-row">
				<?php $this->template( 'settings/payments/section-paypal' ); ?>
			</div>

		</div>

		<div class="sui-box-footer">

			<div class="sui-actions-right">

				<button
					class="sui-button sui-button-blue psource-action-done"
					data-title="<?php esc_attr_e( 'Zahlungseinstellungen', Powerform::DOMAIN ); ?>"
					data-action="payments_settings"
					data-nonce="<?php echo esc_attr( $nonce ); ?>"
				>
					<span class="sui-loading-text"><?php esc_html_e( 'Einstellungen speichern', Powerform::DOMAIN ); ?></span>
					<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
				</button>

			</div>

		</div>

	</form>

</div>
