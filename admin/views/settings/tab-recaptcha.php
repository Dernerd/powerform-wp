<?php
$section = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : 'dashboard';
$v2_captcha_key              = get_option( 'powerform_captcha_key', '' );
$v2_captcha_secret           = get_option( 'powerform_captcha_secret', '' );
$v2_invisible_captcha_key    = get_option( 'powerform_v2_invisible_captcha_key', '' );
$v2_invisible_captcha_secret = get_option( 'powerform_v2_invisible_captcha_secret', '' );
$v3_captcha_key              = get_option( 'powerform_v3_captcha_key', '' );
$v3_captcha_secret           = get_option( 'powerform_v3_captcha_secret', '' );
$captcha_language            = get_option( 'powerform_captcha_language', '' );
$nonce                       = wp_create_nonce( 'powerform_save_popup_captcha' );

$new = true;
?>

<div class="sui-box" data-nav="recaptcha" style="<?php echo esc_attr( 'recaptcha' !== $section ? 'display: none;' : '' ); ?>">

	<div class="sui-box-header">
		<h2 class="sui-box-title"><?php esc_html_e( 'Google reCAPTCHA', Powerform::DOMAIN ); ?></h2>
	</div>

	<form class="powerform-settings-save" action="">

		<div class="sui-box-body">

			<div class="sui-box-settings-row">

				<div class="sui-box-settings-col-1">
					<span class="sui-settings-label"><?php esc_html_e( 'Konfiguriere reCaptcha', Powerform::DOMAIN ); ?></span>
					<span class="sui-description"><?php esc_html_e( 'Gib die reCAPTCHA-Schlüssel und die Spracheinstellung ein, um das reCAPTCHA-Feld in Deinen Formularen zu verwenden.', Powerform::DOMAIN ); ?></span>
				</div>

				<div class="sui-box-settings-col-2">

					<div class="sui-form-field">

						<span class="sui-settings-label"><?php esc_html_e( 'API Schlüssel', Powerform::DOMAIN ); ?></span>
						<span class="sui-description" style="margin-bottom: 10px;"><?php /* translators: ... */ printf( esc_html( __( 'Gib die API-Schlüssel für jeden reCAPTCHA-Typ ein, den Du in Deinen Formularen verwenden möchtest. Beachte, dass für jeden reCAPTCHA-Typ ein anderer Satz von API-Schlüsseln erforderlich ist. %1$sGeneriere API-Schlüssel%2$s', Powerform::DOMAIN ) ), '<a href="https://www.google.com/recaptcha/admin#list" target="_blank">', '</a>' ); ?></span>

						<div class="sui-tabs sui-tabs-overflow">

							<div role="tablist" class="sui-tabs-menu">
								<button type="button" role="tab" id="v2-checkbox" class="sui-tab-item active" aria-controls="v2-checkbox-tab" aria-selected="true"><?php esc_html_e( 'v2 Checkbox', Powerform::DOMAIN ); ?></button>
								<button type="button" role="tab" id="v2-invisible" class="sui-tab-item" aria-controls="v2-invisible-tab" aria-selected="false" tabindex="-1"><?php esc_html_e( 'v2 Unsichtbar', Powerform::DOMAIN ); ?></button>
								<button type="button" role="tab" id="recaptcha-v3" class="sui-tab-item" aria-controls="v3-recaptcha-tab" aria-selected="false" tabindex="-1"><?php esc_html_e( 'v3 reCaptcha', Powerform::DOMAIN ); ?></button>
							</div>

							<div class="sui-tabs-content">

								<?php // TAB: v2 Checkbox ?>
								<div tabindex="0" role="tabpanel" id="v2-checkbox-tab" class="sui-tab-content active" aria-labelledby="v2-checkbox">

									<span class="sui-description"><?php esc_html_e( 'Gib die folgenden API-Schlüssel für reCAPTCHA v2 ein:', Powerform::DOMAIN ); ?></span>

									<div class="sui-form-field">
										<label for="v2_captcha_key" id="v2checkbox-sitekey-label" class="sui-label"><?php esc_html_e( 'Seiten-Schlüssel', Powerform::DOMAIN ); ?></label>
										<input
											type="text"
											name="v2_captcha_key"
											placeholder="<?php esc_html_e( 'Gib hier Deinen Seiten-Schlüssel ein', Powerform::DOMAIN ); ?>"
											value="<?php echo esc_attr( $v2_captcha_key ); ?>"
											id="v2_captcha_key"
											class="sui-form-control"
											aria-labelledby="v2checkbox-sitekey-label"
										/>
									</div>

									<div class="sui-form-field">
										<label for="v2_captcha_secret" id="v2checkbox-secretkey-label" class="sui-label"><?php esc_html_e( 'Geheimer Schlüssel', Powerform::DOMAIN ); ?></label>
										<input
											type="text"
											name="v2_captcha_secret"
											placeholder="<?php esc_html_e( 'Gib hier Deinen geheimen Schlüssel ein', Powerform::DOMAIN ); ?>"
											value="<?php echo esc_attr( $v2_captcha_secret ); ?>"
											id="v2_captcha_secret"
											class="sui-form-control"
											aria-labelledby="v2checkbox-secretkey-label"
										/>
									</div>

									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'reCAPTCHA Vorschau', Powerform::DOMAIN ); ?></label>
										<div id="v2-recaptcha-preview">
											<p class="fui-loading-dialog">
												<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
											</p>
										</div>
										<span class="sui-description"><?php esc_html_e( "Wenn in der Vorschau Fehler auftreten, stelle sicher, dass der von Dir eingegebene Schlüssel gültig ist und Du Deinen Domainnamen beim Generieren der Schlüssel aufgelistet hast.", Powerform::DOMAIN ); ?></span>
									</div>

								</div>

								<?php // TAB: v2 Invisible ?>
								<div tabindex="0" role="tabpanel" id="v2-invisible-tab" class="sui-tab-content" aria-labelledby="v2-invisible" hidden>

									<span class="sui-description"><?php esc_html_e( 'Gib unten die API-Schlüssel für reCAPTCHA v2 Unsichtbar ein:', Powerform::DOMAIN ); ?></span>

									<div class="sui-form-field">
										<label for="invisible_captcha_key" id="v2invisible-sitekey-label" class="sui-label"><?php esc_html_e( 'Seiten-Schlüssel', Powerform::DOMAIN ); ?></label>
										<input
											type="text"
											name="v2_invisible_captcha_key"
											placeholder="<?php esc_html_e( 'Gib hier Deinen Seiten-Schlüssel ein', Powerform::DOMAIN ); ?>"
											value="<?php echo esc_attr( $v2_invisible_captcha_key ); ?>"
											id="invisible_captcha_key"
											class="sui-form-control"
											aria-labelledby="v2invisible-sitekey-label"
										/>
									</div>

									<div class="sui-form-field">
										<label for="invisible_captcha_secret" id="v2invisible-secretkey-label" class="sui-label"><?php esc_html_e( 'Geheimer Schlüssel', Powerform::DOMAIN ); ?></label>
										<input
											type="text"
											name="v2_invisible_captcha_secret"
											placeholder="<?php esc_html_e( 'Gib hier Deinen geheimen Schlüssel ein', Powerform::DOMAIN ); ?>"
											value="<?php echo esc_attr( $v2_invisible_captcha_secret ); ?>"
											id="invisible_captcha_secret"
											class="sui-form-control"
											aria-labelledby="v2invisible-secretkey-label"
										/>
									</div>

									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'reCAPTCHA Vorschau', Powerform::DOMAIN ); ?></label>

										<div id="v2-invisible-recaptcha-preview">
											<p class="fui-loading-dialog">
												<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
											</p>
										</div>

										<span class="sui-description"><?php esc_html_e( "Wenn in der Vorschau Fehler auftreten, stelle sicher, dass der von Dir eingegebene Schlüssel gültig ist und Du Deinen Domainnamen beim Generieren der Schlüssel aufgelistet hast.", Powerform::DOMAIN ); ?></span>
									</div>

								</div>

								<?php // TAB: v3 reCaptcha ?>
								<div tabindex="0" role="tabpanel" id="v3-recaptcha-tab" class="sui-tab-content" aria-labelledby="recaptcha-v3" hidden>

									<span class="sui-description"><?php esc_html_e( 'Gib die folgenden API-Schlüssel für den Typ reCAPTCHA v3 ein:', Powerform::DOMAIN ); ?></span>

									<div class="sui-form-field">
										<label for="v3_captcha_key" id="v3recaptcha-sitekey-label" class="sui-label"><?php esc_html_e( 'Seiten-Schlüssel', Powerform::DOMAIN ); ?></label>
										<input
											type="text"
											name="v3_captcha_key"
											placeholder="<?php esc_html_e( 'Gib hier Deinen Seiten-Schlüssel ein', Powerform::DOMAIN ); ?>"
											value="<?php echo esc_attr( $v3_captcha_key ); ?>"
											id="v3_captcha_key"
											class="sui-form-control"
											aria-labelledby="v3recaptcha-sitekey-label"
										/>
									</div>

									<div class="sui-form-field">
										<label for="v3_captcha_secret" id="v3recaptcha-secretkey-label" class="sui-label"><?php esc_html_e( 'Geheimer Schlüssel', Powerform::DOMAIN ); ?></label>
										<input
											type="text"
											name="v3_captcha_secret"
											placeholder="<?php esc_html_e( 'Gib hier Deinen geheimen Schlüssel ein', Powerform::DOMAIN ); ?>"
											value="<?php echo esc_attr( $v3_captcha_secret ); ?>"
											id="v3_captcha_secret"
											class="sui-form-control"
											aria-labelledby="v3recaptcha-secretkey-label"
										/>
									</div>

									<div class="sui-form-field">

										<label class="sui-label"><?php esc_html_e( 'reCAPTCHA Vorschau', Powerform::DOMAIN ); ?></label>

										<div id="v3-recaptcha-preview">
											<p class="fui-loading-dialog">
												<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
											</p>
										</div>

										<span class="sui-description"><?php esc_html_e( "Wenn in der Vorschau Fehler auftreten, stelle sicher, dass der von Dir eingegebene Schlüssel gültig ist und Du Deinen Domainnamen beim Generieren der Schlüssel aufgelistet hast.", Powerform::DOMAIN ); ?></span>

									</div>

								</div>

							</div>

						</div>

					</div>

					<div class="sui-form-field">

						<span class="sui-settings-label"><?php esc_html_e( 'Sprache', Powerform::DOMAIN ); ?></span>
						<span class="sui-description" style="margin-bottom: 10px;"><?php esc_html_e( 'Standardmäßig zeigen wir das reCAPTCHA in der Sprache Deiner Webseite an.', Powerform::DOMAIN ); ?></span>

						<div style="width: 100%; max-width: 240px;">

							<select name="captcha_language" id="captcha_language" class="sui-select">
								<?php $languages = powerform_get_captcha_languages(); ?>
								<option value=""><?php esc_html_e( 'Automatisch', Powerform::DOMAIN ); ?></option>
								<?php foreach ( $languages as $key => $lang ) : ?>
									<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $captcha_language, $key ); ?>><?php echo esc_html( $lang ); ?></option>
								<?php endforeach; ?>
							</select>

						</div>

					</div>

				</div>

			</div>
		</div>

		<div class="sui-box-footer">

			<div class="sui-actions-right">

				<button
					class="sui-button sui-button-blue psource-action-done"
					data-title="<?php esc_attr_e( 'reCaptcha Einstellungen', Powerform::DOMAIN ); ?>"
					data-action="captcha"
					data-nonce="<?php echo esc_attr( $nonce ); ?>"
				>
					<span class="sui-loading-text"><?php esc_html_e( 'Einstellungen speichern', Powerform::DOMAIN ); ?></span>
					<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
				</button>

			</div>

		</div>

	</form>

</div>
