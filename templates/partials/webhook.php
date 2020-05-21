<?php

$title = __( 'New Webhook', 'dorzki-notifications-to-slack' );
$url = $title = null;
$new_webhook = ! isset( $webhook );

if ( ! $new_webhook && is_object( $webhook ) ) {

	$id     = $webhook->id;
	$url  	= $webhook->url;
	$title  = $webhook->title;

}

?>
<div class="notification-box <?php echo $new_webhook ? 'new' : null; ?>">
	<div class="notification-header">
		<?php if ( $new_webhook ) : ?>
			<h2><?php _e( 'New Webhook', 'dorzki-notifications-to-slack' ); ?></h2>
		<?php else : ?>
			<h2><?php _e( 'Webhook', 'dorzki-notifications-to-slack' ); ?>: <?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>

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
					<input type="hidden" name="webhooks[id][<?php echo $id; ?>]"
						   value="<?php echo esc_attr( $id ); ?>">
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Webhook Title', 'dorzki-notifications-to-slack' ); ?></th>
				<td><input type="text" class="regular-text" name="webhooks[title][<?php echo $id; ?>]"
						   value="<?php echo esc_attr( $title ); ?>">
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Webhook Url', 'dorzki-notifications-to-slack' ); ?></th>
				<td><input type="text" class="regular-text" name="webhooks[url][<?php echo $id; ?>]"
						   value="<?php echo esc_attr( $url ); ?>">
				</td>
			</tr>
			<tr>
				<td colspan="2" class="remove-button">
					<button type="button" class="slack_test_integration button"><?php _e( 'Run Test', 'dorzki-notifications-to-slack' ); ?></button>

					<button type="button"
							class="remove-notification button"><?php esc_attr_e( 'Remove', 'dorzki-notifications-to-slack' ); ?></button>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>
