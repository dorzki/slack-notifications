<?php
/**
 * Plugins settings fields.
 *
 * @package     Slack_Notifications\Settings
 * @subpackage  Field
 * @author      Dor Zuberi <webmaster@dorzki.co.il>
 * @link        https://www.dorzki.co.il
 * @since       2.0.0
 * @version     2.0.6
 */

namespace Slack_Notifications\Settings;

// Block direct access to the file via url.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Field
 *
 * @package Slack_Notifications\Settings
 */
class Field {

	/**
	 * Text field slug.
	 *
	 * @var string
	 */
	const INPUT_TEXT = 'text';

	/**
	 * Media field slug.
	 *
	 * @var string
	 */
	const INPUT_MEDIA = 'media';

	/**
	 * Test integration field slug.
	 *
	 * @var string
	 */
	const INPUT_TEST = 'test_integration';


	/* ------------------------------------------ */


	/**
	 * Prints field HTML.
	 *
	 * @param array $args Field data.
	 */
	public static function output_field( $args ) {

		// Inject plugin classes.
		if ( ! isset( $args['classes'] ) ) {
			$args['classes'] = [];
		}

		$args['classes'][] = "field_type_{$args['type']}";

		switch ( $args['type'] ) {

			case self::INPUT_TEXT:
				$args['classes'][] = 'regular-text';

				self::input_field( $args );

				break;

			case self::INPUT_MEDIA:
				self::media_field( $args );
				break;

			case self::INPUT_TEST:
				self::test_integration_field( $args );
				break;

		}

	}


	/* ------------------------------------------ */


	/**
	 * Output input type field.
	 *
	 * @param array $args Field arguments.
	 */
	public static function input_field( $args ) {

		$value = get_option( $args['label_for'] );

		$html = "<input type='" . $args['type'] . "' class='" . implode( ' ', $args['classes'] ) . "' name='" . $args['label_for'] . "' value='" . $value . "'>";

		echo apply_filters( 'slack_before_output_input_field', $html );

	}


	/**
	 * Output media upload field.
	 *
	 * @param array $args Field arguments.
	 */
	public static function media_field( $args ) {

		$value     = get_option( $args['label_for'] );
		$has_image = ( ! empty( $value ) ) ? 'has_image' : '';

		$html  = "<div class='preview_{$args['label_for']} preview_image_box {$has_image}'>";
		$html .= "  <img src='{$value}' alt='" . esc_attr__( 'Image Preview', 'dorzki-notifications-to-slack' ) . "'>";
		$html .= "  <button type='button' class='remove-image'>" . esc_html__( 'Remove Image', 'dorzki-notifications-to-slack' ) . '</button>';
		$html .= '</div>';

		$html .= sprintf( "<input type='hidden' class='%s' name='%s' value='%s'>", implode( ' ', $args['classes'] ), $args['label_for'], $value );

		echo apply_filters( 'slack_before_output_media_field', $html );

	}


	/**
	 * Output integration testing button.
	 *
	 * @param array $args Field arguments.
	 */
	public static function test_integration_field( $args ) {

		$webhook_defined = get_option( SLACK_NOTIFICATIONS_FIELD_PREFIX . 'webhook' );
		$value           = get_option( $args['label_for'] );

		$disabled = ( ! $webhook_defined ) ? 'disabled' : '';

		$args['classes'][] = ( empty( $value ) ) ? 'error' : 'ok';

		printf( '<button type="button" class="slack_test_integration button %s" %s>%s</button>', implode( ' ', $args['classes'] ), $disabled, esc_html__( 'Run Test', 'dorzki-notifications-to-slack' ) );
		printf( "<input type='hidden' class='%s' name='%s' value='%s'>", implode( ' ', $args['classes'] ), $args['label_for'], $value );

	}

}
