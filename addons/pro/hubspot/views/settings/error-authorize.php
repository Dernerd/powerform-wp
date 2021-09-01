<?php
// defaults
$vars = array(
	'auth_url'      => '',
	'error_message' => '',
);
/** @var array $template_vars */
foreach ( $template_vars as $key => $val ) {
	$vars[ $key ] = $val;
}
?>

<div class="integration-header">

	<h3 id="dialogTitle2" class="sui-box-title">
		<?php
			/* translators: ... */
			echo esc_html( sprintf( __( 'Connect %1$s', Powerform::DOMAIN ), 'HubSpot' ) );
		?>
	</h3>

	<span class="sui-description" style="color: #666666; margin-top: 20px; line-height: 22px;"><?php esc_html_e( "Authenticate your HubSpot account using the button below. Note that you'll be taken to the HubSpot website to grant access to Powerform and then redirected back.", Powerform::DOMAIN ); ?></span>

	<p><?php if ( ! empty( $vars['error_message'] ) ) : ?>
		<?php echo esc_html( $vars['error_message'] ); ?>
	<?php endif; ?></p>

</div>

<div class="sui-block-content-center">

	<a href="<?php echo esc_attr( $vars['auth_url'] ); ?>" target="_blank" class="sui-button sui-button-primary powerform-addon-connect"><?php esc_html_e( 'Authenticate', Powerform::DOMAIN ); ?></a>

</div>
