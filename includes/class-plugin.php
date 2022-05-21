<?php
/**
 * Plugin
 *
 * @package    dorzki\SlackNotifications\Enum
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications;

defined( 'ABSPATH' ) || exit;


/**
 * Class Plugin
 *
 * @package dorzki\SlackNotifications
 */
final class Plugin {
	const VERSION = '2.1.0';
	const SLUG    = 'slack-notifications';


	/** @var Plugin */
	private static $instance;

	/** @var Admin */
	private $admin;
	/** @var Editor */
	private $editor;


	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		$this->autoload();

		$this->admin  = new Admin();
		$this->editor = new Editor();
	}


	/**
	 * Initiate autoloader.
	 *
	 * @return void
	 *
	 * @since 2.1.0
	 */
	private function autoload() : void {
		require_once DSN_PATH . 'includes/class-autoloader.php';

		Autoloader::init();
	}


	/**
	 * Retrieve plugin's instance.
	 *
	 * @return Plugin
	 *
	 * @since 2.1.0
	 */
	public static function get_instance() : Plugin {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * @return Admin
	 */
	public function get_admin() : Admin {
		return $this->admin;
	}

	/**
	 * @return Editor
	 */
	public function get_editor() : Editor {
		return $this->editor;
	}
}

// Init plugin.
Plugin::get_instance();
