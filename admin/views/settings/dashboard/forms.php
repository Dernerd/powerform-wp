<?php
$dashboard_settings = powerform_get_dashboard_settings( 'forms', array() );
$num_recent         = isset( $dashboard_settings['num_recent'] ) ? $dashboard_settings['num_recent'] : 5;
$published          = isset( $dashboard_settings['published'] ) ? filter_var( $dashboard_settings['published'], FILTER_VALIDATE_BOOLEAN ) : true;
$draft              = isset( $dashboard_settings['draft'] ) ? filter_var( $dashboard_settings['draft'], FILTER_VALIDATE_BOOLEAN ) : true;
?>

<div class="sui-form-field">

	<label for="listings-forms-limit" id="listings-forms-limit-label" class="sui-settings-label"><?php esc_html_e( 'Anzahl der Formulare', Powerform::DOMAIN ); ?></label>

	<span id="listings-forms-limit-message" class="sui-description" style="margin-bottom: 10px;"><?php esc_html_e( 'Wähle die Anzahl der zuletzt verwendeten Formulare aus, die in Deinem Dashboard angezeigt werden sollen.', Powerform::DOMAIN ); ?></span>

	<input
		type="number"
		min="0"
		value="<?php echo esc_attr( $num_recent ); ?>"
		placeholder="0"
		name="num_recent[forms]"
		id="listings-forms-limit"
		class="sui-form-control sui-input-sm"
		style="max-width: 100px;"
		aria-labelledby="listings-forms-limit-label"
		aria-describedby="listings-forms-limit-message"
		aria-required="true"
	/>

	<span class="sui-error-message" style="display: none;"><?php esc_html_e( "Dieses Feld sollte nicht leer sein.", Powerform::DOMAIN ); ?></span>

</div>

<div class="sui-form-field">

	<label id="listings-forms-status-label" class="sui-settings-label"><?php esc_html_e( 'Status', Powerform::DOMAIN ); ?></label>

	<span id="listings-forms-status-message" class="sui-description" style="margin-bottom: 10px;"><?php esc_html_e( 'Standardmäßig werden alle Formulare unabhängig vom Status im Dashboard angezeigt. Verwende diese Einstellung, um nur Formulare mit einem bestimmten Status anzuzeigen.', Powerform::DOMAIN ); ?></span>

	<label for="powerform-forms-status-published" class="sui-checkbox sui-checkbox-sm sui-checkbox-stacked">
		<input
			type="checkbox"
			name="published[forms]"
			value="true"
			id="powerform-forms-status-published"
			aria-labelledby="listings-forms-status-label listings-forms-status-published"
			aria-describedby="listings-forms-status-message"
			<?php echo checked( $published ); ?>
		/>
		<span aria-hidden="true"></span>
		<span id="listings-forms-status-published"><?php esc_html_e( 'Veröffentlicht', Powerform::DOMAIN ); ?></span>
	</label>

	<label for="powerform-forms-status-drafts" class="sui-checkbox sui-checkbox-sm sui-checkbox-stacked">
		<input
			type="checkbox"
			name="draft[forms]"
			value="true"
			id="powerform-forms-status-drafts"
			aria-labelledby="listings-forms-status-label listings-forms-status-drafts"
			aria-describedby="listings-forms-status-message"
			<?php echo checked( $draft ); ?>
		/>
		<span aria-hidden="true"></span>
		<span id="listings-forms-status-drafts"><?php esc_html_e( 'Entwürfe', Powerform::DOMAIN ); ?></span>
	</label>

</div>
