<?php
/**
 * User notifications.
 *
 * @package     SlackNotifications\Notifications
 * @subpackage  User
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.4
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
		$this->object_label   = esc_html__( 'Users', 'dorzki-notifications-to-slack' );
		$this->object_options = [
			'new_user'           => [
				'label'    => esc_html__( 'User Registered', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'user_register' => 'new_user',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'admin_logged_in'    => [
				'label'    => esc_html__( 'Administrator Logged In', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'wp_login' => 'administrator_login',
				],
				'priority' => 9,
				'params'   => 2,
			],
			'admin_failed_login' => [
				'label'    => esc_html__( 'Administrator Failed Login', 'dorzki-notofications-to-slack' ),
				'hooks'    => [
					'wp_login_failed' => 'administrator_failed_login',
				],
				'priority' => 9,
				'params'   => 1,
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

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message( $message, $attachments, [
			'color'   => '#2ecc71',
			'channel' => $channel,
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

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message( $message, $attachments, [
			'color'   => '#27ae60',
			'channel' => $channel,
		] );

	}


	/**
	 * Post notification when an administrator failed login was detected.
	 *
	 * @param $username
	 *
	 * @return bool
	 */
	public function administrator_failed_login( $username ) {

		// Get user by email or username.
		$field = ( - 1 === strpos( $username, '@' ) ) ? 'login' : 'email';
		$user  = get_user_by( $field, $username );

		if ( false === $user ) {
			return false;
		}

		if ( ! in_array( 'administrator', $user->roles ) ) {
			return false;
		}

		// Build notification
		$message = __( ':rotating_light: Administrator failed login detected on <%s|%s>.', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, get_bloginfo( 'url' ), get_bloginfo( 'name' ) );

		$attachments = [
			[
				'title' => esc_html__( 'Username', 'dorzki-notifications-to-slack' ),
				'value' => $username,
				'short' => true,
			],
			[
				'title' => esc_html__( 'Login IP', 'dorzki-notifications-to-slack' ),
				'value' => $this->get_user_ip(),
				'short' => true,
			],
		];

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message( $message, $attachments, [
			'color'   => '#e74c3c',
			'channel' => $channel,
		] );

	}

}
