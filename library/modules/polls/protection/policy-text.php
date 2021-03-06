<div class="wp-suggested-text">
	<h2><?php esc_html_e( 'Which polls are collecting personal data?', Powerform::DOMAIN ); ?></h2>
	<p class="privacy-policy-tutorial">
		<?php esc_html_e( 'If you use Powerform to create and embed any polls on your website, you may need to mention it here to properly distinguish it from other polls.',
		                  Powerform::DOMAIN ); ?>
	</p>

	<h2><?php esc_html_e( 'What personal data do we collect and why?', Powerform::DOMAIN ); ?></h2>
	<p class="privacy-policy-tutorial">
		<?php _e( 'By default Powerform captures the <strong>IP Address</strong> for each Poll submission.', Powerform::DOMAIN );// wpcs: xss ok. ?>
	</p>
	<p class="privacy-policy-tutorial">
		<?php esc_html_e( 'In this section you should note what personal data you collected including which polls are available. You should also explan why this data is needed. Include the legal basis for your data collection and note the active consent the user has given.',
		                  Powerform::DOMAIN ); ?>
	</p>
	<p>
		<strong class="privacy-policy-tutorial"><?php esc_html_e( 'Suggested text: ', Powerform::DOMAIN ); ?></strong>
		<?php _e( 'When visitors or users submit a poll, we capture the <strong>IP Address</strong> for spam protection and to set voter limitations.', Powerform::DOMAIN );// wpcs: xss ok. ?>
	</p>

	<h2><?php esc_html_e( 'How long we retain your data', Powerform::DOMAIN ); ?></h2>
	<p class="privacy-policy-tutorial">
		<?php _e( 'By default Powerform retains all votes and its <strong>IP Address</strong> <strong>forever</strong>. You can change this setting in <strong>Powerform</strong> &raquo; <strong>Settings</strong> &raquo;
		<strong>Privacy Settings</strong>',
		          Powerform::DOMAIN );// wpcs: xss ok. ?>
	</p>
	<p>
		<strong class="privacy-policy-tutorial"><?php esc_html_e( 'Suggested text: ', Powerform::DOMAIN ); ?></strong>
		<?php _e( 'When visitors or users votes on a poll we retain the <strong>IP Address</strong> data for 30 days and anonymize it.', Powerform::DOMAIN ); // wpcs: xss ok. ?>
	</p>
	<h2><?php esc_html_e( 'Where we send your data', Powerform::DOMAIN ); ?></h2>
	<p>
		<strong class="privacy-policy-tutorial"><?php esc_html_e( 'Suggested text: ', Powerform::DOMAIN ); ?></strong>
		<?php esc_html_e( 'All collected data might be shown publicly and we send it to our workers or contractors to perform necessary actions based on votes.', Powerform::DOMAIN ); ?>
	</p>
	<h2><?php esc_html_e( 'Third Parties', Powerform::DOMAIN ); ?></h2>
	<p class="privacy-policy-tutorial">
		<?php esc_html_e( 'If your polls utilize either built-in or external third party services, in this section you should mention any third parties and its privacy policy.',
		                  Powerform::DOMAIN ); ?>
	</p>
	<p class="privacy-policy-tutorial">
		<?php esc_html_e( 'By default Powerform Polls can be configured to connect with these third parties:' ); ?>
	</p>
	<ul class="privacy-policy-tutorial">
		<li><?php esc_html_e( 'Akismet. Enabled when you installed and configured Akismet on your site.' ); ?></li>
		<li><?php esc_html_e( 'Zapier. Enabled when you activated and setup Zapier on Integrations settings.' ); ?></li>
		<li><?php esc_html_e( 'Google Drive. Enabled when you activated and setup Google Drive on Integrations settings.' ); ?></li>
		<li><?php esc_html_e( 'Trello. Enabled when you activated and setup Trello on Integrations settings.' ); ?></li>
		<li><?php esc_html_e( 'Slack. Enabled when you activated and setup Slack on Integrations settings.' ); ?></li>
	</ul>
	<p>
		<strong class="privacy-policy-tutorial"><?php esc_html_e( 'Suggested text: ', Powerform::DOMAIN ); ?></strong>
	<p><?php esc_html_e( 'We use Akismet Spam for spam protection. Their privacy policy can be found here : https://automattic.com/privacy/.', Powerform::DOMAIN ); ?></p>
	<p><?php esc_html_e( 'We use Zapier to manage our integration data. Their privacy policy can be found here : https://zapier.com/privacy/.', Powerform::DOMAIN ); ?></p>

	<p>
		<?php esc_html_e( 'We use Google Drive and Google Sheets to manage our integration data. Their privacy policy can be found here : https://policies.google.com/privacy?hl=en.',
		                  Powerform::DOMAIN ); ?>
	</p>
	<p><?php esc_html_e( 'We use Trello to manage our integration data. Their privacy policy can be found here : https://trello.com/privacy.', Powerform::DOMAIN ); ?></p>
	<p><?php esc_html_e( 'We use Slack to manage our integration data. Their privacy policy can be found here : https://slack.com/privacy-policy.', Powerform::DOMAIN ); ?></p>
	</p>
</div>
