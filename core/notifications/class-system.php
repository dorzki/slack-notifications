<?php
/**
 * System notifications.
 *
 * @package     Slack_Notifications\Notifications
 * @subpackage  System
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.6
 */

namespace Slack_Notifications\Notifications;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class System
 *
 * @package Slack_Notifications\Notifications
 */
class System extends Notification_Type {

	/**
	 * System constructor.
	 */
	public function __construct() {

		$this->object_type    = 'system';
		$this->object_label   = esc_html__( 'System', 'dorzki-notifications-to-slack' );
		$this->object_options = [
			'wordpress_update' => [
				'label'  => esc_html__( 'WordPress Update Available', 'dorzki-notifications-to-slack' ),
				'hooks'  => [
					'wp_version_check' => 'wordpress_update',
				],
				'params' => 0,
			],
			'plugins_update'   => [
				'label'  => esc_html__( 'Plugin Update Available', 'dorzki-notifications-to-slack' ),
				'hooks'  => [
					'wp_update_plugins' => 'plugins_update',
				],
				'params' => 0,
			],
			'themes_update'    => [
				'label'  => esc_html__( 'Theme Update Available', 'dorzki-notifications-to-slack' ),
				'hooks'  => [
					'wp_update_themes' => 'themes_update',
				],
				'params' => 0,
			],
		];

		parent::__construct();

	}


	/* ------------------------------------------ */


	/**
	 * Post notification when a new version of WordPress is available.
	 *
	 * @return bool
	 */
	public function wordpress_update() {

		$version_data = get_site_transient( 'update_core' );

		if ( false === $version_data ) {
			return false;
		}

		if ( ! is_object( $version_data ) || ! isset( $version_data->updates[0] ) ) {
			return false;
		}

		if ( 'upgrade' !== $version_data->updates[0]->response ) {
			return false;
		}

		$saved_version = get_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'wordpress_version' );

		if ( $saved_version !== $version_data->updates[0]->current ) {

			update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'wordpress_version', $version_data->updates[0]->current );

			// Build notification.
			/* translators: %1$s: Site URL, %2$s: Site Name */
			$message = __( ':warning: There is a new version available for WordPress on <%1$s|%2$s>.', 'dorzki-notifications-to-wordpress' );
			$message = sprintf( $message, get_bloginfo( 'url' ), get_bloginfo( 'name' ) );

			$attachments = [
				[
					'title' => esc_html__( 'Current Version', 'dorzki-notifications-to-slack' ),
					'value' => $version_data->version_checked,
					'short' => true,
				],
				[
					'title' => esc_html__( 'New Version', 'dorzki-notifications-to-slack' ),
					'value' => $version_data->updates[0]->current,
					'short' => true,
				],

			];

			$channel = $this->get_notification_channel( __FUNCTION__ );

			return $this->slack_bot->send_message(
				$message,
				$attachments,
				[
					'color'   => '#f1c40f',
					'channel' => $channel,
				]
			);

		}

		return false;

	}


	/**
	 * Post notification when there are new versions for plugins.
	 *
	 * @return bool
	 */
	public function plugins_update() {

		$plugins_versions = get_site_transient( 'update_plugins' );

		if ( false === $plugins_versions ) {
			return false;
		}

		if ( ! is_object( $plugins_versions ) || ! isset( $plugins_versions->response ) ) {
			return false;
		}

		// Get saved plugins versions notifications.
		$saved_plugins_versions = get_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'plugins_version' );

		if ( false === $saved_plugins_versions ) {
			$saved_plugins_versions = [];
		}

		$attachments = [];

		// Check if there are new versions.
		foreach ( $plugins_versions->response as $plugin_file => $update_data ) {

			if ( $plugins_versions->checked[ $plugin_file ] === $update_data->new_version ) {
				continue;
			}

			$plugin_meta = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin_file, true, false );

			if ( isset( $saved_plugins_versions[ $plugin_file ] ) && $saved_plugins_versions[ $plugin_file ] === $update_data->new_version ) {
				continue;
			}

			$saved_plugins_versions[ $plugin_file ] = $update_data->new_version;

			$attachments[] = [
				[
					'title' => esc_html__( 'Plugin Name', 'dorzki-notifications-to-slack' ),
					'value' => $plugin_meta['Name'],
					'short' => true,
				],
				[
					'title' => esc_html__( 'New Version', 'dorzki-notifications-to-slack' ),
					'value' => $update_data->new_version,
					'short' => true,
				],
			];

		}

		update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'plugins_version', $saved_plugins_versions );

		if ( ! empty( $attachments ) ) {

			// Build notification.
			/* translators: %1$s: Site URL, %2$s: Site Name */
			$message = __( ':warning: There are new versions available for your plugins on <%1$s|%2$s>.', 'dorzki-notifications-to-slack' );
			$message = sprintf( $message, get_bloginfo( 'url' ), get_bloginfo( 'name' ) );

			$attachments['multiple'] = true;

			$channel = $this->get_notification_channel( __FUNCTION__ );

			return $this->slack_bot->send_message(
				$message,
				$attachments,
				[
					'color'   => '#f1c40f',
					'channel' => $channel,
				]
			);

		}

		return false;

	}


	/**
	 * Post notification when there are new versions for themes.
	 *
	 * @return bool
	 */
	public function themes_update() {

		$themes_versions = get_site_transient( 'update_themes' );

		if ( false === $themes_versions ) {
			return false;
		}

		if ( ! is_object( $themes_versions ) || ! isset( $themes_versions->response ) ) {
			return false;
		}

		// Get saved themes versions notifications.
		$saved_themes_versions = get_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'themes_version' );

		if ( false === $saved_themes_versions ) {
			$saved_themes_versions = [];
		}

		$attachments = [];

		// Check if there are new versions.
		foreach ( $themes_versions->response as $theme_dir => $update_data ) {

			if ( $themes_versions->checked[ $theme_dir ] === $update_data['new_version'] ) {
				continue;
			}

			$theme_meta = wp_get_theme( $theme_dir );

			if ( isset( $saved_themes_versions[ $theme_dir ] ) && $saved_themes_versions[ $theme_dir ] === $update_data->new_version ) {
				continue;
			}

			$saved_themes_versions[ $theme_dir ] = $update_data['new_version'];

			$attachments[] = [
				[
					'title' => esc_html__( 'Plugin Name', 'dorzki-notifications-to-slack' ),
					'value' => $theme_meta->get( 'Name' ),
					'short' => true,
				],
				[
					'title' => esc_html__( 'New Version', 'dorzki-notifications-to-slack' ),
					'value' => $update_data['new_version'],
					'short' => true,
				],
			];

		}

		update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'themes_version', $saved_themes_versions );

		if ( ! empty( $attachments ) ) {

			// Build notification.
			/* translators: %1$s: Site URL, %2$s: Site Name */
			$message = __( ':warning: There are new versions available for your themes on <%1$s|%2$s>.', 'dorzki-notifications-to-slack' );
			$message = sprintf( $message, get_bloginfo( 'url' ), get_bloginfo( 'name' ) );

			$attachments['multiple'] = true;

			$channel = $this->get_notification_channel( __FUNCTION__ );

			return $this->slack_bot->send_message(
				$message,
				$attachments,
				[
					'color'   => '#f1c40f',
					'channel' => $channel,
				]
			);

		}

		return false;

	}

}
