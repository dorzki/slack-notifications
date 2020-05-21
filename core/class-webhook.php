<?php
/**
 * Webhook class.
 *
 * @package     Slack_Notifications
 * @subpackage  Webhook
 * @author      Yoavi Matchulsky <y@yoavi.codes>
 * @link        https://yoavi.codes
 * @since       2.1.0
 * @version     2.1.0
 */

namespace Slack_Notifications;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Webhook
 *
 * @package Slack_Notifications
 */
class Webhook {

	/**
	 * Database field name.
	 *
	 * @var string
	 */
	protected static $db_field;

	/* ------------------------------------------ */


	/**
	 * Notification_Type constructor.
	 */
	public function __construct() {

		self::$db_field = SLACK_NOTIFICATIONS_FIELD_PREFIX . 'webhooks';

		$webhooks = self::get_webhooks();
		$GLOBALS['slack_webhooks'] = $webhooks or [];

	}


	/* ------------------------------------------ */


	/**
	 * Retrieve webhooks from the database.
	 *
	 * @return array|mixed|object
	 */
	public static function get_webhooks() {

		return json_decode( get_option( self::$db_field ) );

	}

	/**
	 * Retrieve webhooks from the database.
	 *
	 * @return array|mixed|object
	 */
	public static function get_webhook( $webhook_id ) {

		$webhooks = self::get_webhooks();

		foreach ( $webhooks as $webhook ) {
			if ( $webhook->id === $webhook_id ) {
				return $webhook;
			}
		}

		return false;

	}

	public static function save_webhooks( $post_data ) {

		$webhooks = [];

		foreach ( $post_data['id'] as $index => $webhook_id ) {

			$title = $post_data['title'][$index];
			$url   = $post_data['url'][$index];

			if ( empty( $url ) ) {
				continue;
			}

			if ( empty( $title ) ) {
				$title = __( 'New Webhook', 'dorzki-notifications-to-slack' );
			}

			// Saving a new webhook with a random id
			if ( empty( $webhook_id ) ) {
				$webhook_id = self::random_id();
			}

			$webhooks[] = [
				'id'    => $webhook_id,
				'title' => $title,
				'url'   => $url,
			];

		}

		return update_option( self::$db_field, json_encode( $webhooks ) );

	}

	public static function random_id() {

		if ( version_compare( PHP_VERSION, '7' ) >= 0 ) {
			return bin2hex(random_bytes(16));
		}
		else {
			return uniqid();
		}

	}
}
