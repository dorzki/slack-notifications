<?php
/**
 * Block Accessory
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
 * Class Block_Accessory
 *
 * @package dorzki\SlackNotifications\Base
 */
abstract class Block_Accessory implements JsonSerializable {
	/** @var string */
	protected $type;


	/**
	 * Retrieve properties to be serialized.
	 *
	 * @return array
	 */
	public function jsonSerialize() : array {
		return [
			'type'      => $this->get_type(),
			'text'      => $this->get_text(),
			'url'       => $this->get_url(),
			'image_url' => $this->get_image_url(),
			'alt_text'  => $this->get_alt_text(),
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
	 *
	 * @return void
	 */
	public function set_type( string $type ) : void {
		$this->type = $type;
	}
}
