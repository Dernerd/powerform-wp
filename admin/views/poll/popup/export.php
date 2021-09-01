<?php
$form_id = $_POST['id'];// phpcs:ignore -- varified on admin ajax
$nonce   = wp_create_nonce( 'powerformPollFormRequest' );

$exportable = array();
$model      = Powerform_Poll_Form_Model::model()->load( $form_id );
if ( $model instanceof Powerform_Poll_Form_Model ) {
	$exportable = $model->to_exportable_data();
}
$text_area_id = uniqid( 'export-text-' );
?>

<div class="sui-box-body psource-popup-form">

	<div class="sui-form-field">
		<textarea class="sui-form-control" readonly="readonly" rows="10" id="<?php echo esc_attr( $text_area_id ); ?>"></textarea>
		<span class="sui-description"><?php esc_html_e( 'Kopiere den gesamten Text oben und füge ihn in den Importdialog ein.', Powerform::DOMAIN ); ?></span>
	</div>

	<div class="sui-notice sui-notice-info">
		<p>
			<?php
			echo(
			sprintf(
				__( 'Du kannst diese %1$s in Powerform %2$s%3$s%4$s oder höher importieren. Die %5$s können bei einer niedrigeren Version als Deiner Installation beschädigt werden.', Powerform::DOMAIN ), //phpcs:ignore
				__( 'Umfrage', Powerform::DOMAIN ),//phpcs:ignore
				'<strong>',
				POWERFORM_VERSION,//phpcs:ignore
				'</strong>',
				__( 'Umfragen', Powerform::DOMAIN )
			)
			);
			?>
		</p>
	</div>

</div>

<div class="sui-box-footer">

	<button class="sui-button powerform-popup-cancel" data-a11y-dialog-hide="powerform-popup"><?php esc_html_e( 'Schließen', Powerform::DOMAIN ); ?></button>

	<div class="sui-actions-right">

		<form action="<?php echo esc_attr( admin_url( 'admin.php?page=powerform-poll' ) ); ?>" method="post">
			<input type="hidden" name="powerform_action" value="export">
			<input type="hidden" name="powerformNonce" value="<?php echo esc_attr( $nonce ); ?>">
			<input type="hidden" name="id" value="<?php echo esc_attr( $form_id ); ?>">
			<button class="sui-button sui-button-primary"><i class="sui-icon-download" aria-hidden="true"></i> <?php esc_html_e( 'Herunterladen', Powerform::DOMAIN ); ?></button>
		</form>

	</div>

</div>

<?php // using jquery to avoid html escape on popup ajax load ?>
<script type="text/javascript">
	jQuery('#<?php echo esc_attr( $text_area_id ); ?>').val(JSON.stringify(<?php echo wp_json_encode( $exportable ); ?>));
</script>
