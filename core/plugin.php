<?php
/**
 * Plugin base class, declares plugin functionality and capabilities.
 *
 * @package     SlackNotifications
 * @subpackage  Plugin
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.3
 */

namespace SlackNotifications;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Plugin
 *
 * @package SlackNotifications
 */
class Plugin {

	/**
	 * @var null|Plugin
	 */
	public static $instance = null;

	/**
	 * @var null|Admin
	 */
	public $admin = null;


	/**
	 * Plugin constructor.
	 */
	public function __construct() {

		$this->load_classes();

		add_action( 'wp_loaded', [ $this, 'init_classes' ] );

	}


	/**
	 * Throws an error if trying to clone the plugin.
	 */
	public function __clone() {

		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'dorzki-notifications-to-slack' ), '2.0.0' );

	}


	/**
	 * Throws an error if trying to unserialize the plugin.
	 */
	public function __wakeup() {

		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'dorzki-notifications-to-slack' ), '2.0.0' );

	}


	/**
	 * Load plugins classes.
	 */
	private function load_classes() {

		do_action( 'slack_before_load_classes' );

		include_once( SN_PATH . 'core/notifications/notification-type.php' );
		include_once( SN_PATH . 'core/notifications/system.php' );
		include_once( SN_PATH . 'core/notifications/user.php' );
		include_once( SN_PATH . 'core/notifications/post.php' );
		include_once( SN_PATH . 'core/notifications/page.php' );
		include_once( SN_PATH . 'core/notifications/comment.php' );
		include_once( SN_PATH . 'core/notifications/cpt.php' );
		include_once( SN_PATH . 'core/notifications/woocommerce.php' );
		include_once( SN_PATH . 'core/notifications/cf7.php' );
		

		do_action( 'slack_after_load_notifications_classes' );

		include_once( SN_PATH . 'core/settings/field.php' );
		include_once( SN_PATH . 'core/settings/settings-page.php' );
		include_once( SN_PATH . 'core/settings/general.php' );
		include_once( SN_PATH . 'core/settings/notifications.php' );
		include_once( SN_PATH . 'core/settings/support.php' );

		include_once( SN_PATH . 'core/logger.php' );
		include_once( SN_PATH . 'core/slack-bot.php' );
		include_once( SN_PATH . 'core/ajax.php' );
		include_once( SN_PATH . 'core/admin.php' );

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
		new Notifications\Cf7();
		new AJAX();

		do_action( 'slack_after_init_classes' );

	}


	/**
	 * Attempts to retrieve plugin's instance, if doesn't exists, creates a new one.
	 *
	 * @return null|Plugin
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
