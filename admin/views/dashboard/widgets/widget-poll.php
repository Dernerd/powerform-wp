<?php
$dashboard_settings = powerform_get_dashboard_settings( 'polls', array() );
$num_recent         = isset( $dashboard_settings['num_recent'] ) ? $dashboard_settings['num_recent'] : 5;
$published          = isset( $dashboard_settings['published'] ) ? filter_var( $dashboard_settings['published'], FILTER_VALIDATE_BOOLEAN ) : true;
$draft              = isset( $dashboard_settings['draft'] ) ? filter_var( $dashboard_settings['draft'], FILTER_VALIDATE_BOOLEAN ) : true;
$statuses           = array();
if ( $published ) {
	$statuses[] = Powerform_Base_Form_Model::STATUS_PUBLISH;
}
if ( $draft ) {
	$statuses[] = Powerform_Base_Form_Model::STATUS_DRAFT;
}

if ( 0 === $num_recent ) {
	return;
}
?>

	<div class="sui-box">

		<div class="sui-box-header">

			<h3 class="sui-box-title"><i class="sui-icon-graph-bar" aria-hidden="true"></i><?php esc_html_e( 'Umfragen', Powerform::DOMAIN ); ?></h3>

		</div>

		<div class="sui-box-body">

			<p><?php esc_html_e( 'Erstelle interaktive Umfragen, um die Meinungen der Benutzer mit vielen dynamischen Optionen und Einstellungen zu sammeln.', Powerform::DOMAIN ); ?></p>

			<?php if ( 0 === powerform_polls_total() ) { ?>

				<p><button href="/" class="sui-button sui-button-blue psource-open-modal" data-modal="polls"><i class="sui-icon-plus" aria-hidden="true"></i> <?php esc_html_e( 'Erstellen', Powerform::DOMAIN ); ?></button></p>

			<?php } ?>

		</div>

		<?php if ( powerform_polls_total() > 0 ) { ?>

			<table class="sui-table sui-table-flushed">

				<thead>

					<tr>

						<th><?php esc_html_e( 'Name', Powerform::DOMAIN ); ?></th>
						<th class="fui-col-status"></th>

					</tr>

				</thead>

				<tbody>

					<?php foreach ( powerform_polls_modules( $num_recent, $statuses ) as $module ) { ?>

						<tr>

							<td class="sui-table-item-title"><?php echo esc_html( $module['name'] ); ?></td>

							<td class="fui-col-status">

								<?php
								if ( 'publish' === $module['status'] ) {
									$status_class = 'published';
									$status_text  = esc_html__( 'Veröffentlicht', Powerform::DOMAIN );
								} else {
									$status_class = 'draft';
									$status_text  = esc_html__( 'Entwurf', Powerform::DOMAIN );
								}
								?>

								<span
									class="sui-status-dot sui-<?php echo esc_html( $status_class ); ?> sui-tooltip"
									data-tooltip="<?php echo esc_html( $status_text ); ?>"
								>
									<span aria-hidden="true"></span>
								</span>

								<a href="<?php echo admin_url( 'admin.php?page=powerform-poll&view-stats=' . esc_attr( $module['id'] ) ); // phpcs:ignore ?>"
									class="sui-button-icon sui-tooltip"
									data-tooltip="<?php esc_html_e( 'Statistiken anzeigen', Powerform::DOMAIN ); ?>">
									<i class="sui-icon-graph-line" aria-hidden="true"></i>
								</a>

								<div class="sui-dropdown">

									<button class="sui-button-icon sui-dropdown-anchor"
										aria-expanded="false"
										aria-label="<?php esc_html_e( 'Mehr Optionen', Powerform::DOMAIN ); ?>">
										<i class="sui-icon-widget-settings-config" aria-hidden="true"></i>
									</button>

									<ul>
										<li>
											<a href="<?php echo admin_url( 'admin.php?page=powerform-poll-wizard&id=' . $module['id'] ); // phpcs:ignore ?>">
												<i class="sui-icon-pencil" aria-hidden="true"></i> <?php esc_html_e( 'Bearbeiten', Powerform::DOMAIN ); ?>
											</a>
										</li>
										<li><button class="psource-open-modal"
											data-modal="preview_polls"
											data-modal-title="<?php echo sprintf( '%s - %s', __( 'Vorschau der Umfrage', Powerform::DOMAIN ), powerform_get_form_name( $module['id'], 'poll' ) ); // phpcs:ignore ?>"
											data-nonce-preview="<?php echo esc_attr( wp_create_nonce( 'powerform_load_module' ) ); ?>"
											data-form-id="<?php echo esc_attr( $module['id'] ); ?>"
											data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_popup_preview_polls' ) ); ?>">
											<i class="sui-icon-eye" aria-hidden="true"></i> <?php esc_html_e( 'Vorschau', Powerform::DOMAIN ); ?>
										</button></li>

										<li>
											<button class="copy-clipboard" data-shortcode='[powerform_poll id="<?php echo esc_attr( $module['id'] ); ?>"]'><i class="sui-icon-code" aria-hidden="true"></i> <?php esc_html_e( 'Shortcode kopieren', Powerform::DOMAIN ); ?></button>
										</li>

										<li><a href="<?php echo admin_url( 'admin.php?page=powerform-entries&form_type=powerform_polls&form_id=' . $module['id'] ); // phpcs:ignore ?>"><i class="sui-icon-community-people" aria-hidden="true"></i> <?php esc_html_e( 'Einsendungen', Powerform::DOMAIN ); ?></a></li>

										<li><form method="post">
											<input type="hidden" name="powerform_action" value="clone">
											<input type="hidden" name="id" value="<?php echo esc_attr( $module['id'] ); ?>"/>
											<?php wp_nonce_field( 'powerformPollFormRequest', 'powerformNonce' ); ?>
											<button type="submit">
												<i class="sui-icon-page-multiple" aria-hidden="true"></i> <?php esc_html_e( 'Duplikat', Powerform::DOMAIN ); ?>
											</button>
										</form></li>

										<?php if ( Powerform::is_import_export_feature_enabled() ) : ?>

											<li><a href="#"
												class="psource-open-modal"
												data-modal="export_poll"
												data-modal-title=""
												data-form-id="<?php echo esc_attr( $module['id'] ); ?>"
												data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_popup_export_poll' ) ); ?>">
												<i class="sui-icon-cloud-migration" aria-hidden="true"></i> <?php esc_html_e( 'Exportieren', Powerform::DOMAIN ); ?>
											</a></li>

										<?php endif; ?>

										<li><a href="#"
											class="psource-open-modal"
											data-modal="delete-module"
											data-modal-title="<?php esc_attr_e( 'Umfrage löschen', Powerform::DOMAIN ); ?>"
											data-modal-content="<?php esc_attr_e( 'Möchtest Du diese Umfrage wirklich dauerhaft löschen?', Powerform::DOMAIN ); ?>"
											data-form-id="<?php echo esc_attr( $module['id'] ); ?>"
											data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerformPollFormRequest' ) ); ?>">
												<i class="sui-icon-trash" aria-hidden="true"></i> <?php esc_html_e( 'Löschen', Powerform::DOMAIN ); ?>
											</a></li>

									</ul>

								</div>

							</td>

						</tr>

					<?php } ?>

				</tbody>

			</table>

			<div class="sui-box-footer">

				<button class="sui-button sui-button-blue psource-open-modal powerform-create-poll"
					data-modal="polls">
					<i class="sui-icon-plus" aria-hidden="true"></i> <?php esc_html_e( 'Erstellen', Powerform::DOMAIN ); ?>
				</button>

				<div class="sui-actions-right">
					<p class="sui-description"><a href="<?php echo admin_url( 'admin.php?page=powerform-poll' ); // phpcs:ignore ?>" class="sui-link-gray"><?php esc_html_e( 'Alle Umfragen anzeigen', Powerform::DOMAIN ); ?></a></p>
				</div>

			</div>

		<?php } ?>

	</div>
