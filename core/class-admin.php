<?php
/**
 * Declare admin settings page, and plugin admin assets.
 *
 * @package     Slack_Notifications
 * @subpackage  Admin
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.6
 */

namespace Slack_Notifications;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Admin
 *
 * @package Slack_Notifications
 */
class Admin {

	/**
	 * Admin constructor.
	 */
	public function __construct() {

		add_action( 'admin_menu', [ $this, 'register_settings_menu' ] );
		add_action( 'admin_menu', [ $this, 'remove_settings_submenu' ], 11 );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_styles' ] );

		$status = get_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'test_integration' );

		if ( empty( $status ) ) {
			add_action( 'admin_notices', [ $this, 'display_connect_problem' ] );
		}

		$this->register_settings_pages();

	}


	/* ------------------------------------------ */


	/**
	 * Register the plugin's admin menu root.
	 */
	public function register_settings_menu() {

		// Register plugin settings menu item.
		add_menu_page( __( 'Slack Notifications', 'dorzki-notifications-to-slack' ), __( 'Slack Notifications', 'dorzki-notifications-to-slack' ), 'manage_options', SLACK_NOTIFICATIONS_SLUG, null, 'dashicons-cloud', 100 );

	}


	/**
	 * Remove the default top level plugin page.
	 */
	public function remove_settings_submenu() {

		remove_submenu_page( SLACK_NOTIFICATIONS_SLUG, SLACK_NOTIFICATIONS_SLUG );

	}


	/**
	 * Declares a new settings page for the plugin.
	 */
	public function register_settings_pages() {

		do_action( 'slack_before_register_pages' );

		new Settings\General();
		new Settings\Notifications();
		new Settings\Support();

		do_action( 'slack_after_register_pages' );

	}


	/* ------------------------------------------ */


	/**
	 * Load plugin scripts.
	 */
	public function register_scripts() {

		// Load plugin assets only on the plugin's settings page.
		if ( - 1 !== strpos( get_current_screen()->id, SLACK_NOTIFICATIONS_SLUG ) ) {

			// Load WordPress media uploader scripts.
			wp_enqueue_media();

			// Load plugin scripts.
			wp_enqueue_script( SLACK_NOTIFICATIONS_SLUG . '-scripts', SLACK_NOTIFICATIONS_URL . 'assets/admin-scripts.min.js', [ 'jquery' ], SLACK_NOTIFICATIONS_VERSION, true );

			// Allow JS strings localization.
			wp_localize_script(
				SLACK_NOTIFICATIONS_SLUG . '-scripts',
				'sn_lang',
				[
					'media_frame_title'  => __( 'Choose or upload a new image', 'dorzki-notifications-to-slack' ),
					'media_frame_button' => __( 'Select Image', 'dorzki-notifications-to-slack' ),
				]
			);

		}

	}


	/**
	 * Load plugin styles.
	 */
	public function register_styles() {

		// Load plugin assets only on the plugin's settings page.
		if ( - 1 !== strpos( get_current_screen()->id, SLACK_NOTIFICATIONS_SLUG ) ) {

			// Load plugin styles.
			wp_enqueue_style( SLACK_NOTIFICATIONS_SLUG . '-styles', SLACK_NOTIFICATIONS_URL . 'assets/admin-styles.min.css', false, SLACK_NOTIFICATIONS_VERSION );

		}

	}


	/* ------------------------------------------ */


	/**
	 * Display en error to the admin if there is a connectivity issue.
	 */
	public function display_connect_problem() {

		echo "<div class='error notice slack-connect-error'>";
		echo '  <p>' . esc_html__( 'There is an issue with the Slack Bot, please check your configuration again.', 'dorzki-notifications-to-slack' ) . '</p>';
		echo '</div>';

	}

}
