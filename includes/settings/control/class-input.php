<?php
/**
 * Settings -> Controls -> Input
 *
 * @package    dorzki\SlackNotifications\Settings\Control
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    1.0.0
 */

namespace dorzki\SlackNotifications\Settings\Control;

use dorzki\SlackNotifications\Base\Settings_Control;
use dorzki\SlackNotifications\Enum\Control_Type;

defined( 'ABSPATH' ) || exit;


/**
 * Class Input
 *
 * @package dorzki\SlackNotifications\Settings\Field
 */
class Input extends Settings_Control {
	/**
	 * @inheritDoc
	 */
	public function __construct( string $type, string $id, string $label ) {
		if ( ! Control_Type::is_input( $type ) ) {
			$type = Control_Type::TEXT;
		}

		parent::__construct( $type, $id, $label );
	}


	/**
	 * @inheritDoc
	 */
	public function render( array $args ) : void {
		$value = get_option( $this->get_id() );

		printf(
			'<input type="%1$s" id="%2$s" class="%3$s" name="%2$s" value="%4$s"/>',
			esc_attr( $this->get_type() ),
			esc_attr( $this->get_id() ),
			esc_attr( implode( ' ', $this->get_classes() ) ),
			esc_attr( $value )
		);
	}

	/**
	 * @inheritDoc
	 */
	public function get_classes() : array {
		return array_merge(
			parent::get_classes(),
			[ 'regular-text' ]
		);
	}
}
