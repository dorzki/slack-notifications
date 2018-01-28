<?php
/**
 * Declare admin settings page, and plugin admin assets.
 *
 * @package     SlackNotifications
 * @subpackage  Admin
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.0
 */

namespace SlackNotifications;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Admin
 *
 * @package SlackNotifications
 */
class Admin {

	/**
	 * @var null|Settings_Page
	 */
	public $settings = null;


	/**
	 * Admin constructor.
	 */
	public function __construct() {

		add_action( 'admin_menu', [ $this, 'register_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_styles' ] );

		$this->settings = new Settings_Page();

	}


	/**
	 * Declares a new settings page for the plugin.
	 */
	public function register_menu() {

		add_options_page( __( 'Slack Notifications Settings', 'dorzki-notification-to-slack' ), __( 'Slack Notifications', 'dorzki-notification-to-slack' ), 'manage_options', SN_SLUG, [
			$this->settings,
			'print_settings_page',
		] );

	}


	/**
	 * Load plugins scripts.
	 */
	public function register_scripts() {

		// Load plugin assets only on the plugin's settings page.
		if ( 'settings_page_' . SN_SLUG === get_current_screen()->id ) {

			// Load WordPress media uploader scripts.
			wp_enqueue_media();

			// Load plugin scripts.
			wp_enqueue_script( SN_SLUG . '-scripts', SN_URL . 'assets/admin-scripts.min.js', [ 'jquery' ], SN_VERSION, true );

			// Allow JS strings localization.
			wp_localize_script( SN_SLUG . '-scripts', 'sn_lang', [
				'media_frame_title'  => __( 'Choose or upload a new image', 'dorzki-notifications-to-slack' ),
				'media_frame_button' => __( 'Select Image', 'dorzki-notifications-to-slack' ),
			] );

		}

	}

	public function register_styles() {

		// Load plugin assets only on the plugin's settings page.
		if ( 'settings_page_' . SN_SLUG === get_current_screen()->id ) {

			// Load plugin styles.
			wp_enqueue_style( SN_SLUG . '-styles', SN_URL . 'assets/admin-styles.min.css', false, SN_VERSION );

		}

	}

}