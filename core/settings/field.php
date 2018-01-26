<?php
/**
 * Plugins settings fields.
 *
 * @package     SlackNotifications
 * @subpackage  Field
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.0
 */

namespace SlackNotifications;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Field
 *
 * @package SlackNotifications
 */
class Field {

	/**
	 * Field types
	 */
	const INPUT_TEXT = 'text';
	const INPUT_MEDIA = 'media';


	/**
	 * Prints field HTML.
	 *
	 * @param $args
	 */
	public static function output_field( $args ) {

		echo "<pre>";
		var_dump( $args );
		echo "</pre>";

	}

}