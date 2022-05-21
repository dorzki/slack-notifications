<?php
/**
 * Settings -> Controls -> Button
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
 * Class Button
 *
 * @package dorzki\SlackNotifications\Settings\Control
 */
class Button extends Settings_Control {
	/** @var string */
	protected $button_text;


	/**
	 * @inheritDoc
	 */
	public function __construct( string $type, string $id, string $label, string $button_text ) {
		if ( ! Control_Type::is_button( $type ) ) {
			$type = Control_Type::BUTTON;
		}

		parent::__construct( $type, $id, $label );

		$this->button_text = $button_text;
	}


	/**
	 * @inheritDoc
	 */
	public function render( array $args ) : void {
		printf(
			'<button type="%1$s" id="%2$s" class="%3$s" name="%2$s">%4$s</button>',
			esc_attr( $this->get_type() ),
			esc_attr( $this->get_id() ),
			esc_attr( implode( ' ', $this->get_classes() ) ),
			esc_html( $args['button_text'] )
		);
	}

	/**
	 * @inheritDoc
	 */
	public function get_data() : array {
		return array_merge(
			parent::get_data(),
			[
				'button_text' => $this->get_button_text(),
			]
		);
	}

	/**
	 * @inheritDoc
	 */
	public function get_classes() : array {
		return array_merge(
			parent::get_classes(),
			[
				'button',
				'button-secondary',
			]
		);
	}


	/**
	 * @return string
	 */
	public function get_button_text() : string {
		return $this->button_text;
	}
}
