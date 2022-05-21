<?php
/**
 * Blocks -> Accessories -> Button
 *
 * @package    dorzki\SlackNotifications\Block\Accessory
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications\Block\Accessory;

use dorzki\SlackNotifications\Base\Block_Accessory;
use dorzki\SlackNotifications\Base\Block_Text;
use dorzki\SlackNotifications\Enum\Accessory_Type;

defined( 'ABSPATH' ) || exit;


/**
 * Class Button_Accessory
 *
 * @package dorzki\SlackNotifications\Block\Accessory
 */
class Button_Accessory extends Block_Accessory {
	/** @var Block_Text|null */
	protected $text;
	/** @var string|null */
	protected $url;


	/**
	 * Button_Accessory constructor.
	 */
	public function __construct() {
		$this->set_type( Accessory_Type::BUTTON );
	}


	/**
	 * @inheritDoc
	 */
	public function jsonSerialize() : array {
		return [
			'type' => $this->get_type(),
			'text' => $this->get_text(),
			'url'  => $this->get_url(),
		];
	}


	/**
	 * @return Block_Text|null
	 */
	public function get_text() : ?Block_Text {
		return $this->text;
	}

	/**
	 * @param Block_Text|null $text
	 *
	 * @return void
	 */
	public function set_text( ?Block_Text $text ) : void {
		$this->text = $text;
	}

	/**
	 * @return string|null
	 */
	public function get_url() : ?string {
		return $this->url;
	}

	/**
	 * @param string|null $url
	 *
	 * @return void
	 */
	public function set_url( ?string $url ) : void {
		$this->url = $url;
	}
}
