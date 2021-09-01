<?php
$entries_per_page = get_option( 'powerform_pagination_entries', 10 );
$module_per_page  = get_option( 'powerform_pagination_listings', 10 );
?>
<div class="sui-box-settings-row">

	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label"><?php esc_html_e( 'Seitennummerierung', Powerform::DOMAIN ); ?></span>
		<span class="sui-description"><?php esc_html_e( 'Wähle die Anzahl der Elemente aus, die pro Seite auf Deinen Einsendungen oder Modulen angezeigt werden sollen.', Powerform::DOMAIN ); ?></span>
	</div>

	<div class="sui-box-settings-col-2">

		<label class="sui-settings-label"><?php esc_html_e( 'Module', Powerform::DOMAIN ); ?></label>

		<span class="sui-description"
			style="margin-bottom: 10px;"><?php esc_html_e( 'Wähle die Anzahl der Formulare, Umfragen und Tests aus, die auf jeder Listingseite angezeigt werden sollen.', Powerform::DOMAIN ); ?></span>

		<div class="sui-form-field">
			<input type="number"
				name="pagination_listings"
				placeholder="<?php esc_html_e( '10', Powerform::DOMAIN ); ?>"
				value="<?php echo esc_attr( $module_per_page ); ?>"
				min="1"
				id="powerform-limit-listing"
				class="sui-form-control powerform-required sui-input-sm sui-field-has-suffix"/>

			<span class="sui-field-suffix"><?php esc_html_e( 'Module pro Seite', Powerform::DOMAIN ); ?></span>
			<span class="sui-error-message"
				style="display: none;"><?php esc_html_e( 'Dieses Feld kann nicht leer sein.', Powerform::DOMAIN ); ?></span>

		</div>
		<label class="sui-settings-label"><?php esc_html_e( 'Einsendungen', Powerform::DOMAIN ); ?></label>

		<span class="sui-description"
			style="margin-bottom: 10px;"><?php esc_html_e( 'Wähle die Anzahl der Einsendungen pro Seite.', Powerform::DOMAIN ); ?></span>

		<div class="sui-form-field">
			<input type="number"
				name="pagination_entries"
				placeholder="<?php esc_html_e( '10', Powerform::DOMAIN ); ?>"
				value="<?php echo esc_attr( $entries_per_page ); ?>"
				min="1"
				id="powerform-limit-entries"
				class="sui-form-control powerform-required sui-input-sm sui-field-has-suffix"/>
			<span class="sui-field-suffix"><?php esc_html_e( 'Einsendungen pro Seite', Powerform::DOMAIN ); ?></span>
			<span class="sui-error-message"
				style="display: none;"><?php esc_html_e( 'Dieses Feld kann nicht leer sein.', Powerform::DOMAIN ); ?></span>

		</div>

	</div>

</div>
