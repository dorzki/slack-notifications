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
	 * Notification_Type constructor.
	 */
	public function __construct() {

		$GLOBALS[ 'slack_notifs' ][] = [
			'id'      => $this->object_type,
			'label'   => $this->object_label,
			'options' => $this->object_options,
		];

	}

}