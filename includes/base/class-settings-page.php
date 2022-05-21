<?php
/**
 * Base -> Settings Page
 *
 * @package    dorzki\SlackNotifications\Base
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications\Base;

use dorzki\SlackNotifications\Plugin;
use dorzki\SlackNotifications\Settings\Control\Section;
use InvalidArgumentException;

defined( 'ABSPATH' ) || exit;


/**
 * Class Settings_Page
 *
 * @package dorzki\SlackNotifications\Base
 */
abstract class Settings_Page {
	const FIELD_PREFIX = 'dsn_';


	/** @var string */
	protected $slug;
	/** @var string */
	protected $title;
	/** @var string */
	protected $template;
	/** @var Section[] */
	protected $settings = [];
	/** @var string[] */
	protected $page_action = [];


	/**
	 * Settings_Page constructor.
	 *
	 * @param string $slug  Page slug.
	 * @param string $title Page title.
	 */
	public function __construct( string $slug, string $title, string $template ) {
		if ( empty( $slug ) || empty( $title ) || empty( $template ) ) {
			throw new InvalidArgumentException( 'Settings page details are invalid.' );
		}

		$this->slug     = $this->generate_slug( $slug );
		$this->title    = $title;
		$this->template = $template;

		add_submenu_page(
			Plugin::SLUG,
			$this->title,
			$this->title,
			'manage_options',
			$this->slug,
			[ $this, 'render' ]
		);

		$this->register_settings();

		add_action( 'admin_init', [ $this, 'init' ] );
	}


	/**
	 * Render page contents.
	 *
	 * @return void
	 *
	 * @since 2.1.0
	 */
	public function render() : void {
		if ( ! current_user_can( 'manage_options' ) ) {
			$notice = esc_html__( 'Oops... it\'s seems like you don\'t have the permission to access this page.', 'dorzki-notifications-to-slack' );

			wp_die( wp_kses_post( "<div class='error'><p>{$notice}</p></div>" ) );
		}

		include_once DSN_TEMPLATES_PATH . 'settings/header.php';
		include_once $this->template;
		include_once DSN_TEMPLATES_PATH . 'settings/footer.php';
	}

	/**
	 * Register page settings.
	 *
	 * @return void
	 *
	 * @since 2.1.0
	 */
	public function register_settings() : void {
	}

	/**
	 * Register page setting fields.
	 *
	 * @return void
	 *
	 * @since 2.1.0
	 */
	public function init() : void {
		if ( empty( $this->settings ) ) {
			return;
		}

		foreach ( $this->settings as $section ) {
			add_settings_section(
				$section->get_id(),
				$section->get_label(),
				[ $section, 'render' ],
				Plugin::SLUG
			);

			foreach ( $section->get_options() as $option ) {
				register_setting( Plugin::SLUG, $option->get_id() );

				add_settings_field(
					$option->get_id(),
					$option->get_label(),
					[ $option, 'render' ],
					Plugin::SLUG,
					$section->get_id(),
					$option->get_data()
				);
			}
		}
	}


	/**
	 * Generate page slug.
	 *
	 * @param string $slug Page slug.
	 *
	 * @return string
	 *
	 * @since 2.1.0
	 */
	protected function generate_slug( string $slug ) : string {
		return strpos( $slug, Plugin::SLUG ) !== 0 ? Plugin::SLUG . "-{$slug}" : $slug;
	}


	/**
	 * @return string
	 */
	public function get_slug() : string {
		return $this->slug;
	}

	/**
	 * @return string
	 */
	public function get_title() : string {
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function get_template() : string {
		return $this->template;
	}
}
