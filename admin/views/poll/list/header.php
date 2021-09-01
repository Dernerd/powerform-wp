<?php $count = $this->countModules(); ?>

<h1 class="sui-header-title"><?php esc_html_e( 'Umfragen', Powerform::DOMAIN ); ?></h1>

<div class="sui-actions-left">

	<button class="sui-button sui-button-blue psource-button-open-modal" data-modal="polls"><i class="sui-icon-plus" aria-hidden="true"></i> <?php esc_html_e( 'Erstellen', Powerform::DOMAIN ); ?></button>

	<?php if ( Powerform::is_import_export_feature_enabled() ) : ?>

		<a href="#"
			class="sui-button psource-open-modal"
			data-modal="import_poll"
			data-modal-title=""
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'powerform_popup_import_poll' ) ); ?>">
			<i class="sui-icon-upload-cloud" aria-hidden="true"></i> <?php esc_html_e( 'Importieren', Powerform::DOMAIN ); ?>
		</a>

	<?php endif; ?>

</div>

<div class="sui-actions-right">
	<?php if ( powerform_is_show_documentation_link() ) : ?>
		<a href="https://n3rds.work/docs/wpmu-dev-plugins/powerform/#polls" target="_blank" class="sui-button sui-button-ghost">
			<i class="sui-icon-academy"></i> <?php esc_html_e( 'View Documentation', Powerform::DOMAIN ); ?>
		</a>
	<?php endif; ?>
</div>
