<?php
// Submissions
$poll_retain_forever = get_option( 'poll_retain_submission_forever' );
$polls_retain_number = get_option( 'powerform_retain_votes_interval_number', 0 );
$polls_retain_unit   = get_option( 'powerform_retain_votes_interval_unit', 'days' );

// IP
$poll_submissions_retain_forever  = get_option( 'retain_poll_forever' );
$poll_submissions_retain_number  = get_option( 'powerform_retain_poll_submissions_interval_number', 0 );
$poll_submissions_retain_unit    = get_option( 'powerform_retain_poll_submissions_interval_unit', 'days' );
?>

<div class="sui-box-settings-row">

	<div class="sui-box-settings-col-1">
		<span class="sui-settings-label"><?php esc_html_e( 'Umfrage Datenschutz', Powerform::DOMAIN ); ?></span>
		<span class="sui-description"><?php esc_html_e( 'Wähle aus, wie Du den Abfragedatenspeicher behandeln möchtest.', Powerform::DOMAIN ); ?></span>
	</div>

	<div class="sui-box-settings-col-2">

		<span class="sui-settings-label"><?php esc_html_e( 'Aufbewahrung von Einsendungen', Powerform::DOMAIN ); ?></span>
		<span class="sui-description"><?php esc_html_e( 'Wie lange möchtest Du die Beiträge der Umfrage aufbewahren?', Powerform::DOMAIN ); ?></span>

		<div class="sui-side-tabs" style="margin-top: 10px;">

			<div class="sui-tabs-menu">

				<label for="poll_retain_submission-true" class="sui-tab-item<?php echo( $poll_retain_forever ? ' active' : '' ); ?>">
					<input type="radio"
						name="poll_retain_submission_forever"
						value="true"
						id="poll_retain_submission-true"
						<?php checked( $poll_retain_forever, true ); ?> />
					<?php esc_html_e( 'Für immer', Powerform::DOMAIN ); ?>
				</label>

				<label for="poll_retain_submission-false" class="sui-tab-item<?php echo( ! $poll_retain_forever ? ' active' : '' ); ?>">
					<input type="radio"
						name="poll_retain_submission_forever"
						value="false"
						id="poll_retain_submission-false"
						data-tab-menu="poll_retain_submission"
						<?php checked( $poll_retain_forever, false ); ?> />
					<?php esc_html_e( 'Benutzerdefiniert', Powerform::DOMAIN ); ?>
				</label>

			</div>

			<div class="sui-tabs-content">

				<div data-tab-content="poll_retain_submission" class="sui-tab-content sui-tab-boxed<?php echo( ! $poll_retain_forever ? ' active' : '' ); ?>">

					<div class="sui-row">
						<div class="sui-col-md-6">
							<div class="sui-form-field">

								<input type="number"
									name="poll_submissions_retention_number"
									placeholder="<?php esc_html_e( 'Z.B. 10', Powerform::DOMAIN ); ?>"
									value="<?php echo esc_attr( $poll_submissions_retain_number ); ?>"
									min="0"
									class="sui-form-control sui-form-control-inline"/>

							</div>
						</div>
						<div class="sui-col-md-6">
							<div class="sui-form-field">
								<select name="poll_submissions_retention_unit">
									<option value="days" <?php selected( $poll_submissions_retain_unit, 'days' ); ?>>
										<?php esc_html_e( 'Tag(e)', Powerform::DOMAIN ); ?></option>
									<option value="weeks" <?php selected( $poll_submissions_retain_unit, 'weeks' ); ?>>
										<?php esc_html_e( 'Woche(n)', Powerform::DOMAIN ); ?></option>
									<option value="months" <?php selected( $poll_submissions_retain_unit, 'months' ); ?>>
										<?php esc_html_e( 'Monat(e)', Powerform::DOMAIN ); ?></option>
									<option value="years" <?php selected( $poll_submissions_retain_unit, 'years' ); ?>>
										<?php esc_html_e( 'Jahr(e)', Powerform::DOMAIN ); ?></option>
								</select>

							</div>
						</div>
					</div>


				</div>

			</div>

		</div>

		<span class="sui-settings-label"><?php esc_html_e( 'IP-Aufbewahrung', Powerform::DOMAIN ); ?></span>
		<span class="sui-description">
			<?php
			esc_html_e( 'Wähle aus, wie lange die IP-Adresse beibehalten werden soll, bevor eine Übermittlung anonymisiert wird. Beachte dass die IP-Adresse zum Überprüfen mehrerer Stimmen desselben Benutzers verwendet wird.', Powerform::DOMAIN ); ?>
		</span>

		<div class="sui-side-tabs" style="margin-top: 10px;">

			<div class="sui-tabs-menu">

				<label for="retain_poll_submission-true" class="sui-tab-item<?php echo( $poll_submissions_retain_forever ? ' active' : '' ); ?>">
					<input type="radio"
						name="retain_poll_forever"
						value="true"
						id="retain_poll_submission-true"
						<?php checked( $poll_submissions_retain_forever, true ); ?> />
					<?php esc_html_e( 'Für immer', Powerform::DOMAIN ); ?>
				</label>

				<label for="retain_poll_submission-false" class="sui-tab-item<?php echo( ! $poll_submissions_retain_forever ? ' active' : '' ); ?>">
					<input type="radio"
						name="retain_poll_forever"
						value="false"
						data-tab-menu="retain_poll_submission"
						id="retain_poll_submission-false"
						<?php checked( $poll_submissions_retain_forever, false ); ?> />
					<?php esc_html_e( 'Benutzerdefiniert', Powerform::DOMAIN ); ?>
				</label>

			</div>

			<div class="sui-tabs-content">

				<div data-tab-content="retain_poll_submission" class="sui-tab-content sui-tab-boxed<?php echo( ! $poll_submissions_retain_forever ? ' active' : '' ); ?>">

					<div class="sui-row">
						<div class="sui-col-md-6">
							<div class="sui-form-field">

								<input type="number"
									name="votes_retention_number"
									placeholder="<?php esc_html_e( 'Z.B. 10', Powerform::DOMAIN ); ?>"
									value="<?php echo esc_attr( $polls_retain_number ); ?>"
									min="0"
									class="sui-form-control sui-form-control-inline"/>
							</div>
						</div>
						<div class="sui-col-md-6">
							<div class="sui-form-field">

								<select name="votes_retention_unit">
									<option value="days" <?php selected( $polls_retain_unit, 'days' ); ?>>
										<?php esc_html_e( 'Tag(e)', Powerform::DOMAIN ); ?></option>
									<option value="weeks" <?php selected( $polls_retain_unit, 'weeks' ); ?>>
										<?php esc_html_e( 'Woche(n)', Powerform::DOMAIN ); ?></option>
									<option value="months" <?php selected( $polls_retain_unit, 'months' ); ?>>
										<?php esc_html_e( 'Monat(e)', Powerform::DOMAIN ); ?></option>
									<option value="years" <?php selected( $polls_retain_unit, 'years' ); ?>>
										<?php esc_html_e( 'Jahr(e)', Powerform::DOMAIN ); ?></option>
								</select>

							</div>
						</div>
					</div>


				</div>

			</div>

		</div>

	</div>

</div>
