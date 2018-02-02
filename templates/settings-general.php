<!-- Settings Form -->
<form action="options.php" method="post">

	<?php settings_fields( SN_SLUG ); ?>

	<?php do_settings_sections( SN_SLUG ); ?>

	<?php submit_button( __( 'Save Settings', 'dorzki-notifications-to-slack' ) ); ?>

</form>
<!-- /Settings Form -->