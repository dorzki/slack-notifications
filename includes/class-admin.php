<?php
/**
 * Admin
 *
 * @package    dorzki\SlackNotifications
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications;

use dorzki\SlackNotifications\Settings\General;

defined( 'ABSPATH' ) || exit;


/**
 * Class Admin
 *
 * @package dorzki\SlackNotifications
 */
class Admin {
	/**
	 * Admin constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_pages' ] );
	}


	/**
	 * Register plugin admin pages.
	 *
	 * @return void
	 */
	public function register_pages() : void {
		add_menu_page(
			__( 'Slack Notifications', 'dorzki-notifications-to-slack' ),
			__( 'Slack Notifications', 'dorzki-notifications-to-slack' ),
			'manage_options',
			Plugin::SLUG,
			null,
			'dashicons-megaphone',
			100
		);

		remove_submenu_page( Plugin::SLUG, Plugin::SLUG );

		new General();
	}
}
