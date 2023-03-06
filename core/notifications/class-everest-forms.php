<?php
/**
 * Everest Forms notifications.
 *
 * @package     Slack_Notifications\Notifications
 * @subpackage  Everest_Forms
 * @author      Tomasz Sienicki <info@kortel.systems>
 * @link        https://kortel.systems
 * @since       2.0.8
 * @version     2.0.8
 */

namespace Slack_Notifications\Notifications;

use WPCF7_ContactForm;
use WPCF7_Submission;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Everest_Forms
 *
 * @package Slack_Notifications\Notifications
 */
class Everest_Forms extends Notification_Type {

	/**
	 * Everest_Forms constructor.
	 */
	public function __construct() {

		$this->object_type = 'evf';
		$this->object_label   = esc_html__( 'Everest Forms', 'dorzki-notifications-to-slack' );
		$this->object_options = [
			'evf_submit' => [
				'label'    => esc_html__( 'From Submission', 'dorzki-notifications-to-slack' ),
				'hooks'    => [
					'everest_forms_process_complete' => 'form_submit',
				],
				'priority' => 10,
				'params'   => 4,
			],
		];

		parent::__construct();

	}


	/* ------------------------------------------ */


	/**
	 * Send notification when a user fills a form from EVF_Form_Task
	 *
     * @param $this->form_fields
     * @param $entry
     * @param $this->form_data
     * @param $entry_id
	 *
	 * @return bool
	 */
	public function form_submit( $form_fields, $entry, $form_data, $entry_id ) {

        error_log(
            sprintf( 'New Form [%s] [%s] [%s] [%s]',
                json_encode( $form_fields ),
                json_encode( $entry ),
                json_encode( $form_data ),
                json_encode( $entry_id ),
            )
        );

		// Build attachments.
		$attachments = [ 'multiple' => true ];

		// Form submitted data.
        foreach ( $form_fields as $meta_key => $meta_value ) {
            switch ($meta_value['type']) {
                case 'first-name':
                case 'last-name':
                case 'name':
                case 'email':
                    $attachments[0][] = [
                        'title' => $meta_value['name'],
                        'value' => $meta_value['value'],
                        'short' => true,
                    ];
                    break;

                default:
                    break;
            }
        }

		// Build notification.
		/* translators: %1$s: Form Name, %2$s: Site URL, %3$s: Site Name */
		$message = __( ':incoming_envelope: *%1$s* was submitted on *<%2$s|%3$s>*!', 'dorzki-notifications-to-slack' );
		$message = sprintf( $message, $entry_id,
            admin_url( 'admin.php?page=evf-entries&form_id=' . $entry['id'] . '&view-entry=' . $entry_id ),
            get_bloginfo( 'name' ) );

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
