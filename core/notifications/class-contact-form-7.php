<?php
/**
 * Contact Form 7 notifications.
 *
 * @package     Slack_Notifications\Notifications
 * @subpackage  Contact_Form_7
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.7
 * @version     2.0.7
 */

namespace Slack_Notifications\Notifications;

use WPCF7_ContactForm;
use WPCF7_Submission;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Contact_Form_7
 *
 * @package Slack_Notifications\Notifications
 */
class Contact_Form_7 extends Notification_Type {

	/**
	 * Contact_Form_7 constructor.
	 */
	public function __construct() {

		$this->object_type = 'cf7';
		$this->object_label   = esc_html__( 'Contact Form 7', 'dorzki-notifications-to-slack' );
		$this->object_options = [
			'cf7_submit' => [
				'label'    => esc_html__( 'From Submission', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'wpcf7_before_send_mail' => 'form_submit',
				],
				'priority' => 10,
				'params'   => 1,
			],
		];

		parent::__construct();

	}


	/* ------------------------------------------ */


	/**
	 * Send notification when a user fills a form.
	 *
	 * @param WPCF7_ContactForm $cf7 Current contact form.
	 *
	 * @return bool
	 */
	public function form_submit( $cf7 ) {

		$submit = WPCF7_Submission::get_instance();
		$data   = $submit->get_posted_data();

		// Remove form irrelevant data.
		unset(
			$data['_wpcf7'],
			$data['_wpcf7_version'],
			$data['_wpcf7_locale'],
			$data['_wpcf7_unit_tag'],
			$data['_wpcf7_container_post']
		);

		// Build attachments.
		$attachments = [ 'multiple' => true ];

		// Form submitted data.
		foreach ( $data as $tag => $value ) {

			if ( empty( $value ) ) {
				continue;
			}

			$field_title = str_replace( [ 'your-', '-' ], [ '', ' ' ], $tag );
			$field_title = ucfirst( $field_title );

			$attachments[0][] = [
				'title' => $field_title,
				'value' => $value,
				'short' => false,
			];

		}

		// Form meta data.
		$date_format = sprintf( '%s, %s', get_option( 'date_format' ), get_option( 'time_format' ) );

		$attachments[] = [
			[
				'title' => esc_html__( 'IP Address', 'dorzki-notifications-to-slack' ),
				'value' => $submit->get_meta( 'remote_ip' ),
				'short' => true,
			],
			[
				'title' => esc_html__( 'Submit Time', 'dorzki-notifications-to-slack' ),
				'value' => date( $date_format, $submit->get_meta( 'timestamp' ) ),
				'short' => true,
			],
			[
				'title' => esc_html__( 'User Agent', 'dorzki-notifications-to-slack' ),
				'value' => $submit->get_meta( 'user_agent' ),
				'short' => false,
			],
		];

		// Build notification.
		/* translators: %1$s: Form Name, %2$s: Site URL, %3$s: Site Name */
		$message = __( ':incoming_envelope: *%1$s* was submitted on *<%2$s|%3$s>*!', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, $cf7->title(), get_bloginfo( 'url' ), get_bloginfo( 'name' ) );

		$channel = $this->get_notification_channel( __FUNCTION__ );

		return $this->slack_bot->send_message(
			$message,
			$attachments,
			[
				'color'   => '#f39c12',
				'channel' => $channel,
			]
		);

	}

}
