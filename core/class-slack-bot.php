<?php
/**
 * Slack Bot class.
 *
 * @package     Slack_Notifications
 * @subpackage  Slack_Bot
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.6
 */

namespace Slack_Notifications;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Slack_Bot
 *
 * @package Slack_Notifications
 */
class Slack_Bot {

	/**
	 * Slack_Bot instance.
	 *
	 * @var null|Slack_Bot
	 */
	private static $instance = null;
	/**
	 * Slack account webhook url.
	 *
	 * @var string
	 */
	private $webhook;
	/**
	 * Slack account channel name.
	 *
	 * @var string
	 */
	private $default_channel;
	/**
	 * Slack account bot name.
	 *
	 * @var string
	 */
	private $name;
	/**
	 * Slack account bot image.
	 *
	 * @var string
	 */
	private $image;


	/* ------------------------------------------ */

	/**
	 * Slack_Bot constructor.
	 */
	public function __construct() {

		$this->webhook         = get_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'webhook' );
		$this->default_channel = get_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'default_channel' );
		$this->name            = get_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'bot_name' );
		$this->image           = get_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'bot_image' );

	}


	/* ------------------------------------------ */

	/**
	 * Attempts to retrieve class instance, if doesn't exists, creates a new one.
	 *
	 * @return Slack_Bot
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Send the notification to slack.
	 *
	 * @param string $message     Notification text.
	 * @param array  $attachments Notification data attachments.
	 * @param array  $args        Notification arguments.
	 *
	 * @return bool
	 */
	public function send_message( $message, $attachments = [], $args = [] ) {

		if ( empty( $message ) ) {
			return false;
		}

		$notification = $this->build_notification( $message, $attachments, $args );
		$channels     = ( isset( $args['channel'] ) ) ? $this->parse_channels( $args['channel'] ) : $this->parse_channels( '' );

		foreach ( $channels as $channel ) {

			$notification['channel'] = $channel;

			// Make an API call.
			$api_call_data = apply_filters(
				'slack_before_api_call',
				[
					'method'      => 'POST',
					'timeout'     => 30,
					'httpversion' => '1.0',
					'blocking'    => true,
					'body'        => [
						'payload' => wp_json_encode( $notification ),
					],
				]
			);

			$response = wp_remote_request( $this->webhook, $api_call_data );

			// Check if we got an error.
			if ( is_wp_error( $response ) || 200 !== $response['response']['code'] ) {

				Logger::write(
					[
						'response_code'    => $response['response']['code'],
						'response_message' => $response['body'],
						'api_request'      => $notification,
					]
				);

				update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'test_integration', 0 );

				return false;

			}
		}

		update_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'test_integration', 1 );

		return true;

	}


	/* ------------------------------------------ */

	/**
	 * Parse message before sending it to slack.
	 *
	 * @param string $message     Notification text.
	 * @param array  $attachments Notification data attachments.
	 * @param array  $args        Notification arguments.
	 *
	 * @return mixed
	 */
	private function build_notification( $message, $attachments = [], $args = [] ) {

		$notification = [
			'username' => $this->name,
			'icon_url' => $this->image,
			'text'     => $message,
			'mrkdwn'   => true,
		];

		if ( ! empty( $attachments ) ) {

			if ( isset( $attachments['multiple'] ) && $attachments['multiple'] ) {

				unset( $attachments['multiple'] );

				foreach ( $attachments as $attachment_id => $attachment ) {

					$notification['attachments'][ $attachment_id ] = [
						'fallback' => ( isset( $args['plain_text'] ) ) ? $args['plain_text'] : $message,
						'color'    => ( isset( $args['color'] ) ) ? $args['color'] : '#000000',
						'fields'   => [],
					];

					foreach ( $attachment as $field ) {

						$notification['attachments'][ $attachment_id ]['fields'][] = [
							'title' => $field['title'],
							'value' => $field['value'],
							'short' => $field['short'],
						];

					}
				}
			} else {

				$notification['attachments'][0] = [
					'fallback' => ( isset( $args['plain_text'] ) ) ? $args['plain_text'] : $message,
					'color'    => ( isset( $args['color'] ) ) ? $args['color'] : '#000000',
					'fields'   => [],
				];

				foreach ( $attachments as $attachment ) {

					$notification['attachments'][0]['fields'][] = [
						'title' => $attachment['title'],
						'value' => $attachment['value'],
						'short' => $attachment['short'],
					];

				}
			}
		}

		return apply_filters( 'slack_after_notification_generation', $notification, $message, $attachments, $args );

	}


	/* ------------------------------------------ */

	/**
	 * Parse channel string.
	 *
	 * @param string $channel Notification channel(s).
	 *
	 * @return array
	 */
	private function parse_channels( $channel ) {

		if ( empty( $channel ) ) {
			$channels = explode( ',', $this->default_channel );
		} else {
			$channels = explode( ',', $channel );
		}

		return apply_filters( 'slack_after_parse_channels', $channels, $channel );

	}

}
