<?php
$section = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : 'dashboard';
?>
<div class="sui-row-with-sidenav">

	<div class="sui-sidenav">

		<ul class="sui-vertical-tabs sui-sidenav-hide-md">

			<li class="sui-vertical-tab <?php echo esc_attr( 'dashboard' === $section ? 'current' : '' ); ?>">
				<a href="#" data-nav="dashboard"><?php esc_html_e( 'Allgemeines', Powerform::DOMAIN ); ?></a>
			</li>

			<li class="sui-vertical-tab <?php echo esc_attr( 'accessibility' === $section ? 'current' : '' ); ?>">
				<a href="#" data-nav="accessibility"><?php esc_html_e( 'Barrierefreiheit', Powerform::DOMAIN ); ?></a>
			</li>

			<li class="sui-vertical-tab <?php echo esc_attr( 'data' === $section ? 'current' : '' ); ?>">
				<a href="#" data-nav="data"><?php esc_html_e( 'Daten', Powerform::DOMAIN ); ?></a>
			</li>

			<li class="sui-vertical-tab <?php echo esc_attr( 'recaptcha' === $section ? 'current' : '' ); ?>">
				<a href="#" data-nav="recaptcha"><?php esc_html_e( 'Google reCAPTCHA', Powerform::DOMAIN ); ?></a>
			</li>

			<li class="sui-vertical-tab <?php echo esc_attr( 'import' === $section ? 'current' : '' ); ?>">
				<a href="#" data-nav="import"><?php esc_html_e( 'Importieren', Powerform::DOMAIN ); ?></a>
			</li>

			<li class="sui-vertical-tab <?php echo esc_attr( 'submissions' === $section ? 'current' : '' ); ?>">
				<a href="#" data-nav="submissions"><?php esc_html_e( 'Einsendungen', Powerform::DOMAIN ); ?></a>
			</li>

			<li class="sui-vertical-tab <?php echo esc_attr( 'payments' === $section ? 'current' : '' ); ?>">
				<a href="#" data-nav="payments"><?php esc_html_e( 'Zahlungen', Powerform::DOMAIN ); ?></a>
			</li>

		</ul>

		<select class="sui-mobile-nav sui-sidenav-hide-lg">
			<option value="dashboard"><?php esc_html_e( 'Allgemeines', Powerform::DOMAIN ); ?></option>
			<option value="accessibility"><?php esc_html_e( 'Barrierefreiheit', Powerform::DOMAIN ); ?></option>
			<option value="data"><?php esc_html_e( 'Daten', Powerform::DOMAIN ); ?></option>
			<option value="recaptcha"><?php esc_html_e( 'Google reCAPTCHA', Powerform::DOMAIN ); ?></option>
			<option value="import"><?php esc_html_e( 'Importieren', Powerform::DOMAIN ); ?></option>
			<option value="submissions"><?php esc_html_e( 'Einsendungen', Powerform::DOMAIN ); ?></option>
			<option value="payments"><?php esc_html_e( 'Zahlungen', Powerform::DOMAIN ); ?></option>
		</select>

	</div>

	<?php $this->template( 'settings/tab-dashboard' ); ?>
	<?php $this->template( 'settings/tab-recaptcha' ); ?>
	<?php $this->template( 'settings/tab-data' ); ?>
	<?php $this->template( 'settings/tab-submissions' ); ?>
	<?php $this->template( 'settings/tab-payments' ); ?>
	<?php $this->template( 'settings/tab-accessibility' ); ?>
	<?php $this->template( 'settings/tab-import' ); ?>

</div>
