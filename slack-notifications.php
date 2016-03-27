<?php
/**
 * Plugin Name: Slack Notifications
 * Plugin URI: https://www.dorzki.co.il
 * Description: Add Slack integration to a channel and send desired notifications as a slack bot.
 * Version: 1.0.6
 * Author: dorzki
 * Author URI: https://www.dorzki.co.il
 * Text Domain: dorzki-notifications-to-slack
 * Domain Path: /languages
 *
 * 
 * @package   Slack Notifications
 * @since     1.0.0
 * @version   1.0.5
 * @author    Dor Zuberi <me@dorzki.co.il>
 * @link      https://www.dorzki.co.il
 */



/**
 * PLUGIN CONSTACTS
 */
if ( ! defined( 'PLUGIN_ROOT_URL' ) ) {
	define( 'PLUGIN_ROOT_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'PLUGIN_ROOT_DIR' ) ) {
	define( 'PLUGIN_ROOT_DIR', dirname( __FILE__ ) );
}

if ( ! defined( 'PLUGIN_VERSION' ) ) {
	define( 'PLUGIN_VERSION', '1.0.6' );
}



/**
 * PLUGIN CLASSES
 */
include_once( 'classes/wordpress-notifications.php' );
include_once( 'classes/slack-bot.php' );
include_once( 'classes/wordpress-slack.php' );



/**
 * PLUGIN INTIALIZATION
 */
$wpSlack = new wpSlack();



/**
 * REGISTER ACTIVATION & DEACTIVATION
 */
register_activation_hook( __FILE__, array( &$wpSlack, 'plugin_activate' ) );
register_deactivation_hook( __FILE__, array( &$wpSlack, 'plugin_deactivate' ) );