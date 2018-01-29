<pre><?php var_export( $_POST ); ?></pre>

<form method="post">

	<div class="notifications-wrapper">

		<!-- Notification Template -->
		<template id="notification_box">
			<div class="notification-box new">
				<div class="notification-header">
					<h2><?php esc_html_e( 'New Notification', 'dorzki-notifications-to-slack' ); ?></h2>
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
							<th scope="row"><?php esc_html_e( 'Notification Type', 'dorzki-notifications-to-slack' ); ?></th>
							<td>
								<select name="notification_type[]" class="notification-type">

									<?php foreach ( $GLOBALS[ 'slack_notifs' ] as $notif_type ) : ?>
										<option
											value="<?php echo esc_attr( $notif_type[ 'id' ] ); ?>"><?php echo esc_html( $notif_type[ 'label' ] ); ?></option>
									<?php endforeach; ?>

								</select>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Notification Options', 'dorzki-notifications-to-slack' ); ?></th>
							<td>
								<?php foreach ( $GLOBALS[ 'slack_notifs' ] as $notif_type ) : ?>

									<select
										name="notification_options[<?php echo esc_attr( $notif_type[ 'id' ] ); ?>][]"
										class="notification_options">

										<?php foreach ( $notif_type[ 'options' ] as $option_id => $option_data ) : ?>
											<option
												value="<?php echo esc_attr( $option_id ); ?>"><?php echo esc_html( $option_data[ 'label' ] ); ?></option>
										<?php endforeach; ?>

									</select>

								<?php endforeach; ?>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Channel', 'dorzki-notifications-to-slack' ); ?></th>
							<td><input type="text" class="regular-text" name="notification_channel[]"
									   placeholder="<?php echo get_option( SN_FIELD_PREFIX . 'default_channel' ); ?>">
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</template>
		<!-- Notification Template -->

	</div>

	<input type="submit" value="Save!">
</form>