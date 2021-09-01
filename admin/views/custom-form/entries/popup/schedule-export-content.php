<div class="psource-box-gray">
	<form class="powerform_schedule_export" method="post">
		<div id="powerform-export-schedule-timeframe" class="psource-row">

			<div class="psource-col col-12 col-md-4">

				<label><?php esc_html_e( 'Frequenz', Powerform::DOMAIN ); ?></label>

				<select class="psource-select">

					<option><?php esc_html_e( 'Täglich', Powerform::DOMAIN ); ?></option>
					<option><?php esc_html_e( 'Wöchentlich', Powerform::DOMAIN ); ?></option>
					<option><?php esc_html_e( 'Monatlich', Powerform::DOMAIN ); ?></option>

				</select>

			</div>

			<div class="psource-col col-12 col-md-4">

				<label><?php esc_html_e( 'Wochentag', Powerform::DOMAIN ); ?></label>

				<select class="psource-select">

					<option><?php esc_html_e( 'Montag', Powerform::DOMAIN ); ?></option>
					<option><?php esc_html_e( 'Dienstag', Powerform::DOMAIN ); ?></option>
					<option><?php esc_html_e( 'Mittwoch', Powerform::DOMAIN ); ?></option>
					<option><?php esc_html_e( 'Donnerstag', Powerform::DOMAIN ); ?></option>
					<option><?php esc_html_e( 'Freitag', Powerform::DOMAIN ); ?></option>
					<option><?php esc_html_e( 'Samstag', Powerform::DOMAIN ); ?></option>
					<option><?php esc_html_e( 'Sonntag', Powerform::DOMAIN ); ?></option>

				</select>

			</div>

			<div class="psource-col col-12 col-md-4">

				<label><?php esc_html_e( 'Tageszeit', Powerform::DOMAIN ); ?></label>

				<select class="psource-select">

					<option>12:00 AM</option>
					<option>01:00 AM</option>
					<option>02:00 AM</option>
					<option>03:00 AM</option>
					<option>04:00 AM</option>
					<option>05:00 AM</option>
					<option>06:00 AM</option>
					<option>07:00 AM</option>
					<option>08:00 AM</option>
					<option>09:00 AM</option>
					<option>10:00 AM</option>
					<option>11:00 AM</option>
					<option>12:00 PM</option>
					<option>01:00 PM</option>
					<option>02:00 PM</option>
					<option>03:00 PM</option>
					<option>04:00 PM</option>
					<option>05:00 PM</option>
					<option>06:00 PM</option>
					<option>07:00 PM</option>
					<option>08:00 PM</option>
					<option>09:00 PM</option>
					<option>10:00 PM</option>
					<option>11:00 PM</option>

				</select>

			</div>

		</div>

		<div id="powerform-export-schedule-email" class="psource-row">

			<div class="psource-col col-12">

				<label><?php esc_html_e( 'E-Mail-Exportdaten an', Powerform::DOMAIN ); ?></label>

				<input type="email" class="psource-input"
					placeholder="<?php esc_html_e( 'admin@website.com', Powerform::DOMAIN ); ?>">

				<label class="psource-helper"><?php esc_html_e( "Lasse das Feld leer, wenn Du keine Exporte per E-Mail erhalten möchtest.", Powerform::DOMAIN ); ?></label>

			</div>

		</div>
		<?php wp_nonce_field( 'powerform_export_data', '_powerform_nonce' ); ?>
		<button class="psource-button psource-button-blue" type="submit"><?php esc_html_e( 'Änderungen speichern', Powerform::DOMAIN ); ?></button>
	</form>
</div>
