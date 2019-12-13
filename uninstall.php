<?php
/**
 * Plugin clean up.
 *
 * @package     SlackNotifications
 * @subpackage  Plugin
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.6
 */

// Block direct access to the file via url.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Clean plugin database data.
delete_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'version' );
delete_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'webhook' );
delete_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'default_channel' );
delete_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'bot_name' );
delete_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'bot_image' );
delete_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'text_integration' );
delete_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'notifications' );
delete_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'wordpress_version' );
delete_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'plugins_version' );
delete_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'themes_version' );

// Clean WordPress cache.
wp_cache_flush();
