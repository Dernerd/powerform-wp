<?php
$sender_email_address = get_global_sender_email_address();
$sender_name          = get_global_sender_name();
?>

<div class="sui-box-settings-row">

	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label"><?php esc_html_e( 'Von Kopfzeilen', Powerform::DOMAIN ); ?></span>
		<span class="sui-description"><?php esc_html_e( 'Wähle den Standard-Absendernamen und die Absender-E-Mail-Adresse für alle ausgehenden E-Mails von Powerform.', Powerform::DOMAIN ); ?></span>
	</div>

	<div class="sui-box-settings-col-2">

		<div class="sui-form-field">

			<label for="powerform-settings--sender-email"
				class="sui-label"><?php esc_html_e( 'Absender-E-Mail-Adresse', Powerform::DOMAIN ); ?></label>
			<input type="email"
				name="sender_email"
				placeholder="<?php esc_html_e( 'Email eingeben', Powerform::DOMAIN ); ?>"
				value="<?php echo esc_html( $sender_email_address ); ?>"
				id="powerform-settings--sender-email"
				class="sui-form-control powerform-required"/>
			<span class="sui-error-message"
				style="display: none;"><?php esc_html_e( 'Bitte gib eine gültige E-Mail-Adresse ein.', Powerform::DOMAIN ); ?></span>

		</div>

		<div class="sui-form-field">

			<label for="powerform-settings--sender-name"
				class="sui-label"><?php esc_html_e( 'Absender', Powerform::DOMAIN ); ?></label>
			<input type="text"
				name="sender_name"
				placeholder="<?php esc_html_e( 'Name eingeben', Powerform::DOMAIN ); ?>"
				value="<?php echo esc_html( $sender_name ); ?>"
				id="powerform-settings--sender-name"
				class="sui-form-control powerform-required"/>
			<span class="sui-error-message"
				style="display: none;"><?php esc_html_e( 'Der Absender darf nicht leer sein.', Powerform::DOMAIN ); ?></span>

		</div>

	</div>

</div>
