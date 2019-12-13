<?php
/**
 * Notification type base class.
 *
 * @package     Slack_Notifications\Notifications
 * @subpackage  Notification_Type
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.6
 */

namespace Slack_Notifications\Notifications;

use Slack_Notifications\Slack_Bot;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Notification_Type
 *
 * @package Slack_Notifications\Notifications
 */
class Notification_Type {

	/**
	 * Database field name.
	 *
	 * @var string
	 */
	protected static $db_field;

	/**
	 * Object type.
	 *
	 * @var string
	 */
	protected $object_type;

	/**
	 * Object label.
	 *
	 * @var string
	 */
	protected $object_label;

	/**
	 * Object arguments.
	 *
	 * @var array
	 */
	protected $object_options = [];

	/**
	 * Slack_Bot instance.
	 *
	 * @var null|Slack_Bot
	 */
	protected $slack_bot = null;

	/**
	 * Notification channels.
	 *
	 * @var array
	 */
	protected $notif_channels = [];


	/* ------------------------------------------ */


	/**
	 * Notification_Type constructor.
	 */
	public function __construct() {

		self::$db_field = SLACK_NOTIFICATIONS_FIELD_PREFIX . 'notifications';

		$this->slack_bot = Slack_Bot::get_instance();

		$GLOBALS['slack_notifs'][ $this->object_type ] = [
			'label'   => $this->object_label,
			'options' => $this->object_options,
		];

		// Build notification_id => channel array.
		$notifications        = self::get_notifications();
		$this->notif_channels = [];

		if ( ! empty( $notifications ) ) {
			foreach ( $notifications as $notification ) {
				$this->notif_channels[ $notification->action ] = $notification->channel;
			}
		}

		$this->run_hooks();

	}


	/* ------------------------------------------ */


	/**
	 * Retrieve notifications from the database.
	 *
	 * @return array|mixed|object
	 */
	public static function get_notifications() {

		return json_decode( get_option( self::$db_field ) );

	}


	/**
	 * Hooks functions to actions.
	 *
	 * @return bool
	 */
	private function run_hooks() {

		$notifications = self::get_notifications();

		if ( ! is_array( $notifications ) || empty( $notifications ) ) {
			return false;
		}

		foreach ( $notifications as $notification ) {

			if ( isset( $this->object_options[ $notification->action ] ) ) {

				foreach ( $this->object_options[ $notification->action ]['hooks'] as $hook => $func ) {

					if ( ! method_exists( $this, $func ) ) {
						return false;
					}

					$priority = ( isset( $this->object_options[ $notification->action ]['priority'] ) ) ? $this->object_options[ $notification->action ]['priority'] : 10;
					$params   = ( isset( $this->object_options[ $notification->action ]['params'] ) ) ? $this->object_options[ $notification->action ]['params'] : 1;

					add_action( $hook, [ $this, $func ], $priority, $params );

				}
			}
		}

		return true;

	}


	/**
	 * Retrieve function channel.
	 *
	 * @param string $func_name Notification function.
	 *
	 * @return bool|mixed
	 */
	protected function get_notification_channel( $func_name ) {

		foreach ( $this->object_options as $notif_id => $notif_data ) {

			foreach ( $notif_data['hooks'] as $func ) {

				if ( $func === $func_name ) {
					return apply_filters( 'slack_notification_channel', $this->notif_channels[ $notif_id ] );
				}
			}
		}

		return false;

	}

}
