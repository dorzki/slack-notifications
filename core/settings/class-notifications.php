<?php
/**
 * Notifications settings screen.
 *
 * @package     Slack_Notifications\Settings
 * @subpackage  Notifications
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.6
 */

namespace Slack_Notifications\Settings;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Notifications
 *
 * @package Slack_Notifications\Settings
 */
class Notifications extends Settings_Page {

	/**
	 * Notifications constructor.
	 */
	public function __construct() {

		$this->page_title    = __( 'Notifications', 'dorzki-notifications-to-slack' );
		$this->menu_title    = __( 'Notifications', 'dorzki-notifications-to-slack' );
		$this->page_slug     = 'notifications';
		$this->template_page = 'settings-notifications';
		$this->header_link   = [
			'label' => esc_html__( 'Add New', 'dorzki-notifications-to-slack' ),
			'link'  => '#new_notification',
		];

		parent::__construct();

	}

}
