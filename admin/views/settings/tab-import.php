<?php
$section = isset( $_GET['section'] ) ? $_GET['section'] : 'dashboard'; // wpcs csrf ok.

?>

<div class="sui-box" data-nav="import" style="<?php echo esc_attr( 'import' !== $section ? 'display: none;' : '' ); ?>">

	<div class="sui-box-header">
		<h2 class="sui-box-title"><?php esc_html_e( 'Importieren', Powerform::DOMAIN ); ?></h2>
	</div>

	<form class="powerform-settings-save" action="">

		<div class="sui-box-body">

			<div class="sui-box-settings-row">

				<div class="sui-box-settings-col-1">

					<h2 class="sui-settings-label"><?php esc_html_e( 'Plugins von Drittanbietern', Powerform::DOMAIN ); ?></h2>

					<p class="sui-description"><?php esc_html_e( 'Verwende dieses Tool, um Deine vorhandenen Formulare aus anderen Formularerstellungs-Plugins von Drittanbietern automatisch in Powerform zu importieren.', Powerform::DOMAIN ); ?></p>

				</div>

				<div class="sui-box-settings-col-2">

					<div class="sui-form-field">

						<h3 class="sui-settings-label"><?php esc_html_e( 'Contact Form 7', Powerform::DOMAIN ); ?></h3>

						<p class="sui-description" style="margin-bottom: 10px;"><?php esc_html_e( 'Importiere Deine vorhandenen Formulare und die entsprechenden Plugin-Einstellungen aus Contact Form 7. Der Importeur unterstützt auch einige weit verbreitete Add-Ons.', Powerform::DOMAIN ); ?></p>

						<?php if ( powerform_is_import_plugin_enabled( 'cf7' ) ) : ?>

							<button
								role="button"
								class="sui-button psource-open-modal"
								data-modal="import_cform_cf7"
								data-modal-title=""
								data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_popup_import_cform_cf7' ) ); ?>"
							>
								<i class="sui-icon-upload-cloud" aria-hidden="true"></i> <?php esc_html_e( 'Importieren', Powerform::DOMAIN ); ?>
							</button>

						<?php else : ?>

							<div class="sui-notice" style="margin-top: 10px;">
								<p><?php echo esc_html__( 'Contact Form 7 Plugin ist auf Deiner Webseite nicht aktiv.', Powerform::DOMAIN ); ?></p>
							</div>

						<?php endif; ?>

					</div>

					<?php if ( powerform_is_import_plugin_enabled( 'ninjaforms' ) ) : ?>

						<div class="sui-form-field">

							<h3 class="sui-settings-label"><?php esc_html_e( 'Ninja Forms', Powerform::DOMAIN ); ?></h3>

							<p class="sui-description" style="margin-bottom: 10px;"><?php esc_html_e( 'Importiere Deine Formulare aus Ninja Forms', Powerform::DOMAIN ); ?></p>

							<button
								role="button"
								class="sui-button psource-open-modal"
								data-modal="import_cform_ninja"
								data-modal-title=""
								data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_popup_import_cform_ninjaforms' ) ); ?>"
							>
								<i class="sui-icon-upload-cloud" aria-hidden="true"></i> <?php esc_html_e( 'Importiere Ninja Forms', Powerform::DOMAIN ); ?>
							</button>

						</div>

					<?php endif; ?>

					<?php if ( powerform_is_import_plugin_enabled( 'gravityforms' ) ) : ?>

						<div class="sui-form-field">

							<h3 class="sui-settings-label"><?php esc_html_e( 'Gravity Forms', Powerform::DOMAIN ); ?></h3>

							<p class="sui-description" style="margin-bottom: 10px;"><?php esc_html_e( 'Importiere Deine Formulare aus Gravity Forms', Powerform::DOMAIN ); ?></p>

							<button
								role="button"
								class="sui-button psource-open-modal"
								data-modal="import_cform_gravity"
								data-modal-title=""
								data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_popup_import_cform_gravityforms' ) ); ?>"
							>
								<i class="sui-icon-upload-cloud" aria-hidden="true"></i> <?php esc_html_e( 'Importiere Gravity Forms', Powerform::DOMAIN ); ?>
							</button>

						</div>

					<?php endif; ?>

				</div>

			</div>

		</div>

	</form>

</div>
