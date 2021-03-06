<?php
$entries          = $this->get_table();
$form_type        = $this->get_form_type();
$count            = $this->get_total_entries();
$entries_per_page = $this->get_per_page();
$first_item  = $count;
$page_number = $this->get_paged();

if ( $page_number > 1 ) {
	$first_item = $count - ( ( $page_number - 1 ) * $entries_per_page );
}
?>

<?php foreach ( $entries as $entry ) : ?>

    <tr class="sui-accordion-item">

        <td>
            <label class="sui-checkbox">
                <input name="ids[]" value="<?php echo esc_attr( $entry->entry_id ); ?>" type="checkbox" id="quiz-answer-<?php echo esc_attr( $entry->entry_id ); ?>">
                <span></span>
                <div class="sui-description"><?php echo esc_attr( $first_item ); ?></div>
            </label>
        </td>

        <td colspan="5">
			<?php echo date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $entry->date_created_sql ) ); // phpcs:ignore ?>
            <span class="sui-accordion-open-indicator">
							<i class="sui-icon-chevron-down"></i>
						</span>
        </td>

    </tr>

    <tr class="sui-accordion-item-content">

        <td colspan="6">

			<div class="sui-box">

				<div class="sui-box-body fui-entries--knowledge">

					<?php // ROW: Title. ?>
					<div class="fui-entries-block">

						<h2 class="fui-entries-title"><?php echo '#' . esc_attr( $first_item ); ?></h2>

						<p class="sui-description"><?php echo date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $entry->date_created_sql ) ); // phpcs:ignore ?></p>

					</div>

					<?php // ROW: Lead Details. ?>
					<?php if ( isset( $entry->meta_data['lead_entry'] ) && isset( $entry->meta_data['lead_entry']['value'] ) ) { ?>

						<div class="fui-entries-block">

							<h3 class="fui-entries-subtitle"><?php esc_html_e( 'Lead Details', Powerform::DOMAIN ); ?></h3>

							<table class="fui-entries-table" data-design="ghost">

								<tbody>

									<?php foreach( $entry->meta_data['lead_entry']['value'] as $lead_entry ) { ?>

										<tr>

											<td><?php echo $lead_entry['name']; // phpcs:ignore ?></td>
											<td><?php echo $lead_entry['value']; // phpcs:ignore ?></td>

										</tr>

									<?php } ?>

								</tbody>

							</table>

						</div>

					<?php } ?>

					<?php // ROW: Quiz Results. ?>
					<div class="fui-entries-block">

						<h3 class="fui-entries-subtitle"><?php esc_html_e( 'Testergebnisse', Powerform::DOMAIN ); ?></h3>

						<?php if ( 'knowledge' === $form_type ) { ?>

							<?php
							$meta  = $entry->meta_data['entry']['value'];
							$total = 0;
							$right = 0;
							?>

							<p class="sui-description"><?php echo sprintf( __( 'Du hast %s/%s richtige Antworten.', Powerform::DOMAIN ), $right, $total ); // phpcs:ignore ?></p>

							<table class="fui-entries-table">

								<thead>

									<tr>
										<th><?php esc_html_e( 'Frage', Powerform::DOMAIN ); ?></th>
										<th><?php esc_html_e( 'Antwort', Powerform::DOMAIN ); ?></th>
									</tr>

								</thead>

								<tbody>

									<?php foreach ( $meta as $answer ) : ?>

										<?php
										$total ++;

										if ( $answer['isCorrect'] ) {
											$right ++;
										}

										$user_answer = $answer['answer'];
										?>

										<tr>
											<td><strong><?php echo esc_html( $answer['question'] ); ?></strong></td>
											<td>
												<?php if ( $answer['isCorrect'] ) {
													echo '<span class="sui-tag sui-tag-success">' . esc_html( $user_answer ) . '</span>';
												} else {
													echo '<span class="sui-tag sui-tag-error">' . esc_html( $user_answer ) . '</span>';
												} ?>
											</td>
										</tr>

									<?php endforeach; ?>

								</tbody>

								<tfoot aria-hidden="true">

									<tr>

										<td colspan="2">

											<div class="fui-entries-table-legend">

												<p class="correct"><?php esc_html_e( 'Richtig', Powerform::DOMAIN ); ?></p>

												<p class="incorrect"><?php esc_html_e( 'Falsch', Powerform::DOMAIN ); ?></p>

											</div>

										</td>

									</tr>

								</tfoot>

							</table>

						<?php } else { ?>

							<?php $meta = $entry->meta_data['entry']['value'][0]['value']; ?>

							<?php if ( isset( $meta['answers'] ) && is_array( $meta['answers'] ) ) : ?>

								<table class="fui-entries-table">

									<thead>

										<tr>
											<th><?php esc_html_e( 'Frage', Powerform::DOMAIN ); ?></th>
											<th><?php esc_html_e( 'Antwort', Powerform::DOMAIN ); ?></th>
										</tr>

									</thead>

									<tbody>

										<?php foreach ( $meta['answers'] as $answer ) : ?>

											<tr>
												<td><strong><?php echo esc_html( $answer['question'] ); ?></strong></td>
												<td><?php echo esc_html( $answer['answer'] ); ?></td>
											</tr>

										<?php endforeach; ?>

									</tbody>

									<tfoot aria-hidden="true">

										<tr>

											<td colspan="2"><?php printf( __( '<strong>Testergebnis:</strong> %s', Powerform::DOMAIN ), $meta['result']['title'] ); // phpcs:ignore ?></td>

										</tr>

									</tfoot>

								</table>

							<?php endif; ?>

						<?php } ?>

					</div>

				</div>

			</div>

        </td>

    </tr>

	<?php
	$first_item --;

endforeach;
