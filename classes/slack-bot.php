<?php
/**
 * Slack Bot Class.
 *
 * @package   Slack Notifications
 * @since     1.0.0
 * @version   1.0.4
 * @author    Dor Zuberi <me@dorzki.co.il>
 * @link      https://www.dorzki.co.il
 */

if ( ! class_exists( 'SlackBot' ) ) {

	/**
	 * Class SlackBot
	 */
	class SlackBot {

		/**
		 * Slack Webhook Endpoint
		 *
		 * @var 	  string
		 * @since   1.0.0
		 */
		private $apiEndpoint;



		/**
		 * Slack Channel
		 *
		 * @var 	  string
		 * @since   1.0.0
		 */
		private $slackChannel;



		/**
		 * Slack Name
		 *
		 * @var 	  string
		 * @since   1.0.0
		 */
		private $botName;



		/**
		 * Slack Image
		 *
		 * @var 	  string
		 * @since   1.0.0
		 */
		private $botIcon;



		/**
		 * Get slack bot details.
		 *
		 * @since   1.0.0
		 */
		public function __construct() {

			$this->apiEndpoint  = get_option( 'slack_webhook_endpoint' );
			$this->slackChannel = get_option( 'slack_channel_name' );
			$this->botName      = ( get_option( 'slack_bot_username' ) === '' ) ? 'Slack Bot' : get_option( 'slack_bot_username' );
			$this->botIcon      = ( get_option( 'slack_bot_image' ) === '' ) ? PLUGIN_ROOT_URL . 'assets/images/default-bot-icon.png' : get_option( 'slack_bot_image' );

		}



		/**
		 * Send the notification thought the API.
		 *
		 * @param   string    $theMessage   the notification to send.
		 * @return  boolean                 did the message sent successfully?
		 * @since   1.0.0
		 */
		public function send_message( $theMessage ) {

			$apiResponse = wp_remote_post( $this->apiEndpoint, array(
				'method'      => 'POST',
				'timeout'     => 30,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'body'        => array(
				'payload'   => wp_json_encode( array(
					'channel'  => $this->slackChannel,
					'username' => $this->botName,
					'icon_url' => $this->botIcon,
					'text'     => sprintf( '%s @ *<%s|%s>*', $theMessage, get_bloginfo( 'home' ), get_bloginfo( 'name' ) ),
				) ),
				),
			) );

			// Check if there is an error.
			if( is_wp_error( $apiResponse ) ) {

				$this->display_send_error();

				return false;

			}

			return true;

		}



		/**
		 * Set the plugin to show an error.
		 * 
		 * @since 1.0.5
		 */
		private function display_send_error() {

			update_option( 'slack_notice_connectivity', 1 );

		}

	}

}
