<?php
$dashboard_settings = powerform_get_dashboard_settings( 'quizzes', array() );
$num_recent         = isset( $dashboard_settings['num_recent'] ) ? $dashboard_settings['num_recent'] : 5;
$published          = isset( $dashboard_settings['published'] ) ? filter_var( $dashboard_settings['published'], FILTER_VALIDATE_BOOLEAN ) : true;
$draft              = isset( $dashboard_settings['draft'] ) ? filter_var( $dashboard_settings['draft'], FILTER_VALIDATE_BOOLEAN ) : true;
?>

<div class="sui-form-field">

	<label for="listings-quizzes-limit" id="listings-quizzes-limit-label" class="sui-settings-label"><?php esc_html_e( 'Anzahl der Tests', Powerform::DOMAIN ); ?></label>

	<span id="listings-quizzes-limit-message" class="sui-description" style="margin-bottom: 10px;"><?php esc_html_e( 'Wähle die Anzahl der letzten Tests aus, die in Deinem Dashboard angezeigt werden sollen.', Powerform::DOMAIN ); ?></span>

	<input
		type="number"
		min="0"
		name="num_recent[quizzes]"
		value="<?php echo esc_attr( $num_recent ); ?>"
		placeholder="0"
		id="listings-quizzes-limit"
		class="sui-form-control sui-input-sm"
		style="max-width: 100px;"
		aria-labelledby="listings-quizzes-limit-label"
		aria-describedby="listings-quizzes-limit-message"
	/>

	<span class="sui-error-message" style="display: none;"><?php esc_html_e( "Dieses Feld sollte nicht leer sein.", Powerform::DOMAIN ); ?></span>

</div>

<div class="sui-form-field">

	<label for="powerform-quizzes-status-published" id="listings-quizzes-status-label" class="sui-settings-label"><?php esc_html_e( 'Status', Powerform::DOMAIN ); ?></label>

	<span id="listings-quizzes-status-message" class="sui-description" style="margin-bottom: 10px;"><?php esc_html_e( 'Standardmäßig werden alle Tests unabhängig vom Status im Dashboard angezeigt. Verwende diese Einstellung, um die Tests nur mit einem bestimmten Status anzuzeigen.', Powerform::DOMAIN ); ?></span>

	<label for="powerform-quizzes-status-published" class="sui-checkbox sui-checkbox-sm sui-checkbox-stacked">
		<input
			type="checkbox"
			name="published[quizzes]"
			value="true"
			id="powerform-quizzes-status-published"
			<?php echo checked( $published ); ?>
			aria-labelledby="listings-quizzes-status-label listings-quizzes-status-published"
			aria-describedby="listings-quizzes-status-message"
		/>
		<span aria-hidden="true"></span>
		<span id="listings-quizzes-status-published"><?php esc_html_e( 'Veröffentlicht', Powerform::DOMAIN ); ?></span>
	</label>

	<label for="powerform-quizzes-status-drafts" class="sui-checkbox sui-checkbox-sm sui-checkbox-stacked">
		<input
			type="checkbox"
			name="draft[quizzes]"
			value="true"
			id="powerform-quizzes-status-drafts"
			<?php echo checked( $draft ); ?>
			aria-labelledby="listings-quizzes-status-label listings-quizzes-status-drafts"
			aria-describedby="listings-quizzes-status-message"
		/>
		<span aria-hidden="true"></span>
		<span id="listings-quizzes-status-drafts"><?php esc_html_e( 'Entwürfe', Powerform::DOMAIN ); ?></span>
	</label>

</div>
