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

		// Inject plugin classes
		if ( ! isset( $args[ 'classes' ] ) ) {
			$args[ 'classes' ] = [];
		}

		$args[ 'classes' ][] = "field_type_{$args['type']}";
		$args[ 'classes' ][] = 'regular-text';

		switch ( $args[ 'type' ] ) {

			case self::INPUT_TEXT:
				self::input_field( $args );
				break;

			case self::INPUT_MEDIA:
				self::media_field( $args );
				break;

		}

	}


	/**
	 * Output input type field.
	 *
	 * @param $args
	 */
	public static function input_field( $args ) {

		$value = get_option( $args[ 'label_for' ] );

		printf( "<input type='%s' class='%s' name='%s' value='%s'>", $args[ 'type' ], implode( ' ', $args[ 'classes' ] ), $args[ 'label_for' ], $value );

	}


	/**
	 * Output media upload field.
	 *
	 * @param $args
	 */
	public static function media_field( $args ) {

		$value     = get_option( $args[ 'label_for' ] );
		$has_image = ( ! empty( $value ) ) ? 'has_image' : '';

		echo "<div class='preview_{$args['label_for']} preview_image_box {$has_image}'>";
		echo "  <img src='{$value}' alt='" . esc_attr__( 'Image Preview', 'dorzki-notifications-to-slack' ) . "'>";
		echo "  <button type='button' class='remove-image'>" . esc_html__( 'Remove Image', 'dorzki-notifications-to-slack' ) . "</button>";
		echo "</div>";

		printf( "<input type='hidden' class='%s' name='%s' value='%s'>", implode( ' ', $args[ 'classes' ] ), $args[ 'label_for' ], $value );

	}

}