<?php
/**
 * Blocks -> Footer
 *
 * @package    dorzki\SlackNotifications\Block
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
 * Class Footer
 *
 * @package dorzki\SlackNotifications\Block
 */
class Footer extends Block {
	/** @var Block_Text[] */
	protected $elements = [];


	/**
	 * Footer constructor.
	 */
	public function __construct() {
		$this->set_type( Block_Type::CONTEXT );
	}


	/**
	 * @inheritDoc
	 */
	public function jsonSerialize() : array {
		return [
			'type'     => $this->get_type(),
			'elements' => $this->get_elements(),
		];
	}


	/**
	 * @return Block_Text[]
	 */
	public function get_elements() : array {
		return $this->elements;
	}

	/**
	 * @param Block_Text[] $elements
	 *
	 * @return void
	 */
	public function set_elements( array $elements ) : void {
		$this->elements = $elements;
	}
}
