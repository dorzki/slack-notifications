<?php
/**
 * Blocks -> Divider
 *
 * @package    dorzki\SlackNotifications\Enum
 * @author     Dor Zuberi <admin@dorzki.io>
 * @copyright  2022 dorzki
 * @version    2.1.0
 */

namespace dorzki\SlackNotifications\Block;

use dorzki\SlackNotifications\Base\Block;
use dorzki\SlackNotifications\Enum\Block_Type;

defined( 'ABSPATH' ) || exit;


/**
 * Class Divider
 *
 * @package dorzki\SlackNotifications\Block
 */
class Divider extends Block {
	/**
	 * Divider constructor.
	 */
	public function __construct() {
		$this->set_type( Block_Type::DIVIDER );
	}
}
