<?php
/**
 * Page notifications.
 *
 * @package     SlackNotifications\Notifications
 * @subpackage  Page
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
 * Class Page
 *
 * @package SlackNotifications\Notifications
 */
class Page extends Notification_Type {

	/**
	 * Page constructor.
	 */
	public function __construct() {

		$this->object_type    = 'page';
		$this->object_label   = esc_html__( 'Pages', 'dorzki-notifications-to-slack' );
		$this->object_options = [
			'new_page'     => [
				'label'    => esc_html__( 'Page Published', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'auto-draft_to_publish' => 'page_published',
					'draft_to_publish'      => 'page_published',
					'future_to_publish'     => 'page_published',
					'pending_to_publish'    => 'page_published',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'future_page'  => [
				'label'    => esc_html__( 'Page Scheduled', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'auto-draft_to_future' => 'page_scheduled',
					'draft_to_future'      => 'page_scheduled',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'pending_page' => [
				'label'    => esc_html__( 'Page Pending', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'auto-draft_to_pending' => 'page_pending',
					'draft_to_pending'      => 'page_pending',
				],
				'priority' => 10,
				'params'   => 1,
			],
			'update_page'  => [
				'label'    => esc_html__( 'Page Updated', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'publish_to_publish' => 'page_updated',
				],
				'priority' => 10,
				'params'   => 1,
			],
		];

		parent::__construct();

	}

}