<?php
/**
 * Block
 *
 * @package   dorzki\SlackNotifications\Base
 * @author    Dor Zuberi <admin@dorzki.io>
 * @copyright 2022 dorzki
 * @version   1.0.0
 */

namespace dorzki\SlackNotifications\Base;

use JsonSerializable;

defined( 'ABSPATH' ) || exit;


/**
 * Class Block
 *
 * @package dorzki\SlackNotifications\Base
 */
abstract class Block implements JsonSerializable {
	/** @var string */
	protected $type;


	/**
	 * Retrieve properties to be serialized.
	 *
	 * @return array
	 */
	public function jsonSerialize() : array {
		return [
			'type' => $this->get_type(),
		];
	}


	/**
	 * @return string
	 */
	public function get_type() : string {
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function set_type( string $type ) : void {
		$this->type = $type;
	}
}
