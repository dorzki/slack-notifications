<?php
/**
 * General settings.
 *
 * @package     Slack_Notifications\Settings
 * @subpackage  General
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
 * Class General
 *
 * @package Slack_Notifications\Settings
 */
class General extends Settings_Page {

	/**
	 * General constructor.
	 */
	public function __construct() {

		$this->page_title    = __( 'General', 'dorzki-notifications-to-slack' );
		$this->menu_title    = __( 'General', 'dorzki-notifications-to-slack' );
		$this->page_slug     = 'general';
		$this->template_page = 'settings-general';

		parent::__construct();

	}


	/* ------------------------------------------ */


	/**
	 * Generate plugin's settings fields.
	 */
	public function generate_settings() {

		$this->settings = apply_filters(
			'slack_general_page_settings',
			[
				'integration' => [
					'title'  => __( 'Slack Integration', 'dorzki-notifications-to-slack' ),
					'desc'   => __( 'Setup integration between WordPress and Slack.' ),
					'fields' => [
						'webhook'          => [
							'label' => esc_html__( 'Webhook URL', 'dorzki-notifications-to-slack' ),
							'type'  => Field::INPUT_TEXT,
						],
						'default_channel'  => [
							'label' => esc_html__( 'Default Channel', 'dorzki-notifications-to-slack' ),
							'type'  => Field::INPUT_TEXT,
						],
						'bot_name'         => [
							'label' => esc_html__( 'Bot Name', 'dorzki-notifications-to-slack' ),
							'type'  => Field::INPUT_TEXT,
						],
						'bot_image'        => [
							'label' => esc_html__( 'Bot Image', 'dorzki-notifications-to-slack' ),
							'type'  => Field::INPUT_MEDIA,
						],
						'test_integration' => [
							'label' => esc_html__( 'Test Integration', 'dorzki-notifications-to-slack' ),
							'type'  => Field::INPUT_TEST,
						],
					],
				],
			]
		);

	}

}
