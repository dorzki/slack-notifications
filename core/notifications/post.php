<?php
/**
 * Post notifications.
 *
 * @package     SlackNotifications\Notifications
 * @subpackage  Post
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
 * Class Post
 *
 * @package SlackNotifications\Notifications
 */
class Post extends Notification_Type {

	/**
	 * Post constructor.
	 */
	public function __construct() {

		$this->object_type    = 'post';
		$this->object_label   = esc_html__( 'Posts', 'dorzki-notifications-to-slack' );
		$this->object_options = [
			'new_post'     => [
				'label'    => esc_html__( 'Post Published', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'auto-draft_to_publish' => 'post_published',
					'draft_to_publish'      => 'post_published',
					'future_to_publish'     => 'post_published',
					'pending_to_publish'    => 'post_published',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'future_post'  => [
				'label'    => esc_html__( 'Post Scheduled', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'auto-draft_to_future' => 'post_scheduled',
					'draft_to_future'      => 'post_scheduled',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'pending_post' => [
				'label'    => esc_html__( 'Post Pending', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'auto-draft_to_pending' => 'post_pending',
					'draft_to_pending'      => 'post_pending',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'update_post'  => [
				'label'    => esc_html__( 'Post Updated', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'publish_to_publish' => 'post_updated',
				],
				'priority' => 10,
				'params'   => 1,
			],
		];

		parent::__construct();

	}

}