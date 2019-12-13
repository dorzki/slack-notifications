<?php
/**
 * Support settings screen.
 *
 * @package     Slack_Notifications\Settings
 * @subpackage  Support
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.3
 * @version     2.0.6
 */

namespace Slack_Notifications\Settings;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Support
 *
 * @package Slack_Notifications\Settings
 */
class Support extends Settings_Page {

	/**
	 * Support constructor.
	 */
	public function __construct() {

		$this->page_title    = __( 'Support', 'dorzki-notifications-to-slack' );
		$this->menu_title    = __( 'Support', 'dorzki-notifications-to-slack' );
		$this->page_slug     = 'support';
		$this->template_page = 'settings-support';

		parent::__construct();

	}


	/* ------------------------------------------ */

	/**
	 * Build a technical report.
	 *
	 * @return string
	 */
	public static function build_report() {

		global $wpdb;

		// Get technical data.
		$wordpress = get_bloginfo( 'version' );
		$server    = ( ! empty( $_SERVER['SERVER_SOFTWARE'] ) ) ? sanitize_textarea_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';
		$php       = phpversion();
		$mysql     = $wpdb->db_version();
		$curl      = ( function_exists( 'curl_version' ) ) ? curl_version() : [];
		$curl      = ( isset( $curl['version'] ) ) ? $curl['version'] : 'NULL';

		$theme   = self::get_active_theme_data();
		$plugins = self::get_plugins_versions();

		// Built report data.
		$plugins_report = '';

		foreach ( $plugins as $plugin ) {
			$plugins_report .= sprintf( '* **[%s](%s)**: %s%s', $plugin['name'], $plugin['plugin_url'], $plugin['version'], PHP_EOL );
		}

		$data = '`' . PHP_EOL .
				'# ' . esc_html__( 'System', 'dorzki-notifications-to-slack' ) . PHP_EOL .
				'* **' . esc_html__( 'WordPress Version', 'dorzki-notifications-to-slack' ) . '**: ' . $wordpress . PHP_EOL .
				'* **' . esc_html__( 'Server Software', 'dorzki-notifications-to-slack' ) . '**: ' . $server . PHP_EOL .
				'* **' . esc_html__( 'PHP Version', 'dorzki-notifications-to-slack' ) . '**: ' . $php . PHP_EOL .
				'* **' . esc_html__( 'MySQL Version', 'dorzki-notifications-to-slack' ) . '**: ' . $mysql . PHP_EOL .
				'* **' . esc_html__( 'cURL Version', 'dorzki-notifications-to-slack' ) . '**: ' . $curl . PHP_EOL .
				PHP_EOL .
				'# ' . esc_html__( 'Active Theme', 'dorzki-notifications-to-slack' ) . PHP_EOL .
				'* **' . esc_html__( 'Name', 'dorzki-notifications-to-slack' ) . '**: ' . $theme['name'] . PHP_EOL .
				'* **' . esc_html__( 'Version', 'dorzki-notifications-to-slack' ) . '**: ' . $theme['version'] . PHP_EOL .
				'* **' . esc_html__( 'Theme URI', 'dorzki-notifications-to-slack' ) . '**: ' . $theme['theme_url'] . PHP_EOL .
				PHP_EOL .
				'# ' . esc_html__( 'Active Plugins', 'dorzki-notifications-to-slack' ) . PHP_EOL .
				$plugins_report .
				'`';

		return $data;

	}

	/**
	 * Retrieve active theme data.
	 *
	 * @return array
	 */
	private static function get_active_theme_data() {

		$active_theme = wp_get_theme();

		return [
			'name'      => $active_theme->get( 'Name' ),
			'version'   => $active_theme->get( 'Version' ),
			'theme_url' => $active_theme->get( 'ThemeURI' ),
		];

	}


	/* ------------------------------------------ */

	/**
	 * Retrieve active plugins data.
	 *
	 * @return array
	 */
	private static function get_plugins_versions() {

		// Get active plugins.
		$plugins      = get_option( 'active_plugins' );
		$plugins_data = [];

		foreach ( $plugins as $plugin ) {

			$plugin_meta = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );

			$plugins_data[] = [
				'name'       => $plugin_meta['Name'],
				'version'    => $plugin_meta['Version'],
				'plugin_url' => $plugin_meta['PluginURI'],
			];

		}

		return $plugins_data;

	}

}
