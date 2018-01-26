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

}