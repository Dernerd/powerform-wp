<?php
$section = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : 'dashboard';
$nonce = wp_create_nonce( 'powerform_save_dashboard_settings' );
?>

<div class="sui-box" data-nav="dashboard" style="<?php echo esc_attr( 'dashboard' !== $section ? 'display: none;' : '' ); ?>">

	<div class="sui-box-header">
		<h2 class="sui-box-title"><?php esc_html_e( 'Allgemeines', Powerform::DOMAIN ); ?></h2>
	</div>

	<form class="powerform-settings-save" action="">

		<div class="sui-box-body">

			<div class="sui-box-settings-row">

				<div class="sui-box-settings-col-1">
					<span class="sui-settings-label"><?php esc_html_e( 'Dashboard', Powerform::DOMAIN ); ?></span>
					<span class="sui-description"><?php esc_html_e( 'Passe das Powerform-Dashboard nach Deinen Wünschen an.', Powerform::DOMAIN ); ?></span>
				</div>

				<div class="sui-box-settings-col-2">

					<label class="sui-settings-label"><?php esc_html_e( 'Auflistung der Module', Powerform::DOMAIN ); ?></label>

					<span class="sui-description" style="margin-bottom: 10px;"><?php esc_html_e( 'Wähle die Anzahl der Module nach Modultyp und/oder Status aus, die im Dashboard angezeigt werden sollen.', Powerform::DOMAIN ); ?></span>

					<div class="sui-tabs sui-tabs-overflow">

						<div role="tablist" class="sui-tabs-menu">
							<button type="button" role="tab" id="dashboard-forms-tab" class="sui-tab-item active" aria-controls="dashboard-forms-panel" aria-selected="true"><?php esc_html_e( 'Formulare', Powerform::DOMAIN ); ?></button>
							<button type="button" role="tab" id="dashboard-polls-tab" class="sui-tab-item" aria-controls="dashboard-polls-panel" aria-selected="false" tabindex="-1"><?php esc_html_e( 'Umfragen', Powerform::DOMAIN ); ?></button>
							<button type="button" role="tab" id="dashboard-quizzes-tab" class="sui-tab-item" aria-controls="dashboard-quizzes-panel" aria-selected="false" tabindex="-1"><?php esc_html_e( 'Tests', Powerform::DOMAIN ); ?></button>
						</div>

						<div class="sui-tabs-content">

							<?php // TAB: Formulare ?>
							<div tabindex="0" role="tabpanel" id="dashboard-forms-panel" class="forms-content sui-tab-content active" aria-labelledby="dashboard-forms-tab">
								<?php $this->template( 'settings/dashboard/forms' ); ?>
							</div>

							<?php // TAB: Umfragen ?>
							<div tabindex="0" role="tabpanel" id="dashboard-polls-panel" class="polls-content sui-tab-content" aria-labelledby="dashboard-polls-tab" hidden>
								<?php $this->template( 'settings/dashboard/polls' ); ?>
							</div>

							<?php // TAB: Tests ?>
							<div tabindex="0" role="tabpanel" id="dashboard-quizzes-panel" class="quizzes-content sui-tab-content" aria-labelledby="dashboard-quizzes-tab" hidden>
								<?php $this->template( 'settings/dashboard/quizzes' ); ?>
							</div>

						</div>

					</div>

				</div>

			</div>

			<?php $this->template( 'settings/tab-emails' ); ?>

			<?php $this->template( 'settings/tab-pagination' ); ?>

			<?php $this->template( 'settings/tab-editor' ); ?>

		</div>

		<div class="sui-box-footer">

			<div class="sui-actions-right">

				<button class="sui-button sui-button-blue psource-action-done" data-title="<?php esc_attr_e( 'Allgemeine Einstellungen', Powerform::DOMAIN ); ?>" data-action="dashboard_settings" data-nonce="<?php echo esc_attr( $nonce ); ?>">
					<span class="sui-loading-text"><?php esc_html_e( 'Save Settings', Powerform::DOMAIN ); ?></span>
					<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
				</button>

			</div>

		</div>

	</form>

</div>
