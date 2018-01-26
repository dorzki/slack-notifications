<?php
/**
 * Plugin Name: Slack Notifications
 * Plugin URI: https://www.dorzki.co.il
 * Description: Add Slack integration to a channel and send desired notifications as a slack bot.
 * Version: 2.0.0
 * Author: dorzki
 * Author URI: https://www.dorzki.co.il
 * Text Domain: dorzki-notifications-to-slack
 *
 *
 * @package   SlackNotifications
 * @since     1.0.0
 * @version   2.0.0
 * @author    Dor Zuberi <me@dorzki.co.il>
 * @link      https://www.dorzki.co.il
 */

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugins constants
define( 'SN_VERSION', '2.0.0' );
define( 'SN_SLUG', 'slack-notifications' );
define( 'SN_PATH', plugin_dir_path( __FILE__ ) );

// Check if the plugin can run on this server.
if ( ! version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	add_action( 'admin_notices', 'sn_php_version_not_supported' );
} else if ( ! version_compare( get_bloginfo( 'version' ), '4.5', '>=' ) ) {
	add_action( 'admin_notices', 'sn_wp_version_no_supported' );
} else {
	require_once( SN_PATH . 'core/plugin.php' );
}


/**
 * Load plugin i18n and l10n capabilities.
 */
function sn_load_text_domain() {

	load_plugin_textdomain( 'dorzki-notification-to-slack' );

}

add_action( 'plugins_loaded', 'sn_load_text_domain' );


/**
 * Show notice to admin if the server doesn't have the minimum required PHP version.
 *
 * @return string
 */
function sn_php_version_not_supported() {

	$notice = sprintf( esc_html__( 'Slack Notifications plugin requires PHP version %s or above to work properly.', 'dorzki-notifications-to-slack' ), '5.4' );

	echo "<div class='error'><p>{$notice}</p></div>";

}


/**
 * Show notice to admin if WordPress version doesn't meet the requirements.
 *
 * @return string
 */
function sn_wp_version_no_supported() {

	$notice = sprintf( esc_html__( 'Slack Notifications plugin requires WordPress version %s or above to work properly.', 'dorzki-notifications-to-slack' ), '4.5' );

	echo "<div class='error'><p>{$notice}</p></div>";

}