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
				'label'    => esc_html__( 'User Registered', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'user_register' => 'new_user',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'admin_logged_in' => [
				'label'    => esc_html__( 'Administrator Logged In', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'wp_login' => 'administrator_login',
				],
				'priority' => 10,
				'params'   => 2,
			],
		];

		parent::__construct();

	}


	/**
	 * Post notification when a new user has registered.
	 *
	 * @param $user_id
	 *
	 * @return bool
	 */
	public function new_user( $user_id ) {

		$user = get_user_by( 'id', $user_id );

		if ( false === $user ) {
			return false;
		}

		// Build notification
		$message = __( ':bust_in_silhouette: A new user just registered on <%s|%s>.', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, get_bloginfo( 'url' ), get_bloginfo( 'name' ) );

		$attachments = [
			[
				'title' => esc_html__( 'User Name', 'dorzki-notifications-to-slack' ),
				'value' => $user->display_name,
				'short' => true,
			],
			[
				'title' => esc_html__( 'User Email', 'dorzki-notifications-to-slack' ),
				'value' => $user->user_email,
				'short' => true,
			],
		];

		return $this->slack_bot->send_message( $message, $attachments, [
			'color' => '#2ecc71',
		] );

	}


	/**
	 * Post notification when an administrator login was detected.
	 *
	 * @param $username
	 * @param $user
	 *
	 * @return bool
	 */
	public function administrator_login( $username, $user ) {

		if ( ! in_array( 'administrator', $user->roles ) ) {
			return false;
		}

		// Build notification
		$message = __( ':necktie: Administrator login detected on <%s|%s>.', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, get_bloginfo( 'url' ), get_bloginfo( 'name' ) );

		$attachments = [
			[
				'title' => esc_html__( 'Username', 'dorzki-notifications-to-slack' ),
				'value' => $username,
				'short' => true,
			],
			[
				'title' => esc_html__( 'Login IP', 'dorzki-notifications-to-slack' ),
				'value' => $_SERVER[ 'REMOTE_ADDR' ],
				'short' => true,
			],
		];

		return $this->slack_bot->send_message( $message, $attachments, [
			'color' => '#27ae60',
		] );

	}

}