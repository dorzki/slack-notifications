<!-- Settings Form -->
<form action="options.php" method="post">

	<?php settings_fields( SLACK_NOTIFICATIONS_SLUG ); ?>

	<?php do_settings_sections( SLACK_NOTIFICATIONS_SLUG ); ?>

	<?php submit_button( __( 'Save Settings', 'dorzki-notifications-to-slack' ) ); ?>

</form>
<!-- /Settings Form -->
