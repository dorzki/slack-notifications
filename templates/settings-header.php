<div class="wrap <?php echo SN_SLUG; ?>-wrapper">

	<!-- Page Name -->
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<!-- /Page Name -->

	<!-- Notices -->
	<?php settings_errors( SN_SLUG . '_notices' ); ?>
	<!-- /Notices -->