<?php
/**
 * Plugin
 *
 * @package   dorzki\SlackNotifications
 * @author    Dor Zuberi <admin@dorzki.io>
 * @copyright 2022 dorzki
 * @version   1.0.0
 */

namespace dorzki\SlackNotifications;

defined( 'ABSPATH' ) || exit;


/**
 * Class Plugin
 *
 * @package dorzki\SlackNotifications
 */
final class Plugin {
	/** @var Plugin */
	private static $instance;

	/** @var Editor */
	private $editor;


	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		$this->autoload();

		$this->set_editor( new Editor() );
	}


	/**
	 * Initiate autoloader.
	 *
	 * @return void
	 *
	 * @since 1.0.0
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
	 * @since 1.0.0
	 */
	public static function get_instance() : Plugin {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * @return Editor
	 */
	public function get_editor() : Editor {
		return $this->editor;
	}

	/**
	 * @param Editor $editor
	 *
	 * @return void
	 */
	public function set_editor( Editor $editor ) : void {
		$this->editor = $editor;
	}
}

// Init plugin.
Plugin::get_instance();
