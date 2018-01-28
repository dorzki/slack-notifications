<div class="wrap <?php echo SN_SLUG; ?>-wrapper">

	<!-- Page Name -->
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<!-- /Page Name -->

	<!-- Notices -->
	<?php settings_errors( SN_SLUG . '_notices' ); ?>
	<!-- /Notices -->

	<!-- Settings Form -->
	<form action="options.php" method="post">

		<?php settings_fields( SN_SLUG ); ?>

		<?php do_settings_sections( SN_SLUG ); ?>

		<?php submit_button( __( 'Save Settings', 'dorzki-notifications-to-slack' ) ); ?>

	</form>
	<!-- /Settings Form -->

</div>