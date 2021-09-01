<?php
// Defaults
$vars = array(
	'token'               => '',
	'error_message'       => '',
	'client_id'           => '',
	'client_secret'       => '',
	'client_secret_error' => '',
	'client_id_error'     => '',
	'redirect_url'        => '',
);

/** @var array $template_vars */
foreach ( $template_vars as $key => $val ) {
	$vars[ $key ] = $val;
} ?>

<div class="integration-header">

	<h3 class="sui-box-title" id="dialogTitle2"><?php echo esc_html( sprintf( /* translators: ... */ __( 'Setup %1$s Client', Powerform::DOMAIN ), 'Google Sheets' ) ); ?></h3>

	<?php if ( ! empty( $vars['token'] ) ) : ?>
		<span class="sui-description" style="margin-top: 20px;"><?php esc_html_e( 'Your Google Sheets account is already authorized. Edit info below to re-authorize.', Powerform::DOMAIN ); ?></span>
	<?php else : ?>
        <span class="sui-description" style="margin-top: 20px;">
			<?php esc_html_e( 'Set up your Google Sheets oAuth 2.0 client by entering your credentials below.', Powerform::DOMAIN );
			if ( powerform_is_show_addons_documentation_link() ) { ?>
                <br/>
				<?php echo sprintf(/* translators: ... */
					esc_html__( '%1$sGuide to generate credentials%2$s.', Powerform::DOMAIN ),
					'<a href="https://n3rds.work/docs/wpmu-dev-plugins/powerform/#google-sheets" target="_blank">',
					'</a>'
				);
			} ?>
		</span>
		<?php if ( ! empty( $vars['error_message'] ) ) : ?>
			<div class="sui-notice sui-notice-error">
				<p><?php echo esc_html( $vars['error_message'] ); ?></p>
			</div>
		<?php endif; ?>
	<?php endif ?>

</div>

<form>

	<div class="sui-form-field">

		<label class="sui-label"><?php esc_html_e( 'Authorized Redirect URI', Powerform::DOMAIN ); ?></label>

		<div class="sui-with-button sui-with-button-icon">
			<input type="text" id="powerform-form-shortcode" class="sui-form-control" value="<?php echo esc_html( ! empty( $vars['redirect_url'] ) ? $vars['redirect_url'] : '' ); ?>">
			<a class="sui-button-icon copy-clipboard-integration" data-shortcode="<?php echo esc_html( ! empty( $vars['redirect_url'] ) ? $vars['redirect_url'] : '' ); ?>">
				<i aria-hidden="true" class="sui-icon-copy"></i>
				<span class="sui-screen-reader-text"><?php esc_html_e( 'Copy shortcode', Powerform::DOMAIN ); ?></span>
			</a>
		</div>

		<span class="sui-description"><?php esc_html_e( 'Please use this redirect URI while generating your client credentials on the Google API console.', Powerform::DOMAIN ); ?></span>

	</div>

	<div class="sui-form-field<?php echo esc_attr( ! empty( $vars['client_id_error'] ) ? ' sui-form-field-error' : '' ); ?>">

		<label class="sui-label"><?php esc_html_e( 'Client ID', Powerform::DOMAIN ); ?></label>

		<div class="sui-control-with-icon">

			<input name="client_id"
				placeholder="<?php echo esc_attr( __( 'Client ID', Powerform::DOMAIN ) ); ?>"
				value="<?php echo esc_attr( $vars['client_id'] ); ?>"
				class="sui-form-control" />

			<i class="sui-icon-profile-male" aria-hidden="true"></i>

		</div>

		<?php if ( ! empty( $vars['client_id_error'] ) ) : ?>
			<span class="sui-error-message"><?php echo esc_html( $vars['client_id_error'] ); ?></span>
		<?php endif; ?>

	</div>

	<div class="sui-form-field<?php echo esc_attr( ! empty( $vars['client_secret_error'] ) ? ' sui-form-field-error' : '' ); ?>">

		<label class="sui-label"><?php esc_html_e( 'Client Secret', Powerform::DOMAIN ); ?></label>

		<div class="sui-control-with-icon">

			<input name="client_secret"
				placeholder="<?php echo esc_attr( __( 'Client Secret', Powerform::DOMAIN ) ); ?>"
				value="<?php echo esc_attr( $vars['client_secret'] ); ?>"
				class="sui-form-control" />

			<i class="sui-icon-key" aria-hidden="true"></i>

		</div>

		<?php if ( ! empty( $vars['client_secret_error'] ) ) : ?>
			<span class="sui-error-message"><?php echo esc_html( $vars['client_secret_error'] ); ?></span>
		<?php endif; ?>

	</div>

</form>

<script>
jQuery('.copy-clipboard-integration').on( "click", function ( e ) {
	e.preventDefault();

	copyToClipboard( jQuery( this ).data( 'shortcode' ) );

	Powerform.Notification.open( 'success', Powerform.l10n.options.uri_copied, 4000 );
});
</script>
