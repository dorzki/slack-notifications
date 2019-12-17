<?php
/**
 * Page notifications.
 *
 * @package     Slack_Notifications\Notifications
 * @subpackage  Page
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.6
 */

namespace Slack_Notifications\Notifications;

use WP_Post;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Page
 *
 * @package Slack_Notifications\Notifications
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
			'trash_page'   => [
				'label'    => esc_html__( 'Page Moved to Trash', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'trashed_post' => 'page_trashed',
				],
				'priority' => 10,
				'params'   => 1,
			],
		];

		parent::__construct();

	}


	/* ------------------------------------------ */


	/**
	 * Post notification when a new page has been posted.
	 *
	 * @param WP_Post $page Post object.
	 *
	 * @return bool
	 */
	public function page_published( $page ) {

		if ( empty( $page ) || ! is_object( $page ) ) {
			return false;
		}

		if ( 'page' !== $page->post_type ) {
			return false;
		}

		// Build notification.
		/* translators: %1$s: Post URL, %2$s: Post Name */
		$message = __( ':memo: The page *<%1$s|%2$s>* was published right now!', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, get_permalink( $page->ID ), $page->post_title );

		$attachments = [
			[
				'title' => esc_html__( 'Page Author', 'dorzki-notifications-to-slack' ),
				'value' => get_the_author_meta( 'display_name', $page->post_author ),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Published Date', 'dorzki-notifications-to-slack' ),
				'value' => get_the_date( null, $page->ID ),
				'short' => true,
			],
		];

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message(
			$message,
			$attachments,
			[
				'color'   => '#3498db',
				'channel' => $channel,
			]
		);

	}


	/**
	 * Post notification when a page is scheduled to be published.
	 *
	 * @param WP_Post $page Post object.
	 *
	 * @return bool
	 */
	public function page_scheduled( $page ) {

		if ( empty( $page ) || ! is_object( $page ) ) {
			return false;
		}

		if ( 'page' !== $page->post_type ) {
			return false;
		}

		// Build notification.
		/* translators: %1$s: Post URL, %2$s: Post Name, $3$s: Date */
		$message = __( ':clock3: The page *<%1$s|%2$s>* was scheduled to be published on *%3$s*.', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, get_permalink( $page->ID ), $page->post_title, get_the_date( null, $page->ID ) );

		$attachments = [
			[
				'title' => esc_html__( 'Page Author', 'dorzki-notifications-to-slack' ),
				'value' => get_the_author_meta( 'display_name', $page->post_author ),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Scheduled Date', 'dorzki-notifications-to-slack' ),
				'value' => get_the_date( null, $page->ID ),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Scheduled Time', 'dorzki-notifications-to-slack' ),
				'value' => get_the_time( null, $page->ID ),
				'short' => true,
			],
		];

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message(
			$message,
			$attachments,
			[
				'color'   => '#2980b9',
				'channel' => $channel,
			]
		);

	}


	/**
	 * Post notification when a page is pending approval.
	 *
	 * @param WP_Post $page Post object.
	 *
	 * @return bool
	 */
	public function page_pending( $page ) {

		if ( empty( $page ) || ! is_object( $page ) ) {
			return false;
		}

		if ( 'page' !== $page->post_type ) {
			return false;
		}

		// Build notification.
		/* translators: %1$s: Post URL, %2$s: Post Name */
		$message = __( ':eye: The page *<%1$s|%2$s>* is pending approval.', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, get_permalink( $page->ID ), $page->post_title );

		$attachments = [
			[
				'title' => esc_html__( 'Page Author', 'dorzki-notifications-to-slack' ),
				'value' => get_the_author_meta( 'display_name', $page->post_author ),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Pending Date', 'dorzki-notifications-to-slack' ),
				'value' => get_the_date( null, $page->ID ),
				'short' => true,
			],
		];

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message(
			$message,
			$attachments,
			[
				'color'   => '#2980b9',
				'channel' => $channel,
			]
		);

	}


	/**
	 * Post notification when a page was updated.
	 *
	 * @param WP_Post $page Post object.
	 *
	 * @return bool
	 */
	public function page_updated( $page ) {

		if ( empty( $page ) || ! is_object( $page ) ) {
			return false;
		}

		if ( 'page' !== $page->post_type ) {
			return false;
		}

		$user_id = ( isset( $_POST['user_ID'] ) ) ? intval( $_POST['user_ID'] ) : $page->post_author;
		$user    = get_user_by( 'id', $user_id );

		// Build notification.
		/* translators: %1$s: Post URL, %2$s: Post Name */
		$message = __( ':pencil2: The page *<%1$s|%2$s>* has been updated right now.', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, get_permalink( $page->ID ), $page->post_title );

		$attachments = [
			[
				'title' => esc_html__( 'Updated By', 'dorzki-notifications-to-slack' ),
				'value' => $user->display_name,
				'short' => true,
			],
			[
				'title' => esc_html__( 'Update Date', 'dorzki-notifications-to-slack' ),
				'value' => get_the_modified_date( null, $page->ID ),
				'short' => true,
			],
		];

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message(
			$message,
			$attachments,
			[
				'color'   => '#2980b9',
				'channel' => $channel,
			]
		);

	}


	/**
	 * Post notification when a page was trashed.
	 *
	 * @param int $page_id Post ID.
	 *
	 * @return bool
	 */
	public function page_trashed( $page_id ) {

		// Get page.
		$page = get_post( $page_id );

		if ( is_wp_error( $page ) ) {
			return false;
		}

		if ( 'page' !== $page->post_type ) {
			return false;
		}

		// Build notification.
		/* translators: %1$s: Post URL, %2$s: Post Name */
		$message = __( ':wastebasket: The page *<%1$s|%2$s>* was moved to trash.', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, get_permalink( $page->ID ), $page->post_title );

		$attachments = [
			[
				'title' => esc_html__( 'Page Author', 'dorzki-notifications-to-slack' ),
				'value' => get_the_author_meta( 'display_name', $page->post_author ),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Trashed Date', 'dorzki-notifications-to-slack' ),
				'value' => get_the_modified_date( null, $page->ID ),
				'short' => true,
			],
		];

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message(
			$message,
			$attachments,
			[
				'color'   => '#e74c3c',
				'channel' => $channel,
			]
		);

	}

}
