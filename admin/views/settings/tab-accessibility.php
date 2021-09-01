<?php
$section = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : 'dashboard';
$nonce                 = wp_create_nonce( 'powerform_save_accessibility_settings' );
$accessibility_enabled = get_option( 'powerform_enable_accessibility', false );
$accessibility_enabled = filter_var( $accessibility_enabled, FILTER_VALIDATE_BOOLEAN );

?>

<div class="sui-box" data-nav="accessibility" style="<?php echo esc_attr( 'accessibility' !== $section ? 'display: none;' : '' ); ?>">

	<div class="sui-box-header">
		<h2 class="sui-box-title"><?php esc_html_e( 'Barrierefreiheit', Powerform::DOMAIN ); ?></h2>
	</div>

	<form class="powerform-settings-save" action="">

		<div class="sui-box-body">

			<div class="sui-box-settings-row">
				<p><?php esc_html_e( 'Aktivieren Sie die Unterstützung für alle Verbesserungen der Barrierefreiheit, die in der Plugin-Oberfläche verfügbar sind.', Powerform::DOMAIN ); ?></p>
			</div>
			<div class="sui-box-settings-row">

				<div class="sui-box-settings-col-1">
					<span class="sui-settings-label"><?php esc_html_e( 'Kontrastreicher Modus', Powerform::DOMAIN ); ?></span>
					<span class="sui-description"><?php esc_html_e( 'Erhöhe die Sichtbarkeit und Zugänglichkeit von Elementen und Komponenten, um die WCAG AAA-Anforderungen zu erfüllen.', Powerform::DOMAIN ); ?></span>
				</div>

				<div class="sui-box-settings-col-2">

					<div class="sui-form-field">

						<label for="powerform-color-accessibility" class="sui-toggle">
							<input type="checkbox"
								name="enable_accessibility"
								value="true"
								id="powerform-color-accessibility" <?php checked( $accessibility_enabled ); ?>/>
							<span class="sui-toggle-slider" aria-hidden="true"></span>
						</label>

						<label for="powerform-color-accessibility"><?php esc_html_e( 'Aktiviere den kontrastreichen Modus', Powerform::DOMAIN ); ?></label>

					</div>

				</div>

			</div>

		</div>

		<div class="sui-box-footer">

			<div class="sui-actions-right">

				<button class="sui-button sui-button-blue psource-action-done"
						data-title="<?php esc_attr_e( 'Barrierefreiheit Einstellungen', Powerform::DOMAIN ); ?>"
						data-action="accessibility_settings"
						data-nonce="<?php echo esc_attr( $nonce ); ?>"
						data-is-reload="true">
					<span class="sui-loading-text"><?php esc_html_e( 'Einstellungen speichern', Powerform::DOMAIN ); ?></span>
					<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
				</button>

			</div>

		</div>

	</form>

</div>
