<?php
$title = __( 'New Notification', 'dorzki-notifications-to-slack' );
$type  = $action = $channel = null;

if ( isset( $notification ) && is_object( $notification ) ) {

	$title   = $notification->title;
	$type    = $notification->type;
	$action  = $notification->action;
	$channel = $notification->channel;

}
?>
<div class="notification-box <?php echo ( ! isset( $notification ) ) ? 'new' : null; ?>">
	<div class="notification-header">
		<h2><?php echo esc_html( $title ); ?></h2>
		<button class="toggle-content">
				<span
					class="screen-reader-text"><?php esc_html_e( 'Toggle Content', 'dorzki-notifications-to-slack' ); ?></span>
			<span class="toggle-indicator" aria-hidden="true"></span>
		</button>
	</div>
	<div class="notification-settings">
		<table class="notification-form">
			<tbody>
			<tr>
				<td colspan="2" class="hide">
					<input type="hidden" name="notification[title][]"
						   value="<?php echo esc_attr( $title ); ?>">
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Notification Type', 'dorzki-notifications-to-slack' ); ?></th>
				<td>
					<select name="notification[type][]" class="notification-type">

						<?php foreach ( $GLOBALS['slack_notifs'] as $notif_id => $notif_type ) : ?>
							<option
									value="<?php echo esc_attr( $notif_id ); ?>" <?php selected( $type, $notif_id ); ?>><?php echo esc_html( $notif_type['label'] ); ?></option>
						<?php endforeach; ?>

					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Notification Options', 'dorzki-notifications-to-slack' ); ?></th>
				<td>
					<?php foreach ( $GLOBALS['slack_notifs'] as $notif_id => $notif_type ) : ?>

						<select
								name="notification[action][<?php echo esc_attr( $notif_id ); ?>][]"
								class="notification_options <?php echo ( $notif_id === $type ) ? 'current' : null; ?>">

							<?php foreach ( $notif_type['options'] as $option_id => $option_data ) : ?>
								<option
										value="<?php echo esc_attr( $option_id ); ?>" <?php selected( $action, $option_id ); ?>><?php echo esc_html( $option_data['label'] ); ?></option>
							<?php endforeach; ?>

						</select>

					<?php endforeach; ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Channel', 'dorzki-notifications-to-slack' ); ?></th>
				<td><input type="text" class="regular-text" name="notification[channel][]"
						   placeholder="<?php echo get_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'default_channel' ); ?>"
						   value="<?php echo esc_attr( $channel ); ?>">
				</td>
			</tr>
			<tr>
				<td colspan="2" class="remove-button">
					<button type="button"
							class="remove-notification button"><?php esc_attr_e( 'Remove', 'dorzki-notifications-to-slack' ); ?></button>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>
