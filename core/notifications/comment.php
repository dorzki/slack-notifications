<?php
/**
 * Comment notifications.
 *
 * @package     SlackNotifications\Notifications
 * @subpackage  Comment
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
 * Class Comment
 *
 * @package SlackNotifications\Notifications
 */
class Comment extends Notification_Type {

	/**
	 * Comment constructor.
	 */
	public function __construct() {

		$this->object_type    = 'comment';
		$this->object_label   = esc_html__( 'Comment', 'dorzki-notifications-to-slack' );
		$this->object_options = [
			'new_comment' => [
				'label'  => esc_html__( 'New Comment', 'dorzki-notifications-to-slack' ),
				'hooks'  => [
					'comment_post' => 'new_comment',
				],
				'priority' => 10,
				'params' => 2,
			],
		];

		parent::__construct();

	}

}