<?php
/**
 * Plugin Name: Slack Notifications
 * Plugin URI: https://www.dorzki.io
 * Description: Get notified and monitor your WordPress site with Slack notifications.
 * Version: 2.1.0
 * Author: dorzki
 * Author URI: https://www.dorzki.io
 * Text Domain: dorzki-notifications-to-slack
 * Requires at least: 5.3
 * Requires PHP: 7.1
 */

defined( 'ABSPATH' ) || exit;


if ( ! defined( 'DSN_PATH' ) ) {
	define( 'DSN_PATH', plugin_dir_path( __FILE__ ) );
}


if ( ! version_compare( PHP_VERSION, '7.1', '>=' ) ) {
	add_action( 'admin_notices', 'dsn_incompatible_php_version' );
} elseif ( ! version_compare( get_bloginfo( 'version' ), '5.3', '>=' ) ) {
	add_action( 'admin_notices', 'dsn_incompatible_wp_version' );
} else {
	require_once DSN_PATH . 'includes/class-plugin.php';
}


add_action( 'plugins_loaded', 'dsn_load_textdomain' );

/**
 * Register plugin's text domain.
 *
 * @return void
 *
 * @since 1.0.0
 */
function dsn_load_textdomain() : void {
	load_plugin_textdomain( 'dorzki-notifications-to-slack' );
}

/**
 * Display admin notice for incompatible PHP version.
 *
 * @return void
 *
 * @since 1.0.0
 */
function dsn_incompatible_php_version() : void {

	$notice = sprintf(
	/* translators: %1$s PHP version */
		esc_html__(
			'Slack Notifications requires PHP version %1$s at least to work.',
			'dorzki-notifications-to-slack'
		),
		'7.1'
	);

	echo wp_kses_post( sprintf( '<div class="error">%s</div>', wpautop( $notice ) ) );

}

/**
 * Display admin notice for incompatible WordPress version.
 *
 * @return void
 *
 * @since 1.0.0
 */
function dsn_incompatible_wp_version() : void {

	$notice = sprintf(
	/* translators: %1$s WordPress version */
		esc_html__(
			'Slack Notifications requires WordPress version %1$s at least to work.',
			'dorzki-notifications-to-slack'
		),
		'5.3'
	);

	echo wp_kses_post( sprintf( '<div class="error">%s</div>', wpautop( $notice ) ) );

}
