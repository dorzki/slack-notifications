<?php
/**
 * Webhooks settings screen.
 *
 * @package     Slack_Notifications\Webhooks
 * @subpackage  Webhooks
 * @author      Yoavi Matchulsky <y@yoavi.codes>
 * @link        https://yoavi.codes
 * @since       2.1.0
 * @version     2.1.0
 */

namespace Slack_Notifications\Settings;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Webhooks
 *
 * @package Slack_Notifications\Webhooks
 */
class Webhooks extends Settings_Page {

	/**
	 * Webhooks constructor.
	 */
	public function __construct() {

		$this->page_title    = __( 'Webhooks', 'dorzki-notifications-to-slack' );
		$this->menu_title    = __( 'Webhooks', 'dorzki-notifications-to-slack' );
		$this->page_slug     = 'webhooks';
		$this->template_page = 'settings-webhooks';
		$this->header_link   = [
			'label' => esc_html__( 'Add New', 'dorzki-notifications-to-slack' ),
			'link'  => '#new_webhook',
		];

		parent::__construct();

	}

}
