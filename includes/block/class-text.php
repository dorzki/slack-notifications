<?php
/**
 * Blocks -> Text
 *
 * @package    dorzki\SlackNotifications\Enum
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications\Block;

use dorzki\SlackNotifications\Base\Block;
use dorzki\SlackNotifications\Base\Block_Text;
use dorzki\SlackNotifications\Enum\Block_Type;

defined( 'ABSPATH' ) || exit;


/**
 * Class Text
 *
 * @package dorzki\SlackNotifications\Block
 */
class Text extends Block {
	/** @var Block_Text */
	protected $text;


	/**
	 * Text constructor.
	 */
	public function __construct() {
		$this->set_type( Block_Type::SECTION );
	}


	/**
	 * @inheritDoc
	 */
	public function jsonSerialize() : array {
		return [
			'type' => $this->get_type(),
			'text' => $this->get_text(),
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
}
