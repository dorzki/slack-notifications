<div class="wrap <?php echo SLACK_NOTIFICATIONS_SLUG; ?>-wrapper">

	<!-- Page Name -->
	<h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<?php if ( ! empty( $this->header_link ) ) : ?>
		<a href="<?php echo esc_attr( $this->header_link['link'] ); ?>"
		   class="page-title-action"><?php echo esc_html( $this->header_link['label'] ); ?></a>
	<?php endif; ?>
	<!-- /Page Name -->

	<!-- Notices -->
	<?php settings_errors( SLACK_NOTIFICATIONS_SLUG . '_notices' ); ?>
	<!-- /Notices -->
