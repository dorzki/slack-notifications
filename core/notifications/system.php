<?php
/**
 * System notifications.
 *
 * @package     SlackNotifications\Notifications
 * @subpackage  System
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.0
 */

namespace SlackNotifications\Notifications;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class System
 *
 * @package SlackNotifications\Notifications
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

}