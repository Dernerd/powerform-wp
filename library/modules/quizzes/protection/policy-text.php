<div class="wp-suggested-text">
	<h2><?php esc_html_e( 'Welche Tests sammeln personenbezogene Daten?', Powerform::DOMAIN ); ?></h2>
	<p class="privacy-policy-tutorial">
		<?php esc_html_e(
			'Wenn Du Powerform zum Erstellen und Einbetten von Quizfragen auf Deiner Webseite verwendest, musst Du diese möglicherweise hier erwähnen, um sie ordnungsgemäß von anderen Quizfragen zu unterscheiden.',
			Powerform::DOMAIN
		); ?>
	</p>

	<h2><?php esc_html_e( 'Welche personenbezogenen Daten erheben wir und warum?', Powerform::DOMAIN ); ?></h2>
	<p class="privacy-policy-tutorial">
		<?php _e( 'Standardmäßig erfasst Powerform für jede Quizübermittlung <strong>KEINE personenbezogenen Daten</strong>.', Powerform::DOMAIN );// wpcs: xss ok. ?>
	</p>
	<p class="privacy-policy-tutorial">
		<?php esc_html_e(
			'In diesem Abschnitt solltest Du notieren, welche persönlichen Daten Du gesammelt hast, einschließlich der verfügbaren Tests. Du solltest auch erklären, warum diese Daten benötigt werden. Gib die Rechtsgrundlage für Deine Datenerfassung an und notiere die aktive Zustimmung des Benutzers.',
			Powerform::DOMAIN
		); ?>
	</p>
	<p>
		<strong class="privacy-policy-tutorial"><?php esc_html_e( 'Vorgeschlagener Text: ', Powerform::DOMAIN ); ?></strong>
		<?php _e( 'Wenn Besucher oder Benutzer die Antwort eines Quiz einreichen, erfassen wir <strong>KEINE personenbezogenen Daten</strong>.', Powerform::DOMAIN );// wpcs: xss
		// ok. ?>
	</p>

	<h2><?php esc_html_e( 'Wie lange speichern wir Deine Daten?', Powerform::DOMAIN ); ?></h2>
	<p class="privacy-policy-tutorial">
		<?php _e(
			'Standardmäßig behält Powerform alle Quizantworten <strong>für immer</strong> bei. Du kannst diese Einstellung in <strong>Powerform</strong> &raquo; <strong>Einstellungen</strong> &raquo ändern;
		<strong>Data</strong>',
			Powerform::DOMAIN
		);// wpcs: xss ok. ?>
	</p>
	<p>
		<strong class="privacy-policy-tutorial"><?php esc_html_e( 'Vorgeschlagener Text: ', Powerform::DOMAIN ); ?></strong>
		<?php _e( 'Wenn Besucher oder Benutzer ein Quiz beantworten, behalten wir die <strong>Antworten</strong> Daten 30 Tage lang und entfernen sie dann aus unserem System.', Powerform::DOMAIN ); // wpcs: xss ok. ?>
	</p>
	<h2><?php esc_html_e( 'Wohin wir Deine Daten senden', Powerform::DOMAIN ); ?></h2>
	<p>
		<strong class="privacy-policy-tutorial"><?php esc_html_e( 'Vorgeschlagener Text: ', Powerform::DOMAIN ); ?></strong>
		<?php esc_html_e( 'Alle gesammelten Daten können öffentlich angezeigt werden und wir senden sie an unsere Mitarbeiter oder Auftragnehmer, um die erforderlichen Maßnahmen auf der Grundlage der Antworten durchzuführen.', Powerform::DOMAIN ); ?>
	</p>
	<h2><?php esc_html_e( 'Dritte', Powerform::DOMAIN ); ?></h2>
	<p class="privacy-policy-tutorial">
		<?php esc_html_e(
			'Wenn Deine Tests integrierte oder externe Dienste von Drittanbietern verwenden, solltest Du in diesem Abschnitt alle Drittanbieter und deren Datenschutzrichtlinien erwähnen.',
			Powerform::DOMAIN
		); ?>
	</p>
	<p class="privacy-policy-tutorial">
		<?php esc_html_e( 'Standardmäßig können Powerform-Tests für die Verbindung mit diesen Drittanbietern konfiguriert werden:' ); ?>
	</p>
	<ul class="privacy-policy-tutorial">
		<li><?php esc_html_e( 'Zapier. Aktiviert, wenn Du die Einstellungen für Zapier in Integrationen aktiviert und eingerichtet hast.' ); ?></li>
		<li><?php esc_html_e( 'Google Drive. Aktiviert, wenn Du die Einstellungen für Google Drive in Integrationen aktiviert und eingerichtet hast.' ); ?></li>
		<li><?php esc_html_e( 'Trello. Aktiviert, wenn Du Trello in den Integrationseinstellungen aktiviert und eingerichtet hast.' ); ?></li>
		<li><?php esc_html_e( 'Slack. Aktiviert, wenn Du die Einstellungen für Slack in Integrationen aktiviert und eingerichtet hast.' ); ?></li>
	</ul>
	<p>
		<strong class="privacy-policy-tutorial"><?php esc_html_e( 'Vorgeschlagener Text: ', Powerform::DOMAIN ); ?></strong>
	<p><?php esc_html_e( 'Wir verwenden Zapier, um unsere Integrationsdaten zu verwalten. Ihre Datenschutzbestimmungen findest Du hier: https://zapier.com/privacy/.', Powerform::DOMAIN ); ?></p>

	<p>
		<?php esc_html_e(
			'Wir verwenden Google Drive und Google Sheets, um unsere Integrationsdaten zu verwalten. Ihre Datenschutzbestimmungen findest Du hier: https://policies.google.com/privacy?hl=en.',
			Powerform::DOMAIN
		); ?>
	</p>
	<p><?php esc_html_e( 'Wir verwenden Trello, um unsere Integrationsdaten zu verwalten. Ihre Datenschutzbestimmungen findest Du hier: https://trello.com/privacy.', Powerform::DOMAIN ); ?></p>
	<p><?php esc_html_e( 'Wir verwenden Slack, um unsere Integrationsdaten zu verwalten. Ihre Datenschutzbestimmungen findest Du hier: https://slack.com/privacy-policy.', Powerform::DOMAIN ); ?></p>
	</p>
</div>
