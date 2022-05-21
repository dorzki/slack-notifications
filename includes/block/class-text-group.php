<?php
/**
 * Blocks -> Text Group
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
 * Class Text_Group
 *
 * @package dorzki\SlackNotifications\Block
 */
class Text_Group extends Block {
	/** @var Block_Text[] */
	protected $fields = [];


	/**
	 * Text_Group constructor.
	 */
	public function __construct() {
		$this->set_type( Block_Type::SECTION );
	}


	/**
	 * @inheritDoc
	 */
	public function jsonSerialize() : array {
		return [
			'type'   => $this->get_type(),
			'fields' => $this->get_fields(),
		];
	}


	/**
	 * @return Block_Text[]
	 */
	public function get_fields() : array {
		return $this->fields;
	}

	/**
	 * @param Block_Text[] $fields
	 *
	 * @return void
	 */
	public function set_fields( array $fields ) : void {
		$this->fields = $fields;
	}
}
