<?php
/**
 * Plugins settings.
 *
 * @package     Slack_Notifications\Settings
 * @subpackage  Settings_Page
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
 * Class Settings_Page
 *
 * @package Slack_Notifications\Settings
 */
class Settings_Page {

	/**
	 * Settings page title.
	 *
	 * @var string
	 */
	protected $page_title;

	/**
	 * Settings page menu title.
	 *
	 * @var string
	 */
	protected $menu_title;

	/**
	 * Settings page template file.
	 *
	 * @var string
	 */
	protected $template_page;

	/**
	 * Settings page slug.
	 *
	 * @var string
	 */
	protected $page_slug;

	/**
	 * Settings page header button link.
	 *
	 * @var array
	 */
	protected $header_link = [];

	/**
	 * Settings page arguments.
	 *
	 * @var array
	 */
	protected $settings = [];


	/* ------------------------------------------ */


	/**
	 * Settings_Page constructor.
	 */
	public function __construct() {

		add_action( 'admin_menu', [ $this, 'register_page' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );

		$this->generate_settings();

	}


	/* ------------------------------------------ */


	/**
	 * Registers the current settings page.
	 */
	public function register_page() {

		do_action( 'slack_before_page_register', $this );
		do_action( 'slack_before_' . $this->page_slug . '_page_register', $this );

		add_submenu_page(
			SLACK_NOTIFICATIONS_SLUG,
			$this->page_title,
			$this->menu_title,
			'manage_options',
			SLACK_NOTIFICATIONS_SLUG . '-' . $this->page_slug,
			[
				$this,
				'print_settings_page',
			]
		);

		do_action( 'slack_after_page_register', $this );
		do_action( 'slack_after_' . $this->page_slug . '_page_register', $this );

	}


	/**
	 * Prints the plugins settings page HTML.
	 */
	public function print_settings_page() {

		// Check if the current user allowed to access this page.
		if ( ! current_user_can( 'manage_options' ) ) {

			$notice = esc_html__( 'Oops... it\'s seems like you don\'t have the permission to access this page.', 'dorzki-notifications-to-slack' );

			wp_die( wp_kses_post( "<div class='error'><p>{$notice}</p></div>" ) );

		}

		do_action( 'slack_before_page_output', $this );
		do_action( 'slack_before_' . $this->page_slug . '_page_output', $this );

		include_once SLACK_NOTIFICATIONS_PATH . 'templates/settings-header.php';
		include_once SLACK_NOTIFICATIONS_PATH . "templates/{$this->template_page}.php";
		include_once SLACK_NOTIFICATIONS_PATH . 'templates/settings-footer.php';

		do_action( 'slack_after_page_output', $this );
		do_action( 'slack_after_' . $this->page_slug . '_page_output', $this );

	}


	/**
	 * Register plugin settings fields.
	 */
	public function register_settings() {

		// Declare sections.
		foreach ( $this->settings as $section_id => $section ) {

			add_settings_section(
				$section_id,
				$section['title'],
				[
					$this,
					'section_callback',
				],
				SLACK_NOTIFICATIONS_SLUG
			);

			// Declare fields.
			foreach ( $section['fields'] as $field_id => $field ) {

				register_setting( SLACK_NOTIFICATIONS_SLUG, SLACK_NOTIFICATIONS_FIELD_PREFIX . $field_id );

				add_settings_field(
					SLACK_NOTIFICATIONS_FIELD_PREFIX . $field_id,
					$field['label'],
					'\Slack_Notifications\Settings\Field::output_field',
					SLACK_NOTIFICATIONS_SLUG,
					$section_id,
					[
						'label_for' => SLACK_NOTIFICATIONS_FIELD_PREFIX . $field_id,
						'type'      => $field['type'],
						'options'   => ( isset( $field['options'] ) ) ? $field['options'] : null,
					]
				);

			}
		}

	}


	/**
	 * Prints section description if exists.
	 *
	 * @param array $args Section arguments.
	 */
	public function section_callback( $args ) {

		if ( ! isset( $this->settings[ $args['id'] ]['desc'] ) ) {
			return;
		}

		if ( empty( $this->settings[ $args['id'] ]['desc'] ) ) {
			return;
		}

		do_action( 'slack_before_section_output', $args );
		do_action( 'slack_before_' . $this->page_slug . '_section_output', $args );

		$html = sprintf( "<p id='%s'>%s</p>", $args['id'], $this->settings[ $args['id'] ]['desc'] );

		echo apply_filters( 'slack_section_output', $html );

		do_action( 'slack_after_section_output', $args );
		do_action( 'slack_after_' . $this->page_slug . '_section_output', $args );

	}


	/**
	 * Generate plugin's settings fields.
	 */
	protected function generate_settings() {

		$this->settings = [];

	}

}
