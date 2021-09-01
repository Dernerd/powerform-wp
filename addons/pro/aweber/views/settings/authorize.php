<?php
// Defaults
$vars = array(
	'account_id'   => 0,
	'auth_url'     => '',
	'is_connected' => false,
);

/** @var array $template_vars */
foreach ( $template_vars as $key => $val ) {
	$vars[ $key ] = $val;
} ?>

<div class="integration-header">

	<h3 class="sui-box-title" id="dialogTitle2">
		<?php
			/* translators: ... */
			echo esc_html( sprintf( __( 'Connect %1$s', Powerform::DOMAIN ), 'AWeber' ) );
		?>
	</h3>

	<?php if ( ! empty( $vars['account_id'] ) ) : ?>
		<div class="sui-notice sui-notice-success">
			<p>
				<?php
					/* translators: ... */
					echo esc_html( sprintf( __( 'Your %1$s account is already authorized.', Powerform::DOMAIN ), 'AWeber' ) );
				?>
			</p>
		</div>
	<?php else : ?>
		<span class="sui-description" style="margin-top: 20px;"><?php esc_html_e( 'Authorize Powerform to connect with your AWeber account in order to send data from your forms.', Powerform::DOMAIN ); ?></span>
	<?php endif; ?>

</div>

<?php if ( empty( $vars['account_id'] ) ) : ?>

	<div class="sui-block-content-center">

		<a href="<?php echo esc_attr( $vars['auth_url'] ); ?>"
			target="_blank"
			class="sui-button sui-button-blue powerform-addon-connect">
			<?php esc_html_e( 'Authorize', Powerform::DOMAIN ); ?>
		</a>

	</div>

<?php endif; ?>

<?php if ( $vars['is_connected'] ) : ?>
	<button class="sui-button sui-button-ghost powerform-addon-disconnect"><?php esc_html_e( 'Disconnect', Powerform::DOMAIN ); ?></button>
<?php endif; ?>
