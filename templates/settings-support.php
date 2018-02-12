<!-- Technical Information -->
<section class="page-section tech-info">
	<header class="section-header">
		<h2><?php esc_html_e( 'System Technical Data', 'dorzki-notifications-to-slack' ); ?></h2>
	</header>
	<div class="section-contents">
		<textarea name="slack_tech_data" id="slack_tech_data" cols="30" rows="10"
				  readonly><?php echo \SlackNotifications\Settings\Support::build_report(); ?></textarea>
		<button type="button"
				class="button button-primary copy-report"><?php esc_html_e( 'Copy Report', 'dorzki-notifications-to-slack' ); ?></button>
	</div>
</section>
<!-- Technical Information -->