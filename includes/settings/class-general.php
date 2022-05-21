<?php
/**
 * Settings -> General
 *
 * @package    dorzki\SlackNotifications\Settings
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications\Settings;

use dorzki\SlackNotifications\Base\Settings_Page;
use dorzki\SlackNotifications\Enum\Control_Type;
use dorzki\SlackNotifications\Plugin;
use dorzki\SlackNotifications\Settings\Control\Button;
use dorzki\SlackNotifications\Settings\Control\Input;
use dorzki\SlackNotifications\Settings\Control\Section;

defined( 'ABSPATH' ) || exit;


/**
 * Class General
 *
 * @package dorzki\SlackNotifications\Settings
 */
class General extends Settings_Page {
	/**
	 * General constructor.
	 */
	public function __construct() {
		parent::__construct(
			Plugin::SLUG,
			esc_html_x( 'General', 'Settings Page Title', 'dorzki-notifications-to-slack' ),
			DSN_TEMPLATES_PATH . 'settings/general.php'
		);
	}


	/**
	 * @inheritDoc
	 */
	public function register_settings() : void {
		$this->settings = [
			new Section(
				'dsn_section_connection',
				esc_html__( 'Connection Settings', 'dorzki-notifications-to-slack' ),
				[
					new Input(
						Control_Type::TEXT,
						self::FIELD_PREFIX . 'slack_token',
						esc_html__( 'Slack Bot Token', 'dorzki-notifications-to-slack' )
					),
					new Button(
						Control_Type::BUTTON,
						self::FIELD_PREFIX . 'slack_test_connection',
						esc_html__( 'Test Connection', 'dorzki-notifications-to-slack' ),
						esc_html__( 'Test', 'dorzki-notifications-to-slack' )
					),
				]
			),
		];
	}
}
