<?php
$core_update = get_option( 'slack_notif_core_update' );
$theme_update = get_option( 'slack_notif_theme_update' );
$plugin_update = get_option( 'slack_notif_plugin_update' );
$new_post = get_option( 'slack_notif_new_post' );
$new_page = get_option( 'slack_notif_new_page' );
$new_comment = get_option( 'slack_notif_new_comment' );
$new_user = get_option( 'slack_notif_new_user' );
$admin_logged = get_option( 'slack_notif_admin_logged' );
?>
<div class="wrap">
  <h2><?php _e( 'Slack Notifications', 'dorzki-slack' ); ?>
    <small><?php _e( 'by', 'dorzki-slack' ); ?> <a href="https://www.dorzki.co.il" target="_blank"><?php _e( 'dorzki', 'dorzki-slack' ); ?></a></small>
  </h2>
  <form action="options.php" method="post">
    <?php settings_fields( 'dorzki-slack' ); ?>
    <?php do_settings_fields( 'dorzki-slack' ); ?>

    <h3 class="title"><?php _e( 'Integration Setup', 'dorzki-slack' ); ?></h3>
    <p><?php _e( 'Setup the integration between WordPress and Slack API.', 'dorzki-slack' ); ?></p>
    <table class="form-table">
      <tbody>

        <!-- Webhook URL -->
        <tr valign="top">
          <th scope="row"><label for="slack_webhook_endpoint"><?php _e( 'Webhooks Endpoint', 'dorzki-slack' ); ?></label></th>
          <td>
            <input type="url" name="slack_webhook_endpoint" id="slack_webhook_endpoint" class="regular-text" value="<?php echo get_option( 'slack_webhook_endpoint' ); ?>">
            <p class="description" id="slack_webhook_endpoint-description"><?php printf( __( 'Add <a href=\'%s\' target=\'_blank\'>Slack Incoming Webhooks</a> to your Slack Account and paste the Webhook URL here.', 'dorzki-slack' ), 'https://my.slack.com/services/new/incoming-webhook/' ); ?></p>
          </td>
        </tr>
        <!-- /Webhook URL -->

        <!-- Channel Name -->
        <tr valign="top">
          <th scope="row"><label for="slack_channel_name"><?php _e( 'Channel Name', 'dorzki-slack' ); ?></label></th>
          <td>
            <input type="text" name="slack_channel_name" id="slack_channel_name" class="regular-text" value="<?php echo get_option( 'slack_channel_name' ); ?>">
            <p class="description" id="slack_channel_name-description"><?php _e( 'Write here the desired channel name to receive notifications, don\'t forget to include the hash symbol before the name.', 'dorzki-slack' ); ?></p>
          </td>
        </tr>
        <!-- /Channel Name -->

        <!-- Slack Bot Name -->
        <tr valign="top">
          <th scope="row"><label for="slack_bot_username"><?php _e( 'Slack Bot Name', 'dorzki-slack' ); ?></label></th>
          <td>
            <input type="text" name="slack_bot_username" id="slack_bot_username" class="regular-text" value="<?php echo get_option( 'slack_bot_username' ); ?>">
            <p class="description" id="slack_bot_username-description"><?php _e( 'The Slack Bot name to be displayed in notifications.', 'dorzki-slack' ); ?></p>
          </td>
        </tr>
        <!-- /Slack Bot Name -->

        <!-- Bot Image -->
        <tr valign="top">
          <th scope="row"><label for="slack_bot_image"><?php _e( 'Slack Bot Logo', 'dorzki-slack' ); ?></label></th>
          <td>
            <input type="text" id="slack_bot_image" name="slack_bot_image" class="regular-text" value="<?php echo esc_url( get_option( 'slack_bot_image' ) ); ?>" />
            <input id="slack_bot_image_button" type="button" class="button" value="<?php _e( 'Upload', 'dorzki-slack' ); ?>" />
            <p class="description" id="slack_bot_image-description"><?php _e( 'Slack Bot image to be displayed in Slack.', 'dorzki-slack' ); ?></p>
            <div id="slack_bot_image_preview">
				<?php if ( get_option( 'slack_bot_image' ) != '' ) : ?>
                <img src="<?php echo get_option( 'slack_bot_image' ); ?>">
				<?php endif; ?>
            </div>
          </td>
        </tr>
        <!-- /Bot Image -->

      </tbody>
    </table>
    <h3 class="title"><?php _e( 'Desired Notifications', 'dorzki-slack' ); ?></h3>
    <p><?php _e( 'Please select the desired notification to be sent on event fire.', 'dorzki-slack' ); ?></p>
    <table class="form-table">
      <tbody>

        <tr>
          <th scope="row"><?php _e( 'Version Updates', 'dorzki-slack' ); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text">
                <span><?php _e( 'Version Updates', 'dorzki-slack' ); ?></span>
              </legend>

              <!-- WordPress Core Update? -->
              <label for="slack_notif_core_update">
                <input type="checkbox" name="slack_notif_core_update" id="slack_notif_core_update" value="1" <?php checked( $core_update, 1, true ); ?>> <?php _e( 'WordPress Core Update Available?', 'dorzki-slack' ); ?>
              </label>
              <br>
              <!-- /WordPress Core Update? -->

              <!-- WordPress Theme Update? -->
              <label for="slack_notif_theme_update">
                <input type="checkbox" name="slack_notif_theme_update" id="slack_notif_theme_update" value="1" <?php checked( $theme_update, 1, true ); ?>> <?php _e( 'Theme Update Available?', 'dorzki-slack' ); ?>
              </label>
              <br>
              <!-- /WordPress Theme Update? -->

              <!-- WordPress Plugin Update? -->
              <label for="slack_notif_plugin_update">
                <input type="checkbox" name="slack_notif_plugin_update" id="slack_notif_plugin_update" value="1" <?php checked( $plugin_update, 1, true ); ?>> <?php _e( 'Plugin Update Available?', 'dorzki-slack' ); ?>
              </label>
              <br>
              <!-- /WordPress Plugin Update? -->

            </fieldset>
          </td>
        </tr>
        <tr>
          <th scope="row"><?php _e( 'New Entries', 'dorzki-slack' ); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text">
                <span><?php _e( 'New Entries', 'dorzki-slack' ); ?></span>
              </legend>

              <!-- New Post -->
              <label for="slack_notif_new_post">
                <input type="checkbox" name="slack_notif_new_post" id="slack_notif_new_post" value="1" <?php checked( $new_post, 1, true ); ?>> <?php _e( 'Post Published', 'dorzki-slack' ); ?>
              </label>
              <br>
              <!-- /New Post -->

              <!-- New Page -->
              <label for="slack_notif_new_page">
                <input type="checkbox" name="slack_notif_new_page" id="slack_notif_new_page" value="1" <?php checked( $new_page, 1, true ); ?>> <?php _e( 'Page Published', 'dorzki-slack' ); ?>
              </label>
              <br>
              <!-- /New Page -->

              <!-- New Comment -->
              <label for="slack_notif_new_comment">
                <input type="checkbox" name="slack_notif_new_comment" id="slack_notif_new_comment" value="1" <?php checked( $new_comment, 1, true ); ?>> <?php _e( 'New Comment', 'dorzki-slack' ); ?>
              </label>
              <br>
              <!-- /New Comment -->

            </fieldset>
          </td>
        </tr>
        <tr>
        <th scope="row"><?php _e( 'Users', 'dorzki-slack' ); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text">
                <span><?php _e( 'Users', 'dorzki-slack' ); ?></span>
              </legend>

              <!-- New User -->
              <label for="slack_notif_new_user">
                <input type="checkbox" name="slack_notif_new_user" id="slack_notif_new_user" value="1" <?php checked( $new_user, 1, true ); ?>> <?php _e( 'New User', 'dorzki-slack' ); ?>
              </label>
              <br>
              <!-- /New User -->

              <!-- Admin Logged-in -->
              <label for="slack_notif_admin_logged">
                <input type="checkbox" name="slack_notif_admin_logged" id="slack_notif_admin_logged" value="1" <?php checked( $admin_logged, 1, true ); ?>> <?php _e( 'Admin Logged-in', 'dorzki-slack' ); ?>
              </label>
              <br>
              <!-- /Admin Logged-in -->

            </fieldset>
          </td>
        </tr>

      </tbody>
    </table>

    <?php submit_button(); ?>
  </form>
</div>
