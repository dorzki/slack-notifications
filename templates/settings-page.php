<?php
/**
 * Settings page.
 *
 * @package   Slack Notifications
 * @since     1.0.0
 * @version   1.0.5
 * @author    Dor Zuberi <me@dorzki.co.il>
 * @link      https://www.dorzki.co.il
 */

global $postTypes;

$core_update = get_option( 'slack_notif_core_update' );
$theme_update = get_option( 'slack_notif_theme_update' );
$plugin_update = get_option( 'slack_notif_plugin_update' );
$new_post = get_option( 'slack_notif_new_post' );
$new_page = get_option( 'slack_notif_new_page' );
$new_comment = get_option( 'slack_notif_new_comment' );
$new_user = get_option( 'slack_notif_new_user' );
$admin_logged = get_option( 'slack_notif_admin_logged' );
$webhook_url = get_option( 'slack_webhook_endpoint' );
$channel_name = get_option( 'slack_channel_name' );

$isConfigured = ( ( ! empty( $webhook_url ) && ! empty( $channel_name ) ) );
?>
<div class="wrap">
  <h2><?php esc_html_e( 'Slack Notifications', 'dorzki-notifications-to-slack' ); ?>
    <small><?php esc_html_e( 'by', 'dorzki-notifications-to-slack' ); ?> <a href="https://www.dorzki.co.il" target="_blank"><?php esc_html_e( 'dorzki', 'dorzki-notifications-to-slack' ); ?></a></small>
  </h2>
  <form action="options.php" method="post">
    <?php settings_fields( 'dorzki-slack' ); ?>

    <h3 class="title"><?php esc_html_e( 'Integration Setup', 'dorzki-notifications-to-slack' ); ?></h3>
    <p><?php esc_html_e( 'Setup the integration between WordPress and Slack API.', 'dorzki-notifications-to-slack' ); ?></p>
    <table class="form-table">
      <tbody>

        <!-- Webhook URL -->
        <tr valign="top">
          <th scope="row"><label for="slack_webhook_endpoint"><?php esc_html_e( 'Webhooks Endpoint', 'dorzki-notifications-to-slack' ); ?></label></th>
          <td>
            <input type="url" name="slack_webhook_endpoint" id="slack_webhook_endpoint" class="regular-text" value="<?php echo esc_html( $webhook_url ); ?>">
            <p class="description" id="slack_webhook_endpoint-description"><?php printf( __( 'Add <a href=\'%s\' target=\'_blank\'>Slack Incoming Webhooks</a> to your Slack Account and paste the Webhook URL here.', 'dorzki-notifications-to-slack' ) , 'https://my.slack.com/services/new/incoming-webhook/' ); ?></p>
          </td>
        </tr>
        <!-- /Webhook URL -->

        <!-- Channel Name -->
        <tr valign="top">
          <th scope="row"><label for="slack_channel_name"><?php esc_html_e( 'Channel Name', 'dorzki-notifications-to-slack' ); ?></label></th>
          <td>
            <input type="text" name="slack_channel_name" id="slack_channel_name" class="regular-text" value="<?php echo esc_html( $channel_name ); ?>">
            <p class="description" id="slack_channel_name-description"><?php esc_html_e( 'Write here the desired channel name to receive notifications, don\'t forget to include the hash symbol before the name.', 'dorzki-notifications-to-slack' ); ?></p>
          </td>
        </tr>
        <!-- /Channel Name -->

        <!-- Slack Bot Name -->
        <tr valign="top">
          <th scope="row"><label for="slack_bot_username"><?php esc_html_e( 'Slack Bot Name', 'dorzki-notifications-to-slack' ); ?></label></th>
          <td>
            <input type="text" name="slack_bot_username" id="slack_bot_username" class="regular-text" value="<?php echo esc_html( get_option( 'slack_bot_username' ) ); ?>">
            <p class="description" id="slack_bot_username-description"><?php esc_html_e( 'The Slack Bot name to be displayed in notifications.', 'dorzki-notifications-to-slack' ); ?></p>
          </td>
        </tr>
        <!-- /Slack Bot Name -->

        <!-- Bot Image -->
        <tr valign="top">
          <th scope="row"><label for="slack_bot_image"><?php esc_html_e( 'Slack Bot Logo', 'dorzki-notifications-to-slack' ); ?></label></th>
          <td>
            <input type="text" id="slack_bot_image" name="slack_bot_image" class="regular-text" value="<?php echo esc_url( get_option( 'slack_bot_image' ) ); ?>" />
            <input id="slack_bot_image_button" type="button" class="button" value="<?php esc_html_e( 'Upload', 'dorzki-notifications-to-slack' ); ?>" />
            <p class="description" id="slack_bot_image-description"><?php esc_html_e( 'Slack Bot image to be displayed in Slack.', 'dorzki-notifications-to-slack' ); ?></p>
            <div id="slack_bot_image_preview">
              <?php if ( '' !== get_option( 'slack_bot_image' )  ) : ?>
                <img src="<?php echo esc_url( get_option( 'slack_bot_image' ) ); ?>">
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <!-- /Bot Image -->

      </tbody>
    </table>
    <h3 class="title"><?php esc_html_e( 'Desired Notifications', 'dorzki-notifications-to-slack' ); ?></h3>
    <p><?php esc_html_e( 'Please select the desired notification to be sent on event fire.', 'dorzki-notifications-to-slack' ); ?></p>
    <table class="form-table">
      <tbody>

        <tr>
          <th scope="row"><?php esc_html_e( 'Version Updates', 'dorzki-notifications-to-slack' ); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text">
                <span><?php esc_html_e( 'Version Updates', 'dorzki-notifications-to-slack' ); ?></span>
              </legend>

              <!-- WordPress Core Update? -->
              <label for="slack_notif_core_update">
                <input type="checkbox" name="slack_notif_core_update" id="slack_notif_core_update" value="1" <?php checked( $core_update, 1, true ); ?>> <?php esc_html_e( 'WordPress Core Update Available?', 'dorzki-notifications-to-slack' ); ?>
              </label>
              <br>
              <!-- /WordPress Core Update? -->

              <!-- WordPress Theme Update? -->
              <label for="slack_notif_theme_update">
                <input type="checkbox" name="slack_notif_theme_update" id="slack_notif_theme_update" value="1" <?php checked( $theme_update, 1, true ); ?>> <?php esc_html_e( 'Theme Update Available?', 'dorzki-notifications-to-slack' ); ?>
              </label>
              <br>
              <!-- /WordPress Theme Update? -->

              <!-- WordPress Plugin Update? -->
              <label for="slack_notif_plugin_update">
                <input type="checkbox" name="slack_notif_plugin_update" id="slack_notif_plugin_update" value="1" <?php checked( $plugin_update, 1, true ); ?>> <?php esc_html_e( 'Plugin Update Available?', 'dorzki-notifications-to-slack' ); ?>
              </label>
              <br>
              <!-- /WordPress Plugin Update? -->

            </fieldset>
          </td>
        </tr>
        <tr>
          <th scope="row"><?php esc_html_e( 'New Entries', 'dorzki-notifications-to-slack' ); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text">
                <span><?php esc_html_e( 'New Entries', 'dorzki-notifications-to-slack' ); ?></span>
              </legend>

              <!-- New Post -->
              <label for="slack_notif_new_post">
                <input type="checkbox" name="slack_notif_new_post" id="slack_notif_new_post" value="1" <?php checked( $new_post, 1, true ); ?>> <?php esc_html_e( 'Post Published', 'dorzki-notifications-to-slack' ); ?>
              </label>
              <br>
              <!-- /New Post -->

              <!-- New Page -->
              <label for="slack_notif_new_page">
                <input type="checkbox" name="slack_notif_new_page" id="slack_notif_new_page" value="1" <?php checked( $new_page, 1, true ); ?>> <?php esc_html_e( 'Page Published', 'dorzki-notifications-to-slack' ); ?>
              </label>
              <br>
              <!-- /New Page -->

              <?php foreach ( $postTypes as $postType ) : ?>
                <!-- New <?php echo esc_html( $postType->labels->singular_name ); ?> -->
                <label for="slack_notif_new_<?php echo esc_html( $postType->name ); ?>">
                  <input type="checkbox" name="slack_notif_new_<?php echo esc_html( $postType->name ); ?>" id="slack_notif_new_<?php echo esc_html( $postType->name ); ?>" value="1" <?php checked( intval( get_option( 'slack_notif_new_' . $postType->name ) ), 1, true ); ?>> <?php printf( esc_html__( '%s Published', 'dorzki-notifications-to-slack' ), esc_html( $postType->labels->singular_name ) ); ?>
                </label>
                <br>
                <!-- /New <?php echo esc_html( $postType->labels->singular_name ); ?> -->
              <?php endforeach; ?>

              <!-- New Comment -->
              <label for="slack_notif_new_comment">
                <input type="checkbox" name="slack_notif_new_comment" id="slack_notif_new_comment" value="1" <?php checked( $new_comment, 1, true ); ?>> <?php esc_html_e( 'New Comment', 'dorzki-notifications-to-slack' ); ?>
              </label>
              <br>
              <!-- /New Comment -->

            </fieldset>
          </td>
        </tr>
        <tr>
          <th scope="row"><?php esc_html_e( 'Users', 'dorzki-notifications-to-slack' ); ?></th>
          <td>
            <fieldset>
              <legend class="screen-reader-text">
                <span><?php esc_html_e( 'Users', 'dorzki-notifications-to-slack' ); ?></span>
              </legend>

              <!-- New User -->
              <label for="slack_notif_new_user">
                <input type="checkbox" name="slack_notif_new_user" id="slack_notif_new_user" value="1" <?php checked( $new_user, 1, true ); ?>> <?php esc_html_e( 'New User', 'dorzki-notifications-to-slack' ); ?>
              </label>
              <br>
              <!-- /New User -->

              <!-- Admin Logged-in -->
              <label for="slack_notif_admin_logged">
                <input type="checkbox" name="slack_notif_admin_logged" id="slack_notif_admin_logged" value="1" <?php checked( $admin_logged, 1, true ); ?>> <?php esc_html_e( 'Admin Logged-in', 'dorzki-notifications-to-slack' ); ?>
              </label>
              <br>
              <!-- /Admin Logged-in -->

            </fieldset>
          </td>
        </tr>

      </tbody>
    </table>

    <!-- Test Integration -->
    <h3 class="title"><?php esc_html_e( 'Test Integration', 'dorzki-notifications-to-slack' ); ?></h3>
    <p><?php esc_html_e( 'Test if you configured the plugin correctly by sending a test notification (available only if the plugin is configured).', 'dorzki-notifications-to-slack' ); ?></p>
    <button type="button" id="dorzki-test-integration" class="button button-secondary" <?php echo ( ! $isConfigured ) ? 'disabled' : ''; ?>><?php esc_html_e( 'Send test notification', 'dorzki-notifications-to-slack' ); ?></button>
    <img id="test-spinner" src="<?php echo admin_url( 'images/wpspin_light-2x.gif' ); ?>" alt="WordPress Spinner">
    <!-- /Test Integration -->

    <?php submit_button(); ?>
  </form>
</div>
