<?php
/**
 * Templates -> Settings -> Header
 *
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    1.0.0
 */

use dorzki\SlackNotifications\Plugin;

?>
<div class="wrap <?php echo esc_attr( Plugin::SLUG ); ?>-wrapper">

	<!-- Page Name -->
	<h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<?php if ( ! empty( $this->page_action ) ) : ?>
		<a href="<?php echo esc_attr( $this->page_action['link'] ); ?>" class="page-title-action">
			<?php echo esc_html( $this->page_action['label'] ); ?>
		</a>
	<?php endif; ?>
	<!-- /Page Name -->

	<!-- Notices -->
	<?php settings_errors( Plugin::SLUG . '_notices' ); ?>
	<!-- /Notices -->
