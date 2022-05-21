<?php
/**
 * Blocks -> Image
 *
 * @package    dorzki\SlackNotifications\Block
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications\Block;

use dorzki\SlackNotifications\Base\Block;
use dorzki\SlackNotifications\Enum\Block_Type;

defined( 'ABSPATH' ) || exit;


/**
 * Class Image
 *
 * @package dorzki\SlackNotifications\Block
 */
class Image extends Block {
	/** @var string|null */
	protected $image_url;
	/** @var string|null */
	protected $alt_text;


	/**
	 * Image_Accessory constructor.
	 */
	public function __construct() {
		$this->set_type( Block_Type::IMAGE );
	}


	/**
	 * @inheritDoc
	 */
	public function jsonSerialize() : array {
		return [
			'type'      => $this->get_type(),
			'image_url' => $this->get_image_url(),
			'alt_text'  => $this->get_alt_text(),
		];
	}


	/**
	 * @return string|null
	 */
	public function get_image_url() : ?string {
		return $this->image_url;
	}

	/**
	 * @param string|null $image_url
	 *
	 * @return void
	 */
	public function set_image_url( ?string $image_url ) : void {
		$this->image_url = $image_url;
	}

	/**
	 * @return string|null
	 */
	public function get_alt_text() : ?string {
		return $this->alt_text;
	}

	/**
	 * @param string|null $alt_text
	 *
	 * @return void
	 */
	public function set_alt_text( ?string $alt_text ) : void {
		$this->alt_text = $alt_text;
	}
}
