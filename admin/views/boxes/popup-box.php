<?php $icon_close = powerform_plugin_dir() . 'assets/icons/admin-icons/close.php'; ?>

<div id="powerform-modal-<?php echo esc_attr( $template_class ); ?>" class="psource-modal <?php echo esc_attr( $template_class ); ?>">

	<div class="psource-modal-mask" aria-hidden="true"></div>

	<div class="psource-box-modal">

		<div class="psource-box-header">

			<div class="psource-header--text">

				<h2 class="psource-subtitle"><?php echo esc_html( $title ); ?></h2>

			</div>

			<div class="psource-header--action">

				<button class="psource-box--action"><?php require $icon_close; ?></button>

				<button class="psource-sr-only"><?php esc_html_e( 'Close modal', Powerform::DOMAIN ); ?></button>

			</div>

		</div>

		<div class="psource-box-body">
			<?php if ( is_callable( $main_callback ) ) : ?>
				<?php call_user_func( $main_callback ); ?>
			<?php elseif ( $this->template_exists( $template_id . '/content' ) ) : ?>
				<?php $this->template( $template_id . '/content' ); ?>
			<?php else : ?>
				<?php $this->template( $template_id . '-content' ); ?>
			<?php endif; ?>
		</div>

	</div>

</div>
