<?php namespace Slack_Notifications; ?>

<!-- Technical Information -->
<section class="page-section tech-info">
	<header class="section-header">
		<h2><?php esc_html_e( 'System Technical Data', 'dorzki-notifications-to-slack' ); ?></h2>
	</header>
	<div class="section-contents">
		<textarea name="slack_tech_data" id="slack_tech_data" cols="30" rows="10"
				  readonly><?php echo Settings\Support::build_report(); ?></textarea>
		<button type="button"
				class="button button-primary copy-report"><?php esc_html_e( 'Copy Report', 'dorzki-notifications-to-slack' ); ?></button>
	</div>
</section>
<!-- Technical Information -->

<!-- Logger -->
<section class="page-section logger">
	<header class="section-header">
		<h2><?php esc_html_e( 'Error Log', 'dorzki-notifications-to-slack' ); ?></h2>
	</header>
	<div class="section-contents">
		<textarea name="slack_error_logs" id="slack_error_logs" cols="30" rows="10"
				  readonly><?php echo Logger::get_log_file_contents(); ?></textarea>
		<a href="<?php echo esc_attr( Logger::get_file_url() ); ?>" target="_blank"
		   class="button button-primary"
		   id="slack_download_logs"
		   download><?php esc_html_e( 'Download Logs', 'dorzki-notifications-to-slack' ); ?></a>
		<button type="button"
				class="button button-secondary"
				id="slack_clear_logs"><?php esc_html_e( 'Clear Logs', 'dorzki-notifications-to-slack' ); ?></button>
	</div>
</section>
<!-- Logger -->