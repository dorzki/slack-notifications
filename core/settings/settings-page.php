<?php
/**
 * Plugins settings.
 *
 * @package     SlackNotifications\Settings
 * @subpackage  Settings_Page
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.0
 */

namespace SlackNotifications\Settings;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Settings_Page
 *
 * @package SlackNotifications\Settings
 */
class Settings_Page {

	/**
	 * @var string
	 */
	protected $page_title;

	/**
	 * @var string
	 */
	protected $menu_title;

	/**
	 * @var string
	 */
	protected $template_page;

	/**
	 * @var string
	 */
	protected $page_slug;

	/**
	 * @var array
	 */
	protected $header_link = [];

	/**
	 * @var array
	 */
	protected $settings = [];


	/**
	 * Settings_Page constructor.
	 */
	public function __construct() {

		add_action( 'admin_menu', [ $this, 'register_page' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );

		$this->generate_settings();

	}


	/**
	 * Registers the current settings page.
	 */
	public function register_page() {

		add_submenu_page( SN_SLUG, $this->page_title, $this->menu_title, 'manage_options', SN_SLUG . '-' . $this->page_slug, [
			$this,
			'print_settings_page',
		] );

	}


	/**
	 * Prints the plugins settings page HTML.
	 */
	public function print_settings_page() {

		// Check if the current user allowed to access this page.
		if ( ! current_user_can( 'manage_options' ) ) {

			$notice = esc_html__( 'Oops... it\'s seems like you don\'t have the permission to access this page.', 'dorzki-notifications-to-slack' );

			wp_die( "<div class='error'><p>{$notice}</p></div>" );

		}

		include_once( SN_PATH . 'templates/settings-header.php' );
		include_once( SN_PATH . "templates/{$this->template_page}.php" );
		include_once( SN_PATH . 'templates/settings-footer.php' );

	}


	/**
	 * Register plugin settings fields.
	 */
	public function register_settings() {

		// Declare sections
		foreach ( $this->settings as $section_id => $section ) {

			add_settings_section( $section_id, $section[ 'title' ], [
				$this,
				'section_callback',
			], SN_SLUG );

			// Declare fields
			foreach ( $section[ 'fields' ] as $field_id => $field ) {

				register_setting( SN_SLUG, SN_FIELD_PREFIX . $field_id );

				add_settings_field( SN_FIELD_PREFIX . $field_id, $field[ 'label' ], '\SlackNotifications\Settings\Field::output_field', SN_SLUG, $section_id, [
					'label_for' => SN_FIELD_PREFIX . $field_id,
					'type'      => $field[ 'type' ],
					'options'   => ( isset( $field[ 'options' ] ) ) ? $field[ 'options' ] : null,
				] );

			}

		}

	}


	/**
	 * Prints section description if exists.
	 *
	 * @param $args
	 */
	public function section_callback( $args ) {

		if ( ! isset( $this->settings[ $args[ 'id' ] ][ 'desc' ] ) ) {
			return;
		}

		if ( empty( $this->settings[ $args[ 'id' ] ][ 'desc' ] ) ) {
			return;
		}

		printf( "<p id='%s'>%s</p>", $args[ 'id' ], $this->settings[ $args[ 'id' ] ][ 'desc' ] );

	}


	/**
	 * Generate plugin's settings fields.
	 */
	protected function generate_settings() {

		$this->settings = [];

	}

}