<?php use Slack_Notifications\Webhook;

if ( isset( $_POST['save_webhooks'] ) ) {

	Webhook::save_webhooks( $_POST[ 'webhooks' ] );

}

?>

<form method="post">

	<div class="webhooks-wrapper">

		<!-- Webhook Template -->
		<template id="webhook_box">

			<?php require SLACK_NOTIFICATIONS_PATH . 'templates/partials/webhook.php'; ?>

		</template>
		<!-- Webhook Template -->

		<?php $webhooks = Webhook::get_webhooks(); ?>

		<?php if ( is_array( $webhooks ) && ! empty( $webhooks ) ) : ?>

			<?php foreach ( $webhooks as $webhook ) : ?>

				<?php include SLACK_NOTIFICATIONS_PATH . 'templates/partials/webhook.php'; ?>

			<?php endforeach; ?>

		<?php else : ?>

			<?php include SLACK_NOTIFICATIONS_PATH . 'templates/partials/webhook.php'; ?>

		<?php endif; ?>

	</div>

	<input type="submit" name="save_webhooks" id="submit" class="button button-primary"
		   value="<?php esc_html_e( 'Save Webhooks', 'dorzki-notifications-to-slack' ); ?>">
</form>
