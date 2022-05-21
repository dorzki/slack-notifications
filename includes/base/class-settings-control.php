<?php
/**
 * Base -> Settings Control
 *
 * @package    dorzki\SlackNotifications\Base
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications\Base;

use dorzki\SlackNotifications\Enum\Control_Type;
use InvalidArgumentException;

defined( 'ABSPATH' ) || exit;


/**
 * Class Settings_Control
 *
 * @package dorzki\SlackNotifications\Base
 */
abstract class Settings_Control {
	/** @var string */
	protected $type;
	/** @var string */
	protected $id;
	/** @var string */
	protected $label;


	/**
	 * Settings_Control constructor.
	 *
	 * @param string $type  Control type.
	 * @param string $id    Control id.
	 * @param string $label Control label.
	 */
	public function __construct( string $type, string $id, string $label ) {
		if ( empty( $type ) || empty( $id ) || empty( $label ) ) {
			throw new InvalidArgumentException( 'Control values are invalid.' );
		}

		$this->type  = $type;
		$this->id    = $id;
		$this->label = $label;
	}


	/**
	 * Render control html.
	 *
	 * @param array $args
	 *
	 * @return void
	 *
	 * @since 2.1.0
	 */
	public function render( array $args ) : void {
	}


	/**
	 * Get control additional data.
	 *
	 * @return array
	 *
	 * @since 2.1.0
	 */
	public function get_data() : array {
		return [
			'type' => $this->get_type(),
		];
	}

	/**
	 * Get control CSS classes.
	 *
	 * @return string[]
	 *
	 * @since 2.1.0
	 */
	public function get_classes() : array {
		return [ "control-type-{$this->get_type()}" ];
	}


	/**
	 * @return string
	 */
	public function get_type() : string {
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function get_id() : string {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function get_label() : string {
		return $this->label;
	}
}
