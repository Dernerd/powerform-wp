<section class="psource-dashboard-section">

	<?php $this->template( 'dashboard/widgets/widget-resume' ); ?>

	<div class="sui-row">

		<div class="sui-col-md-6">

			<?php $this->template( 'dashboard/widgets/widget-cform' ); ?>

			<?php $this->template( 'dashboard/widgets/widget-poll' ); ?>

		</div>

		<div class="sui-col-md-6">

			<?php if ( ! POWERFORM_PRO ) {
				$this->template( 'dashboard/widgets/widget-upgrade' );
			} ?>

			<?php $this->template( 'dashboard/widgets/widget-quiz' ); ?>

		</div>

	</div>

	<?php
	$notice_dismissed = get_option( 'powerform_dismiss_feature_114', false );
	$version_upgraded = get_option( 'powerform_version_upgraded', false );

	if ( ! $notice_dismissed && $version_upgraded && powerform_is_show_documentation_link() ) { ?>

		<?php $this->template( 'dashboard/new-feature-notice' ); ?>

	<?php } ?>

</section>
