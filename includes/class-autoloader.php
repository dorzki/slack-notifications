<?php
/**
 * Autoloader
 *
 * @package   dorzki\SlackNotifications
 * @author    Dor Zuberi <admin@dorzki.io>
 * @copyright 2022 dorzki
 * @version   1.0.0
 */

namespace dorzki\SlackNotifications;

defined( 'ABSPATH' ) || exit;


/**
 * Class Autoloader
 *
 * @package dorzki\SlackNotifications
 */
class Autoloader {
	const DOMAIN = 'dorzki\SlackNotifications';


	/**
	 * Autoloader constructor.
	 */
	public function __construct() {
		spl_autoload_register( [ $this, 'autoload' ] );
	}


	/**
	 * Autoload a class by its namespace.
	 *
	 * @param string $class Class namespace and name.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function autoload( string $class ) : void {
		if ( false === strpos( $class, self::DOMAIN ) ) {
			return;
		}

		$class = substr( $class, strlen( self::DOMAIN ) + 1 );

		$namespace_parts = explode( '\\', $class );

		$file_name = array_pop( $namespace_parts );

		$file_name = "class-{$file_name}.php";
		$file_path = implode( DIRECTORY_SEPARATOR, $namespace_parts ) . $file_name;
		$file_path = str_replace( '_', '-', strtolower( $file_path ) );
		$file_path = DSN_PATH . "includes/{$file_path}";

		if ( is_file( $file_path ) ) {
			require_once $file_path;
		}
	}


	/**
	 * Init autoloader.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public static function init() : Autoloader {
		return new self();
	}
}
