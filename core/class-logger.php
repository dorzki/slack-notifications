<?php
/**
 * Logger class.
 *
 * @package     Slack_Notifications
 * @subpackage  Logger
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @version     2.0.3
 * @since       2.0.6
 */

namespace Slack_Notifications;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Logger
 *
 * @package SlackNotifications
 */
class Logger {

	/**
	 * Retrieve logger file path.
	 *
	 * @return string
	 */
	public static function get_file() {

		$hash = sha1( get_bloginfo( 'url' ) );

		return SLACK_NOTIFICATIONS_PATH . "logger-{$hash}.txt";

	}


	/**
	 * Retrieve logger file url.
	 *
	 * @return string
	 */
	public static function get_file_url() {

		$hash = sha1( get_bloginfo( 'url' ) );

		return SLACK_NOTIFICATIONS_PATH . "logger-{$hash}.txt";

	}


	/* ------------------------------------------ */


	/**
	 * Format error message.
	 *
	 * @param array $log Log data.
	 *
	 * @return bool|string
	 */
	private static function prepare_log( $log ) {

		if ( empty( $log ) || ! is_array( $log ) ) {
			return false;
		}

		$_raw = '===========================================================================' . PHP_EOL .
				'API ERROR' . PHP_EOL .
				'---------------------------------------------------------------------------' . PHP_EOL .
				'Error Time: ' . date( 'd-m-Y, H:i:s' ) . PHP_EOL .
				"Error Code: {$log['response_code']}" . PHP_EOL .
				"API Response: {$log['response_message']}" . PHP_EOL .
				'API Request: ' . wp_json_encode( $log['api_request'] ) . PHP_EOL .
				'===========================================================================' . PHP_EOL . PHP_EOL;

		return $_raw;

	}


	/* ------------------------------------------ */


	/**
	 * Log action to file.
	 *
	 * @param array $log Raw log content.
	 *
	 * @return bool
	 */
	public static function write( $log ) {

		if ( empty( $log ) || ! is_array( $log ) ) {
			return false;
		}

		// Open file.
		$fs = fopen( self::get_file(), 'a+' );

		if ( false === $fs ) {
			return false;
		}

		// Prepare and write.
		$log_data = self::prepare_log( $log );
		$written  = fwrite( $fs, $log_data );

		return ( false !== $written );

	}


	/**
	 * Retrieve error log file contents.
	 *
	 * @return bool|string
	 */
	public static function get_log_file_contents() {

		$file = self::get_file();

		if ( ! file_exists( $file ) ) {
			return false;
		}

		return file_get_contents( $file );

	}


	/**
	 * Removes the logs file.
	 *
	 * @return bool
	 */
	public static function clear_log_file() {

		$file = self::get_file();

		if ( ! file_exists( $file ) ) {
			return true;
		}

		return unlink( $file );

	}

}
