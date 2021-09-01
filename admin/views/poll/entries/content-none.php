<?php if ( powerform_is_show_branding() ) : ?>
	<img src="<?php echo esc_url( powerform_plugin_url() . 'assets/img/powerform-submissions.png' ); ?>"
		srcset="<?php echo esc_url( powerform_plugin_url() . 'assets/img/powerform-submissions.png' ); ?> 1x, <?php echo esc_url( powerform_plugin_url() . 'assets/img/powerform-submissions@2x.png' ); ?> 2x"
		alt="<?php esc_html_e( 'Powerform', Powerform::DOMAIN ); ?>"
		class="sui-image"
		aria-hidden="true"/>
<?php endif; ?>

<div class="sui-message-content">

	<h2><?php echo powerform_get_form_name( $form_id, 'poll' ); // phpcs:ignore ?></h2>

	<p><?php esc_html_e( 'You haven’t received any submissions for this poll yet. When you do, you’ll be able to view all the data here.', Powerform::DOMAIN ); ?></p>

</div>
