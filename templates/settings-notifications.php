<?php use Slack_Notifications\Notifications\Notification_Type;

if ( isset( $_POST['save_notifications'] ) ) {

	$notifications = [];

	foreach ( $_POST['notification']['type'] as $notification_id => $notification_type ) {

		$notifications[] = [
			'type'    => $notification_type,
			'action'  => $_POST['notification']['action'][ $notification_type ][ $notification_id ],
			'channel' => $_POST['notification']['channel'][ $notification_id ],
			'title'   => $_POST['notification']['title'][ $notification_id ],
		];

	}

	update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'notifications', json_encode( $notifications ) );

} ?>

<form method="post">

	<div class="notifications-wrapper">

		<!-- Notification Template -->
		<template id="notification_box">

			<?php require SLACK_NOTIFICATIONS_PATH . 'templates/partials/notification.php'; ?>

		</template>
		<!-- Notification Template -->

		<?php $notifications = Notification_Type::get_notifications(); ?>

		<?php if ( is_array( $notifications ) && ! empty( $notifications ) ) : ?>

			<?php foreach ( $notifications as $notification ) : ?>

				<?php include SLACK_NOTIFICATIONS_PATH . 'templates/partials/notification.php'; ?>

			<?php endforeach; ?>

		<?php endif; ?>

	</div>

	<input type="submit" name="save_notifications" id="submit" class="button button-primary"
		   value="<?php esc_html_e( 'Save Notifications', 'dorzki-notifications-to-slack' ); ?>">
</form>
