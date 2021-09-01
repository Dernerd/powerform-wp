<?php
// defaults
$vars = array(
	'auth_url' => '',
	'token'    => '',
	'user'     => '',
);

/** @var array $template_vars */
foreach ( $template_vars as $key => $val ) {
	$vars[ $key ] = $val;
} ?>

<div class="integration-header">

	<h3 id="dialogTitle2" class="sui-box-title">
		<?php
			/* translators: ... */
			echo esc_html( sprintf( __( 'Connect %1$s', Powerform::DOMAIN ), 'HubSpot' ) );
		?>
	</h3>

	<?php if ( ! empty( $vars['token'] ) ) : ?>

		<span class="sui-description" style="color: #666666; margin-top: 20px; line-height: 22px;"><?php esc_html_e( 'You are already connected to the HubSpot. You can disconnect your HubSpot Integration (if you need to) using the button below.', Powerform::DOMAIN ); ?></span>

		<div class="sui-notice sui-notice-success" style="margin-bottom: -30px;">
			<p>
				<?php
					/* translators: ... */
					echo sprintf( esc_html__( 'You are connected to %2$s%1$s%3$s.', Powerform::DOMAIN ), esc_html( $vars['user'] ), '<strong>', '</strong>' );
				?>
			</p>
		</div>

	<?php else : ?>

		<span class="sui-description" style="color: #666666; margin-top: 20px; line-height: 22px;"><?php esc_html_e( "Authenticate your HubSpot account using the button below. Note that you'll be taken to the HubSpot website to grant access to Powerform and then redirected back.", Powerform::DOMAIN ); ?></span>

	<?php endif; ?>

</div>

<?php if ( empty( $vars['token'] ) ) : ?>

	<div class="sui-block-content-center" style="margin-top: -10px; margin-bottom: -20px;">

		<a href="<?php echo esc_attr( $vars['auth_url'] ); ?>" target="_blank" class="sui-button sui-button-primary powerform-addon-connect"><?php esc_html_e( 'Authenticate', Powerform::DOMAIN ); ?></a>

	</div>

<?php endif; ?>
