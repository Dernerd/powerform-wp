<?php $url = powerform_plugin_url(); ?>

<div class="sui-row-with-sidenav powerform-integrations-wrapper">

	<div class="sui-sidenav">

		<ul class="sui-vertical-tabs sui-sidenav-hide-md">

			<li class="sui-vertical-tab powerform-integrations" data-tab-id="powerform-integrations">
				<a href="#powerform-integrations" role="button"><?php esc_html_e( 'Applications', Powerform::DOMAIN ); ?></a>
			</li>
            <?php if ( powerform_is_show_documentation_link() ) { ?>
                <li class="sui-vertical-tab powerform-api" data-tab-id="powerform-api">
                    <a href="#powerform-api" role="button"><?php esc_html_e( 'API', Powerform::DOMAIN ); ?></a>
                </li>
            <?php } ?>
		</ul>

		<select class="sui-mobile-nav sui-sidenav-hide-lg">
			<option value="powerform-integrations"><?php esc_html_e( 'Applications', Powerform::DOMAIN ); ?></option>
			<?php if ( powerform_is_show_documentation_link() ) { ?>
                <option value="powerform-api"><?php esc_html_e( 'API', Powerform::DOMAIN ); ?></option>
			<?php } ?>
		</select>

	</div>

	<div id="powerform-integrations" class="psource-settings--box" style="display: block;">

		<div class="sui-box">

			<div class="sui-box-header">

				<h2 class="sui-box-title"><?php esc_html_e( 'Applications', Powerform::DOMAIN ); ?></h2>

			</div>

			<div id="powerform-integrations-page" class="sui-box-body">

				<p><?php esc_html_e( 'Powerform integrates with your favorite third party apps. You can connect to the available apps via their API here and activate them to collect data in the Integrations tab of your forms, polls or quizzes.', Powerform::DOMAIN ); ?></p>

				<div id="powerform-integrations-display"></div>

			</div>

		</div>

	</div>
	<?php if ( powerform_is_show_documentation_link() ) { ?>
	    <div id="powerform-api" class="psource-settings--box" style="display: none;">

            <div class="sui-box">

                <div class="sui-box-header">

                    <h2 class="sui-box-title"><?php esc_html_e( 'API', Powerform::DOMAIN ); ?></h2>

                </div>

                <div class="sui-box">

                    <div class="sui-box-body sui-block-content-center">

                        <?php if ( powerform_is_show_branding() ) : ?>
                            <img src="<?php echo $url . 'assets/img/powerform-disabled.png'; // phpcs:ignore ?>"
                                srcset="<?php echo $url . 'assets/img/powerform-disabled.png'; // phpcs:ignore ?> 1x,
                                <?php echo $url . 'assets/img/powerform-disabled@2x.png'; // phpcs:ignore ?> 2x"
                                alt="<?php esc_html_e( 'Powerform APIs', Powerform::DOMAIN ); ?>"
                                class="sui-image sui-image-center fui-image"/>
                        <?php endif; ?>

                        <div class="fui-limit-block-600 fui-limit-block-center">

                        <p>
                            <?php
                            esc_html_e( 'Build your own integrations and custom Powerform apps using our full featured API! Visit the Powerform API Docs to get started.', Powerform::DOMAIN );
                            ?>
                        </p>
                        <p>
                            <a href="https://n3rds.work/docs/wpmu-dev-plugins/powerform-api-docs/" target="_blank" class="sui-button sui-button-blue">Get Started</a>
                        </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>
	<?php } ?>

</div>
