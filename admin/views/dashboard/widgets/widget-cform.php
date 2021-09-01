<?php
$dashboard_settings = powerform_get_dashboard_settings( 'forms', array() );
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
};
?>

<div class="sui-box">

	<div class="sui-box-header">

		<h3 class="sui-box-title"><i class="sui-icon-clipboard-notes" aria-hidden="true"></i><?php esc_html_e( 'Formulare', Powerform::DOMAIN ); ?></h3>

	</div>

	<div class="sui-box-body">

		<p><?php esc_html_e( 'Erstelle jede Art von Formular aus einer unserer vorgefertigten Vorlagen oder erstelle Deine eigenen von Grund auf neu.', Powerform::DOMAIN ); ?></p>

		<?php // Strict comparison is removed for a reason! ?>
		<?php if ( 0 == powerform_cforms_total() ) { // WPCS: loose comparison ok ?>

			<p><button href="/" class="sui-button sui-button-blue psource-open-modal" data-modal="custom_forms"><i class="sui-icon-plus" aria-hidden="true"></i> <?php esc_html_e( 'Erstellen', Powerform::DOMAIN ); ?></button></p>

		<?php } ?>

	</div>

	<?php if ( 0 < powerform_cforms_total() ) { ?>

		<table class="sui-table sui-table-flushed">

			<thead>

				<tr>

					<th><?php esc_html_e( 'Name', Powerform::DOMAIN ); ?></th>

					<th class="fui-col-status"><?php esc_html_e( 'Status', Powerform::DOMAIN ); ?></th>

				</tr>

			</thead>

			<tbody>

				<?php foreach ( powerform_cform_modules( $num_recent, $statuses ) as $module ) { ?>

					<tr>

						<td class="sui-table-item-title"><?php echo powerform_get_form_name( $module['id'], 'custom_form' ); // phpcs:ignore ?></td>

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

							<a href="<?php echo admin_url( 'admin.php?page=powerform-cform&view-stats=' . esc_attr( $module['id'] ) ); // phpcs:ignore ?>"
								class="sui-button-icon sui-tooltip sui-tooltip-top-right-mobile"
								data-tooltip="<?php esc_html_e( 'Statistiken anzeigen', Powerform::DOMAIN ); ?>">
								<span class="sui-icon-graph-line" aria-hidden="true"></span>
							</a>

							<div class="sui-dropdown">

								<button class="sui-button-icon sui-dropdown-anchor"
									aria-expanded="false"
									aria-label="<?php esc_html_e( 'Mehr Optionen', Powerform::DOMAIN ); ?>">
									<span class="sui-icon-widget-settings-config" aria-hidden="true"></span>
								</button>

								<ul>
									<li>
										<a href="<?php echo admin_url( 'admin.php?page=powerform-cform-wizard&id=' . $module['id'] ); // phpcs:ignore ?>">
											<span class="sui-icon-pencil" aria-hidden="true"></span> <?php esc_html_e( 'Bearbeiten', Powerform::DOMAIN ); ?>
										</a>
									</li>
									<li><button class="psource-open-modal"
										data-modal="preview_cforms"
										data-modal-title="<?php echo sprintf( '%s - %s', esc_html__( 'Vorschau des benutzerdefinierten Formulars', Powerform::DOMAIN ), powerform_get_form_name( $module['id'], 'custom_form' ) ); // phpcs:ignore ?>"
										data-nonce-preview="<?php echo esc_attr( wp_create_nonce( 'powerform_load_module' ) ); ?>"
										data-form-id="<?php echo esc_attr( $module['id'] ); ?>"
										data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_popup_preview_cforms' ) ); ?>">
										<span class="sui-icon-eye" aria-hidden="true"></span> <?php esc_html_e( 'Vorschau', Powerform::DOMAIN ); ?>
									</button></li>

									<li>
										<button class="copy-clipboard" data-shortcode='[powerform_form id="<?php echo esc_attr( $module['id'] ); ?>"]'><i class="sui-icon-code" aria-hidden="true"></i> <?php esc_html_e( 'Shortcode kopieren', Powerform::DOMAIN ); ?></button>
									</li>

									<li><a href="<?php echo admin_url( 'admin.php?page=powerform-entries&form_type=powerform_forms&form_id=' . $module['id'] ); // phpcs:ignore ?>"><i class="sui-icon-community-people" aria-hidden="true"></i> <?php esc_html_e( 'Einsendungen', Powerform::DOMAIN ); ?></a></li>

									<li><form method="post">
										<input type="hidden" name="powerform_action" value="clone">
										<input type="hidden" name="id" value="<?php echo esc_attr( $module['id'] ); ?>"/>
										<?php wp_nonce_field( 'powerformCustomFormRequest', 'powerformNonce' ); ?>
										<button type="submit">
											<span class="sui-icon-page-multiple" aria-hidden="true"></span> <?php esc_html_e( 'Klonen', Powerform::DOMAIN ); ?>
										</button>
									</form></li>

									<?php if ( Powerform::is_import_export_feature_enabled() ) : ?>

										<li><a href="#"
											class="psource-open-modal"
											data-modal="export_cform"
											data-modal-title=""
											data-form-id="<?php echo esc_attr( $module['id'] ); ?>"
											data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_popup_export_cform' ) ); ?>">
											<span class="sui-icon-cloud-migration" aria-hidden="true"></span> <?php esc_html_e( 'Exportieren', Powerform::DOMAIN ); ?>
										</a></li>

									<?php endif; ?>

									<li>
										<button class="psource-open-modal"
											data-modal="delete-module"
											data-modal-title="<?php esc_attr_e( 'Formular löschen', Powerform::DOMAIN ); ?>"
											data-modal-content="<?php esc_attr_e( 'Möchtest Du dieses Formular wirklich dauerhaft löschen?', Powerform::DOMAIN ); ?>"
											data-form-id="<?php echo esc_attr( $module['id'] ); ?>"
											data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerformCustomFormRequest' ) ); ?>">
											<span class="sui-icon-trash" aria-hidden="true"></span> <?php esc_html_e( 'Löschen', Powerform::DOMAIN ); ?>
										</button>
									</li>

								</ul>

							</div>

						</td>

					</tr>

				<?php } ?>

			</tbody>

		</table>

		<div class="sui-box-footer">

			<button class="sui-button sui-button-blue psource-open-modal powerform-create-form"
				data-modal="custom_forms">
				<span class="sui-icon-plus" aria-hidden="true"></span> <?php esc_html_e( 'Erstellen', Powerform::DOMAIN ); ?>
			</button>

			<div class="sui-actions-right">
				<p class="sui-description"><a href="<?php echo admin_url( 'admin.php?page=powerform-cform' ); // phpcs:ignore ?>" class="sui-link-gray"><?php esc_html_e( 'Alle Formulare anzeigen', Powerform::DOMAIN ); ?></a></p>
			</div>

		</div>

	<?php } ?>

</div>
