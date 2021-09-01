<?php
$total_modules           = powerform_total_forms();
$count_active            = powerform_total_forms( 'publish' );
$forms_total_submissions = Powerform_Form_Entry_Model::count_all_entries_by_type( 'custom-forms' ); // phpcs:ignore -- powerform_cforms_total();
$poll_total_submissions  = Powerform_Form_Entry_Model::count_all_entries_by_type( 'poll' );// phpcs:ignore -- powerform_polls_total();
$quiz_total_submissions  = Powerform_Form_Entry_Model::count_all_entries_by_type( 'quizzes' );// phpcs:ignore -- powerform_quizzes_total();
$last_submission         = powerform_get_latest_entry_time( 'custom-forms' );
?>

<div class="sui-box sui-summary <?php echo esc_attr( $this->get_box_summary_classes() ); ?>">

	<div class="sui-summary-image-space" aria-hidden="true" style="<?php echo esc_attr( $this->get_box_summary_image_style() ); ?>"></div>

	<div class="sui-summary-segment">

		<div class="sui-summary-details">

			<?php if ( 0 < $total_modules ) { ?>
				<span class="sui-summary-large"><?php echo esc_html( $count_active ); ?></span>
			<?php } else { ?>
				<span class="sui-summary-large">0</span>
			<?php } ?>

			<?php if ( 1 === $total_modules ) { ?>
				<span class="sui-summary-sub"><?php esc_html_e( 'Aktives Modul', Powerform::DOMAIN ); ?></span>
			<?php } else { ?>
				<span class="sui-summary-sub"><?php esc_html_e( 'Aktive Module', Powerform::DOMAIN ); ?></span>
			<?php } ?>

			<?php if ( $total_modules > 0 ) { ?>
				<span class="sui-summary-detail"><strong><?php echo esc_html( $last_submission ); ?></strong></span>
			<?php } else { ?>
				<span class="sui-summary-detail"><strong><?php esc_html_e( 'Noch keine', Powerform::DOMAIN ); ?></strong></span>
			<?php } ?>

			<span class="sui-summary-sub"><?php esc_html_e( 'Letzte Einsendung', Powerform::DOMAIN ); ?></span>

		</div>

	</div>

	<div class="sui-summary-segment">

		<ul class="sui-list">

			<li>
				<span class="sui-list-label"><?php esc_html_e( 'Formularübermittlungen', Powerform::DOMAIN ); ?></span>
				<?php if ( $forms_total_submissions > 0 ) { ?>
					<span class="sui-list-detail"><?php echo esc_html( $forms_total_submissions ); ?></span>
				<?php } else { ?>
					<span class="sui-list-detail">0</span>
				<?php } ?>
			</li>

			<li>
				<span class="sui-list-label"><?php esc_html_e( 'Umfrageergebnisse', Powerform::DOMAIN ); ?></span>
				<?php if ( $poll_total_submissions > 0 ) { ?>
					<span class="sui-list-detail"><?php echo esc_html( $poll_total_submissions ); ?></span>
				<?php } else { ?>
					<span class="sui-list-detail">0</span>
				<?php } ?>
			</li>

			<li>
				<span class="sui-list-label"><?php esc_html_e( 'Testergebnisse', Powerform::DOMAIN ); ?></span>
				<?php if ( $quiz_total_submissions > 0 ) { ?>
					<span class="sui-list-detail"><?php echo esc_html( $quiz_total_submissions ); ?></span>
				<?php } else { ?>
					<span class="sui-list-detail">0</span>
				<?php } ?>
			</li>

		</ul>

	</div>

</div>
