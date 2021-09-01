<?php
$powerform_editor_settings = get_option( 'powerform_editor_settings', "true" );

?>
<div class="sui-box-settings-row">

	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label"><?php esc_html_e( 'Formulareditor', Powerform::DOMAIN ); ?></span>
		<span class="sui-description"><?php esc_html_e( 'Passe die Einstellungen Deines Formulareditors an.', Powerform::DOMAIN ); ?></span>
	</div>

	<div class="sui-box-settings-col-2">
		<label class="sui-settings-label"><?php esc_html_e( 'Feldeinstellungen automatisch öffnen', Powerform::DOMAIN ); ?></label>

		<span class="sui-description"
			style="margin-bottom: 10px;"><?php echo sprintf( esc_html__( 'Durch Aktivieren dieser Option wird das Modul für die Feldeinstellungen automatisch geöffnet, wenn Du jeweils nur %1$sein Feld%2$s in Dein Formular einfügst.', Powerform::DOMAIN ), '<strong>', '</strong>' ); ?></span>

		<label for="powerform-editor-settings" class="sui-toggle">
			<input type="checkbox"
				name="editor_settings"
				value="true"
				id="powerform-editor-settings" <?php checked( $powerform_editor_settings, "true" ); ?>/>
			<span class="sui-toggle-slider" aria-hidden="true"></span>
		</label>

		<label for="powerform-editor-settings"><?php esc_html_e( 'Aktivieren', Powerform::DOMAIN ); ?></label>

	</div>

</div>
