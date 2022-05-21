<?php
/**
 * Base -> Block Text
 *
 * @package    dorzki\SlackNotifications\Enum
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications\Base;

use JsonSerializable;

defined( 'ABSPATH' ) || exit;


/**
 * Class Block_Text
 *
 * @package dorzki\SlackNotifications\Base
 */
abstract class Block_Text implements JsonSerializable {
	/** @var string */
	protected $type;
	/** @var string */
	protected $text;
	/** @var bool */
	protected $emoji;


	/**
	 * Retrieve properties to be serialized.
	 *
	 * @return array
	 */
	public function jsonSerialize() : array {
		return [
			'type'  => $this->get_type(),
			'text'  => $this->get_text(),
			'emoji' => $this->is_emoji(),
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

	/**
	 * @return string
	 */
	public function get_text() : string {
		return $this->text;
	}

	/**
	 * @param string $text
	 *
	 * @return void
	 */
	public function set_text( string $text ) : void {
		$this->text = $text;
	}

	/**
	 * @return bool
	 */
	public function is_emoji() : bool {
		return $this->emoji;
	}

	/**
	 * @param bool $emoji
	 *
	 * @return void
	 */
	public function set_emoji( bool $emoji ) : void {
		$this->emoji = $emoji;
	}
}
