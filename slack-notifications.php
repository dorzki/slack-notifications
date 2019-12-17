<?php
/**
 * Plugin Name: Slack Notifications
 * Plugin URI: https://www.dorzki.co.il
 * Description: Stay up-to-date about your WordPress site directly to your Slack.
 * Version: 2.0.7
 * Author: dorzki
 * Author URI: https://www.dorzki.co.il
 * Text Domain: dorzki-notifications-to-slack
 *
 * @package Slack_Notifications
 * @since   1.0.0
 * @version 2.0.7
 * @author  Dor Zuberi <me@dorzki.co.il>
 * @link    https://www.dorzki.co.il
 */

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugins constants.
define( 'SLACK_NOTIFICATIONS_VERSION', '2.0.7' );
define( 'SLACK_NOTIFICATIONS_SLUG', 'slack-notifications' );
define( 'SLACK_NOTIFICATIONS_FIELD_PREFIX', 'slack_' );
define( 'SLACK_NOTIFICATIONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'SLACK_NOTIFICATIONS_URL', plugin_dir_url( __FILE__ ) );

// Check if the plugin can run on this server.
if ( ! version_compare( PHP_VERSION, '5.4', '>=' ) ) {

	add_action( 'admin_notices', 'sn_php_version_not_supported' );

} elseif ( ! version_compare( get_bloginfo( 'version' ), '4.5', '>=' ) ) {

	add_action( 'admin_notices', 'sn_wp_version_no_supported' );

} else {

	include_once 'core/class-plugin.php';

	add_action( 'plugins_loaded', 'sn_update_plugin_db' );

}


/**
 * Load plugin i18n and l10n capabilities.
 */
function sn_load_text_domain() {

	load_plugin_textdomain( 'dorzki-notifications-to-slack' );

}

add_action( 'plugins_loaded', 'sn_load_text_domain' );


/**
 * Show notice to admin if the server doesn't have the minimum required PHP version.
 */
function sn_php_version_not_supported() {

	/* translators: %s: PHP version */
	$notice      = sprintf( esc_html__( 'Slack Notifications plugin requires PHP version %s or above to work properly.', 'dorzki-notifications-to-slack' ), '5.4' );
	$notice_html = sprintf( '<div class="error">%s</div>', wpautop( $notice ) );

	echo wp_kses_post( $notice_html );

}


/**
 * Show notice to admin if WordPress version doesn't meet the requirements.
 */
function sn_wp_version_no_supported() {

	/* translators: %s: WordPress version */
	$notice      = sprintf( esc_html__( 'Slack Notifications plugin requires WordPress version %s or above to work properly.', 'dorzki-notifications-to-slac' ), '4.7' );
	$notice_html = sprintf( '<div class="error">%s</div>', wpautop( $notice ) );

	echo wp_kses_post( $notice_html );

}


/**
 * Plugin activation method, currently used for handling version upgrade.
 *
 * @return bool
 */
function sn_update_plugin_db() {

	// Get previous version.
	$old_version = get_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'version' );

	update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'version', SLACK_NOTIFICATIONS_VERSION );

	if ( ! empty( $old_version ) && version_compare( $old_version, '2.0.0', '>=' ) ) {
		return false;
	}

	$webhook   = get_option( 'slack_webhook_endpoint' );
	$channel   = get_option( 'slack_channel_name' );
	$bot_name  = get_option( 'slack_bot_username' );
	$bot_image = get_option( 'slack_bot_image' );

	$notifications = [];

	// Upgrade array.
	$old_hooks = [
		'system'  => [
			'label' => esc_html__( 'System', 'dorzki-notifications-to-slack' ),
			'hooks' => [
				'slack_notif_core_update'   => [
					'action' => 'wordpress_update',
					'title'  => esc_html__( 'WordPress Update Available', 'dorzki-notifications-to-slack' ),
				],
				'slack_notif_plugin_update' => [
					'action' => 'plugins_update',
					'title'  => esc_html__( 'WordPress Update Available', 'dorzki-notifications-to-slack' ),
				],
				'slack_notif_theme_update'  => [
					'action' => 'themes_update',
					'title'  => esc_html__( 'Theme Update Available', 'dorzki-notifications-to-slack' ),
				],
			],
		],
		'user'    => [
			'label' => esc_html__( 'Users', 'dorzki-notifications-to-slack' ),
			'hooks' => [
				'slack_notif_new_user'     => [
					'action' => 'new_user',
					'title'  => esc_html__( 'User Registered', 'dorzki-notifications-to-slack' ),
				],
				'slack_notif_admin_logged' => [
					'action' => 'admin_logged_in',
					'title'  => esc_html__( 'Administrator Logged In', 'dorzki-notifications-to-slack' ),
				],
			],
		],
		'comment' => [
			'label' => esc_html__( 'Comments', 'dorzki-notifications-to-slack' ),
			'hooks' => [
				'slack_notif_new_comment' => [
					'action' => 'new_comment',
					'title'  => esc_html__( 'New Comment', 'dorzki-notifications-to-slack' ),
				],
			],
		],
		'post'    => [
			'label' => esc_html__( 'Posts', 'dorzki-notifications-to-slack' ),
			'hooks' => [
				'slack_notif_new_post'     => [
					'action' => 'new_post',
					'title'  => esc_html__( 'Post Published', 'dorzki-notifications-to-slack' ),
				],
				'slack_notif_future_post'  => [
					'action' => 'future_post',
					'title'  => esc_html__( 'Post Scheduled', 'dorzki-notifications-to-slack' ),
				],
				'slack_notif_pending_post' => [
					'action' => 'pending_post',
					'title'  => esc_html__( 'Post Pending', 'dorzki-notifications-to-slack' ),
				],
				'slack_notif_update_post'  => [
					'action' => 'update_post',
					'title'  => esc_html__( 'Post Updated', 'dorzki-notifications-to-slack' ),
				],
			],
		],
		'page'    => [
			'label' => esc_html__( 'Pages', 'dorzki-notifications-to-slack' ),
			'hooks' => [
				'slack_notif_new_page'     => [
					'action' => 'new_page',
					'title'  => esc_html__( 'Page Published', 'dorzki-notifications-to-slack' ),
				],
				'slack_notif_future_page'  => [
					'action' => 'future_page',
					'title'  => esc_html__( 'Page Scheduled', 'dorzki-notifications-to-slack' ),
				],
				'slack_notif_pending_page' => [
					'action' => 'pending_page',
					'title'  => esc_html__( 'Page Pending', 'dorzki-notifications-to-slack' ),
				],
				'slack_notif_update_page'  => [
					'action' => 'update_page',
					'title'  => esc_html__( 'Page Updated', 'dorzki-notifications-to-slack' ),
				],
			],
		],
	];

	foreach ( $old_hooks as $type => $type_data ) {

		foreach ( $type_data['hooks'] as $old_hook => $hook_data ) {

			if ( get_option( $old_hook ) ) {

				$notifications[] = [
					'type'    => $type,
					'action'  => $hook_data['action'],
					'channel' => null,
					'title'   => sprintf( '[%s] %s', $type_data['label'], $hook_data['title'] ),
				];

			}

			delete_option( $old_hook );

		}
	}

	// Handle custom post types.
	$post_types = get_post_types(
		[
			'public'   => true,
			'_builtin' => false,
		]
	);

	foreach ( $post_types as $post_type ) {

		if ( get_option( "slack_notif_new_{$post_type}" ) ) {

			$cpt_obj = get_post_type_object( $post_type );

			/* translators: %s: Notification Category, %s: Notification Type */
			$title = sprintf( '[%s] %s', $cpt_obj->labels->name, sprintf( esc_html__( '%s Published', 'dorzki-notifications-to-slack' ), $cpt_obj->labels->singular_name ) );

			$notifications[] = [
				'type'    => 'cpt_' . $post_type,
				'action'  => 'new_cpt',
				'channel' => null,
				'title'   => $title,
			];

		}

		delete_option( "slack_notif_new_{$post_type}" );

	}

	// Clean database.
	delete_option( 'slack_webhook_endpoint' );
	delete_option( 'slack_channel_name' );
	delete_option( 'slack_bot_username' );
	delete_option( 'slack_bot_image' );
	delete_option( 'slack_notif_core_version' );
	delete_option( 'slack_notif_theme_version' );
	delete_option( 'slack_notif_plugins_version' );
	delete_option( 'slack_notice_connectivity' );
	delete_option( '_testing_slack' );

	// Save new values.
	update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'webhook', $webhook );
	update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'default_channel', $channel );
	update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'bot_name', $bot_name );
	update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'bot_image', $bot_image );
	update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'test_integration', '1' );
	update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'notifications', wp_json_encode( $notifications ) );

	return true;

}
