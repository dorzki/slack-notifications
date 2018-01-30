<?php
/**
 * User notifications.
 *
 * @package     SlackNotifications\Notifications
 * @subpackage  User
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
 * Class User
 *
 * @package SlackNotifications\Notifications
 */
class User extends Notification_Type {

	/**
	 * User constructor.
	 */
	public function __construct() {

		$this->object_type    = 'user';
		$this->object_label   = esc_html__( 'User', 'dorzki-notifications-to-slack' );
		$this->object_options = [
			'new_user'        => [
				'label'  => esc_html__( 'User Registered', 'dorzki-notifications-to-slack' ),
				'hooks'  => [
					'user_register' => 'new_user',
				],
				'priority' => 10,
				'params' => 1,
			],
			'admin_logged_in' => [
				'label'  => esc_html__( 'Administrator Logged In', 'dorzki-notifications-to-slack' ),
				'hooks'  => [
					'wp_login' => 'administrator_login',
				],
				'priority' => 10,
				'params' => 2,
			],
		];

		parent::__construct();

	}

}