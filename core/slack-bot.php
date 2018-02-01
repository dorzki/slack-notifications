<?php
/**
 * Slack Bot class.
 *
 * @package     SlackNotifications
 * @subpackage  Slack_Bot
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.0
 */

namespace SlackNotifications;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Slack_Bot
 *
 * @package SlackNotifications
 */
class Slack_Bot {

	/**
	 * @var string
	 */
	private $webhook;

	/**
	 * @var string
	 */
	private $default_channel;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $image;

	/**
	 * @var null|Slack_Bot
	 */
	private static $instance = null;


	/**
	 * Slack_Bot constructor.
	 */
	public function __construct() {

		$this->webhook         = get_option( SN_FIELD_PREFIX . 'webhook' );
		$this->default_channel = get_option( SN_FIELD_PREFIX . 'default_channel' );
		$this->name            = get_option( SN_FIELD_PREFIX . 'bot_name' );
		$this->image           = get_option( SN_FIELD_PREFIX . 'bot_image' );

	}


	/**
	 * Parse message before sending it to slack.
	 *
	 * @param       $message
	 * @param array $attachments
	 * @param array $args
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

			if ( isset( $attachments[ 'multiple' ] ) && $attachments[ 'multiple' ] ) {

				unset( $attachments[ 'multiple' ] );

				foreach ( $attachments as $attachment_id => $attachment ) {

					$notification[ 'attachments' ][ $attachment_id ] = [
						'fallback' => ( isset( $args[ 'plain_text' ] ) ) ? $args[ 'plain_text' ] : $message,
						'color'    => ( isset( $args[ 'color' ] ) ) ? $args[ 'color' ] : '#000000',
						'fields'   => [],
					];

					foreach ( $attachment as $field ) {

						$notification[ 'attachments' ][ $attachment_id ][ 'fields' ][] = [
							'title' => $field[ 'title' ],
							'value' => $field[ 'value' ],
							'short' => $field[ 'short' ],
						];

					}

				}

			} else {

				$notification[ 'attachments' ][ 0 ] = [
					'fallback' => ( isset( $args[ 'plain_text' ] ) ) ? $args[ 'plain_text' ] : $message,
					'color'    => ( isset( $args[ 'color' ] ) ) ? $args[ 'color' ] : '#000000',
					'fields'   => [],
				];

				foreach ( $attachments as $attachment ) {

					$notification[ 'attachments' ][ 0 ][ 'fields' ][] = [
						'title' => $attachment[ 'title' ],
						'value' => $attachment[ 'value' ],
						'short' => $attachment[ 'short' ],
					];

				}

			}

		}

		return $notification;

	}


	/**
	 * Parse channel string.
	 *
	 * @param $channel
	 *
	 * @return array
	 */
	private function parse_channels( $channel ) {

		if ( empty( $channel ) ) {
			return explode( ',', $this->default_channel );
		}

		return explode( ',', $channel );

	}


	/**
	 * Send the notification to slack.
	 *
	 * @param       $message
	 * @param array $attachments
	 * @param array $args
	 *
	 * @return bool
	 */
	public function send_message( $message, $attachments = [], $args = [] ) {

		if ( empty( $message ) ) {
			return false;
		}

		$notification = $this->build_notification( $message, $attachments, $args );
		$channels     = ( isset( $args[ 'channel' ] ) ) ? $this->parse_channels( $args[ 'channel' ] ) : $this->parse_channels( '' );

		foreach ( $channels as $channel ) {

			$notification[ 'channel' ] = $channel;

			// Make an API call.
			$response = wp_remote_request( $this->webhook, [
				'method'      => 'POST',
				'timeout'     => 30,
				'httpversion' => '1.0',
				'blocking'    => true,
				'body'        => [
					'payload' => wp_json_encode( $notification ),
				],
			] );

			// Check if everything is ok.
			if ( is_wp_error( $response ) ) {
				update_option( SN_FIELD_PREFIX . 'test_integration', 0 );
			}

		}

		update_option( SN_FIELD_PREFIX . 'test_integration', 1 );

		return true;

	}


	/**
	 * Attempts to retrieve class instance, if doesn't exists, creates a new one.
	 *
	 * @return null|Slack_Bot
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

}