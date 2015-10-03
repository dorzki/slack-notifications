<?php
/**
 * SLACK BOT CLASS
 */
if( !class_exists( slackBot ) ) {

  class slackBot {

    /**
     * Slack Webhook Endpoint
     */
    private $apiEndpoint;



    /**
     * Slack Channel
     */
    private $slackChannel;



    /**
     * Slack Name
     */
    private $botName;



    /**
     * Slack Image
     */
    private $botIcon;



    /**
     * Get slack bot details.
     */
    public function __construct() {

      $this->apiEndpoint  = get_option( 'slack_webhook_endpoint' );
      $this->slackChannel = get_option( 'slack_channel_name' );
      $this->botName      = ( get_option( 'slack_bot_username' ) == '' ) ? 'Slack Bot' : get_option( 'slack_bot_username' );
      $this->botIcon      = ( get_option( 'slack_bot_image' ) == '' ) ? PLUGIN_ROOT_URL . 'assets/images/default-bot-icon.png' : get_option( 'slack_bot_image' );

    }



    /**
     * Send the notification thought the API.
     * @param  string   $theMessage   the notification to send.
     */
    public function sendMessage( $theMessage ) {

      $apiResponse = wp_remote_post( $this->apiEndpoint, array(
        'method'      => 'POST',
        'timeout'     => 30,
        'httpversion' => '1.0',
        'blocking'    => true,
        'headers'     => array(),
        'body'        => array(
          'payload'   => json_encode( array(
            'channel'  => $this->slackChannel,
            'username' => $this->botName,
            'icon_url' => $this->botIcon,
            'text'     => $theMessage
            ) )
          ),
        ) );

    }

  }

}