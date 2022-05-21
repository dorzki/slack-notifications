<?php
/**
 * Blocks -> Image Text
 *
 * @package    dorzki\SlackNotifications\Block
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications\Block;

use dorzki\SlackNotifications\Base\Block;
use dorzki\SlackNotifications\Base\Block_Text;
use dorzki\SlackNotifications\Block\Accessory\Image_Accessory;
use dorzki\SlackNotifications\Enum\Block_Type;

defined( 'ABSPATH' ) || exit;


/**
 * Class Image_Text
 *
 * @package dorzki\SlackNotifications\Block
 */
class Image_Text extends Block {
	/** @var Block_Text */
	protected $text;
	/** @var Image_Accessory */
	protected $accessory;


	/**
	 * Image_Text constructor.
	 */
	public function __construct() {
		$this->set_type( Block_Type::SECTION );
		$this->set_accessory( new Image_Accessory() );
	}


	/**
	 * @inheritDoc
	 */
	public function jsonSerialize() : array {
		return [
			'type'      => $this->get_type(),
			'text'      => $this->get_text(),
			'accessory' => $this->get_accessory(),
		];
	}


	/**
	 * @return Block_Text
	 */
	public function get_text() : Block_Text {
		return $this->text;
	}

	/**
	 * @param Block_Text $text
	 *
	 * @return void
	 */
	public function set_text( Block_Text $text ) : void {
		$this->text = $text;
	}

	/**
	 * @return Image_Accessory
	 */
	public function get_accessory() : Image_Accessory {
		return $this->accessory;
	}

	/**
	 * @param Image_Accessory $accessory
	 *
	 * @return void
	 */
	public function set_accessory( Image_Accessory $accessory ) : void {
		$this->accessory = $accessory;
	}
}
