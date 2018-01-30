<?php
/**
 * Notification type base class.
 *
 * @package     SlackNotifications\Notifications
 * @subpackage  Notification_Type
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.0
 */

namespace SlackNotifications\Notifications;

use SlackNotifications\Slack_Bot as Slack_Bot;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Notification_Type
 *
 * @package SlackNotifications\Notifications
 */
class Notification_Type {

	/**
	 * @var string
	 */
	protected $object_type;

	/**
	 * @var string
	 */
	protected $object_label;

	/**
	 * @var array
	 */
	protected $object_options = [];

	/**
	 * @var null|Slack_Bot
	 */
	protected $slack_bot = null;


	/**
	 * Notification_Type constructor.
	 */
	public function __construct() {

		$this->slack_bot = Slack_Bot::get_instance();

		$GLOBALS[ 'slack_notifs' ][ $this->object_type ] = [
			'label'   => $this->object_label,
			'options' => $this->object_options,
		];

		$this->run_hooks();

	}


	/**
	 * Hooks functions to actions.
	 *
	 * @return bool
	 */
	private function run_hooks() {

		$notifications = json_decode( get_option( SN_FIELD_PREFIX . 'notifications' ) );

		if ( ! is_array( $notifications ) || empty( $notifications ) ) {
			return false;
		}

		foreach ( $notifications as $notification ) {

			if ( isset( $this->object_options[ $notification->action ] ) ) {

				foreach ( $this->object_options[ $notification->action ][ 'hooks' ] as $hook => $func ) {

					if ( ! method_exists( $this, $func ) ) {
						return false;
					}

					$priority = ( isset( $this->object_options[ $notification->action ][ 'priority' ] ) ) ? $this->object_options[ $notification->action ][ 'priority' ] : 10;
					$params   = ( isset( $this->object_options[ $notification->action ][ 'params' ] ) ) ? $this->object_options[ $notification->action ][ 'params' ] : 1;

					add_action( $hook, [ $this, $func, ], $priority, $params );

				}

			}

		}

		return true;

	}

}