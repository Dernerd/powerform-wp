<?php
/**
 * JS reference : assets/js/admin/layout.js
 */

/** @var $this Powerform_CForm_View_Page */
$is_filter_enabled = $this->is_filter_box_enabled();
$date_range        = '';
$date_created      = isset( $this->filters['date_created'] ) ? $this->filters['date_created'] : '';
if ( is_array( $date_created ) && isset( $date_created[0] ) && isset( $date_created[1] ) ) {
	$date_created[0] = date( 'm/d/Y', strtotime( $date_created[0] ) );// phpcs:ignore
	$date_created[1] = date( 'm/d/Y', strtotime( $date_created[1] ) );// phpcs:ignore
	$date_range      = implode( ' - ', $date_created );
}
$search_filter = isset( $this->filters['search'] ) ? $this->filters['search'] : '';
$min_id        = isset( $this->filters['min_id'] ) ? $this->filters['min_id'] : '';
$max_id        = isset( $this->filters['max_id'] ) ? $this->filters['max_id'] : '';
$order_by      = isset( $this->order['order_by'] ) ? $this->order['order_by'] : '';
$order_filter  = isset( $this->order['order'] ) ? $this->order['order'] : '';
?>
<div class="sui-pagination-filter <?php echo( $is_filter_enabled ? 'sui-open' : '' ); ?>">

	<div class="sui-row">

		<div class="sui-col-md-6">

			<div class="sui-form-field">

				<label for="powerform-forms-filter--by-date" class="sui-label"><?php esc_html_e( 'Einsendungsdatum Bereich', Powerform::DOMAIN ); ?></label>

				<div class="sui-date">
					<i class="sui-icon-calendar" aria-hidden="true"></i>
					<input type="text"
						placeholder="<?php esc_html_e( 'Wähle einen Datumsbereich', Powerform::DOMAIN ); ?>"
						id="powerform-forms-filter--by-date"
						name="date_range"
						autocomplete="off"
						value="<?php echo esc_attr( $date_range ); ?>"
						class="sui-form-control powerform-entries-filter-date"/>
				</div>

			</div>

		</div>

		<div class="sui-col-md-3">

			<label for="powerform-forms-filter--from-id" class="sui-label"><?php esc_html_e( 'Von ID', Powerform::DOMAIN ); ?></label>
			<input type="number"
				name="min_id"
				min="0"
				value="<?php echo esc_attr( $min_id ); ?>"
				placeholder="<?php esc_html_e( 'Z.B. 100', Powerform::DOMAIN ); ?>"
				id="powerform-forms-filter--from-id"
				class="sui-form-control"/>

		</div>

		<div class="sui-col-md-3">

			<label for="powerform-forms-filter--to-id" class="sui-label"><?php esc_html_e( 'An ID', Powerform::DOMAIN ); ?></label>
			<input type="number"
				name="max_id"
				min="0"
				value="<?php echo esc_attr( $max_id ); ?>"
				placeholder="<?php esc_html_e( 'Z.B. 100', Powerform::DOMAIN ); ?>"
				id="powerform-forms-filte--to-id"
				class="sui-form-control"/>

		</div>

	</div>

	<div class="sui-row">

		<div class="sui-col-md-6">

			<div class="sui-form-field">

				<label for="powerform-forms-filter--by-keyword" class="sui-label"><?php esc_html_e( 'Schlagwort', Powerform::DOMAIN ); ?></label>

				<div class="sui-control-with-icon">
					<i class="sui-icon-magnifying-glass-search" aria-hidden="true"></i>
					<input type="text"
						name="search"
						value="<?php echo esc_attr( $search_filter ); ?>"
						placeholder="<?php esc_html_e( 'Z.B. Suche', Powerform::DOMAIN ); ?>"
						id="powerform-forms-filter--by-keyword"
						class="sui-form-control"/>
				</div>

			</div>

		</div>

		<div class="sui-col-md-3">

			<label for="powerform-forms-filter--sort-by" class="sui-label"><?php esc_html_e( 'Sortieren nach', Powerform::DOMAIN ); ?></label>
			<select id="powerform-forms-filter--sort-by" name="order_by">
				<!--				<option value="">--><?php //esc_html_e( 'ID', Powerform::DOMAIN ); ?><!--</option>-->
				<option value="entries.date_created" <?php selected( 'entries.date_created', $order_by ); ?> ><?php esc_html_e( 'Einsendungsdatum', Powerform::DOMAIN ); ?></option>
			</select>

		</div>

		<div class="sui-col-md-3">

			<label for="powerform-forms-filter--sort-order" class="sui-label"><?php esc_html_e( 'Sortierreihenfolge', Powerform::DOMAIN ); ?></label>
			<select id="powerform-forms-filter--sort-order" name="order">
				<option value="DESC" <?php selected( 'DESC', $order_filter ); ?>><?php esc_html_e( 'Absteigend', Powerform::DOMAIN ); ?></option>
				<option value="ASC" <?php selected( 'ASC', $order_filter ); ?>><?php esc_html_e( 'Aufsteigend', Powerform::DOMAIN ); ?></option>
			</select>

		</div>

	</div>

	<div class="sui-form-field">

		<label class="sui-label"><?php esc_html_e( 'Anzeigefelder', Powerform::DOMAIN ); ?></label>

		<div class="sui-side-tabs powerform-field-select-tab">

			<div class="sui-tabs-menu">

				<label for="powerform-forms-filter--display-false" class="sui-tab-item <?php echo ( $this->fields_is_filtered ? '' : 'active' ); ?>" data-tab-index="1">
					<input type="radio"
						name="fields_select"
						id="powerform-forms-filter--display-false"
						value="false"/>
					<?php esc_html_e( 'Alle', Powerform::DOMAIN ); ?>
				</label>

				<label for="powerform-forms-filter--display-true" class="sui-tab-item <?php echo ( $this->fields_is_filtered ? 'active' : '' ); ?>" data-tab-index="2">
					<input type="radio"
						name="fields_select"
						id="powerform-forms-filter--display-true"
						value="true"/>
					<?php esc_html_e( 'Angegebene Felder', Powerform::DOMAIN ); ?>
				</label>

			</div>

			<div class="sui-tabs-content">

				<div class="sui-tab-content <?php echo ( $this->fields_is_filtered ? '' : 'active' ); ?>" data-tab-index="1">
				</div>
				<div class="sui-tab-content sui-tab-boxed <?php echo ( $this->fields_is_filtered ? 'active' : '' ); ?>" data-tab-index="2">

					<fieldset class="powerform-entries-fields-filter" <?php echo ( $this->fields_is_filtered ? '' : 'disabled=disabled' ); ?>>
						<?php
						$ignored_field_types = Powerform_Form_Entry_Model::ignored_fields();
						$fields              = apply_filters( 'powerform_custom_form_filter_fields', $this->get_fields() );

						foreach ( $fields as $field ) {

							$label      = $field->__get( 'field_label' );
							$field_type = $field->__get( 'type' );

							if ( in_array( $field_type, $ignored_field_types, true ) ) {
								continue;
							}

							if ( ! $label ) {
								$label = $field->title;
							}

							if ( empty( $label ) ) {
								$label = ucfirst( $field_type );
							}

							$slug = isset( $field->slug ) ? $field->slug : sanitize_title( $label );
							?>

							<label class="sui-checkbox" for="<?php echo esc_attr( $slug ); ?>-enable">
								<input type="checkbox"
									name="field[]"
									value="<?php echo esc_attr( $slug ); ?>"
									id="<?php echo esc_attr( $slug ); ?>-enable"
									<?php $this->checked_field( $slug ); ?> />
								<span aria-hidden="true"></span>
								<span class="sui-description"><?php echo esc_html( $label ); ?></span>
							</label>

						<?php } ?>
					</fieldset>

				</div>

			</div>

		</div>

	</div>

	<div class="sui-filter-footer">

		<button class="sui-button sui-button-ghost powerform-entries-clear-filter"><?php esc_html_e( 'Filter löschen', Powerform::DOMAIN ); ?></button>

		<div class="sui-actions-right">
			<button class="sui-button powerform-entries-apply-filter" type="submit"><?php esc_html_e( 'Anwenden', Powerform::DOMAIN ); ?></button>
		</div>

	</div>

</div>
