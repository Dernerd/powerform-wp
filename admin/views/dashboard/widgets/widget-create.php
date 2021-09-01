<?php
$icon_minus  = powerform_plugin_dir() . 'assets/icons/admin-icons/minus.php';
$hero_sample = powerform_plugin_dir() . 'assets/icons/powerform-icons/hero-sample.php';
?>

<div class="psource-row">

	<div class="psource-col col-12">

		<div id="powerform-dashboard-box--create" class="psource-box psource-box--split psource-can--hide">

			<div class="psource-box-header">

				<div class="psource-header--text">

					<h2 class="psource-title"><?php esc_html_e( 'Module erstellen', Powerform::DOMAIN ); ?></h2>

				</div>

				<div class="psource-header--action">

					<button class="psource-box--action" aria-hidden="true"><span class="psource-icon--plus"></span></button>

					<button class="psource-sr-only"><?php esc_html_e( 'Box verstecken', Powerform::DOMAIN ); ?></button>

				</div>

			</div>

			<div class="psource-box-section">

				<?php foreach ( $args ['modules'] as $key => $module ) : ?>

					<div class="psource-split--item">

						<div class="psource-sitem--header">

							<div class="psource-sitem--icon" aria-hidden="true"><?php echo $module->get_icon(); // phpcs:ignore ?></div>

							<h3 class="psource-sitem--title"><?php echo $module->get_name(); // phpcs:ignore ?></h3>

						</div>

						<div class="psource-sitem--section">

							<p><?php echo $module->get_description(); // phpcs:ignore ?></p>

						</div>

						<div class="psource-sitem--footer">

							<button href="/" class="psource-button psource-button-sm psource-button-ghost psource-open-modal" data-modal="<?php echo esc_attr( $module->get_id() ); ?>"><?php echo $module->get_label(); // phpcs:ignore ?></button>

						</div>

					</div>

				<?php endforeach; ?>

			</div>

		</div><?php // .psource-box ?>

	</div><?php // .psource-col ?>

</div><?php // .psource-row ?>
