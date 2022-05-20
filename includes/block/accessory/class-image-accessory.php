<?php
/**
 * Image Accessory
 *
 * @package    dorzki\SlackNotifications\Block\Accessory
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    1.0.0
 */

namespace dorzki\SlackNotifications\Block\Accessory;

use dorzki\SlackNotifications\Base\Block_Accessory;
use dorzki\SlackNotifications\Enum\Accessory_Type;

defined( 'ABSPATH' ) || exit;


/**
 * Class Image_Accessory
 *
 * @package dorzki\SlackNotifications\Block\Accessory
 */
class Image_Accessory extends Block_Accessory {
	/** @var string|null */
	protected $image_url;
	/** @var string|null */
	protected $alt_text;


	/**
	 * Image_Accessory constructor.
	 */
	public function __construct() {
		$this->set_type( Accessory_Type::IMAGE );
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
