<?php
/**
 * AJAX handling class.
 *
 * @package     SlackNotifications
 * @subpackage  AJAX
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
 * Class AJAX
 *
 * @package Slack_Notifications
 */
class AJAX {

	/**
	 * AJAX constructor.
	 */
	public function __construct() {

		add_action( 'wp_ajax_slack-test-integration', [ $this, 'slack_test_integration' ] );
		add_action( 'wp_ajax_slack-clear-logs', [ $this, 'slack_clear_logs' ] );

	}


	/* ------------------------------------------ */


	/**
	 * Test integration with slack.
	 */
	public function slack_test_integration() {

		$bot = Slack_Bot::get_instance();

		$message = __( ':pizza: Mmmmmmm.... Pizzzzzzzzzzzzzzzzzzzzzzza!!!', 'dorzki-notifications-to-slack' );

		$sent = $bot->send_message( $message );

		return ( $sent ) ? wp_send_json_success() : wp_send_json_error();

	}


	/**
	 * Removes logs file.
	 */
	public function slack_clear_logs() {

		return ( Logger::clear_log_file() ) ? wp_send_json_success() : wp_send_json_error();

	}

}
