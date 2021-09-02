<?php
$count = Powerform_Form_Entry_Model::count_all_entries();
?>

<?php if ( $count > 0 ) { ?>

	<?php
        $markup = $this->render_entries();
    
        if ( ! empty( $_GET[ 'form_type' ] ) ) {
            update_option( 'powerform_submissions_form_type', sanitize_text_field( $_GET[ 'form_type' ] ) );
        }
        if ( ! empty( $_GET[ 'form_id' ] ) ) {
            update_option( 'powerform_submissions_form_id', sanitize_text_field( $_GET[ 'form_id' ] ) );
        }

        $form_type = get_option( 'powerform_submissions_form_type' );
        $form_id   = get_option( 'powerform_submissions_form_id' );
    ?>

	<form method="get"
		name="bulk-action-form"
		class="sui-box">

		<div class="fui-entries-bar">

			<div class="fui-bar-selectors">

				<input type="hidden" name="page" value="powerform-entries" />

				<select
					name="form_type"
					onchange="submit()"
					class="sui-select-sm"
				>

					<?php foreach ( $this->get_form_types() as $post_type => $name ) { // phpcs:ignore ?>
						<option value="<?php echo esc_attr( $post_type ); ?>" <?php echo selected( $post_type, $form_type ); ?>><?php echo esc_html( $name ); ?></option>
					<?php } ?>

				</select>

				<?php echo $this->render_form_switcher( $form_type, $form_id ); // phpcs:ignore ?>

			</div>

			<button class="sui-button sui-button-blue show-submissions" onclick="submit()"><?php esc_html_e( 'Einsendungen anzeigen', Powerform::DOMAIN ); ?></button>

			<?php if ( $markup ) : ?>
				<a href="/" class="sui-button sui-button-ghost psource-open-modal" data-modal="exports-schedule"><i class="sui-icon-paperclip" aria-hidden="true"></i> <?php esc_html_e( 'Exportieren', Powerform::DOMAIN ); ?></a>
			<?php endif; ?>

		</div>

	</form>

	<?php if ( $markup ) : ?>

		<?php echo $markup; // phpcs:ignore ?>

	<?php else : ?>

		<div class="sui-box sui-message">

			<?php if ( powerform_is_show_branding() ) : ?>
				<img src="<?php echo esc_url( powerform_plugin_url() . 'assets/img/powerform-disabled.png' ); ?>"
					srcset="<?php echo esc_url( powerform_plugin_url() . 'assets/img/powerform-disabled.png' ); ?> 1x, <?php echo esc_url( powerform_plugin_url() . 'assets/img/powerform-disabled@2x.png' ); ?> 2x"
					alt="<?php esc_html_e( 'Powerform', Powerform::DOMAIN ); ?>"
					class="sui-image"/>
			<?php endif; ?>

			<div class="sui-message-content">

				<h2><?php esc_html_e( 'Fast dort!', Powerform::DOMAIN ); ?></h2>

				<p><?php esc_html_e( 'Wähle das Formular-, Umfrage- oder Testmodul aus, um die entsprechenden Einreichungen anzuzeigen.', Powerform::DOMAIN ); ?></p>

			</div>

		</div>

	<?php endif; ?>

<?php } else { ?>

	<div class="sui-box sui-message">

		<?php if ( powerform_is_show_branding() ) : ?>
			<img src="<?php echo esc_url( powerform_plugin_url() . 'assets/img/powerform-submissions.png' ); ?>"
				srcset="<?php echo esc_url( powerform_plugin_url() . 'assets/img/powerform-submissions.png' ); ?> 1x, <?php echo esc_url( powerform_plugin_url() . 'assets/img/powerform-submissions@2x.png' ); ?> 2x"
				alt="<?php esc_html_e( 'Powerform', Powerform::DOMAIN ); ?>"
				class="sui-image"/>
		<?php endif; ?>

		<div class="sui-message-content">

			<h2><?php esc_html_e( 'Einreichungen', Powerform::DOMAIN ); ?></h2>

			<p><?php esc_html_e( 'Du hast noch keine Formular-, Umfrage- oder Test-Einsendungen erhalten. Wenn Du dies tust, kannst Du alle Daten hier einsehen.', Powerform::DOMAIN ); ?></p>

		</div>

	</div>

<?php } ?>
