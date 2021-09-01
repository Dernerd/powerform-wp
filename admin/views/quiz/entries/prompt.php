<?php
if ( ! POWERFORM_PRO ) {
	$submission               = $this->get_total_entries();
	$form_id                  = $this->form_id;
	$notice_success           = get_option( 'powerform_rating_success', false );
	$notice_dismissed         = get_option( 'powerform_rating_dismissed', false );
	$submission_later         = get_post_meta( $form_id, 'powerform_submission_rating_later' );
	$submission_later_dismiss = get_post_meta( $form_id, 'powerform_submission_rating_later_dismiss' );
	if ( ! $notice_dismissed && ! $notice_success ) {
		if ( ( ( 10 < $submission && 100 >= $submission ) && ! $submission_later )
			 || ( 100 < $submission && ! $submission_later_dismiss ) ) {
			$milestone = ( 100 >= $submission ) ? 10 : 100;
			?>
			<div class="powerform-rating-notice sui-notice sui-notice-purple fui-notice-rate<?php echo powerform_is_show_branding() ? '' : ' fui-unbranded'; ?>"
				 data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_dismiss_notification' ) ); ?>">

				<p><?php printf( esc_html__( "Hey, we noticed you just crossed %1\$s submissions%2\$s on this quiz - that's awesome! We have spent countless hours developing this free plugin for you, and we would really appreciate it if you could drop us a rating on wp.org to help us spread the word and boost our motivation.", Powerform::DOMAIN ), '<strong> ' . $milestone, '</strong>' ); ?></p>
				<p>
					<a type="button" href="#" target="_blank"
					   class="sui-button sui-button-purple"
					   data-prop="powerform_rating_success"><?php esc_html_e( 'Rate Powerform', Powerform::DOMAIN ); ?></a>

					<button type="button"
							class="sui-button sui-button-ghost"
							data-prop="<?php echo 100 > $submission ? 'powerform_submission_rating_later' : 'powerform_submission_rating_later_dismiss'; ?>"><?php esc_html_e( 'Maybe later', Powerform::DOMAIN ); ?></button>

					<a href="#" style="color: #888;"
					   data-prop="powerform_rating_dismissed"
					   data-prop="powerform_rating_dismissed"><?php esc_html_e( 'No Thanks', Powerform::DOMAIN ); ?></a>
				</p>

			</div>
			<script type="text/javascript">
				var ajaxUrl = '<?php echo powerform_ajax_url(); ?>';
				jQuery('.powerform-rating-notice a').on('click', function (e) {
					e.preventDefault();

					var $notice = jQuery(e.currentTarget).closest('.powerform-rating-notice'),
						prop = jQuery(this).data('prop');

					if ('powerform_rating_success' === prop) {
						window.open('https://wordpress.org/support/plugin/powerform/reviews/#new-post', '_blank');
					}

					jQuery.post(
						ajaxUrl,
						{
							action: 'powerform_dismiss_notification',
							prop: prop,
							_ajax_nonce: $notice.data('nonce')
						}
					).always(function () {
						$notice.hide();
					});
				});
				jQuery('.powerform-rating-notice button').on('click', function (e) {
					e.preventDefault();

					var $notice = jQuery(e.currentTarget).closest('.powerform-rating-notice'),
						prop = jQuery(this).data('prop');

					jQuery.post(
						ajaxUrl,
						{
							action: 'powerform_later_notification',
							prop: prop,
							form_id: <?php echo $form_id; ?>,
							_ajax_nonce: $notice.data('nonce')
						}
					).always(function () {
						$notice.hide();
					});
				});
			</script>
		<?php }
	}
}