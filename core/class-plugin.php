<?php
/**
 * Plugin base class, declares plugin functionality and capabilities.
 *
 * @package     Slack_Notifications
 * @subpackage  Plugin
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.7
 */

namespace Slack_Notifications;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Plugin
 *
 * @package Slack_Notifications
 */
class Plugin {

	/**
	 * Plugin instance.
	 *
	 * @var null|Plugin
	 */
	public static $instance = null;

	/**
	 * Admin instance.
	 *
	 * @var null|Admin
	 */
	public $admin = null;


	/* ------------------------------------------ */


	/**
	 * Plugin constructor.
	 */
	public function __construct() {

		$this->load_classes();

		add_action( 'wp_loaded', [ $this, 'init_classes' ] );

	}


	/* ------------------------------------------ */


	/**
	 * Throws an error if trying to clone the plugin.
	 */
	public function __clone() {

		_doing_it_wrong(
			__FUNCTION__,
			esc_html__( 'Cheatin&#8217; huh?', 'dorzki-notifications-to-slack' ),
			'2.0.0'
		);

	}


	/**
	 * Throws an error if trying to unserialize the plugin.
	 */
	public function __wakeup() {

		_doing_it_wrong(
			__FUNCTION__,
			esc_html__( 'Cheatin&#8217; huh?', 'dorzki-notifications-to-slack' ),
			'2.0.0'
		);

	}


	/* ------------------------------------------ */


	/**
	 * Load plugins classes.
	 */
	private function load_classes() {

		do_action( 'slack_before_load_classes' );

		include_once 'notifications/class-notification-type.php';
		include_once 'notifications/class-system.php';
		include_once 'notifications/class-user.php';
		include_once 'notifications/class-post.php';
		include_once 'notifications/class-page.php';
		include_once 'notifications/class-comment.php';
		include_once 'notifications/class-cpt.php';
		include_once 'notifications/class-woocommerce.php';
		include_once 'notifications/class-contact-form-7.php';

		do_action( 'slack_after_load_notifications_classes' );

		include_once 'settings/class-field.php';
		include_once 'settings/class-settings-page.php';
		include_once 'settings/class-general.php';
		include_once 'settings/class-notifications.php';
		include_once 'settings/class-support.php';

		include_once 'class-logger.php';
		include_once 'class-slack-bot.php';
		include_once 'class-ajax.php';
		include_once 'class-admin.php';

		do_action( 'slack_after_load_classes' );

	}


	/**
	 * Initiate classes.
	 */
	public function init_classes() {

		do_action( 'slack_before_init_classes' );

		$this->admin = new Admin();

		new Notifications\System();
		new Notifications\User();
		new Notifications\Post();
		new Notifications\Page();
		new Notifications\Comment();
		new Notifications\CPT();
		new Notifications\WooCommerce();
		new Notifications\Contact_Form_7();

		new AJAX();

		do_action( 'slack_after_init_classes' );

	}


	/* ------------------------------------------ */


	/**
	 * Attempts to retrieve plugin's instance, if doesn't exists, creates a new one.
	 *
	 * @return Plugin
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

}

// Initiate the plugin.
Plugin::get_instance();
