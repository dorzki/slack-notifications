<?php
/**
 * Templates -> Settings -> General
 *
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    1.0.0
 */

use dorzki\SlackNotifications\Plugin;

?>
<!-- Settings Form -->
<form action="options.php" method="post">
	<?php settings_fields( Plugin::SLUG ); ?>
	<?php do_settings_sections( Plugin::SLUG ); ?>

	<?php submit_button( __( 'Save Settings', 'dorzki-notifications-to-slack' ) ); ?>
</form>
<!-- /Settings Form -->
